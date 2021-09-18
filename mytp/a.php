<?php

//引入自定义smart模板引擎
include "mysmart.class.php";

$tpl = './a.html';
//判断静态缓存文件是否存在，若存在则直接获取并响应
// if (file_exists($tpl . '.tmp') && filemtime(__FILE__) < filemtime($tpl. '.tmp')) {
// 	echo file_get_contents($tpl. '.tmp');
// 	exit;
// }

//实例化
$smarty = new MySmarty();

//向模板中放置信息
$smarty->assign('title', '我的自定义Smarty模板' . time());
$smarty->assign('content', 'Smart是采用PHP写的一个模板引擎，设计的目的是要将PHP和html代码分离。' . time());
$smarty->display($tpl);

