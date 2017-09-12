<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 11:17
 */
class LoginController extends Controller
{
    //登录功能
    public function login(){
        //显示页面
        $this->display('login');
    }

    //验证登陆功能
    public function check(){
        //开启session
        @session_start();
        //得到账号密码
        $uaername = $_POST['username'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
//        var_dump($_SESSION);die;
        //都用小写进行验证码登陆
//        if(strtolower($captcha) != strtolower($_SESSION['r'])){
//
//        }
        //调用模型验证账号密码
        $membersModel = new MembersModel();
        $result =$membersModel->check($uaername,$password);
        //判断账号密码
        if($result === false){
            $this->redirect('index.php?p=Admin&c=Login&a=login',"登录失败".$membersModel->getError(),3);
        }
        //将数据保存到session中
        $_SESSION['USER_INFO'] = $result;
        $id = $result['id'];
        //将密码加密
        $password = md5($result['pasword']."_s");
        setcookie('id',$id,time()+60*3600*12,"/");
        setcookie('password',$password,time()+60*3600*12,"/");
        //登陆成功显示首页
        $this->redirect('index.php?p=Admin&c=index&a=index');
    }
}