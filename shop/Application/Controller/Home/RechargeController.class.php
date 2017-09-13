<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 19:05
 */
class RechargeController extends PlatformController
{
    /**
     * 充值功能
     */
    public function recharge(){
        if ($_SERVER['REQUEST_METHOD']=="GET"){
            $id = $_GET['id'];
            $this->assign('id',$id);
            $this->display('recharge');
        }else{
            $data = $_POST;
            if ($data['money']>500&&$data['money']<1000){
                $data['money']=$data['money']+200;
            }elseif ($data['money']>1000&&$data['money']<5000){
                $data['money']=$data['money']+300;
            }elseif ($data['money']>5000){
                $data['money']=$data['money']+2000;
            }
            $usermodel = new UsersModel();
            $usermodel->recharge($data);
            $this->redirect("index.php?p=Home&c=Users&a=index",'充值成功',3);
        }
    }
    /**
     * 消费功能
     */
    public function pay(){
        $data = $_POST;
    }
}