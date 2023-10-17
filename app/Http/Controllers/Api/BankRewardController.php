<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankRewardController extends Controller
{
    public function index(): array
    {
        $banks = Bank::orderBy('order', 'asc')->where('enabled_reward', '=', 1)->get();
        $data = [
            'banks' => $banks,
        ];

        return $data;
    }
}
