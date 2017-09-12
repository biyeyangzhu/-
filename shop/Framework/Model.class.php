<?php

/**
 * 基础模型类，为所有模型提供公共的属性和方法
 * Class Model
 */
abstract class Model
{
    protected $db;//保存创建好的DB对象

    protected $error;//保存错误信息

    public function __construct()
    {
        //引入DB创建$db对象
        $this->db = DB::getInstance($GLOBALS['config']['db']);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(){
        return $this->error;
    }

    /**
     * 插入数据
     * @param $data
     */
    public function insertData($data){
//        var_dump($data);
        //insert into 表面() values()
        //insert into 表面 set 字段名 = 值
//        var_dump(get_class($this));
//        var_dump(str_replace("Model","",get_class($this)));
        //获取表面
            $table = strtolower(str_replace("Model","",get_class($this)));
        //固定部分
            $sql = "insert into {$table} set ";
        //动态部分
            $fields = [];
            foreach ($data as $key=>$v){
                $fields[] = "`{$key}`='{$v}'";
            }
            $sql .= implode(',',$fields);

        //执行sql
            $this->db->query($sql);
    }
}