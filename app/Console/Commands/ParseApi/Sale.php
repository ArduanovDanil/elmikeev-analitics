<?php

namespace App\Console\Commands\ParseApi;

use App\Jobs\SaleJob;
use App\Models\Sale as SaleModel;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Sale extends Command
{

    protected string $key = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
    protected string $url = 'http://109.73.206.144:6969/api/sales';
    protected int $limit = 500;

    protected int $pageStart = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sale';

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

        $lastSaleModel = SaleModel::orderByDesc('date')->first();
        
        $dateFrom = $lastSaleModel->date ?? Carbon::createFromTimestamp(0)->toDateString();
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
            SaleJob::dispatch($this->url, $query, $page)->delay(now()->addSeconds($page * 2));
        }

    }
}
