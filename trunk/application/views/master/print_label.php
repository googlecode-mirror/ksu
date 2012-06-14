<?
$pdf=new Zetro_pdf();
$pdf->FPDFF("P","cm","Legal");
$pdf->SetMargins(0.5,0.5,0.5);
$pdf->AddPage();
$pdf->AliasNbPages();
$title='Label Material';
$pdf->SetTitle($title);
$pdf->SetAuthor('Iswan Putera S.Kom');
		$n=0;$m=0;
			$x=$list->num_rows();
			($x>1)?$z=($x%($x/2)):$z='';
			($z==1||$z='')?$zz=1:$zz=0;
			for ($i=0;$i<=((($x/2)+$zz));$i++){
				$m++;
				$pdf->PrintChapter(1,($i+$m-1)."_slip.txt",($i+$m)."_slip.txt");
			//echo ($i+$m-1)."_slip.txt"."|".($i+$m)."_slip.txt<br>$z";
			}
$pdf->Output();
//
?>
