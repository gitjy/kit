<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$url = U("Admin/Index/index");
       echo "<h3><a href='{$url}'>进入网站后台:基于角色的权限管理(RBAC)</a></h3>";
	   
	   //使用Ajax实现级联操作。
	   $url = U("District/index");
       echo "<h3><a href='{$url}'>使用Ajax实现城市信息级联操作</a></h3>";
	   //aabbcc(); //使用自定义公共函数
	  
	   $url = U("Jcrop/index");
       echo "<h3><a href='{$url}'>无刷新上传和裁剪技术</a></h3>";
	   
	   $url = U("Swfupload/index");
       echo "<h3><a href='{$url}'>Swfupload多文件上传技术</a></h3>";
	   
	   
	   
	   //使用自定类
	   //$p = new \Home\Org\Person();
	   //$p->add();
	}
}