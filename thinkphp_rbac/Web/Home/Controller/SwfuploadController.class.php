<?php
//多文件上传处理Action
namespace Home\Controller;
use Think\Controller;

class SwfuploadController extends Controller{
	private $path="./Public/Uploads/swfpic/"; //指定上传文件的目录
	
	public function index(){
		$this->display("index");
	}
	
	//执行图片上传
	public function doupload(){
		//判断文件上传信息是否有效
		if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
			echo "ERROR:invalid upload";
			exit(0);
		}

		// 获取图片上传临时文件名及路径
		$img = imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
		if (!$img) {
			echo "ERROR:could not create image handle ". $_FILES["Filedata"]["tmp_name"];
			exit(0);
		}
		//保存图片信息
		$filename = md5($_FILES["Filedata"]["tmp_name"] + rand()*100000).".jpg";
		move_uploaded_file($_FILES["Filedata"]["tmp_name"],$this->path.$filename);
		
		//进行图片缩放小图
		$this->loadpic($img,$filename);
	}
	
	private function loadpic($img,$filename){
		$width = imageSX($img);
		$height = imageSY($img);
		$target_width = 100;
		$target_height = 100;
		$target_ratio = $target_width / $target_height;

		$img_ratio = $width / $height;

		if ($target_ratio > $img_ratio) {
			$new_height = $target_height;
			$new_width = $img_ratio * $target_height;
		} else {
			$new_height = $target_width / $img_ratio;
			$new_width = $target_width;
		}

		if ($new_height > $target_height) {
			$new_height = $target_height;
		}
		if ($new_width > $target_width) {
			$new_height = $target_width;
		}

		$new_img = ImageCreateTrueColor(100, 100);
		$c = imagecolorallocate($new_img,255,255,255); //分配一个颜色
		imagefill($new_img,0,0,$c); //填充背景颜色
		//if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) {	// Fill the image black
		//	echo "ERROR:Could not fill new image";
		//	exit(0);
		//}

		if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
			echo "ERROR:Could not resize image";
			exit(0);
		}
		imagejpeg($new_img,$this->path."s_".$filename); //输出图像。
		echo "FILEID:".__ROOT__."/Public/Uploads/swfpic/s_".$filename;
		exit();
	}
}
