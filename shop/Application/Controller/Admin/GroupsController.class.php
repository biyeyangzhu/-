<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 19:26
 */
class GroupsController extends PlatformController
{
    /**
     * 显示页面
     */
    public function index()
    {
        //调用模型
        $groupsModel = new groupsModel();
        $result = $groupsModel->getAll();
        //分配页面
        $this->assign('result', $result);
        $this->display('index');
    }

    /**
     * 删除数据
     */
    public function delete(){
      //根据ID删除数据
        $id = $_GET['id'];
//        var_dump($id);die;
        $groupsModel = new groupsModel();
        $result =$groupsModel->delete($id);
//        var_dump($result);die;
        //删除成功 跳转
        $this->redirect('index.php?p=Admin&c=Groups&a=index');
    }

    /**
     * 添加功能
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $_POST;
            $groupsModel = new groupsModel();
            $result = $groupsModel->insert($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=Groups&a=add", "添加失败" . $groupsModel->getError(), 3);
            }
            //添加成功跳转页面
            $this->redirect("index.php?p=Admin&c=Groups&a=index");
        } else {
            $this->display('add');
        }
    }


    /**
     * 修改功能
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //接收数据
            $data = $_POST;
            $groupsModel = new groupsModel();
            $result = $groupsModel->update($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=Groups&a=edit", "添加失败" . $groupsModel->getError(), 3);
            }
            //添加成功跳转首页
            $this->redirect("index.php?p=Admin&c=Groups&a=index");
        } else {
            $id = $_GET['id'];
            $groupsModel = new groupsModel();
            $rows = $groupsModel->getOne($id);
            //分配页面显示数据
//            var_dump($rows);die;
            $this->assign('rows', $rows);
            $this->display('edit');
        }
    }

}