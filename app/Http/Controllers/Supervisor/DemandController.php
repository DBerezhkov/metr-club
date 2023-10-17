<?php

namespace App\Http\Controllers\Supervisor;

use App\Filters\Supervisor\DemandFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemandRequest;
use App\Models\Bank;
use App\Models\Demand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(DemandRequest $request)
    {
        $ids = Auth::user()->employees()->withTrashed()->get()->pluck('id');
        $ids[] = Auth::id();
        $demands = DemandFilter::search_field($request)
            ->whereIn('agent_id', $ids)
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->withQueryString();
        $banks = Bank::orderBy('order', 'asc')->where('enabled', '=', 1)->get();
        $demands_count = $demands->total();
        return view('partner.demand.index', compact('banks', 'demands', 'demands_count'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Demand $demand)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
