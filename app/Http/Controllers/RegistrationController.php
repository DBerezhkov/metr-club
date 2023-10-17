<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExternalApi\GoogleSheets\UserSheet;
use App\Models\Settings;
use App\Models\User;
use App\Services\Admin\MailService;
use App\Services\Admin\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{
    public function form()
    {
        return view('registration');
    }

    public function registrationNewUser(Request $request)
    {
        $usersData = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'login' => 'email:rfc,dns',
            'telnumber' => 'required|string',
            'form_of_interaction' => 'required|string',
            'tglogin' => 'nullable|string',
            'how_know_about_us' => 'required|string',
            'url' => 'nullable|url',
            'utm_source' => 'nullable|string',
            'utm_medium' => 'nullable|string',
            'utm_campaign' => 'nullable|string',
            'utm_content' => 'nullable|string',
            'utm_term' => 'nullable|string',
            'agreement' => 'accepted',
        ]);

        if (User::withTrashed()->where('email', $usersData['login'])->orWhere('old_email', $usersData['login'])->exists()) {
            return response()->json(['error' => 'Введён недопустимый логин']);
        }

        if (!preg_match('/^((\+7))(\(\d{3}\))\d{3}\-\d{2}\-\d{2}$/', $usersData['telnumber'])) {
            return response()->json(['error_number' => 'Введен некоррентный номер телефона']);
        }

        $chat_id = Settings::where('setting', 'telegram_id')->value('param');
        $chat_ids = preg_split('/,/', str_ireplace(' ', '', $chat_id));


        $usersData['tglogin'] = $usersData['tglogin'] ?? '';
        if ($usersData['tglogin'] != '') {
            $usersData['tglogin'] = str_ireplace([' ', '@'], '', $usersData['tglogin']);
            $usersData['tglogin'] = '@' . $usersData['tglogin'];
        }

        $string_data = vsprintf("Регистрация нового агента:
        Имя: %s
        Фамилия: %s
        Почтовый логин: %s
        Телефон: %s
        Форма взаимодействия: %s
        Логин Telegram: %s
        Откуда вы о нас узнали: %s
        Страница: %s
        utm_source: %s
        utm_medium: %s
        utm_campaign: %s
        utm_content: %s
        utm_term: %s", $usersData);

        foreach ($chat_ids as $chat_id) {
            $data = [
                'text' => $string_data,
                'chat_id' => $chat_id,
                'parse_mode' => 'HTML'
            ];
            Http::asForm()->get('https://api.telegram.org/bot2001296311:AAF6ptLVnxiv2ja_ujDTlUdXDlj_zBEBcxU/sendMessage', $data);
        }
        $registerService = new RegisterService();
        $user = $registerService->registerNewUser(Role::findById(3), ['name' => $usersData['name'] . ' ' . $usersData['surname'], 'email' => $usersData['login']]);
        $user->agent_registration_data = json_encode($usersData);
        $userSheet = new UserSheet();
        $userSheet->appendDataToSheet($usersData, Settings::where('setting', 'spread_sheet_id')->value('param'));
        $user->save();
        return response()->json(['success' => $usersData]);
    }

    /**
     * @throws \Exception
     */
    public function acceptUser(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->except('_token');
        $user->agent_registration_data = json_encode($data);
        $agent_registration_data = json_decode($user->agent_registration_data, true);
        $user->update([
            'name' => $agent_registration_data['name'] . ' ' . $agent_registration_data['surname'],
            'email' => $agent_registration_data['login'],
        ]);
        $password = RegisterService::gen_password(14);
        RegisterService::reactivate_user($user, $password);
        $template = Settings::where('setting', 'tg_text')->value('param');
        //MailService::createEmailForNewUser($agent_registration_data['name'], $agent_registration_data['surname'], str_ireplace('@metr.club', '', $user->email), $password);
        $res = preg_replace(['%USERNAME%', '%LOGIN%', '%PASSWORD%'], [$user->name, $user->email, $password], $template);
        //$userSheet = new UserSheet();
        //$userSheet->appendDataToSheet($data);
        return redirect()->back()->with('template', $res);
    }

}
