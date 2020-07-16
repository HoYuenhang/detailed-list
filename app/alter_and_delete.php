<?php

// 删除项目：删除list

// 拿到前端传入的文本
$finish_id = isset($_GET['isFinished']) ? $_GET['isFinished'] : ''; //接收数据库中isFinished的值
$finish_content = isset($_GET['content']) ? $_GET['content'] : ''; //接收数据库中content的值
$delete_list = isset($_GET['id']) ? $_GET['id'] : ''; //接受删除按钮传进的id值 操作：删除

// 数据库操作
$finish_sql = "UPDATE project SET isFinished = 1 WHERE content = '{$finish_content}'";
$unfinish_sql = "UPDATE project SET isFinished = 0 WHERE content = '{$finish_content}'";
$delete_sql = "DELETE FROM project WHERE id = '{$delete_list}'";

// 数据修改入库
include_once 'database_login.php';

// 执行指令
if ($delete_list) {
    if (query($link, $delete_sql)) {
        echo '数据删除成功';
    } else {
        echo '数据删除失败';
    }
} else if ($finish_id == 1) {
    if (query($link, $unfinish_sql)) {
        echo '数据isFinished=0设置成功';
    } else {
        echo '数据isFinished=0设置失败';
    }
} else if ($$finish_id == 0) {
    if (query($link, $finish_sql)) {
        echo '数据isFinished=1设置成功';
    } else {
        echo '数据isFinished=1设置失败';
    }
}

// 跳转回主页
include_once 'utils.php';
back2index();