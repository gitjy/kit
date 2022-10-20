<?php
include('contractPdf.php');


$contractNo = time();
$title = '纸鸢商户入驻服务合同';
$pdf = new ContractPdf('msyh', $title, $contractNo);

//合同第一步部分配置 载入配置
$data = [];
// 服务商或机构名称
$data['customer.master_name'] = '小天印象';
// 服务商或机构地址
$data['customer.addr'] = '团结湖';
// 服务商或机构联系人
$data['customer.card_id_name'] = '身份证名';
// 平台名称
$data['platform.name'] = '北京纸媛';
// 平台地址
$data['platform.addr'] = '丰台';
// 合同签约开始时间
$data['customer.start_date'] = date('Y 年 m 月 d 日');
// 合同签约结束时间
$data['customer.end_date'] = date('Y 年 m 月 d 日', strtotime(' -1 days ', strtotime(' +1 years')));
// 合同签约类目
$data['customer.skillName'] = '瑜伽';

$data['platform.services'] = 20;   // 服务费
$data['platform.bonds'] = 100;   // 保证金
$data['platform.paymentDays'] = 5;  //结算周期天
$data['platform.draw'] = '£美食类 首张订单金额的__%
£洗浴类 首张订单金额的__%
£按摩类 首张订单金额的__%
£医美类 首张订单金额的__%
£美容类 首张订单金额的__%
£健身类 首张订单金额的__%
£酒店类 首张订单金额的__%';
$data['platform.singkekDraw'] =  '£美食类 每张订单金额的__%
£洗浴类 每张订单金额的__%
£按摩类 每张订单金额的__%
£医美类 每张订单金额的__%
£美容类 每张订单金额的__%
£健身类 每张订单金额的__%
£酒店类 每张订单金额的__%';

//合同第二部分配置
//$chapter = __DIR__ . '/static/chapter.png';
$chapter = './static/chapter.png';
$signData['date']                    = date('Y-m-d');
$signData['platform']['name']        = '榜样';
$signData['platform']['chapter']     = $chapter;
$signData['platform']['addr']        = '朝阳门';
$signData['customer']['master_name'] = $data['customer.master_name']; //乙方名称
        $signData['platform']['custSignImg'] = $chapter;
        $signData['platform']['custSealImg'] = $chapter;
$fileName =  'doc.pdf';
$file = 'upload/' . $fileName;
//$content = "";
$content = include "static/templet.php";
$pdf->data($data)->analysis($content)->sign($signData);
//$pdf->Output('F', $file);
$pdf->Output();