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
	function ListHeader($section,$width='100%',$tp='list'){
		$zm= new zetro_manager;
		$this->tp=$tp;
		$jml=$zm->Count($section,$this->path);
		echo "<table id='listTable' style='border-collapse:collapse' width='$width'>
			  <tr align='center' class='header'><th id='c0' width='4%' class='kotak'>No.</th>";
			  for($i=1;$i<=$jml;$i++){
				  $fld=explode(',',$zm->rContent($section,$i,$this->path));
				  (count($fld)>5)? $wd="width='".$fld[6]."'":$wd='';
				  echo "<th id='c$i' $wd class='kotak'>".$fld[0]."</th>";
			  }
		echo ($this->tp=='list')? "<th id='c".($jml+1)."' $wd class='kotak'></th></tr>":"</tr>";
		
	}
	function event($id,$menu=''){
		echo "<img src='".base_url()."asset/images/16/pencil_16.png' id='$id' class='edit' title='click for update this lain'>
				  <img src='".base_url()."asset/images/16/delete_16.png' id='$id' class='del' title='Click for delete this line'>";
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
	function nBulan($bln){
		$this->bln=array('','January','February','Maret','April','Mei','Juni','Juli','Agustus','September',
					'Oktober','November','Desember');
		return $this->bln[round($bln)];	
	}
}
?>