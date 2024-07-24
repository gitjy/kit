<?php
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

var_dump(ini_get('session.save_path'), session_id());



// echo "<a href='./index.html'>返回登录</a>";