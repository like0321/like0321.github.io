<?php




        不管是数据库操作还是模型操作，都使用paginate()方法来实现

    语法：
        paginate(每页显示条数, 是否是简介分页, 分页配置参数)

    例：
        $list = db('user')->paginate(10);
        return view('index@index/user', compact('list'));

        $list = User::paginate(10)
        return view('index@index/user', compact('list'));


    模板中：
        <div>
            <ul>
                {foreach $list as $item}
                <li> {$item.nickname}</li>
                {/foreach}
            </ul>
        </div>
        {$list|raw}   //推荐
    
        {:html_entity_decode($list->render())} //不推荐



<style>
    ul.pagination {
        display: inline-block;
        padding: 0;
        margin: 0;
    }

    .pagination a {
        text-decoration: none;
        margin-right: 0px !important;
    }

    ul.pagination li {
        display: inline;
    }

    .disabled, .pagination .active, .pagination li a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
        margin: 0 4px;
    }

    .pagination .active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .disabled {
        background-color: rgba(236, 236, 236, 0.78);
    }

    ul.pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    ul.pagination li a:hover:not(.active) {
        background-color: #ddd;
    }
</style>




























