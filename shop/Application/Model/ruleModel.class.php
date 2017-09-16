<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/16
 * Time: 0:34
 */
class ruleModel extends Model
{
    /**
     * 显示功能
     * @return array
     */
    public function getAll()
    {
        $sql = "select * from rule";
        return $this->db->fetchAll($sql);
    }
    /**
     * 添加功能
     */
    public function insert($data){
        $sql = $this->getInsertSql($data);
        $this->db->query($sql);
    }

    /**
     * 修改回显
     */
    public function edit($id){
        $sql = "select * from rule where id =$id";
        return $this->db->fetchRow($sql);
    }

    /**
     * 修改功能
     */
    public function update($data){
        $sql = $this->getUpdateSql($data);
        $this->db->query($sql);
    }

    /**
     * 删除功能
     */
    public function delete($id){
        $sql = $this->getDeleteSqlById($id);
        $this->db->query($sql);
    }
}