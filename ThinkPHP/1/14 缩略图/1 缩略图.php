<?php


        使用Composer安装ThinkPHP5的图像处理类库：
            
            composer require topthink/think-image

        
        // 打开图片
            $image = \think\Image::open('./image.png');

        
        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
            $image->thumb(150, 150)->save('./thumb.png');






    一、生成缩略图

        使用thumb方法生成缩略图


        public function upload()
        {
    
            // 获取表单上传文件
            $file = request()->file('pic');
    
            // 移动文件
            $info = $file->move( './uploads');
    
            if($info){
    
                $savename = '/uploads/' . str_replace('\\','/',$info->getSaveName());
    
                //打开图片
                $image = \think\Image::open( dirname(__DIR__).DIRECTORY_SEPARATOR.'public'.$savename );
    
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                $image->thumb(150, 150)->save( dirname(__DIR__).DIRECTORY_SEPARATOR.'public'.$savename );
    
                return json(['status' => 1, 'msg' => $savename]);
    
            }else{
    
                return json(['status' => 0, 'msg' => $file->getError() ]);  // 上传失败返回错误信息
    
            }
        }

    补充：
        DIRECTORY_SEPARATOR常量

        
        作用：
            根据操作系统自动转换目录分隔符。


        目录分隔符，是定义php的内置常量。
        在调试机器上，在windows我们习惯性的使用“\”作为文件分隔符，但是在linux上系统不认识这个标识，于是就要引入这个php内置常量了：DIRECTORY_SEPARATOR
    















