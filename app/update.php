<?php

// 更新数据到数据库

// 中文处理
header('Content-type:text/html;charset=utf-8');

// 接受数据并验证
$id = isset($_POST['id']) ? (integer) $_POST['id'] : 0; //0不会存在
$content = isset($_POST['edit_project']) ? trim($_POST['edit_project']) : '';

// 数据合法性验证
// 标题和内容均不能为空
if (empty($id) || empty($content)) {
    //提示同时回到提交页面
    header('Refresh:3;url=index.php'); //header前不能有输出
    // 阻止脚本进行
    exit('标题或内容都不能为空！');
}

// 分割新建内容与标签
$explore_array = array();
$explore_array = explode(" ", $content);

// 组织sql更新到数据库
include_once 'database_login.php';

$new_project_name = trim($explore_array[0]);
$sql = "UPDATE project SET content = '{$new_project_name}' WHERE id = '{$id}'";
query($link, $sql);

// 数据安全性与执行
$count = count($explore_array); // 统计接收到的数据条数：更改与标签
if ($count == 1) {
    $sql2 = "UPDATE project SET label = NULL WHERE content = '{$new_project_name}'";
    query($link, $sql2);
} else if ($count > 1) {
    $new_project_label = trim($explore_array[1]);
    $sql2 = "update project set label = '{$new_project_label}' where id = '{$id}'";
    query($link, $sql2);
}

// 提示
header('Refresh:3;url = index.php');
echo '当前信息更新成功！即将返回主页面';