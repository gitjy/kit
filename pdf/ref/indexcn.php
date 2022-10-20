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
$pdf->AddGBFont();





// $pdf->AddBig5Font();
// $pdf->SetFont('Big5','',20);

$pdf->AddPage();


$str = '北京欢迎您';
$str = iconv("UTF-8","gbk",$str); //将字符转换为GBK字符集

$pdf->SetFont('GB','',20);
$pdf->Cell(0,10,$str,  0, 1);
$pdf->SetFont('GB','B',20, );
$pdf->Cell(0,10,$str,  0, 1);
$pdf->SetFont('GB','I',20 );
$pdf->Cell(0,10,$str, 0, 1);
$pdf->Output();