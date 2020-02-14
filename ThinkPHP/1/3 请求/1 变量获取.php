<?php


	    在ThinkPHP5.1中，获取请求对象数据，是由think\Request类负责，
    	
    	在很多场合下并不需要实例化调用，通常使用依赖注入即可
    
    		$request->param('name');

    	在其他场合(例如模板输出等)则可以使用think\facade\Request静态类操作

        	Request::param('name');
        



    一、变量获取

    	Route::get('req','@index/index/req')->name('index/index/req');

    1、门面

        use think\facade\Request;

        public function req()
        {

        	//获取GET请求
            echo Request::get('id');

            //如果没有则使用默认值 20
            echo Request::get('age', 20);

            //获取GET全部数据
            dump(Request::get());

            //判断一个key是否存在
            dump(Request::has('sex'));

            //获取指定的数据 白名单
            dump(Request::only(['id', 'age']))

            //排除不要的数据  黑名单
            dump(Request::except(['id']));

        //获取POST请求
            dump(Request::post('name'));

        //获取PUT请求
            dump(Request::put('name'));

        //获取DELETE请求
            dump(Request::delete('name'));

        //获取任意类型
            dump(Request::param('name'));
        }




    2、判断请求的类型

        public function req()
        {

        	dump(Request::isPost());

 			dump(Request::isGet());

 			dump(Request::isPut());

 			dump(Request::isDelete());

 			//是否是ajax请求
 			dump(Request::isAjax());

 			$_SERVER一样的
 			dump(Request::server());

 			//获取环境变量 框架定义好的常量
 			dump(Request::env());

 			//获取路由
        	dump(Request::route());
        }




    3、依赖注入 推荐

        use think\Request;

        public function req(Request $request) 
        {

            dump($request -> get('name'));

            dump($request -> has('sex'));

            dump($request -> only(['id']));

            dump($request -> except(['id']));

            //全部post变量
            dump($request -> post());

        }

    如果你继承了系统的控制器基类think\Controller的话，系统已经自动完成了请求对象的构造方法注入了，你可以直接使用$this->request属性调用当前的请求对象。




    4、助手函数 推荐

        //获取GET的全部参数
        dump(input('get.'));

        //获取指定的数据
        dump(input('get.id'));

        //默认值
        dump(input('get.sex', '女士'));

        //post数据
        dump(input('post.'));

        //获取任意类型的数据
        dump(input('param.'));
        dump(input(''));

        //获取任意类型的key为name的值  如果get和post都存在，优先post
        dump(input('name'));

        //判断一个key是否存在
        dump(input('?sex'));

        //使用变量修饰符 a 数组 s 字符串 d 数字
        dump(input('id/d'));
