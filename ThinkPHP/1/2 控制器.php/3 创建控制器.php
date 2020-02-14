<?php


	一、创建控制器

   
    1、手动创建

        application/模块目录/controller/目录下
        
        命名规则：
        		控制器名称(首字母大写)+(控制器后缀,默认没有)+.php

    

    2、命令行方式创建 【推荐】

        php think make:controller --plain 模块名/控制器名

        	--plain 标准控制器(默认创建的控制器是一个资源控制器，所以一般加上此选项)

        注意：
        	如果创建时，没有加模块名称，则默认创建到公共模块中【common】
