<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Sale;

class SaleJob extends BaseJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->sendRequest();

        foreach ($data as $item)
        {
            $item['account_id'] = $this->account->id;
            Sale::create($item);
        }

        $this->logSuccessfulMessage();
    }
}
