<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 13:25
 */

/**
 * 验证是否登录
 * Class PlatformController
 */
class PlatformController extends Controller
{
        //构造
        public function __construct()
        {
            $result = $this->checkByCookie();
            if($result === false){
                $this->redirect('index.php?p=Admin&c=Login&a=login',"请登录",3);
            }
        }

        //验证ID和密码
        public  function  checkByCookie(){
            @session_start();
            if(!isset($_SESSION['ADMIN_INFO'])){
                //判断id与密码
                if(isset($_COOKIE['member_id']) && isset($_COOKIE['password'])){
                        $id=$_COOKIE['member_id'];
                        $password=$_COOKIE['password'];
                    $membersModel = new MembersModel();
                    $result = $membersModel->checkCookie($id,$password);
                    //验证成功返回true
                    if($result != false){
                        $_SESSION['ADMIN_INFO'] = $result;
                        return true;
                    }else{
                        return false;
                    }
                }
                return false;
            }
        }
}