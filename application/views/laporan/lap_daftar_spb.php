<?php
empty($bln)?$blne=date('m'):$blne=$bln;
empty($thn)?$thne=date('Y'):$thne=$thn;
link_js('jquery_print.js','application/views/admin/js');
link_js('zetro_number.js,lap_list_spb.js','asset/js,application/views/laporan/js');
$user_aktiv=$this->session->userdata("userid");
$blnj="<select id='bulan' name='bulan'></select>";
$thnj="<select id='thn' name='thn'></select>";
$img="<img src='".base_url()."asset/images/printer.png' id='printing' title='Print Report' class='xx'>";
echo "<form id='frm1' name='frm1' action='' method='post'>";
panel_begin('Daftar SPB,Perpanjang SPB','',"Filter by Bulan :,".$blnj.",Tahun :,".$thnj.",&nbsp;&nbsp;&nbsp;","$img");
panel_multi('daftarspb','block');
$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
$zb->ListHeader('Spb','100%','listTable');
$no=0;//($page+1);
	foreach($list->result_array() as $lst){
	$no++;
	 echo "<tr class='xx' id='".$lst['no_spb']."' align='center'>
		   <td class='kotak'>$no</td>
	 	   <td class='kotak'>".$lst['no_spb']."</td>
		   <td class='kotak'>".tglfromSql($lst['tgl_spb'])."</td>
		   <td class='kotak' align='left'>".$lst['nama_spb']."</td>
		   <td class='kotak' align='left'>".$lst['ktp_spb']."</td>
		   <td class='kotak' align='left'>".$lst['id_barang']."</td>
		   <td class='kotak' align='right'>".number_format($lst['taksir_spb'],2)."</td>
		   <td class='kotak' align='right'>".number_format($lst['nilai_spb'],2)."</td>
		   <td class='kotak'>".$lst['jw_spb']."</td>
		   <td class='kotak'>".tglfromSql($lst['jt_spb'])."</td>";
		   $ppke=rdb("perpanjang_spb","pp_ke",'pp_ke',"where no_spb='".$lst['no_spb']."'");
		   echo (compare_date($lst['jt_spb'],date('Y-m-d')))?
		   "<td class='kotak' width='5%'>". perpanjang($lst['no_spb'],$ppke)."<td>":
		   "<td class='kotak' width='5%'>&nbsp;</td></tr>";
	}
echo "</tbody></table>\n";
panel_multi_end();
panel_multi('perpanjangspb');
?>
<table id='listdata' style='border-collapse:collapse'>
<thead>
<tr class='header'>
<th class='kotak' rowspan='2' width='20%'>URAIAN</th>
<th class='kotak' colspan='2' width='12%'>PENJUALAN</th>
<th class='kotak' rowspan='2' width='10%'>NAMA NASABAH</th>
<th class='kotak' rowspan='2' width='10%'>TAKSIR</th>
<th class='kotak' rowspan='2' width='10%'>NILAI TAKSIR</th>
<th class='kotak' rowspan='2' width='5%'>WAKTU</th>
<th class='kotak' rowspan='2' width='8%'>JATUH TEMPO</th>
<th class='kotak' colspan='10' width='30%'>PERPANJANGAN WAKTU</th>
</tr>
<tr class='header' align='center'>
<th class='kotak' width='6%'>NO.SPB</th>
<Th class='kotak' width='6%'>TGL</Th>
<th class='kotak' width='3%'>1</th>
<th class='kotak' width='3%'>2</th>
<th class='kotak' width='3%'>3</th>
<th class='kotak' width='3%'>4</th>
<th class='kotak' width='3%'>5</th>
<th class='kotak' width='3%'>6</th>
<th class='kotak' width='3%'>7</th>
<th class='kotak' width='3%'>8</th>
<th class='kotak' width='3%'>9</th>
<th class='kotak' width='3%'>10</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<?
panel_multi_end();
panel_end();
echo "</form>";
popup_start('Edit SPB',500,500,'frm2');
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->AddBarisKosong(true);
$zb->BuildForm('Spb',true,'80%');
popup_end('');
?>
<script language='javascript'>
	$(document).ready(function(e) {
        $('#bulan').html("<? dropdown('spb','distinct(month(tgl_spb)) as bln','','order by month(tgl_spb)',$blne);?>");
        $('#thn').html("<? dropdown('spb','distinct(year(tgl_spb)) as thn','','order by year(tgl_spb)',$thne);?>");
	    //$('#id_barang').html("<? dropdown('material','nmbarang','nmbarang',"order by nmbarang");?>");
    });
</script>
<input type='hidden' id='prs' value='' />
<input type='hidden' id='yngaktif' val-'' />