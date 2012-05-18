<div class='contents'>
<div class="j_panel judul">Ganti Password</div>
<div class="pn_content">
<hr>
<?
$zb=new zetro_frmBuilder('asset/bin/form.cfg');
$zb->BuildForm('Ganti Password',true,'80%');
?>
<input type="hidden" id='user_id' value='<?=$user_id;?>' />
</div>
</div>