<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TokenType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

 
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    public function apiServices() : BelongsToMany
    {
        return $this->belongsToMany(ApiService::class);
    }

}
