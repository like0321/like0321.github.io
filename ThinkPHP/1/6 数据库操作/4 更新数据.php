<?php


	一、更新数据 	一定要写条件

            
        use think\Db;

        db('user')->where('id',1)->update($data);    	推荐

        db('user')->where('id',1)->data($data)->update();

        
    
    2、更新数据有id的情况下

        Db::name('user')->update(['name'=>'thinkphp', 'id'=>1]);


    
    3、5.1.7之后还支持了Db::raw(原生)写法
        
        Db::name('user')
            ->where('id',1)
            ->update([
            'name' => Db::raw('UPPER(name)'),
            'score' => Db::raw('score-3'),
            'click' => DB::raw('click+1')
        ])
