<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 認証を処理する
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $name     = $request->input('name');
        $password = $request->input('password');

        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            // 認証に成功した
            return redirect('/home');
        } else {
            return redirect('/home');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/home');
    }
}
