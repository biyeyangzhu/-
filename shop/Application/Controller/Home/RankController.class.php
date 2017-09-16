<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 * Time: 15:59
 */
class RankController extends PlatformController
{
    /**
     * 排行榜功能
     */
    public function index(){
        $rankModel = new RankModel();
        $rankmember = $rankModel->getmember();
        $rankpay = $rankModel->getpay();
        $rankrecharge = $rankModel->getrecharge();
        $this->assign("result",$rankmember);
        $this->assign("money",$rankpay);
        $this->assign('charge',$rankrecharge);
        $this->display('index');
    }
}