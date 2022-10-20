<?php
//生成简历

$userinfo=array(
		'name'=>'张三',
		'sex'=>'男',
		'address'=>'北京'
	);



include 'PHPExcel.php';


//单元格缓存到PHP临时文件中 
$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp; 
$cacheSettings = array( 'memoryCacheSize' => '100MB'); 
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);



//从文件加载excel
$excel=PHPExcel_IOFactory::load('temp.xlsx');
//活动工作表
$sheet=$excel->getActiveSheet();

$sheet->setTitle('个人简历');

//姓名
$sheet->getCell('B2')->setValue($userinfo['name']);

//加入图片
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Photo'); 
$objDrawing->setDescription('Photo'); 
$objDrawing->setPath('./test.jpg');//图片文件名
$objDrawing->setHeight(190); //图片的大小
$objDrawing->setWidth(137);
$objDrawing->setCoordinates('E2');//图片位置 
$objDrawing->setWorksheet($excel->getActiveSheet());
$objDrawing->getShadow()->setVisible(true); 
$objDrawing->getShadow()->setDirection(45);


/*
//保存文件
$writer=PHPExcel_IOFactory::createWriter($excel,'Excel5');

$writer->save('test3.xls');
*/

//临时文件 
$file=uniqid().'.xls'; 
$show_name=$userinfo['name'].'简历.xls'; 
$write=PHPExcel_IOFactory::createWriter($excel,'Excel5'); 
$write->save($file);
 //弹出下载对话框   去手册中readfile()函数，复制下面这段即可
header('Content-Type: application/octet-stream'); 
header('Content-Disposition: attachment; filename='.$show_name); 
header('Content-Length: ' . filesize($file)); 
readfile($file);
//删除临时文件 
unlink($file);
