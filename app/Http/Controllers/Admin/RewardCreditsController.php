<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardCredit;
use Illuminate\Http\Request;

class RewardCreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $rewardsCredits = RewardCredit::all();
        return view('admin.reward_credits.index', [
            'rewards' => $rewardsCredits
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reward_credits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
            'mail_for_demands' => 'required|string',
        ]);

        $reward = $this->rewardService->saveDataToRewardCredit($data);

        if ($request->has('only_text')) {
            $reward->only_text = 1;
        }
        if ($request->hasFile('img')) {
            $reward->img = $this->rewardService->saveImgToReward($request);
        } else {
            return redirect()->back()->withInput()->with('error', 'Без файлов никак!');
        }
        $reward->save();
        return redirect()->back()->withSuccess('Успех!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(RewardCredit $reward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(RewardCredit $reward_credit)
    {

        return view('admin.reward_credits.edit', compact(['reward_credit']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RewardCredit $reward_credit)
    {
        $requestData = $request->all();
        $requestData = $this->rewardService->prepareData($requestData);
        $request->merge($requestData);
        $request->validate([
            'description' => 'required|string',
            'advanced_description' => 'required|string',
            'mail_for_demands' => 'required|string',
        ]);

        if ($request->has('only_text')) {
            $requestData['only_text'] = 1;
        } else {
            $requestData['only_text'] = 0;
        }
        if ($request->hasFile('img')) {
            $requestData['img'] = $this->rewardService->saveImgToReward($request);
        }

        $reward_credit->update($requestData);

        return redirect()->route('reward_credits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RewardCredit $reward)
    {
        $reward->delete();
    }
}
