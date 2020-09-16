<?php

// 标签显示页面

$label = trim($_GET['label']);

// 登录数据库
include_once 'database_login.php';

// 启用session
session_start();
// 检查session
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : '';

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
        if ($res_array[$i]['label'] == $label) { // 从所有数据中筛选出用户所点击的标签
            $array_unfinish[] = $res_array[$i];
        }
    } elseif ($res_array[$i]['isFinished'] == 1) { //已完成
        if ($res_array[$i]['label'] == $label) { // 从所有数据中筛选出用户所点击的标签,too
            $array_finished[] = $res_array[$i];
        }
    }
}

// 引入html模板
include_once '../html/label.html';