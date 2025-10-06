<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use App\Models\Sale;

class SaleJob implements ShouldQueue
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

        $data = $response->json('data');

        foreach ($data as $item)
        {
            Sale::create($item);
        }
    }
}
