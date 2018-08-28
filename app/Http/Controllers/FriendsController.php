<?php

namespace App\Http\Controllers;

use App\Http\Model\FriendsModel;
use App\Http\Model\UserModel;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    private $user_model;
    private $friends_model;

    public function __construct()
    {
        $this->user_model = new UserModel();
        $this->friends_model = new FriendsModel();
    }

    /**
     * 查找用户功能
     * @param Request $request
     * @param string $username 用户名
     * @return string
     */
    public function searchUser(Request $request, $username = '')
    {
        if (empty($username)) {
            return json_encode(['code' => 400, 'message' => '请输入您要查找的用户名']);
        }

        $user_info = $this->user_model->getUserInfo(['username' => $username]);
        if (!$user_info) {
            return json_encode(['code' => 401, 'message' => '用户不存在']);
        } else {
            $can = true;
            $login_user = $request->session()->get('userInfo');
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
