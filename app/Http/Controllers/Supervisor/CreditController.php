<?php

namespace App\Http\Controllers\Supervisor;

use App\Filters\Supervisor\CreditFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supervisor\Credit\CreditRequest;
use App\Models\Bank;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(CreditRequest $request)
    {
        $ids = Auth::user()->employees()->withTrashed()->get()->pluck('id');
        $ids[] = Auth::id();
        $credits = CreditFilter::search_field($request)
            ->whereIn('agent_id', $ids)
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->withQueryString();
        $banks = Bank::orderBy('order', 'asc')->where('enabled', '=', 1)->get();
        $credits_count = $credits->total();
        return view('partner.credit.index', compact('credits', 'credits_count', 'banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
