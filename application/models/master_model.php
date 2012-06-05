<?php
class Master_model extends CI_Model {
    function  __construct() 
	{
        parent::__construct();
    }
	function db_list(){
		$q=$this->db->query("select distinct(nmgroup) as nmgroup from material order by nmgroup");
		return $q;
	}
		
	function db_list_list($lst){
		//echo "select p.* from spb as p , material as m where m.nmgroup='".$lst."' and m.nmbarang=p.id_barang and p.stat_spb='Y' order by p.no_spb";
		  $q=$this->db->query("select p.* from spb as p , material as m where m.nmgroup='".$lst."' and m.nmbarang=p.id_barang and p.stat_spb='Y' order by p.no_spb");	
		return $q;
	}
}
?>