<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id','id');
    }

    public function creditprogram() {
        return $this->belongsTo(CreditProgram::class, 'type', 'id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }

    public function PrintBanksList($banks){
        $banks = json_decode($banks);
        $i = 0;
        if(isset($banks)){
            $numItems = count($banks);
        } else {
            return '';
        }
        $names = '';
        foreach ($banks as $bank) {
            $i++;
            $names .= Bank::find($bank)['name'];
            if($i === $numItems) {
                $names .= '';
            }
            else {
                $names .= ', ';
            }
        }
        return $names;
    }
}
