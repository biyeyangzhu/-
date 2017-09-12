<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 11:17
 */
class LoginController extends Controller
{
    /**
     * 登录
     */
    public function login()
    {
        //显示页面
        $this->display('login');
    }

    /**
     * 验证功能
     */
    public function check()
    {
        //开启session
        @session_start();
        //得到账号密码
        $username = $_POST['username'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        //都已小写判断
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){
            $this->redirect("index.php?p=Admin&c=Login&a=login","验证码填写错误！",3);
        }
        //调用模型验证账号密码
        $membersModel = new MembersModel();
        $result = $membersModel->check($username, $password);
//        var_dump($result);die;
        //判断账号密码
        if ($result === false) {
            $this->redirect('index.php?p=Admin&c=Login&a=login', "登录失败" . $membersModel->getError(), 3);
        }
//        将数据保存到session中
        $_SESSION['ADMIN_INFO'] = $result;

        /**
         * 自动登录
         */
//        var_dump($result['remember']);die;
        if($result['remember']??0){
            $id = $result['id'];
            //将密码加密
            $password = md5($result['password'] . "_s");
            setcookie('id', $id, time() + 60 * 3600 * 12, "/");
            setcookie('password', $password, time() + 60 * 3600 * 12, "/");
        }
//        echo 111;die;
        //登陆成功显示首页
        $this->redirect('index.php?p=Admin&c=Index&a=index');
    }
}