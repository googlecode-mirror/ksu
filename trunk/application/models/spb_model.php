<?php
class Spb_model extends CI_Model {
    function  __construct() 
	{
        parent::__construct();
    }
	
	function dropdown($jenis=''){
			$this->db->select("distinct($jenis(tgl_spb)) as bln from spb order by $jenis(tgl_spb)");
		return $this->db->get();
	}
	function edit_field($key,$section=''){
			
		
	}
	function total_record_val($thn){
		$sql="select sum(nilai_spb) as nama_spb,month(tgl_spb) as bln from spb where year(tgl_spb)='$thn' group by concat(month(tgl_spb),year(tgl_spb))";
		$n=0;
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($rs)){
			$data[$row['bln']]=$row['nama_spb'];
			$n++;
		}
		return $data;
	}

	function total_barang($thn){
		$sql="select count(id_barang) as nama_spb,month(tgl_spb) as bln from spb where year(tgl_spb)='$thn' group by concat(month(tgl_spb),year(tgl_spb))";
		$n=0;
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($rs)){
			$data[$row['bln']]=$row['nama_spb'];
			$n++;
		}
		return $data;
	}

	function total_barang_val($thn){
		$sql="select sum(taksir_spb) as nama_spb,month(tgl_spb) as bln from spb where year(tgl_spb)='$thn' group by concat(month(tgl_spb),year(tgl_spb))";
		$n=0;
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($rs)){
			$data[$row['bln']]=$row['nama_spb'];
			$n++;
		}
		return $data;
	}


}
?>