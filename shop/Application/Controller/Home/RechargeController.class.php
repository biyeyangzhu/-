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
            $id = $_GET['id'];//接收用户的id
            $this->assign('id',$id);
            $this->display('recharge');
        }else{
            $data = $_POST;
            $summodel = new RechargeModel();
            $id= $_POST['id'];
            //计算出 用户所有的充值金额
            $sum = $summodel->getsum($id);
            $data['sum'] = $sum+$data['recharge'];
            //查询出所有的充值规则
            $recharge = new RechargeruleModel();
            $rows = $recharge->getall();
            $usermodel = new RechargeModel();
            $usermodel->recharge($data,$rows);
            $this->redirect("index.php?p=Home&c=Users&a=index",'充值成功',3);
        }
    }
    /**
     * 消费功能
     */
    public function pay(){
        if ($_SERVER['REQUEST_METHOD']=="POST"){
            $data = $_POST;
            $paymodel = new RechargeModel();
            $paymodel->pay($data);
            $this->redirect('index.php?p=Home&c=Users&a=index','消费成功',3);
        }else{
            $id=$_GET['id'];//获取到用户的id
            $paymodel = new RechargeModel();
            //根据用户id查询所拥有的代金券和姓名
            $usercode = $paymodel->getUserCode($id);
            //查询所有员工
            $membermodel = new MemberModel();
           $membername =  $membermodel->index();
            //查询出所有的套餐
            $planmodel = new PlansModel();
            $plan = $planmodel->getAll();
//            var_dump($plan);die;
            $this->assign("id",$id);
            $this->assign($usercode);
            $this->assign('plan',$plan);
            $this->assign($membername);
            $this->display('pay');
        }

    }
}