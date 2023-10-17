<?php

namespace App\Http\Controllers\Partner;

use App\Filters\CreditFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\Credit\CreditRequest;
use App\Mail\SendCredit;
use App\Models\Bank;
use App\Models\Credit;
use App\Models\CreditProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(CreditRequest $request)
    {
        if(Auth::user()->hasRole('supervisor')){
            return redirect()->route('supervisor_credits.index');
        }
        $credits = CreditFilter::search_field($request)->where('agent_id', Auth::id())->orderBy('created_at', 'desc')->paginate(30)->withQueryString();
        $banks = Bank::orderBy('order', 'asc')->where('enabled', '=', 1)->get();
        $credits_count = $credits->total();
        return view('partner.credit.index', compact('credits', 'banks', 'credits_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('partner.credit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|min:15',
            'first_payment' => 'required',
            'type' => 'required',
        ]);
        $credit = new Credit();
        $credit->agent_id = Auth::id();
        $credit->name = $request->name;
        $credit->phone = $request->phone;
        $credit->price = 0;
        $credit->first_payment = $request->first_payment;
        $credit->type = $request->type;
        $credit->uid = (string) Str::uuid();

        if ($request->hasFile('scanfiles')) {
            $files = $request->file('scanfiles');
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $name = str_replace(' ', '-', $name);
                $file->move(public_path() . '/clients/' . $credit->uid, $name);
                $data[] = $name;
            }

            $credit->files = json_encode($data);
            $email = 'zayavka@metr.club';
            Mail::to($email)->send(new SendCredit($credit));

            $credit->save();
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
    public function show(Credit $credit)
    {
        $credit_program = CreditProgram::find($credit->type);
        $banks_list = json_decode($credit['banks_list']);
        $banks = Bank::orderBy('id', 'asc')->get();
        return view('partner.credit.show', compact('credit', 'credit_program', 'banks_list', 'banks'));
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
