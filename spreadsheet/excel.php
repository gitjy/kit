<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'source/example.xlsx';
// 读取Excel文件
$spreadsheet = IOFactory::load($file);

// 获取第一个工作表
$worksheet = $spreadsheet->getActiveSheet();

// 获取行数和列数
$rowCount = $worksheet->getHighestRow();
$columnCount = $worksheet->getHighestColumn();  //最后一列比如C
var_dump($columnCount);
 
// 遍历行
for ($row = 1; $row <= $rowCount; $row++) {
    // 遍历列
    for ($col = 'A'; $col <= $columnCount; $col++) {
        // 获取单元格的值
        $cellValue = $worksheet->getCell($col . $row)->getValue();
        // 打印单元格的值
        echo $cellValue . "\t";
        //echo $row, $col, "\t";
    }
    echo "\n";
}
