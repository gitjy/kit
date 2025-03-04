<?php
$_ENV['incr'] = [__DIR__,__DIR__ . '/oauth2/', dirname(__DIR__) . '/common/'];
//引入文件
spl_autoload_register(function ($n) {
	foreach ($_ENV['incr'] as $dir) {
		$files = [linkPath($dir, strtolower($n) .'.php'), linkPath($dir, $n .'.php')];
		$files[] = linkPath($dir, trim(strtolower(preg_replace('/[A-Z]/', "/$0", $n)), '/') . '.php');
		foreach ($files as $f) {
			if (file_exists($f)) {
			 require_once $f;
			 return true;
			}
		}
		
	}
});

//连接两个路径
function linkPath($dir, $filename)
{
    return rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($filename,DIRECTORY_SEPARATOR);
}
