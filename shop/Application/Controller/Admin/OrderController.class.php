<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 10:19
 */
class OrderController extends  Controller
{
    /**
     * 显示功能
     */
        public function index(){
            $orderModel = new OrderModel();
            $result = $orderModel->getAll();
            $this->assign('result', $result);
            $this->display('index');
        }

    /**
     * 修改功能
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //接收数据
            $data = $_POST;
            $orderModel = new OrderModel();
            $result = $orderModel->update1($data);
            if ($result === false) {
                $this->redirect("index.php?p=Home&c=Order&a=edit", "添加失败" . $orderModel->getError(), 3);
            }
            //添加成功跳转首页
            $this->redirect("index.php?p=Home&c=Order&a=index");
        } else {
            $id = $_GET['id'];
            //回显一条数据
            $orderModel = new OrderModel();
            $row=$orderModel->getOne($id);
            $this->assign('row',$row);
            //回显分类数据
            $memberModel=new MembersModel();
            $rows =$memberModel->getAll();
            $this->assign('rows',$rows);
            $this->display('edit');
        }
    }
}