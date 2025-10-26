<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    // protected $incomeId;
    // protected $number;
    // protected $date;
    // protected $lastChangeDate;
    // protected $supplierArticle;
    // protected $techSize;
    // protected $barcode;
    // protected $quantity;
    // protected $totalPrice;
    // protected $dateClose;
    // protected $warehouseName;
    // protected $nmId;

    protected $fillable = [
        'id',
        'income_id',
        'number',
        'date',
        'last_change_date',
        'supplier_article',
        'tech_size',
        'barcode',
        'quantity',
        'total_price',
        'date_close',
        'warehouse_name',
        'nm_id',
        'account_id'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }


}
