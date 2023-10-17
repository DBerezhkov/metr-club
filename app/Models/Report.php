<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = false;

    public function getStatusAttribute($value) {
        return ['0' => 'Новый',
            '1' => 'Проверка',
            '2' => 'Оплачен'][$value];
    }
}
