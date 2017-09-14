<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 19:08
 */
class RechargeModel extends Model
{
    /**
     * 充值功能
     */
    public function recharge($data){
    $sql_user ="update member set money =money+{$data['money']}";
    $sql_history="insert into histories set type=1 acount={$data['money']} ";
    $this->db->query($sql_user);
    $this->db->query($sql_history);
    }
    /**
     * 消费功能
     */
    public function pay($data){
        $sql_user = "update member set money =money-{$data['money']}";
        $sql_history = "insert into histories set type=0 acount={$data['money']} ";
        $this->db->query($sql_user);
        $this->db->query($sql_history);
    }
}