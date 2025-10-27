<?php

namespace App\Services\ParseApi;

use App\Models\Stock;
use App\Jobs\StockJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Account;


class StockParseService extends BaseParseService
{
    protected string $modelClass = Stock::class;
    protected string  $jobClass = StockJob::class;

    public function __construct(Account $account)
    {
        parent::__construct($account);
        $this->url = $this->apiUrl . 'stocks';
    }

     public function parse()
    {
        $this->consoleOutput->writeln('Start parsing ' . $this->modelClass);

        $lastRecord = $this->modelClass::orderByDesc('date')->first();
        
        $dateFrom = $lastRecord->date ?? date('Y-m-d');

        Log::info('Parse from {dateFrom} to {dateTo}', ['dateFrom' => $dateFrom]);
        $this->consoleOutput->writeln("Parse from {$dateFrom}");

        $query = [
            'dateFrom' => $dateFrom,
            'page' => $this->pageStart,
            'key' => $this->key,
            'limit' => $this->limit,
        ];

        $response = Http::acceptJson()->get($this->url, $query);

        Log::info('Response status from api service = ' . $response->status());
        $this->consoleOutput->writeln("Response status from api service = {$response->status()}");
        
        $pagesCount = $response->json('meta.last_page');

        Log::info('Pages count for parsing = ' . $pagesCount);
        $this->consoleOutput->writeln("Pages count for parsing = {$pagesCount}");

        for ($page = 1; $page <= $pagesCount; $page++)
        {
            $this->jobClass::dispatch($this->url, $query, $page, $this->account)->delay(now()->addSeconds($page * 2));
        }

    }

}