<?php

namespace App\Models;

use App\Jobs\OrderJob;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PARSE_API_JOB = OrderJob::class;
    
    protected $gNumber;
    protected $date;
    protected $lastChangeDate;
    protected $supplierArticle;
    protected $techSize;
    protected $barcode;
    protected $totalPrice;
    protected $discountPercent;
    protected $warehouseName;
    protected $oblast;
    protected $incomeId;
    protected $odid;
    protected $nmId;
    protected $subject;
    protected $category;
    protected $brand;
    protected $isCancel;
    protected $cancelDt;

    protected $guarded = [];

}
