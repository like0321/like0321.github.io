<?php



    查询单条记录

        $ret = Articles::get(102);
        
        $ret = Articles::find(102);

        $user = User::where('name', 'thinkphp')->get();  //报错
        
        $user = User::where('name', 'thinkphp')->find();
        
        注意：
            get直接查询，不可以带where条件，
            find两者都可以 推荐

    

    查询多条记录

        $list = User::where('status', 1)->limit(3)->order('id','asc')->select();


    
    条件分组 where() or ()

        $ret = Articles::where(function ($query){
            $query -> where('id', '>', 200);
        })-> whereOr(function ($query){
            $query -> where('click', '>=', 102);
        })->select();


    
    获取某个字段的值

        User::where('id',10)->value('score');


    
    获取某个列的所有值

        User::where('status',1)->column('name');


    
    动态查询
        getBy(固定)字段名(首字母大写)
        
        遇到下划线，下划线后的首字母大写  例：title_article  getByTitleArticle

        //根据name字段查询用户
        $user = User::getByName('thinkphp');