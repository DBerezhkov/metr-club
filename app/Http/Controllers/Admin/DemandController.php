<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AgentsCsvExport;
use App\Exports\DemandsExport;
use App\Filters\AdminDemandFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemandRequest;
use App\Mail\SendDemand;
use App\Mail\SendRegionalDemand;
use App\Models\Bank;
use App\Models\Demand;
use App\Models\message;
use App\Models\Region;
use App\Models\Reward;
use App\Models\User;
use App\Services\Admin\DemandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(DemandRequest $request)
    {
        $regions = Region::all();
        $banks = Bank::orderBy('id', 'asc')->where('enabled', '=', 1)->get();
        $demands = AdminDemandFilter::search_field($request)->orderBy('created_at', 'desc')->paginate(100)->withQueryString();
        $demands_count = $demands->total();
         return view('admin.demand.index', compact('banks', 'demands', 'demands_count', 'regions'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Demand  $demand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Demand $demand)
    {

        $banks_list = json_decode($demand['banks_list']);

        $banks = Bank::orderBy('id', 'asc')->get();

        $pledges_region = Region::find($demand->pledges_region)->title;
        $deals_region = Region::find($demand->deals_region)->title;
        $offices = [];
        if(isset($demand->offices_list) && json_decode($demand->offices_list) != null){
                foreach (json_decode($demand->offices_list) as $office){
                    $offices[] = [
                      'banks_name' => json_decode($office, true)['banks_name'],
                      'office_name' => json_decode($office, true)['offices_name'],
                    ];
                }
        } else {
            $offices = null;
        }

        return view('admin.demand.show', [
            'demand' => $demand,
            'banks' => $banks,
            'banks_list' => $banks_list,
            'pledges_region' => $pledges_region,
            'deals_region' => $deals_region,
            'offices' => $offices,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    public function edit(Demand $demand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demand $demand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Demand  $demand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Demand $demand)
    {
        DemandService::deleteFileFromDemand($demand);
        $demand->delete();
        return redirect()->route('demand.index')->with('success', 'Заявка удалена!');
    }
}
