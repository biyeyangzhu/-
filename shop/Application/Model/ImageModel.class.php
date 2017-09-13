<?php

/**
 * 图片处理模型
 */
class ImageModel extends Model
{
    /**
     * 制作缩略图的方法
     * @param $src_path 原图路径 相对路径，相对于Uploads文件夹
     * @param $thumb_width 目标图片的宽
     * @param $thumb_height 目标图片的高
     */
    public function thumb($src_path,$thumb_width,$thumb_height){
        //>>1.打开原图
            //处理原图路径
            $src_path = UPLOADS_PATH.$src_path;
            if(!is_file($src_path)){
                //判断原图路径是否存在
                $this->error = "原图不存在！";
                return false;
            }
            //获取原图的宽高
            $src_size = getimagesize($src_path);
            list($src_width,$src_height) = $src_size;

            /**
             * 处理图片创建函数，动态的拼接函数
             * imagecreatefrom + 图片格式
             * 只需要获取图片格式即可
             */
            //得到图片的类型
            $mime = $src_size['mime'];//image/jpeg
            $extension = explode("/",$mime)[1];
            //imagecreatefrom + 图片格式
            $imagecreate_func = "imagecreatefrom".$extension;

            $src_image = $imagecreate_func($src_path);

        //>>2.创建新画布
            $thumb_image = imagecreatetruecolor($thumb_width,$thumb_height);
            //补白
            $white = imagecolorallocate($thumb_image,255,255,255);
            imagefill($thumb_image,0,0,$white);
        //>>3.拷贝原图到新图
            //等比例缩放 计算最大缩放比例 原图除以目标图的宽高
            $scale = max($src_width/$thumb_width,$src_height/$thumb_height);

            //计算缩放后的尺寸 原图除以比例
            $width = $src_width/$scale;
            $height = $src_height/$scale;

            //居中
            $result = imagecopyresampled($thumb_image,$src_image,($thumb_width-$width)/2,($thumb_height-$height)/2,0,0,$width,$height,$src_width,$src_height);
            if($result===false){
                $this->error = "重采样失败！";
                return false;
            }
        //>>4.保存图片
        /**
         * goods\20170906\IT_59af6d23e8082.jpg 原图
         * goods\20170906\IT_59af6d23e8082_100x100.jpg 缩略图
         */
            //处理缩略图的路径
            $pathinfo = pathinfo($src_path);//获取路径信息
            $thumb_path = $pathinfo['dirname']."/".$pathinfo['filename']."_{$thumb_width}x{$thumb_height}.".$pathinfo['extension'];

            /*
             * 动态获取输出图片的函数
             * image + 图片格式
             */
            $image_func = "image".$extension;

//            imagepng($thumb_image,$thumb_path);
            $image_func($thumb_image,$thumb_path);

        //>>5.关闭图片
            imagedestroy($thumb_image);
            imagedestroy($src_image);

        //>>6.返回缩略图路径
            return str_replace(UPLOADS_PATH,"",$thumb_path);
    }
}