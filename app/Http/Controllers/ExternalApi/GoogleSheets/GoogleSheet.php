<?php

namespace App\Http\Controllers\ExternalApi\GoogleSheets;

use Google_Client;
use Google_Service_Sheets;


abstract class GoogleSheet implements GoogleSheetInterface
{
    private static $googleAccountKeyFilePath;
    private static $client;
    private static $service;

    public function __construct()
    {
        self::$googleAccountKeyFilePath = base_path('metrclub-373011-af7d04588509.json');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . self::$googleAccountKeyFilePath);
        self::$client = new Google_Client();
        self::$client->useApplicationDefaultCredentials();
        self::$client->addScope('https://www.googleapis.com/auth/spreadsheets');
        self::$service = new Google_Service_Sheets(self::$client);
    }

    public function getDataFromSheet($spreadsheetId): \Google\Service\Sheets\Spreadsheet
    {
        return self::$service->spreadsheets->get($spreadsheetId);
    }

    protected function appendToSheet($spreadsheetId, $range, $body, $options){
        self::$service->spreadsheets_values->append($spreadsheetId, $range, $body, $options);
    }



}
