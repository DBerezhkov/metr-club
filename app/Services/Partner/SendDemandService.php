<?php

namespace App\Services\Partner;


use App\Http\Controllers\ExternalApi\GoogleSheets\DemandSheet;
use App\Models\Demand;
use App\Models\Settings;

class SendDemandService
{
    public static function sendDemand($users_region_id, $new_demand, $bank)
    {
        $emails = [];

        if (isset($bank->emails_for_different_programs) && $new_demand->creditprogram == 7) {
            $emails = explode(',', str_ireplace(' ', '', $bank->emails_for_different_programs));
            self::saveDataToRegionsList($new_demand, $bank, 1);
        } elseif (json_decode($bank->offices, true) !== null && $bank->offices !== '[]' && json_decode( $new_demand->offices_list, true) !== null) {
            foreach (json_decode($new_demand->offices_list) as $offices){
                $banks_emails = collect(json_decode($bank->offices, true))->where('id', json_decode($offices, true)['offices_id'])->pluck('emails')->toArray();
                foreach ($banks_emails as $email){
                    $emails = array_merge($emails, explode(',', str_ireplace(' ', '', $email)));
                }
            }
                $emails = array_merge($emails, explode(',', str_ireplace(' ', '', $bank->email_copy)));
        } else {
            if ($bank->attribute_for_sending_to_regions == "agents_region") {
                if ($users_region_id == null || $users_region_id == 1) {
                    $emails[] = $bank->email;
                    $emails = array_merge($emails, explode(',', str_ireplace(' ', '', $bank->email_copy)));
                    self::saveDataToRegionsList($new_demand, $bank, 1);
                } else {
                    $emails = self::sendDemandToRegion($users_region_id, $new_demand, $bank);
                }
            } else if ($bank->attribute_for_sending_to_regions == "pledges_region") {
                $emails = self::sendDemandToRegion($new_demand->pledges_region, $new_demand, $bank);

            } else if ($bank->attribute_for_sending_to_regions == "deals_region") {
                $emails = self::sendDemandToRegion($new_demand->deals_region, $new_demand, $bank);
            }
        }
        return array_merge($emails, self::sendDemandToProcessing($bank));
    }

    public static function sendDemandToProcessing($bank){
        if($bank->variant_copy_for_processing == 1){
            return explode(',', str_ireplace(' ', '', Settings::where('setting', 'processing_email')->value('param')));
        }
        return [];
    }

    private static function sendDemandToRegion($region_id, $new_demand, $bank)
    {
        if (isset($bank->region_emails) && array_key_exists($region_id, json_decode($bank->region_emails, true))) {
            $region_emails = explode(',', str_ireplace(' ', '', json_decode($bank->region_emails, true)[$region_id]['region_emails']));
            self::saveDataToRegionsList($new_demand, $bank, $region_id);
            return $region_emails;
        } else {
            self::saveDataToRegionsList($new_demand, $bank, 1);
            return array_merge([$bank->email], explode(',', str_ireplace(' ', '', $bank->email_copy)));
        }
    }

    private static function saveDataToRegionsList($new_demand, $bank, $region_id)
    {

        if (isset($new_demand->regions_list)) {
            $regions_list = json_decode($new_demand->regions_list);
        }
        $regions_list[] = [
            'bank_id' => $bank->id,
            'region_id' => $region_id,
        ];
        Demand::find($new_demand->id)->update([
            'regions_list' => json_encode($regions_list),
        ]);
    }

}
