<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 14:14
 */
class RechargeRuleModel extends Model
{
    public function getall(){
        $sql = "select * from rule order by charge desc";
         return $this->db->fetchAll($sql);
    }
}