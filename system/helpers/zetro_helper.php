<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	function __construct(){
			
	}
	function check_logged_in($status=FALSE){
        if ( $status!= TRUE) {
            redirect('admin/index', 'refresh');
            exit();
        }
	}

	function hapus_table($table,$where){
		$sql="delete from $table $where";
		mysql_query($sql) or die(mysql_error());	
	}
	function rdb($tabel,$rfield,$sfield='',$where='',$order='',$group=''){
		$datadb="";
		if($sfield==''){
		$sql="select * from ".$tabel." $where $group $order";
		}else{
		$sql="select ".$sfield. " from ".$tabel." $where $group $order";
		}
		$rs=mysql_query($sql) or die($sql.mysql_error());
		while($rw=mysql_fetch_array($rs)){
			$datadb=$rw[$rfield];
		}
		return $datadb;
	}
	function RowCount($tabel,$where='',$sfield='*'){
		$databd=0;
		$sql="select $sfield from $tabel $where";
		$rs=mysql_query($sql) or die($sql.mysql_error());
		$datadb=mysql_num_rows($rs);
		return $datadb;
	}
	function hapus($tabel,$where){
		$sql="delete from $tabel $where";
		mysql_query($sql) or die(mysql_error());
	}
	function dropdown($tabel,$fieldforval,$fieldforname='',$where='',$pilih='',$bariskosong=true){
		if ($bariskosong==true) echo "<option value=''>&nbsp;</option>";
		$dst=explode(" as ",$fieldforval);
		if($fieldforname!=''){$dst2=explode(",",$fieldforname);}
		($fieldforname=='')?
		$sql="select $fieldforval from $tabel $where":		
		$sql="select $fieldforval,$fieldforname from $tabel $where";
			$rs=mysql_query($sql) or die(mysql_error());
			while ($rw=mysql_fetch_object($rs)){
			(count($dst)>1)? $valu=$rw->$dst[1]: $valu=$rw->$dst[0];
			if($fieldforname!='')(count($dst2)>1)? $addnm=$rw->$dst2[0]." [".$rw->$dst2[1]." ]":$addnm=$rw->$dst2[0];
			echo "<option value='".$valu."'";if ($pilih==$valu){ echo " selected";}
			echo " >";echo ($fieldforname=='')? $rw->$dst[1]:$addnm."</option>";	
			}
	}
	function lama_execute(){
		$awal = microtime(true);
		
		// --- bagian yang akan dihitung execution time --
		
		$bil = 2;
		$hasil = 1;
		for ($i=1; $i<=10000000; $i++)
		{
			 $hasil .= $bil;
		}
		
		// --- bagian yang akan dihitung execution time --
		
		$akhir = microtime(true);
		$lama = $akhir - $awal;
		return $lama;
	}
	
	function nBulan($bln){
		$bln=array('','January','February','Maret','April','Mei','Juni','Juli','Agustus','September',
					'Oktober','November','Desember');
		return $bln[round($bln)];	
	}
	function penomoran($table,$fieldnomor){
		$nom=rdb($table,$fieldnomor,$fieldnomor,"order by $fieldnomor desc limit 1");
		if ($nom==""){
			$nomor=date('Ymd')."-0001";
		}else{
			$noms=explode("-",$nom);
			if (strlen((int)$noms[1])==1){
				$nomor=date('Ymd')."-000".($noms[1]+1);
			}else if(strlen((int)$noms[1])==2){
				$nomor=date('Ymd')."-00".($noms[1]+1);
			}else if(strlen((int)$noms[1])==3){
				$nomor=date('Ymd')."-0".($noms[1]+1);
			}else if(strlen((int)$noms[1])==4){
				$nomor=date('Ymd')."-".($noms[1]+1);
			}
		}
		return $nomor;
	}
	function tglToSql($tgl=''){
		//input dd/mm/yyyy -->output yyyymmdd
		if($tgl==''){
			$tanggal=date('Ymd');
		}else{
			$tanggal=substr($tgl,6,4).substr($tgl,3,2).substr($tgl,0,2);
		}
		return $tanggal;
	}
	function tglfromSql($tgl='',$separator='/'){
		($tgl=='')?
		$tanggal='dd/mm/yyyy':
		$tanggal=substr($tgl,8,2).$separator.substr($tgl,5,2).$separator.substr($tgl,0,4);
		return $tanggal;
	}
	function ShortTgl($tgl='',$withYear=false){
		($tgl=='')?
		$tanggal=date('d/m'):
		$tanggal=($withYear==true)?substr($tgl,8,2).'/'.substr($tgl,5,2).'/'.substr($tgl,2,2):substr($tgl,8,2).'/'.substr($tgl,5,2);
		return $tanggal;
	}
	function no_auth(){
	echo "<img src='".base_url()."asset/images/warning.png'>";?>
	<font style="font-family:'20th Century Font', Arial; color:#DD0000; font-size:xx-large">
	<? $zn= new zetro_manager();
        echo $zn->rContent("Message","NoAuth","asset/bin/form.cfg");
        ?>
	</font>
    <?
	}
	function panel_begin($judul,$form='',$filter='',$printer=''){
	$judul= explode(',',$judul);
	echo "<div class='contents'>\n
			<table style='border-collapse:collapse' border='0' id='panel'>\n
			<tr height='35px' align='center'>\n";
			for ($i=0;$i< count($judul);$i++){
			  echo "<td width='120px' class='j_panel' id='".strtolower(str_replace(" ",'',$judul[$i]))."'>".$judul[$i]."</td>\n";
			}
		if($filter!=''){
			echo "<td width='50px' class='flt'>&nbsp;</td>";
			$flt=explode(',',$filter);
			for($z=0;$z< count($flt);$z++){
				echo "<td bgcolor='' class='flt'>".$flt[$z]."</td>";
			}
		}
		if($printer!=''){
			echo "<td width='50px' class='plt'>&nbsp;</td>";
			$flt=explode(',',$printer);
			echo "<td bgcolor='' class='plt' align='right'>";
			for($z=0;$z< count($flt);$z++){
				echo $flt[$z].'&nbsp;';
			}
			echo "</td>";
		}
		echo "</tr></table>\n
			<div class='pn_content'>\n
			<hr>\n";
		echo ($form!='')? "<form id='$form' name='$form' action='' method='post'>\n":'';
	}
	function panel_multi($id,$display='none'){
		echo "<span id='v_$id' style='display:$display'>";
	}
	function panel_multi_end(){
		echo "</span>";
	}
	function panel_end($form=false){
		echo "</div></div>\n";
		echo ($form==true)? "</form>\n":'';
	}
	function link_js($js,$path){
	$js=explode(",",$js);$pathe=explode(",",$path);
		for ($i=0;$i< count($js);$i++){
		 echo "<script language='javascript' src='".base_url().$pathe[$i]."/".$js[$i]."' type='text/javascript'></script>\n";	
		}
	}
	function link_css($css,$path){
	$css=explode(",",$css);$pathe=explode(",",$path);
		for ($i=0;$i< count($css);$i++){
		 echo "<link href='".base_url().$pathe[$i]."/".$css[$i]."' type='text/css' rel='stylesheet'>\n";	
		}
	}
	function popup_start($caption='',$width='500',$height='500',$form=''){
	?>  <div id='lock' class='black_overlay'></div>
        <div id='lvladd' align="center"  style='display:none; border:5px solid #333; padding:0px; left:0; top:0; width:<?=$width;?>px; max-height:<?=$height;?>px; position:fixed; overflow:auto; z-index:9999'>
        <table id='lvltbl0' width="100%" style='border-collapse:collapse'>
        <tr><td colspan='2' bgcolor="#333" class=''>
        <font style='font-size:large; color:#FFFFFF'><?=$caption;?></font></td>
        <td bgcolor="#333" align="center" width="10px"><font color="#FFFFFF">
        <img src="<?=base_url();?>asset/images/no.png"  id='close' style='cursor:pointer' title="Close"/></font></td></tr>
        </table>
        <?	
        echo ($form!='')? "<form id='$form' name='$form' action='' method='post'>\n":'';
	}
	
	function popup_end($form=false){
	 echo "</div>\n";
	 echo ($form==true)? "</form>\n":'';	
	}
	
	function getNextDays($fromdate,$countdays) {
		$dated='';
		$time = strtotime($fromdate); // 20091030
		$day = 60*60*24;
		for($i = 0; $i<$countdays; $i++)
		{
			$the_time = $time+($day*$i);
			$dated = date('Y-m-d',$the_time);
		}
			return $dated;
    }
	
	function  compare_date($date_1,$date_2){
	  list($year, $month, $day) = explode('-', $date_1);
	  $new_date_1 = sprintf('%04d%02d%02d', $year, $month, $day);
	  list($year, $month, $day) = explode('-', $date_2);
	  $new_date_2 = sprintf('%04d%02d%02d', $year, $month, $day);
		
		($new_date_1 <= $new_date_2)? $data=true:$data=false; 
		return $data;
  	}
	
	function perpanjang($no_spb,$pp_ke=1,$showtgl=false,$bayar=false){
	   $jtspb=rdb('spb','tgl_spb','tgl_spb',"where no_spb='$no_spb'");
	   $nextjtspb=getNextDays($jtspb,($pp_ke *30));
	   $nextjtspb2=getNextDays($jtspb,(($pp_ke+1) *30));
	   $bataslelang=getNextDays($nextjtspb,13);
	   $today=date('Y-m-d');
	   $stat=rdb('perpanjang_spb','pp_ke','pp_ke',"where no_spb='".$no_spb."' and pp_ke='$pp_ke'");
	   $action=rdb('perpanjang_spb','pp_stat','pp_stat',"where no_spb='".$no_spb."' and pp_ke='$pp_ke'");
	   $bayare=($bayar==true && $pp_ke>1)?rdb('perpanjang_spb','pp_stat','pp_stat',"where no_spb='".$no_spb."' and pp_ke='".($pp_ke-1)."'"):'';
	   $bunga=rdb('spb','taksir_spb','taksir_spb',"where no_spb='$no_spb'");
	   $bunga=($bunga*10/100);
	   if($stat==''){
		   if(compare_date($today,$bataslelang)==true && compare_date($today,$nextjtspb)==false){
			    return "<img class='aksi' src='".base_url()."/asset/images/icon-25.gif' width='20' height='20' title='Klik untuk process perpanjang' onclick=\"aksi_click('$no_spb','$pp_ke','$bunga')\";>";
		   }else{
			  return (compare_date($nextjtspb2,$today)==false)?
			  	 ($bayar==true && $bayare=='Y' || $pp_ke=='1')?
				 "<img src='".base_url()."/asset/images/checkout.gif' title='Click untuk transaksi bayar' onclick=\"aksi_click('$no_spb','$pp_ke','$bunga')\">":false: 
			 	 "<img src='".base_url()."/asset/images/8.png' title='Tidak di perpanjang lanjut untuk process lelang'>";
		   }
	   }else{
		if ($action=='Y'){
			return($showtgl==false)?
		   		 "<img src='".base_url()."/asset/images/iconic.png' ondblclick=\"reset_upd('$no_spb','$pp_ke','');\" title='Telah di perpanjang ".($stat)." kali.\nTanggal Jatuh Tempo berikutnya :".tglfromSql(getNextDays($jtspb,(($stat+1) *30)))."'>":
				 ShortTgl($nextjtspb2);
		}else if($action=='N'){
			return	"<img src='".base_url()."/asset/images/8.png' ondblclick=\"reset_upd('$no_spb','$pp_ke','Y');\" title='Tidak di perpanjang lanjut untuk process lelang'>";
		}else if($action=='L'){
			return	"<img src='".base_url()."/asset/images/bullet.png' title='Lunas'>";
		}else{
			return false;
		}
	   }
	   
	}
//}