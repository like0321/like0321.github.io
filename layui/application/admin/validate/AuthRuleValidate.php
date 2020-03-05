<?php


namespace app\admin\validate;


use think\Validate;

class AuthRuleValidate extends Validate
{

    protected $rule = [
        'pid' => 'require',
        'title' => 'require',
        'name' => 'require',
        'sort' => 'require|number'
    ];

    protected $message = [
        'pid.require' => '请选择上级菜单！',
        'title.require' => '请填写菜单名称！',
        'name.require' => '请填写控制器方法！',
        'sort.require' => '请填写排序！',
        'sort.number' => '排序只能填写数字！'
    ];

}