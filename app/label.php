<?php

// 标签显示页面

$label = $_GET['label'];
// var_dump($label);

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
$sql = "select * from project";
$res = query($link, $sql);
for ($i = 0; $i < $rows; $i++) {
    $res_array[] = mysqli_fetch_assoc($res);
}

// 判断是否完成：分类
for ($i = 0; $i < $rows; $i++) {
    if ($res_array[$i]['isFinished'] == 0) { //未完成
        if ($res_array[$i]['label'] == $label) {
            $array_unfinish[] = $res_array[$i];
        }
    } elseif ($res_array[$i]['isFinished'] == 1) { //已完成
        if ($res_array[$i]['label'] == $label) {
            $array_finished[] = $res_array[$i];
        }
    }
}

// 引入html模板
include_once '../html/label.html';