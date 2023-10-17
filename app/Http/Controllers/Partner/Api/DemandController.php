<?php

namespace App\Http\Controllers\Partner\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExternalApi\GoogleSheets\DemandSheet;
use App\Http\Requests\Partner\Api\StoreDemandRequest;
use App\Jobs\Partner\AppendDemandToGoogleSheetJob;
use App\Jobs\Partner\SendDemandJob;
use App\Models\Bank;
use App\Models\CreditProgram;
use App\Models\Demand;
use App\Models\Region;
use App\Models\Settings;
use App\Models\User;
use App\Services\Partner\SendDemandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
      $banks = Bank::orderBy('order', 'asc')->where('enabled', '=', 1)->get();
      $text = Settings::where('setting', 'max_file_size_text')->value('param');
      $regions = Region::query()->where('id', '!=', 1)->orderBy('title')->get();
      $defaultRegion = Region::find(1);
      $creditPrograms = CreditProgram::query()->where('enabled_demands', '=', 1)->get();
      $max_count_banks_for_demand = Settings::where('setting', 'max_count_banks_for_demand')->value('param');

      $data = [
          'banks' => $banks,
          'text' => $text,
          'regions' => $regions,
          'defaultRegion' => $defaultRegion,
          'creditPrograms' => $creditPrograms,
          'max_count_banks_for_demand' => $max_count_banks_for_demand,
      ];

        return $data;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDemandRequest $request)
    {
        $new_demand = new Demand();
        $new_demand->name = $request->name;
        $new_demand->type = $request->type;
        $new_demand->estatetype = $request->estatetype;
        $new_demand->creditprogram = $request->creditprogram;
        $new_demand->agent_id = Auth::id();
        $new_demand->contact_phone = $request->clientphone;
        $new_demand->first_pay_summ = $request->firstpaysumm;
        $new_demand->refin_date = $request->refindate;
        $new_demand->refin_percent = $request->refinpercent;
        $new_demand->refin_balance = $request->refinbalance;
        $new_demand->first_pay_percents = round((($request->firstpaysumm / $request->estatesumm) * 100), 0);
        $new_demand->estate_summ = $request->estatesumm;
        $new_demand->credit_summ = $request->estatesumm - $request->firstpaysumm;
        $new_demand->banks_list = json_encode($request->banks);
        $new_demand->pledges_region = $request->pledges_region;
        $new_demand->deals_region = $request->deals_region;
        $new_demand->commentary = $request->commentary;
        $new_demand->offices_list = json_encode($request->offices);
        $new_demand->rate_list = json_encode($request->variants_rate);

        //   статусы
        $tmps = $request->banks;
        $statuses = array();
        foreach ($tmps as $tmp) {
            $statuses[$tmp] = 0;
        }
        $statuses = json_encode($statuses);
        $new_demand->status = $statuses;
        //  /статусы


        $new_demand->uid = (string)Str::uuid();
            $files = $request->file('scanfiles');
            foreach ($files as $key => $file) {
                $name = $file->getClientOriginalName();
                $name = $key . '-' . str_replace(' ', '-', $name);
                $file->move(public_path() . '/clients/' . $new_demand->uid, $name);
                $data[] = $name;
            }
            $new_demand->files = json_encode($data);

            $new_demand->save();

            $user = User::find(Auth::id());

            foreach ($request->banks as $bank) {
                $tmp = Bank::find($bank);
                $new_demand->bank_name = $tmp->name;
                $new_demand->bank_id = $tmp->id;
                $emails = SendDemandService::sendDemand($user->region_id, $new_demand, $tmp);
                SendDemandJob::dispatch($emails, $new_demand, $tmp->toArray())->onQueue('SendDemand');
                AppendDemandToGoogleSheetJob::dispatch($new_demand, $tmp->toArray())->onQueue('AppendDemandToGoogleSheet');
            }
            return response()->json('Заявка успешно создана!');
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
