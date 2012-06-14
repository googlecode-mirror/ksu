<?php
link_css('autosuggest.css','asset/css');
empty($ttl)?$ttl0=0:$ttl0=$ttl;
$img="<img src='".base_url()."asset/images/printer.png' id='print' title='Print Label' class='xx'>";
$pilihan="<input type='text' id='spb_label' name='spb_label' class='cari w100'>";
$check="<input type='checkbox' id='re_prn'>";
link_js('zetro_number.js,master_label.js','asset/js,application/views/master/js');
panel_begin('Pilih Barang,Print Label','',$check .', Print Ulang, | Cari nama barang yang akan di label  :,'.$pilihan,',,'.$img.', Print to printer');
$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
panel_multi('pilihbarang',true);
?>
<table width='70%' border='0' id='listdata' style='border-collapse:collapse; padding-left:10px;'>
<tbody>
</tbody>
</table>
<?
panel_multi_end();
panel_multi('printlabel');
?>
<table border='0' id='listlabel' style='border-collapse:collapse;'>
<tbody>
</tbody>
</table>
<?
panel_multi_end();
panel_end();
?>
<input type='hidden' id='prs' value='' />
<div class="autosuggest" id="autosuggest_list"></div>
<script language="javascript">
	$(document).ready(function(e) {
		$('#print').click(function(){
			document.location.href='<?=base_url();?>index.php/master/print_label';
		})/**/
    });
</script>