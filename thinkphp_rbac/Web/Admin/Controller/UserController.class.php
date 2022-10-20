<?php
namespace Admin\Controller;
use Admin\Controller;

//用户信息控制器
class UserController extends CommonController {
    //封装搜素条件
	public function _filter(&$map){
		//搜索条件有值则做封装
		if(!empty($_REQUEST['keyword'])){
			$where['username']  = array('like', "%{$_REQUEST['keyword']}%");
			$where['name']  = array('like',"%{$_REQUEST['keyword']}%");
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
		}
		//判断是否有角色信息搜索
		if(!empty($_REQUEST['roleid'])){
			$list = M("User_role")->where("rid={$_REQUEST['roleid']}")->select();
			if($list && count($list)>0){
				$uid=array();
				foreach($list as $v){
					$uid[]=$v['uid'];
				}
				//封装uid的条件
				$map["id"]=array("in",$uid);
			}
		}
	}
	
	//浏览当前用户的角色信息
	public function rolelist($uid=0){

		//1. 获取当前用户信息
		$user = M("User")->find($uid);
		$this->assign("user",$user);
		//2. 获取所有角色信息
		$rolelist = M("Role")->select();
		$this->assign("rolelist",$rolelist);
		//3. 获取当前用户的角色信息
		$res = M("User_role")->where("uid=".$uid)->select();
		//对获取的结果进行处理
		$rids=array();
		foreach($res as $v){
			$rids[]=$v['rid'];
		}
		$this->assign("rids",$rids);
		
		$this->display("rolelist");
	}
	
	//执行角色信息的保存
	public function saverole(){
		//获取被操作的用户信息
		$uid = $_POST['uid'];
		$rid = $_POST['rid'];
		$mod = M("User_role");
		//删除当前用户的所有角色信息
		$mod->where("uid=".$uid)->delete();
		//将当前选择的角色信息添加上去
		if(is_array($rid)){
			foreach($rid as $v){
				$data['rid']=$v;
				$data['uid']=$uid;
				$mod->data($data)->add();
			}
		}
		$this->success("修改成功！");
	}
}