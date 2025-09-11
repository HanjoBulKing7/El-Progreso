<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    // protected $redirectTo = '/home';

    protected function authenticated(Request $request)
    {
        if (Auth::user()->estatus == 1) {// do your margic here
            return redirect('/home');
        }else{
            $message = 'El Usuario se encuentra inactivo, Por favor contacte al administrador'; 
            $this->logout($request);
            return redirect()->back()->withInput($request->only($this->username(), 'remember')) ->withErrors([$this->username() => $message, ]); 
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
}
