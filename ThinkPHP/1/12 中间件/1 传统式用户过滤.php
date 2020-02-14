<?php


	一、传统式用户过滤


        通过继承基类来达到权限的判断。


    例：
        //基类
        namespace app\index\controller;

        use think\Controller;

        class Base extends Controller
        {
            //tp框架中的构造方法
            public function initialize()
            {
                //相关的权限判断
                if (!session('?login')) {

                    //return redirect('login')->with(['message'=>'请登录']);

                    return $this->error('请登录', url('login'));
                }
                
                //全局变量
                View::share('name','你好世界');
            }

        }



        // 子类继承基类Base
        namespace app\index\controller;
                            //同命名空间下不用引入
        class User extends Base
        {
            public function index()
            {
                return '后台管理'
            }
        }
