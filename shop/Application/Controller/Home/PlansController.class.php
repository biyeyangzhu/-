<?php

/**
 *  美发套餐功能
 */
class PlansController extends PlatformController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $plansModel = new PlansModel();
        $result = $plansModel->getAll();
        $this->assign('result', $result);
        $this->display('index');
    }

}
