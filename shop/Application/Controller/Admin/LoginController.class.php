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
        //以小写判断验证码
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){
            //错误跳转到登陆页面
            $this->redirect('index.php?p=Admin&c=Login&a=login','验证码错误',2);
        }
        //调用模型验证账号密码
        $membersModel = new MemberModel();
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
//        var_dump($result);
        if (isset($_POST['remember'])) {
            $id =$result['id'];
            //将密码加密
            $password = md5($result['password'] . "_s");
            setcookie('plan_id', $id, time()+ 24 * 3600 * 7, "/");
            setcookie('password', $password, time()+ 24 * 3600 * 7, "/");
        }
//        die;
//        echo 111;die;
        //登陆成功显示首页
        $this->redirect('index.php?p=Admin&c=rank&a=index');
    }
        /**
         * 退出功能
         */
        public function logout(){
            //删除cookie中的id和password
        setcookie('id',null,time()-1,"/");
        setcookie('password',null,time()-1,"/");
        @session_start();
        unset($_SESSION['ADMIN_INFO']);
        $this->redirect('index.php?p=Admin&c=login&a=login');
    }

}