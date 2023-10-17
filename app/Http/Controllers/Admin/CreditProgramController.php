<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditProgram;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CreditProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $credit_programs = CreditProgram::all()->sortBy('id')->filter(function ($value, $key) {
                return $value->id != 1;
            });
        $first = CreditProgram::whereId(1)->first();
        $credit_programs = $credit_programs->prepend($first);
        return view('admin.creditprograms.index', compact('credit_programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.creditprograms.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credit_program = $request->validate([
            'title' => 'required|unique:credit_programs|string',
        ]);
        CreditProgram::create($credit_program);

        return redirect()->route('credit_programs.index')->withSuccess('Кредитная программа успешно добавлена!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(CreditProgram $credit_program)
    {
        return view('admin.creditprograms.edit', compact('credit_program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditProgram $creditProgram)
    {
        $data = $request->validate([
            'title' => 'required|string',
        ]);
        if($creditProgram->id == 1) {
            $data['enabled_demands'] = true;
        } else {
            $data['enabled_demands'] = $request->boolean('enabled_demands') ?? 'false';
        }
        $data['enabled_credits'] = $request->boolean('enabled_credits') ?? 'false';

        $creditProgram->update($data);
        return redirect()->route('credit_programs.index')->withSuccess('Кредитная программа успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CreditProgram $creditProgram)
    {
        try {
            $creditProgram->delete();
            return redirect()->route('credit_programs.index')->withSuccess('Регион успешно удалён!');
        } catch (QueryException $e){
            return redirect()->back()->with('error','Регион нельзя удалить, так как он в данный момент используется агентами.');
        }

    }
}
