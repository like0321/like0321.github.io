<?php


	一、添加数据

        
        1、添加一条数据

            方法1：
                $user = new User;
                $user -> name = 'thinkphp';
                $user -> email = 'thinkphp@qq.com';
                $user -> save();

            方法2：
                $user = new User;
                $user -> save($data);

                //过滤post数组中的非数据表字段数据
                $user -> allowField(true) -> save($data);
                // 允许插入的字段
                $user->allowField(['title','desn'])->save($data);


            方法3： 推荐
                $user = User::create($data);


       	2、添加多条数据

            $user = new User;
            
            $list = [];
            
            $user->saveAll($list);

