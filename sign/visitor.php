<?php
session_start();

if (!isset($_SESSION['name'])) {
    echo "未登录";
    header("location:./index.html");
    exit;
}

if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}

echo  $_SESSION['count'];

//打印session文件内容内容,$_SESSION变化还未写入session文件
echo "<br>";
var_dump(file_get_contents('/var/tmp/sess_'.session_id()));

