<?php
declare (strict_types=1);

namespace app\controller;

use think\exception\ValidateException;
use think\Request;
use app\validate\Project as projectValidate;
use think\Response;
use app\model\Project as projectModel;
use app\checkToken as checkToken;

class Project extends Base
{
    /**
     * 获取项目数据
     *
     * @param Request $request
     * @return Response
     */
    public function getProject(Request $request)
    {
//        检查token
        $c = new checkToken();
        $token = $c->checkResult();
        if (!$token) {
            return $this->create([], 'invalid token', 401);
        }
//        接收数据
        $data = $request->get();
//        验证数据完整性
        try {
            validate(projectValidate::class)->scene('getProject')->check($data);
        } catch (ValidateException $exception) {
            return $this->create([], $exception->getError(), 406);
        }
//        查找项目数据：已完成
        $project1 = (new projectModel)->where(['uuid' => $data['uuid'], 'isFinished' => 1, 'isDelete' => 0])
            ->order('finish_time desc')
            ->page($this->page, 10)
            ->select();
//        查找项目数据：未完成
        $project0 = (new projectModel)->where(['uuid' => $data['uuid'], 'isFinished' => 0, 'isDelete' => 0])
            ->order('create_time desc')
            ->page($this->page, 10)
            ->select();
//        返回数据
        $data = [
            'finished' => $project1,
            'unFinished' => $project0
        ];
        return $this->create($data, 'request ok', 200);
    }

    /**
     * 新建项目
     *
     * @param Request $request
     * @return Response
     */
    public function newProject(Request $request)
    {
//        检查token
        $c = new checkToken();
        $token = $c->checkResult();
        if (!$token) {
            return $this->create([], 'invalid token', 401);
        }
//        接收数据
        $data = $request->post();
//        验证数据完整性
        try {
            validate(projectValidate::class)->scene('newProject')->check($data);
        } catch (ValidateException $exception) {
            return $this->create([], $exception->getError(), 406);
        }
//        分割字符串
        $split = explode(' ', $data['title']);
//        return $this->create($split, 'Request', 200);
//        生成listId
        $chars = md5(uniqid((string)mt_rand(), true));
        $listId = substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4)
            . substr($chars, 20, 12);
        $insert = [
            'uuid' => $this->uuid,
            'listId' => $listId,
            'title' => $split[0],
            'category' => array_key_exists('1', $split) ? $split[1] : null,
            'create_time' => date("Y-m-d H:i:s"),
        ];
//        启动事务
        (new projectModel)->startTrans();
        try {
            (new projectModel)->insert($insert);
//            提交
            (new projectModel)->commit();
            return $this->create(1, 'insert ok', 200);
        } catch (\Exception $exception) {
//            回滚
            (new projectModel)->rollback();
            return $this->create(0, 'insert failed:' . $exception->getMessage(), 500);
        }
    }

    /**
     * 更改项目状态
     *
     * @param Request $request
     * @return Response
     */
    public function modifyStatus(Request $request)
    {
//        检查token
        $c = new checkToken();
        $token = $c->checkResult();
        if (!$token) {
            return $this->create([], 'invalid token', 401);
        }
//        接收数据
        $data = $request->post();
//        验证数据完整性
        try {
            validate(projectValidate::class)->scene('modifyStatus')->check($data);
        } catch (ValidateException $exception) {
            return $this->create([], $exception->getError(), 406);
        }
//        启动事务
        (new projectModel)->startTrans();
        try {
//            更新数据
            (new projectModel)->where('listId', $data['listId'])->save([
                'isFinished' => $data['isFinish'],
                'finish_time' => $data['isFinish'] == 1 ? date("Y-m-d H:i:s") : null
            ]);
//            提交
            (new projectModel)->commit();
            return $this->create(1, 'update ok', 200);
        } catch (\Exception $exception) {
//            回滚
            (new projectModel)->rollback();
            return $this->create(0, 'update failed:' . $exception->getMessage(), 500);
        }
    }

    /**
     * 保存更新的资源
     *
     * @param Request $request
     * @param int $id
     * @return void
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
