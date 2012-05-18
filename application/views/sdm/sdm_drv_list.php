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
			$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
			$zb->ListHeader('AddPegawai','100%');
?>
</div>
</div>
