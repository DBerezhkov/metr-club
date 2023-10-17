<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandTemplate;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DemandsTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $templates = DemandTemplate::all();
        return view('admin.demands_template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $default_template = DemandTemplate::find(1);
        return view('admin.demands_template.create', compact('default_template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $template = $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'body' => 'required|string',
            'refin_body' => 'nullable|string',
        ]);
        $template['refin_body'] = $this->rewardService->prepareData($template['refin_body']);
        $template['enabled'] = $request->boolean('enabled') ?? 'false';
        DemandTemplate::create($template);

        return redirect()->route('demands_templates.index')->withSuccess('Шаблон успешно добавлен!');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($template)
    {
        $template = DemandTemplate::find($template);
        return view('admin.demands_template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $template)
    {
        $template_data = $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'body' => 'required|string',
            'refin_body' => 'nullable|string',
        ]);
        if($template != 1) {
            $template_data['enabled'] = $request->boolean('enabled') ?? 'false';
            if(!$template_data['enabled']){
                $banks = DemandTemplate::find($template)->banks;
                $default_template = DemandTemplate::find(1)->id;
                foreach ($banks as $bank){
                    $bank->demand_template_id = $default_template;
                    $bank->save();
                }
            }
        }
        $template_data['refin_body'] = $this->rewardService->prepareData($template_data['refin_body']);
        DemandTemplate::find($template)->update($template_data);
        return redirect()->route('demands_templates.index')->withSuccess('Шаблон успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($template)
    {
        $template = DemandTemplate::find($template);
        $banks = $template->banks;
        $default_template = DemandTemplate::find(1)->id;
        foreach ($banks as $bank){
            $bank->demand_template_id = $default_template;
            $bank->save();
        }
        try {
            $template->delete();
            return redirect()->route('demands_templates.index')->withSuccess('Шаблон успешно удалён!');
        } catch (QueryException $e){
            return redirect()->back()->with('error','Шаблон нельзя удалить, так как он в данный момент выбран для рассылки банком.');
        }
    }
}
