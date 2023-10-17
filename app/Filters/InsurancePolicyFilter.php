<?php

namespace App\Filters;

use App\Http\Requests\InsurancePolicyRequest;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;

class InsurancePolicyFilter extends QueryFilter {

    public static function search_field(InsurancePolicyRequest $request) {
        $data = $request->validated();
        $insurancePolicyQuery = InsurancePolicy::query();

        if(isset($data['search_field'])) {
            $insurancePolicyQuery->where([['agent_id', Auth::id()],['name', 'LIKE', '%'.$data['search_field'].'%']]);
        }

        return $insurancePolicyQuery;
    }
}
