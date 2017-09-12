<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 16:14
 */
class CaptchaController extends Controller
{
    public function captcha()
    {
        //准备数组
        $str = "23456789ABCDEFGHGKMNPQRSTUVWXYZ";
        //打乱数组
        $string = str_shuffle($str);
        //截取数组
        $jiequ = substr($string, 0, 4);
        //保存到session中
        @session_start();
        $_SESSION['random_code'] = $jiequ;
//        var_dump($_SESSION);die;
        //建立画布
        $width = 370;
        $height = 40;
        $image = imagecreatetruecolor($width, $height);
        //选择颜色  填充
        $color = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imagefill($image, 0, 0, $color);
        //选择颜色，写字
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        //选择一个数组将颜色放入
        $shuzu = [
            $black,
            $white
        ];
        imagefttext($image,15,0,$width/2.5, $height/1.3, $shuzu[mt_rand(0, 1)], './Public/Admin/Font/STSONG.TTF', $jiequ);

        //随机现
        for ($i = 1; $i < 5; $i++) {
            //随机颜色
            $color = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            //随机线
            imageline($image, mt_rand(1, $width - 2), mt_rand(1, $height - 2), mt_rand(1, $width - 2), mt_rand(1, $height - 2), $color);
        }

        //白色边框
        imagerectangle($image, 0, 0, $width - 1, $height - 1, $white);
        //输出到浏览器
        header("Content-Type: image/jpeg; charset=utf-8");
        imagejpeg($image);
        //关闭
        imagedestroy($image);
    }
}