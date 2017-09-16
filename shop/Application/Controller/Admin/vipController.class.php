<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/16
 * Time: 0:34
 */
class vipController extends PlatformController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $vipModel = new vipModel();
        $result = $vipModel->getAll();
        $this->assign('rows', $result);
        $this->display('index');
    }

    /**
     * 增加功能
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $_POST;
            $panlsModel = new vipModel();
            $result = $panlsModel->insert($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=vip&a=add", "添加失败" . $panlsModel->getError(), 3);
            }
            //添加成功跳转页面
            $this->redirect("index.php?p=Admin&c=vip&a=index");
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
        $vipModel = new vipModel();
        $vipModel->delete($id);
        //删除成功 跳转
        $this->redirect('index.php?p=Admin&c=vip&a=index');
    }

    /**
     * 修改功能
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //接收数据
            $data = $_POST;
            $vipModel = new vipModel();
            $result = $vipModel->update($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=vip&a=edit", "修改失败" . $vipModel->getError(), 3);
            }
            //添加成功跳转首页
            $this->redirect("index.php?p=Admin&c=vip&a=index");
        } else {
            $id = $_GET['id'];
            $vipModel = new vipModel();
            $rows = $vipModel->edit($id);
            //分配页面显示数据
//            var_dump($rows);die;
            $this->assign('row', $rows);
            $this->display('edit');
        }
    }
}