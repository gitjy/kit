<?php
//遮盖层
$coverFilename = 'cover.png';
$slideFilename = 'slide.png';
list($width, $height, $type, $attr) = getImageSize($coverFilename);
$cover = imagecreatefrompng($coverFilename);
//生成滑块图画板
$img = imagecreatetruecolor($width, $height);
//设定滑块透明通道信息
imagesavealpha($img, true);
$bg = imagecolorallocatealpha($img, 255, 0, 0, 127);
imagefill($img, 0, 0, $bg);

//背景层
$fullFilename = 'background.jpg';
$bgFilename = 'bg.jpg';

//生成背景画板
$bg_width = 450;
$bg_height = 300;
$im_full = imagecreatefromjpeg($fullFilename);
$background = imagecreatetruecolor($bg_width, $bg_height);
imagecopy($background,$im_full,0,0,400,400,$bg_width, $bg_height);


//处理背景层和滑块
$x = rand(50, $bg_width-$width-1);
$y = rand(50, $bg_height-$height-1);
$widthMax = $x + $width;
$heightMax = $y + $height;

//使用设置点方式画背景和滑块
for($i = $x;$i< $widthMax;$i++) {
	for($j = $y;$j < $heightMax;$j++) {
		//获取遮盖层当前点的颜色
		$coverColor = imagecolorat($cover, $i-$x, $j-$y);

		$bgColor = imagecolorat($background, $i, $j);
		$s = imagecolorallocatealpha($background, 192, 192, 192, 45);
		//黑色位置填充
		if (0 == $coverColor) {
			imagesetpixel($background, $i, $j, $s);	//填充背景
			imagesetpixel($img, $i-$x, $j-$y, $bgColor);	//填充滑块
		}
	}
}

//背景图
imagepng($background, $bgFilename);

//header('Content-type: image/png');
imagepng($img, $slideFilename);