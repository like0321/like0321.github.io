<?php 


    下载webuploader插件

        百度开发  无刷新上传前端组件  http://fex.baidu.com/webuploader/download.html

        1、引入资源

            <link rel="stylesheet" type="text/css" href="/static/webuploader/webuploader.css">
            <script type="text/javascript" src="/static/webuploader/webuploader.js"></script> 

        2、html

            <div id="uploader" class="wu-example form-group row">
                <!--用来存放文件信息-->
                <div id="thelist" class="uploader-list">
                    <img src="" alt="" id="desnImg" style="display: none">
                </div>
                <div class="btns">
                    <div id="picker">选择文件</div>
                </div>
            </div>

         
        3、js
            //文件上传
            var uploader = WebUploader.create({
                // swf文件路径
                swf: '/static/webuploader/Uploader.swf',
                // 选完文件后，是否自动上传。
                auto: true,
                // 文件接收服务端。
                server: '{:url("index/upload")}',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#picker',
                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
               
            });
            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( $file,$res ) {
                if($res.status==1){
                    $( '#desnImg').attr('src',$res.msg).show('slow');
                }
        
            });


        注意：
            1、默认传到后台的name='file'，修改的话，

                文档API里，fileVal{}
                例：
                    设置文件上传域的name
                    fileVal: 'pic'

            2、传递请求额外参数

                    formData:{
                        'uid': uid
                    }




    服务器端接收

        public function upload(Request $req)
        {
            // 获取表单上传文件
            $file = request()->file('file');
    
            // 验证并移动文件
            $info = $file->validate(['size'=>102400,'ext'=>'jpg,png,gif'])->move('./uploads/gsjj');
    
            if($info){
                //保存的地址
                $savename = '/uploads/gsjj/' . str_replace('\\','/',$info->getSaveName());
                return json(['status' => 1, 'msg' => $savename]);
            }else{
                return json(['status' => 0, 'msg' => $file->getError() ]);  // 上传失败返回错误信息
            }
        }


        //多文件上传
        public function uploads(Request $req)
        {
            $files = request()->file('image');

            foreach ($files as $k => $v) {
                // 验证并移动文件
                $info = $file->validate(['size'=>15678,'ext'=>'jpg,png,gif'])->move('./uploads');
        
                if($info){
                     
                    dump($info->getExtension);  //后缀  png
                    dump($info->getSaveName);   //带路径
                    dump($info->getFileName);   //不带路径

                    return json(['status' => 1, 'msg' => $savename]);
                }else{
                    return json(['status' => 0, 'msg' => $file->getError() ]);  // 上传失败返回错误信息
                }
            }
        }



































