<?php

// 登陆界面
// 从前端接收数据
$admin = isset($_POST['account']) ? trim($_POST['account']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

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
$res = mysqli_fetch_assoc(query($link, $sql));

// 登录检查
$_SESSION["admin"] = null;
if (($_POST['account'] == null) || ($_POST['password'] == null)) { //登录时两个输入框均为空
    header('Refresh:3;url = ../html/login.html');
    die('账号或密码错误！即将返回登陆界面。');
}
if (isset($res['admin']) && ($_POST['account'] == $res['admin']) && ($_POST['password'] == $res['password'])) { //登录密码正确时
    $_SESSION["admin"] = $res['admin'];
    echo "<script>location.href='index.php'</script>";
} elseif ($admin == $res['admin'] && $res['password'] == null) {
    echo "账号或密码错误！即将返回登陆界面。";
} elseif ($res == null) {
    $sql_register = "INSERT INTO admin VALUES(NULL,'{$admin}','{$password}')";
    $res_register = mysqli_fetch_assoc(query($link, $sql_register));
    echo "<script>location.href='index.php'</script>";
} else { //其他情况
    header('Refresh:3;url = ../html/login.html');
    die('账号或密码错误！即将返回登陆界面。');
}