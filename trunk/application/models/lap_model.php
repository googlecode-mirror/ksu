<?php
class Lap_model extends CI_Model {
    function  __construct() 
	{
        parent::__construct();
    }

	function show_lap_spb($bln='',$thn=''){
		($bln=='')? $bln=date('m'):$bln=$bln;
		($thn=='')? $thn=date('Y'):$thn=$thn;
		$sql="select * from spb where month(tgl_spb)='$bln' and year(tgl_spb)='$thn' order by no_spb";
		
		return $this->db->query($sql);
	}
}
?>