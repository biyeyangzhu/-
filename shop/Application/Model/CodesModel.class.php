<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 15:22
 */
class CodesModel extends Model
{
    /**
     * 显示功能
     */
    public function getAll(){
        $sql= "select * from codes";
        return $this->db->fetchAll($sql);
    }

    /**
     * 删除功能
     */
    public function delete($id){
        $row = $this->getOne($id);
        if($row['status'] ==4) {
            $this->error="未使用的代金券不能删除";
            return false;
        }else{
            $sql ="delete from codes where id={$id}";
            $this->db->query($sql);
        }

    }

    /**
     * 查询一条
     */
    public function getOne($id){
        $sql="select * from codes where id={$id}";
        return $this->db->fetchRow($sql);
    }

    /**
     * 添加功能
     */
    public function insert($data){
        $sql = $this->getInsertSql($data);
        $this->db->query($sql);
    }

    /**
     *修改功能
     */
        public function update($deta){
            $sql =$this->getUpdateSql($deta);
            $this->db->query($sql);
        }
    /**
     * 查询Users里面的会员
     */
    public function get(){
        $sql="select * from users";
        return $this->db->fetchAll($sql);
    }

    /**
     * 查询会员的优惠券
     * @param $userid
     */
    public function getuser($userid){
        $sql="select * from codes where user_id={$userid}";
        return $this->db->fetchAll($sql);
    }
}