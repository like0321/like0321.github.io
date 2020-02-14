<?php

        首先 在项目根目录  使用Composer安装think-captcha扩展包：

            composer require topthink/think-captcha=2.0.*


        验证码的配置参数：
            直接在应用的config目录下面的captcha.php文件（没有则首先创建）中进行设置即可

            return [
                // 验证码字体大小
                'fontSize'    =>    30,    
                // 验证码位数
                'length'      =>    3,   
                // 关闭验证码杂点
                'useNoise'    =>    false, 
            ];


        
        1、在模版内添加验证码的显示代码

            <div>{:captcha_img()}</div>

                    或者

            <div><img src="{:captcha_src()}" alt="captcha" /></div>   //推荐，可以绑定点击事件

                例：
                    <img src="{:captcha_src()}" alt="captcha" id="vcode"/>
        
                    //切换验证码
                    $('#vcode').click(function(){
                        let rnd = Math.random();
                        let src = $(this).attr('src') + '?vt=' + rnd;
                        $(this).attr('src',src);
                    })


        
        2、验证验证码的有效性

            第1种、验证器去验证验证码  推荐
    
                验证器（LoginValidate）中
                    protected $rule = [    
                        'code' => 'require|captcha' // 判断验证码的
                    ];
        
                    protected $message = [
                        'code.captcha' => '验证码输入有误'
                    ]
    
                控制器
                    public function login()
                    {
                        $ret = $this -> Validate($request->post(), LoginValidate::class);
        
                        if (true !== $ret) {
                            return $this -> error($ret);
                        }
                    }
    

    
            第2种、调用内置的函数手动验证   
    
                public function login()
                {
                    $code = $request ->post('code');
    
                    //独立验证 验证不通过返回false
                    if(!captcha_check($code)){
                        // 验证失败
                        return $this->error('验证码不正确');
                    };
    
                }

 