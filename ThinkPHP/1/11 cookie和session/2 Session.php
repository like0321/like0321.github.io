<?php


    可以直接使用think\facade\Session类操作Session。


    一、赋值

        // 赋值（当前作用域）
        Session::set('name','张三');

        session('name', '张三');


    二、判断

        Session::has('name');

        session('?name');


    三、取值

        Session::get('name');

        session('name');


    四、删除

        Session::delete('name');

        session('name', null);


    五、清空

        Session::clear();

        session(null);


    补充：

        获取全部Session
        dump(session(''));


        个人在项目中定义session的习惯
        session('admin.user', '张三');
        session('index.user', '李四');
