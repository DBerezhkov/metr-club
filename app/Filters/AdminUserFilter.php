<?php

namespace App\Filters;

use App\Http\Requests\Admin\UserRequest;
use App\Models\Landing;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminUserFilter extends QueryFilter {
    public static function filter_field(UserRequest $request){
        if ($request->all() != []) {
            $data = $request->validated();
            $userQuery = User::query();

            if (isset($data['name_or_email'])) {
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

            if (isset($data['agreement'])) {
                $userQuery->where('agreement', '=', $data['agreement']);
            }

            if (isset($data['create_date_range'])) {
                $range = explode(' - ', $data['create_date_range']);
                $range[0] = Carbon::parse($range[0])->startOfDay();
                $range[1] = Carbon::parse($range[1])->endOfDay();
                $userQuery->whereBetween('created_at', array_values($range));
            }

            if (isset($data['last_visit_range'])) {
                $range = explode(' - ', $data['last_visit_range']);
                $range[0] = Carbon::parse($range[0])->startOfDay();
                $range[1] = Carbon::parse($range[1])->endOfDay();
                $userQuery->whereBetween('active_at', array_values($range));
            }

            if (isset($data['agent_contract_type_id'])) {
                if ($data['agent_contract_type_id'] == 0) {
                    $userQuery->whereNull('agent_contract_type_id');
                } else if ($data['agent_contract_type_id'] == 4) {
                    $userQuery->whereNotNull('agent_contract_type_id');
                } else {
                    $userQuery->where('agent_contract_type_id', '=', $data['agent_contract_type_id']);
                }
            }

            if (isset($data['is_online'])) {
                $range = [Carbon::now()->subMinutes(5), Carbon::now()];
                $userQuery->whereBetween('active_at', $range);
            }

            if (isset($data['role'])) {
                $userQuery = User::role($data['role']);
            }

            if (isset($data['region'])) {
                $userQuery->where('region_id', $data['region']);
            }

            if (isset($data['landing'])) {
                if ($data['landing'] == 0) {
                    $landing = url('/registration');
                } else {
                    $landing = url('/l/' . Landing::whereId($data['landing'])->first()->slug);
                }
                $userQuery->whereRaw("JSON_VALUE(agent_registration_data, '$.\"url\"') LIKE '%{$landing}%'");
            }

            if (isset($data['rating'])) {
                $userQuery->whereRaw("JSON_VALUE(rating, '$.\"rating\"') = {$data['rating']}");
            }

            if (isset($data['presets'])) {
                if ($data['presets'] == 1) {
                    $userQuery->where('agreement', '=', '0')->where('created_at', '<', (Carbon::now()->subDays(90)));
                }
                if ($data['presets'] == 2) {
                    $userQuery->where('agreement', '=', '0')->where('created_at', '<', Carbon::now()->subDays(30));
                }
                if ($data['presets'] == 3) {
                    $userQuery
                        ->whereRaw("JSON_VALUE(rating, '$.\"demands\"') > 0")
                        ->orderByRaw("CAST(JSON_VALUE(rating, '$.\"rating\"') AS UNSIGNED) DESC")
                        ->orderByRaw("CAST(JSON_VALUE(rating, '$.\"demands\"') AS UNSIGNED) DESC");
                }
            }

            if (isset($data['supervisor'])) {
                $userQuery->where('id', $data['supervisor']);
            }

            if (isset($data['subagent'])) {
                $userQuery->where('id', $data['subagent']);
            }

            if (isset($data['supervisors_employees'])) {
                $userQuery->where('supervisor_id', $data['supervisors_employees']);
            }

            if (isset($data['count_subagents_from'])) {
                $userQuery->select('*')
                    ->where('users.is_supervisor', 1)
                    ->where(function ($query) {
                        $query->select(DB::raw('COUNT(*)'))
                            ->from('users as u_employee')
                            ->whereColumn('u_employee.supervisor_id', 'users.id')
                            ->where('u_employee.is_employee', 1)
                            ->whereNull('u_employee.deleted_at');
                    }, '>=', $data['count_subagents_from'])
                    ->orderBy(DB::raw('(SELECT COUNT(*) FROM users as u_employee WHERE u_employee.supervisor_id = users.id AND u_employee.is_employee = 1)'), 'desc');

            }

            if (isset($data['count_subagents_to'])) {
                $userQuery->select('*')
                    ->where('users.is_supervisor', 1)
                    ->where(function ($query) {
                        $query->select(DB::raw('COUNT(*)'))
                            ->from('users as u_employee')
                            ->whereColumn('u_employee.supervisor_id', 'users.id')
                            ->where('u_employee.is_employee', 1)
                            ->whereNull('u_employee.deleted_at');
                    }, '<=', $data['count_subagents_to'])
                    ->orderBy(DB::raw('(SELECT COUNT(*) FROM users as u_employee WHERE u_employee.supervisor_id = users.id AND u_employee.is_employee = 1)'), 'desc');

            }

            if (isset($data['agent_data'])) {
                $value = mb_strtoupper(str_replace('"', '\\\"', $data['agent_data']), 'utf8');
                $userQuery->whereRaw('UPPER(agent_contract_props) like ?', ['%' . $value . '%']);
            }
        } else {
            $userQuery = User::query()->select('id', 'name', 'email', 'agreement', 'created_at', 'active_at', 'agent_contract_type_id', 'rating', 'is_supervisor', 'is_employee');
        }

        return $userQuery;
    }
}
