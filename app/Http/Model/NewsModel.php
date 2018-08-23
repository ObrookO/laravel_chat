<?php
/**
 * Created by PhpStorm.
 * User: wecash
 * Date: 2018/8/18
 * Time: 下午9:06
 */

namespace App\Http\Model;

use DB;

class NewsModel
{
    public function insertNews($data)
    {
        return DB::table('news')->insertGetId($data);
    }

    public function getNews($where, $column = ['*'], $count = false)
    {
        if ($column != ['*']) {
            return DB::table('news')->where($where)->orderBy('created_at', 'desc')->pluck(implode(',', $column));
        }

        if ($count) {
            return DB::table('news')->where($where)->count();
        }
        return DB::table('news')->where($where)->orderBy('created_at', 'desc')->get();
    }

    public function updateNews($where, $update)
    {
        if (array_key_exists('in', $where)) {
            $key = array_keys($where['in'])[0];
            return DB::table('news')->whereIn($key, $where['in'][$key])->update($update);
        }
        return DB::table('news')->where($where)->update($update);
    }
}