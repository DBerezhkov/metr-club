<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function update(Request $request) {
        foreach ($request->banks as $bank) {
            Bank::whereId($bank['id'])->update(array('order' => $bank['order']));
        }
        return response('Update success.', 200);
    }
}
