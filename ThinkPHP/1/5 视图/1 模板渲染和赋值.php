<?php


	一、视图的组成

		视图就是MVC中所说的V层，视图层也叫展示层。thinkPHP中视图层是由HTML模板文件组成的。



    二、模板的定义

        为了对模板文件更加有效的管理，ThinkPHP对模板文件进行目录划分，默认的模板文件定义

        规则：
        	视图目录(view)/控制器名(小写)/操作名(小写)+模板后缀(框架的默认视图文件后缀是.html)




    三、模板的渲染



    		用法							描述
		
		不带任何参数				自动定位当前操作的模板文件
		
		[模块@][控制器/][操作]		常用写法，支持跨模块
		
		完整的模板文件名			直接使用完整的模板文件名（包括模板后缀）
		
        return $this->fetch('[模板文件]'[,'模板变量(数组)']);

                    或者 助手函数
        return view('[模板文件]'[,'模板变量(数组)']);


    注意：
    	自定义路由时，模板文件不能省略

        return view('index@index/index');






	四、模板赋值

            $aa = '我就是变量';
            $arr = ['id'=>1, 'name'=>'张三'];

        方法一：
            $this -> assign('aa', $aa);
            return view('index@index/index');

        方法二：
            以关联数组的方式在渲染模板方法第二个参数填写

            return view('index@index/index', ['aa'=>$aa, 'arr'=>$arr]);

        方法三；compact()函数  推荐

            return view('index@index/index', compact('aa', 'arr'));


    2、全局赋值

        use think\facade\View;

        //赋值全局模板变量
        View::share('webName', '网站的名称');

            或者批量赋值
        View::share(['name1'=>'value1', 'name2'=>'value2']);

    

    总结：
        渲染 view函数
        
        赋值 局部 compact()函数        全局 think\facade\View::share();