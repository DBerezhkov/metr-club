<?php

namespace App\Http\Controllers\ExternalApi\GoogleSheets;

use Carbon\Carbon;
use Google_Service_Exception;
use Google_Service_Sheets_ValueRange;


class UserSheet extends GoogleSheet
{
    public function appendDataToSheet($data, $spreadsheetId)
    {
        try {
        $name = $data['surname'] . " " . $data['name'];
        $date = Carbon::now()->format('d.m.Y');
        $login = $data['login'];
        $numberPhone = $data['telnumber'];
        $how_know_about_us = $data['how_know_about_us'];
        $referal = mb_substr($data['url'], strrpos($data['url'], '/')+1);
        $referal = $referal == 'registration' ? '' : $referal;
        $form_of_interaction = $data['form_of_interaction'];
        $telegram = $data['tglogin'];

        $values = [
            [$name, $name, $date, $login, $numberPhone, $how_know_about_us, $referal, $form_of_interaction, $telegram]
        ];
        $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
        $options = array('valueInputOption' => 'RAW');
            $this->appendToSheet($spreadsheetId, 'Агенты', $body, $options);
        } catch (Google_Service_Exception $exception) {

        }

    }
}
