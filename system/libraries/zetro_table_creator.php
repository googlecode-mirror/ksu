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
		$sql='';$pri=1;
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
					$pri=1;
					}else{
					$pri=0;
					}
			}
			//($pri==0)?$sql2=substr($sql,0,(strlen($sql)-14)):$sql2=$sql;
			$sql .=" )\nCOLLATE='latin1_swedish_ci'\nENGINE=MyISAM;";
			return mysql_query($sql) or die("<br>".$sql."<br/>".mysql_error());
	}
}
?>








