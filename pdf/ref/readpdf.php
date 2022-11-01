<?php
include('includecn.php');
/**
 * 
 * 尝试读取pdf输出
 * 
 * 
 **/



$filename = 'upload/chinese.pdf';

header('Content-Type:application/pdf');
readfile($filename); 