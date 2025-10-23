<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TokenType extends Model
{
    protected $id;
    protected $name;

    protected $guarded = [];

    public function token(): BelongsTo
    {
        return $this->belongsTo(Token::class);
    }

    public function apiServices() : BelongsToMany
    {
        return $this->belongsToMany(ApiService::class);
    }

}
