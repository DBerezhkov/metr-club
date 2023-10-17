<?php

namespace App\Http\Controllers;

use App\Mail\SendDemand;
use App\Mail\SendRefferal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function GuzzleHttp\Promise\all;

class RegisterRefferalController extends Controller
{
    public function CreateRefferal(Request $request){
        $email = 'ipoteka@metr.club';
        //$email = 'dfkkg@ya.ru';
        $ref = $request->all();
        Mail::to($email)->send(new SendRefferal($ref));
        return redirect()->back()->withSuccess('Заявка успешно подана! В ближайшее время с вами свяжутся.');
    }
}
