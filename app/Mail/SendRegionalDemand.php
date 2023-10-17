<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendRegionalDemand extends Mailable
{
    use Queueable, SerializesModels;

    protected $dem;

    /**
     * Create a new message instance.
     *
     * @param $dem
     */
    public function __construct($dem)
    {
        $this->dem = $dem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find(Auth::id());
        $user_telnumber = $user->agent_contract_props[$user->agent_contract_type_id]['phone'];
        $user_email = $user->agent_contract_props[$user->agent_contract_type_id]['email'];
        $files = json_decode($this->dem->files);
        foreach ($files as $file) {
            $this->attach(public_path() . '/clients/' . $this->dem->uid . '/' . $file);
        }
        return $this->view('mail.send_regional_demand', ['demand' => $this->dem, 'user_name' => $user->name, 'user_telnumber' => $user_telnumber, 'user_email' => $user_email])
            ->subject($this->dem->name.'_'.'_МетрКлаб_'.'[' . $this->dem->uid . ']/'.$this->dem->bank_id);
    }
}
