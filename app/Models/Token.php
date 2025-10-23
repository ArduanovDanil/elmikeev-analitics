<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Token extends Model
{
    protected $id;
    protected $value;
    protected $attributes;

    protected $guarded = [];

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }

    public function tokenType(): HasOne
    {
        return $this->hasOne(TokenType::class);
    }

}
