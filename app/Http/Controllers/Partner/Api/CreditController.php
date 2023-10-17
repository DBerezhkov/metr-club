<?php

namespace App\Http\Controllers\Partner\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\Api\StoreCreditRequest;
use App\Models\Bank;
use App\Models\Credit;
use App\Models\CreditProgram;
use App\Models\Settings;
use App\Models\User;
use App\Services\Partner\SendCreditService;
use App\Services\Partner\SendDemandService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $banks = Bank::orderBy('order', 'asc')->where('enabled_credit', '=', 1)->get();
        $credit_programs = CreditProgram::where('enabled_credits', '=', 1)->get();
        $text = Settings::where('setting', 'max_file_size_text')->value('param');
        $textForPopup = Settings::where('setting', 'info_for_popup_credits')->value('param');
        return [
            'banks' => $banks,
            'text' => $text,
            'credit_programs' => $credit_programs,
            'textForPopup' => $textForPopup,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCreditRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCreditRequest $request)
    {

        $new_credit = new Credit();
        $new_credit->uid = (string)Str::uuid();
        $new_credit->agent_id = Auth::id();
        $new_credit->name = $request->name;
        $new_credit->phone = $request->clientphone;
        $new_credit->price = $request->estatesumm;
        $new_credit->type = $request->type;
        $new_credit->banks_list = json_encode($request->banks);
        $new_credit->commentary = $request->commentary;


        //dd($new_credit);

        $files = $request->file('scanfiles');
        foreach ($files as $key => $file) {
            $name = $file->getClientOriginalName();
            $name = $key . '-' . str_replace(' ', '-', $name);
            $file->move(public_path() . '/clients/credits/' . $new_credit->uid, $name);
            $data[] = $name;
        }
        $new_credit->files = json_encode($data);

        $new_credit->save();

        foreach ($request->banks as $bank) {
            $tmp = Bank::find($bank);
            $email = $tmp->email_credit;
            $new_credit->bank_name = $tmp->name;
            $new_credit->bank_id = $tmp->id;
            $emails = explode(',', str_ireplace(' ', '', $tmp->email_copy_credit));
            $emails[] = $email;
            SendCreditService::sendCredit($emails, $new_credit, $tmp);
        }
        return response()->json('Заявка успешно создана!');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
