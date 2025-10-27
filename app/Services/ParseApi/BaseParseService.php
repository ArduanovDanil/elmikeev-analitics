<?php

namespace App\Services\ParseApi;

use App\Models\Account;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class BaseParseService
{

    protected string $key = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
    protected string $apiUrl = 'http://109.73.206.144:6969/api/';

    protected string $url;

    protected string $modelClass;
    protected string $jobClass;

    protected ConsoleOutput $consoleOutput;
    protected Account $account;

    protected int $limit = 500;
    protected int $pageStart = 1;

    public function __construct(Account $account)
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->account = $account;
    }

    public function parse()
    {
        $this->consoleOutput->writeln('Start parsing ' . $this->modelClass);

        $lastRecord = $this->modelClass::orderByDesc('date')->first();
        
        $dateFrom = $lastRecord->date ?? Carbon::createFromTimestamp(0)->toDateString();
        $dateTo = date('Y-m-d');

        Log::info('Parse from {dateFrom} to {dateTo}', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
        $this->consoleOutput->writeln("Parse from {$dateFrom} to {$dateTo}");

        $query = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
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