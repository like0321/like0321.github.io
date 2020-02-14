<?php



	一、执行原生SQL

        Db类支持原生SQL查询操作

        获取表前缀：
                读取配置文件中的配置
                echo config('database.prefix');  //tp_


    1、查询：
            $sql = "select * from tp_articles where id =:id";
            
            $ret = Db::query($sql, ['id' => 103]);

            dump($ret);


    2、添加
            $sql = "insert into tp_articles (title, desc) values (:title,:desc)";
            
            $ret = Db::execute($sql,['title'=>'我是标题','desc'=>'我是描述']);

            dump($ret); //受影响的行数

        
    3、更新
            $sql = "update tp_articles set title =:title where id =:id";
            
            $ret = Db::execute($sql,['title'=>'我是修改的','id'=>204]);

            dump($ret); //受影响的行数


    4、删除
            $sql = "delete from tp_articles where id =:id";
            
            $ret = Db::execute($sql,['id' => 204]);

            dump($ret); //受影响的行数