<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEvaluation extends Mailable
{
    use Queueable, SerializesModels;

    protected $eval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eval)
    {
        $this->eval = $eval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $files = json_decode($this->eval->files);

        foreach ($files as $file) {
            $this->attach(public_path() . '/evaluations/' . $this->eval->uid . '/' . $file);
        }
        return $this->view('mail.send_evaluation', ['evaluation' => $this->eval])->subject('Новая заявка на оценочный альбом от Metr.Club');
    }
}
