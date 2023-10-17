<?php

namespace App\Filters;

use App\Http\Requests\DemandRequest;
use App\Models\Demand;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DemandFilter extends QueryFilter{
    public static function search_field(DemandRequest $request){
        $data = $request->validated();
        $demandQuery = Demand::query();

        if(isset($data['search_field'])){

            $demandQuery->where([['agent_id', Auth::id()],['name', 'LIKE', '%'.$data['search_field'].'%']])
                ->orWhere([['agent_id', Auth::id()],['contact_phone', 'LIKE', '%'.$data['search_field'].'%']])
                ->orWhereRelation('agent', [['agent_id', Auth::id()],['name', 'LIKE', '%'.$data['search_field'].'%']])
                ->orWhereRelation('agent', [['agent_id', Auth::id()],['email', 'LIKE', '%'.$data['search_field'].'%']]);
        }
        if(isset($data['create_date_range'])){
            $range = explode(' - ', $data['create_date_range']);
            $range[0] = Carbon::parse($range[0])->startOfDay();
            $range[1] = Carbon::parse($range[1])->endOfDay();
            $demandQuery->whereBetween('created_at', array_values($range));
        }

        if(isset($data['name_of_banks'])){
            $demandQuery->where(function($demandQuery) use ($data) {
                foreach ($data['name_of_banks'] as  $name_of_bank){
                    $demandQuery->orWhereJsonContains('banks_list', $name_of_bank);
                }
            });
        }
        return $demandQuery;
    }
}
