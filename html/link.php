<?php

$id= $_GET['id'] ?? 0;

if (!$id) {
	$data = [
	['id' => 2, 'name' => '北京'],
	['id' => 3, 'name' => '天津'],
	['id' => 4, 'name' => '上海'],
	['id' => 5, 'name' => '重庆'],
	['id' => 6, 'name' => '广东'],
	['id' => 7, 'name' => '台湾'],
  ];
} else {
	$data = [
	['id' => 20, 'name' => '朝阳'],
	['id' => 21, 'name' => '海淀'],
	['id' => 22, 'name' => '东城'],
	['id' => 23, 'name' => '西城'],
	['id' => 24, 'name' => '昌平'],
	['id' => 25, 'name' => '通州'],
	['id' => 26, 'name' => '大兴'],
	['id' => 27, 'name' => '房山'],
	['id' => 28, 'name' => '丰台'],
	['id' => 29, 'name' => '石景山'],
	['id' => 30, 'name' => '门头沟'],
	['id' => 31, 'name' => '延庆'],
	['id' => 32, 'name' => '怀柔'],
	['id' => 33, 'name' => '密云'],
	['id' => 34, 'name' => '顺义'],
	['id' => 35, 'name' => '平谷'],
  ];

  $data = array_slice($data,($id-2) * count($data)/6,count($data)/6);
}
echo json_encode($data, 384); 