<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ParseApi\IncomeParseService;
use App\Services\ParseApi\OrderParseService;
use App\Services\ParseApi\SaleParseService;
use App\Services\ParseApi\StockParseService;

class ParseApi extends Command
{

    const ENDPOINTS = [
        'incomes' => IncomeParseService::class,
        'orders' => OrderParseService::class,
        'sales' => SaleParseService::class,
        'stocks' => StockParseService::class,
    ];

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

        if (!array_key_exists($endpoint, self::ENDPOINTS)) {
            $this->error("Endpoint {$endpoint} is not allowed");
            return 1;
        }

        $parseService = new (self::ENDPOINTS[$endpoint]);
        $parseService->parse();

    }
}
