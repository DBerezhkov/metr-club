<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Mail\SendEvaluation;
use App\Models\Evaluation;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if(Auth::user()->hasRole('supervisor')){
            return redirect()->route('supervisor_evaluations.index');
        }
        $evals = Evaluation::orderBy('id', 'asc')->where('agent_id', Auth::id())->get();
        return view('partner.evaluation.index', [
            'evaluations' => $evals
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $name = Auth::user()->name;
        return view('partner.evaluation.create', [
            'name' => $name
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
        $request->validate([
            'name' => 'required',
            'clientphone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:17',
            'contact' => 'required',
            'price' => 'required',
            'comment' => 'required',
            'bank' => 'required'
        ]);
        //dd($request);
        if ($request->hasFile('scanfiles')) {
            $evaluation = new Evaluation();
            $evaluation->name = $request->name;
            $evaluation->agent_id = Auth::user()->id;
            $evaluation->clientphone = $request->clientphone;
            $evaluation->contact = $request->contact;
            $evaluation->price = $request->price;
            $evaluation->comment = $request->comment;
            $evaluation->bank = $request->bank;

            $evaluation->uid = (string) Str::uuid();

            $files = $request->file('scanfiles');
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $name = str_replace(' ', '-', $name);
                $file->move(public_path() . '/evaluations/' . $evaluation->uid, $name);
                $data[] = $name;
            }

            $evaluation->files = json_encode($data);
            $evaluation->save();
            $email = Settings::where('setting', 'evaluation_mail')->value('param');
            //$email = $template->param;
            Mail::to($email)->send(new SendEvaluation($evaluation));
            return redirect()->back()->withSuccess('Заявка успешно создана!');
        } else {
            return redirect()->back()->with('error', 'Без файлов никак!');
        }
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
