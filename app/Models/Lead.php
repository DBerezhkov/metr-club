<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function manager(){
        //return $this->belongsTo(User::class, 'user_id');
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getStatusTextAttribute($id) {
        return ['0' => 'Новый',
            '4' => 'В работе',
            '1' => 'Хороший',
            '2' => 'Плохой'][$this->status];
    }
}
