<?php
/**
 * Created by PhpStorm.
 * User: wecash
 * Date: 2018/8/20
 * Time: 下午9:45
 */

namespace App\Http\Tools;


class Common
{
    /**
     * 把时间戳转为xx秒前/xx分钟前
     * @param $time
     * @return
     */
    public function convertTime($time)
    {
        $sub = time() - $time;
        if ($sub >= 31104000) { // N年前
            $num = (int)($sub / 31104000);
            return $num . '年前';
        }
        if ($sub >= 2592000) { // N月前
            $num = (int)($sub / 2592000);
            return $num . '月前';
        }
        if ($sub >= 86400) { // N天前
            $num = (int)($sub / 86400);
            return $num . '天前';
        }
        if ($sub >= 3600) { // N小时前
            $num = (int)($sub / 3600);
            return $num . '小时前';
        }
        if ($sub >= 60) { // N分钟前
            $num = (int)($sub / 60);
            return $num . '分钟前';
        }
        return "刚刚";
    }
}