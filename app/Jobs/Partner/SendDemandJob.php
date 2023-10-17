<?php

namespace App\Jobs\Partner;

use App\Http\Controllers\ExternalApi\GoogleSheets\DemandSheet;
use App\Mail\SendDemand;
use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;
use Throwable;

class SendDemandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emails;
    protected $demand;
    protected $bank;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $demand, $bank)
    {
        $this->emails = $emails;
        $this->demand = $demand;
        $this->bank = $bank;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->emails as $recipient) {
            try {
                Mail::to($recipient)->send(new SendDemand($this->demand, $this->bank['id']));
            } catch (Swift_TransportException $e) {
                logger($e);
            }
        }
    }

    public function failed(Throwable $exception){
//        DemandService::deleteFileFromDemand($this->demand);
//        Demand::find($this->demand->id)->delete();
    }
}
