<?php

/**
 * Created by PhpStorm.
 * User: lx101
 * Date: 2018/4/9
 * Time: 11:50
 */

class Chat
{
    private $server;
    private static $redis;
    private $online_users;
    private $news_type = [
        '10100001' => 'friendRequest',
        '10100004' => 'chatRecord',
    ];

    public function __construct()
    {
        //  创建WebSocket服务器对象,监听0.0.0.0:9502端口
        $this->server = new swoole_websocket_server("0.0.0.0", 9502);

        self::$redis = new Redis();
        self::$redis->connect('127.0.0.1');

        $this->onOpen();
        $this->onMessage();
        $this->onClose();
        $this->start();
    }

    public function onOpen()
    {
        //  监听连接事件
        $this->server->on('open', function ($ws, $request) {
            $username = mb_substr($request->server['request_uri'], 1);
            self::$redis->hSet('relations', $username, $request->fd);
        });
    }

    public function onMessage()
    {
        $this->server->on('message', function ($ws, $frame) {
            //  获取当前连接的客户端
            $online = [];
            foreach ($this->server->connections as $k => $v) {
                array_push($online, $v);
            }
            $this->online_users = $online;

            $data = json_decode($frame->data, true);

            try {
                $send_to_fd = self::$redis->hGet('relations', $data['send_to_username']);
                $func = $this->news_type[$data['news_type']];
                $this->$func($send_to_fd, json_encode([
                    'send_by_id' => $data['send_by_id'],
                    'send_by_username' => $data['send_by_username'],
                    'send_by_user_avatar' => $data['send_by_user_avatar'] ? $data['send_by_user_avatar'] : '',
                    'send_to_id' => $data['send_to_id'],
                    'send_to_username' => $data['send_to_username'],
                    'content' => $data['content'],
                    'news_type' => $data['news_type']
                ]));
            } catch (ErrorException $e) {
                echo 111;
            }
        });
    }

    public function onClose()
    {
        $this->server->on('close', function ($ws, $fd) {
        });
    }

    public function start()
    {
        $this->server->start();
    }

    /**
     * 给好友请求接受者推送消息
     * @param $send_to $fd
     * @param $content
     */
    private function friendRequest($send_to, $content)
    {
        if (in_array($send_to, $this->online_users)) {
            $this->server->push($send_to, $content);
        }
    }

    /**
     * 聊天功能
     * @param $send_to $fd
     * @param $content
     */
    private function chatRecord($send_to, $content)
    {
        if (in_array($send_to, $this->online_users)) {
            $this->server->push($send_to, $content);
        }
    }
}

$ws = new Chat();
