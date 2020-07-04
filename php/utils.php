<?php

// 工具函数集

// 登录数据库
include_once 'database_login.php';

// 整理数据表
function sort_list($link)
{
    $sort = "alter table project drop id";
    $sort2 = "alter table project add id int(11) primary key auto_increment first";
    query($link, $sort) && query($link, $sort2);
}

// 查看总行数
function count_rows($link)
{
    $sql = 'select * from project';
    $res = query($link, $sql);
    // 检查出错原因
    if (!$res) {
        printf("Error: %s\n", mysqli_error($link));
        exit();
    }
// var_dump($res);
    $rows = mysqli_num_rows($res);
// echo $rows;
    return $rows;
}

// 跳转回主页
function back2index()
{
    $url = '../index.php';
    header("location: $url");

}