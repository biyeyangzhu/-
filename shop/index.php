<?php
    header("Content-Type: text/html;charset=utf-8");
    /**
     * 定义项目路径常量  所有的路径都以 / 结尾
     */
    defined("DS") or define("DS",DIRECTORY_SEPARATOR);//定义的目录的分隔符常量
//    defined("ROOT_PATH") or define("ROOT_PATH",__DIR__.DS);
    defined("ROOT_PATH") or define("ROOT_PATH",dirname($_SERVER['SCRIPT_FILENAME']).DS);
    defined("APP_PATH") or define("APP_PATH",ROOT_PATH."Application".DS);//Application的目录路径
    defined("FRAME_PATH") or define("FRAME_PATH",ROOT_PATH."Framework".DS);//Framework的目录路径
    defined("PUBLIC_PATH") or define("PUBLIC_PATH",ROOT_PATH."Public".DS);//Public的目录路径
    defined("UPLOADS_PATH") or define("UPLOADS_PATH",ROOT_PATH."Uploads".DS);//Uploads的目录路径
    defined("CONFIG_PATH") or define("CONFIG_PATH",APP_PATH."Config".DS);//Config的目录路径
    defined("CONTROLLER_PATH") or define("CONTROLLER_PATH",APP_PATH."Controller".DS);//Controller的目录路径
    defined("MODEL_PATH") or define("MODEL_PATH",APP_PATH."Model".DS);//Model的目录路径
    defined("VIEW_PATH") or define("VIEW_PATH",APP_PATH."View".DS);//View的目录路径
    defined("TOOLS_PATH") or define("TOOLS_PATH",FRAME_PATH."Tools".DS);//Tools的目录路径

    //引入配置文件
    $config = require CONFIG_PATH."application.config.php";

//接收链接上的请求参数
    $a = $_GET['a']??$config['app']['default_action'];//方法名称
    $c = $_GET['c']??$config['app']['default_controller'];//控制器类的名称
    $p = $_GET['p']??$config['app']['default_platform'];//代表访问的平台

    //定义当前控制器平台路径和视图平台路径
    defined("CURRENT_CONTROLLER_PATH") or define("CURRENT_CONTROLLER_PATH",CONTROLLER_PATH.$p.DS);
    defined("CURRENT_VIEW_PATH") or define("CURRENT_VIEW_PATH",VIEW_PATH.$p.DS.$c.DS);

//创建控制器类对象
    require CURRENT_CONTROLLER_PATH."{$c}Controller.class.php";
    $class_name = "{$c}Controller";//拼接类名
    $controller = new $class_name();
//调用控制器类对象上的方法
    $controller->$a();


/**
 * 类的自动加载函数
 */
function __autoload($class_name){
    //定义框架类的映射关系
    $classMapping = [
        'DB'=>TOOLS_PATH."DB.class.php",
        'Model'=>FRAME_PATH."Model.class.php",
        'Controller'=>FRAME_PATH."Controller.class.php",
//        'PageTool'=>TOOLS_PATH."PageTool.class.php"
    ];
    //根据类名加载对应的类文件
    if (isset($classMapping[$class_name])){//加载框架映射类
        require $classMapping[$class_name];
    }elseif(substr($class_name,-10) == "Controller"){//加载控制器
        require CURRENT_CONTROLLER_PATH."{$class_name}.class.php";
    }elseif (substr($class_name,-5) == "Model"){//加载模型
        require MODEL_PATH."{$class_name}.class.php";
    }elseif (substr($class_name,-4) == "Tool"){//加载工具类中的代码
        require TOOLS_PATH."{$class_name}.class.php";
    }
}


?>