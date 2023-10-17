<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewLoginInfo extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.send_new_login_info', ['user' => $this->user])->subject('Важная информация! Ваш логин в CRM Metr.Club был изменён!');
    }
}
