<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'regions_list',
        'refin_percent',
        'files'
    ];

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id','id');
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

    public function printRegionsList($regions){
        $regions = array_column(json_decode($regions, true), 'region_id');
        $i = 0;
        if(isset($regions)){
            $numItems = count($regions);
        } else {
            return '';
        }
        $names = '';
        foreach ($regions as $region) {
            $i++;
            $names .= Region::find($region)['title'];
            if($i === $numItems) {
                $names .= '';
            }
            else {
                $names .= ', ';
            }
        }
        return $names;
    }

//    public function PrintFilesList(String $files){
//        $files = json_decode($files);
//        $file_list = array();
//        foreach ($files as $file) {
//            $file_list[] = $file;
//        }
//        return $file_list;
//    }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
