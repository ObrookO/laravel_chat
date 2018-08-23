<?php

namespace App\Http\Controllers;

use App\Http\Model\UserModel;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * 查找用户功能
     * @param string $username 用户名
     * @return string
     */
    public function searchUser($username = '')
    {
        if (empty($username)) {
            return json_encode(['code' => 400, 'message' => '请输入您要查找的用户名']);
        }

        $user_model = new UserModel();
        $user_info = $user_model->getUserInfo(['username' => $username]);
        if (!$user_info) {
            return json_encode(['code' => 401, 'message' => '用户不存在']);
        } else {
            return json_encode([
                'code' => 200,
                'message' => 'OK',
                'data' => [
                    'id' => $user_info->id,
                    'username' => $user_info->username,
                    'avatar' => $user_info->avatar,
                    'motto' => $user_info->motto,
                    'created_at' => date('Y-m-d H:i:s', $user_info->created_at)
                ]
            ]);
        }
    }
}
