<script language="javascript" src="<?=base_url().'application/views/admin/js/change_pwd.js';?>"></script>
<div class='contents'>
<div class="j_panel judul">Change Pwd</div>
<div class="pn_content">
<hr>
<?
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/form.cfg');
$zb->BuildForm('Ganti Password',true,'80%');
echo "<input type='hidden' id='userid' value='".$user_id."' />";
echo "</form>";
?>
</div>
</div>