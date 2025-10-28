<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiService extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
    ];

    public function tokenType(): BelongsToMany
    {
        return $this->belongsToMany(TokenType::class);
    }


}
