<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"D:\phpstudy_pro\WWW\webserver\tp5.0\public/../application/admin\view\admin\edit.html";i:1583420632;s:68:"D:\phpstudy_pro\WWW\webserver\tp5.0\application\admin\view\base.html";i:1583417065;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理系统</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/admin.css">
    
    <style>
        #upload_images img{
            width: 150px;
        }
    </style>

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
            <li><a href="<?php echo url('index'); ?>">管理员</a></li>
            <li class="layui-this">编辑管理员</li>
        </ul>
        <div class="layui-tab-content">
            <form action="<?php echo url('edit'); ?>" class="layui-form form-container" method="post">
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" required lay-verify="required" class="layui-input" placeholder="请输入用户名" name="username" value="<?php echo $info['username']; ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" class="layui-input" placeholder="（选填）如不修改则留空" name="password">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">重复密码</label>
                    <div class="layui-input-block">
                        <input type="password" class="layui-input" placeholder="（选填）如不修改则留空" name="confirm_password">
                    </div>
                </div>
                <?php if($info['id'] != 1): ?>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">权限组</label>
                    <div class="layui-input-block">
                        <select name="group_id" id="" lay-verify="required">
                            <?php foreach(db('auth_group')->where('status',1)->select() as $v): ?>
                            <option value="<?php echo $v['id']; ?>" <?php if($info['group_id']==$v['id']): ?>selected<?php endif; ?>><?php echo $v['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">头像</label>
                    <div class="layui-input-inline" style="display: flex">
                        <input type="text" id="head_image" name="head_img" class="layui-input" value="<?php echo $info['head_img']; ?>" lay-verify="required" style="width: 200px; margin-right: 30px">
                        <button type="button" class="layui-btn " id="upload">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                    </div>
                </div>
                <div class="layui-form-item" id="upload_images">
                    <label for="" class="layui-form-label"></label>
                    <span><img src="<?php echo $info['head_img']; ?>" alt=""></span>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                        <button class="layui-btn" lay-submit lay-filter="*">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>




<script src="/static/js/jquery.min.js"></script>
<script src="/static/layui/layui.all.js"></script>
<script src="/static/js/admin.js"></script>



<script>
    var upload = layui.upload;

    //执行实例
    var uploadInst = upload.render({
        elem: '#upload' //绑定元素
        ,url: "<?php echo url('admin/login/upload',['filename'=>'admin']); ?>" //上传接口
        ,done: function(res){
            if(res.error==0){

                $("#head_image").val(res.url);
                $("#upload_images span").remove();
                $("#upload_images").append("<span><img src=\""+res.url+"\" alt=\"\"></span>")
            }else {
                layer.msg(res.msg)
            }
        }
    });

</script>


</body>

</html>