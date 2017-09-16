<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/16
 * Time: 12:42
 */
class historyController extends PlatformController
{
    /**
     * 当前登录会员的消费记录
     */
    public function pay(){
        $id= $_SESSION['USER_INFO']['id'];
        $rechargeModel=new RechargeModel();
        $pay = $rechargeModel->getpay($id);
        $this->assign('row',$pay);
        $this->display('pay');
    }

    /**
     * 当前会员的充值记录
     */
    public function charge(){
        $id= $_SESSION['USER_INFO']['id'];
        $rechargeModel=new RechargeModel();
        $charge = $rechargeModel->getcharge($id);
        $this->assign('row',$charge);
        $this->display('recharge');
    }
}