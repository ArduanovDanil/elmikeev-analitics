<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Order;

class OrderJob extends BaseJob implements ShouldQueue
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
            Order::create($item);
        }

        $this->logSuccessfulMessage();
    }
}
