<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $rewards = Reward::all();
        return view('admin.reward.index', [
            'rewards' => $rewards
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reward.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data = $this->rewardService->prepareData($data);
        $request->merge($data);
        $request->validate([
            'description' => 'required|string',
            'advanced_description' => 'required|string',
            'name' => 'required|string',
        ]);
        $reward = $this->rewardService->saveDataToReward($data);
        if ($request->has('only_text')) {
            $reward->only_text = 1;
        }
        if ($request->hasFile('img')) {
            $reward->img = $this->rewardService->saveImgToReward($request);
        }
        else {
            return redirect()->back()->withInput()->with('error', 'Без файлов никак!');
        }
        $reward->save();
        return redirect()->back()->withSuccess('Успех!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function show(Reward $reward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Reward $reward)
    {
        return view('admin.reward.edit', compact(['reward']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Reward $reward)
    {
        $requestData = $request->all();
        $requestData = $this->rewardService->prepareData($requestData);
        $request->merge($requestData);

         $request->validate([
            'description' => 'required|string',
            'advanced_description' => 'required|string',
            'name' => 'required|string',
        ]);

        if ($request->has('only_text')) {
            $requestData['only_text'] = 1;
        } else {
            $requestData['only_text'] = 0;
        }
        if ($request->hasFile('img')) {
            $requestData['img'] = $this->rewardService->saveImgToReward($request);
        }

        $reward->update($requestData);

        return redirect()->route('reward.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reward $reward)
    {
        $reward->delete();
    }
}
