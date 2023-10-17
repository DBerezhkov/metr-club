<?php

namespace App\Http\Controllers\Supervisor;

use App\Exports\CreditsExport;
use App\Filters\Supervisor\CreditFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supervisor\Credit\CreditRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportCreditController extends Controller
{
    public function creditsExport(CreditRequest $request)
    {
        $ids = Auth::user()->employees()->withTrashed()->get()->pluck('id');
        $ids[] = Auth::id();
        $credits = CreditFilter::search_field($request)
            ->whereIn('agent_id', $ids)
            ->orderBy('created_at', 'desc')
            ->get();
        return Excel::download(new CreditsExport($credits), 'credits.xlsx');
    }
}
