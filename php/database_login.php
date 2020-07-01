<?php
header('Content-type:text/html;charset:utf-8');

// 做数据库初始化

// 连接认证
$link = mysqli_connect('localhost:3306', 'root', 'H*****319');
if (!$link) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// 设定字符集
mysqli_query($link, 'set names utf8');

// 选择数据库
mysqli_query($link, 'use detailed_list');

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
