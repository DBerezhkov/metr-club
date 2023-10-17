<?php

namespace App\Jobs\Partner;

use App\Models\Bank;
use App\Models\Credit;
use App\Models\User;
use App\Services\Admin\CreditService;
use App\Services\Partner\SendCreditService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCreditJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $emails;
    protected $credit;
    protected $bank;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($credit, Bank $bank)
    {
        $this->credit = $credit;
        $this->bank = $bank;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SendCreditService::sendCredit($this->credit, $this->bank);
    }

    public function failed(\Throwable $exception) {
        CreditService::deleteFileFromCredit($this->credit);
        Credit::find($this->credit->id)->delete();
    }
}
