<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/16
 * Time: 0:34
 */
class ruleController extends PlatformController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $ruleModel = new ruleModel();
        $result = $ruleModel->getAll();
        $this->assign('rows', $result);
        $this->display('index');
    }

}