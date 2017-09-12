<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 15:12
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

    /**
     * 增加功能
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $_POST;
            $panlsModel = new PlansModel();
            $result = $panlsModel->insert($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=Plans&a=add", "添加失败" . $panlsModel->getError(), 3);
            }
            //添加成功跳转页面
            $this->redirect("index.php?p=Admin&c=Plans&a=index");
        } else {
            $this->display('add');
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        //根据ID删除数据
        $id = $_GET['id'];
//        var_dump($id);die;
        $plansModel = new PlansModel();
        $plansModel->delete($id);
        //删除成功 跳转
        $this->redirect('index.php?p=Admin&c=Plans&a=index');
    }

    /**
     * 修改功能
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //接收数据
            $data = $_POST;
            $plansModel = new PlansModel();
            $result = $plansModel->update($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=Plans&a=edit", "添加失败" . $plansModel->getError(), 3);
            }
            //添加成功跳转首页
            $this->redirect("index.php?p=Admin&c=Plans&a=index");
        } else {
            $id = $_GET['id'];
            $plansModel = new PlansModel();
            $rows = $plansModel->getOne($id);
            //分配页面显示数据
//            var_dump($rows);die;
            $this->assign('rows', $rows);
            $this->display('edit');
        }
    }
}
