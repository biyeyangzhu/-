<?php

/**
 * Class DB
 */
class DB
{
    private $host;//主机名
    private $username;//用户名
    private $password;//密码
    private $dbName;//数据库名
    private $port;//端口
    private $charset;//设置字符串

    private $link;//保存数据库链接

    //保存创建好的对象
    private static $instance;
    /**
     * 构造方法，初始化
     * DB constructor.
     * @param $config 数组 保存的所有的连接数据库的信息
     */
    private function __construct($config)
    {
        //初始化属性
        $this->host = $config['host']??'127.0.0.1';
        $this->username = $config['username']??'root';
        $this->password = $config['password'];
        $this->dbName = $config['dbName'];
        $this->port = $config['port']??3306;
        $this->charset = $config['charset']??'utf8';

        //1.链接数据库
        $this->connect();
        //2.设置字符集
        $this->setCharset();
    }
    //私有的克隆方法
    private function __clone(){}

    /**
     * 创建对象的方法
     */
    public static function getInstance($config){
        if(self::$instance == null){
            //没有创建过对象
            self::$instance = new DB($config);
        }
        return self::$instance;
    }
    /**
     * 链接数据库
     */
    private function connect(){
        //方法中的代码面向过程的
        $this->link = @mysqli_connect($this->host,$this->username,$this->password,$this->dbName,$this->port);
        if($this->link === false){
            die(
                '链接数据库失败！<br />'.
                '错误编号：'.mysqli_connect_errno().'<br />'.
                '错误信息：'.mysqli_connect_error()
            );
        }
    }

    /**
     * 设置字符集
     */
    private function setCharset(){
        $result = mysqli_set_charset($this->link,$this->charset);
        if($result === false){
            die(
                '设置字符集失败！<br />'.
                '错误编号：'.mysqli_errno($this->link).'<br />'.
                '错误信息：'.mysqli_error($this->link)
            );
        }
    }
    /**
     * 专业执行sql语句
     * @param $sql
     */
    public function query($sql){
        //3.执行sql语句
        $result = mysqli_query($this->link,$sql);
        if($result === false){
            die(
                '执行sql语句失败！<br />'.
                '错误编号：'.mysqli_errno($this->link).'<br />'.
                '错误信息：'.mysqli_error($this->link).'<br />'.
                'sql语句：'.$sql
            );
        }
        return $result;
    }

    /**
     * 执行sql语句，返回二维数组
     * @param $sql
     * @return array|[]
     */
    public function fetchAll($sql){
        //>>1.执行sql语句
//            $result = mysqli_query($this->link,$sql);
        $result = $this->query($sql);
        //>>2.解析后返回二维数组
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }

    /**
     * 执行sql，返回一行数据
     * @param $sql
     */
    public function fetchRow($sql){
        /*        //>>1.执行sql语句
                    $result = mysqli_query($this->link,$sql);
                //>>2.解析，返回一维数组
                    return mysqli_fetch_assoc($result);*/

        /*        //>>1.执行sql语句
                $result = $this->query($sql);
                //>>2.解析，返回一维数组
                return mysqli_fetch_assoc($result);*/

        //>>1.执行sql语句
        $rows = $this->fetchAll($sql);
        //>>2.解析，返回一维数组
        return $rows[0]??[];
    }

    /**
     * 执行sql语句，返回第一行第一列的值
     * @param $sql
     * @return mix|0
     */
    public function fetchColumn($sql){
        //>>1.执行sql语句
        $row = $this->fetchRow($sql);
        //>>2.解析结果，取出第一行第一列的值
        //array_values 返回数组的值
//            dump(array_values($row));
        return empty($row)?null:array_values($row)[0];

        /*        //>>1.执行sql语句
                    $result = $this->query($sql);
                //>>2.解析结果，取出第一行第一列的值
                    $row = mysqli_fetch_row($result);
                    return $row[0];*/

    }
    public function __destruct()
    {
        //关闭第三方资源
    }

    /**
     * 转义参数
     * @param $param 需要转义的参数
     */
    public function escape_param($param){
        return mysqli_real_escape_string($this->link,$param);
    }
}
