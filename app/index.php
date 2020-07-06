<?php

// 主页面文件:输出数据库中内容

// 登录数据库
include_once 'database_login.php';

// 查看总行数
include_once 'utils.php';
$rows = count_rows($link);

// 输出未完成
$res_array = array(); //装总结果
$array_unfinish = array(); //装未完成
$array_finished = array(); //装已完成

// 遍历数据库：返回所有结果
for ($i = $rows; $i >= 1; $i--) {
    $sql = "select isFinished,content from project where id = '{$i}'";
    $res = query($link, $sql);
    $res_array[] = mysqli_fetch_assoc($res);
}

// 判断是否完成：分类
for ($i = $rows - 1; $i >= 0; $i--) {
    if ($res_array[$i]['isFinished'] == 0) { //未完成
        $array_unfinish[] = $res_array[$i]['content'];
    } elseif ($res_array[$i]['isFinished'] == 1) { //已完成
        $array_finished[] = $res_array[$i]['content'];
    }
}

// 引入html模板
include_once '../html/index.html';