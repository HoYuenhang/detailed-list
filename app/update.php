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

// 组织sql更新到数据库
include_once 'database_login.php';
$sql = "update project set content = '{$content}' where id = '{$id}'";
query($link, $sql);

// 提示
header('Refresh:3;url = index.php');
echo '当前新闻更新成功！即将返回主页面';