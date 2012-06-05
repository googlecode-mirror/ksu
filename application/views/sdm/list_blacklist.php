<?php
link_js('zetro_number.js,list_nasabah.js','asset/js,application/views/sdm/js');
$user_aktiv=$this->session->userdata("userid");
panel_begin('Black List','');
$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
$zb->ListHeader('nasabah','70%','listTable');
$no=0;
echo "<tbody>";//($page+1);
	foreach($list->result_array() as $lst){
	$no++;
	 echo "<tr class='xx' id='".$lst['ktp_spb']."' align='left'>\n
		   <td class='kotak' align='center'>$no</td>
		   <td class='kotak'>".$lst['nama_spb']."$ae</td>
		   <td class='kotak'>".$lst['ktp_spb']."</td>
		   <td class='kotak'>".$lst['almnasabah']."</td>
		   <td class='kotak' width='8%' align='center'>";
		   $bls=rdb('blacklist','ktp_spb','ktp_spb',"where ktp_spb='".$lst['ktp_spb']."'");
			 if ($ae=='Y' || $user_aktiv=='Superuser'){ $zb->event($lst['ktp_spb']);}
			echo "</td></tr>\n";
	}
	echo "</tbody></table>";
panel_end();
popup_start('Edit Data Nasabah',500,300,'frm2');
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->AddBarisKosong(true);
$zb->BuildForm('nasabah',true,'80%');
popup_end('');

?>
<input type='text' id='prs' value='bcl'>
<script language='javascript'>
	$(document).ready(function(e) {
		$('img.edit').hide();
		$('img.del').attr({'src':'<?=base_url();?>asset/images/up2.png','title':'Keluarkan dari daftar Black List'});
       // $('img.del').show();;
		//$('img.del').addClass('pas');
					
    });
</script>
