<?php


	一、连接数据库

        在应用配置目录或者模块配置目录下面的config/database.php中配置下面的数据库参数

        	return [
			    // 数据库类型
			    'type'        => 'mysql',
			    // 服务器地址
			    'hostname'    => '127.0.0.1',
			    // 数据库名
			    'database'    => 'thinkphp',
			    // 数据库用户名
			    'username'    => 'root',
			    // 数据库密码
			    'password'    => '',
			    // 数据库连接端口
			    'hostport'    => '',
			    // 数据库连接参数
			    'params'      => [],
			    // 数据库编码默认采用utf8
			    'charset'     => 'utf8',
			    // 数据库表前缀
			    'prefix'      => 'think_',
			];



        注：
            配置好后，一定要检查mysql服务是否开启，同时也要检查PDO是否打开。
            
            同时还要创建好对应的数据库和连接数据库的用户名和密码并确保他们可以连接上你的mysql服务器。