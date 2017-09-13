<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 15:54
 */
class PlatformController extends Controller
{
    //创建构造方法  成功继续执行 失败就赶回登陆页面
    public function __construct()
    {
        $result = $this->checkByCookie();
        if($result === false) {
            $this->redirect('index.php?p=Home&c=Login&a=login',"登陆失败",3);
        }
    }

    //自动登陆  每个页面检测
    public function checkByCookie(){
        @session_start();
        if(!isset($_SESSION['USER_INFO'])){
            //判断ID和密码
            if(isset($_COOKIE['id']) && isset($_COOKIE['password'])){
                //将cookie中的ID密码赋值
                $id=$_COOKIE['id'];
                $password=$_COOKIE['password'];
                $managerModel = new ManagerModel();
                $result = $managerModel->checkCookie($id,$password);
                //判断结果集是否为false
                if($result !== false){
                    $_SESSION['USER_INFO'] = $result;
                    return true;
                }else{
                    return false;
                }
            }
            //失败返回false 跳转
            return false;
        }
    }
}
