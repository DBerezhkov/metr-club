<?php

namespace App\Services\Admin;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class MailService
{

    public static function createEmailForNewUser($name, $surname, $login, $password)
    {
        $url = 'https://api360.yandex.net/directory/v1/org/6239293/users';
        $data = [
            'departmentId' => 1,
            'name' => ['first' => $name, 'last' => $surname],
            'nickname' => $login,
            'password' => $password
        ];
        $authToken = Settings::where('setting', 'yandex_token')->value('param');
        $response = Http::withHeaders([
            'Authorization' => 'Oauth ' . $authToken],
        )->post($url, $data);
        return $response->json();
    }

    public static function deleteUsersEmail($login)
    {
        $authToken = Settings::where('setting', 'yandex_token')->value('param');
        $allEmails = self::getUsersList();
        $key = array_search($login, array_column($allEmails, 'nickname'));
        $userMailId = $allEmails[$key]['id'];

        $urlUser = 'https://api360.yandex.net/directory/v1/org/6239293/users/' . $userMailId;

        $response = Http::withHeaders([
            'Authorization' => 'Oauth ' . $authToken],
        )->patch($urlUser, ["isDismissed" => true,]);
        return $response->json();
    }

    public static function isUsersEmailExist($login): bool
    {
        $allEmails = self::getUsersList();
        if (array_search($login, array_column($allEmails, 'nickname'))) {
            return true;
        } else {
            return false;
        }

    }

    public static function changePassword(User $user, $password)
    {
        $authToken = Settings::where('setting', 'yandex_token')->value('param');
        $userYandexId = MailService::getUserYandexId($user);
        $urlUser = 'https://api360.yandex.net/directory/v1/org/6239293/users/' . $userYandexId;
        $response = Http::withHeaders([
            'Authorization' => 'Oauth ' . $authToken],
        )->patch($urlUser, ["password" => $password,]);

        return $response;
    }

    private static function getUserYandexId(User $user){
        $allUsers = MailService::getUsersList();
        $key = array_search(str_ireplace('@metr.club', '', $user->email), array_column($allUsers, 'nickname'));
        $userYandexId = $allUsers[$key]['id'];
        return $userYandexId;
    }

    private static function getUsersList()
    {
        $url = 'https://api360.yandex.net/directory/v1/org/6239293/users?perPage=500';
        $authToken = Settings::where('setting', 'yandex_token')->value('param');
        $response = Http::withHeaders([
            'Authorization' => 'Oauth ' . $authToken],
        )->get($url);
        return array_values($response->json()['users']);
    }
}
