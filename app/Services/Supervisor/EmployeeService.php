<?php

namespace App\Services\Supervisor;

use App\Http\Controllers\ExternalApi\GoogleSheets\UserSheet;
use App\Models\Settings;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class EmployeeService
{
    public static $users_active = [];
    public static $online_count = 0;

    public static function setActiveUserAndOnlineCount($users)
    {
        foreach ($users as $user) {
            if (Carbon::parse($user->active_at)->diffInMinutes(now()) < 5) {
                self::$users_active[$user['id']] = true;
                self::$online_count++;
            } else {
                self::$users_active[$user['id']] = false;
            }

            $phone = null;
            if (isset($user->agent_registration_data)) {
                $phone = preg_replace('/[^\d]/', '', json_decode($user->agent_registration_data)->telnumber);
            } else if (isset($user->agent_contract_props[$user->agent_contract_type_id]['phone'])) {
                $phone = preg_replace('/[^\d]/', '', $user->agent_contract_props[$user->agent_contract_type_id]['phone']);
            }

            $user->phone = $phone;
            $user->tglogin = isset($user->agent_registration_data) ? ltrim(json_decode($user->agent_registration_data)->tglogin, '@') : null;
        }
    }

    public static function getOnlineCount(): int
    {
        return self::$online_count;
    }

    public static function getUsersActive(): array
    {
        return self::$users_active;
    }

    public static function prepareRegistrationData($usersData)
    {
        switch (auth()->user()->agent_contract_type_id) {
            case 1:
                $usersData['form_of_interaction'] = 'Самозанятый';
                break;
            case 2:
                $usersData['form_of_interaction'] = 'ИП';
                break;
            case 3:
                $usersData['form_of_interaction'] = 'ООО';
                break;
        }

        $usersData['tglogin'] = $usersData['tglogin'] ?? '';
        if ($usersData['tglogin'] != '') {
            $usersData['tglogin'] = str_ireplace([' ', '@'], '', $usersData['tglogin']);
            $usersData['tglogin'] = '@' . $usersData['tglogin'];
        }

        $usersData['how_know_about_us'] =  'Агент с логином ' . auth()->user()->email . '('. auth()->user()->id .')' .' добавил нового пользователя';
        $usersData['url'] = '';
        $usersData['utm_source'] = 'none';
        $usersData['utm_medium'] = 'none';
        $usersData['utm_campaign'] = 'none';
        $usersData['utm_content'] = 'none';
        $usersData['utm_term'] = 'none';
        return $usersData;
    }

    public static function prepareUsersData($user, $usersData)
    {
        $user->agent_registration_data = json_encode($usersData);
        $user->agent_contract_type_id = auth()->user()->agent_contract_type_id;
        $employee_contract_props = auth()->user()->agent_contract_props;
        $employee_contract_props[$user->agent_contract_type_id]['email'] = $user->email;
        $employee_contract_props[$user->agent_contract_type_id]['phone'] = $usersData['telnumber'];
        $user->agent_contract_props = $employee_contract_props;
        $user->is_employee = 1;
        $user->supervisor_id = auth()->user()->id;
        $user->save();
        return $user;
    }

    public static function sendNotificationToTelegramAboutNewUser($usersData)
    {
        $chat_id = Settings::where('setting', 'telegram_id')->value('param');
        $chat_ids = preg_split('/,/', str_ireplace(' ', '', $chat_id));
        $usersData['tglogin'] = $usersData['tglogin'] ?? '';
        if ($usersData['tglogin'] != '') {
            $usersData['tglogin'] = str_ireplace([' ', '@'], '', $usersData['tglogin']);
            $usersData['tglogin'] = '@' . $usersData['tglogin'];
        }
        $string_data = vsprintf("Регистрация нового субагента:
        Имя: %s
        Фамилия: %s
        Почтовый логин: %s
        Телефон: %s
        Логин Telegram: %s
        Форма взаимодействия: %s
        Откуда вы о нас узнали: %s", $usersData);

        foreach ($chat_ids as $chat_id) {
            $data = [
                'text' => $string_data,
                'chat_id' => $chat_id,
                'parse_mode' => 'HTML'
            ];
            Http::asForm()->get('https://api.telegram.org/bot2001296311:AAF6ptLVnxiv2ja_ujDTlUdXDlj_zBEBcxU/sendMessage', $data);
        }
    }

    public static function addUserToGoogleSheet($usersData)
    {
        $userSheet = new UserSheet();
        $userSheet->appendDataToSheet($usersData, Settings::where('setting', 'spread_sheet_id')->value('param'));
    }

    public static function updateContractPropsForEmployee($user){
        $employees = $user->employees()->withTrashed()->get();
        foreach ($employees as $employee){
            $employee_contact_email = $employee->agent_contract_props[$employee->agent_contract_type_id]['email'];
            $employee_contact_phone = $employee->agent_contract_props[$employee->agent_contract_type_id]['phone'];
            $new_contract_props_for_employee = $user->agent_contract_props;
            $new_contract_props_for_employee[$user->agent_contract_type_id]['email'] = $employee_contact_email;
            $new_contract_props_for_employee[$user->agent_contract_type_id]['phone'] = $employee_contact_phone;
            $employee->update([
                'agent_contract_type_id' => $user->agent_contract_type_id,
                'agent_contract_props' => $new_contract_props_for_employee,
            ]);
        }
    }


}
