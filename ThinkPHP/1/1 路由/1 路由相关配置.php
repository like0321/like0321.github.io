<?php


	    phpstorm 快捷键

        查找文件 双击shift

        打开刚关闭的文件 Ctrl+E


    一、路由

        将用户的请求按照事先规划的方案提交给指定的控制器 和 方法来进行处理。

    thinkPHP提供了两种路由规则：
            
            pathinfo模式
            
            自定义路由规则【推荐】

    Route类注册使用think\facade\Route类静态调用

    
     注意：
        thinkPHP5.1的路由定义更加对象化，并且默认开启路由(不能关闭)，如果一个URL没有定义路由，则采用默认的PATH_INFO模式访问URL。




    二、路由相关配置

        1、强制路由   设置为true

            在config/app.php配置文件中设置      'url_route_must' => true,

            注意：
                将开启强制使用路由，这种方式下面必须严格给每一个访问地址定义路由规则(包括首页)，否则将抛出异常。

        
        2、路由缓存    线上部署模式开启

            对于路由规则较多的应用可以大幅提升路由性能   
            
            'route_check_cache' => true,

            注意：
                如果路由定义中，有某个路由规则的路由地址使用了闭包的方式，那么路由缓存将会失效。

        
        3、完全匹配  设置为true

            'route_complete_match' => true,