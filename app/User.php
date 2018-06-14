<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ApiModel;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __construct(ApiModel $api) {
        $this->api = $api;
    }

    public function getAccessToken($data) {
        $res = $this->api->call('POST', env('API_URL').'/auth/login', $data);
        return $res->getBody();
    }

    public function updateUserProfile($data, $user_profile_id) {
        $res = $this->api->callByAuth('POST', env('API_URL').'/user/update/'.$user_profile_id, $data);
        return $res->getBody();
    }

    public function getUsers() {
        $res = $this->api->callByAuth('GET', env('API_URL').'/users');
        return $res->getBody();
    }

    public function postForgotPassword($data) {
        $res = $this->api->call('POST', env('API_URL').'/auth/forgot', $data);
        return $res->getBody();
    }

    public function getForgotPasswordToken($token) {
        $res = $this->api->call('GET', env('API_URL').'/auth/forgot-password/'.$token);
        return $res->getBody();
    }

    public function postForgotPasswordToken($data, $token) {
        $res = $this->api->call('POST', env('API_URL').'/auth/forgot-password/'.$token, $data);
        return $res->getBody();
    }

    public function postAddUser($data) {
        $res = $this->api->callByAuth('POST', env('API_URL').'/users/add', $data);
        return $res->getBody();
    }

    public function postChangePassword($data) {
        $res = $this->api->callByAuth('POST', env('API_URL').'/auth/change-password', $data);
        return $res->getBody();
    }

    public function postRemoveUser($data, $user_id) {
        $res = $this->api->callByAuth('POST', env('API_URL').'/users/remove/'.$user_id, $data);
        return $res->getBody();
    }

    public function postLogout() {
        $res = $this->api->callByAuth('GET', env('API_URL').'/auth/logout');
        return $res->getBody();
    }

    public function getUserHighlights($user_id) {
        $res = $this->api->callByAuth('GET', env('API_URL').'/highlights/'.$user_id);
        return $res->getBody();
    }
}
