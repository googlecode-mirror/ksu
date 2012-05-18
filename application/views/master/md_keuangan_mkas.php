<script language="javascript">
	$(document).ready(function(e) {
        lock('select:not(#iddo)');
		lock('#noengine,#nochasis');
    });
</script>
<? $prs=@$_GET['prs'];
?>
<div class='contents'>
<div class="j_panel judul">Set Jenis Kas</div>
<div class="pn_content">
<hr>
<?
if($prs!='list'){
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('KasAwal',true,'80%');
}
//echo "</form>";
?>
</div>
