<?php

// 工具函数集

/*整理数据表
 *@param1 resource $link, 连接数据库资源
 */
function sort_list($link)
{
    $sort = "alter table project drop id";
    $sort2 = "alter table project add id int(11) primary key auto_increment first";
    query($link, $sort) && query($link, $sort2);
}

/*查看总行数
 *@param1 resource $link, 连接数据库资源
 */
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

/*跳转回主页
 *@param1 none
 */
function back2index()
{
    header("location: index.php");
}