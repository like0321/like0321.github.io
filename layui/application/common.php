<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 循环删除目录和文件
 * @param $dir
 * @return bool
 */
function delete_dir_file($dir)
{
    $res = false;

    //判断是不是目录
    if (is_dir($dir)) {

        //打开目录
        $handle = opendir($dir);

        //读取目录条目
        while ($line = readdir($handle)) {

            // 如果是'.'或'..'，则跳过
            if ($line == '.' || $line == '..') {
                continue;
            }

            // 判断是文件还是目录
            if (is_dir($dir . DIRECTORY_SEPARATOR . $line)) {
                delete_dir_file($dir . DIRECTORY_SEPARATOR . $line);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $line);
            }
        }

        //关闭目录
        closedir($handle);

        //删除目录
        if(rmdir($dir)){
            $res = true;
        }

    }

    return $res;
}


/**
 * 数组层级缩进转换
 * @param $arr
 * @param int $pid
 * @param int $level
 * @return array
 */
function array2level($arr, $pid=0, $level=1)
{

    static $list = [];
    foreach ($arr as $v) {
        if($v['pid'] == $pid ){
            $v['level'] = $level;
            $list[] = $v;
            array2level($arr, $v['id'], $level+1);
        }
    }
    return $list;
}








/**
 * 子元素计数器
 * @param array $array
 * @param int   $pid
 * @return array
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++; //值++
        $counter[$item[$pid]] = $count; //父id为键，子元素个数为值
    }
    return $counter;
}


/**
 * 构建层级（树状）数组
 * @param array  $array          要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children')
{
    //父id为键，子元素个数为值
    $counter = array_children_count($array, $pid_name);

    //空数组
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }


    $tree = [];

    while (isset($counter[0]) && $counter[0] > 0){
        //将 array 的第一个单元移出并作为结果返回
        $temp = array_shift($array);

        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);

        } else {
            //是一级分组
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }

        $counter = array_children_count($array, $pid_name);
    }
    return $tree;
}
/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }
    return $parent;
}
/**
 * 手机号格式检查
 * @param string $mobile
 * @return bool
 */
function check_mobile_number($mobile)
{
    if (!is_numeric($mobile)) {
        return false;
    }
    $reg = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#';

    return preg_match($reg, $mobile) ? true : false;
}
//获取客户端真实IP
function getClientIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}

