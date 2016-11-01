<?php
namespace think\geetest;

use think\Config;
use think\Session;
use think\geetest\GeetestLib;

class GeetestController
{

    public function index()
    {
        $geetest = new GeetestLib((array) Config::get('geetest'));
        Session::set('gt_user_id', $_SERVER['REQUEST_TIME']);
        Session::set('gt_server_status', $geetest->pre_process(Session::get('gt_user_id')));
        return  $geetest->get_response_str();
    }
}