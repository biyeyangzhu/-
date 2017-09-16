<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 14:34
 */
class UsersModel extends Model
{
    //验证账号和密码
    public function check($username, $password)
    {
        $password = $this->db->escape_param($password);
        //准备sql
        $password = md5($password);
        $sql = "select * from users where username='{$username}' and password='{$password}'";
        //执行sql
        $result = $this->db->fetchRow($sql);
        //判断数据中的账号密码是否正确
        if (empty($result)) {
            $this->error = "账号或密码错误";
            return false;
        }
        return $result;
    }

    /**
     * 验证ID和密码
     * @param $id
     * @param $password
     * @return array|bool|mixed|null
     */
    public function checkCookie($id, $password)
    {
        //准备sql
        $sql = "select * from users where id={$id}";
        $result = $this->db->fetchRow($sql);
        //判断账号是否存在
        if (empty($result)) {
            $this->error = "账号不存在";
            return false;
        }
        //判断加密后的密码
        $password1 = md5($result['password'] . "_shy");
        if ($password != $password1) {
            $this->error = "密码错误";
            return false;
        }
        return $result;
    }

    /**
     * 添加功能
     */
    public function insert($data)
    {
        $sql=$this->getInsertSql($data);
        $this->db->query($sql);
    }

    /**
     * 修改回显功能
     */
    public function edit($id)
    {
        $sql = "select * from users where id={$id}";
        return $this->db->fetchRow($sql);
    }

    /**
     * 修改功能
     */
    public function update($data)
    {
        if (empty($data['photo'])) {
            $row = $this->edit($data['id']);
            $data['photo'] = $row['photo'];
        }
        $user = $this->edit($data['id']);
        if ($data['password']=$user['password']){
            $data['password']=$user['password'];
        }else{
            $data['password']=md5($data['password']);
        }
        $sql = $this->getUpdateSql($data);
       $this->db->query($sql);
    }

    /**
     * 删除功能
     */
    public function delete($id)
    {
       $sql= $this->getDeleteSqlById($id);
        $this->db->query($sql);
    }

    /**
     * 列表功能
     */
    public function index($page, $condition)
    {
        //加入搜索的条件  对sql语句在拼接
        $sql = "select * from users";
        //动态的where条件
        $where = "";
        if (!empty($condition)) {
            $where = " where " . implode("and", $condition);
            //implode 拆分数组为字符串 以and连接
        }
        //合成sql语句
        $sql .= $where;
//        var_dump($condition);die;
        //需要返回总页数  每页显示的条数  当前页
        //总页数
        $pagesize = 1;
        $count = $this->db->fetchColumn("select count(*) from users" . $where);
//        var_dump($count);die;
        $totalpage = ceil($count / $pagesize);
        //每页显示的内容
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $totalpage) {
            $page = $totalpage;
        }
        $start = ($page - 1) * $pagesize;
        if ($start<=0){
            $start =0;
//            var_dump($start);die;
        }
        $limit = " limit {$start},{$pagesize}";
        //在拼接上页码的限制
        $sql .= $limit;
        $lists = $this->db->fetchAll($sql);
        $pre_page = $page - 1 < 1 ? 1 : $page - 1;
        $next_page = $page + 1 > $totalpage ? $totalpage : $page + 1;
        return ['list' => $lists, 'pagesize' => $pagesize, 'totalpage' => $totalpage, 'page' => $page, 'count' => $count, 'pre_page' => $pre_page, 'next_page' => $next_page];
    }

}