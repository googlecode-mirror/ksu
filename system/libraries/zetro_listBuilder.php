<?php
class zetro_listBuilder{
	public $path;
	var $sql;
	var $con;
	function zetro_listBuilder($path=''){
		$this->path=$path;
	}
	function db_query($sql,$con=''){
		$this->sql=$sql;
		$this->con=$con;
	}
	function ListHeader($section,$width='100%',$id='',$tp='list'){
		$zm= new zetro_manager;
		$this->tp=$tp;
		$jml=$zm->Count($section,$this->path);
		($id=='')?$jud='listTable':$jud=$id;
		echo "<table id='$id' style='border-collapse:collapse' width='$width'>\n<thead>
			  <tr align='center' class='header'>\n\r
			  <th id='c0' width='4%' class='kotak'>No.</th>\n\r";
			  for($i=1;$i<=$jml;$i++){
				  $fld=explode(',',$zm->rContent($section,$i,$this->path));
				  (count($fld)>6)? $wd="width='".$fld[6]."'":$wd='';
				  ($fld[6]=='')? $st="style='display:none'":$st='';
				  echo "<th id='c$i' $wd class='kotak' $st>".$fld[0]."</th>\n\r";
			  }
		echo ($this->tp=='list')? "<th id='c".($jml+1)."' width='5%' class='kotak'></th>\n\r</tr>\n\r":"</tr>";
		echo "</thead>";
	}
	function event($id,$menu='',$stat=''){
		if($stat==''){
		echo "<img src='".base_url()."asset/images/editor.png' id='$id' class='edit' title='click for update this line'>
				  <img src='".base_url()."asset/images/no.png' id='$id' class='del' title='Click for delete this line'>";
		}elseif ($stat='process'){
		echo "<img src='".base_url()."asset/images/16/diagram_16.png' id='$id' class='process' title='Click for process this data'>";
		}
	}
	function ListBuilder($section,$total=false,$tp='list'){
		$n=0;
		$zm= new zetro_manager;
		$jml=$zm->Count($section,$this->path);
		$this->rs=mysql_query($this->sql,$this->con) or die(mysql_error());
			while($row=mysql_fetch_array($this->rs)){
				$n++;
				echo "<tr align='center' class='xx'><td id='c00' class='kotak'>No.</td>";
				  for($i=1;$i<=$jml;$i++){
					  $fld=explode(',',$zm->rContent($section,$i,$this->path));
					  echo "<td id='c$i$n' class='kotak'>".$row[$fld[3]]."</td>";
				  }
			echo ($this->tp=='list')? "<td id='c".($jml+1)."' class='kotak'>".$this->event($n)."</td></tr>":"</tr>";
			}
		echo "</table>";
		
	}
}
?>