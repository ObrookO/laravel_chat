<?php
/**
 * Created by PhpStorm.
 * User: wecash
 * Date: 2018/8/24
 * Time: 下午1:49
 */

namespace App\Http\Model;

use DB;

class ChatRecordModel
{
    /**
     * 插入一条聊天记录
     * @param $data
     * @return mixed
     */
    public function newChatRecord($data)
    {
        return DB::table('chat_records')->insertGetId($data);
    }

    /**
     * 获取聊天记录
     * @param $news_from
     * @param $news_to
     * @return mixed
     */
    public function getChatRecords($news_from, $news_to)
    {
        return DB::table('chat_records')
            ->where([['news_from', '=', $news_from], ['news_to', '=', $news_to]])
            ->orWhere([['news_from', '=', $news_to], ['news_to', '=', $news_from]])
            ->get();
    }
}