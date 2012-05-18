<script language="javascript">
	$(document).ready(function(e) {
		$('input:first').focus().select();	
		lock('input:not(:first),select,textarea')	
	});
</script>
<? $prs=@$_GET['prs'];
?>
<div class='contents'>
<div class="j_panel judul" style="width:20%">Biodata Karyawan</div>
<div class="pn_content">
<hr>
<?
if($prs!='list'){
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('AddPegawai',false,'80%');
}
?>
</div>
