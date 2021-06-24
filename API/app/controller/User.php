<?php
declare (strict_types=1);

namespace app\controller;

use app\common;
use think\exception\ValidateException;
use think\Request;
use app\model\User as UserModel;
use think\Response;
use app\validate\User as UserValidate;

class User extends Base
{
    /**
     * 用户登录
     *
     * @param Request $request
     * @return Response
     */
    public function Login(Request $request)
    {
//        接收数据
        $data = $request->post();
//        验证数据完整性
        try {
            validate(UserValidate::class)->scene('login')->check($data);
        } catch (ValidateException $exception) {
            return $this->create([], $exception->getError(), 406);
        }
//        查找用户信息
        $user = (new UserModel)->where('username', $data['username'])->find();
//        无信息：未注册
        if (!$user) {
            return $this->create([], 'no user in database', 400);
        }
//        有信息
//        密码错误
        if ($user['password'] != $data['password']) {
            return $this->create([], 'invalid username or password', 401);
        }
//        密码正确
//        特权
        if ($user['uuid'] == '69d3ccb1-486f-4756-a815-b66f6dc44b9d') {
            return $this->create($user, 'login ok', 200);
        }
//        生成token
        $c = new common();
        $token = $c->gen_token($data['username']);
//        生成过期时间：7天
        $expire_time = time() + 7 * 86400;
//        更新数据库中的token与过期时间
//        启动事务
        (new UserModel)->startTrans();
//        数据入库
        try {
            (new UserModel)->where(['username' => $data['username'], 'password' => $data['password']])
                ->update(['token' => $token, 'expire_time' => $expire_time]);
            (new UserModel)->commit();
            $user['token'] = $token;
            return $this->create($user, 'login ok', 200);
        } catch (\Exception $exception) {
            (new UserModel)->rollback();
            return $this->create([], 'login failed:' . $exception->getMessage(), 500);
        }

    }

    /**
     * 免验证登录
     *
     * @param Request $request
     * @return Response
     */
    public function freeLogin(Request $request)
    {
//        接收数据
        $data = $request->post();
//        验证数据完整性
        try {
            validate(UserValidate::class)->scene('freeLogin')->check($data);
        } catch (ValidateException $exception) {
            return $this->create([], $exception->getError(), 406);
        }
//        查找用户信息
        $find = (new UserModel)->where('uuid', $data['uuid'])->find();
//        无用户信息
        if (!$find) {
            return $this->create([], 'login failed', 400);
        }
//        检查token是否正确
        if ($data['token'] != $find['token']) {
            return $this->create($find, 'login failed', 401);
        }
//        检查是否过期
        if (time() >= (int)$find['expire_time']) {
            return $this->create($find, 'login failed', 401);
        }
//        登录成功
        return $this->create($find, 'login ok', 200);
    }

    /**
     * 用户注册
     *
     * @param Request $request
     * @return Response
     */
    public function userRegister(Request $request)
    {
//        接收数据
        $data = $request->post();
//        验证数据完整性
        try {
            validate(UserValidate::class)->scene('userRegister')->check($data);
        } catch (ValidateException $exception) {
            return $this->create([], $exception->getError(), 406);
        }
//        查找是否有重复信息：用户名，手机号
        if ((new UserModel)->where('username', $data['username'])->find()) {
            return $this->create([], 'username in database', 4001);
        }
//        if ((new UserModel)->where('phone_number', $data['phone_number'])->find()) {
//            return $this->create([], 'phone number in database', 4002);
//        }
//        生成uuid
        $c = new common();
        $data['uuid'] = $c->gen_uuid();
        $data['create_time'] = date("Y-m-d H:i:s");
//        数据入库
//        启动事务
        (new UserModel)->startTrans();
        try {
            (new UserModel)->insert($data);
//            提交
            (new UserModel)->commit();
            return $this->create(1, 'register ok', 200);
        } catch (\Exception $exception) {
//            回滚
            (new UserModel)->rollback();
            return $this->create(0, 'register failed:' . $exception->getMessage(), 500);
        }
    }

    /**
     * 保存更新的资源
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        //
    }
}
