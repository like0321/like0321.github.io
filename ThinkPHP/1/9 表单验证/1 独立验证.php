<?php

 

    表单验证是为了防止访问者跳过客户端验证（js验证）而造成的系统安全问题，一旦非法用户绕过客户端验证而服务器端没有加以验证，这样就是很不安全了，所以项目必须要进行 服务器端表单验证。


    ThinkPHP5.1推荐使用验证器进行数据验证（也支持使用\think\Validate类进行独立验证）。


    一、独立验证 (写在控制器里)


        语法：
            make('验证规则', '错误信息', '字段描述消息')


        例：
        	use think\facade\Validate;

            $validate = Validate::make([
                '表单提交name值' => '规则名:规则',
                'name' => 'require|max:25',
                'email' => 'email'
            ],[
                'name.require' => '名称必须填写',
                'name.max' => '名称最多只能是25字',
                'email.email' => '邮箱不合法'
            ]);


            $data = $this -> request ->post();

            //判断
            if (!$validate -> check($data)) {
                $this -> error($validate->getError());
            }


        
        2、自定义验证规则

            独立验证的时候支持使用extend方法动态注册验证规则

        语法：
            Validate::extend('规则名', function($value, $rule){
                return $rule == $value ? true : '错误';
            })


        例：
            //自定义验证规则                                    规则是(李四)
            Validate::extend('checkTitle', function ($value, $rule) {
                return $rule == $value ? true : '名称错误';
            });

            $validate = Validate::make([
                'title' => 'require|min:2:checkTitle:李四'
            ],[
                'title.require' => '标题不能为空',
                'title.min' => '标题最少不能少于2个字'
            ]);

            if (!$validate -> check($data)) {
                $this -> error($validate->getError());
            }

