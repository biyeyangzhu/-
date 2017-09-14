<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 14:22
 */
class ActivityModel extends Model
{
    /**
     * 展示功能
     */
    public function index(){

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
    $sql = $this->getDeleteSqlById($id);
    $this->db->query($sql);
    }

    /**
     * 修改功能
     */
    public function update(){

    }

    /**
     * 删除功能
     */
    public function delete(){

    }
}