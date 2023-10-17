<?php

namespace App\Http\Controllers;


class RewardController extends Controller
{
    public function index(){
        $user = auth()->user() ?? 0;
        return view('new_reward', compact('user'));
    }
}
