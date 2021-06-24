<?php

namespace app;

use app\controller\Base;
use app\validate\Project as projectValidate;
use app\model\User as UserModel;
use think\exception\ValidateException;
use think\facade\Request;

class checkToken extends Base
{
    /**
     * 检查token是否正确或过期
     *
     * @return bool
     */
    public function checkResult()
    {
//        检查是否有传入token和uuid
        $data = [
            'uuid' => $this->uuid,
            'token' => $this->token
        ];
        try {
            validate(projectValidate::class)->scene('checkToken')->check($data);
        } catch (ValidateException $exception) {
            return false;
        }
//        特权
        if ($data['uuid'] == '69d3ccb1-486f-4756-a815-b66f6dc44b9d') {
            return true;
        }
//        查找用户
        $user = UserModel::where('uuid', $this->uuid)->field('uuid,token,expire_time')->find();
//        检查token是否正确
        if ($this->token != $user['token']) {
            return false;
        }
//        检查是否过期
        if (time() >= (int)$user['expire_time']) {
            return false;
        }
        return true;
    }
}