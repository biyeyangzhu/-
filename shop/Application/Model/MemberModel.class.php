<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 11:15
 */
class MemberModel extends Model
{
    public function insert($data){
       $sql= $this->getInsertSql($data);
        $this->db->query($sql);
    }

    /**
     * 修改回显功能
     */
    public function edit($id){
        $sql = "select * from member where id={$id}";
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
        //var_dump($this->getError());die;
        $this->db->query($sql);
    }

    /**
     * 删除功能
     */
    public function delete($id){
       $sql= $this->getDeleteSqlById($id);
        $this->db->query($sql);
    }

    /**
     * 列表功能
     */
    public function index($page,$condition){
        //加入搜索的条件  对sql语句在拼接
        $sql = "select * from member";
        //动态的where条件
        $where = "";
        if (!empty($condition)){
            $where = " where ".implode("and",$condition);
            //implode 拆分数组为字符串 以and连接
        }
        //合成sql语句
        $sql .= $where;
//        var_dump($where);die;
        //需要返回总页数  每页显示的条数  当前页
        //总页数
        $pagesize = 2;
        $count = $this->db->fetchColumn("select count(*) from member".$where);
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

    //验证方法
    public  function check($username,$password){
            //双重加密
            $password = md5($password);
            //准备sql
            $sql="select * from member where username='{$username}' and password='{$password}'";
            $result = $this->db->fetchRow($sql);
//            var_dump($result);die;
            //判断输入的账号密码与数据库的账号密码
            if(empty($result)){
                $this->error='账号或密码错误';
                return false;
            }
            //成功返回
            return $result;
        }

        //自动登录验证ID和密码
        public function checkCookie($id,$password){
                //验证id
            $sql = "select * from Member where id={$id}";
            $result = $this->db->fetchRow($sql);
            if(empty($result)){
                $this->error="账号不存在";
                return false;
            }
            //判断密码和加密的密码
            $password1=md5($password('password'."_s"));
            if($password !=$password1){
                $this->error="密码错误";
                return false;
            }
            return $result;
        }


        /**
         * 查询所有的美发师
         */
        public function getAll(){
            $sql = "select * from member where group_id=2";
            return $this->db->fetchAll($sql);
        }
}