<?php
//无刷新上传加图片裁剪控制器
namespace Home\Controller;
use Think\Controller;
class JcropController extends Controller {
    public function index(){
		$this->display("index");
	}
	
	//执行上传
	public function upload(){
		$upload = new \Think\Upload();	//实例化上传类
		$upload->maxSize = 3145728;		//设置附件上传大小
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath = './public/uploads/'; //设置附件上传目录 
		$upload->autoSub=false;
		// 上传文件 
		$info = $upload->upload();
		var_dump($info);exit;
		if(!$info) {
			// 上传错误提示错误信息
			echo "<script>window.parent.doupload('false');</script>"; 
		}else{
			echo "<script>window.parent.doupload('{$info['pic']['savename']}');</script>"; 
		}
		exit();
	}
	
	//执行裁剪
	public function  doCrop(){
		$picname = $_POST['picname'];
		$cx = $_POST['cx'];
		$cy = $_POST['cy'];
		$cw = $_POST['cw'];
		$ch = $_POST['ch'];
		$image = new \Think\Image();
		$image->open('./Public/Uploads/'.$picname);//将图片裁剪为400x400并保存为corp.jpg
		$image->crop($cw,$ch,$cx,$cy)->save('./Public/Uploads/'.$picname);
	}
}