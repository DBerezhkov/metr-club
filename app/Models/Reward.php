<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function prettyDate(){
        return Carbon::parse($this->updated_at)->format('d.m.Y');
    }
}
