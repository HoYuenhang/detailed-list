<?php

// 登陆界面

// 从前端接收数据
$admin = isset($_POST['account']) ? trim($_POST['account']) : '';
$password = isset($_POST['password']) ? md5(trim($_POST['password'])) : '';

// 启用session
session_start();

if ($_POST['btn'] == "login_unres") {
    echo "<script>location.href='../html/login.html'</script>";
}
if ($_POST['btn'] == "logout") {
    unset($_SESSION['admin']);
    echo "<script>location.href='../html/login.html'</script>";
}

// 数据库操作
include_once 'database_login.php';
$sql = "SELECT * FROM admin WHERE admin = '{$admin}'";

// 登录检查
$_SESSION["admin"] = null;
if (!$admin || !$password) { //登录时两个输入框有一个为空
    header('Refresh:3;url = ../html/login.html');
    die('请输入正确的账号和密码！即将返回登陆界面。');
}
if ($admin) {
    $res = mysqli_fetch_assoc(query($link, $sql));
    // var_dump($res);
}
//登录密码正确时
if (isset($res['admin']) && ($password == $res['password'])) {
    $_SESSION["admin"] = $res['admin'];
    echo "<script>location.href='index.php'</script>";
}
// 数据库中没有找到该用户信息，自动注册
if ($res == null) {
    $sql_register = "INSERT INTO admin VALUES(NULL,'{$admin}','{$password}')";
    $res_register = mysqli_fetch_assoc(query($link, $sql_register));
    $_SESSION['admin'] = $admin;
    echo "<script>location.href='index.php'</script>";
} else { //其他情况
    header('Refresh:3;url = ../html/login.html');
    die('账号或密码错误！即将返回登陆界面。');
}
