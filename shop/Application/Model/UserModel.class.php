<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 11:19
 */
class UserModel extends Model
{
    /**
     * 添加功能
     */
    public function insert($data){
        $this->insertData($data);
    }

    /**
     * 修改回显功能
     */
    public function edit($id){
        $sql = "select * from userer where id={$id}";
    return $this->db->fetchRow($sql);
    }

    /**
     * 修改功能
     */
    public function update($data){
        if (empty($data['photo'])){
            $row = $this->edit($data['id']);
            $data['photo']=$row['photo'];
        }
    $sql = $this->getUpdateSql($data);
        var_dump($sql);
    }

    /**
     * 删除功能
     */
    public function delete($id){
    $this->getDeleteSqlById($id);
    }

    /**
     * 列表功能
     */
    public function index($page,$condition){
        //加入搜索的条件  对sql语句在拼接
        $sql = "select * from userer";
        //动态的where条件
        $where = "";
        if (!empty($condition)){
            $where = " where ".implode("and",$condition);
            //implode 拆分数组为字符串 以and连接
        }
        //合成sql语句
        $sql .= $where;
//        var_dump($sql);die;
        //需要返回总页数  每页显示的条数  当前页
        //总页数
        $pagesize = 2;
        $count = $this->db->fetchColumn("select count(*) from userber".$where);
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
        $lists = $this->db->fetchAll($sql);
        $pre_page = $page-1<1?1:$page-1;
        $next_page = $page+1>$totalpage?$totalpage:$page+1;
        return ['list'=>$lists,'pagesize'=>$pagesize,'totalpage'=>$totalpage,'page'=>$page,'count'=>$count,'pre_page'=>$pre_page,'next_page'=>$next_page];
    }

}