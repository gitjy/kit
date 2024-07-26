<?php
ini_set('session.gc_maxlifetime', 60);
# 百分比启动垃圾回收机制
ini_set('session.gc_probability',1);
ini_set('session.gc_divisor',1);
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

echo  "访问次数:". $_SESSION['count'],"<br>";

//打印session文件内容内容,$_SESSION变化还未写入session文件
echo "1.打印session文件内容内容,\$_SESSION变化还未写入session文件<br>";
var_dump(file_get_contents('/var/tmp/sess_'.session_id()));

echo "1.session.gc_maxlifetime:" . ini_get('session.gc_maxlifetime'). ",   session_id:" . session_id();


