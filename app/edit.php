<?php

// 数据编辑表单

// 中文处理
header('Content-type:text/html;charset=utf-8');

// 获取数据
$id = isset($_GET['id']) ? (integer) $_GET['id'] : 0; //接收数据库中id的值
// var_dump($_GET);
// 安全验证
if ($id == 0) {
    header('Refresh:3;url=index.php');
    echo '当前要编辑的数据不存在。';
    exit();
}

// 获取当前id对应的信息
include_once 'database_login.php';
$sql = "SELECT * FROM project WHERE id = {$id}";
$res = query($link, $sql);
$res_array = mysqli_fetch_assoc($res);
// var_dump($res_array);

// 包含html模板
include_once '../html/edit.html';