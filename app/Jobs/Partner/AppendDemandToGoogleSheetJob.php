<?php

namespace App\Jobs\Partner;

use App\Http\Controllers\ExternalApi\GoogleSheets\DemandSheet;
use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppendDemandToGoogleSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $demand;
    protected $bank;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($demand, $bank)
    {
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
        if($this->bank['variant_copy_for_processing'] == 2){
            $demand_sheet = new DemandSheet();
            $this->demand->bank_name = $this->bank['name'];
            $demand_sheet->appendDataToSheet($this->demand, Settings::where('setting', 'spread_sheet_id')->value('param'));
        }
    }
}
