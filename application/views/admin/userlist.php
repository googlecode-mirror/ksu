<?php
(@$_GET['pos']=='add')?$dsp='':$dsp='none';
if(@$_GET['id']!=''){
	$sql="insert into user_level (nmlevel) values('".@$_GET['id']."')";
	mysql_query($sql) or die(mysql_error());
}
?>
<script language="javascript" src="<?=base_url().'application/views/admin/js/userlist.js';?>"></script>
<script language="javascript">
$(document).ready(function(e) {
   $('#levelid').html("<? dropdown('user_level','idlevel','nmlevel',"where idlevel<>'1'",@$_GET['id']);?>");
	var prs=''
	if (prs=='<?=@$_GET['pos'];?>'){
		$('#list').removeClass('j_panel');
		$('#list').addClass('j_panel2');
		}else{
		$('#add').removeClass('j_panel');
		$('#add').addClass('j_panel2');
		$('#addlvl').attr('disabled','disabled');
		$('#v_list').css('display','none');
		$('#levelid').text('<?=@$_GET['id'];?>').select();
	}
});
</script>
<div class='contents'>
<table style="border-collapse:collapse" border="0" id='panel'>
<tr height="35px" align="center">
<td width="125px" class="j_panel judul" id="add">Add User</td>
<td width="125px" class="j_panel judul" id="list">User List</td>
<td width="125px" class="j_panel judul" id="hak">Hak Akses</td>
</tr></table>
<div class="pn_content">
<hr>
<span id="v_add" style="display:<?=$dsp;?>"><br />
<? 
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/form.cfg');
$zb->BuildForm('Adduser',true,'80%');
?>
</span>
<span id='v_list' style='display:block'><br />
<?
$zb=new zetro_listBuilder('asset/bin/form.cfg');
$zb->ListHeader('Adduser','100%');
$no=0;//($page+1);
	foreach ($userlst->result_array() as $lst){
		$no++;
		echo "<tr class='xx' align='center'>
			 <td class='kotak'>$no</td>
			 <td class='kotak'>".$lst['userid']."</td>
			 <td class='kotak' align='left'>".$lst['username']."</td>
			 <td class='kotak' >".rdb("user_level","nmlevel","","where idlevel='".$lst['levelid']."'")."</td>
			 <td class='kotak' width='10%'>";
			 $zb->event($no);
			echo "<td></tr>";
			 $no++;
	}
echo "</tbody></table>\n";
?>
</span>
<table align="center" width="100%"><tr><td><? //=$paginator; ?></td></tr></table>
</div>
</div>
<span id='addlevel' style=" display:"><input type="button" id='addlvl' value='+' alt='Add user level' /></span>