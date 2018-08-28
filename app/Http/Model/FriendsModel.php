<?php
/**
 * Created by PhpStorm.
 * User: wecash
 * Date: 2018/8/20
 * Time: 下午8:46
 */

namespace App\Http\Model;

use DB;

class FriendsModel
{

    /**
     * 获取好友
     * @param $where
     * @return mixed
     */
    public function getFriends($where)
    {
        return DB::table('friends')
            ->leftjoin('users', 'user2', '=', 'users.id')
            ->where($where)
            ->select('friends.*', 'users.username', 'users.motto', 'users.avatar')
            ->get();
    }

    /**插入一条好友记录
     * @param $data
     * @return mixed
     */
    public function newFriend($data)
    {
        return DB::table('friends')->insertGetId($data);
    }

    /**
     * 从friends表中删除一条记录
     * @param $where
     * @return mixed
     */
    public function delRecord($where)
    {
        return DB::table('friends')->where($where)->delete();
    }
}