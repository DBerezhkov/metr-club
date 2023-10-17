<?php

namespace App\Http\Controllers\Partner;

use App\Filters\InsurancePolicyFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsurancePolicyRequest;
use App\Models\insurance_policy;
use App\Models\InsurancePolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DemandInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(InsurancePolicyRequest $request)
    {
        $insurances = InsurancePolicyFilter::search_field($request)->where('agent_id',  Auth::id())->orderBy('created_at', 'desc')->paginate(30)->withQueryString();
        $insurances_count = $insurances->total();
        return view('partner.demandinsurance.index', compact('insurances', 'insurances_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('partner.demandinsurance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
