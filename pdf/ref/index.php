<?php
/*
 * 1.初始化类
 * 2.添加分页
 * 3.设置字体
 * 4.写数据
 * 5.输出
 *
 *  * ** 内置字体不支持中文
 * 可用的内置字体名可以在font目录查找，后缀增加b,i,bi是同家族字体对应的style
 *
 *
 * */

require('include.php');



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('courier','',16);


//$pdf->SetLeftMargin(50); //定义左边边界起始位置 //设置左边界起始位置，x也为此值
//var_dump($pdf->getX());
//$pdf->setX(10);    //定义x的偏移量

$str = 'Hello World!';



/*无效
$str = '简体中文汉字';
$str = iconv("UTF-8","gbk",$str); //将字符转换为GBK字符集
 */
$pdf->Cell(40,10,$str);
$pdf->Cell(40,15,$str);
$pdf->Output();


