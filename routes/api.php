<?php

use App\Http\Controllers\Partner\DemandInsuranceController;
use App\Http\Controllers\ZipController;
use App\Http\Controllers\Report\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

 Route::get('/checknpd/{inn}', [App\Http\Controllers\ExternalApi\CheckNpdStatusController::class, 'checkStatus']);

    Route::get('/reward', [App\Http\Controllers\Api\BankRewardController::class, 'index']);

Route::group(['prefix' => 'reports', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/getreports', [ReportController::class, 'GetReports']);
    Route::get('/getbanks', [ReportController::class, 'GetBanks']);
    Route::get('/getinsurances', [ReportController::class, 'GetInsurances']);
    Route::get('/getcreditprograms', [ReportController::class, 'GetCreditPrograms']);
    Route::get('/search/{q}/{exceptions}', [ReportController::class, 'Search']);
    Route::post('/makereport', [ReportController::class, 'MakeReport']);
});

Route::group(['prefix' => 'insurances', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/partnerLogin', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'partnerLogin']);
    Route::get('/bankList', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'bankList']);
    Route::get('/companyList', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'companyList']);
    Route::post('/preCalcPolicyPrice/{id}', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'preCalcPolicyPrice']);
    Route::post('/calcPolicyPrice/{id}', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'calcPolicyPrice']);
    Route::post('/issuePolicy/{id}', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'issuePolicy']);
    Route::post('/companyUIData/{id}', [App\Http\Controllers\Partner\Api\DemandInsuranceController::class, 'companyUIData'] );
});

Route::group(['prefix' => 'demands', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/', \App\Http\Controllers\Partner\Api\DemandController::class);
    Route::post('send_new_files', [App\Http\Controllers\Partner\Api\SendNewFilesToDemandController::class, 'sendNewFiles']);
    Route::get('send_new_files/{id}', [App\Http\Controllers\Partner\Api\SendNewFilesToDemandController::class, 'getDemandFiles']);
});

Route::group(['prefix' => 'credits', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/', \App\Http\Controllers\Partner\Api\CreditController::class);
});

Route::group(['prefix' => 'banks', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [App\Http\Controllers\Admin\Api\BankController::class, 'update']);
});

Route::post('download', [ZipController::class, 'zipFile']);

