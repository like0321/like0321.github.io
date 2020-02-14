<?php    

 

    一、路由分组

        Route::group('admin', function (){
            
            Route::get('login', function (){
               return '用户登录';
            });
            
            Route::get('logout', function (){
                return '退出登录';
            });
        });

        访问时：tp5.com/admin/login
               tp5.com/admin/logout



                             分组名              路由定义前缀
        Route::group(['name'=>'admin','prefix'=>'admin/index/'],function(){

            Route::get('index','index');
            Route::get('demo','demo');

        });

        访问时：tp5.com/admin/index
                tp5.com/admin/demo





    2、分组的嵌套
                      这里可以写中间件
        Route::group(['method' => 'get'], function (){
            
            Route::group('blog', function(){
               
                Route::get(':id', 'read');
                
                Route::post(':id', 'update');
                
                Route::delete(':id', 'delete')
            
            });

        })->pattern(['id' => '\d+']);


















