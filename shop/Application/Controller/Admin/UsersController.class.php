<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 22:41
 */
class UsersController extends PlatformController
{
    /**
     * 会员列表
     */
    public function index(){
        $page = $_GET['page']??1;
        $condition = [];
        if(!empty($_GET['sex'])){
            $condition[] ="sex={$_GET['sex']}-1";
        }
        if(!empty($_GET['keyword'])){
            $condition[] ="(username like '%{$_GET['keyword']}%' or telephone like '%{$_GET['keyword']}%' or realname like '%{$_GET['keyword']}%')";//多个自动进行模糊匹配的时候需要使用()将其扩起来，作为一个整体进行判断
        }
        $usermodel=new UsersModel();
        $result = $usermodel->index($page,$condition);
        unset($_REQUEST['page']);
        $url = http_build_query($_REQUEST);
        $pageHtml = PageTool::show($result['count'],$result['pagesize'],$result['page'],"index.php?".$url);
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
            $data['password']=md5($data['password']);
            $file = $_FILES['logo'];
            $data['is_vip']=1;
            if ($data['recharge']>=5000){
                $data['is_vip']+=1;
            }
            /**
             * 将上传文件保存到upload文件 成功返回路径 失败返回false
             * 如果没有上传就默认使用一张图作为头像
             */
            if ($file['error']==4){
                $data['thumb_photo']="head/20170912/IT_59b798a4330fc_100x100.jpg";
                }else{
                $uploadModel = new UploadModel();
                $logo_path = $uploadModel->upload($file, "head/");
                if ($logo_path === false) {
                    $this->redirect("index.php?p=Admin&c=users&a=insert", "上传失败！" . $uploadModel->getError(), 3);
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
                    $this->redirect("index.php?p=admin&c=users&a=add","缩略图制作失败！".$imageModel->getError(),3);
                    //制作缩略图成功，添加数据到$data中
                    $data['thumb_photo'] = $thumb_logo;
                }
            }
            $usermodel = new UsersModel();
            $usermodel->insert($data);
            $this->redirect("index.php?p=admin&c=Users&a=index",'添加成功',3);
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
        $usermodel = new UsersModel();
        $usermodel->delete($id);
        $this->redirect('index.php?p=Admin&c=users&a=index',"删除成功",3);
    }

    /**
     * 会员的修改
     */
    public function update(){
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            $userModel = new  UsersModel();
            $row = $userModel->edit($id);
            $this->assign('row', $row);
            $this->display('edit');
        } else {
            if ($_FILES['logo']['error'] == '4') {
                $id = $_POST['id'];
                $data = $_POST;
                $usermodel = new UsersModel();
                $result = $usermodel->update($data);
                if ($result === false) {
                    $this->redirect("index.php?p=admin&c=users&a=edit&id={$id}", "修改失败", 3);
                }

                $this->redirect("index.php?p=Admin&c=users&a=index", "修改成功", 3);
            } elseif ($_FILES['logo']['error'] != '4') {
                $logo = $_FILES['logo'];
                $id = $_POST['id'];
                $data = $_POST;
                $uploadModel = new UploadModel();
                //返回路径 失败 false
                $logo_path = $uploadModel->upload($logo, 'head/');
                if ($logo_path === false) {
                    $this->redirect("index.php?p=Admin&c=users&a=edit&id={$id}", "添加失败！" . $uploadModel->getError(), 3);
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
                    $this->redirect("index.php?p=Admin&c=users&a=update","缩略图制作失败！".$imageModel->getError(),3);
                }
                //制作缩略图成功，添加数据到$data中
                $data['thumb_photo'] = $thumb_logo;
                $usermodel = new userModel();
                $result = $usermodel->update($data);
                if ($result === false) {
                    $this->redirect("index.php?p=Admin&c=users&a=edit&id={$id}", "修改失败", 3);
                }
            }
        }
        $this->redirect("index.php?p=Admin&c=users&a=index","修改成功",3);
    }

}