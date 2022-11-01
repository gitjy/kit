<?php
include('includecn.php');
/**
 * 
 * 支持中文
 * chinese.php
 * 
 * 
 **/

$pdf=new PDF_Chinese();


$family = 'abc'; //字体名字随便起

$pdf->AddGBFont($family);





// $pdf->AddBig5Font();
// $pdf->SetFont('Big5','',20);

$pdf->AddPage();


$str = '北京欢迎您';
$str = iconv("UTF-8","gbk",$str); //将字符转换为GBK字符集


$pdf->SetFont($family,'',20);
$pdf->Cell(0,10,$str,  0, 1);
//不传family,使用上次字体设置
$pdf->SetFont('','B',20, );
$pdf->Cell(0,10,$str,  0, 1);
$pdf->SetFont('','I',20 );
$pdf->Cell(0,10,$str, 0, 1);
//下划线
$pdf->SetFont('','U',20 );
$pdf->Cell(0,10,$str, 0, 1);

$dest = 'F';
$filename = 'upload/chinese.pdf';

$dest = 'I';
$pdf->Output($dest, $filename);