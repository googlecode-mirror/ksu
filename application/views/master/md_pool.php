<script language="javascript">
	$(document).ready(function(e) {
		$('#nmpoll').focus().select();	
		lock('#idpool');
		$('#idpool').val("<?=penomoran("pool","idpool");?>");	
		
		$('#saved').click(function(){
			unlock('#idpool');
			$('#frm1').attr('action','<?=base_url();?>index.php/master/md_pool_simpan');
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
$zb->BuildForm('Pool',true,'80%');
}
//echo "</form>";
?>
</div>
