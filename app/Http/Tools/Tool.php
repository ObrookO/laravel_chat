<?php
/**
 * Created by PhpStorm.
 * User: wecash
 * Date: 2018/8/20
 * Time: 下午9:45
 */

namespace App\Http\Tools;


class Tool
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

    /**
     * 上传图片
     * @param $file $request->file('xxx')
     * @param $store_path
     * @param float|int $max_size
     * @param array $allow_ext
     * @return string
     */
    public function uploadImg($file, $store_path, $allow_ext = ['jpeg', 'jpg', 'png', 'gif'], $max_size = 2 * 1024 * 1024)
    {
        if (!$file) {
            return json_encode(['code' => 400, 'message' => '请上传图片']);
        }
        if (empty($allow_ext) || !is_array($allow_ext)) {
            return json_encode(['code' => 401, 'message' => '参数错误']);
        }

        $size = $file->getSize();
        $ext = $file->getClientOriginalExtension();
        if (!in_array($ext, $allow_ext)) {
            return json_encode(['code' => 402, 'message' => '图片格式错误']);
        }
        if ($size > $max_size || !$size) {
            return json_encode(['code' => 403, 'message' => '图片最大为2M']);
        }

        $path = $file->store($store_path);
        if ($path) {
            return json_encode(['code' => 200, 'message' => 'OK', 'data' => '/upload/' . $path]);
        } else {
            return json_encode(['code' => 404, 'message' => '图片上传失败']);
        }
    }
}