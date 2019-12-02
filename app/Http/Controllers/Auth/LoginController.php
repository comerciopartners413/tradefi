<?php

namespace TradefiUBA\Http\Controllers\Auth;

use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\User;
use TradefiUBA\FootPrint;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/home';
    // protected $maxLoginAttempts = 1;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('one-login')->only('login');
        // $this->middleware('sessioned')->only('login');
    }

    public function showLoginForm()
    {
        return redirect('/');
    }

    public function login(Request $request, User $user)
    {
        // $request->session()->regenerateToken();
        $email    = $request->email;
        $password = $request->password;
        $username = $request->username;
        // dd($re);
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            // 'g-recaptcha-response' => 'required|recaptcha',
            'password' => 'required|string',

        ], [
            'g-recaptcha-response.required' => 'Are you a robot? use the captcha below to answer.',
            // 'captcha'                       => 'Wrong captcha, please try again',
        ]);

        if ($validator->fails()) {
            // ***========
            $footprint = (object) [
              'Title' => 'Login - Failed',
              'Details' => 'Input validation failure.'
            ];
            FootPrint::logTrail($footprint);
            // ***========
            return response()->json(['errors' => $validator->errors()])
                ->setStatusCode(500, 'Unprocessible Entity');
        } else {

            if (Auth::attempt(['username' => $username, 'password' => $password])) {
              // ***========
              $footprint = (object) [
                'Title' => 'Login - Success',
                'Details' => 'Logged In'
              ];
              FootPrint::logTrail($footprint);
              // ***========

                return response()->json([
                    'message' => 'Login was successful',
                ]);

            } else {
                // // ***========
                // $footprint = (object) [
                //   'Title' => 'Login - Failed',
                //   'Details' => 'Wrong username / password combination.'
                // ];
                // FootPrint::logTrail($footprint);
                // // ***========
                return response()->json(['username' => 'Username/Password combination was wrong', 'errors' => $validator->errors()])
                    ->setStatusCode(500, 'Unprocessible Entity');
            }
        }

    }

    public function username()
    {
        return 'username';
    }

    public function logout()
    {
      if (Auth::check()) {
        // ***========
        $footprint = (object) [
          'Title' => 'Logout'
        ];
        FootPrint::logTrail($footprint);
        // ***========

        Auth::logout();
        return redirect('/')->with('status', 'Logged out successfully');
      }
      return redirect('/');

    }

}
