<?php
/**
 * 读取+处理nginx日志
 * 
 **/
/**
$str = '219.156.152.133 - - [01/Jun/2015:14:00:45 +0800] 1.265 "GET /api1.0/my/authlogin?udid=866824021827452&version=1.1.1&client=android&device=vivo%20Y13L&appname=yuedan&market=tuiguang_0013&lan=zh_cn&lat=32.975173&lng=112.502978&openid=74493CD1949F9D610F3F6AF41AA70F2A&src=qq&accessToken=8D25815CE5C02E1D1F5E6C867A720511 HTTP/1.1" 200 208 "-" "-" -';

$my_GET = parse_query($str);
var_dump($my_GET);
**/


$handle = @fopen("auth.log", "r");
if ($handle) {
    while (($buffer = fgets($handle)) !== false) {
        $my_GET = parse_query($str);
		switch($my_GET) {
			'authlogin' :
				$user[my_GET['udid']]['src'] = $my_GET['src'];
				$user[my_GET['udid']]['client'] = $my_GET['client'];
			'usersnssendsms'
				$user[my_GET['udid']]['moblie'] = $my_GET['mobile'];
			'usersnssignin'
				unset($user[my_GET['udid']]);
		}
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
var_dump($user);

function parse_query($var)
  {
   /**
    *  Use this function to parse out the query array element from
    *  the output of parse_url().
    */
   $path = parse_url($var,PHP_URL_PATH);
   $method = strtolower(substr(strrchr($path, "/"), 1));
   $var  = parse_url($var, PHP_URL_QUERY);
   $var  = html_entity_decode($var);
   $var  = explode('&', $var);
   $arr  = array('$method' => $method);

 
  foreach($var as $val)
    {
     $x          = explode('=', $val);
     $arr[$x[0]] = $x[1];
    }
   unset($val, $x, $var);
   return $arr;
 }
