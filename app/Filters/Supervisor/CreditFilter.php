<?php

namespace App\Filters\Supervisor;

use App\Filters\QueryFilter;
use App\Http\Requests\Supervisor\Credit\CreditRequest;
use App\Models\Credit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CreditFilter extends QueryFilter{
    public static function search_field(CreditRequest $request){
        $data = $request->validated();
        $creditQuery = Credit::query();

        if(isset($data['search_field'])){
            $creditQuery->where(function ($query) use ($data) {
                $query->where('name', 'LIKE', '%'.$data['search_field'].'%')
                    ->orWhere('phone', 'LIKE', '%'.$data['search_field'].'%')
                    ->orWhereRelation('agent', 'name', 'LIKE', '%'.$data['search_field'].'%')
                    ->orWhereRelation('agent', 'email', 'LIKE', '%'.$data['search_field'].'%');
                });

        }
        if(isset($data['create_date_range'])){
            $range = explode(' - ', $data['create_date_range']);
            $range[0] = Carbon::parse($range[0])->startOfDay();
            $range[1] = Carbon::parse($range[1])->endOfDay();
            $creditQuery->whereBetween('created_at', array_values($range));
        }

        if(isset($data['name_of_banks'])){
            $creditQuery->where(function($creditQuery) use ($data) {
                foreach ($data['name_of_banks'] as  $name_of_bank){
                    $creditQuery->orWhereJsonContains('banks_list', $name_of_bank);
                }
            });
        }

        if(isset($data['supervisors_demands'])){
            $creditQuery->where('agent_id', Auth::user()->id);
        }

        if(isset($data['employees_demands'])){
            $ids = Auth::user()->employees()->pluck('id');
            $creditQuery->whereIn('agent_id', $ids);
        }

        return $creditQuery;
    }
}
