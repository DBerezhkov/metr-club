<?php

namespace App\Http\Controllers\Admin;

use App\Filters\AdminDemandFilter;
use App\Http\Controllers\Controller;
use App\Exports\DemandsExport;
use App\Http\Requests\DemandRequest;
use Maatwebsite\Excel\Facades\Excel;

class ExportDemandController extends Controller
{
    public function demandsExport(DemandRequest $request)
    {

        $demands = AdminDemandFilter::search_field($request)->orderBy('created_at', 'desc')->get();
        return Excel::download(new DemandsExport($demands), 'demands.xlsx');
    }
}
