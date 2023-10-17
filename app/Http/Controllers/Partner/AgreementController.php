<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    public function Agreement() {
        $user = Auth::user();
        $user->agreement = 1;
        $user->save();
        //echo 'Bingo!';
        return redirect()->route('homePartner');
    }
}
