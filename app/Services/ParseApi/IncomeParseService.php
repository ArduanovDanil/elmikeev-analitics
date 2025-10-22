<?php

namespace App\Services\ParseApi;

use App\Models\Income;
use App\Services\ParseApi\BaseParseService;
use App\Jobs\IncomeJob;

class IncomeParseService extends BaseParseService
{

    protected string $modelClass = Income::class;
    protected string  $jobClass = IncomeJob::class;

    public function __construct()
    {
        $this->url = $this->apiUrl . 'incomes';
    }

}