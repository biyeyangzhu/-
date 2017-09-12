<?php

/**
 * 基础控制器
 */
abstract class Controller
{
    private $data = [];//保存需要分配到视图上的数据

    /**
     * 将数据分配到视图页面，通过$name取值
     * 其实 就是将数据保存到$data属性数组中，并且给键名
     * @param $name 字符串 | 关联数组 直接通过关联数组的键名取值
     * @param $value
     */
    protected function assign($name,$value=''){
        if(is_array($name)){//说明传入是关联数组
            //array_merge — 合并一个或多个数组
            $this->data = array_merge($this->data,$name);
        }else{
            $this->data[$name] = $value;
        }
    }
    /**
     * 加载视图文件
     * @param $template 模板文件的名称
     */
    protected function display($template){
        //要求必须在该方法中有个局部变量 $rows;
//        $rows = [];
        /**
         * 1.设计一个属性，来保存数据
         *      分配一个数据，需要一个属性，如果多个属性，不方便类的管理
         *
         * 2.设计一个属性，数组，保存多个需要分配到视图的属性
         *
         * 3.动态的将数据从$this->data数组中取出来
         *    extract(); 将一个关联数组导入到当前符号表，
         *    管理数组的键名是变量名，键值即变量的值
         */
//        var_dump($this->data);
//        $rows = $this->data['rows'];
//        $page = $this->data['page'];
//        $total = $this->data['total'];
        extract($this->data);
        require CURRENT_VIEW_PATH."{$template}.html";
        exit;
    }

    /**
     * 跳转方法
     * @param 跳转的url $url
     */
    protected function redirect($url , $msg = '' ,$times = 0){
        /*if($times){
            //时间大于零 输出错误信息后隔几秒跳转
            echo "<h2>{$msg}</h2>";
            //等待一定时间后再刷新页面
            header("Refresh: {$times};{$url}");
        }else{
            //立即跳转
            header("Location: {$url}");
        }*/
        if($times){
            //时间大于零 输出错误信息后隔几秒跳转
            echo "<h2>{$msg}</h2>";
        }
        //等待一定时间后再刷新页面
        header("Refresh: {$times};{$url}");
        exit;
    }
}