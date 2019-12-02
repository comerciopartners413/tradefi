<?php

namespace TradefiUBA\Http\Controllers\Auth;

use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\User;
use TradefiUBA\Company;
use TradefiUBA\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $this->middleware('guest');
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
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            // 'dob'       => 'required|date',
            'email'     => 'required|string|email|max:255|unique:users',
            'phone'     => 'required|string|min:6|max:11',
            'password'  => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|
               confirmed',

        ], [
            'password.regex' => 'Password must contain an uppercase, a lowercase and a numeric value',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \TradefiUBA\User
     */
    protected function create(array $data)
    {
        $company = Company::where('name', 'uba')->first();
        $role = Role::where('name', 'customer')->first();
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'phone'     => $data['phone'],
            'dob'       => $data['dob'],
            'email'     => $data['email'],
            'username'  => $data['username'],
            'password'  => bcrypt($data['password']),
            'company_id' => $company->id,
            'cash_account' => random_digits(10)
        ]);

        $user->roles()->attach($role->id);
    }

}
