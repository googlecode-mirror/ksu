
<script language="javascript">
/*	$(document).ready(function(e) {
        $('input:first').focus().select();
		$('#levelid').html("<? dropdown('user_level','idlevel','nmlevel');?>");
    });*/
</script>
<div class='contents'>
<div class="j_panel judul">Add New User</div>
<div class="pn_content">
<hr>
<? /*
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/form.cfg');
$zb->BuildForm('Adduser',true,'80%');*/
hapus_table('user_level',"where idlevel='".@$_GET['id']."'");

?>
</div>
</div>