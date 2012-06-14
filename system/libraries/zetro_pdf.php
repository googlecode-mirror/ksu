<?
require('fpdff.php');

class Zetro_pdf extends FPDFF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;


function Footer()
{
    //Page footer
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

function SetCol($col)
{
    //Set position at a given column
    $this->col=$col;
    $x=10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
	//(($col % 2)==1)?$y=$x:$y=0.5;
	$xx=$this->GetX();
	$y=$this->GetY();
	//$this->SetXY($xx+1,$y);
}

function AcceptPageBreak()
{
    //Method accepting or not automatic page break
    if($this->col<2)
    {
        //Go to next column
        $this->SetCol($this->col+1);
        //Set ordinate to top
        $this->SetY($this->y0);
        //Keep on page
        return false;
    }
    else
    {
        //Go back to first column
        $this->SetCol(0);
        //Page break
        return true;
    }
}

function ChapterTitle($num,$label)
{
    //Title
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,220,255);
    $this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
    $this->Ln(4);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody($file,$file2)
{
    //Read text file
    $f=fopen($file,'r');
    $f2=fopen($file2,'r');
    $txt=fread($f,filesize($file));
    $txt2=fread($f2,filesize($file2));
    fclose($f);
    fclose($f2);
    //Font
    $this->SetFont('Times','B',18);
	$y=$this->GetY();
    //Output text in a 6 cm width column
    $this->MultiCell(9,1,$txt,1,1);
	$x=$this->GetX();
	$this->SetXY(10,$y+$x-0.5);
    $this->MultiCell(9,1,$txt2,1,1);
}

function PrintChapter($num,$file2,$file)
{
    //Add chapter
    //$this->AddPage();
    $this->ChapterBody($file,$file2);
    $this->Ln();
   // $this->AcceptPageBreak();
}
}?>