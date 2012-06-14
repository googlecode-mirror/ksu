<?php
class Report extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("lap_model","",true);
    $this->load->model("Admin_model","",true);
  }

	function print_lap_spb(){
		$data=array();
		$con=$this->uri->segment(3);
		$con=explode('-',$con);
		($this->uri->segment(3)=='')? $bln=date('m'):$bln=$con[0];
		($this->uri->segment(3)=='')? $thn=date('Y'):$thn=$con[1];
		$oto_p=$this->Admin_model->is_oto('laporan/lap_daftar','p');
		$data['bln']=$bln;
		$data['thn']=$thn;
		$data['temp_rec']=$this->lap_model->show_lap_spb($bln,$thn);
		  $this->load->view('laporan/lap_print_spb',$data);
    }
}
?>
