<?php

header('Content-type:text/html;charset:utf-8');

/* php文件上传功能封装
 *
 * 实现文件上传（单个文件）
 * @param1 array $file，需要上传的文件信息
 * @param2 array $allow_type，允许上传的MINE类型
 * @param3 string $path，储存的路径
 * @param4 string &$error，如果出现错误的原因
 * @param5 array $allow_format = array()，允许上传的文件格式
 * @param6 int $max_size = 2000000，允许上传的最大值
 */

function upload_single($file, $allow_type, $path, &$error, $allow_format = array(), $max_size)
{
    // 判断文件是否有效：文件类型
    if (!is_array($file) && !isset($file['error'])) {
        // 文件无效
        $error = '不是一个有效的上传文件！';
        return false;
    }

    // 判断文件储存路径是否有效
    if (!is_dir($path)) {
        // 路径不存在
        $error = '文件储存路径不存在！';
        return false;
    }

    // 判断文件本身上传过程中是否有错误
    switch ($file['error']) {
        case 1:
        case 2:
            $error = '文件超出服务器允许大小！';
            return false;
        case 3:
            $error = '文件上传过程中出现问题！';
            return false;
        case 4:
            $error = '用户无选择要上传的文件！';
            return false;
        case 6:
        case 7:
            $error = '文件保存失败！';
            return false;
    }

    // 判断MIME类型
    if (!in_array($file['type'], $allow_type)) {
        // 该文件类型不允许上传
        $error = '该文件类型不允许上传!';
        return false;
    }

    // 判断文件格式：后缀名
    // 取出后缀
    $ext = ltrim(strrchr($file['name'], '.'), '.');
    if (!empty($allow_format) && !in_array($ext, $allow_format)) { //设定的 $allow_format不为空 并且 上传文件的后缀在$allow_format中存在
        // 不允许的文件后缀
        $error = '当前文件的格式不允许上传！';
        return false;
    }

    // 判断当前文件大小是否满足
    if ($file['size'] > $max_size) {
        // 文件过大
        $error = '上传的文件过大！限定文件大小为：' . $max_size / 1000000 . 'MB以下！';
        return false;
    }

    // 构造文件名字:类型_年月日+随机字符串.$ext
    $fullname = strstr($file['type'], '/', true) . date('YYYYmmdd');
    // 产生随机字符串
    for ($i = 0; $i < 4; $i++) {
        $fullname .= chr(mt_rand(65, 90));
    }
    // 拼凑后缀
    $fullname .= '.' . $ext;

    // 移动到指定目录
    if (!is_uploaded_file($file['tmp_name'])) {
        // 不是上传的文件
        $error = '不是上传的文件！';
        return false;
    }

    if (move_uploaded_file($file['tmp_name'], $path . '/' . $fullname)) {
        return $fullname;
    } else {
        // 移动失败
        $error = '文件上传失败!';
        return false;
    }
}

// 测试数据
$file = $_FILES['image'];
$path = 'uploads';
$allow_format = array('jpg', 'png', 'jpeg', 'gif');
$allow_type = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
$max_size = 8000000;

if ($filename = upload_single($file, $allow_type, $path, $error, $allow_format, $max_size)) {
    echo $filename;
} else {
    echo $error;
}
