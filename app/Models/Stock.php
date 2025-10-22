<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
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
