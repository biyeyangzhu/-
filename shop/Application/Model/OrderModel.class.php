<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 10:23
 */
class OrderModel extends Model
{
    /**
     * 显示功能
     * @return array
     */
    public function getAll()
    {
        $sql = "select * from orders";
        return $this->db->fetchAll($sql);
    }
    /**
     * 删除功能
     * @param $id
     */
    public function delete($id)
    {
        $sql = "delete from orders where id={$id}";
        $this->db->query($sql);
    }




    /**
     * 增加功能
     * @param $data 数据
     */
    public function insert($data)
    {
        $sql = "insert into orders(phone,realname,date,content) VALUES ('{$data['phone']}','{$data['realname']}','{$data['date']}','{$data['content']}')";
        $result = $this->db->query($sql);
        return $result;
    }


    /**
     * 查询一条数据
     * @param $id
     * @return array|mixed|null
     */
    public function getOne($id)
    {
        //准备sql
        $sql = "select * from orders where id={$id}";
        //执行sql
        return $this->db->fetchRow($sql);
    }

    /**
     * 修改功能
     * @param $data 数据
     */
    public function update($data)
    {
        //准备sql
        $sql = "update orders set phone='{$data['phone']}',realname='{$data['realname']}',date='{$data['date']}',content='{$data['content']}' where id={$data['id']}";
        $this->db->query($sql);
    }

    /**
     * 修改功能
     * @param $data 数据
     */
    public function update1($data)
    {
        //状态 合成用 |  拆分用&
        $status = [];
        if ($data['status']) {
            foreach ($data['status'] as $v) {
                $status = $status | $v;
            }
        }
//        var_dump($data);die;
        //准备sql
        $sql = "update orders set status='{$status}',reply='{$data['reply']}' where id='{$data['id']}'";
        $this->db->query($sql);
    }
    /**
     * 根据用户id查询一条数据
     * @param $id
     * @return array|mixed|null
     */
    public function getuser($userid)
    {
        //准备sql
        $sql = "select * from orders where user_id={$userid}";
        //执行sql
        return $this->db->fetchAll($sql);
    }
}