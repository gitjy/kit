<?php

$file = './source/mark.png';
$im = imagecreatefrompng($file);
imagesavealpha($im , true);//设置保存PNG时保留透明通道信息


 $red = imagecolorallocate($im, 255, 0, 0);
 $green = imagecolorallocate($im, 0, 255, 0);
 $white = imagecolorallocate($im, 255, 255, 255);
 $black = imagecolorallocate($im, 0, 0, 0); 
 $blackAlpha = imagecolorallocatealpha($im, 0, 0, 0, 1);

 //imagefill($im,0, 0, $white);


//背景设为透明三
//imagecolortransparent($im, $red);


$type = 'png';
header('Content-Type: image/' . $type);
$func = 'image' . $type;
$gd =  './source/' . 'gd.' . $type;
$func($im);
$func($im, $gd);

imagedestroy($im);
