<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApiService extends Model
{
    protected $id;
    protected $name;
    
    protected $guarded = [];

    public function tokenType(): BelongsToMany
    {
        return $this->belongsToMany(TokenType::class);
    }


}
