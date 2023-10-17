<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRefferal extends Mailable
{
    use Queueable, SerializesModels;

    protected $ref;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ref)
    {
        $this->ref = $ref;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.send_refferal', ['ref' => $this->ref])->subject('Новый рефферал - ' . $this->ref['firstname'] . ' ' . $this->ref['surname']);
    }
}
