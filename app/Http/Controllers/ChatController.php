<?php

namespace App\Http\Controllers;

use App\Http\Model\ChatRecordModel;
use App\Http\Model\FriendsModel;
use App\Http\Model\NewsModel;
use App\Http\Model\UserModel;
use App\Http\Tools\Tool;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $news_model;
    private $user_model;
    private $friends_model;
    private $chat_record_model;
    private $tool;

    public function __construct(NewsModel $newsModel, UserModel $userModel, FriendsModel $friendsModel, ChatRecordModel $chatRecordModel, Tool $tool)
    {
        $this->news_model = $newsModel;
        $this->user_model = $userModel;
        $this->friends_model = $friendsModel;
        $this->chat_record_model = $chatRecordModel;

        $this->tool = $tool;
    }

    /**
     * 聊天页面
     * @param Request $request
     * @param $user_id
     * @return mixed
     */
    public function chat(Request $request, $user_id)
    {
        $user_info = $this->user_model->getUserInfo(['id' => $user_id]);
        $login_user = session('userInfo');

        if ($user_info) {
            $is_friend = $this->friends_model->getFriends(['user1' => $login_user->id, 'user2' => $user_id]);
            if (count($is_friend)) {
                $chat_records = $this->chat_record_model->getChatRecords($user_id, $login_user->id);

                return view('chat', [
                    'user_id' => $user_id,
                    'username' => $user_info->username,
                    'avatar' => $user_info->avatar,
                    'records' => $chat_records
                ]);
            } else {
                return view('errors.404', ['message' => '该用户还不是您的好友']);
            }

        } else {
            return view('errors.404', ['message' => '用户不存在']);
        }
    }

    /**
     * 保存聊天消息
     * @param Request $request
     * @return string
     */
    public function save(Request $request)
    {
        $user_info = $this->user_model->getUserInfo(['id' => $request->send_to_id]);
        $login_user = session('userInfo');

        if ($user_info) {
            if (!$request->data) {
                return json_encode(['code' => 401, 'message' => '请输入想要发送的消息']);
            }
            $chat_record_model = new ChatRecordModel();
            $insert_data = [
                'news_from' => $login_user->id,
                'news_to' => $request->send_to_id,
                'message' => $request->data,
                'type' => $request->content_type,
                'created_at' => time()
            ];
            $id = $chat_record_model->newChatRecord($insert_data);
            if ($id) {
                return json_encode([
                    'code' => 200,
                    'message' => 'OK',
                    'data' => [
                        'send_to_id' => $request->send_to_id,
                        'send_to_username' => $user_info->username,
                        'send_by_id' => $login_user->id,
                        'send_by_username' => $login_user->username,
                        'send_by_user_avatar' => $login_user->avatar,
                        'content' => $request->data,
                    ]
                ]);
            } else {
                return json_encode(['code' => 402, 'message' => '消息插入失败']);
            }
        } else {
            return json_encode(['code' => 400, 'message' => '用户不存在']);
        }
    }

    /**
     * 上传聊天图片
     * @param Request $request
     * @return string
     */
    public function uploadImg(Request $request)
    {
        $file = $request->file('image');
        return $this->tool->uploadImg($file, 'chat');
    }
}
