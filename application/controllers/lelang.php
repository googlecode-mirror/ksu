<?php
class Lelang extends CI_Controller {

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
	
	function list_lelang(){
		$this->create_table('lelang');
		$data=array();
		$data['ttl']=$this->Admin_model->total_data('lelang','D',"pp_stat");
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('lelang/list_lelang',$this->load->view('lelang/daftar_lelang',$data));
		$this->load->view('admin/footer');
	}
	
	function lap_perpanjang(){
		$n=0;
		$data=array();$datax=array();
		$no_spb=$_POST['no_spb'];
		$data['ae']=$this->Admin_model->is_oto('lelang/list_lelang','e');
		$data=$this->Admin_model->show_list('perpanjang_spb',"where pp_stat='N' group by no_spb order by no_spb",'distinct(no_spb) as no_spb,pp_ke,sum(pp_bayar) as ppbayar');
		if($data->num_rows>0){
		foreach($data->result() as $row){
			$n++;
		    $pp_ke=$this->Admin_model->show_single_field("lelang","pp_stat","where no_spb='".$row->no_spb."'");	
			($pp_ke=='')? $gb='checkout.gif':$gb='44.png';
			($pp_ke=='')? $grb='D':$grb='';
			echo "\n<tr class='xx' id='".$row->no_spb."' align='center'>
				  <td class='kotak' align='left'>".rdb('spb','id_barang','id_barang',"where no_spb='".$row->no_spb."'")."</td>	
				  <td class='kotak' align='center'>".substr($row->no_spb,0,5)."</td>	
				  <td class='kotak' align='left'>".ShortTgl(rdb('spb','tgl_spb','tgl_spb',"where no_spb='".$row->no_spb."'"),true)."</td>	
				  <td class='kotak' align='left'>".rdb('spb','nama_spb','nama_spb',"where no_spb='".$row->no_spb."'")."</td>	
				  <td class='kotak' align='right'>".number_format(rdb('spb','taksir_spb','taksir_spb',"where no_spb='".$row->no_spb."'"),2)."</td>	
				  <td class='kotak' align='right'>".number_format(rdb('spb','nilai_spb','nilai_spb',"where no_spb='".$row->no_spb."'"),2)."</td>	
				  <td class='kotak'>".$row->pp_ke." x</td>	
				  <td class='kotak'>".TglfromSql(getNextDays(rdb('spb','tgl_spb','tgl_spb',"where no_spb='".$row->no_spb."'"),($row->pp_ke*30)))."</td>
				  <td id='c-1-$n' class='kotak'><img src='".base_url()."asset/images/$gb' id='ck-$n' class='pros' onclick=\"upd_lelang('".$row->no_spb."','$grb');\"></td>";
		   echo " </tr>\n";
		}
		}else{
			echo "Tidak ada barang yang akan di lelang";
		}
	}
	function upd_lelang(){
		$data=array();$datax=array();
	 	$id=$_POST['no_spb'];
		$n=$_POST['ide'];
		$data['no_spb']=$this->Admin_model->show_single_field("spb","no_spb","where no_spb='".$id."'");	
		$data['id_barang']=$this->Admin_model->show_single_field("spb","id_barang","where no_spb='".$id."'");	
		$data['nilai_spb']=$this->Admin_model->show_single_field("spb","nilai_spb","where no_spb='".$id."'");	
		$data['jw_spb']=$this->Admin_model->show_single_field("spb","jw_spb","where no_spb='".$id."'");	
		$tgl_spb=$this->Admin_model->show_single_field("spb","tgl_spb","where no_spb='".$id."'");	
		$pp_ke=$this->Admin_model->show_single_field("perpanjang_spb","pp_ke","where pp_stat='Y' and no_spb='".$id."'");	
		($pp_ke=='')?$pp_ke=1:$pp_ke=$pp_ke;
		$data['jt_spb']=getNextDays($tgl_spb,($pp_ke*30));
		($_POST['stat']=='')?$sts="":$sts=$_POST['stat'];
		$data['pp_stat']=$_POST['stat'];
		$data["created_by"]=$this->session->userdata("userid");
		if($this->Admin_model->field_exists('lelang',"where no_spb='$id'",'no_spb')==''){
			$this->Admin_model->simpan_data('lelang',$data);
		}else{
			$this->Admin_model->upd_data('lelang',"set pp_stat='".$sts."'","where no_spb='$id'");			
		}
		($_POST['stat']=='')?
		$this->Admin_model->upd_data('spb',"set stat_spb='Y',created_by='".$this->session->userdata("userid")."'","where no_spb='".$_POST['no_spb']."'"):
		$this->Admin_model->upd_data('spb',"set stat_spb='C',created_by='".$this->session->userdata("userid")."'","where no_spb='".$_POST['no_spb']."'");
		//print_r ($data);
		$datax['gambar']=base_url()."asset/images/44.gif";
		$datax['diklik']="upd_lelang('$id','');";
		$datax['ttl']=$this->Admin_model->total_data('lelang','D',"pp_stat");
		echo json_encode($datax);
	}
	//label lelang
	function print_lelang(){
	$n=0;
		$data=$this->Admin_model->show_list('lelang',"where pp_stat='D' group by no_spb order by no_spb");
		if($data->num_rows>0){
			foreach($data->result() as $row){
				$n++;
				echo "\n<tr class='xx' id='".$row->no_spb."' align='center'>
					  <td class='kotak' align='center'>$n</td>
					  <td class='kotak' align='left'>".$row->id_barang."</td>	
					  <td class='kotak' align='center'>".substr($row->no_spb,0,5)."</td>";	
			   echo " </tr>\n";
			}
		}else{
			echo "Tidak ada barang yang akan di lelang";
		}
	}	
}
?>