<?php

// 主页面文件:输出数据库中内容

// 登录数据库
include_once 'database_login.php';

// 启用session
session_start();
// 检查session
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : '';
// echo $admin;
// var_dump($_SESSION);

if ($admin == null) {
    echo "<center style='font-size:16px;'><br>请登录后再操作！</center>";
}

// 输出未完成
$res_array = array(); //装总结果
$array_unfinish = array(); //装未完成
$array_finished = array(); //装已完成

// 遍历数据库：返回所有结果
$sql = "select * from project where admin = '{$admin}'";
$res = query($link, $sql);
$rows = mysqli_num_rows($res); //查看总行数
for ($i = 0; $i < $rows; $i++) {
    $res_array[] = mysqli_fetch_assoc($res);
}

// 判断是否完成：分类
for ($i = 0; $i < $rows; $i++) {
    if ($res_array[$i]['isFinished'] == 0) { //未完成
        $array_unfinish[] = $res_array[$i];
    } elseif ($res_array[$i]['isFinished'] == 1) { //已完成
        $array_finished[] = $res_array[$i];
    }
}
// var_dump($array_unfinish);

// 引入html模板
include_once '../html/index.html';
