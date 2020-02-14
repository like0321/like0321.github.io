<?php



	一、路由参数

    1、必填参数

    	语法：
    		Route::请求方式('路由表达式/:参数', 匿名函数);

        php7之后的特性
       		Route::get('dd/:id', function(int $id){
       		    return '我的参数值是:'.$id;
       		});

        路由参数类型的限定
        	Route::get('dd/:id', function($id) {
        	    return '我的参数值是：'.$id;
        	})->pattern(['id' => '\d+']);
	
        注意：
        	形参与规则绑定的要一致。

    

    2、可选参数

    	语法：
    		Route::请求方式('路由表达式/[:参数]', 匿名函数);



        Route::get('dd/[:id]', function($id = 0){
            return '我的参数值是:'.$id;
        });

        
        注意：
        	可选参数设置时，如果要获取参数则需要在形参处设置默认值