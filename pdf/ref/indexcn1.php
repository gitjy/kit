<?php
include('includecn.php');
/**
 * 
 * 支持中文
 * chinese.php
 * 
 * 必须将字符转换为GBK字符集，否则还是乱码
 *
 * 为中文字体起家族名，和中文名,设置多个相当于起别名，还是同一字体类型
 * 设置字体，没有调用底层AddFont方法，自己封装了字体
 **/

$pdf=new PDF_Chinese();

$pdf->AddGBFont('simsun','宋体');
$pdf->AddGBFont('simhei','黑体');
$pdf->AddGBFont('simkai','楷体_GB2312');
$pdf->AddGBFont('sinfang','仿宋_GB2312');
$pdf->AddGBFont('hanzi','汉字');
$pdf->AddPage();

$str = '简体中文汉字 LOVE is hand would to touch but back ';

//将字符转换为GBK字符集
$str = iconv("UTF-8","gbk",$str);

$pdf->SetFont('simsun','',20);
$pdf->Write(10,$str);
$pdf->ln();
$pdf->SetFont('simhei','',20);
$pdf->Write(10,$str);
$pdf->ln();
$pdf->SetFont('simkai','',20);
$pdf->Write(10,$str);
$pdf->ln();
$pdf->SetFont('sinfang','',20);
$pdf->Write(10,$str);
$pdf->ln();

$pdf->SetFont('hanzi','',20);
$pdf->Write(10,$str);
$pdf->ln();


$pdf->Output();