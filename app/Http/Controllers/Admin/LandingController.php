<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Landing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $landings = Landing::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.landings.index', [
            'landings' => $landings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.landings.create');
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
            'title' => 'required|string',
            'slug' => 'required|string',
            'landing_type' => 'required|integer',
        ]);

        $landing = new Landing($request->all());
        if ($request->landing_type < 3) {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/img/landings/', $name);
                $landing->image = $name;
                $landing->save();
                return redirect()->back()->withSuccess('Лендинг успешно создан!');
            }
            else {
                return redirect()->back()->with('error', 'Без файлов никак!')->withInput();
            }
        }
        else {
            $landing->save();
            return redirect()->back()->withSuccess('Лендинг успешно создан!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function show(Landing $landing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $landing =Landing::find($id);
        return view('admin.landings.edit', [
            'landing' => $landing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Landing $landing)
    {
        $request->validate([
            'slug' => [
                'required',
                Rule::unique('landings')->ignore($landing),
            ],
            'title' => [
                'required',
            ]],
            [
                'slug.unique' => 'Адрес "https://metr.club/l/' . $request->slug . '/" уже занят. Выберите другой!'
            ],
        );

        if ($request->landing_type < 3) {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/img/landings/', $name);

                $old_file_path = public_path('/img/landings/' . $landing->image);
                if(File::exists($old_file_path)) File::delete($old_file_path);

                $landing->image = $name;
                $landing->update($request->except(['image']));

                return redirect()->back()->withSuccess('Лендинг успешно обновлён!');
            }
            else {
                $landing->update($request->all());
                return redirect()->back()->withSuccess('Лендинг успешно обновлён!');
            }
        }
        else {
            $landing->update($request->all());
            return redirect()->back()->withSuccess('Лендинг успешно создан!');
        }





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $landing = Landing::find($id);
        $landing->delete();
        return redirect()->back()->withSuccess('Лендинг успешно удалён!');
    }
}
