<?php

namespace App\Services\ParseApi;

use App\Models\Stock;
use App\Jobs\StockJob;
use Illuminate\Support\Facades\Http;


class StockParseService extends BaseParseService
{

    protected string $modelClass = Stock::class;
    protected string  $jobClass = StockJob::class;

    public function __construct()
    {
        $this->url = $this->apiUrl . 'stocks';
    }

     public function parse()
    {
        $lastRecord = $this->modelClass::orderByDesc('date')->first();
        
        $dateFrom = $lastRecord->date ?? date('Y-m-d');

        $query = [
            'dateFrom' => $dateFrom,
            'page' => $this->pageStart,
            'key' => $this->key,
            'limit' => $this->limit,
        ];

        $response = Http::acceptJson()->get($this->url, $query);
        
        $pagesCount = $response->json('meta.last_page');

        for ($page = 1; $page <= $pagesCount; $page++)
        {
            $this->jobClass::dispatch($this->url, $query, $page)->delay(now()->addSeconds($page * 2));
        }

    }

}