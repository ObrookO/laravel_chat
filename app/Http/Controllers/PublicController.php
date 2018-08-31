<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\UserModel;

class PublicController extends Controller
{
    private $user_model;

    public function __construct(UserModel $userModel)
    {
        $this->user_model = $userModel;
    }

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('public.login');
        }

        if ($request->method() == 'POST') {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required'
            ], [
                'username.required' => '请输入用户名',
                'password.required' => '请输入密码',
            ]);

            $user_info = $this->user_model->getUserInfo(['username' => $request->username]);
            if ($user_info) {
                if (decrypt($user_info->password) != $request->password) {
                    return json_encode(['code' => 401, 'message' => '密码错误']);
                } else {
                    session(['is_login' => true, 'userInfo' => $user_info]);
                    return json_encode(['code' => 200, 'message' => 'OK']);
                }
            } else {
                return json_encode(['code' => 400, 'message' => '用户不存在']);
            }
        }
    }

    public function register(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('public.register');
        }

        if ($request->method() == 'POST') {
            $this->validate($request, [
                'username' => 'required|unique:users|regex:/^\w{4,16}$/',
                'password' => 'required|regex:/^\w{6,16}$/'
            ], [
                'username.required' => '用户名由数字、字母、_ 组成，长度在4-16之间',
                'username.regex' => '用户名由数字、字母、_ 组成，长度在4-16之间',
                'username.unique' => '用户名已被占用',
                'password.required' => '密码由数字、字母、_ 组成，长度在6-16之间',
                'password.regex' => '密码由数字、字母、_ 组成，长度在6-16之间',
            ]);

            $id = $this->user_model->newUser(['username' => $request->username, 'password' => encrypt($request->password), 'created_at' => time()]);
            if ($id) {
                return json_encode(['code' => 200, 'message' => 'OK']);
            } else {
                return json_encode(['code' => 403, 'message' => '用户注册失败']);
            }
        }
    }

    public function logout(Request $request)
    {
        session()->forget(['is_login', 'userInfo']);
        return redirect(route('login'));
    }
}
