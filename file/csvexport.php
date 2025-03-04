<?php
/**
 * csv 文件下载 
 */
//10M文件已经很大了，通常10000条1M,10页10M
$fileName = "download";
header('Content-Encoding: UTF-8');
//声明响应内容的类型
//header("Content-type:application/vnd.ms-excel;charset=UTF-8");
header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
/*
修改后缀并不能改名文件本身csv的格式
header('Content-Disposition: attachment;filename="' . $fileName . '.xls"');
*/
//打开php标准输出流
$fp = fopen('php://output', 'a');
//添加BOM头，以UTF8编码导出CSV文件，如果文件头未添加BOM头，打开会出现乱码。
//fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
$title = ['店铺ID', '店铺名称', '店铺LOGO','经营类目', '签约主体', '店铺类型', '入驻时间', '合同', '店铺状态'];
$size = 1;
$pages = 2;
$page = 1;
//添加导出标题
while ($page <= $pages) {
	for ($i = 0; $i < $size; $i++) {
		fputcsv($fp, $title);
	}
	$page++;
}