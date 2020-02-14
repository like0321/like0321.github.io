<?php



	一、开启调试模式

    	默认情况下，错误描述比较模糊，不方便进行错误调试。这种模式通常叫做“部署模式”。
    
    	开发阶段可以将框架设置为调试模式，便于进行错误调试。

    
    1、config/app.php中

        应用调试模式
        'app_debug' => true,

        应用Trace
        'app_trace' => true,

        吞吐率 qps ， Apache最多2000


    
    2、在项目根目录中创建.env文件 	推荐

        APP_DEBUG = true
        DATABASE = tp5