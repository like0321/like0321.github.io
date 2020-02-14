<?php



	一、添加数据

        use think\Db;

        
        1、添加一条数据
           
            $ret = Db::name('user')->data($data)->insert();

            $ret = Db::name('user')->insert($data);

            $ret = db('user')->insert($data);   //推荐

            dump($ret); //受影响的行数


        2、添加数据后返回新增的自增主键
            
            $userId = db('user')->insertGetId($data);


        3、添加多条数据

            $ret = Db::name('user')->insertAll($data);

            $ret = db('user')->insertAll($data);

            dump($ret); //受影响的行数