<?php
/**
 * 查看配置信息
 */

require('include.php');

$pdf = new FPDF('P', 'mm', 'a4');
$data['pageWidth'] = $pdf->GetPageWidth();
$data['pageHeight'] = $pdf->GetPageHeight();

var_dump($data);

