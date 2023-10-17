<?php

namespace App\Http\Controllers;

use App\Mail\SendPicasso;
use App\Models\Picasso;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PicassoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pics = Picasso::orderBy('id', 'asc')->where('agent_id', Auth::id())->get();
        return view('partner.picasso.index', [
            'pics' => $pics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partner.picasso.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $years18 = date('d.m.Y',strtotime('18 years ago'));
        $years14 = date('d.m.Y',strtotime('14 years ago'));
        $years80 = date('d.m.Y',strtotime('80 years ago'));
        $request->validate([
            'clientname' => 'required',
            'date_of_birth'  => 'date_format:d.m.Y|required|before:'.$years18.'|after:'.$years80,
            'passport_sn' => 'required',
            'passport_who' => 'required',
            'passport_when' => 'date_format:d.m.Y|required|before:'.$years14.'|after:'.$years80,
            'passport_code' => 'required',
            'inn' => 'required',
            'banks' => 'required',
            'salary' => 'required',
            'position' => 'required',
            'record_of_service_date' => 'date_format:d.m.Y|required|after:date_of_birth',
            'employment_date' => 'date_format:d.m.Y|required|after:date_of_birth'
        ]);

        if ($request->hasFile('scanfiles')) {
            $pic = new Picasso($request->except(['scanfiles']));
            $pic->agent_id = Auth::id();
            $pic->uid = (string) Str::uuid();
            $files = $request->file('scanfiles');
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                //$name = Str::slug($name, '-');
                $name = str_replace(' ', '-', $name);
                $file->move(public_path() . '/picasso/' . $pic->uid, $name);
                $data[] = $name;
            }
            $pic->files = json_encode($data);
            $pic->save();
            $email = Settings::where('setting', 'picasso_mail')->value('param');
            Mail::to($email)->send(new SendPicasso($pic));
            return redirect()->back()->withSuccess('Заявка успешно отправлена художнику!');
        }
        else {
            return redirect()->back()->withError('Без файлов никак!');
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
