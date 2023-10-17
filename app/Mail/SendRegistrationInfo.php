<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRegistrationInfo extends Mailable
{
    use Queueable, SerializesModels;

    protected $registrationinfo;
    protected $password;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registrationinfo, $password)
    {
        $this->registrationinfo = $registrationinfo;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.send_registration_info', ['registrationinfo' => $this->registrationinfo, 'password' => $this->password])->subject('Добро пожаловать в Metr.club!');
    }
}
