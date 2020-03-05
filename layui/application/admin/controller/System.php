<?php

namespace app\admin\controller;

use app\admin\validate\AdminValidate;
use app\common\controller\AdminBase;
use think\Controller;

class System extends AdminBase
{
    //


    /**
     * 清除缓存
     */
    public function clear()
    {

        $res1 = delete_dir_file(CACHE_PATH);
        $res2 = delete_dir_file(TEMP_PATH);

        if ( $res1 || $res2 ) {
            $this->success('清除缓存成功！');
        } else {
            $this->error('清除缓存失败！');
        }
    }


    /**
     * 修改密码
     * @return \think\response\View
     */
    public function changePassword()
    {
        return view();
    }


    /**
     * 更新密码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function updatePassword()
    {

        if ($this->request->isPost()) {

            $data = input();

            $val_res = $this->validate($data,"AdminValidate.changePassword");
            if ($val_res !== true) {
                $this->error($val_res);
            }

            $admin_id = session('admin_user')['id'];
            $userInfo = db('admin')->find($admin_id);

            if ($userInfo['password'] != md5($data['old_password'] . config('salt'))) {
                $this->error('原密码不正确！');
            }

            $new_password = md5($data['password'] . config('salt'));

            $res = db('admin')->where('id', $admin_id)->setField('password', $new_password);

            $res ? $this->success('修改成功！') : $this->error('修改失败！');
        }

    }

}
