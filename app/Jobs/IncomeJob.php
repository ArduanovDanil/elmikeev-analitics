<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use App\Models\Income;
use Illuminate\Queue\Middleware\RateLimited;

class IncomeJob implements ShouldQueue
{
    use Queueable;

    protected string $url;
    protected array $query;
    protected int $page;

    /**
     * Create a new job instance.
     */
    public function __construct(string $url, array $query, int $page)
    {
        $this->url = $url;
        $this->query = $query;
        $this->page = $page;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $query = array_merge($this->query, ['page' => $this->page]);
        $response = Http::acceptJson()->get($this->url, $query);
        
        $status = $response->status();

        Log::info('status');
        Log::info($status);

        $data = $response->json('data');

        Log::info('data response');
        Log::info($data);

        foreach ($data as $item)
        {
            if ($item['number'] === ''){
                $item['number'] = null;
            }
            Income::create($item);
        }

        Log::info("Mess from IncomeJob with page = {$this->page}");
        Log::info("Mess from IncomeJob with url = {$this->url}");
    }
}
