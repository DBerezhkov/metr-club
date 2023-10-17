<?php

namespace App\Http\Controllers\Partner;

use App\Filters\AdminDemandFilter;
use App\Filters\AdminUserFilter;
use App\Filters\DemandFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemandRequest;
use App\Mail\SendDemand;
use App\Mail\SendRegionalDemand;
use App\Models\Bank;
use App\Models\Demand;
use App\Models\Region;
use App\Models\Settings;
use App\Models\User;
use App\Rules\MaxUploadedFileSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(DemandRequest $request)
    {
        if(Auth::user()->hasRole('supervisor')){
            return redirect()->route('supervisor_demands.index');
        }
        $demands = DemandFilter::search_field($request)->where('agent_id', Auth::id())->orderBy('created_at', 'desc')->paginate(30)->withQueryString();
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
        $banks = Bank::orderBy('id', 'asc')->where('enabled', '=', 1)->get();
        $text = Settings::where('setting', 'max_file_size_text')->value('param');
            return view('partner.demand.create', [
                'banks' => $banks,
                'text' => $text
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request['estatesumm'] = str_ireplace(' ', '', $request->estatesumm);
        $request['firstpaysumm'] = str_ireplace(' ', '', $request->firstpaysumm);
        if(isset($request->refinbalance)){
            $request['refinbalance'] = str_ireplace(' ', '', $request->refinbalance);
        }
        $request->validate([
            'clientname' => 'required|string',
            'clientphone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:17',
            'clientage' => 'required|integer',
            'estatesumm' => 'required|numeric',
            'firstpaysumm' => 'required|numeric',
            'banks' => 'required',
            'scanfiles' => ['required', new MaxUploadedFileSize(100000)],
            'scanfiles.*' => 'mimetypes:image/png,image/jpeg,application/pdf,image/tiff,application/msword,pplication/vnd.openxmlformats-officedocument.wordprocessingml.document,application/zip,application/x-rar-compressed|max:20000',
        ]);

        $new_demand = new Demand();
        $new_demand->name = $request->clientname;
        $new_demand->age = $request->clientage;
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
        $regions_list = [];

        //   статусы
        $tmps = $request->banks;
        $statuses = array();
        foreach($tmps as $tmp) {
            $statuses[$tmp] = 0;
        }
        $statuses = json_encode($statuses);
        $new_demand->status = $statuses;
        //  /статусы

        $new_demand->uid = (string) Str::uuid();
        if ($request->hasFile('scanfiles')) {
            $files = $request->file('scanfiles');
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $name = str_replace(' ', '-', $name);
                $file->move(public_path() . '/clients/' . $new_demand->uid, $name);
                $data[] = $name;
            }
            $new_demand->files = json_encode($data);

            $new_demand->save();

            $user = User::find(Auth::id());
            $users_region_id = $user->region_id;

            foreach ($request->banks as $bank) {
                $tmp = Bank::find($bank);
                $email = $tmp->email;
                $new_demand->bank_name = $tmp->name;
                $new_demand->bank_id = $tmp->id;
                $emails = explode(',', str_ireplace(' ', '',$tmp->email_copy));
                $emails[] = $email;
                if($users_region_id == null || $users_region_id == 1) {
                    foreach ($emails as $recipient) {
                        Mail::to($recipient)->send(new SendDemand($new_demand, $tmp->id));
                    }
                    $regions_list[] = [
                        'bank_id' => $new_demand->bank_id,
                        'region_id' => 1,
                    ];
                } else {
                    if (isset($tmp->region_emails) && array_key_exists($users_region_id, json_decode($tmp->region_emails, true))) {
                        $region_emails = explode(',', str_ireplace(' ', '', json_decode($tmp->region_emails, true)[$users_region_id]['region_emails']));
                        foreach ($region_emails as $recipient) {
                            Mail::to($recipient)->send(new SendDemand($new_demand, $tmp->id));
                        }
                        $regions_list[] = [
                            'bank_id' => $new_demand->bank_id,
                            'region_id' => $users_region_id,
                        ];
                    } else {
                        foreach ($emails as $recipient) {
                            Mail::to($recipient)->send(new SendDemand($new_demand, $tmp->id));
                        }
                        $regions_list[] = [
                            'bank_id' => $new_demand->bank_id,
                            'region_id' => 1,
                        ];
                    }
                }
                $demand = Demand::find($new_demand->id);
                $demand->update([
                    'regions_list' => json_encode($regions_list),
                ]);
            }
            return redirect()->back()->withSuccess('Заявка успешно создана!');
        } else {
            return redirect()->back()->with('error', 'Без файлов никак!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Demand $demand)
    {
        $banks = Bank::orderBy('id', 'asc')->get();
        $pledges_region = Region::find($demand->pledges_region)->title;
        $deals_region = Region::find($demand->deals_region)->title;
        $banks_list = json_decode($demand->banks_list);
        return view('partner.demand.show', [
            'demand' => $demand,
            'banks' => $banks,
            'pledges_region' => $pledges_region,
            'deals_region' => $deals_region,
            'banks_list' => $banks_list,
        ]);
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
