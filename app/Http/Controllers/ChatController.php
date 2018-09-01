<?php

namespace App\Http\Controllers;

use App\Http\Model\ChatRecordModel;
use App\Http\Model\NewsModel;
use App\Http\Model\UserModel;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $news_model;
    private $user_model;
    private $chat_record_model;

    public function __construct(NewsModel $newsModel, UserModel $userModel, ChatRecordModel $chatRecordModel)
    {
        $this->news_model = $newsModel;
        $this->user_model = $userModel;
        $this->chat_record_model = $chatRecordModel;
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
            $chat_records = $this->chat_record_model->getChatRecords($user_id, $login_user->id);

            return view('chat', [
                'user_id' => $user_id,
                'username' => $user_info->username,
                'records' => $chat_records
            ]);
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

    public function uploadImg(Request $request)
    {
        $file = $request->file('image');
        if (!$file) {
            return json_encode(['code' => 400, 'message' => '请上传图片']);
        }

        $max_size = 2 * 1024 * 1024;
        $allow_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $size = $file->getSize();
        $ext = $file->getClientOriginalExtension();
        if (!in_array($ext, $allow_ext)) {
            return json_encode(['code' => 401, 'message' => '只能上传jpg,jpeg,png,gif格式的图片']);
        }
        if ($size > $max_size || !$size) {
            return json_encode(['code' => 402, 'message' => '图片最大为2M']);
        }

        $path = $file->store('chat');
        if ($path) {
            return json_encode(['code' => 200, 'message' => 'OK', 'data' => '/upload/' . $path]);
        } else {
            return json_encode(['code' => 403, 'message' => '图片上传失败']);
        }
    }
}
