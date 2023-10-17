<?php
namespace App\Handler;

use App\Models\message;
use Spatie\WebhookClient\ProcessWebhookJob;

class WebhookHandler extends ProcessWebhookJob {

    public function handle(){
        logger($this->webhookCall);
        $data = json_decode($this->webhookCall, true)['payload'];
        //logger($data['uid']);
        //logger($data['bank_id']);
        //logger($data['status']);
        $message = new Message();
        $message->uid = $data['uid'];
        $message->bank_id = $data['bank_id'];
        $message->type = 0;
        $message->message = $data['status'];
        $message->save();
    }

}
