<?php


namespace app\admin\validate;


use think\Validate;

class AdminValidate extends Validate
{

    protected $rule = [
        'old_password' => 'require',
        'password' => 'confirm:confirm_password',
        'confirm_password' => 'confirm:password',
        'username' => 'require|unique:admin',
        'group_id' => 'require',
        'head_img' => 'require'
    ];

    protected $message = [
        'old_password.require' => '请填写原密码！',
        'password.confirm' => '两次密码输入不一致！',
        'username.require' => '请输入用户名！',
        'username.unique' => '用户名已存在！',
        'group_id.require' => '请选择权限组！',
        'head_img.require' => '请上传头像！'
    ];

    protected $scene = [
        'changePassword' => ['old_password','password','confirm_password'],
        'add' => ['username','password','confirm_password','group_id','head_img'],
        'edit' => ['username.require','password','confirm_password','head_img']
    ];
}