<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CreditsExport;
use App\Filters\AdminCreditFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Credit\CreditRequest;
use Maatwebsite\Excel\Facades\Excel;

class ExportCreditController extends Controller
{
    public function creditsExport(CreditRequest $request)
    {

        $credits = AdminCreditFilter::search_field($request)->orderBy('created_at', 'desc')->get();
        return Excel::download(new CreditsExport($credits), 'credits.xlsx');
    }
}
