<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

}
