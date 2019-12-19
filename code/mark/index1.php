<?php
$slideFilename = 'slide1.png';
$bgFilename = 'bg1.jpg';
//遮盖层
list($width_z, $height_z, $type_z, $attr_z) = getimagesize("cover.png");
$cover = imagecreatefrompng("cover.png");
//创建一个和遮盖层同样大小的图片
$img = imagecreatetruecolor($width_z, $height_z);
imagesavealpha($img, true);
$bg = imagecolorallocatealpha($img, 255, 0, 0, 127);
imagefill($img, 0, 0, $bg);

//背景层
$fullFilename = 'background.jpg';
$width_t = $bg_width = 450;
$height_t = $bg_height = 300;
$im_full = imagecreatefromjpeg($fullFilename);
$background = imagecreatetruecolor($bg_width, $bg_height);
imagecopy($background,$im_full,0,0,400, 400,$bg_width, $bg_height);
//list($width_t, $height_t, $type_t, $attr_t) = getimagesize("background.jpg");

$width_max = $width_t-$width_z-10;
$height_max = $height_t-$height_z-10;

$width_ini = rand($width_z+10,$width_max);
$height_ini = rand(10,$height_max);

$width_limit = $width_ini + $width_z;
$height_limit = $height_ini + $height_z;

for ($i=$width_ini; $i < $width_limit; $i++) { 
    for ($j=$height_ini; $j < $height_limit; $j++) { 

        $color2 = imagecolorat($background, $i, $j);
        
        //判断索引值区分具体的遮盖区域
        if(imagecolorat($cover, $i-$width_ini, $j-$height_ini) == 0){
            imagesetpixel($img, $i-$width_ini, $j-$height_ini, $color2);
        }


        $color1 = imagecolorat($cover, $i-$width_ini, $j-$height_ini);
        $s = imagecolorallocatealpha($background, 192, 192, 192, 45);
        if($color1 == 0){
            imagesetpixel($background,$i,$j,$s);
        }
        
    }
}

//生成背景图
imagepng($background, $bgFilename);
//生成滑块图
imagepng($img, $slideFilename);