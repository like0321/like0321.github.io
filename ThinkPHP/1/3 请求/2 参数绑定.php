<?php


	一、参数绑定

        参数绑定是把当前请求的路由参数作为操作方法的参数直接传入，参数绑定并不区分请求类型。

        1、    Route::get('req3/[:id]', '@index/index/req3')
                ->name('index/index/req3')
                ->pattern(['id' => '\d+']);

                public function req3($id=0) 
                {
                    return '参数为：'.$id;
                }


        2、  Route::get('req3/[:id]', '@index/index/req3')
            ->name('index/index/req3');

            public function req3(int $id=0) 
            {
                return '参数为：'.$id;
            }