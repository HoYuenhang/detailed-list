<?php

// php操作mysql公共文件

// 中文处理
header('Content-type:text/html;charset=utf-8');

// 连接初始化
$link = mysqli_connect('localhost:3306', 'root', 'H*****319') or die('数据库连接失败！');

// 封装mysql语法错误函数
/*
@param1 resource $link, 连接数据库资源
@param2 string $sql, 要执行的sql语句
@return $res, 正确执行完返回的结果
 */
function query($link, $sql)
{
    // 执行sql
    $res = mysqli_query($link, $sql);
    // 处理可能存在的错误
    if (!$res) {
        echo 'SQL指令执行出错，错误编号为：' . mysqli_errno($link) . '<br>';
        echo 'SQL指令执行出错，错误信息是：' . mysqli_error($link) . '<br>';
        // 中止代码
        exit();
    }
    //返回结果
    return $res;
}

// 字符集处理
query($link, 'set names utf8');

// 选择数据库
query($link, 'use detailed_list');

// 数据库相关信息
// CREATE DATABASE webnote charset=utf8;
// CREATE TABLE new_project(
//     id int PRIMARY KEY auto_increment,
//     isFinished TINYINT NOT NULL COMMENT '是否完成',
//     content text COMMENT '内容',
//     pub_time INT NOT NULL COMMENT '时间戳'
// )charset utf8;
// 注意：
// 关于是否完成，没完成为0，完成为1。插入时均为0。
// 关于时间戳，系统自动生成
