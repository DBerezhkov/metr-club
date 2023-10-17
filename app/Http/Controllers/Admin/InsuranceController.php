<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insurances = Insurance::all();
        $banks = Reward::all();
        return view('admin.insurance.index', [
            'insurances' => $insurances,
            'banks' => $banks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Insurance $insurance)
    {
        $banks = Reward::all();
        $percents = (array) json_decode($insurance->percents);
        return view('admin.insurance.edit', compact(['insurance', 'banks', 'percents']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $percents = json_encode(Arr::except($request->all(), [
            '_token',
            '_method'
        ]));
        $insurance = Insurance::find($id);
        $insurance->percents = $percents;
        $insurance->contacts = $request->contacts;
        $insurance->save();
        return redirect()->route('insurance.index');
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
