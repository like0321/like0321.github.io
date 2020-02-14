<?php


	runtime目录在Linux和mac下面，一定要设置可写的权限



	application 					应用目录，MVC就在此目录中，也是实现业务代码的所在的目录

	application/common 				公共模块目录，在application可以自定创建自己的模块，但在common定义的函数和模型都是公用的

	application/common.php 			公共函数库文件

	config/app.php 					应用主配置文件

	route 							路由文件目录

	public 							虚拟主机指向的目录

	application/[index或admin] 		表示index模块和admin模块[自定义创建的]