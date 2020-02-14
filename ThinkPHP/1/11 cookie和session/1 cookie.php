<?php

        ThinkPHP采用think\facade\Cookie类提供Cookie支持。

        cookie中 重要的是域名

            例：
                设为baidu.com
                则fanyi.baidu.com    pan.baidu.com 都能获取到cookie信息



    一、设置

        // 初始化
        cookie(['prefix' => 'aa_', 'expire' => 3600]);


        // 设置Cookie 有效期为 300秒
        Cookie::set('name','value',300);

        cookie('name', 'value', 300);



    二、判断

        Cookie::has('name');

        cookie('?name');



    三、获取

        echo Cookie::get('name');

        echo cookie('name');


    四、删除

        Cookie::delete('name');

        cookie('name', null);


    五、清除

        Cookie::clear('aa_');

        cookie(null, 'aa_');

    注意：
        如果不指定前缀，不能做清空操作











































