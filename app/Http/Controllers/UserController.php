<?php

namespace App\Http\Controllers;

use App\Http\Model\FriendsModel;
use App\Http\Model\UserModel;
use App\Http\Tools\Tool;
use Illuminate\Http\Request;
use ErrorException;

class UserController extends Controller
{
    private $user_model;
    private $friends_model;
    private $tool;

    public function __construct(UserModel $userModel, FriendsModel $friendsModel, Tool $tool)
    {
        $this->user_model = $userModel;
        $this->friends_model = $friendsModel;
        $this->tool = $tool;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 用户信息页
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     *  用户信息编辑页
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $login_user = session('userInfo');
        if ($id != $login_user->id) {
            return view('errors.404');
        }

        return view('user.show', [
            'user' => [
                'username' => $login_user->username,
                'avatar' => $login_user->avatar,
                'motto' => $login_user->motto
            ]
        ]);
    }

    /**
     *  更新用户信息
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $login_user = session('userInfo');
        if ($id != $login_user->id) {
            return json_encode(['code' => 400, 'message' => '参数错误']);
        }
        if ($request->username != $login_user->username) {
            $this->validate($request, [
                'username' => 'required|unique:users|regex:/^\w{4,16}$/'
            ], [
                'username.required' => '请输入正确的用户名',
                'username.unique' => '该用户名已被使用',
                'username.regex' => '用户名由数字、字母、_ 组成，长度在4-16之间',
            ]);
        }

        $update_data = [];
        if ($request->username) {
            $update_data['username'] = $request->username;
        }
        if ($request->avatar_url) {
            $update_data['avatar'] = $request->avatar_url;
        }
        if ($request->motto) {
            $update_data['motto'] = $request->motto;
        }

        try {
            $this->user_model->updateUser(['id' => $id], $update_data);
            session()->forget('userInfo');
            session(['userInfo' => $this->user_model->getUserInfo(['id' => $id])]);
            return json_encode(['code' => 200, 'message' => 'OK']);
        } catch (ErrorException $e) {
            $request->avatar_url ? unlink($request->avatar_url) : '';
            return json_encode(['code' => 400, 'message' => '信息修改失败']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 上传头像
     * @param Request $request
     * @return mixed
     */
    public function uploadAvatar(Request $request)
    {
        return $this->tool->uploadImg($request->file('avatar'), 'avatar');
    }

    /**
     * 用户查找功能
     * @param $username
     * @return string
     */
    public function searchUser($username)
    {
        if (empty($username)) {
            return json_encode(['code' => 400, 'message' => '请输入您要查找的用户名']);
        }

        $user_info = $this->user_model->getUserInfo(['username' => $username]);
        if (!$user_info) {
            return json_encode(['code' => 401, 'message' => '用户不存在']);
        } else {
            $can = true;
            $login_user = session('userInfo');
            $my_friends = $this->friends_model->getFriends(['user1' => $login_user->id])->pluck('username');

            if ($username == $login_user->username) {
                $can = false;
            }
            if (in_array($username, $my_friends->toArray())) {
                $can = false;
            }
            return json_encode([
                'code' => 200,
                'message' => 'OK',
                'data' => [
                    'id' => $user_info->id,
                    'can' => $can,
                    'username' => $user_info->username,
                    'avatar' => $user_info->avatar,
                    'motto' => $user_info->motto,
                    'created_at' => date('Y-m-d H:i:s', $user_info->created_at)
                ]
            ]);
        }
    }
}
