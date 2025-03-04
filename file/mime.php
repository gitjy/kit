<?php
/**
 * 获取文件的mime类型
 */
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$src = $_GET['name'] ?? 'test.csv';
var_dump(finfo_file($finfo, $src));