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
namespace think\geetest;
use think\Config;
use think\Session;
use think\geetest\GeetestLib;
class GeetestController
{
    public function index()
    {
        dump(1);
        $geetest = new GeetestLib((array)Config::get('geetest'));
        Session::set('gt_user_id',$_SERVER['REQUEST_TIME']);
        Session::set('gt_server_status',$geetest->pre_process(Session::get('gt_user_id')));
        return  $geetest->get_response_str();
    }
}