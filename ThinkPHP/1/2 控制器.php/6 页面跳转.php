<?php
 
    
    一、页面跳转
    
        在应用开发中，经常会遇到一些带有提示信息的跳转页面，
        
        例如操作成功或者操作错误页面，并且自动跳转到另外一个目标页面。
        
        系统的\think\Controller类内置了两个跳转方法success和error，用于页面跳转提示。
    
    
        
        1、$this -> success('登录成功！', '/index/demo/su');   //没定义路由，写全地址
    
        
        
        2、生成url地址函数  url()
    
            $this -> success('登录成功！', url('su'));       //同控制器下面  可以直接写方法名
    
            $this -> success('登陆成功！', url('index/index')); // 不同控制器下  可以写控制器名/方法名
    
       
        
        3、路由别名情况下
                                                    路由别名
            Route::get('abc', 'index/index/index')->name('indexr')
    
            $this -> success('登录成功！', url('indexr'));
    
    
       
        4、可根据不同的请求方式http标准请求还是ajax请求会自动返回数据（html/json）
    
            第三个参数
            $this -> success('登录成功！', url('indexr'), ['status' => 1]);
    





