<?php


	一、更新数据

        方法1：
            $user = User::get(1);
            $user -> name = 'thinkphp';
            $user -> email = 'thinkphp@qq.com';
            $user -> save();

        
        方法2：
            $user = new User;

            //save方法第二个参数为更新条件
            $user->save($data, ['id' => 1]);


            $user = new User;

            //过滤post数组中的非数据表字段数据
            $user -> allowField(true) -> save($data, ['id' => 1]);

        
        方法3：  推荐

            $ret = User::where('id', 1)->update($data);