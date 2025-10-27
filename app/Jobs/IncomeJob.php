<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Income;

class IncomeJob extends BaseJob implements ShouldQueue
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
            if ($item['number'] === ''){
                $item['number'] = null;
            }
            $item['account_id'] = $this->account->id;
            Income::create($item);
        }

        $this->logSuccessfulMessage();
    }


}
