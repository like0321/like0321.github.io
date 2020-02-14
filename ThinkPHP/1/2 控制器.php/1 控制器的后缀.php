<?php



	一、控制器的后缀
	
	    
	    打开配置文件application/app.php，有如下配置
	
	        'controller_suffix' => false,
	        表示默认情况下，控制器无特殊后缀。例如Index控制器，文件名为Index.php
	
	    
	    
	    如果需要进行设置，可以改为
	
	        'controller_suffix' => 'Controller'
	        表示控制器以Controller为后缀。例如Index控制器，文件名为IndexController.php	