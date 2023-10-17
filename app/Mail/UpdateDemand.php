<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateDemand extends Mailable
{
    use Queueable, SerializesModels;

    protected $dem;

    /**
     * Create a new message instance.
     *
     * @return void
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
        return $this->view('view.name');
    }
}
