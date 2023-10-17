<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function tooltip(){
        return $this->belongsTo(Reward::class, 'id', 'id');
    }
    public function demandTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DemandTemplate::class);
    }

    public function demandTemplateCredit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DemandTemplate::class);
    }
}
