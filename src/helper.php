<?php
use think\Route;
use think\Config;
use think\geetest\GeetestLib;
use think\Session;
use think\Url;
// 注册路由
Route::rule('geetest/[:id]', "\\think\\geetest\\GeetestController@index");

function geetest($config = [])
{
    $config = empty($config) ? Config::get('geetest') : $config;
    $geetest = new GeetestLib($config);
    Session::set('gt_user_id', $_SERVER['REQUEST_TIME']);
    Session::set('gt_server_status', $geetest->pre_process(Session::get('gt_user_id')));
    return $geetest->get_response_str();
}

/**
 * 获取地址
 * @return string
 */
function geetest_url()
{
    return Url::build('/geetest');
}

/**
 * 极验验证
 * @param array $post post提交的数据
 * @param array $config
 * @return bool
 */
function geetest_check($post, $config = [])
{
    $config = empty($config) ? Config::get('geetest') : $config;
    $geetest = new GeetestLib($config);
    if (1 == Session::get('gt_server_status')) {
        if ($geetest->success_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'], Session::get('gt_user_id'))) {
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
