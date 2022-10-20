<?php
namespace Home\Controller;
use Think\Controller;
class DistrictController extends Controller {
    public function index(){
		$this->display("index");
	}
	
	//加载城市信息
	public function loaddist($upid=0){
		$mod = M("District");
		$list = $mod->where("upid=".$upid)->select();
		echo json_encode($list);
		exit();
	}
}