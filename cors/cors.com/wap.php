<?php
$cb = $_REQUEST['cb']??null;

header('Content-type: application/json');

$out = ['data' => ['id' => 1, 'name' =>'lisi'],'code' => 200];
$json = json_encode($out, 254);

echo $cb ? $cb . "(" . $json . ")" : $json;