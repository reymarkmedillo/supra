<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Session;

class UserController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }
    public function editProfile() {
        return view('user.profile');
    }

    public function updateProfile(Request $request) {
        $user = $this->user->updateUserProfile($request->all(), session()->get('user')->user_id);
        if($user->result == config('define.result.success')) {
            Session::forget('user');
            Session::set('user', $user->user_profile);
            return redirect('/user/edit');
        } else {
            return response()->json('There is some problem with your request.');
        }
    }

    public function postUpdateUser($user_id, Request $request) {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'auth_type' => 'required',
            'subscription_period' => 'numeric|min:1|max:365'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()],422);
        }

        $user = $this->user->updateUserProfile($request->all(), $user_id);
        if($user->result == config('define.result.success')) {
            return response()->json($user);
        } else {
            return response()->json(['result' => 'failed', $user]);
        }
    }

    public function getUsers() {
        if(session()->get('user')->role != 'admin') {
            return redirect(route('top'));
        }
        $users = $this->user->getUsers()->users;
        return view('user.list', compact('users'));
    }

    public function getAddUser() {
        return view('user.add');
    }

    public function postAddUser(Request $request) {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'auth_type' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()],422);
        }

        $user = $this->user->postAddUser($request->all());
        if($user->result == config('define.result.success')) {
            return response()->json($user);
        } else {
            return response()->json(['result' => 'failed', $user]);
        }
    }

    public function getEditUser($id) {
        $user = $this->user->updateUserProfile(array(), $id);

        if($user->result == config('define.result.success')) {
            if(isset($user->msg) && $user->msg == 'error') {
                abort(404);
            }
            return view('user.view', compact('user'));
        } else {
            abort(404);
        }
    }

    public function getChangePassword() {
        return view('auth.change_password');
    }

    public function postChangePassword(Request $request) {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8',
        ]);
        if($validator->fails()) {
            return view('auth.change_password')->withErrors($validator->errors());
        }
        $user = $this->user->postChangePassword($request->all());
        if($user->result == config('define.result.success')) {
            return redirect('/signout');
        } else {
            return view('auth.change_password', ['message' => $user->error]);
        }
    }

    public function postRemoveUser($user_id, Request $request) {
        $user = $this->user->postRemoveUser($request->all(), $user_id);
        return response()->json($user);
    }

    public function getUserHighlights() {
        $highlights = $this->user->getUserHighlights(session()->get('user')->user_id);
        $temp_array = array();
        $final_array = array();
        if(!$highlights) {
            abort(404);
        }
        foreach ($highlights->highlights as $highlight) {
            $temp_array[$highlight->grno][] = $highlight;
        }
        foreach ($temp_array as $grno => $array) {
            $final_array[$grno] = $array;
            $final_array[$grno]['formatted_text'] = '';
            $final_array[$grno]['formatted_text'] .= (isset($array[0]->short_title)?$array[0]->short_title:null)."\n";
            $final_array[$grno]['formatted_text'] .= (isset($array[0]->grno)?$array[0]->grno:null)."\n";
            $final_array[$grno]['formatted_text'] .= (isset($array[0]->date)?date('F d, Y',strtotime($array[0]->date)):null)."\n\n";
            foreach($array as $highlight) {
                $final_array[$grno]['formatted_text'] .= $highlight->text."\n";
            }
        }

        return view('user_highlight.index', ['highlights' => $final_array]);
    }
}
