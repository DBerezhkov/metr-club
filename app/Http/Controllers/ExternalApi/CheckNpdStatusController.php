<?php

namespace App\Http\Controllers\ExternalApi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckNpdStatusController extends Controller
{
    public function checkStatus($inn)
    {
        $dateStr = Carbon::now()->format("Y-m-d");
        $url = "https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status";
        $data = array(
            "inn" => $inn,
            "requestDate" => $dateStr
        );
        $response = Http::post($url, $data);
        return $response->json();
    }
}
