<?php
//导入Excel到数据库


include 'PHPExcel.php';

//从文件加载excel
$excel=PHPExcel_IOFactory::load('stu_2003.xls');

//得到活动的工作表
$sheet=$excel->getActiveSheet();

//得到有几条数据
$rows=$sheet->getHighestRow();
//循环读取数据
//因为第一行是标题，所以从2开始
for($i=2;$i<=$rows;$i++){
	$name=$sheet->getCellByColumnAndRow(0,$i)
		->getValue();
	$sex=$sheet->getCellByColumnAndRow(1,$i)
		->getValue();
	$address=$sheet->getCellByColumnAndRow(2,$i)
		->getValue();
	
	//name、address的安全处理....

	//性别处理
	if($sex=='男'){
		$sex=1;
	}else{
		$sex=0;
	}

	//生成SQL语句的values部份
	$values[]="('$name','$sex','$address')";
}

//完整的SQL
$sql="insert into stu (name,sex,address) values
".implode(',',$values);

$link=mysql_connect('localhost','root','root') or die('连接出错');
mysql_set_charset('utf8');
mysql_select_db('test');
$result=mysql_query($sql);
if($result){
	$count=mysql_affected_rows($link);
	echo "成功导入了{$count}条数据";
}





