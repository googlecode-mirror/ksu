<?php
class Spb extends CI_Controller {
  public $tc;
  public $zn;
	public $zc;
	public $zm;
	public $nfiles;
    function  __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('spb_model');
		$this->load->library('zetro_slip');
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
    function index() {
		$data=array();
		$this->create_table('spb');
		$this->create_table('nomorspb');
		$this->create_table('material_group');
		$this->create_table('material');
		$this->create_table('nasabah');
		$this->create_table('perpanjang_spb');
		$data['no_spb']=$this->Admin_model->penomoran();
		//$this->print_slip();
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('index',$this->load->view('spb/spbnew',$data));
		$this->load->view('admin/footer');
	}

	public function penomoran(){
	//$data=array();
	$datak=$this->Admin_model->penomoran();
	if(count($datak)>0 ){$nomor=$datak['nomor'];}else{$nomor='';}
	($nomor=='')?$nomor=1:$nomor=(int)$nomor+1;
		if(strlen($nomor)==1){
		$nomo='00'.$nomor;
		}else if(strlen($nomor)==2){
			$nomo='00'.$nomor;
		}else{
			$nomo=$nomor;
		}
		$nom=date('Ymd').'-'.$nomo;
		return $nom;
	}
	function jenisbarang(){
		$idbr=$_POST['nmbarang'];
		echo dropdown('material','nmbarang','nmbarang',"order by nmbarang",$idbr);
	}
	function addbarang(){
		$data=array();
		$data['nmgroup']=$_POST['nmgroup'];
		$data['nmbarang']=$_POST['nmbarang'];
		$data['hgbarang']=$_POST['hgbarang'];
		$data['created_by']=$this->session->userdata('userid');
		$this->Admin_model->simpan_data('material',$data);
		echo $_POST['nmbarang'];
	}
	function auto_suggested(){
		$str=addslashes($_POST['str']);
		$datax=$this->Admin_model->find_match($str);
		if($datax->num_rows>0){
			echo "<ul>";
				foreach ($datax->result() as $lst){
					echo '<li onclick="suggest_click(\''.$lst->nmbarang.'\,\'nmbarang\');">'.$lst->nmbarang."</li>";
				}
			echo "</ul>";
		}
	}
	function nm_suggested(){
		$str=addslashes($_POST['str']);
		$datax=$this->Admin_model->find_match($str,"nasabah","nama_spb");
		if($datax->num_rows>0){
		echo "<ul>";
			foreach ($datax->result_array() as $lst){
				echo '<li onclick="suggest_click(\''.$lst['nama_spb'].'\',\'nama_spb\');">'.$lst['nama_spb']."</li>";
			}
		echo "</ul>";
		}
	}
	function nospb_suggested(){
		$str=addslashes($_POST['str']);
		$datax=$this->Admin_model->find_match_spb($str,"spb","no_spb");
		if($datax->num_rows>0){
			echo "<ul>";
				foreach ($datax->result() as $lst){
					echo '<li onclick="suggest_click(\''.$lst->no_spb.'\',\'no_spb\');">'.$lst->no_spb."</li>";
				}
			echo "</ul>";
		}
	}
	function ktp_nasabah(){
		$data='';
		$nsbh=$_POST['nama_spb'];
		$data=$this->Admin_model->show_single_field("nasabah","ktp_spb","where nama_spb='".$nsbh."'");	
		echo $data;
	}
	function cek_blacklist(){
		$ktp_spb=$_POST['ktp_spb'];
		$data=$this->Admin_model->field_exists('blacklist',"where ktp_spb='$ktp_spb'",'ktp_spb');
		echo ($data=='')? '':"No. KTP tersebut masuk dalam daftar blacklist\nSilahkan cek di menu Nasabah Blacklist";
	}
	function simpan_spb(){
		$datax=array();
		$nomor=explode('/',$this->input->post('no_spb'));
		$datax['no_spb']=(int)$nomor[0];
		$datax["created_by"]=$this->session->userdata("userid");
		$this->get_data_field('Spb','spb');
		if($this->Admin_model->show_single_field("nasabah","nama_spb","where nama_spb='".$this->input->post('nama_spb')."'")==''){
		$this->get_data_field('nasabah','nasabah');}
		$this->Admin_model->update_nomor($datax);
		redirect('spb/index');
	}
	
	public function get_data_field($section,$table){
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
		$this->Admin_model->simpan_data($table,$data);
		//print_r($data);
	}
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
//list spb
	function daftar(){
		$data=array();
		($this->input->post('bulan')=='')? $bln=date('m'):$bln=$this->input->post('bulan');
		($this->input->post('thn')=='')? $thn=date('Y'):$thn=$this->input->post('thn');
		$data['ae']=$this->Admin_model->is_oto('daftar','e');
		$data['list']=$this->Admin_model->show_list('spb',"where month(tgl_spb)='".$bln."' and year(tgl_spb)='".$thn."' order by left(no_spb,5),year(tgl_spb)");
		$data['bln']=$this->input->post('bulan');
		$data['thn']=$this->input->post('thn');
		//print_r($data);
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('daftar',$this->load->view('spb/daftar_spb',$data));
		$this->load->view('admin/footer');
	}
	function spb_edit(){
		$data=array();
		$id=$_POST['no_spb'];
		echo json_encode($this->show_data_field('Spb','spb',"where no_spb='$id'"));
	}
	function spb_edit_simpan(){
		$this->update_data_field('Spb','spb','no_spb');
		redirect('spb/daftar');
	}
//perpanjangan spb

	function perpanjang(){
		$data=array();
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('daftar',$this->load->view('spb/perpanjang_spb',$data));
		$this->load->view('admin/footer');
	}
	function list_perpanjang(){
		$n=0;
		$data=array();$datax=array();
		$no_spb=$_POST['no_spb'];
		$data['ae']=$this->Admin_model->is_oto('perpanjang','e');
		$data=$this->Admin_model->show_list('spb',"where no_spb='$no_spb' order by left(no_spb,5),year(tgl_spb)");
		foreach($data->result() as $row){
			$n++;
			echo "\n<tr class='xx' id='".$row->no_spb."' align='center'>
				  <td class='kotak' align='left'>".$row->id_barang."</td>	
				  <td class='kotak' align='right'>".number_format($row->taksir_spb,2)."</td>	
				  <td class='kotak' align='right'>".number_format($row->nilai_spb,2)."</td>	
				  <td class='kotak'>".$row->jw_spb."</td>	
				  <td class='kotak'>".TglfromSql($row->jt_spb)."</td>
				  <td id='c-1' class='kotak'>".perpanjang($row->no_spb,1)."</td>	
				  <td id='c-2' class='kotak'>".perpanjang($row->no_spb,2)."</td>	
				  <td id='c-3' class='kotak'>".perpanjang($row->no_spb,3)."</td>	
				  <td id='c-4' class='kotak'>".perpanjang($row->no_spb,4)."</td>	
				  <td id='c-5' class='kotak'>".perpanjang($row->no_spb,5)."</td>	
				  <td id='c-6' class='kotak'>".perpanjang($row->no_spb,6)."</td>	
				  <td id='c-7' class='kotak'>".perpanjang($row->no_spb,7)."</td>	
				  <td id='c-8' class='kotak'>".perpanjang($row->no_spb,8)."</td>	
				  <td id='c-9' class='kotak'>".perpanjang($row->no_spb,9)."</td>	
				  <td id='c-10'  class='kotak'>".perpanjang($row->no_spb,10)."</td>	
				  </tr>\n";
		}
		$datax['pp_ke']=rdb('perpanjang_spb','pp_ke','pp_ke',"where no_spb='".$row->no_spb."'");
		//echo json_encode($datax);
	}
	function pp_update(){
		$data=array();$datax=array();
		$data['no_spb']=$_POST['no_spb'];
		$data['pp_ke']=$_POST['pp_ke'];
		$data['pp_stat']=$_POST['pp_stat'];
		$data['pp_bayar']=$_POST['pp_bayar'];
		$data["created_by"]=$this->session->userdata("userid");
		$this->Admin_model->simpan_data('perpanjang_spb',$data);
		$this->Admin_model->upd_data('spb',"set stat_spb='".$_POST['pp_stat']."' where no_spb='".$_POST['no_spb']."'");
		//print_r($data);
	}
	function reset_aksi(){
		($_POST['pp_stat']!='')?
		$this->Admin_model->upd_data('perpanjang_spb',"set pp_stat='".$_POST['pp_stat']."',created_by='".$this->session->userdata("userid")."'","where no_spb='".$_POST['no_spb']."'"):
		$this->Admin_model->hps_data('perpanjang_spb',"where no_spb='".$_POST['no_spb']."' and pp_ke='".$_POST['pp_ke']."'");
		$this->Admin_model->upd_data('spb',"set stat_spb='Y',created_by='".$this->session->userdata("userid")."'","where no_spb='".$_POST['no_spb']."'");
		//print_r($data);
		//$this->list_perpanjang();
	}
//pelunasan
	function lunas(){
		$data=array();
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('daftar',$this->load->view('spb/pelunasan_spb',$data));
		$this->load->view('admin/footer');
	}
	function pelunasan(){
		$n=0;
		$data=array();$datax=array();
		$no_spb=$_POST['no_spb'];
		$data['ae']=$this->Admin_model->is_oto('lunas','e');
		$data=$this->Admin_model->show_list('spb',"where no_spb='$no_spb' order by left(no_spb,5),year(tgl_spb)");
		foreach($data->result() as $row){
			$n++;
			echo "\n<tr class='xx' id='".$row->no_spb."' align='center'>
				  <td class='kotak' align='left'>".$row->id_barang."</td>	
				  <td class='kotak' align='right'>".number_format($row->taksir_spb,2)."</td>	
				  <td class='kotak' align='right'>".number_format($row->nilai_spb,2)."</td>	
				  <td class='kotak'>".$row->jw_spb."</td>	
				  <td class='kotak'>".TglfromSql($row->jt_spb)."</td>
				  <td id='c-1' class='kotak'>".perpanjang($row->no_spb,1,true,true)."</td>	
				  <td id='c-2' class='kotak'>".perpanjang($row->no_spb,2,true,true)."</td>	
				  <td id='c-3' class='kotak'>".perpanjang($row->no_spb,3,true,true)."</td>	
				  <td id='c-4' class='kotak'>".perpanjang($row->no_spb,4,true,true)."</td>	
				  <td id='c-5' class='kotak'>".perpanjang($row->no_spb,5,true,true)."</td>	
				  <td id='c-6' class='kotak'>".perpanjang($row->no_spb,6,true,true)."</td>	
				  <td id='c-7' class='kotak'>".perpanjang($row->no_spb,7,true,true)."</td>	
				  <td id='c-8' class='kotak'>".perpanjang($row->no_spb,8,true,true)."</td>	
				  <td id='c-9' class='kotak'>".perpanjang($row->no_spb,9,true,true)."</td>	
				  <td id='c-10'  class='kotak'>".perpanjang($row->no_spb,10,true,true)."</td>	
				  </tr>\n";
		}
	}
	function print_slip(){
		$this->zetro_slip->path=$this->session->userdata('userid');
		$this->zetro_slip->mode();
		$this->zetro_slip->newline(9);
		$this->zetro_slip->content($this->isi_slip());
		$this->zetro_slip->create_file();	
		system("print '".$this->session->userdata('userid')."_slip.txt'");
		system("close");
	}
	function isi_slip(){
		$brsbaru=" \r\n";
		$nospb=explode('/',$_POST['no_spb']);
		$tglspb=explode('/',$_POST['tgl_spb']);
		$isine=array(str_repeat(' ',9).$nospb[0].str_repeat(' ',5).$nospb[2].str_repeat(' ',5).substr($nospb[3],2,2).$brsbaru.$brsbaru,
					 str_repeat(' ',12).$tglspb[0].str_repeat(' ',5).$tglspb[1].str_repeat(' ',5).substr($tglspb[2],2,2).$brsbaru.$brsbaru.$brsbaru,
					 str_repeat(' ',22).$_POST['nama_spb'].$brsbaru.$brsbaru,
					 str_repeat(' ',22).$_POST['ktp_spb'].$brsbaru.$brsbaru.$brsbaru,
					 str_repeat(' ',22).$_POST['id_barang'].$brsbaru.$brsbaru.$brsbaru.$brsbaru.$brsbaru,
					 str_repeat(' ',22).'Rp.  '.number_format($_POST['taksir_spb'],2).$brsbaru.$brsbaru,
					 str_repeat(' ',22).'Rp.  '.number_format($_POST['nilai_spb'],2).$brsbaru.$brsbaru,
					 str_repeat(' ',22).$_POST['jw_spb'].' Hari'.$brsbaru.$brsbaru,
					 str_repeat(' ',22).$_POST['jt_spb'].$brsbaru);
		return $isine;
	}
/*
end of class spb
Author : Iswan Putera S.Kom
Location : application/controllers/spb.php
*/
}
?>