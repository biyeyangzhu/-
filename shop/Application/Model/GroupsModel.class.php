<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 13:34
 */
class groupsModel extends Model
{
    /**
     * 查询出所有的部门
     * @return array|null|voidcha
     */
    public function getAll(){
    $sql = "select * from groups";
    return $this->db->fetchAll($sql);
    }

    /**
     * 根据部门id查询出部门名称
     * 返回一个数组id和名字的映射关系
     */
    public function getgroupname(){
    $sql="select * from groups";
    $rows = $this->db->fetchAll($sql);
    $group = [];
    foreach ($rows as $row){
        $group[$row['id']]=$row['name'];
    }
    return $group;
    }

    /**
     * 删除功能
     * @param $id
     */
    public function delete($id)
    {
        $sql = "select count(*) from member where group_id={$id}";
        $row = $this->db->fetchColumn($sql);
//        var_dump($row);die;
        if($row == 0){
            $this->error="该部门有员工不能删除";
            return false;
        }
        $sql = "delete from groups where id={$id}";
        $this->db->query($sql);
    }

    /**
     * 增加功能
     * @param $data 数据
     */
    public function insert($data)
    {
        $sql = "insert into groups(name) VALUES ('{$data['name']}')";
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
        $sql = "select * from groups where id={$id}";
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
        $sql = "update groups set name='{$data['name']}' where id='{$data['id']}'";
        $this->db->query($sql);
    }
}