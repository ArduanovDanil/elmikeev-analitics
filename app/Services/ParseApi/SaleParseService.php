<?php

namespace App\Services\ParseApi;

use App\Models\Sale;
use App\Jobs\SaleJob;


class SaleParseService extends BaseParseService
{

    protected string $modelClass = Sale::class;
    protected string  $jobClass = SaleJob::class;

    public function __construct()
    {
        parent::__construct();
        $this->url = $this->apiUrl . 'sales';
    }

}