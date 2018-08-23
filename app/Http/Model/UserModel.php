<?php
/**
 * Created by PhpStorm.
 * User: wecash
 * Date: 2018/8/14
 * Time: 下午1:52
 */

namespace App\Http\Model;

use DB;

class UserModel
{
    public function getUserInfo($where)
    {
        return DB::table('users')->where($where)->first();
    }

    public function newUser($data)
    {
        return DB::table('users')->insertGetId($data);
    }
}