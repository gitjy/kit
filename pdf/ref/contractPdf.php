<?php
include('includecn.php');
/**
 * 
 * 合同类 支持中文 
 * chinese.php
 * 
 * 必须将字符转换为GBK字符集，否则还是乱码
 *
 * 为中文字体起家族名，和中文名,设置多个相当于起别名，还是同一字体类型
 * 设置字体，没有调用底层AddFont方法，自己封装了字体
 **/



class ContractPdf extends PDF_Chinese
{

    /**
     * 设置页眉
     */
    public function Header()
    {
        $this->SetX(150);
        $this->SetTextColor(100, 100, 100);
        $this->SetFont('msyh', '', 8);
        $this->SetFontSize(8);
        $this->Write(10, iconv("UTF-8", "gbk", '合同编号: '.$this->contractNo));
        $this->Line(10, 20, 200, 20);
        $this->Ln(20);
    }


    /**
     * 生成 PDF初始化
     * @param string $font 字体
     * @param string $title 文档标题
     * @param int $contractNo 合同号
     * @param int $fontSize 标题字体大小
     * @param int $generalFsize 内容字体大小
     */
    public function __construct($font = 'GB', $title = '',$contractNo=0, $fontSize = 20, $generalFsize = 12)
    {
        parent::__construct($orientation = 'P', $unit = 'mm', $size = 'A4');
        $this->contractNo = $contractNo;
        $this->AddGBFont($font, iconv("UTF-8", "gbk", '微软雅黑'));
        $this->SetTitle($title, true);
        $this->AddPage();
        $this->SetFont($font, 'B');
        $this->SetFontSize($fontSize);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 45, iconv("UTF-8", "gbk", $title), 0, 1, 'C');
        $this->SetFont($font, '');
        $this->SetFontSize($generalFsize);
    }


    /**
     * 内容解析
     * @return string|string[]|null
     */
    public function analysis($content)
    {
        $data = $this->data;
        $this->content = preg_replace_callback("/\{(.*)\}/U", function ($matches) use ($data) {
            if (array_key_exists($matches[1], $data)) {
                return $data[$matches[1]];
            }
        }, $content);
        return $this;
    }


    /**
     * 内容解析数据
     * @param $data
     * @return $this
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }



    /**
     * 字符转码
     * @param $data 待转码内容
     * @param $to  转码类型
     * @return string
     */
    protected function Transcode($to)
    {
        $encode_arr = array('UTF-8', 'ASCII', 'GBK', 'GB2312', 'BIG5', 'JIS', 'eucjp-win', 'sjis-win', 'EUC-JP');
        $encoded = mb_detect_encoding($this->content, $encode_arr);
        return mb_convert_encoding($this->content, $to, $encoded);
    }



    /**
     * 电子签名
     * @param $data  签名数据
     * @return $this
     */
    public function sign($data) {
        $this->MultiCell(0,9,$this->Transcode("GBK"),0,'L');
        $this->Image($data['platform']['chapter'],30,60,40,40,'png');
        if (isset($data['platform']['custSignImg'])) {
            $this->Image($data['platform']['custSignImg'],135,65,50,20,'png');
        }
        if (isset($data['platform']['custSealImg'])) {
            $this->Image($data['platform']['custSealImg'],135,55,50,50,'png');
        }
        $this->Cell(100,9,iconv('UTF-8','GBK//TRANSLIT//IGNORE','甲方（盖章）：'.$data['platform']['name']),0,0,'L',0);   // empty cell with left,top, and right borders
        $this->Cell(80,9,iconv('UTF-8','GBK//TRANSLIT//IGNORE','乙方（盖章）：'.$data['customer']['master_name']),0,1,'L',0);
        $this->Cell(100,9,iconv('UTF-8','GBK//TRANSLIT//IGNORE','代表人签字：'),0,0,'L',0);
        $this->Cell(80,9,iconv('UTF-8','GBK//TRANSLIT//IGNORE','代表人签字：'),0,1,'L',0);
        $this->Cell(100,9,iconv('UTF-8','GBK//TRANSLIT//IGNORE','签署日期：'.$data['date']),0,0,'L',0);
        $this->Cell(80,9,iconv('UTF-8','GBK//TRANSLIT//IGNORE','签署日期：'.$data['date']),0,1,'L',0);
        return $this;
    }

}
