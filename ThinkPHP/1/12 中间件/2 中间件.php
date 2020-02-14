<?php



    中间件主要用于拦截或过滤应用的HTTP请求，并进行必要的业务处理。

 
    一、定义中间架

        命令行    php think make:middleware 中间件的名称

        这个指令会 application/http/middleware目录下面生成一个中间件文件。

    例：
        namespace app\http\middleware;

        class CheckLogin
        {
            
            public function handle($request, \Closure $next)
            {
                // 添加前置中间件执行代码

                return $next($request);
            }

            
            public function handle($request, \Closure $next)
            {
                $res = $next($request);

                // 添加后置中间件执行代码

                return $res;
            }
        }

    注意：
        中间件的入口执行方法必须是handle方法，而且第一个参数是Request对象，第二个参数是一个闭包。
        
        在回调函数 $next 之前的是前置中间件（大多数情况），在其之后的是后置中间件，


    

    二、注册中间件(定义好后需注册才可使用)

        1、控制器注册

            protected  $middleware = [
                'CheckLogin' //中间件的类名称
            ];

            注意：
                只适用于pathinfo模式



        2、路由注册  推荐

            Route::get('login','@index/login/index')->name('login')->middleware('CheckLogin');

            //支持路由分组                      数组
                Route::group(['middleware'=>['CheckLogin']], function(){
                    Route::get('login','@index/login/index')->name('login');
                });



        3、配置文件注册    推荐pathinfo用这种

            middleware.php此文件可以放在模块下，就是对此模块注册此中间件，
            
            middleware.php在应用目录application下面，就是全局中间件，就是所有的模块都有此中间件。

            return [
                \app\http\middleware\CheckLogin::class,
                //   'app\http\middleware\CheckLogin',
                'Hello',
            ];

            注意：
                中间件的注册应该使用完整的类名，如果没有指定命名空间则使用app\http\middleware作为命名空间。





    三、中间件传参：

        使用第三个参数传入额外的参数。

        1、定义

            namespace app\http\middleware;

            class Check
            {                                                    传额外参数(形参 随便起名)
                public function handle($request, \Closure $next, $name)
                {
                    if ($name == 'think') {
                        return redirect('index/think');
                    }

                    return $next($request);
                }
            }


        
        2、注册 

        2.1、配置文件形式传参： [中间件文件类, 值]
            return [                               实参
                [\app\http\middleware\Auth::class, 'admin'],
                'Hello:thinkphp',
            ];


        2、路由传参：     中间件名:值
                                                     实参
            Route::group(['middleware'=>['CheckLogin:guest']], function(){
                Route::get('login','@index/login/index')->name('login');
            });


        3、控制器传参：    中间件名:值

            protected $middleware = [
                            实参
                'CheckLogin:user'
            ];
