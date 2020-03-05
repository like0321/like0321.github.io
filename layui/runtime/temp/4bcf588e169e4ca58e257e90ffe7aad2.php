<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:90:"D:\phpstudy_pro\WWW\webserver\tp5.0\public/../application/admin\view\auth_group\index.html";i:1583251558;s:68:"D:\phpstudy_pro\WWW\webserver\tp5.0\application\admin\view\base.html";i:1583417065;}*/ ?>
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
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">权限组</li>
            <li><a href="<?php echo url('add'); ?>">添加权限组</a></li>
        </ul>
        <div class="layui-tab-content">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list as $v): ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['title']; ?></td>
                    <td><img src="/static/images/<?php if($v['status']==1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('auth_group','id','<?php echo $v['id']; ?>','status',this)"></td>
                    <td>
                        <a href="<?php echo url('auth',['id'=>$v['id']]); ?>" class="layui-btn layui-btn-xs"><i class="layui-icon layui-icon-auz"></i></a>
                        <a href="<?php echo url('edit',['id'=>$v['id']]); ?>" class="layui-btn layui-btn-xs layui-btn-normal"><i class="layui-icon layui-icon-edit"></i></a>
                        <a href="<?php echo url('delete',['id'=>$v['id']]); ?>" class="layui-btn layui-btn-xs layui-btn-danger ajax-delete"><i class="layui-icon layui-icon-delete"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
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