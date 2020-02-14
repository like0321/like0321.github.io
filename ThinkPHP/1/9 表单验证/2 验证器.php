<?php

    一、验证器

        thinkPHP 5.1 之后推荐使用的方式

        验证器，就是一个独立的文件，此文件就干一件事，验证。

        命令行创建验证器：
                        php think make:validate 模块名/验证器名(首字母大写)


        namespace app\index\validate;

        use think\Validate;

        class User extends Validate
        {
            //验证规则
            protected $rule =   [
                'name'  => 'require|max:25',
                'age'   => 'number|between:1,120',
                'email' => 'email',
            ];

            //错误信息
            protected $message  =   [
                'name.require' => '名称必须',
                'name.max'     => '名称最多不能超过25个字符',
                'age.number'   => '年龄必须是数字',
                'age.between'  => '年龄只能在1-120之间',
                'email'        => '邮箱格式错误',
            ];

        }

        
        控制器中使用

            1、第一种使用方法   了解

                $data = $this -> request -> post();
    
                $validate = new \app\index\validate\User;
    
                if (!$validate->check($data)) {
                   return $this->error($validate->getError());
                }


            2、第二种方式 控制器中有validate方法 推荐

                $data = $this -> request -> post();
    
                $result = $this->validate($data, 'app\index\validate\User');
                        或者
                $result = $this->validate($data, User::class);
    
                if (true !== $result) {
                    // 验证失败 输出错误信息
                    return $this->error($result)
                }
    



    2、自定义验证规则

        namespace app\index\validate;

        use think\Validate;

        class User extends Validate
        {
            protected $rule = [
                'name'  =>  'checkName:thinkphp',
                'email' =>  'email',
            ];

            protected $message = [
                'name'  =>  '用户名必须',
                'email' =>  '邮箱格式错误',
            ];

            // 自定义验证规则                   thinkphp
            protected function checkName($value,$rule,$data=[])
            {
                return $rule == $value ? true : '名称错误';
            }
        }

 