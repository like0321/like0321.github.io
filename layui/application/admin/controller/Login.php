<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    /**
     * 登录页面
     * @return \think\response\View
     */
    public function index()
    {
    	return view();
    }

    /**
     * 登录处理
     * @param Request $request
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function loginHandle(Request $request)
    {
        if($request->isPost()){

            $data = input('');
            ob_clean();

            //验证
            $res = $this->validate($data,'app\admin\validate\LoginValidate');
            if($res !== true){
                $this->error($res);
            }

            //查询数据库
            $where['username'] = $data['username'];
            $where['password'] = md5($data['password'].config('salt'));
            $info = db('admin')->field('id,username,status,head_img')->where($where)->find();


            if(!$info){
                $this->error('用户名或密码错误！');
            }

            if($info['status']==0){
                $this->error('当前用户已禁用！');
            }

            //存入session
            session('admin_user',$info);

            db('admin')->update([
                'id'=>$info['id'],
                'last_login_time'=>date('Y-m-d H:i:s',time()),
                'last_login_ip'=>$request->ip()
            ]);


           $this->success('登录成功！','index/index');
        }

        return $this->redirect('index');
    }


    /**
     * 登出
     */
    public function logout()
    {
        session(null);

        $this->redirect('login/index');
    }


    /**
     * 修改指定表的指定字段值
     */
    public function changeTableVal()
    {
        $table = input('table'); //表名
        $id_name = input('id_name'); //主键名
        $id_val = input('id_val');//主键值
        $field = input('field'); //字段名
        $value = input('value'); //字段值

        db($table)->where($id_name,$id_val)->setField($field,$value);
    }



    /**
     * 上传图片
     * @return \think\response\Json
     */
    public function upload($filename)
    {
        $file = request()->file('file');

        $config = [
            'size' =>  2097152,
            'ext' => 'jpg,png,gif'
        ];
        $save_path = ROOT_PATH . 'public' . DS . 'uploads'.DS.$filename;
        $url_path = "/uploads/{$filename}/";

        $info = $file->validate($config)->move($save_path);
        if ($info) {
            $res = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $url_path . $info->getSaveName())
            ];
        } else {
            $res = [
                'error' => 1,
                'msg' => $file->getError()
            ];
        }
        return json($res);
    }


}
