<?php

namespace App\Http\Controllers;

use App\Http\Model\FriendsModel;
use App\Http\Model\UserModel;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    private $friends_model;

    public function __construct(FriendsModel $friendsModel)
    {
        $this->friends_model = $friendsModel;
    }

    /**
     * 获取当前用户好友列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFriends()
    {
        //  查询当前用户的好友
        $login_user = session('userInfo');
        $my_friends = $this->friends_model->getFriends(['user1' => $login_user->id, 'friends.status' => '1']);

        return view('friends', ['my_friends' => $my_friends,]);
    }
}
