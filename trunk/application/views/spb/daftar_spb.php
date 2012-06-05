<?php
empty($bln)?$blne=date('m'):$blne=$bln;
empty($thn)?$thne=date('Y'):$thne=$thn;
link_js('zetro_number.js,list_spb.js','asset/js,application/views/spb/js');
$user_aktiv=$this->session->userdata("userid");
$blnj="<select id='bulan' name='bulan'></select>";
$thnj="<select id='thn' name='thn'></select>";
echo "<form id='frm1' name='frm1' action='' method='post'>";
panel_begin('Daftar SPB','',"Filter by Bulan :,".$blnj.",Tahun :,".$thnj);
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
		   <td class='kotak'>".tglfromSql($lst['jt_spb'])."</td>
		   <td class='kotak' width='8%'>";
			 if ($ae=='Y' || $user_aktiv=='Superuser' ){ ( $lst['stat_spb']=='Y')? $zb->event($lst['no_spb']):'';}
			echo "<td></tr>";
	}
echo "</tbody></table>\n";
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
	    $('#id_barang').html("<? dropdown('material','nmbarang','nmbarang',"order by nmbarang");?>");
    });
</script>