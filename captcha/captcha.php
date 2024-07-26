<?php
/**
 * 验证码
 */
class Captcha
{

    /**
     * 图片验证码的样式
     */
    static $imgFunc = 'Captcha::img2';

    /**
     * 调用验证码
     */
    public static function show()
    {
        $code = self::genCode();                //生成验证码
        //保存验证码
        self::getVCode($code);
        call_user_func(self::$imgFunc, $code);  //使用验证码生成图片
    }




    static function img($code)
    {
        $width = 100;
        $height = 30;
        //imagecreatetruecolor 定义指定大小的花板
        $image = imagecreatetruecolor($width, $height);
        //指定背景色填充  imagecolorallocate 设置画笔颜色
        $bgcolor = imagecolorallocate($image, mt_rand(90, 255), mt_rand(90, 255), mt_rand(90, 255));
        imagefill($image, 0, 0, $bgcolor);

        //干扰项 添加400个 字符
        for ($i = 0; $i < 100; $i++) {
            $x = mt_rand(0, $width);
            $y = mt_rand(-10, $height);
            $color = imagecolorallocate($image, mt_rand(90, 255), mt_rand(90, 255), mt_rand(90, 255));
            imagechar($image, 1, $x, $y, "#", $color);

        }
        $fontSize = 30;
        $space = $width/strlen($code);
        for ($i = 0, $x = 0; $i < strlen($code); $i++) {
            //在
            $x = $i === 0 ? rand(2, 5) : $x + $space - 1 + rand(0, 1);
            $y = rand(1, 5);
            $c = imagecolorallocate($image, rand(0, 99), rand(0, 99), rand(0, 99));
            imagechar($image, $fontSize, $x, $y, $code[$i], $c);
        }
        #输出到浏览器 必须指定content-type image/png
        header("Content-Type:image/png");
        imagepng($image);
        #销毁内存资源
        imagedestroy($image);
    }

    /**
     * 生成验证码
     */
    static function genCode($type = 1, $length=4)
    {
        //$code = rand(1000, 9999);
        //$code = substr(md5(uniqid()), -4);
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        switch($type) {
            case 2:
                $endIndex = 35;   //数字和小写字母
                break;
            case 3:
                $code = strlen($str)-1;
                break;
            default:
                $endIndex = 9;   //只有数字
                break;
        }
        $code = '';
        for($i=0;$i<$length;$i++){
            $code.=$str[rand(0,$endIndex)];
        }
        return $code;
    }

    /**
     * 验证 验证码
     */
    static function check($code, $isDel = true)
    {
        $vcode = self::getVCode($code, false);
        $cookieVCode = self::getVCode();
        $isOk = $vcode == $cookieVCode ? true : false;
        if ($isOk && $isDel) {
            self::delCode();
        }
        return $isOk;
        $vcode == $cookieVCode ? $isOk = true : $isOk = false;
        if ($isOk && $isDel) {
            self::delCode();
        }
        return $isOk;
    }

    /**
     * code 存在 保存验证码的md5后4位并保存到cookie
     * code 存在 客户端传递的验证码,生成验证码的md5后4位,不保存到服务器 
     * code=null 获取vcode
     * 
     */
    static function getVCode($code = null, $isSave= true)
    {
        $cookieName = 'vc' . filemtime(__FILE__) .date('Ymd');
        if (null === $code) {
            $vcode = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : null;
            return $vcode;
        }
        $vcode = substr(md5($code), 25);
        if (!$isSave) {
            return $vcode;
        }
        setcookie($cookieName, $vcode, time()+300);
        return $vcode;
    }

    static function delCode()
    {
        $cookieName = 'vc' . filemtime(__FILE__) .date('Ymd');
        setcookie($cookieName, false, 0);
    }

    static function img2($code)
    {
        $length = strlen($code);
        $height = 30;
        $width=$length*20; //验证码图片的宽度

        $im = imagecreatetruecolor($width,$height); //新建一个真彩的图像画布
        $bg[0] = imagecolorallocate($im,220,220,220); //分配一个背景颜色
        $bg[1] = imagecolorallocate($im,189,196,230); //分配一个背景颜色
        $bg[2] = imagecolorallocate($im,231,217,211); //分配一个背景颜色
        $bg[3] = imagecolorallocate($im,190,131,153); //分配一个背景颜色

        $cc[0] = imagecolorallocate($im,255,0,0); //分配一个颜色
        $cc[1] = imagecolorallocate($im,0,0,255); //分配一个颜色
        $cc[2] = imagecolorallocate($im,111,115,21); //分配一个颜色
        $cc[3] = imagecolorallocate($im,17,94,19); //分配一个颜色
        $cc[4] = imagecolorallocate($im,0,0,255); //分配一个颜色

        //2. 开始绘画
        //填充背景
        imagefill($im,0,0,$bg[rand(0,3)]);


        //绘制文本（可指定字体文件）
        for($i=0;$i<$length;$i++){
            imagettftext($im,18,rand(-30,30),$i*20+5,20,$cc[rand(0,4)],"msyh.ttf",$code[$i]);
        }

        //循环随机位置绘制干扰点
        for($i=0;$i<100;$i++){
            $color=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($im,rand(0,$width),rand(0,$height),$color);
        }
        //循环随机位置绘制干扰线
        for($i=0;$i<4;$i++){
            $color=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
            imageline($im,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),$color);
        }

        //3. 输出图像
        header("Content-Type:image/png");
        imagepng($im);

        //4. 销毁资源
        imagedestroy($im);
    }
    
}