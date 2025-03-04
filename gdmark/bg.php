<?php
$file = './source/gengous.jpg';
$im = imagecreatefromjpeg($file);

//背景设为透明
imagesavealpha($im , true);//设置保存PNG时保留透明通道信息

$red = imagecolorallocate($im, 255, 0, 0);
$alpha = imagecolorallocatealpha($im, 0, 0, 0, 50);
//imagefill($im,0,0, $Alpha);



//填充矩形
imagefilledrectangle($im, 200, 300, 300, 500, $alpha);


$type = 'jpeg';
header('Content-Type: image/' . $type);
$func = 'image' . $type;
$gd =  './source/' . 'gd.' . $type;
$func($im);