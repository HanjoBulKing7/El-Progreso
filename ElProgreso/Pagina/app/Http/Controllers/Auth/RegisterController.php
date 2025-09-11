<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    // Modificar el trait de registerUsers para evitar la redireccion y el login del usuario
    //  https://laracasts.com/discuss/channels/laravel/how-to-modify-things-in-default-register-and-login-processes?page=0
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string','email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'apepat' => $data['apepat'],
            'apemat' => $data['apemat'],
            'salario' => $data['salario'],
            'infonavit' => $data['infonavit'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'fktiporol' => $data['puesto'],
            'fecha_ingreso' => $data['fechaingreso'],
            'fecha_nacimiento' => $data['fechanacimiento'],
            'password' => Hash::make($data['password']),

        ]);
    }
}
