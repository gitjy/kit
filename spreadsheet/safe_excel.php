<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;


$file = 'source/example.xlsx';
// 读取Excel文件
$spreadsheet = IOFactory::load($file);

// 获取第一个工作表
$worksheet = $spreadsheet->getActiveSheet();

foreach ($worksheet->getRowIterator() as $row) {
    $rowData = [];
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);
    foreach ($cellIterator as $cell) {
        $rowData[] = $cell->getValue();
    }
     print_r($rowData);
    // 处理每一行的数据
    // $rowData 包含当前行中的所有单元格值
}


