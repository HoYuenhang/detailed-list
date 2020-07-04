<?php

// 删除项目：删除list
include_once 'utils.php';
// 登录数据库
include_once 'database_login.php';

// 拿到前端传入的文本
var_dump($_POST);
$finish_list = $_POST['finish']; //接收未完成列传进的数据 set isFinished=1 操作：未完成——>完成
$unfinish_list = $_POST['unfinish']; //接收完成列传进的数据 set isFinished=0 操作：完成——>未完成
$delete_list = $_POST['delete']; //接受删除按钮传进的数据 操作：删除

// 数据库操作
$finish_sql = "UPDATE project SET isFinished = 1 WHERE content = '{$finish_list}'";
$unfinish_sql = "UPDATE project SET isFinished = 0 WHERE content = '{$unfinish_list}'";
$delete_sql = "DELETE FROM project WHERE content = '{$delete_list}'";

// 执行指令
if ($delete_list) {
    if (query($link, $delete_sql)) {
        // 整理数据库列表id
        include_once 'utils.php';
        sort_list($link);
        echo '数据删除成功';
    } else {
        echo '数据删除失败';
    }
} else if ($unfinish_list) {
    if (query($link, $unfinish_sql)) {
        echo '数据isFinished=0设置成功';
    } else {
        echo '数据isFinished=0设置失败';
    }
} else if ($finish_list) {
    if (query($link, $finish_sql)) {
        echo '数据isFinished=1设置成功';
    } else {
        echo '数据isFinished=1设置失败';
    }
}

// 跳转回主页
back2index();