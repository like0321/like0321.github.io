<?php


	一、模型定义与模型设置

        php think make:model 模块名/模型名(首字母大写)

        
        例：
       		namespace app\common\model;

			use think\Model;
			
			class Article extends Model
			{
			    protected $pk = 'id';  //设置主键名称
			
			    //非必须
			    protected $table = 'tp_article'; //设置当前模型对应的完整数据表名称
			
			    public function aa()
			    {
			    	return 'aa';
			    }
			}
			
       
        注意：
        	5.1中模型不会自动获取主键名称，必须设置pk属性。



        1、实例化

            $model = new Articles();
        


        2、助手函数

            $model = model('articles');

            dump($model->aa());