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
    public function index($page){
        $sql = "select * from activity";
        //需要返回总页数  每页显示的条数  当前页
        //总页数
        $pagesize = 2;
        $count = $this->db->fetchColumn("select count(*) from activity");
//        var_dump($count);die;
        $totalpage = ceil($count/$pagesize);
        //每页显示的内容
        if ($page<1){
            $page=1;
        }
        if ($page>$totalpage){
            $page=$totalpage;
        }
        $start =($page-1)*$pagesize;
        $limit = " limit {$start},{$pagesize}";
        //在拼接上页码的限制
        $sql.=$limit;
    $result =$this->db->fetchAll($sql);
        $pre_page = $page-1<1?1:$page-1;
        $next_page = $page+1>$totalpage?$totalpage:$page+1;
        return ['result'=>$result,'pagesize'=>$pagesize,'totalpage'=>$totalpage,'page'=>$page,'count'=>$count,'pre_page'=>$pre_page,'next_page'=>$next_page];
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
    $sql = "select * from activity where id =$id";
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