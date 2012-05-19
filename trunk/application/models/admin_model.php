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
	function Auth($menu,$type_auth='d',$userid=''){
		//type_auth=d for full Authorisation;
		($userid=='')? $userid=$this->session->userdata('userid'):$userid=$userid;
		if($uid!='Superuser'){
			$this->db->select($type_auth);
			$this->db->where('userid',$userid);
			$this->db->where('idmenu',$menu);
			$query=$this->db->get('useroto');
				return $query;//->row_array();
		}
	}
	function cek_Auth($idmenu='',$userid=''){
		//type_auth=d for full Authorisation;
		($userid=='')? $userid=$this->session->userdata('userid'):$userid=$userid;
			$this->db->select('*');
			$this->db->where('userid',$userid);
			if($idmenu!=''){
			$this->db->where('idmenu',$idmenu);
			}
			$query=$this->db->get('useroto');
			if ($this->session->userdata('levelid')!=1){
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
	public function penomoran(){
	 $this->db->order_by('nomor','desc');
	 $query=$this->db->get('penomoran');
	  return $query->row_array();
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
		($uid=='')?$uid=$this->session->userdata('userid'):$uid=$uid;
		$q=$this->db->query("select $fields from useroto where idmenu='$menu' and userid='$uid'");
		if ($q->num_rows() > 0) {
			$row=$q->row();
			$hasil=$row->$fields;
		}else{ $hasil='';}
		return $hasil;
	}
	function update_nomor($data){
		$this->simpan_data('penomoran',$data);
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
			mysql_query($q) or die(mysql_error());
	}
}

?>