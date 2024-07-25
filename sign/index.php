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

$line = '<br/>';

echo $_SESSION['name'] . "：你好{$line }";
echo "<a href='./signout.php'>退出登录</a>", $line ;
echo "<a href='./visitor.php'>当前用登录阶段的访问此次</a>", $line ;
echo  $_SESSION['count'] ?? 1;

var_dump(session_id(),ini_get('session.gc_maxlifetime'));


// echo "<a href='./index.html'>返回登录</a>";