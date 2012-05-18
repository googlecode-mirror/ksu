<script language="javascript">
	$(document).ready(function(e) {
		$('#nmclient').focus().select();	
		lock('#idclient');
		$('#idclient').val("<?=penomoran("client","idclient");?>");	
		
		$('#saved').click(function(){
			unlock('#idclient');
			$('#frm1').attr('action','<?=base_url();?>index.php/master/md_client_simpan');
			document.frm1.submit();
		});
	});
</script>
<? $prs=@$_GET['prs'];
?>
<div class='contents'>
<div class="j_panel judul">Uang Jalan</div>
<div class="pn_content">
<hr>
<?
if($prs!='list'){
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('Client',true,'80%');
}
//echo "</form>";
?>
</div>
