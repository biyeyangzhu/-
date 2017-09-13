<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 15:54
 */
class PlansModel extends Model
{
    /**
     * 显示功能
     * @return array
     */
    public function getAll()
    {
        $sql = "select * from plans";
        return $this->db->fetchAll($sql);
    }

    /**
     * 删除功能
     * @param $id
     */
    public function delete($id)
    {
        $sql = "delete from plans where id={$id}";
        $this->db->query($sql);
    }




    /**
     * 增加功能
     * @param $data 数据
     */
    public function insert($data)
    {
        //状态 合成用| 拆分yoga&
        $status = [];
        if ($data['status']) {
            foreach ($data['status'] as $v) {
                $status = $status | $v;
            }
        }
        $sql = "insert into plans(name,money,status,des) VALUES ('{$data['name']}','{$data['money']}','{$status}','{$data['des']}')";
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
        $sql = "select * from plans where id={$id}";
        //执行sql
        return $this->db->fetchRow($sql);
    }

    /**
 * 修改功能
 * @param $data 数据
 */
    public function update($data)
    {
        //状态 合成用 |  拆分用&
        $status = [];
        if ($data['status']) {
            foreach ($data['status'] as $v) {
                $status = $status | $v;
            }
        }
        //准备sql
        $sql = "update plans set name='{$data['name']}',money='{$data['money']}',status='{$status}',des='{$data['des']}' where id='{$data['id']}'";
        //执行sql
//            var_dump($sql);die;
        $this->db->query($sql);
    }
}