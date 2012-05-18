<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//class zetro_helper{
	
	function __construct(){
			
	}
	function rdb($tabel,$rfield,$sfield='',$where='',$order='',$group=''){
		$datadb="";
		if($sfield==''){
		$sql="select * from ".$tabel." $where $group $order";
		}else{
		$sql="select ".$sfield. " from ".$tabel." $where $group $order";
		}
		//echo $sql."<br>";
		$rs=mysql_query($sql) or die($sql.mysql_error());
		while($rw=mysql_fetch_array($rs)){
			$datadb=$rw[$rfield];
		}
		return $datadb;
		//echo $databd;
	}
	function RowCount($tabel,$where='',$sfield='*'){
		$databd=0;
		$sql="select $sfield from $tabel $where";
		//echo $sql."<br>";
		$rs=mysql_query($sql) or die($sql.mysql_error());
		$datadb=mysql_num_rows($rs);
		return $datadb;
	}
	function hapus($tabel,$where){
		$sql="delete from $tabel $where";
		//echo $sql;
		mysql_query($sql) or die(mysql_error());
	}
	function dropdown($tabel,$fieldforval,$fieldforname,$where='',$pilih='',$bariskosong=true){
		if ($bariskosong==true) echo "<option value=''>&nbsp;</option>";
		$dst=explode(" as ",$fieldforval);
		$dst2=explode(",",$fieldforname);
		$sql="select $fieldforval,$fieldforname from $tabel $where";
			$rs=mysql_query($sql) or die(mysql_error());
			while ($rw=mysql_fetch_object($rs)){
			(count($dst)>1)? $valu=$rw->$dst[1]: $valu=$rw->$dst[0];
			echo "<option value='".$valu."'";
				if ($pilih==$valu){ echo " selected";}
			echo ">";
			(count($dst2)>1)? $addnm=$rw->$dst2[0]." [".$rw->$dst2[1]." ]":$addnm=$rw->$dst2[0];
			echo   $addnm."</option>";	
			}
	}
	function lama_execute(){
		$awal = microtime(true);
		
		// --- bagian yang akan dihitung execution time --
		
		$bil = 2;
		$hasil = 1;
		for ($i=1; $i<=10000000; $i++)
		{
			 $hasil .= $bil;
		}
		
		// --- bagian yang akan dihitung execution time --
		
		$akhir = microtime(true);
		$lama = $akhir - $awal;
		echo "<p>Lama eksekusi script adalah: ".$lama." detik</p>";
	}
	
	function nBulan($bln){
		$bln=array('','January','February','Maret','April','Mei','Juni','Juli','Agustus','September',
					'Oktober','November','Desember');
		return $bln[round($bln)];	
	}
	function penomoran($table,$fieldnomor){
		$nom=rdb($table,$fieldnomor,$fieldnomor,"order by $fieldnomor desc limit 1");
		if ($nom==""){
			$nomor=date('Ymd')."-0001";
		}else{
			$noms=explode("-",$nom);
			if (strlen((int)$noms[1])==1){
				$nomor=date('Ymd')."-000".($noms[1]+1);
			}else if(strlen((int)$noms[1])==2){
				$nomor=date('Ymd')."-00".($noms[1]+1);
			}else if(strlen((int)$noms[1])==3){
				$nomor=date('Ymd')."-0".($noms[1]+1);
			}else if(strlen((int)$noms[1])==4){
				$nomor=date('Ymd')."-".($noms[1]+1);
			}
		}
		return $nomor;
	}
	function tglToSql($tgl=''){
		//input dd/mm/yyyy -->output yyyymmdd
		if($tgl==''){
			$tanggal=date('Ymd');
		}else{
			$tanggal=substr($tgl,6,4).substr($tgl,3,2).substr($tgl,0,2);
		}
		return $tanggal;
	}
	function tglfromSql($tgl='',$separator='/'){
		($tgl=='')?
		$tanggal='dd/mm/yyyy':
		$tanggal=substr($tgl,8,2).$separator.substr($tgl,5,2).$separator.substr($tgl,0,4);
		return $tanggal;
	}
//}