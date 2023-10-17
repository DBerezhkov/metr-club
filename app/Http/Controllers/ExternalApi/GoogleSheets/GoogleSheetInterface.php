<?php

namespace App\Http\Controllers\ExternalApi\GoogleSheets;

interface GoogleSheetInterface
{
    public function appendDataToSheet($data, $spreadsheetId);

}
