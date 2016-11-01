<?php
use think\Route;
use think\Session;
use think\Config;
use think\Url;
\think\Route::rule('geetest/[:id]', "\\think\\geetest\\GeetestController@index");

/**
 *
 * @return bool
 */
function geetest($config = [])
{
    $config = empty($config) ? Config::get('geetest') : $config;
    $geetest = new \think\geetest\GeetestLib($config);
    Config::set('gt_user_id', $_SERVER['REQUEST_TIME']);
    Config::set('gt_server_status', $geetest->pre_process(Config::get('gt_user_id')));
    return $geetest->get_response_str();
}

/**
 *
 * @return string
 */
function geetest_url()
{
    return Url::build('/geetest');
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
    $config = empty($config) ? Config::get('geetest') : $config;
    $geetest = new \think\geetest\GeetestLib($config);
    if (1 == Config::get('gt_server_status')) {
        if ($geetest->success_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'], Config::get('gt_user_id'))) {
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








