<?php
link_css('autosuggest.css','asset/css');
link_js('jquery_terbilang.js,zetro_number.js,pelunasan_spb.js','asset/js,asset/js,application/views/spb/js');
$user_aktiv=$this->session->userdata("userid");
$bln="<select id='bulan'></select>";
$thn="<select id='thn'></select>";
panel_begin('Pelunasan SPB','frm1');
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->AddBarisKosong(true);
$zb->BuildForm('perpanjang','','60%');
echo "<br/>\n";
?>
<table id='listTable' width='100%' style='border-collapse:collapse'>
<thead>
<tr class='header' align='center'>
<th class='kotak' rowspan='2' width='25%'>Uraian</th>
<th class='kotak' rowspan='2' width='10%'>Taksir</th>
<th class='kotak' rowspan='2' width='10%'>Nilai Taksir</th>
<th class='kotak' rowspan='2' width='5%'>Jangka Waktu</th>
<th class='kotak' rowspan='2' width='10%'>Jatuh Tempo</th>
<th class='kotak' colspan='10' width='40%'>Perpanjangan Waktu</th>
</tr>
<tr class='header' align='center'>
<th class='kotak'>1</th>
<th class='kotak'>2</th>
<th class='kotak'>3</th>
<th class='kotak'>4</th>
<th class='kotak'>5</th>
<th class='kotak'>6</th>
<th class='kotak'>7</th>
<th class='kotak'>8</th>
<th class='kotak'>9</th>
<th class='kotak'>10</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<?
panel_end();
?>

<div class="autosuggest" id="autosuggest_list"></div>

<?
popup_start('Process Document','350','200','frm5');
?><br />
<table style='border-collapse:collapse' width='95%' align='center'>
  <tr><td width='50%' class='b_line'>Tindakan :&nbsp;</td><td width='50%'>
	 <select id='tindakan' name='tindakan' class=''>
	 <option value=''>&nbsp;</option>
	 <option value='L'>Pelunasaan</Option>
	 <!--option value='N'>Tidak</Option-->
     </select></td></tr>
  <tr id='hrg' style='display:none'><td class='b_line'> Jumlah pembayaran : &nbsp;</td><td>
	 <input id='bayar' name='bayar' type='text' class='angka' value='0'></td></tr>
   <tr id='hrg' style='display:none'><td class='b_line'>Terbilang</td><td><div id='terbilang'></div></td></tr>
   <tr height='30' valign='middle'><td colspan='2' align='right'>
   <input type='button' value='Submit' id='simpan' />
   <input type='hidden' id='nospb' name='nospb' value='' />
   <input type='hidden' id='ppke' name='ppke' value='' />
   <input type='hidden' id='bungane' name='bungane' value='' />
   </td></tr>
	</table><br />
<?	 
popup_end(true);
?>