<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"D:\phpstudy_pro\WWW\webserver\tp5.0\public/../application/admin\view\auth_group\auth.html";i:1583422343;s:68:"D:\phpstudy_pro\WWW\webserver\tp5.0\application\admin\view\base.html";i:1583417065;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理系统</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/admin.css">
    
<link rel="stylesheet" href="/static/layui_ext/dtree/dtree.css">
<link rel="stylesheet" href="/static/layui_ext/dtree/font/dtreefont.css">

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
            <li><a href="<?php echo url('index'); ?>">权限组</a></li>
            <li class="layui-this">授权</li>
        </ul>
        <div class="layui-tab-content">
            <ul id="demoTree" class="dtree" data-id="0"></ul>
        </div>
       <div class="layui-input-block">
           <input type="hidden" value="<?php echo \think\Request::instance()->param('id'); ?>" id="group_id">
           <button type="button" class="layui-btn" id="auth-btn">授权</button>
       </div>
    </div>
</div>

</div>




<script src="/static/js/jquery.min.js"></script>
<script src="/static/layui/layui.all.js"></script>
<script src="/static/js/admin.js"></script>




<script>


    var id =$("#group_id").val();  //权限组id  传给后台

    layui.extend({
        dtree: '/static/layui_ext/dtree/dtree'   // {/}的意思即代表采用自有路径，即不跟随 base 路径
    }).use(['dtree'], function(){

        var dtree = layui.dtree;


        // 初始化树
        var DemoTree = dtree.render({
            elem: "#demoTree",
            url: "/admin/auth_group/getJson", // 使用url加载（可与data加载同时存在）
            dataStyle: "layuiStyle",  //使用layui风格的数据格式
            dataFormat: "list",  //配置data的风格为list
            response:{message:"msg",statusCode:0,parentId:"pid"},  //修改response中返回数据的定义
            request:{"id":id},
            checkbar:true, //开启复选框
            checkbarType: "all",
            useSelection : true,  // true高亮显示选中的节点;false反之;
        });


        //授权
        $("#auth-btn").on('click',function () {

            //获取复选框选中值
            var params = dtree.getCheckbarNodesParam("demoTree");
            var auth_rule_ids = [];
            $.each(params,function (i,ele) {
                auth_rule_ids.push(ele.nodeId);
            });

            $.ajax({
                url:'/admin/auth_group/updateAuthGroupRule',
                type:'post',
                data:{
                    id,
                    auth_rule_ids,
                },
                success:function (res) {
                    if(res.code==1){
                        setTimeout(function () {
                            location.href=res.url;
                        },1000)
                    }
                    layer.msg(res.msg)
                }
            })
        })

    });






</script>



</body>

</html>