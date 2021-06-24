<?php

namespace app\controller;

use think\facade\Request;
use think\facade\Config;
use think\Response;

/**
 * Class Base
 * @package app\controller
 */
abstract class Base
{
    /**
     * @var int
     */
    protected $page;
    /**
     * @var int
     */
    protected $pageSize;
    /**
     * @var string
     */
    protected $uuid;
    /**
     * @var string
     */
    protected $token;

    /**
     * Base constructor.
     */
    public function __construct()
    {
//        获取分页
        $this->page = (int)Request::param('page');
//        获取条数
        $this->pageSize = (int)Request::param('page_size', Config::get('app.page_size'));
//        获取token
        $this->uuid = Request::header('uuid');
//        获取token
        $this->token = Request::header('token');
    }

    /**
     * @param $data
     * @param string $msg
     * @param int $code
     * @param string $type
     * @return Response
     */
    protected function create($data, $msg = '', $code = 200, $type = 'json'): Response
    {
        // 标准api结构生成
        $result = [
            // 状态码
            'code' => $code,
            // 消息
            'msg' => $msg,
            // 数据
            'data' => $data,
        ];
        // 返回api接口
        return Response::create($result, $type);
    }

    /**
     * @param $name
     * @param $arguments
     * @return Response
     */
    public function __call($name, $arguments)
    {
        // 404,方法不存在
        return $this->create([], '资源不存在', 404);
    }
}
