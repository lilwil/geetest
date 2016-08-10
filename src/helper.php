<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lilwil <lilwil@163.com>
// +----------------------------------------------------------------------
\think\Route::get('geetest/[:id]', "\\think\\geetest\\GeetestController@index");
\think\Validate::extend('geetest', function ($value, $id = "") {
    return captcha_check($value, $id, (array) \think\Config::get('geetest'));
});
\think\Validate::setTypeMsg('geetest', '验证码错误!');
/**
 * @param string $id
 * @param array  $config
 * @return \think\Response
 */
function geetest($id = "", $config)
{
    $geetest = new \think\geetest\GeetestLib($config);
    \think\Session::set('gt_user_id',$_SERVER['REQUEST_TIME']);
    \think\Session::set('gt_server_status',$geetest->pre_process(\think\Session::get('gt_user_id')));
    return  $geetest->get_response_str();
}
