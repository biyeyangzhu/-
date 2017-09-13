<?php


abstract class Model
{
    protected $db;//保存创建好的DB对象
    protected $error;//保存错误信息
    public function __construct()
    {
        //引入DB创建$db对象
//        require "Framework/Tools/DB.class.php";
        $this->db = DB::getInstance($GLOBALS['config']['db']);
    }

     //获取错误信息
    public function getError(){
        return $this->error;
    }
    /****拼接添加SQL语句****/
    public function getInsertSql($data){
        $fieldStr = '';
        $tableName = strtolower(str_replace('Model',"",get_class($this)));
//        var_dump($tableName);exit;
        foreach($data as $key=>$v){
            $fieldStr .= "`{$key}`='{$v}'";
            $fieldStr .= ',';
        }
        $fieldStr = substr($fieldStr,0,-1);
        $sql = "INSERT INTO `{$tableName}` SET {$fieldStr}";
        return $sql;
    }

    /****拼接删除SQL语句****/
    public function getDeleteSqlById($id){
        $tableName = strtolower(str_replace('Model',"",get_class($this)));
        $sql = "delete from {$tableName} where id={$id}";
        return $sql;
    }

    /***拼接修改SQL语句***/
    public function getUpdateSql($data){
        $fieldStr='';
        $tableName = strtolower(str_replace('Model',"",get_class($this)));
        foreach ($data as $key => $datum) {
            $fieldStr .= "`{$key}`='{$datum}',";
        }
        $fieldStr = substr($fieldStr,0,-1);
        $sql = "UPDATE {$tableName} SET $fieldStr WHERE `id`={$data['id']}";
        return $sql;
    }
    /****拼接添加SQL语句****/
    public function getDeleteSqlId($id){
        $tableName = strtolower(str_replace('Model',"",get_class($this)));
        $sql = "delete from {$tableName} where id={$id}";
        return $sql;
    }

}