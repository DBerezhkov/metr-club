<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AgentsCsvExport;
use App\Filters\AdminUserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Maatwebsite\Excel\Facades\Excel;

class ExportAgentsCsvController extends Controller
{
    public function agentsExport(UserRequest $request)
    {

        $users = AdminUserFilter::filter_field($request)->get();
        return Excel::download(new AgentsCsvExport($users), 'agents.xlsx');
    }
}
