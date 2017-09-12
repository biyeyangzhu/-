<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 11:15
 */
class MembersModel extends Model
{
    //验证方法
    public  function check($username,$password){
            //双重加密
            $password = md5($password);
            //准备sql
            $sql="select * from members where username='{$username}' and password='{$password}'";
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
            $sql = "select * from members where id={$id}";
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
}