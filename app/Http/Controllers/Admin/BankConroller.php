<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\CreditProgram;
use App\Models\DemandTemplate;
use App\Models\Region;
use App\Services\Admin\BankService;
use App\Services\Admin\BanksRewardService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BankConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::orderBy('order', 'asc')->get();
        return view('admin.bank.index', [
            'banks' => $banks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::query()->where('id', '!=', 1)->orderBy('title')->get();
        $demand_templates = DemandTemplate::all();
        return view('admin.bank.create', compact('regions', 'demand_templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'max_files_size' => 'nullable|numeric|between:1,30'
        ]);
        $new_bank = new Bank();
        $new_bank->name = $request->namebank;
        $new_bank->email = $request->emailbank;
        $new_bank->email_copy = $request->emailcopybank;
        $new_bank->emails_for_different_programs = $request->emails_for_different_programs;
        $new_bank->contact = $request->contactbank;
        $new_bank->contact_phone = $request->contactphonebank;
        $new_bank->alt_contact = $request->altcontactbank;
        $new_bank->demand_template_id = $request->demand_template_id;
        $new_bank->attribute_for_sending_to_regions = $request->attribute_for_sending_to_regions;
        $new_bank->enabled = $request->boolean('enabled') ?? 'false';
            $region_emails = collect([]);
            foreach ($request->region_id as $id) {
                if (isset($request->region_emails[array_search($id, $request->region_id)])) {
                    $region_emails->put($id, [
                        'region_emails' => $request->region_emails[array_search($id, $request->region_id)],
                    ]);
                }
            }
            $new_bank->region_emails = $region_emails->isEmpty() ? null : $region_emails;
            $new_bank->max_files_size = $request->max_files_size;
        $new_bank->save();

        return redirect()->back()->withSuccess('Банк успешно добавлен!');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        $data = Region::all();
        $regions = $data->sortBy('title')->filter(function ($value, $key) {
            return $value->id != 1;
        });
        $region_emails = json_decode($bank->region_emails, true);
        $credit_programs = CreditProgram::all();
        $demand_templates = DemandTemplate::all();

        return view('admin.bank.edit', compact(['bank'], 'regions', 'region_emails', 'demand_templates', 'credit_programs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'max_files_size' => 'nullable|numeric|between:1,30',
            'banks_logo' => [Rule::requiredIf(!isset($bank->banks_logo)), 'mimetypes:image/png,image/jpeg'],
        ]);

        if(isset($request->credit_submit)) {
            $enabled_credit = $request->boolean('enabled_credit') ?? 'false';
            if(!isset($request->programs_credit)) {
                $request->request->add(['programs_credit' => []]);
            }

            if (!isset($request->enabled_credit)) {
                $request->request->add(['enabled_credit' => $enabled_credit]);
            }
            $requestData = $request->except(['credit_submit']);
        }

        else {
            $enabled = $request->boolean('enabled') ?? 'false';
            if (!isset($request->enabled)) {
                $request->request->add(['enabled' => $enabled]);
            }
            $requestData = $request->all();
        }

        if(isset($request->reward_submit)) {
            $requestData = BanksRewardService::update($request, $bank);
            if(isset($request->update_contact_to_reward)){
                unset($requestData['update_contact_to_reward']);
                $bank->update($requestData);
                return response()->json(['success'=> $requestData]);
            }
        }
        if (isset($request->banks_logo)){
            $file =  $request->file('banks_logo');
            $name = $file->getClientOriginalName();
            $name = str_replace(' ', '-', $name);
            if(isset($bank->banks_logo)){
                $current_logo = $bank->banks_logo;
                unlink(public_path() . "/img/banks/" . $bank->id . "/" . $current_logo);
            }
            $file->move(public_path() . '/img/banks/' . $bank->id . '/', $name);
            $bank->banks_logo = $name;
            $bank->save();
            unset($requestData['banks_logo']);
        }

        if(isset($request->region_id)) {
            $region_emails = collect([]);
            foreach ($request->region_id as $id) {
                if (isset($request->region_emails[array_search($id, $request->region_id)])) {
                    $region_emails->put($id, [
                        'region_emails' => $request->region_emails[array_search($id, $request->region_id)],
                    ]);
                }
            }
            $requestData['region_emails'] = $region_emails->isEmpty() ? null : $region_emails;
            unset($requestData['region_id']);
        }

        if ($request->has('variants_rate')) {
            $requestData['variants_rate_enable'] = $request->boolean('variants_rate_enable');
        }

        if(isset($request->banks_office)){
            $requestData = BankService::updateBank($request, $bank);
            if(isset($request->delete_office)){
                unset($requestData['delete_office']);
                $bank->update($requestData);
                return response()->json(['success'=> $requestData]);
            }
            if(isset($request->update_office)){
                unset($requestData['update_office']);
                $bank->update($requestData);
                return response()->json(['success'=> $requestData]);
            }
        }
        if (isset($requestData['variants_rate'])){
            $requestData['variants_rate'] = trim($requestData['variants_rate']);
            $last_char_of_string = $requestData['variants_rate'][strlen($requestData['variants_rate'])-1];
            $requestData['variants_rate'] = $last_char_of_string == ';' ? substr_replace($requestData['variants_rate'], '', strlen($requestData['variants_rate'])-1) : $requestData['variants_rate'];
        }

        if(isset($request->demand_submit)) {
            if(!isset($request->programs_demand)){
                $requestData['programs_demand'] = [];
            }
           unset($requestData['demand_submit']);
        }

        $bank->update($requestData);

        return redirect()->route('bank.edit', $bank->id)->withSuccess('Данные успешно обновлены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
