<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 22:41
 */
class UsersController extends Controller
{
    /**
     * 会员列表
     */
    public function index(){
        $page = $_GET['page']??1;
        $condition = [];
        if(!empty($_GET['sex'])){
            $condition[] ="sex={$_GET['sex']}";
        }
        if(!empty($_GET['keyword'])){
            $condition[] ="(username like '%{$_GET['keyword']}%' or telephone like '%{$_GET['keyword']}%' or realname like '%{$_GET['keyword']}%')";//多个自动进行模糊匹配的时候需要使用()将其扩起来，作为一个整体进行判断
        }
        $usermodel=new UserModel();
        $result = $usermodel->index($page,$condition);
        $pageHtml = PageTool::show($result['count'],$result['pagesize'],$result['page'],"index.php?p=Admin&c=Member&a=index");
//        var_dump($pageHtml);exit;
        $this->assign('pagehtml',$pageHtml);
        $this->assign($result);
        $this->display('index');
    }

    /**
     * 会员的添加 头像上传
     */
    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $_POST;
            $file = $_FILES['logo'];

            /**
             * 将上传文件保存到upload文件 成功返回路径 失败返回false
             */

            $uploadModel = new UploadModel();
            $logo_path = $uploadModel->upload($file, "head/");
            if ($logo_path === false) {
                $this->redirect("index.php?p=Admin&c=member&a=insert", "上传失败！" . $uploadModel->getError(), 3);
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
                $this->redirect("index.php?p=Admin&c=Goods&a=add","缩略图制作失败！".$imageModel->getError(),3);
            }
            //制作缩略图成功，添加数据到$data中
            $data['thumb_photo'] = $thumb_logo;
            $usermodel = new UserModel();
            $usermodel->insert($data);
        }else{
//          //显示添加页面
            $this->display('add');
        }
    }
    /**
     * 会员的删除
     */
    public function delete(){
        $id = $_GET['id'];
        $usermodel = new UserModel();
        $usermodel->delete($id);
        $this->redirect('index.php?p=Admin&c=user&a=index',"删除失败",3);
    }

    /**
     * 会员的修改
     */
    public function update(){
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            $userModel = new  UserModel();
            $row = $userModel->edit($id);
            $this->assign('row', $row);
            $this->display('edit');
        } else {
            if ($_FILES['logo']['error'] == '4') {
                $id = $_POST['id'];
                $data = $_POST;
                $usermodel = new UserModel();
                $result = $usermodel->update($data);
                if ($result === false) {
                    $this->redirect("index.php?p=Admin&c=user&a=edit&id={$id}", "修改失败", 3);
                }

                $this->redirect("index.php?p=Admin&c=user&a=index", "修改成功", 3);
            } elseif ($_FILES['logo']['error'] != '4') {
                $logo = $_FILES['logo'];
                $id = $_POST['id'];
                $data = $_POST;
                $uploadModel = new UploadModel();
                //返回路径 失败 false
                $logo_path = $uploadModel->upload($logo, 'head/');
                if ($logo_path === false) {
                    $this->redirect("index.php?p=Admin&c=user&a=edit&id={$id}", "添加失败！" . $uploadModel->getError(), 3);
                }
//        将logo保存到$data中
                $data['logo'] = $logo_path;
                /**
                 * 制作缩略图
                 */
                $imageModel = new ImageModel();
                $thumb_logo = $imageModel->thumb($logo_path,100,100);
//                    var_dump($thumb_logo);exit;
                if($thumb_logo === false){//制作缩略图失败
                    $this->redirect("index.php?p=Admin&c=user&a=update","缩略图制作失败！".$imageModel->getError(),3);
                }
                //制作缩略图成功，添加数据到$data中
                $data['thumb_photo'] = $thumb_logo;
                $usermodel = new userModel();
                $result = $usermodel->update($data);
                if ($result === false) {
                    $this->redirect("index.php?p=Admin&c=user&a=edit&id={$id}", "修改失败", 3);
                }
            }
        }
        $this->redirect("index.php?p=Admin&c=user&a=index","修改成功",3);
    }
}