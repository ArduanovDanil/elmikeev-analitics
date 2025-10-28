<?php

namespace App\Console\Commands;

use App\Models\Account;
use Illuminate\Console\Command;
use App\Services\ParseApi\IncomeParseService;
use App\Services\ParseApi\OrderParseService;
use App\Services\ParseApi\SaleParseService;
use App\Services\ParseApi\StockParseService;
use Illuminate\Support\Facades\Log;

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
    protected $signature = 'app:parse-api {--endpoint=} {--account_id=}';

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
        $accountId = $this->option('account_id');

        if (!$endpoint) {
            $this->error('Option "endpoint" is required');
            return 1;
        }

        if (!$accountId) {
            $this->error('Option "account_id" is required');
            return 1;
        }

        if (!array_key_exists($endpoint, self::ENDPOINTS)) {
            $this->error("Endpoint {$endpoint} is not allowed");
            return 1;
        }

        $account = Account::find($accountId);

        if (!$account) {
            $this->error('Invalid "account_id" option');
            return 1;
        }

        $logMessage = "Start parsing {$endpoint} with account_id = {$account->id}";
        Log::info($logMessage);
        $this->info($logMessage);

        $parseService = new (self::ENDPOINTS[$endpoint])($account);

        $parseService->parse();

    }
}
