<?php


	一、删除数据

        方法1：
            
            $user = User::get(1);
            
            $user->delete();

        

        方法2：
            
            User::destroy(1);
            
            User::destroy([1,2,3]);