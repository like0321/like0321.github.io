<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Controller;
use think\Db;

class Index extends AdminBase
{
    /**
     * 后台首页
     * @return \think\response\View
     */
    public function index()
    {

        $version = Db::query("select version() as ver");

        $config = [
            'url' => $_SERVER['HTTP_HOST'],
            'server_os' => PHP_OS,//服务器操作系统
            'server_port' => $_SERVER['SERVER_PORT'],//服务器端口
            'server_soft' => $_SERVER['SERVER_SOFTWARE'],//服务器操作环境
            'php_version' => PHP_VERSION,//php版本
            'mysql_version' => $version[0]['ver'],//MySQL版本
            'max_upload_size' => ini_get('upload_max_filesize') //最大上传限制
        ];

        return view('',compact('config'));

    }
}
