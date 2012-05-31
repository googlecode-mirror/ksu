<?php
class Admin_model extends CI_Model 
{
    var $tabel_name = 'users';
    function  __construct() 
	{
        parent::__construct();
    }
	
    function cek_user_login($username, $password) 
	{
        $this->db->select('*');
        $this->db->where('userid', $username);
        $this->db->where('password', md5($password));

        $query = $this->db->get($this->tabel_name, 1);

        if ($query->num_rows() == 1) 
		{
            return $query->row_array();
        }
    }
	
	function userlist($limit,$offset){
		$this->db->where('levelid !=','1');
		$this->db->select('*');
		$this->db->order_by('userid');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get('users');
		return $query;
	}
	function total_data($tabel,$where='',$field=''){
		if($where!='')$query=$this->db->where($field,$where);
		$query=$this->db->count_all_results($tabel);
		return $query;	
	}
	function show_single_field($table,$field='*',$where){
		$nom='';
		$sql="select $field from $table $where";
		//echo $sql;
		$rs=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($rs)){
			$nom=$row[$field];	
		}
		return $nom;
	}
	public function penomoran($table='nomorspb',$field='no_spb',$where=''){
		($where=='')?$where="order by no_spb desc limit 1":$where=$where;
		$nom=$this->show_single_field($table,$field,$where);
		if($nom >0 && $nom <10000){$nomor=$nom;}else{$nomor='';}
		($nomor=='')?$nomor=1:$nomor=(int)$nomor+1;
			if(strlen($nomor)==1){
			$nomo='0000'.$nomor;
			}else if(strlen($nomor)==2){
				$nomo='000'.$nomor;
			}else if(strlen($nomor)==3){
				$nomo='00'.$nomor;
			}else if(strlen($nomor)==4){
				$nomo='0'.$nomor;
			}else{
				$nomo=$nomor;
			}
			//$nom=date('Ymd').'-'.$nomo;
			return $nomo;

	}
	function user_exists($uid=''){
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$this->db->where("userid",$uid);
		$q=$this->db->count_all_results("users");
		;
		return $q;
	}
	function field_exists($table,$where='',$field='*'){
		$q=$this->db->query("select $field from $table $where");
		if ($q->num_rows() > 0) {
			$row=$q->row();
			$hasil=$row->$field;
		}else{ $hasil='';}
		return $hasil;
	}
	function cek_pwd($uid=''){
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$q=$this->db->query("select password from users where userid='$uid'");
		$row=$q->row();
		$hasil=$row->password;
		return $hasil;
	}
	function cek_oto($menu,$fields,$uid=''){
		check_logged_in($this->session->userdata('userid'));
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$q=$this->db->query("select $fields from useroto where idmenu='$menu' and userid='$uid'");
		if ($q->num_rows() > 0) {
			$row=$q->row();
			$hasil=$row->$fields;
		}else{ $hasil='';}
		return $hasil;
	}
	function is_oto($menu,$field,$userid=''){
		check_logged_in($this->session->userdata('userid'));
		$oto='';
		($userid=='')?$uid=$this->session->userdata('userid'):$uid=$userid;
		$sql="select $field from useroto where idmenu='$menu' and userid='$uid'";	
		//echo $sql;
		$rs=mysql_query($sql) or die(mysql_error());
		while ($row=mysql_fetch_array($rs)){
			$oto=$row[$field];	
		}
		return $oto;
	}
	function is_oto_all($menu,$link_oto,$userid=''){
		check_logged_in($this->session->userdata('userid'));
		($userid=='')?$uid=$this->session->userdata('userid'):$uid=$userid;
		if($uid=='Superuser'){
			$link_oto;
		}else{
			if($this->is_oto($menu,'c',$uid)=='Y' ||
			   $this->is_oto($menu,'e',$uid)=='Y' ||
			   $this->is_oto($menu,'v',$uid)=='Y' ||
			   $this->is_oto($menu,'p',$uid)=='Y' ||
			   $this->is_oto($menu,'d',$uid)=='Y' ){
				   $link_oto;
			   }else{
				  $this->load->view("admin/no_authorisation");
			   }
		}
	}
	function update_nomor($data,$table='nomorspb'){
		$this->simpan_data($table,$data);
	}
	function simpan_data($tabel,$tabeldata){
		$simpan=$this->db->insert($tabel,$tabeldata);
		return $simpan;
	}
	function simpan_update($tabel,$data,$field){
		$this->db->where($field,$data[$field]);
		$q=$this->db->update($tabel,$data);
		return $q;
	}
	function isi_list($tabel,$where='',$field='*'){
		$q=$this->db->query("select $field from $tabel $where");
		return $q;
	}
	function show_list($tabel,$where='',$field='*'){
		$q=$this->db->query("select $field from $tabel $where");
		return $q;	
	}
	function hapus_table($tabel,$field,$isi){
		$this->db->where($field,$isi);
		$this->db->delete($tabel);	
	}
	function update_table($table,$where,$field,$data){
		$this->db->where($where, $field);
		$q=$this->db->update($table, $data);
		return $q;	
	}
	function tgl_to_mysql($tgl='',$delimiter='/'){
		if($tgl==''){$tgle=date('Ymd');}else{
			$tgl=str_replace($delimiter,"",$tgl);
			$tgle=substr($tgl,4,4).substr($tgl,2,2).substr($tgl,0,2);
		}
		return $tgle;
	 }
	function create_useroto(){
	$sql="CREATE TABLE IF NOT EXISTS `useroto` (
		`userid` VARCHAR(50) NULL DEFAULT NULL,
		`idmenu` VARCHAR(50) NULL DEFAULT NULL,
		`c` ENUM('Y','N') NULL DEFAULT 'N',
		`e` ENUM('Y','N') NULL DEFAULT 'N',
		`v` ENUM('Y','N') NULL DEFAULT 'N',
		`p` ENUM('Y','N') NULL DEFAULT 'N',
		`d` ENUM('Y','N') NULL DEFAULT 'N')
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM;";	
		mysql_query($sql) or die(mysql_error());
	}
	function user_level(){
		$sql="CREATE TABLE IF NOT EXISTS `user_level`(
			`idlevel` INT(50) NOT NULL AUTO_INCREMENT,
			`nmlevel` VARCHAR(150) NULL DEFAULT NULL,
			PRIMARY KEY (`idlevel`))
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM;";	
		mysql_query($sql) or die(mysql_error());
	}
	
	function upd_data($table,$field,$where){
		$q="update $table $field $where";
		//echo $q;
			mysql_query($q) or die(mysql_error());
	}
	function find_match($str,$table='material',$field='nmbarang'){
		$this->db->select($field." from ".$table." where ".$field." like '".$str."%' order by ".$field,FALSE);
		return $this->db->get();
	}
	function find_match_spb($str){
		$this->db->select("s.no_spb from spb as s where stat_spb not in('L','C') and s.no_spb like '".$str."%'  order by no_spb",FALSE);
		return $this->db->get();
	}
	function total_record($thn){
		//$data=array();
		$sql="select count(distinct(nama_spb)) as nama_spb,month(tgl_spb) as bln from spb where year(tgl_spb)='$thn' group by concat(month(tgl_spb),year(tgl_spb))";
		//$sql="select $field from $table $where";
		//echo $sql."\n";
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