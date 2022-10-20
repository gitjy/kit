<?php
/**
 * *多列显示文本 展示了如何将文本放置在多列中。
 * AcceptPageBreak 为false不触发分页
 * 打印对齐段落的示例chapter.php的变体
 * 
 *  设置多列显示后，每列必须同时设置左边界和x的偏移量
 * 不定义左边边界,指定x偏移量无效
 * 
 * 内置字体不支持中文
 * 
 **/

/**
 * $this->MultiCell(60,5,$txt); 每行设置宽度
 * 
 * 使用的关键方法是AcceptPageBreak()。它允许接受或不接受自动分页符。通过拒绝它并更改边距和当前位置，可以实现所需的列布局。
 * 类中添加了两个属性来保存当前列号和列开始的位置，MultiCell() 调用指定了 6 厘米的宽度。
 * 
 * AcceptPageBreak
 * 每逢有分页的情况出现，就代表这个功能已经被执行了，而且，分页会自动显示出来，也不需要依靠在其它数值数据。预设履行反回数值，取决于 SetAutoPageBreak() 的模式选择。这个功能是会自动处理的，也不需要其它程序操控。
 * 
 * SetAutoPageBreakSetAutoPageBreak(boolean auto [, float margin])
 * 启动或关闭自动分页模式。当启动了自动分页模式，第二个参数可以用来限制页的底部距离。默认值为启动并且边缘为 2 厘米。
 */
require('include.php');


class PDF extends FPDF
{
protected $col = 0; // 当前列号
protected $y0;      // 当前列开始的位置

function Header()
{
    // Page header
    global $title;

    $this->SetFont('Arial','B',15);
    $w = $this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    $this->SetDrawColor(0,80,180);
    $this->SetFillColor(230,230,0);
    $this->SetTextColor(220,50,50);
    $this->SetLineWidth(1);
    $this->Cell($w,9,$title,1,1,'C',true);
    $this->Ln(10);
    // Save ordinate
    $this->y0 = $this->GetY();
    
}

function Footer()
{
    // Page footer
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

/**
 * 设置多列显示后，每列必须同时设置左边界和x的偏移量
 * 不定义左边边界,指定x偏移量无效
 * 下一页定义了左边界，还需要要重置x偏移量
 * */
function SetCol($col)
{
    // Set position at a given column
    $this->col = $col;
    $x = 10+$col*65;
    $this->SetLeftMargin($x); //定义左边边界。
    //var_dump($col,$x , $this->getX(), '----');
    $this->SetX($x);   //定义横坐标(x)目前的位置。
}

function AcceptPageBreak()
{
    // Method accepting or not automatic page break
    if($this->col<2)
    {
        // Go to next column
        $this->SetCol($this->col+1);
        // Set ordinate to top 重置高度
        $this->SetY($this->y0); 
        // Keep on page
        return false;
    }
    else
    {
        // Go back to first column
        $this->SetCol(0);
        // Page break
        return true;
    }
}

function ChapterTitle($num, $label)
{
    // Title
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,220,255);
    $this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
    $this->Ln(4);
    // Save ordinate
    $this->y0 = $this->GetY();
}

function ChapterBody($file)
{
    // Read text file
    $txt = file_get_contents($file);
    // Font
    $this->SetFont('Times','',12);
    // Output text in a 6 cm width column
    $this->MultiCell(60,5,$txt); //每行宽度6cm
    $this->Ln();
    // Mention
    $this->SetFont('','I');
    $this->Cell(0,5,'(end of excerpt)');
    // Go back to first column
    //$this->SetCol(0);
}

function PrintChapter($num, $title, $file)
{
    // Add chapter
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
}
}

$pdf = new PDF();
$title = '20000 Leagues Under the Seas';
$pdf->SetTitle($title, true);
$pdf->SetAuthor('Jules Verne', true);
$pdf->PrintChapter(1,'A RUNAWAY REEF','chapter1_en.txt');
$pdf->PrintChapter(2,'THE PROS AND CONS APPLE INFO','chapter2_en.txt');
$pdf->Output('', '',true);
