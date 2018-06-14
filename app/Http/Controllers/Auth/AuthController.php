<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->user = $user;
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function getLogin() {
        return view('auth.login');
    }

    protected function postLogin(Request $request) {
        Session::forget('access_token');
        Session::forget('user');
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        $request->request->add(['type'=> 'normal']);
        $api_errors = null;
        $api = $this->user->getAccessToken($request->all());
        if($api->result == config('define.result.failure') || empty($api->access_token)) {
            $api_errors = $api;
            return view('auth.login', [
                'api_errors' => $api_errors
            ])
            ->withErrors($validate, 'error')
            ->withInput($request->flash());
        }
        Session::set('token', [
            'access_token' => $api->access_token,
            'expired_date' => $api->expired_date,
        ]);
        Session::set('user', $api->user_profile);

        return redirect('/');
    }

    public function logout() {
        $api = $this->user->postLogout();
        if($api->result == config('define.result.failure')) {
            Session::flush();
            return redirect()->to('/signin');
        }
        Session::flush();
        return redirect()->to('/signin');
    }

    public function getForgotPassword() {
        return view('auth.forgot');
    }

    public function postForgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);
        if($validator->fails()) {
            return view('auth.forgot')->withErrors($validator, 'error')->withInput($request->flash());
        }
        $api = $this->user->postForgotPassword($request->all());
        if($api->result == config('define.result.failure')) {
            return view('auth.forgot')
            ->withErrors($api->errors, 'error')
            ->withInput($request->flash());
        }
        return view('auth.forgot', ['message' => $api->message]);
    }

    public function getForgotPasswordToken($token) {
        $api = $this->user->getForgotPasswordToken($token);
        if($api->result == config('define.result.failure') || empty($api->user)) {
            abort(404);
        }
        return view('auth.token_change_password',['forgot_token' => $token]);
    }

    public function postForgotPasswordToken(Request $request, $token) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);
        if($validator->fails()) {
            return view('auth.token_change_password',['forgot_token' => $token])->withErrors($validator, 'error');
        }
        $api = $this->user->postForgotPasswordToken($request->all(), $token);
        if($api->result == config('define.result.failure')) {
            return view('auth.token_change_password',['forgot_token' => $token]);
        }
        return 'Password Changed Successfully, <a href="'.env('APP_URL').'">Click Here to proceed</a>';
    }

}
