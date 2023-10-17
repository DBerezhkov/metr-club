<?php

namespace App\Http\Controllers\Supervisor;

use App\Exports\AgentsCsvExport;
use App\Filters\Supervisor\EmployeeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportAgentsCsvController extends Controller
{
    public function agentsExport(UserRequest $request)
    {
        $users = EmployeeFilter::filter_field($request)->get()->where('supervisor_id', Auth::id());
        return Excel::download(new AgentsCsvExport($users), 'agents.xlsx');
    }
}
