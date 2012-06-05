<?
class Master extends CI_Controller {

	function  __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Master_model');
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
	
	function label_spb(){
		$this->create_table('labeling');
		$data=array();
		$data['ttl']=$this->Admin_model->total_data('lelang','D',"pp_stat");
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('index',$this->load->view('master/master_label',$data));
		$this->load->view('admin/footer');
	}
	function labellelang(){
		$data=array();
		$kolom=2;
		$n=0;
		$data=$this->Admin_model->show_list('labeling',"where pp_stat='Y' order by no_spb");
		if($data->num_rows>0){
			foreach($data->result() as $row){
				$n++;
				if (($n-1) % $kolom==0) echo "<tr align='center' valign='middle' height='350px'>";
				echo "<td width='450px' style='border:2px solid #000'><div class='stiker'>
					  <table witdh='445' border='0' style='border-collapse:collapse; font-size:40px' height='345px'>
					  <tr height='30px'><td width='30%'>NAMA</td><td width='70%' nowrap>:&nbsp;".rdb('spb','nama_spb','nama_spb',"where no_spb='".$row->no_spb."'")."</td></tr>\n
					  <tr height='30px'><td width='30%'>NO</td><td width='70%'>:&nbsp;".substr($row->no_spb,0,5)."</td></tr>\n
					  <tr height='30px'><td width='30%'>JK.WKT</td><td width='70%'>:&nbsp;".$row->jw_spb." Hari</td></tr>\n
					  <tr height='30px'><td width='30%'>TGL.JT</td><td width='70%'>:&nbsp;".tglfromSql(rdb('spb','tgl_spb','tgl_spb',"where no_spb='".$row->no_spb."'"))."</td></tr>\n
					  <tr height='30px'><td width='30%'>Rp.</td><td width='70%' style='border-bottom:1px solid #000'>:&nbsp;".number_format($row->nilai_spb,2)."</td></tr>\n
					  <tr height='40px'><td colspan='2'>&nbsp;</td></tr></table></div></td><td width='5px'>&nbsp;</td>";
				if($n % $kolom==0) echo "</tr>";	  
			}
		}
	}
	
	function material_group(){
		$data=array();$datax=array();
		$kolom=2;
		$n=0;
		$data=$this->Master_model->db_list();
		if($data->num_rows>0){
			foreach($data->result_array() as $row){
				$datax=$this->Master_model->db_list_list($row['nmgroup']);
				$n++;
				//print_r($data);
				echo "<tr valign='middle' class='xx header' id='".$row['nmgroup']."'>";
				echo "<td class='kotak' colspan='4'>".$row['nmgroup']."</td>";
				if($datax->num_rows>0){
					foreach($datax->result_array() as $dbs){
					  $cek_status=$this->Admin_model->field_exists('labeling',"where no_spb='".$dbs['no_spb']."'",'no_spb');
						 if ($cek_status ==''){
						  echo "<tr class='xx ".$row['nmgroup']."'>
								<td width='5%' class='kotak'>&nbsp</td>
								<td class='kotak'>".$dbs['id_barang']."</td>
								<td class='kotak'>".$dbs['no_spb']."</td>
								<td class='kotak' align='center'>";?>
									<input type='checkbox' id='ck-"<?=$dbs['no_spb'];?>"'
									onclick="cek4label('<?=$dbs['no_spb'];?>');">
						  <? echo "</td>
								</tr>";
						 }
					}
				}
				echo "</tr>";	  
			}
		}
	}	
	
	function label_siap_print(){
		$data=array();
	 	$id=$_POST['no_spb'];
		//$n=$_POST['ide'];
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
		if($this->Admin_model->field_exists('labeling',"where no_spb='$id'",'no_spb')==''){
			$this->Admin_model->simpan_data('labeling',$data);
		}else{
			$this->Admin_model->upd_data('labeling',"set pp_stat='".$sts."'","where no_spb='$id'");			
		}
		
	}
	
	function hps_label_siap_print(){
		$this->Admin_model->hps_data("labeling");
	}
}