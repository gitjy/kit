<?php
//自定义用户信息操作Model类
namespace Admin\Model;

use Think\Model;

class UserModel extends Model
{
	//自动验证
    protected $_validate = array(
		array('name','require','姓名必须填写！'), 
		array('userpass','/^[.]{6,18}$/','密码必须6到18位！'), 
	);
	
	//自动填充
	protected $_auto = array(
		//array('userpass','md5',3,'function'), 
		array('userpass','mymd5',3,'callback'), 
	);
	
	//自定义密码加密方式
	public function mymd5(){
		return md5(md5($_POST['userpass'])."xiaozhan");
	}
}
