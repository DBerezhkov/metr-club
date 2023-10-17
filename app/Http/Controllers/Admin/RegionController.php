<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //$regions = Region::all()->sortBy('title');
        $regions = Region::all()->sortBy('title')->filter(function ($value, $key) {
            return $value->id != 1;
        });
        $first = Region::whereId(1)->first();
        $regions = $regions->prepend($first);
        return view('admin.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $region = $request->validate([
            'title' => 'required|unique:regions|string',
        ]);
        Region::create($region);

        return redirect()->route('regions.index')->withSuccess('Регион успешно добавлен!');
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
    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $data = $request->validate([
            'title' => 'required|unique:regions|string',
        ]);
        $region->update($data);
        return redirect()->route('regions.index')->withSuccess('Регион успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Region $region)
    {
        try {
            $region->delete();
            return redirect()->route('regions.index')->withSuccess('Регион успешно удалён!');
        } catch (QueryException $e){
            return redirect()->back()->with('error','Регион нельзя удалить, так как он в данный момент используется агентами.');
    }

    }
}
