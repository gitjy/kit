<?php
ini_set('session.gc_maxlifetime', 120);
$name = $_POST['name'];
$pass = $_POST['password'];
// echo $name;
// echo $pass;
$url = './index.php';
$delay = 1;
if($name == 'admin' && $pass == '123456') {
    echo '登录成功,即将跳转首页';
    session_start();
    $_SESSION['name'] = $name;
    //header('Location: ./index.php');
    header("refresh:{$delay};url={$url}");
} else {
    echo '登录失败,即将跳到登录页';
    //header('Location: ./index.html');
    header("refresh:{$delay};url={$url}");
}