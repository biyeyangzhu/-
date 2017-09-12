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
}