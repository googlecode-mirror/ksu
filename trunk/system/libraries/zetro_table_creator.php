<?php

class zetro_table_creator{
	function zetro_table_creator($path=''){
	 $this->path=$path;	
	}
	
	function table_name($name){
		$this->name=strtolower(str_replace(" ","",$name));
	}
	function section($sec){
		$this->sec=$sec;	
	}
	function table_created(){
		$zn= new zetro_manager();
		$jml_field=$zn->Count($this->sec,$this->path);
		$sql="CREATE TABLE IF NOT EXISTS `".$this->name."` (\n";
			for ($i=1;$i<=$jml_field;$i++){
				$fld=explode(",",$zn->rContent($this->sec,$i,$this->path));
					if($fld[1]!='N'){
					$sql .="`".$fld[2]."` ".$fld[3].",\n";
					}else{$sql=$sql;}
			}
			for ($z=1;$z<=$jml_field;$z++){
				$fld2=explode(",",$zn->rContent($this->sec,$z,$this->path));
					if($fld2[1]=='P'){
					$sql .="PRIMARY KEY (".$fld2[2].")\n";
					}
			}
			$sql .=" )\n
						COLLATE='latin1_swedish_ci'\n
						ENGINE=MyISAM;";
			return mysql_query($sql) or die($jml_field.$sql."<br/>".mysql_error());
	}
}
?>