<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Controller;

/**
 * 权限组
 * Class AuthGroup
 * @package app\admin\controller
 */
class AuthGroup extends AdminBase
{
    //权限组
    public function index()
    {
        $list = db('auth_group')->select();

        return view('',compact('list'));
    }


    /**
     * 添加权限组
     * @return \think\response\View
     */
    public function add()
    {
        if($this->request->isPost()){

            $data = $this->request->post();

            $res = db('auth_group')->insert($data);
            $res ? $this->success('添加成功！','index') : $this->error('添加失败！');
        }

        return view('');
    }


    /**
     * 编辑权限组
     * @param $id
     * @return \think\response\View
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit($id)
    {

        if($this->request->isPost()){
            $data = $this->request->post();

            if($id == 1 && $data['status']!=1){
                $this->error('超级管理组不可禁用！');
            }

            $res = db('auth_group')->update($data);
            $res ? $this->success('更新成功！','index') : $this->error('更新失败！');
        }

        $info = db('auth_group')->find($id);
        return view('',compact('info'));
    }


    /**
     * 删除权限组
     * @param $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete($id)
    {
        if($id==1){
            $this->error('超级管理组不可删除！');
        }

        db('auth_group_access')->where('group_id',$id)->delete();
        $res = db('auth_group')->delete($id);
        $res ? $this->success('删除成功！') : $this->error('删除失败！');
    }


    /**
     * 授权页面
     * @param $id
     * @return \think\response\View
     */
    public function auth($id)
    {
        return view();
    }


    /**
     * 权限json数据
     * @param $id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getJson($id)
    {
        //权限组的权限
        $auth_group_rules = db('auth_group')->where('id',$id)->value('rules');
        $auth_group_rules = explode(',',$auth_group_rules);
        //所有权限
        $auth_rule_list = db('auth_rule')->field('id,title,pid')->select();

        foreach ($auth_rule_list as $k=>&$v) {

            if(in_array($v['id'],$auth_group_rules)){
                $v['checkArr']=['checked'=>1];
            }else{
                $v['checkArr']=['checked'=>0];
            }
        }

        return json(['code'=>0,'msg'=>'ok','data'=>$auth_rule_list]);
    }


    /**
     * 更新权限组信息
     * @param $id
     * @param string $auth_rule_ids
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateAuthGroupRule($id,$auth_rule_ids='')
    {
        if($this->request->isPost()){

            $group_data['id'] = $id;
            $group_data['rules'] = is_array($auth_rule_ids) ? implode(',',$auth_rule_ids) : '';

            $res = db('auth_group')->update($group_data);
            $res ? $this->success('授权成功！') : $this->error('授权失败！');

        }

    }


}
