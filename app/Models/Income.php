<?php

namespace App\Models;

use App\Jobs\IncomeJob;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    const PARSE_API_JOB = IncomeJob::class;

    protected $incomeId;
    protected $number;
    protected $date;
    protected $lastChangeDate;
    protected $supplierArticle;
    protected $techSize;
    protected $barcode;
    protected $quantity;
    protected $totalPrice;
    protected $dateClose;
    protected $warehouseName;
    protected $nmId;

    protected $guarded = [];

}
