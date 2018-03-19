<?php
	
//包含文件	PHPExcel.php
include 'PHPExcel.php';

//实例化工作簿
$excel=new PHPExcel();

//得到当前活动工作表
$sheet=$excel->getActiveSheet();

//设置
$sheet->getCell('A1')->setValue('这是一个测试');

//把A1单元格的内容，取出并显示
echo $sheet->getCell('A1')->getValue();

//设A1单元格的字体大小
$sheet->getStyle('A1')->getFont()->setSize(18);
//设A1单元格的字体名称
$sheet->getStyle('A1')->getFont()->setName('黑体');
//A1单元格字体加粗
$sheet->getStyle('A1')->getFont()->setBold(true);
//A1单元格字段颜色
$sheet->getStyle('A1')->getFont()->getColor()->setRGB('00FF00');

//A列的宽度
$sheet->getColumnDimension('A')->setWidth(60);
//第一行的高度
$sheet->getRowDimension('1')->setRowHeight(40);


//分隔符和小数数位
$sheet->getCell('A5')->setValue(12345);
$sheet->getStyle('A5')->getNumberFormat()->setFormatCode('#,##0.00');

//前导0
$sheet->getCell('A6')->setValue(123);
$sheet->getStyle('A6')->getNumberFormat()->setFormatCode('000000');

//合并多个单元格
$sheet->mergeCells('B7:C9');
//取消合并
//$sheet->unmergeCells('B7:C9');

//保护单元格
$sheet->getProtection()->setSheet(true);
$sheet->protectCells('A7:A10','lamp');//允许编辑的区域,lamp是密码

//取消保护
//$sheet->getProtection()->setSheet(false);

//保存文件
$writer=PHPExcel_IOFactory::createWriter($excel,'Excel5');
//Excel5-->office 97-2003
//Excel2007  -->office2007 2010 ..

$writer->save('test1.xls');