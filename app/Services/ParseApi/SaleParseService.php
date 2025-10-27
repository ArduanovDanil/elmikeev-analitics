<?php

namespace App\Services\ParseApi;

use App\Models\Sale;
use App\Jobs\SaleJob;
use App\Models\Account;


class SaleParseService extends BaseParseService
{

    protected string $modelClass = Sale::class;
    protected string  $jobClass = SaleJob::class;

    public function __construct(Account $account)
    {
        parent::__construct($account);
        $this->url = $this->apiUrl . 'sales';
    }

}