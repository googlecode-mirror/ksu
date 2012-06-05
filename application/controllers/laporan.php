<?php
class Laporan extends CI_Controller {
  public $tc;
  public $zn;
	public $zc;
	public $zm;
	public $nfiles;
    function  __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('spb_model');
		$this->tc= new zetro_table_creator('asset/bin/zetro_table.cfg');
		$this->zn= new zetro_manager();
		$this->zc='asset/bin/zetro_config.dll';
		$this->zm='asset/bin/zetro_menu.dll';
		$this->nfiles='asset/bin/zetro_form.cfg';
	}
	function lap_daftar(){
		$data=array();
		($this->input->post('bulan')=='')? $bln=date('m'):$bln=$this->input->post('bulan');
		($this->input->post('thn')=='')? $thn=date('Y'):$thn=$this->input->post('thn');
		$data['ae']=$this->Admin_model->is_oto('lap_daftar','e');
		$data['list']=$this->Admin_model->show_list('spb',"where month(tgl_spb)='".$bln."' and year(tgl_spb)='".$thn."' order by left(no_spb,5),year(tgl_spb)");
		$data['bln']=$this->input->post('bulan');
		$data['thn']=$this->input->post('thn');
		//print_r($data);
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('lap_daftar',$this->load->view('laporan/lap_daftar_spb',$data));
		$this->load->view('admin/footer');
	}
	
	function lap_perpanjang(){
		$n=0;
		$data=array();$datax=array();
		$no_spb=$_POST['no_spb'];
		$data['ae']=$this->Admin_model->is_oto('perpanjang','e');
		$data=$this->Admin_model->show_list('spb',"where jt_spb <now() order by left(no_spb,5),year(tgl_spb)");
		foreach($data->result() as $row){
			$n++;
			echo "\n<tr class='xx' id='".$row->no_spb."' align='center'>
				  <td class='kotak' align='left'>".$row->id_barang."</td>	
				  <td class='kotak' align='left'>".substr($row->no_spb,0,5)."</td>	
				  <td class='kotak' align='left'>".ShortTgl($row->tgl_spb,true)."</td>	
				  <td class='kotak' align='left'>".$row->nama_spb."</td>	
				  <td class='kotak' align='right'>".number_format($row->taksir_spb,2)."</td>	
				  <td class='kotak' align='right'>".number_format($row->nilai_spb,2)."</td>	
				  <td class='kotak'>".$row->jw_spb."</td>	
				  <td class='kotak'>".TglfromSql($row->jt_spb)."</td>
				  <td id='c-1' class='kotak'>".perpanjang($row->no_spb,1,true)."</td>	
				  <td id='c-2' class='kotak'>".perpanjang($row->no_spb,2,true)."</td>	
				  <td id='c-3' class='kotak'>".perpanjang($row->no_spb,3,true)."</td>	
				  <td id='c-4' class='kotak'>".perpanjang($row->no_spb,4,true)."</td>	
				  <td id='c-5' class='kotak'>".perpanjang($row->no_spb,5,true)."</td>	
				  <td id='c-6' class='kotak'>".perpanjang($row->no_spb,6,true)."</td>	
				  <td id='c-7' class='kotak'>".perpanjang($row->no_spb,7,true)."</td>	
				  <td id='c-8' class='kotak'>".perpanjang($row->no_spb,8,true)."</td>	
				  <td id='c-9' class='kotak'>".perpanjang($row->no_spb,9,true)."</td>	
				  <td id='c-10'  class='kotak'>".perpanjang($row->no_spb,10,true)."</td>	
				  </tr>\n";
		}
		//$datax['pp_ke']=rdb('perpanjang_spb','pp_ke','pp_ke',"where no_spb='".$row->no_spb."'");
		//echo json_encode($datax);
	}
	function mychart(){  
        //$this->load->libraries('fusion_pi');  
        $arrData = array();
		$FC = new FusionCharts("Column3D","720","400");  
        /*$arrData = array( 500, 269, 254, 895, 633);  
        foreach( $arrData as $i=>$data ){  
            $FC->addChartData( $data );  
        } */
		//$sql="select count(distinct(nama_spb)) as nama_spb,month(tgl_spb) as bln from spb group by concat(month(tgl_spb),year(tgl_spb))";
		//echo $sql;
		$FC->setDataURL("graph.xml");
        $strParam="numberSuffix=; formatNumberScale=0; decimalPrecision=0; xAxisName=Bulan; animation=1";  
        $FC->setChartParams($strParam);  
        $FC->setChartMessage("ChartNoDataText=Chart Data not provided; PBarLoadingText=Please Wait.The chart is loading...");  
		return $FC->renderChart(false,false);  
    }
	function lap_nasabah(){
		$data=array();
		empty($_POST['thn'])?$thn=date('Y'):$thn=$_POST['thn'];
		$data['prs']='nol';
		$data['thn']=$thn;
		$this->_judul_grafik('Grafik Jml Nasabah Tahun :'.$thn);
		$this->_judul_axis('Bulan','Jumlah');
		$this->_data_sec($this->Admin_model->total_record($thn));
		//print_r($this->datasec);
		$this->data_XML();
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('lap_nasabah',$this->load->view('laporan/lap_nasabah',$data));
		$this->load->view('admin/footer');
	}
	function lap_nilaitaksir(){
		$data=array();
		empty($_POST['thn'])?$thn=date('Y'):$thn=$_POST['thn'];
		$data['prs']='nil';
		$data['thn']=$thn;
		$this->_judul_grafik('Grafik Nilai Taksir Tahun :'.$thn);
		$this->_judul_axis('Bulan','Rupiah');
		$this->_data_sec($this->spb_model->total_record_val($thn));
		$this->data_XML();
		//$this->load->view('admin/header');
		//$this->Admin_model->is_oto_all('lap_nasabah',$this->load->view('laporan/lap_nasabah',$data));
		//$this->load->view('admin/footer');
		echo 'nill,chartdiv2,'.$thn;
	}
	function lap_jumlahnasabah(){
		$data=array();
		empty($_POST['thn'])?$thn=date('Y'):$thn=$_POST['thn'];
		$data['prs']='nol';
		$data['thn']=$thn;
		$this->_judul_grafik('Grafik Jml Nasabah Tahun :'.$thn);
		$this->_judul_axis('Bulan','Jumlah');
		$this->_data_sec($this->Admin_model->total_record($thn));
		//print_r($this->datasec);
		$this->data_XML();
		echo 'nol,chartdiv,'.$thn;
	}
	
	function lap_material(){
		$data=array();
		empty($_POST['thn'])?$thn=date('Y'):$thn=$_POST['thn'];
		$data['prs']='nol';
		$data['thn']=$thn;
		$this->_judul_grafik('Grafik Jml Barang Tahun :'.$thn);
		$this->_judul_axis('Bulan','Jumlah');
		$this->_data_sec($this->spb_model->total_barang($thn));
		//print_r($this->datasec);
		$this->data_XML();
		$this->load->view('admin/header');
		$this->Admin_model->is_oto_all('lap_nasabah',$this->load->view('laporan/lap_barang',$data));
		$this->load->view('admin/footer');
	}
	function lap_jumlahbarang(){
		$data=array();
		empty($_POST['thn'])?$thn=date('Y'):$thn=$_POST['thn'];
		$data['prs']='nol';
		$data['thn']=$thn;
		$this->_judul_grafik('Grafik Jumlah Barang Tahun :'.$thn);
		$this->_judul_axis('Bulan','Jumlah');
		$this->_data_sec($this->spb_model->total_barang($thn));
		$this->data_XML();
		//$this->load->view('admin/header');
		//$this->Admin_model->is_oto_all('lap_nasabah',$this->load->view('laporan/lap_nasabah',$data));
		//$this->load->view('admin/footer');
		echo 'nol,chartdiv,'.$thn;
	}
	function lap_nilaibarang(){
		$data=array();
		empty($_POST['thn'])?$thn=date('Y'):$thn=$_POST['thn'];
		$data['prs']='nil';
		$data['thn']=$thn;
		$this->_judul_grafik('Grafik Nilai Barang Tahun :'.$thn);
		$this->_judul_axis('Bulan','Rupiah');
		$this->_data_sec($this->spb_model->total_barang_val($thn));
		$this->data_XML();
		//$this->load->view('admin/header');
		//$this->Admin_model->is_oto_all('lap_nasabah',$this->load->view('laporan/lap_nasabah',$data));
		//$this->load->view('admin/footer');
		echo 'nill,chartdiv2,'.$thn;
	}

	function data_XML(){
		$n=0;$x=0;
		$user=$this->session->userdata('userid');
		$xml=fopen($user.'_graph.xml','wb');
		fwrite($xml,"<graph caption='".$this->judul."' xAxisName='".$this->xAxis."' yAxisName='".$this->yAxis."' numberPrefix='' showvalues='1'  numDivLines='4' formatNumberScale='0' decimalPrecision='0' anchorSides='10' anchorRadius='3' anchorBorderColor='00990'>\r\n");
		foreach($this->datasec as $sec=>$par_tip){
			fwrite($xml,"<set name='".$sec.'\' value=\''.$par_tip."'/>\r\n");
			$n++;
		}
		fwrite($xml,"</graph>\r\n");
	}
	
	
	function _judul_grafik($judul=''){
		$this->judul=$judul;
	}
	function _judul_axis($xAxis='',$yAxis=''){
		$this->xAxis=$xAxis;
		$this->yAxis=$yAxis;
	}
	function _data_cat($datacat){
		if(is_array($datacat)){
			 $this->datacat=$datacat;
		}else{
			return false;
		}
	}
	function _data_sec($datasec){
		if(is_array($datasec)){
			$this->datasec=$datasec;
		}else{
			return false;
		}			
	}
	
		

/*
end of class spb
Author : Iswan Putera S.Kom
Location : application/controllers/spb.php
*/
}
?>