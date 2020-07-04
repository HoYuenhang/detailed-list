<?php

// 插入项目：新建list

header('Content-type:text/html;charset:utf-8');

// 登录数据库
include_once 'database_login.php';

//拿到前端传入的文本
var_dump($_POST);
$new_project = $_POST['new_project'];

// 插入数据
$public_time = time();
$sql = "INSERT INTO project VALUES(NULL,0,'{$new_project}',{$public_time})";

// 检查是否有相同数据
$check_sql = query($link, "SELECT * FROM project WHERE content = '{$new_project}'");
$check_finished = mysqli_fetch_array($check_sql, MYSQLI_ASSOC);
// var_dump($check_finished);

// 执行指令
if ($new_project == $check_finished['content']) {
    echo '数据库中已有此条数据';
} else {
    if ($new_project && query($link, $sql)) {
        echo '数据插入成功';
    } else {
        echo '数据插入失败';
    }
}

// 跳转回主页
$url = '../index.php';
if ($url) {
    header("location: $url");
}
