<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeOfSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
