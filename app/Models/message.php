<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;
    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id','id');
    }

    public function getStatusTextAttribute($id)
    {
        return ['1' => 'Заявка принята',
                '2' => 'Отправлено в банк',
                '3' => 'Доработка',
                '4' => 'Отказ ',
                '5' => 'Одобрено'][$this->message];
    }

    public function scopeStatusById($query, $bank_id) {
        return $query->where('bank_id', $bank_id);
    }

}
