<?php

use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ZipController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('agreement', function () {
    return view('agreement');
})->name('agree');
Route::get('agreement/accept', [\App\Http\Controllers\Partner\AgreementController::class, 'Agreement']);

Route::get('/', function () {
    return view('metr');
})->name('mainPage');

Route::get('/partners', function () {
    return view('partners');
});

Route::get('/ipotekapro', function () {
    return view('ipotekapro');
});
Route::post('/ipotekapro/register', 'App\Http\Controllers\RegisterRefferalController@CreateRefferal');

//Route::get('/landing', function (){
//    return view('landing');
//})->name('landing.form');


Route::get('/registration', 'App\Http\Controllers\RegistrationController@form')->name('registration.form');
Route::post('/registration', [\App\Http\Controllers\RegistrationController::class, 'registrationNewUser']);
Route::post('/registration/{id}', [\App\Http\Controllers\RegistrationController::class, 'acceptUser'])->name('registration.acceptUser');

Route::get('/knowledge_metr', function () {
    return view('knowledge_metr');
})->middleware('auth', 'role:partner|admin', 'agreement', 'activity');
Route::get('/knowledge_metr1', function () {
    return view('knowledge_metr1');
})->middleware('auth', 'role:partner|admin', 'agreement', 'activity');


Route::get('/reward/{page?}/{banks_id?}', [\App\Http\Controllers\RewardController::class, 'index'])->name('reward');

Route::get('/reward_credits', function() {
    $banks = \App\Models\RewardCredit::all();
    return view('reward', [
        'rewards' => $banks,
        'title' => 'Кредиты'
    ]);
});

Route::get('/insurance', function() {
    $banks = \App\Models\Reward::all();
    $insurances = \App\Models\Insurance::all();
    return view('insurance', [
        'banks' => $banks,
        'insurances' => $insurances
    ]);
});

Route::webhooks('refin-webhook');

Route::post('download', [ZipController::class, 'zipFile']);
Route::get('demand/export', [\App\Http\Controllers\Admin\ExportDemandController::class, 'demandsExport'])->name('demandsExport');
Route::get('credit/export', [\App\Http\Controllers\Admin\ExportCreditController::class, 'creditsExport'])->name('creditsExport');
Route::get('users/export', [\App\Http\Controllers\Admin\ExportAgentsCsvController::class, 'agentsExport'])->name('agentsExport');
Auth::routes(['register' => false]);

Route::get('/home', function () {
    return redirect('/');
});

Route::get('/sopd', function () {
    $text = Settings::where('setting', 'sopd')->value('param');
    return view('sopd', [
        'text' => $text,
    ]);
})->name('sopd');

Route::get('/demo', function () {
    return view('demo');
});

Route::middleware(['auth', 'role:admin', 'activity'])->prefix('admin_panel')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homeAdmin');
    Route::resource('bank', \App\Http\Controllers\Admin\BankConroller::class);
    Route::resource('demand', \App\Http\Controllers\Admin\DemandController::class);
    Route::resource('lead', \App\Http\Controllers\Admin\LeadController::class);
    Route::resource('reward', \App\Http\Controllers\Admin\RewardController::class);
    Route::resource('reward_credits', \App\Http\Controllers\Admin\RewardCreditsController::class);
    Route::resource('insurance', \App\Http\Controllers\Admin\InsuranceController::class);
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::get('user/{id}/create_contract', 'App\Http\Controllers\Admin\UserController@createContract');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::resource('settings', \App\Http\Controllers\Admin\SettingsController::class);
    Route::resource('landings', \App\Http\Controllers\Admin\LandingController::class);
    Route::resource('regions', \App\Http\Controllers\Admin\RegionController::class);
    Route::resource('credit_programs', \App\Http\Controllers\Admin\CreditProgramController::class);
    Route::resource('demands_templates', \App\Http\Controllers\Admin\DemandsTemplateController::class);
    Route::resource('credit', \App\Http\Controllers\Admin\CreditController::class);
    Route::get('/old_reward', function() {
        $banks = \App\Models\Reward::all();
        return view('reward', [
            'rewards' => $banks,
            'title' => 'Ипотека'
        ]);
    });
    Route::resource('setting_files', \App\Http\Controllers\Admin\SettingFileController::class);

//    Route::get('/finances', function () {
//        return view('admin.finances.index');
//    });
});

Route::middleware(['auth', 'role:partner|admin', 'agreement', 'activity', 'checkcontract', 'check_agreement_send_pd'])->prefix('partner')->group(function () {
    Route::get('/', [App\Http\Controllers\Partner\HomeController::class, 'index'])->name('homePartner');
    Route::resource('profile', \App\Http\Controllers\Partner\UserController::class)->withoutMiddleware(['checkcontract', 'check_agreement_send_pd']);
    Route::resource('demands', \App\Http\Controllers\Partner\DemandController::class)->middleware('checkdemandowner');
    Route::resource('insurances', \App\Http\Controllers\Partner\DemandInsuranceController::class)->middleware('role:admin');
    Route::resource('leads', \App\Http\Controllers\Partner\LeadController::class);
    Route::resource('evaluations', \App\Http\Controllers\Partner\EvaluationController::class);
    Route::resource('credits', \App\Http\Controllers\Partner\CreditController::class)->middleware('checkcreditowner');
    Route::resource('picasso', \App\Http\Controllers\PicassoController::class, ['middleware' => ['can:picasso']]);
    Route::resource('reports', App\Http\Controllers\Partner\ReportController::class);
    Route::get('/news/{id}', [\App\Http\Controllers\Partner\NewsController::class, 'index'])->name('partner_news');
    Route::get('/page/{slug}', '\App\Http\Controllers\PageController@show')->name('page.show');
    Route::resource('employees', \App\Http\Controllers\Supervisor\EmployeeController::class)->middleware('role:supervisor');
    Route::resource('supervisor_demands', \App\Http\Controllers\Supervisor\DemandController::class)->middleware('role:supervisor');
    Route::resource('supervisor_credits', \App\Http\Controllers\Supervisor\CreditController::class)->middleware('role:supervisor');
    Route::resource('supervisor_evaluations', \App\Http\Controllers\Supervisor\EvaluationController::class)->middleware('role:supervisor');
    //Route::get('/report', '\App\Http\Controllers\Partner\ReportController@index');
});

Route::get('supervisor_demands/export', [\App\Http\Controllers\Supervisor\ExportDemandController::class, 'demandsExport'])->name('supervisorDemandsExport')->middleware('role:supervisor');
Route::get('supervisor_credits/export', [\App\Http\Controllers\Supervisor\ExportCreditController::class, 'creditsExport'])->name('supervisorCreditsExport')->middleware('role:supervisor');
Route::get('employees/export', [\App\Http\Controllers\Supervisor\ExportAgentsCsvController::class, 'agentsExport'])->name('supervisorAgentsExport')->middleware('role:supervisor');

Route::get('/l/{slug}', '\App\Http\Controllers\LandingController@show')->name('landing.show');
