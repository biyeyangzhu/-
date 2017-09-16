<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 15:22
 */
class CodesController extends PlatformController
{
    /**
     * 显示功能
     */
    public  function index(){
        $codesModel = new CodesModel();
        $result = $codesModel->getAll();
        $this->assign('result',$result);
        $this->display('index');
    }

    /**
     * 删除功能
     */
    public function delete(){
        $id=$_GET['id'];
        $codesModel = new CodesModel();
        $result = $codesModel->delete($id);
        if($result ===false){
            $this->redirect('index.php?p=Admin&c=Codes&a=index',"删除失败".$codesModel->getError(),3);
        }
       $this->redirect('index.php?p=Admin&c=Codes&a=index');
    }

    /**
     * 添加功能
     */
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data=$_POST;
            $data['code']=time();
            $codesModel = new CodesModel();
            $result = $codesModel->insert($data);
            if ($result === false) {
                $this->redirect("index.php?p=Admin&c=Codes&a=add", "添加失败" . $codesModel->getError(), 3);
            }
            $this->redirect("index.php?p=Admin&c=Codes&a=index");
        }else{
            $codesModel = new CodesModel();
            $result = $codesModel->get();
            $this->assign('result',$result);
              $this->display('add');
        }

    }

    /**
     * 查询一条语
     */
    public  function edit(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $deta = $_POST;
            $codes = new CodesModel();
            $result = $codes->update($deta);
            if($result === false){
                $this->redirect('index.php?p=Admin&c=Codes&a=edit',"修改失败",$codes->getError(),3);
            }
            $this->redirect('index.php?p=Admin&c=Codes&a=index');
        }else{
            $id = $_GET['id'];
            $codeModel = new CodesModel();
            $rows = $codeModel->getOne($id);
            $this->assign('rows',$rows);
            //查询会员数据分配到视图
            $result = $codeModel->get();
            $this->assign("result",$result);
            $this->display('edit');
        }
    }
}