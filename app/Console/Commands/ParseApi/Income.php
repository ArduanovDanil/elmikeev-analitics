<?php

namespace App\Console\Commands\ParseApi;

use App\Jobs\IncomeJob;
use App\Models\Income as IncomeModel;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Income extends Command
{

    protected string $key = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
    protected string $url = 'http://109.73.206.144:6969/api/incomes';
    protected int $limit = 500;

    protected int $pageStart = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:income';

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

        $lastIncomeModel = IncomeModel::orderByDesc('date')->first();
        
        $dateFrom = $lastIncomeModel->date ?? Carbon::createFromTimestamp(0)->toDateString();
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
            IncomeJob::dispatch($this->url, $query, $page)->delay(now()->addSeconds($page * 2));
        }

    }
}
