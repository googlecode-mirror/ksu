
<?
link_css('autosuggest.css','asset/css');
link_js('zetro_number.js,spb.js,jquery_terbilang.js','asset/js,application/views/spb/js,asset/js');
panel_begin('SPB','frm1');
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->AddButton(array('Print Slip'));
$zb->BuildForm('Spb',true,'80%','',3);
panel_end();
//popup menu
popup_start('Tambah Jenis Barang',500,500,'frm2');
$zb->AddBarisKosong(true);
$zb->BuildForm('Material',true,'100%','popup');
popup_end();
?>
<script language='javascript'>
$(document).ready(function(e) {
	var today= new Date();
	var bln='<?=date('m');?>';//today.getMonth();
	(bln.length==0)? xx='0'+bln:xx=bln;
 	$('#no_spb').val('<?=$no_spb;?>/SPB/'+xx+'/'+today.getFullYear());
   $('#nama_spb').focus().select();
   $('#id_barang').html("<? dropdown('material','nmbarang','nmbarang',"order by nmbarang");?>");
});
</script>
<span id='addlevel' style=" display:none; "><input type="button" id='addlvl' value='+' title='Tambah Jenis Barang' /></span>
<div class="autosuggest" id="autosuggest_list"></div>
<div id='terbilang' style='left:0px;top:0px;position:fixed; display:none;color:#000000'></div>
<div id='info' align='center'>
<div class='j_info' align="left">Information</div>
<div id='txtmsg'></div><hr />
<span><input type='button' id='ok' value='OK' /></span><br />
</div>

