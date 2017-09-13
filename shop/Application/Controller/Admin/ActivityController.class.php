<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 14:15
 */
class ActivityController extends Controller
{
    /**
     * 展示活动列表
     */
    public function index(){

    }

    /**
     * 添加活动
     */
    public function insert(){
        if ($_SERVER['REQUEST_METHOD']=="POST"){
            $data = $_POST;
            $activity = new ActivityModel();
            $activity->insert($data);
            $this->redirect("index.php?p=Admin&c=Activity&a=index","添加成功",3);
        }else{
            $this->display('add');
        }

    }
    /**
     * 修改活动
     */
    public function update(){
        if ($_SERVER['REQUEST_METHOD']=="POST"){
        $data = $_POST;
            $acticity = new ActivityModel();
            $acticity->update();
        }else{
            $id = $_GET['id'];
            $acticity = new ActivityModel();
            $result = $acticity->edit();
            $this->assign('result',$result);
            $this->display('edit');
        }
    }
    /**
     * 删除功能
     */
    public function delete(){
    $id=$_GET['id'];
    $activity = new ActivityModel();
    $activity->delete($id);
    $this->redirect("index.php?p=Admin&c=Activity&a=index","删除失败",3);
    }
}