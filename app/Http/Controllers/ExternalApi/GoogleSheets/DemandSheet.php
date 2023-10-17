<?php

namespace App\Http\Controllers\ExternalApi\GoogleSheets;

use App\Models\CreditProgram;
use Carbon\Carbon;
use Google_Service_Exception;
use Google_Service_Sheets_ValueRange;

class DemandSheet extends GoogleSheet
{

    public function appendDataToSheet($data, $spreadsheetId)
    {
        try {
            if(array_key_exists('initials_surname', $data->agent->agent_contract_props[$data->agent->agent_contract_type_id])){
                $agent_name = $data->agent->agent_contract_props[$data->agent->agent_contract_type_id]['initials_surname'] ?? $data->agent->name;
            } elseif (array_key_exists('shortname', $data->agent->agent_contract_props[$data->agent->agent_contract_type_id])) {
                $agent_name = $data->agent->agent_contract_props[$data->agent->agent_contract_type_id]['shortname'] ?? $data->agent->name;
            } else {
                $agent_name = $data->agent->name;
            }
        $values = [
            ['', 'партнер', $data->created_at->format('d.m.Y'), $data->bank_name, $agent_name,
                $data->agent->email, CreditProgram::find($data->creditprogram)->title, $data->credit_summ, $data->name, 'нд', 'в банке']
        ];
        $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
        $options = array('valueInputOption' => 'RAW');
            $this->appendToSheet($spreadsheetId, 'Реестр', $body, $options);
        } catch (Google_Service_Exception $exception) {
            logger($exception);
        }
    }
}
