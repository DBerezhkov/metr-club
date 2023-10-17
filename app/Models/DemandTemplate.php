<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandTemplate extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function banks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bank::class);
    }
}
