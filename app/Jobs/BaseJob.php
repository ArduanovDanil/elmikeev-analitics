<?php

namespace App\Jobs;

use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

abstract class BaseJob implements ShouldQueue
{
    use Queueable;

    protected string $url;
    protected array $query;
    protected int $page;
    protected Account $account;

    /**
     * Create a new job instance.
     */
    public function __construct(string $url, array $query, int $page, Account $account)
    {
        $this->url = $url;
        $this->query = $query;
        $this->page = $page;
        $this->account = $account;
    }

    abstract function handle();

    protected function sendRequest(): array
    {
        $query = array_merge($this->query, ['page' => $this->page]);

        Log::info('Send request to ' . $this->url . 'Query params = ' . http_build_query($query, '', ', '));

        $response = Http::acceptJson()->get($this->url, $query);

        if (!$response->successful()) {
            Log::error('Response from endpoint is not successful. Code = ' . $response->status());
            $this->release(now()->addSeconds(10));
        }

        return $response->json('data');
    }

    protected function logSuccessfulMessage()
    {
        Log::info(get_class($this) . " successful parsed page = {$this->page}, url = {$this->url}");
    }

}
