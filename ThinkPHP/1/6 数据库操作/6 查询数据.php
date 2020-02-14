<?php


    一、查询数据

        1、查询一条数据

            db('articles')->find(209);

            Db::name('user')->where('id',1)->find();


            在没有找到数据后抛出异常
                Db::name('user')->where('id',1)->findOrFail();


        2、查询多条数据
        a:
            Db::name('articles')->where('id','>',100)
            ->where('click','>',100)
            ->select();

        b：
            $where = [
                ['id', '>', 100],
                ['click','>',100]
            ];
            Db::name('articles')->where($where)->select();

        c：
            db('articles')->where(function ($query){
                $query -> where('id','>',100)->where('click','>',100);
            })->whereOr(function ($query){
                $query->where('title','like','a%');
            })->select();


            在没有找到数据后抛出异常可以使用
                Db::name('user')->where('status',1)->selectOrFail();


        3、某个字段的值

            Db::name('user')->where('id',1)->value('name');


        4、某一列的值

            Db::name('user')->column('name');

            Db::name('user')->column('name','id');  //以id为key


        5、排序并获取指定记录条数

            Db::name('user')->order('id', 'desc')->limit(0,10)->select();


        6、获取器 5.1.20之后才有
                                                        当前值    数据源
            Db::name('user')->withAttr('title', function($value, $data){
                
                return strtolower($value);
            
            })->where('id','>',200)->select();


















