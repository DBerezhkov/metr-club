<?php

namespace App\Http\Controllers\Admin;

use App\Filters\AdminCreditFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Credit\CreditRequest;
use App\Models\Bank;
use App\Models\Credit;
use App\Models\CreditProgram;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(CreditRequest $request)
    {
       $credits = AdminCreditFilter::search_field($request)->orderBy('created_at', 'desc')->paginate(30)->withQueryString();
        $credit_programs = CreditProgram::where('enabled_credits', '=', true)->get();
        $banks = Bank::orderBy('order', 'asc')->where('enabled', '=', 1)->get();
        $credits_count = $credits->total();

        return view('admin.credit.index', compact('credits', 'credit_programs', 'banks', 'credits_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $credit = Credit::find($id);
        return view('admin.credit.show', compact('credit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
