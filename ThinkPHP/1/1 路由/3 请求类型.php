<?php


	一、请求类型

        Route::get('new/:id','News/read');      // 定义GET请求路由规则      查询

        Route::post('new/:id','News/update');   // 定义POST请求路由规则     添加

        Route::put('new/:id','News/update');    // 定义PUT请求路由规则      修改

        Route::delete('new/:id','News/delete'); // 定义DELETE请求路由规则   删除

        Route::any('new/:id','News/read');      // 所有请求都支持的路由规则 框架提供的任意类型 不推荐



    例：
		Route::get('/',function(){
			return '我是get请求';
		});
		
		
		Route::post('/',function(){
			return '我是post请求';
		});
		
		
		Route::put('/',function(){
			return '我是put请求';
		});
		
		Route::delete('/',function(){
			return '我是delete请求';
		});		