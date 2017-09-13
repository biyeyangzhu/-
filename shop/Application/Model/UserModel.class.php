<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 14:34
 */
class UserModel extends Model
{
    //验证账号和密码
    public function check($username,$password){
        //准备sql
        $password = md5($password);
        $sql ="select * from users where username='{$username}' and password='{$password}'";
        //执行sql
        $result = $this->db->fetchRow($sql);
        //判断数据中的账号密码是否正确
        if(empty($result)){
            $this->error="账号或密码错误";
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
    public function checkCookie($id,$password){
        //准备sql
        $sql="select * from users where id={$id}";
        $result = $this->db->fetchRow($sql);
        //判断账号是否存在
        if(empty($result)){
            $this->error="账号不存在";
            return false;
        }
        //判断加密后的密码
        $password1=md5($result['password']."_shy");
        if($password !=$password1){
            $this->error="密码错误";
            return false;
        }
        return $result;
    }
}