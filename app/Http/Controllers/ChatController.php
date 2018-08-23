<?php

namespace App\Http\Controllers;

use App\Http\Model\NewsModel;
use App\Http\Model\UserModel;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $news_model;
    private $user_model;

    public function __construct()
    {
        $this->news_model = new NewsModel();
        $this->user_model = new UserModel();
    }

    /**
     * 聊天页面
     * @param $user_id
     * @return mixed
     */
    public function chat(Request $request, $user_id)
    {
        $user_info = $this->user_model->getUserInfo(['id' => $user_id]);
        if ($user_info) {
            $news = $this->news_model->getNews(['send_to' => $request->session()->get('userInfo')->id]);
            return view('chat', ['news' => $news]);
        } else {
            return view('errors.404', ['message' => '用户不存在']);
        }
    }
}
