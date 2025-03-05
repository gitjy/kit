<?php
return array(
	//'配置项'=>'配置值'
	//设置当前允许访问的模块
	'MODULE_ALLOW_LIST' => array('Home','Admin'),
	'DEFAULT_MODULE'    => 'Home',  //默认模块
    'URL_MODEL'          => '3', //URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
	
	 /* 数据库设置 */
    'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'lamp',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '',        // 端口
    'DB_PREFIX'             =>  'lamp_',    // 数据库表前缀
);