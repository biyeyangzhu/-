<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 14:06
 */
class LoginController extends Controller
{
    //显示登陆页面
    public function login(){
        $this->display('login');
    }

    /**
     * 验证方法
     */
    public function check(){
        //验证账号和密码
        @session_start();
        //将账号和密码取出来
        $username = $_POST['username'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        //都已小写判断
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){
            $this->redirect("index.php?p=Home&c=Login&a=login","验证码填写错误！",3);
        }

        $managerModel = new UserModel();
        $result = $managerModel->check($username,$password);
        //判断张海和密码
        if($result === false){
            $this->redirect('index.php?p=Home&c=Login&a=login','登录失败！'.$managerModel->getError(),3);
        }
        //将结果保存到SESSION中
        @session_start();
        $_SESSION['USER_INFO'] = $result;
        //判断是否电了REMMEMBER,双重加密
        if(isset($_POST['remember'])){
            $id = $result['id'];
            //保存到cookie中
            $password = md5($result['password']."_shy");
            setcookie('id',$id,time()+7*3600*24,"/");
            setcookie('password',$password,time()+7*3600*24,"/");
        }
//        die;
        //跳转
        $this->redirect('index.php?p=Home&c=User&a=index');
    }

    /**
     * 退出功能
     */
    public function logout(){
        //删除cookie中的id和password
        setcookie('id',null,-1,"/");
        setcookie('password',null,-1,"/");
        @session_start();
        unset($_SESSION['USER_INFO']);
        $this->redirect('index.php?p=Home&c=login&a=login');
    }

}