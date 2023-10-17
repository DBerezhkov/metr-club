<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if (Auth::user()->hasRole('admin')) {
            return '/admin_panel';
        }
        if (Auth::user()->hasRole('partner')) {
            return '/partner';
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ( ! User::where('email', $request->email)->first() ) {
            throw ValidationException::withMessages(
                [
                    $this->username() => [trans('auth.failed')],
                ]);
        }
        if ( ! User::where('email', $request->email)->where('password', bcrypt($request->password))->first() ) {
            throw ValidationException::withMessages(
                [
                    'password' => [trans('auth.password')],
                ]);
        }


    }
}
