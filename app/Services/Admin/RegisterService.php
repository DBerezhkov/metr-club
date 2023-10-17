<?php

namespace App\Services\Admin;

use App\Mail\SendRegistrationInfo;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterService
{

    use RegistersUsers;

    public function registerNewUser(Role $role, array $data): User
    {
       $this->validator($data);
        return $this->create($role, $data);
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * @throws \Exception
     */
    protected function create(Role $role, array $data): User
    {
        $password = $this->gen_password(14);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'agr_send_pd_is_read' => 1,
        ]);
        $user->assignRole($role);
        $this->sendRegistarionInfoMail($user, $password);
        return $user;
    }

    /**
     * @throws \Exception
     */
    public static function gen_password(int $length = 8): string
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!^&*()-_=+?';
        $size = strlen($chars) - 1;
        $password = '';
        while($length--) {
            $password .= $chars[random_int(0, $size)];
        }
        return $password;
    }

    public static function reactivate_user(User $user, $password): User
    {
        $user->password = Hash::make($password);
        $user->save();
        $user->removeRole('user');
        $user->assignRole('partner');
        return $user;
    }

    public static function sendRegistarionInfoMail(User $user, $password)
    {
        Mail::to($user->email)->send(new SendRegistrationInfo($user, $password));
    }

}
