<?php

namespace App\Http\Controllers;

use App\Http\Model\FriendsModel;
use App\Http\Model\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user_model;
    private $friends_model;

    public function __construct(UserModel $userModel, FriendsModel $friendsModel)
    {
        $this->user_model = $userModel;
        $this->friends_model = $friendsModel;
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
