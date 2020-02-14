<?php

 
    一、软删除

        namespace app\index\model;

        use think\Model;
        use think\model\concern\SoftDelete;

        class User extends Model
        {
            //1、 引入tract
            use SoftDelete;

            //2、 声明软删除的字段名称
            protected $deleteTime = 'delete_time';
        }




 
        
        Articles::destroy(215);

        //强制真删除
        Articles::destroy(209,true);

        //软删除的数据 不会被查询到
        Articles::select();

        //包含软删除
        Articles::withTrashed()->select();

        //只查询软删除的数据
        Articles::onlyTrashed()->select();


        //恢复软删除的数据
        $ret = Articles::onlyTrashed()->find(214);
        $ret -> restore();


