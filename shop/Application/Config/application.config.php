<?php

//配置文件
return [
    'db'=>[//数据库链接信息
        'host'=>'127.0.0.1',
        'username'=>'root',
        'password'=>'root',
        'dbName'=>'haircut',
        'port'=>3306,
        'charset'=>'utf8'
    ],
    //默认访问的平台控制器方法
    'app'=>[
        'default_platform'=>'Home',
        'default_controller'=>'Login',
        'default_action'=>'Login'
    ]
];