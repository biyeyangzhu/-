<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 * Time: 16:13
 */
class RankModel extends Model
{
    /**
     * 获取员工服务排行榜
     */
    public function getmember(){
    $sql = "select fuwu,username from member order by fuwu DESC limit 3";
    $result =$this->db->fetchAll($sql);
    return $result;
    }

    /**
     * 获取消费排行榜
     */
    public function getpay(){
     $sql ="select sum(amount) as `sum` ,user_id from history where `type`=1 GROUP BY user_id order by `sum` desc limit 3";
     $result = $this->db->fetchAll($sql);
     //查询出消费排行榜前三的用户名
        foreach ($result as $v){
            $money[]=$v['sum'];
        }
      $R1 = $result[0]['user_id'];
      $R2 = $result[1]['user_id'];
      $R3 = $result[2]['user_id'];
      $sql_1 = "select username from users where id={$R1}";
      $sql_2 = "select username from users where id={$R2}";
      $sql_3 = "select username from users where id={$R3}";
      $R1=$this->db->fetchColumn($sql_1);
      $R2=$this->db->fetchColumn($sql_2);
      $R3=$this->db->fetchColumn($sql_3);
      $money["R1"]=$R1;
      $money["R2"]=$R2;
      $money["R3"]=$R3;
      return $money;
    }

    /**
     * 获取充值排行榜
     */
    public function getrecharge(){
        $sql = "select sum(amount) as `sum` ,user_id from history where `type`=0 GROUP BY user_id order by `sum` desc limit 3";
        $result = $this->db->fetchAll($sql);
        $result = $this->db->fetchAll($sql);
        //查询出消费排行榜前三的用户名
        foreach ($result as $v){
            $money[]=$v['sum'];
        }
        $R1 = $result[0]['user_id'];
        $R2 = $result[1]['user_id'];
        $R3 = $result[2]['user_id'];
        $sql_1 = "select username from users where id={$R1}";
        $sql_2 = "select username from users where id={$R2}";
        $sql_3 = "select username from users where id={$R3}";
        $R1=$this->db->fetchColumn($sql_1);
        $R2=$this->db->fetchColumn($sql_2);
        $R3=$this->db->fetchColumn($sql_3);
        $money["R1"]=$R1;
        $money["R2"]=$R2;
        $money["R3"]=$R3;
        return $money;
    }
}