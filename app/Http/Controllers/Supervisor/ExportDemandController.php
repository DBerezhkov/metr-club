<?php

namespace App\Http\Controllers\Supervisor;

use App\Filters\Supervisor\DemandFilter;
use App\Http\Controllers\Controller;
use App\Exports\DemandsExport;
use App\Http\Requests\DemandRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportDemandController extends Controller
{
    public function demandsExport(DemandRequest $request)
    {
        $ids = Auth::user()->employees()->withTrashed()->get()->pluck('id');
        $ids[] = Auth::id();
        $demands = DemandFilter::search_field($request)
            ->whereIn('agent_id', $ids)
            ->orderBy('created_at', 'desc')
            ->get();
        return Excel::download(new DemandsExport($demands), 'demands.xlsx');
    }
}
