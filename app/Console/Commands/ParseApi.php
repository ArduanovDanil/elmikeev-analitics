<?php

namespace App\Console\Commands;

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\ParseApi\IncomeParseService\IncomeParseService;

class ParseApi extends Command
{

    const ENDPOINTS = [
        'incomes' => IncomeParseService::class,
        'orders' => Order::class,
        'sales' => Sale::class,
        'stocks' => Stock::class,
    ];

    protected string $key = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
    protected string $url = 'http://109.73.206.144:6969/api/';
    protected int $limit = 500;

     protected int $pageStart = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-api {--endpoint=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endpoint = $this->option('endpoint');

        //dd($endpoint, self::ENDPOINTS);

        if (!array_key_exists($endpoint, self::ENDPOINTS)) {
            $this->error("Endpoint {$endpoint} is not allowed");
        }

        $modelClass = self::ENDPOINTS[$endpoint];
        $lastModel = $modelClass::orderByDesc('date')->first();

        dd($modelClass, $lastModel);
        
        $dateFrom = $lastModel->date ?? date('Y-m-d');
        $dateTo = date('Y-m-d');
        $url = $this->url . $endpoint;

        dd($dateFrom, $dateTo, $url);

        $query = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'page' => $this->pageStart,
            'key' => $this->key,
            'limit' => $this->limit,
        ];

        $response = Http::acceptJson()->get($url, $query);

        //dd($response);
        
        $pagesCount = $response->json('meta.last_page');
        $meta = $response->json('meta');
        //dd($meta, $pagesCount);

        for ($page = 1; $page <= $pagesCount; $page++)
        {
            $modelClass::PARSE_API_JOB::dispatch($url, $query, $page)->delay(now()->addSeconds($page * 2));
        }

        //dd($lastModel);

        //$name = $this->choice('What is your name?', ['foo' => 'Taylor', 'bar' => 'Dayle']);

    }
}
