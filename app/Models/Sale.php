<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $gNumber;
    protected $date;
    protected $lastChangeDate;
    protected $supplierArticle;
    protected $techSize;
    protected $barcode;
    protected $totalPrice;
    protected $discountPercent;
    protected $isSupply;
    protected $isRealization;
    protected $promoCodeDiscount;
    protected $warehouseName;
    protected $countryName;
    protected $oblastOkrugName;
    protected $regionName;
    protected $incomeId;
    protected $saleId;
    protected $odid;
    protected $spp;
    protected $forPay;
    protected $finishedPrice;
    protected $priceWithDisc;
    protected $nmId;
    protected $subject;
    protected $category;
    protected $brand;
    protected $isStorno;

    protected $guarded = [];

}
