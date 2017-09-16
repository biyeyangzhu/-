<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 15:22
 */
class CodesController extends PlatformController
{
    /**
     * 显示功能
     */
    public  function index(){
        @session_start();
        $userid=$_SESSION['USER_INFO']['id'];
        $codesModel = new CodesModel();
        $result = $codesModel->getuser($userid);
        $this->assign('result',$result);
        $this->display('index');
    }
}