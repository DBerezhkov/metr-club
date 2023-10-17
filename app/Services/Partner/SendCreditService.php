<?php

namespace App\Services\Partner;

use App\Mail\SendCredit;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class SendCreditService
{

    public static function sendCredit($emails, $new_credit, $bank): array
    {
       foreach ($emails as $recipient) {
           try {
               Mail::to($recipient)->send(new SendCredit($new_credit, $bank->id));
           } catch (Swift_TransportException $e) {
           }
       }
       return [
            'bank_id' => $new_credit->bank_id,
       ];
    }
}
