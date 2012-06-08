<?php
class Client extends CI_Controller {

	function  __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->tc= new zetro_table_creator('asset/bin/zetro_table.cfg');
		$this->zn= new zetro_manager();
		$this->zc='asset/bin/zetro_config.dll';
		$this->zm='asset/bin/zetro_menu.dll';
		$this->nfiles='asset/bin/zetro_form.cfg';
	}
	public function create_table($content){
		$this->tc->table_name($content);
		$this->tc->section($content);
		$this->tc->table_created();
	}

	 function list_client(){
		 $data=array();
		 $this->create_table('blacklist');
			$data=array();
			($this->input->post('bulan')=='')? $bln=date('m'):$bln=$this->input->post('bulan');
			($this->input->post('thn')=='')? $thn=date('Y'):$thn=$this->input->post('thn');
			$data['ae']=$this->Admin_model->is_oto('client/list_client','e');
			$data['list']=$this->Admin_model->show_list('nasabah',"/*where month(doc_date)='".$bln."' and year(doc_date)='".$thn."'*/ order by nama_spb");
			$data['bln']=$this->input->post('bulan');
			$data['thn']=$this->input->post('thn');
			$this->load->view('admin/header');
			$this->Admin_model->is_oto_all('client/list_client',$this->load->view('sdm/list_nasabah',$data));
			$this->load->view('admin/footer');
	 
	 }
	 function blacklist(){
		 $data=array();
		 $this->create_table('blacklist');
			($this->input->post('bulan')=='')? $bln=date('m'):$bln=$this->input->post('bulan');
			($this->input->post('thn')=='')? $thn=date('Y'):$thn=$this->input->post('thn');
			$data['ae']=$this->Admin_model->is_oto('client/blacklist','e');
			$data['list']=$this->Admin_model->show_list('blacklist',"/*where month(doc_date)='".$bln."' and year(doc_date)='".$thn."'*/ order by nama_spb");
			$data['bln']=$this->input->post('bulan');
			$data['thn']=$this->input->post('thn');
			$this->load->view('admin/header');
			$this->Admin_model->is_oto_all('client/blacklist',$this->load->view('sdm/list_blacklist',$data));
			$this->load->view('admin/footer');
	 
	 }
	 function edit_client(){
			$data=array();
			$id=$_POST['ktp_spb'];
			echo json_encode($this->show_data_field('nasabah','nasabah',"where ktp_spb='$id'"));
	 }
	function edit_simpan(){
		$this->update_data_field('nasabah','nasabah','ktp_spb');
		redirect('client/list_client');
	}
 	function add_blacklist(){
			$data=array();
			$id=$_POST['ktp_spb'];
			$data['nama_spb']=$this->Admin_model->show_single_field("nasabah","nama_spb","where ktp_spb='$id'");
			$data['ktp_spb']=$this->Admin_model->show_single_field("nasabah","ktp_spb","where ktp_spb='$id'");
			$data['almnasabah']=$this->Admin_model->show_single_field("nasabah","almnasabah","where ktp_spb='$id'");
			$data["created_by"]=$this->session->userdata("userid");
			//print_r($data);
			$this->Admin_model->simpan_data('blacklist',$data);//'ktp_spb');
			echo "<img src='".base_url()."asset/images/GoOut.png' width='20px' height='20px' title='Masuk daftar Blacklist'>";
	}
	function del_blacklist(){
			$id=$_POST['ktp_spb'];
			$this->Admin_model->hapus_table('blacklist','ktp_spb',$id);
	}
///public function	
	public function show_data_field($section,$table,$where){
		$data=array();
		$jml=$this->zn->Count($section,$this->nfiles);
		for ($i=1;$i<$jml;$i++){
			$fld=explode(",",$this->zn->rContent($section,$i,$this->nfiles));
			($fld[2]=='date')?
			$result=tglfromSql($this->Admin_model->show_single_field($table,$fld[3],$where)):
			$result=$this->Admin_model->show_single_field($table,$fld[3],$where);
		   $data[$fld[3]]=$result;
		}
		 return $data;
	}
	public function update_data_field($section,$table,$field){
		$data=array();
		$jml=$this->zn->Count($section,$this->nfiles);
		for ($i=1;$i<$jml;$i++){
			$fld=explode(",",$this->zn->rContent($section,$i,$this->nfiles));
			($fld[2]=='date')?
			$result=tglToSql($this->input->post($fld[3])):
			$result=$this->input->post($fld[3]);
			$data[$fld[3]]=$result;
		}
		$data["created_by"]=$this->session->userdata("userid");
		$this->Admin_model->simpan_update($table,$data,$field);
	}
	

/*end of class ajax.php
location : application/cotrollers/sdm.php
*/
}

?>