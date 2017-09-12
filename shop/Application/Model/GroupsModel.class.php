<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 19:32
 */
class GroupsModel extends  Model
{
    /**
     * 显示功能
     * @return array
     */

    public function getAll(){
        $sql = "select * from groups";
         return $this->db->fetchAll($sql);
    }

    /**
     * 删除功能
     * @param $id
     */
    public function delete($id){
        $sql = "delete from groups where id={$id}";
        $this->db->query($sql);
    }

    /**
     * 添加功能
     */
    public function insert($data){
        $sql = "insert into groups(name) VALUES ('{$data['name']}')";
        $result = $this->db->query($sql);
        return $result;
    }

    /**
     *得到一条数据
     */
    public function getOne($id)
    {
        //准备sql
        $sql = "select * from groups where id={$id}";
        //执行sql
        return $this->db->fetchRow($sql);
    }

    /**
     * 修改功
     */
    public  function update($data){
        //准备sql
        $sql = "update groups set name='{$data['name']}'";
        //执行sql
//            var_dump($sql);die;
        $this->db->query($sql);
    }
}