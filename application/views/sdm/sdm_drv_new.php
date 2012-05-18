<script language="javascript" src="<?=base_url();?>application/views/sdm/js/sdm_drv_new.js" type="text/javascript"></script>
<? $prs=@$_GET['prs'];
?>
<div class='contents'>
<div class="j_panel judul" style="width:20%">Add New Karyawan</div>
<div class="pn_content">
<hr>
<?
if($prs!='list'){
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('AddPegawai',true,'80%');
}
?>
</div>
