<?php

namespace App\Filters\Supervisor;

use App\Filters\QueryFilter;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Support\Carbon;

class EmployeeFilter extends QueryFilter {
    public static function filter_field(UserRequest $request){

        $data = $request->validated();
        $userQuery = User::query();

        if(isset($data['name_or_email'])){
            $userQuery->where('name', 'like', "%{$data['name_or_email']}%")->orWhere('email', 'like', "%{$data['name_or_email']}%")
                ->orWhere('old_email', 'like', "%{$data['name_or_email']}%");
            $phone = mb_substr(preg_replace('/[^\d]/', '', $data['name_or_email']), 1);
            if (mb_strlen($phone) > 3) $userQuery->orWhereRaw("REGEXP_REPLACE(JSON_VALUE(agent_registration_data, '$.\"telnumber\"'), '[^[:alnum:]]+', '') LIKE '%{$phone}%'");
            for ($i = 1; $i < 4; $i++) {
                $userQuery->orWhereRaw("JSON_VALUE(agent_contract_props, '$.\"{$i}\".\"email\"') LIKE '%{$data['name_or_email']}%'");
                if (mb_strlen($phone) > 3) {
                    $userQuery->orWhereRaw("REGEXP_REPLACE(JSON_VALUE(agent_contract_props, '$.\"{$i}\".\"phone\"'), '[^[:alnum:]]+', '') LIKE '%{$phone}%'");
                }
            }
        }

        if(isset($data['create_date_range'])){
            $range = explode(' - ', $data['create_date_range']);
            $range[0] = Carbon::parse($range[0])->startOfDay();
            $range[1] = Carbon::parse($range[1])->endOfDay();
            $userQuery->whereBetween('created_at', array_values($range));
        }

        if(isset($data['last_visit_range'])){
            $range = explode(' - ', $data['last_visit_range']);
            $range[0] = Carbon::parse($range[0])->startOfDay();
            $range[1] = Carbon::parse($range[1])->endOfDay();
            $userQuery->whereBetween('active_at', array_values($range));
        }

        if(isset($data['is_online'])){
            $range = [Carbon::now()->subMinutes(5), Carbon::now()];
            $userQuery->whereBetween('active_at', $range);
        }

        if(isset($data['rating'])) {
            $userQuery->whereRaw("JSON_VALUE(rating, '$.\"rating\"') = {$data['rating']}");
        }

        return $userQuery;
    }
}
