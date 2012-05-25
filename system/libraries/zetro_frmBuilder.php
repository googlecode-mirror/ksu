<?php
//class Name: formBuilder
//version	: 1.2
//Author	: Iswan Putera
// function	: Build automatic generate form and field from file config

class zetro_frmBuilder {
	public $brs;
	function zetro_frmBuilder($path=''){
		$this->path=$path;
	}
	
	function BuildForm($section,$button=false,$width='100%',$idTable=''){
		$zm= new zetro_manager;
		$jml=$zm->Count($section,$this->path);
		($idTable!=='')?$idt=$idTable:$idt='fmrTable';
		//echo "<form id='frm1' name='frm1' method='post' action=''>
		echo "<table id='".$idt."' width='$width'>\n";
		// add baris kosong 
		echo $this->brs;
		
		for ($i=1;$i<=$jml;$i++){
			$fld=explode(',',$zm->rContent($section,$i,$this->path));
			echo "<tr id='$i'>\n
				  <td id='c1$i' ";
				   if($fld[0]==''){echo "class=''";}else{echo "class='border_b'";}
				   echo " width='42%'>&nbsp;&nbsp;".$fld[0]."</td>\n
				  <td id='c2$i' width='60%' >";
				  //if ($fld[1]!='')
				  switch($fld[1]){
					  case 'input':
				  		echo "<".$fld[1]." type='".$fld[2]."' id='".$fld[3]."' name='".$fld[3]."' value='".$fld[5]."' class='".$fld[4]."'></td>";
					  break;
					  case 'select':
					  	echo "<".$fld[1]." id='".$fld[3]."' name='".$fld[3]."' class='".$fld[4]."'>";
						if (count($fld)==9){
							if($fld[7]=='RS'){
							echo "<option></option>";
								for ($x=1;$x<=$zm->Count($fld[8],$this->path);$x++){
									$data=explode(",",$zm->rContent($fld[8],$x,$this->path));
								echo "<option value='".$data[0]."'>".$data[1]."</option>\n\r";
								}
							}
						}
						echo "</select>";
					  break;
					  case 'textarea':
					  	echo "<".$fld[1]." id='".$fld[3]."' name='".$fld[3]."' class='".$fld[4]."'></textarea>";
					  break;
					  case 'button':
				  		//echo "<".$fld[1]." type='".$fld[2]."' id='".$fld[3]."' value='".$fld[5]."' class='".$fld[4]."'></td>";
					  break;	   
				  }
			echo "\n<td id='c3$i' width='8%'>&nbsp;</td>\n</tr>";
		}
		if($button==false){echo "</table></form>";}else{
			if($fld[1]=='button'){$this->BuildFormButton($fld[5],$fld[4]);}
		}
	}
	function BuildFormButton($value,$action='button',$buttonCount=2,$tableCol=3){
		echo "<tr><td>&nbsp;</td>
				<td><input type='$action' id='saved' value='$value'>
					<input type='reset' id='batal' value='Cancel'></td>
				<td>&nbsp;</td></tr>\n";
				echo $this->brs;
                echo "</table></form>\n";
	}
	function AddBarisKosong($brs=false){
		$this->dat='';
		$this->brs=$brs;
		if($this->brs==true){ $this->brs= "<tr><td colspan='3'>&nbsp;</td></tr>\n";}
		return $this->brs;
	}
}
?>
