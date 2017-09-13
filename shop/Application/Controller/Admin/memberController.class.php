<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 11:12
 */
class MemberController extends Controller
{
    /**
     * 员工列表
     */
    public function index(){

        $page = $_GET['page']??1;
        $condition = [];

        //查询所有的员工数据
        $memberModel=new MembersModel();
        $result =$memberModel->index($page,$condition);
        //查询所有的分类数据
        $groupsModel = new groupsModel();
        $groups = $groupsModel->getAll();
        $groupname=$groupsModel->getgroupname();
        foreach ($result['list'] as &$value){
            $value['group_id']=$groupname[$value['group_id']];
        }
        //分配商品数据到页面
        $this->assign($result);
        //分配 商品分类到页面
        $this->assign('group',$groups);
        //3.显示页面
        $this->display('index');

    }

    /**
     * 添加功能   上传文件
     */
    public function insert(){
        if ($_SERVER['REQUEST_METHOD']=="POST"){
            $data =$_POST;
            $file = $_FILES['logo'];

            //将上传文件保存到upload文件 成功返回路径 失败返回false

            $uploadModel = new UploadModel();
            $logo_path = $uploadModel->upload($file,"head/");
            if ($logo_path===false){
                $this->redirect("index.php?p=Admin&c=member&a=insert","上传失败！".$uploadModel->getError(),3);
            }
            //上传成功 保存到$data中
            $data['photo'] = $logo_path;
            /**
             * 制作缩略图
             */
            $imageModel = new ImageModel();
            $thumb_logo = $imageModel->thumb($logo_path,100,100);
//                    var_dump($thumb_logo);exit;
            if($thumb_logo === false){//制作缩略图失败
                $this->redirect("index.php?p=Admin&c=member&a=add","缩略图制作失败！".$imageModel->getError(),3);
            }
            //制作缩略图成功，添加数据到$data中
            $data['thumb_photo'] = $thumb_logo;
            $member = new membersModel();
            $member->insert($data);
        }else{
//            添加显示页面  显示员工分组
            $groups=new groupsModel();
            $groups = $groups->getAll();
            $this->assign('group',$groups);
            $this->display('add');
        }

    }

    /**
     * 修改功能
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            $memberModel = new  membersModel();
            $row = $memberModel->edit($id);
            $groupsModel = new groupsModel();
            $groups = $groupsModel->getAll();
            $this->assign('group', $groups);
            $this->assign('row', $row);
            $this->display('edit');
        } else {
            if ($_FILES['logo']['error'] == '4') {
                $id = $_POST['id'];
                $data = $_POST;
                $membermodel = new membersModel();
                $result = $membermodel->update($data);
                if ($result === false) {
                    $this->redirect("index.php?p=Admin&c=member&a=edit&id={$id}", "修改失败", 3);
                }

                $this->redirect("index.php?p=Admin&c=member&a=index", "修改成功", 3);
            } elseif ($_FILES['logo']['error'] != '4') {
                $logo = $_FILES['logo'];
                $id = $_POST['id'];
                $data = $_POST;
                $uploadModel = new UploadModel();
                //返回路径 失败 false
                $logo_path = $uploadModel->upload($logo, 'head/');
                if ($logo_path === false) {
                    $this->redirect("index.php?p=Admin&c=member&a=edit&id={$id}", "添加失败！" . $uploadModel->getError(), 3);
                }
//        将logo保存到$data中
                $data['logo'] = $logo_path;
                $membermodel = new MembersModel();
                $result = $membermodel->update($data);
                if ($result === false) {
                    $this->redirect("index.php?p=Admin&c=member&a=edit&id={$id}", "修改失败", 3);
                }
            }
        }
        $this->redirect("index.php?p=Admin&c=member&a=index","修改成功",3);
    }
    /**
     * 删除功能
     */
    public function delete(){
    $id=$_GET['id'];
    $memberModel = new memberModel();
    $memberModel->delete($id);
    }

}