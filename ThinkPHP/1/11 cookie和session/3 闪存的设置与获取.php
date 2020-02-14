<?php


	一、闪存的设置与获取

            闪存数据传值，仅在下一次请求有效

        
        第一种：
            设置
            	//定义好，在下一次HTTP请求中获取到，第2次没有了
            	Session::flash('success','登录成功')

            获取
            	dump(session('success'));

            注意：
            	需要在下一次请求中获取，且只能获取到一次


        
        第二种： redirect()方法 配合 with()方法

            class Index
            {
                public function index()
                {
                                //同控制器下前面的可省略
                    return redirect('hello')->with('name','张三');  //跳转并写入闪存信息
                }

                public function hello()
                {
                    $name = session('name');
                    
                    return 'hello,'.$name.'!';
                }
            }