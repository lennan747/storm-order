<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //

    public function password(){
        return view('auth.reset');
    }

    public function passwordReset(Request $request){
        //dd($request->user());

        $old_password = $request->input('old_password');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'old_password'=>'required|between:8,20',
            'password'=>'required|between:8,20|confirmed',
        ];
        $messages = [
            'required' => '密码不能为空',
            'between' => '密码必须是8~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);
        $user = Auth::user();
        $validator->after(function($validator) use ($old_password, $user) {
            if (!Hash::check($old_password, $user->password)) {
                $validator->errors()->add('old_password', '原密码错误');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);  //返回一次性错误
        }
        $user->password = bcrypt($password);
        $user->save();
        Auth::logout();  //更改完这次密码后，退出这个用户
        return redirect('/login');
    }
}
