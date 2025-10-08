<?php

namespace App\Models;

use App\Jobs\StockJob;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    const PARSE_API_JOB = StockJob::class;

    protected $date;
    protected $lastChangeDate;
    protected $supplierArticle;
    protected $techSize;
    protected $barcode;
    protected $quantity;
    protected $isSupply;
    protected $isRealization;
    protected $quantityFull;
    protected $warehouseName;
    protected $inWayToClient;
    protected $inWayFromClient;
    protected $nmId;
    protected $subject;
    protected $category;
    protected $brand;
    protected $scCode;
    protected $price;
    protected $discount;

    protected $guarded = [];

}
