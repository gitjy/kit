<?php
//fgetcsv只能解析csv，不能解析excel
$filename = 'test.csv';
$row = 0;
if (($handle = fopen($filename, "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    $num = count($data);
	    echo "<p> $num fields in line $row: <br /></p>\n";
	    $row++;
	    var_dump($data);
	    /*for ($c=0; $c < $num; $c++) {
	        echo $data[$c] . "<br />\n";
	    }*/
	}
}
fclose($handle);
