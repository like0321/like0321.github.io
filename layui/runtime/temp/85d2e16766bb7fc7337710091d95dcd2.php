<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"D:\phpstudy_pro\WWW\webserver\tp5.0\public/../application/admin\view\index\index.html";i:1582810542;s:68:"D:\phpstudy_pro\WWW\webserver\tp5.0\application\admin\view\base.html";i:1583417065;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理系统</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/admin.css">
    
</head>


<body>

<div class="layui-layout layui-layout-admin">

    <!-- 头部 -->
    <div class="layui-header header">
        <div class="layui-logo">后台管理系统</div>
        <ul class="layui-nav layui-layout-left">
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item"><a href="/" target="_blank">前台首页</a></li>
            <li class="layui-nav-item"><a href="" data-url="<?php echo url('system/clear'); ?>" id="clear-cache">清除缓存</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="<?php echo \think\Session::get('admin_user.head_img'); ?>" class="layui-nav-img">
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo \think\Session::get('admin_user.username'); ?></a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('system/changepassword'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('login/logout'); ?>">登出</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!-- 侧边栏 -->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item"><a href="">管理菜单</a></li>
                <li class="layui-nav-item">
                    <a href="/admin/index/index.html"><i class="fa fa-home"></i> 网站信息</a>
                </li>

                <?php foreach($menu as $v): if(isset($v['children'])): ?>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="<?php echo $v['icon']; ?>"></i><?php echo $v['title']; ?></a>
                    <dl class="layui-nav-child">
                        <?php foreach($v['children'] as $cv): ?>
                        <dd><a href="<?php echo url($cv['name']); ?>"><?php echo $cv['title']; ?></a></dd>
                        <?php endforeach; ?>
                    </dl>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo url($v['name']); ?>"><i class="<?php echo $v['icon']; ?>"></i><?php echo $v['title']; ?></a>
                </li>
                <?php endif; endforeach; ?>


            </ul>
        </div>
    </div>


    <!-- 主体 -->
    

<div class="layui-body">
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">网站概览</li>
        </ul>
        <div class="layui-tab-content">
            <table class="layui-table">
                <tr>
                    <td style="width: 400px">网站域名</td>
                    <td><?php echo $config['url']; ?></td>
                </tr>
                <tr>
                    <td>服务器操作系统</td>
                    <td><?php echo $config['server_os']; ?></td>
                </tr>
                <tr>
                    <td>服务器端口</td>
                    <td><?php echo $config['server_port']; ?></td>
                </tr>
                <tr>
                    <td>服务器环境</td>
                    <td><?php echo $config['server_soft']; ?></td>
                </tr>
                <tr>
                    <td>PHP版本</td>
                    <td><?php echo $config['php_version']; ?></td>
                </tr>
                <tr>
                    <td>MySQL版本</td>
                    <td><?php echo $config['mysql_version']; ?></td>
                </tr>
                <tr>
                    <td>最大上传限制</td>
                    <td><?php echo $config['max_upload_size']; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

</div>




<script src="/static/js/jquery.min.js"></script>
<script src="/static/layui/layui.all.js"></script>
<script src="/static/js/admin.js"></script>




</body>

</html>