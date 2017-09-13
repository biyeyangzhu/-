<?php

/**
 * 图片文件上传
 */
class UploadModel extends Model
{
    //文件允许的类型
    private $allow_types = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    //文件允许的大小 2M
    private $max_size = 2*1024*1024;
    /**
     * 期望该方法 用于上传文件
     * @param $file 文件信息
     * @param $dir 文件保存路径
     */
    public function upload($file,$dir){

        //判断文件上传是否出错
            if($file['error'] != 0){
                $this->error = "上传文件失败！";
                return false;
            }
        //判断上传文件的类型
            if(!in_array($file['type'],$this->allow_types)){
                $this->error = "上传文件类型错误！";
                return false;
            }

        //判断上传文件的大小
            if($file['size'] > $this->max_size){
                $this->error = "上传文件过大，只能上传2M以下";
                return false;
            }

        //判断是否是 http post 上传
            if(!is_uploaded_file($file['tmp_name'])){
                $this->error = "不是上传的文件！";
                return false;
            }

        //指定文件名称
            $filename = uniqid("IT_").strrchr($file['name'],".");
        //准备路径
            //工作中上传文件都是按天分目录存储
            $dirname =  UPLOADS_PATH.$dir.date("Ymd")."/";
            //判断路径是否存在
            if(!is_dir($dirname)){
                mkdir($dirname,0777,true);
            }
        //完整文件路径
            $full_name = $dirname.$filename;
//        var_dump($full_name);exit;
        if(!move_uploaded_file($file['tmp_name'],$full_name)){
            $this->error = "移动文件失败！";
            return false;
        }else{
            //移动成功，返回图片相对路径
            return str_replace(UPLOADS_PATH,"",$full_name);
        }
    }
}