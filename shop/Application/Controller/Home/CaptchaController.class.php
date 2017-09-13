<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 15:17
 */
class CaptchaController extends Controller
{

    /**
     * 验证码
     */
    public  function captcha(){
        //准备数组
        $str = "23456789ABCDEFGHJKMNOPQRSTUVWXYZ";
        //打乱数组
        $string = str_shuffle($str);
        //截取数组
        $jiequ = substr($string,0,4);
        //保存到session中
        @session_start();
        $_SESSION['random_code'] = $jiequ;

        //建立画布
        $width = 330;
        $height = 40;
        $image = imagecreatetruecolor($width,$height);
        //选择颜色，填充
        $color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagefill($image,0,0,$color);
        //选择颜色，写字
        $black = imagecolorallocate($image,0,0,0);
        $white = imagecolorallocate($image,255,255,255);
        $shuzu = [$black, $white];
        imagefttext($image,15,0,$width/2.5, $height/1.3, $shuzu[mt_rand(0, 1)], './Public/Admin/Font/STSONG.TTF', $jiequ);

        //随机现
        for ($i = 1; $i < 4; $i++) {
            //随机颜色
            $color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //随机画线
            imageline($image,mt_rand(1,$width-2),mt_rand(1,$height-2),mt_rand(1,$width-2),mt_rand(1,$height-2),$color);
        }
        //白色边框
        imagerectangle($image,0,0,$width-1,$height-1,$white);
        //输出到浏览器
        header("Content-Type: image/jpeg; charset=utf8");
        imagejpeg($image);
        imagedestroy($image);
    }
}