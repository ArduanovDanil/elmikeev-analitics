<?php

namespace App\Services\ParseApi;

//use App\Services\ParseApi\BaseParseService;
use App\Jobs\OrderJob;
use App\Models\Order;

class OrderParseService extends BaseParseService
{

    protected string $modelClass = Order::class;
    protected string  $jobClass = OrderJob::class;

    public function __construct()
    {
        $this->url = $this->apiUrl . 'orders';
    }

}