<?php
include "check.php";

$str = 'hello';
$t = microtime(true);
$is = Check::word($str);
$t =sprintf('%.2f',(microtime(true)- $t)* 1000);
var_dump($is, $t. 'ms');