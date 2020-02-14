<?php


	一、前置操作

		可以为某个或者某些操作指定前置执行的操作方法，

		设置beforeActionList属性可以指定某个方法为其他方法的前置操作，

		数组键名为需要调用的前置方法名，无值的话为当前控制器下所有方法的前置方法。


   		protected $beforeActionList = [

   		    要触发的方法      请求的方法，请求此方法，触发前面定义的方法
   		    'checkUser' => ['index', 'welcome']

   		];


   		['except' => '方法名,方法名']   //表示这些方法不使用前置方法，

 
		['only' => '方法名,方法名'] 	//表示只有这些方法使用前置方法。



	例：
		namespace app\index\controller;

		use think\Controller;
		
		class Index extends Controller
		{
		    protected $beforeActionList = [
		        'first',
		        'second' =>  ['except'=>'hello'],
		        'three'  =>  ['only'=>'hello,data'],
		    ];
		    
		    protected function first()
		    {
		        echo 'first<br/>';
		    }
		    
		    protected function second()
		    {
		        echo 'second<br/>';
		    }
		    
		    protected function three()
		    {
		        echo 'three<br/>';
		    }
		
		    public function hello()
		    {
		        return 'hello';
		    }
		    
		    public function data()
		    {
		        return 'data';
		    }
		}


		访问  	http://localhost/index.php/index/Index/hello
			
		最后的输出结果是
		
				first
				three
				hello
		

		访问 	http://localhost/index.php/index/Index/data
		
		的输出结果是：
		
				first
				second
				three
				data		