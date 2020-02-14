<?php


	一、删除数据

        根据主键删除
            
            Db::name('user')->delete(1);
            
            Db::name('user')->delete([1,2,3]);

        

        条件删除
            
            Db::name('user')->where('id',1)->delete();
            
            Db::name('user')->where('id','<',10)->delete();

        

        无条件删除所有数据
           
            Db::name('user')->delete(true);

        

        软删除数据 使用delete_time字段标记删除
            
            Db::name('user')
            ->where('id',1)
            ->useSoftDelete('delete_time', time())
            ->delete();

            注意：
            	表中必须要有delete_time字段，int类型