<?php

namespace App\Services\Admin;


use App\Models\User;

class SupervisorService
{

    public static function setSupervisor($request, $user)
    {
            $supervisor = User::find($request -> set_supervisor);
            $user->is_employee = 1;
            $user->supervisor_id = $supervisor->id;
            $employee_contract_props = $supervisor->agent_contract_props;
            $employee_contract_props[$supervisor->agent_contract_type_id]['email'] = $user->email;
            $employee_contract_props[$supervisor->agent_contract_type_id]['phone'] = $user->agent_contract_props[$user->agent_contract_type_id]['phone'];
            $user->agent_contract_type_id = $supervisor->agent_contract_type_id;
            $user->agent_contract_props = $employee_contract_props;
            $request['agent_contract_props'] = $employee_contract_props;
    }

}
