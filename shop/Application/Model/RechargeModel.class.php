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
    public function recharge($data,$rows){
        //计算出用户所有的充值记录
        $sql_count = "select amount from history where user_id={$data['id']} and `type`=1";
        $charge_count =  $this->db->fetchColumn($sql_count);
        //vip升级
        $sql_vip = "select `level` from vip  where money<={$charge_count}order by money desc";
        $vip_level = $this->db->fetchColumn($sql_vip);
            //判断充值赠送的金额
            $gift = '';
            foreach ($rows as $v){
                if($data['recharge']>=$v['charge']){
                    $gift = $v['gift'];
                }
            }
            $data['recharge'] += $gift;
        //修改用户余额和vip等级
            $sql = "update users set money=money+{$data['recharge']},vip_level={$vip_level} where id={$data['id']}";
            //充值记录
        $time=time();
    $sql_history="insert into history set `type`=1 ,amount={$data['recharge']} ,time={$time},user_id={$data['id']}, reminder={$data['recharge']}";
    $this->db->query($sql);
    $this->db->query($sql_history);
    }
    /**
     * 消费功能
     */
    public function pay($data){
        $time = time();
        //查询出用户的vip等级
        $sql_level = "select vip_level from users where id={$data['id']}";
        $level = $this->db->fetchColumn($sql_level);
        //判断代金券余额和消费金额对比
        if (isset($data['codes'])){
            if ($data['plan']>$data['codes']){
                $data['money']=$data['plan']-$data['codes'];
                $sql_codes = "update codes set status=1 ";
                $this->db->query($sql_codes);
            }else{
                $sql_codes = "update codes set status=1";
                $this->db->query($sql_codes);
                $data['money']=0;
            }
        }else{
            //使用vip打折
            //查询出用户的折扣
            $sql_discount ="select discount from vip where vip_level={$level}";
            $discount = $this->db->fetchColumn($sql_discount);
            $data['money']=$data['plan']*$discount;
        }
        //查询用户的余额
        $sql_user = "select money from users where id={$data['id']}";
        $user_money = $this->db->fetchColumn($sql_user);
        if ($data['money']>$user_money){
            $this->error = "用户余额不足";
            return false;
        }
        //计算消费积分
        $sql_mall = "select mall from mall where `level`={$level}";
        $mall = $this->db->fetchColumn($sql_mall);
        $data['mall']=$data['money']*$mall;
        //修改各个数据表的记录
        $sql_mall = "update mall set mall=mall+{$data['mall']}";
        //对于员工服务进行修改
        $sql_member = "update member set fuwu=fuwu+1 where id={$data['member']}";
        $sql_user = "update users set money =money-{$data['money']},mall={$data['mall']} where id={$data['id']}";
        $sql_history = "insert into history set `type`=0 ,amount={$data['money']},time={$time} , reminder=reminder-{$data['money']}, user_id={$data['id']}";
        $this->db->query($sql_user);
        $this->db->query($sql_history);
        $this->db->query($sql_mall);
        $this->db->query($sql_member);
    }
    /**
     * 查询出所有的充值金额
     */
    public function getsum($id){
    $sql  ="select sum(amount) from history where user_id ={$id} and type=1";
    $result  =$this->db->fetchColumn($sql);
    return $result;
    }

    /**
     * 获取所有用户的信息 用户所拥有的代金券
     */
    public function getUsercode($id){
        $sql ="select * from users where id={$id}";
        $sql_code ="select * from codes where user_id={$id} and status=0";
        $rows = $this->db->fetchRow($sql);
        $row = $this->db->fetchAll($sql_code);
        return ['code'=>$row,'username'=>$rows];
    }
}