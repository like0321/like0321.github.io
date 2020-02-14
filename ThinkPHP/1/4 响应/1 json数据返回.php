<?php



	一、输出响应

        return 'PHP是世界上最好的语言';


    二、json数据返回

    1、由于默认是输出HTML，所以直接以html页面方式输出响应内容，但也可以设置默认输出为json格式

            'default_return_type' => 'json',


    
    2、默认HTML时，要返回json数据

            
            return json($data, http状态码, header头信息);

                            或者

            return json($data)->code(201)->header(['username'=>'admin','password'=>'admin888']);
