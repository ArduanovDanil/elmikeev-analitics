<?php

namespace App\Services\ParseApi;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

abstract class BaseParseService
{

    protected string $key = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
    protected string $apiUrl = 'http://109.73.206.144:6969/api/';

    protected string $url;

    protected string $modelClass;
    protected string $jobClass;

    protected int $limit = 500;
    protected int $pageStart = 1;

    public function __construct()
    {
        
    }

    public function parse()
    {

        $lastRecord = $this->modelClass::orderByDesc('date')->first();
        
        $dateFrom = $lastRecord->date ?? Carbon::createFromTimestamp(0)->toDateString();
        $dateTo = date('Y-m-d');

        $query = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
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