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

/**
 *
 * @return bool
 */
function geetest($config = [])
{
    $config = empty($config) ? \think\Config::get('geetest') : $config;
    $geetest = new \think\geetest\GeetestLib($config);
    \think\Session::set('gt_user_id', $_SERVER['REQUEST_TIME']);
    \think\Session::set('gt_server_status', $geetest->pre_process(\think\Session::get('gt_user_id')));
    return $geetest->get_response_str();
}

/**
 * @return string
 */
function geetest_url()
{
    return \think\Url::build('/geetest');
}

/**
 *
 * @return bool
 */
/**
 * 极验验证
 * @param array $post post提交的数据
 * @param array $config
 * @return bool
 */
function geetest_check($post, $config = [])
{
    $config = empty($config) ? \think\Config::get('geetest') : $config;
    $geetest = new \think\geetest\GeetestLib($config);
    if (1 == \think\Session::get('gt_server_status')) {
        if ($geetest->success_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'], \think\Session::get('gt_user_id'))) {
            return true;
        } else {
            return false;
        }
    } else {
        if ($geetest->fail_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'])) {
            return true;
        } else {
            return false;
        }
    }
}








