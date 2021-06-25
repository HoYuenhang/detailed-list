<?php
declare (strict_types=1);

namespace app\validate;

use think\Validate;

class Project extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'uuid' => 'require',
        'token' => 'require',
        'title' => 'require',
        'content' => 'require',
        'listId' => 'require',
        'isFinish' => 'require'
    ];

    /**
     * 定义场景
     *
     * @var array
     */
    protected $scene = [
        'checkToken' => ['uuid', 'token'],
        'getProject' => ['uuid'],
        'newProject' => ['title'],
        'modifyStatus' => ['listId', 'isFinish'],
        'doDelete' => ['listId']
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'uuid' => 'no uuid',
        'token' => 'no token',
        'title' => 'no title',
        'content' => 'no content',
        'listId' => 'no listId',
        'isFinish' => 'no isFinish'
    ];
}
