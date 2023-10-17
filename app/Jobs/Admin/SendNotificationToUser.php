<?php

namespace App\Jobs\Admin;

use App\Mail\SendNewLoginInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;
use Throwable;

class SendNotificationToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if (config("app.debug")) {
                Mail::to("info.jacktiger@gmail.com")->send(new SendNewLoginInfo($this->user));
                Mail::to("dfkkg@ya.ru")->send(new SendNewLoginInfo($this->user));
                echo "письмо ушло на почтовые адреса: info.jacktiger@gmail.com и dfkkg@ya.ru " . "\n";
                logger("письмо ушло на почтовые адреса: info.jacktiger@gmail.com и dfkkg@ya.ru " . "\n");
            } else {
                Mail::to($this->user->email)->send(new SendNewLoginInfo($this->user));
                Mail::to($this->user->old_email)->send(new SendNewLoginInfo($this->user));
                echo "письмо ушло на почтовые адреса: " . $this->user->email . ' и ' . $this->user->old_email . "\n";
                logger("письмо ушло на почтовые адреса: " . $this->user->email . ' и ' . $this->user->old_email . "\n");
            }
        } catch (Swift_TransportException $e) {

        }
    }

    public function failed(Throwable $exception)
    {
        logger("Внимание! При отправке письма возникла ошибка! Письмо не было доставлено на адреса: " . $this->user->email . ' и ' . $this->user->old_email);
        logger("Текст ошибки: " . $exception);
    }
}
