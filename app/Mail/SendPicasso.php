<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPicasso extends Mailable
{
    use Queueable, SerializesModels;

    protected $pic;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pic)
    {
        $this->pic = $pic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $files = json_decode($this->pic->files);

        foreach($files as $file) {
            $this->attach(public_path() . '/picasso/' . $this->pic->uid . '/' . $file);
        }

        return $this->view('mail.send_picasso', ['pic' => $this->pic])->subject('Новая заявка от Metr.Club / ' . $this->pic->clientname . ' /');
    }
}
