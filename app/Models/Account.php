<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $id;
    protected $name;

    protected $guarded = [];

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function token(): BelongsTo
    {
        return $this->belongsTo(Token::class);
    }


}
