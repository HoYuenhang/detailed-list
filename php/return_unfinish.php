<?php

// 登录数据库
include_once 'database_login.php';

// 返回数据给前端

// 查看总行数
include_once 'utils.php';
$rows = count_rows($link);

for ($i = $rows; $i >= 1; $i--) {
    // 判断是否完成
    $sql_finished = "select isFinished,content from project where id = '{$i}'";
    $res_finished = mysqli_query($link, $sql_finished);
    $array_finished = mysqli_fetch_array($res_finished, MYSQLI_ASSOC);
    // var_dump($array_finished);

    if ($array_finished['isFinished'] == 0) { //未完成
        $html1 = "<li class='list-item list-item-unselect'><i class='layui-icon layui-icon-star'></i>{$array_finished['content']}
        <button style='float:right;margin-right:5px;border-radius:10px;' type='submit' name='delete' value='{$array_finished['content']}' class='del-btn layui-btn layui-btn-primary layui-btn-xs'>删除</button>
        <button style='float:right;margin-right:5px;border-radius:10px;' type='submit' name='finish' value='{$array_finished['content']}' class='finish-btn layui-btn layui-btn-primary layui-btn-xs'>完成</button></li>";
        echo $html1;
    }
    // echo $array['content'];
}

// 遍历
// $sql2 = "select * from project where id = '{$i}'";
// $res2 = mysqli_query($link, $sql2);
// $array = mysqli_fetch_array($res2, MYSQLI_ASSOC);
// 检查出错原因
// if (!$res2) {
//     printf("Error: %s\n", mysqli_error($link));
//     exit();
// }
// print_r(json_encode(mysqli_fetch_array($res2, MYSQLI_ASSOC)));
// var_dump($array);
