<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Controller;

class Admin extends AdminBase
{
    //管理员
    public function index()
    {
        $admin_list = db('admin')->select();

        foreach($admin_list as &$v){
            $v['group_id'] = db('auth_group_access')->where('uid',$v['id'])->value('group_id');
            $v['group_title'] = db('auth_group')->where('id',$v['group_id'])->value('title');
        }

        return view('',compact('admin_list'));
    }


    /**
     * 添加管理员
     * @return \think\response\View
     */
    public function add()
    {

        if($this->request->isPost()){

            $data = $this->request->post();
            $val_res = $this->validate($data,'AdminValidate.add');

            if($val_res !== true){
                $this->error($val_res);
            }
            $data['password'] = md5($data['password'].config('salt'));

            $admin_id = db('admin')->insertGetId([
                'username'=>$data['username'],
                'password'=>$data['password'],
                'head_img'=>$data['head_img']
            ]);
            $res = db('auth_group_access')->insert([
                'uid' => $admin_id,
                'group_id' => $data['group_id']
            ]);

            $res ? $this->success('添加成功！','index') : $this->error('添加失败！');
        }

        return view();
    }




    /**
     *
     * 编辑管理员
     * @param $id
     * @return \think\response\View
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function edit($id)
    {

        if($this->request->isPost()){

            $data = $this->request->post();
            $val_res = $this->validate($data,'AdminValidate.edit');

            if($val_res !== true){
                $this->error($val_res);
            }

            //更新用户
            if(!empty($data['password'])){
                $data['password'] = md5($data['password'].config('salt'));
                $res = db('admin')->where('id',$id)->update([
                    'username'=>$data['username'],
                    'password'=>$data['password'],
                    'head_img'=>$data['head_img']
                ]);
            }else{
                $res = db('admin')->where('id',$id)->update([
                    'username'=>$data['username'],
                    'head_img'=>$data['head_img']
                ]);
            }


            //非超级管理员
            if(array_key_exists('group_id',$data)){
                db('auth_group_access')->where(['uid' => $id])->setField('group_id',$data['group_id']);
            }

            $res!==false ? $this->success('更新成功！','index') : $this->error('更新失败！');
        }


        $info = db('admin')
            ->field('u.id,u.username,u.head_img,a.group_id,g.title')
            ->alias('u')
            ->join('__AUTH_GROUP_ACCESS__ a','a.uid = u.id')
            ->join('__AUTH_GROUP__ g','a.group_id = g.id')
            ->find($id);


        return view('',compact('info'));
    }


    /**
     * 删除管理员
     * @param $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete($id)
    {
        if($id==1){
            $this->error('默认管理员不可删除！');
        }

        if(db('admin')->delete($id)){
            db('auth_group_access')->where('uid',$id)->delete();
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }



}
