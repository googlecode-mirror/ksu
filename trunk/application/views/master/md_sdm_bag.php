<script language="javascript">
	$(document).ready(function(e) {
		$('input:first').focus().select();		
	});
</script>
<? $prs=@$_GET['prs'];
?>
<div class='contents'>
<div class="j_panel judul" style="width:20%">List Karyawan</div>
<div class="pn_content">
<hr>
<?
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('Jab',true,'60%');
echo "<hr/>";

			$zb2=new zetro_listBuilder('asset/bin/zetro_form.cfg');
			$zb2->ListHeader('Jab','50%');
?>
</div>
</div>
