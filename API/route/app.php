<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Headers:uuid, token, Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With');

header('Access-Control-Allow-Methods: GET, POST');

header('Access-Control-Max-Age: 1728000');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

//->allowCrossDomain([
//    'Access-Control-Allow-Origin' => '*',
//])

//用户登录
Route::post('login', 'User/Login');
//用户注册
Route::post('userRegister', 'User/userRegister');
//用户免验证登录
Route::post('freeLogin', 'User/freeLogin');
//获取项目数据
Route::get('getProject', 'Project/getProject');
//获取项目数据
Route::post('newProject', 'Project/newProject');
//更改项目状态
Route::post('modifyStatus', 'Project/modifyStatus');
//删除项目
Route::post('doDelete', 'Project/doDelete');
//删除项目
Route::post('doModify', 'Project/doModify');
//获取某分类项目数据
Route::get('getCategoryProject', 'Project/getCategoryProject');