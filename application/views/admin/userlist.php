<?php
(empty($levelid))?$dsp='none':$dsp='';
(empty($levelid))?$lvlid='':$lvlid=$levelid;
(empty($userid))?$uid='':$uid=$uderid;
(empty($username))?$unm='':$unm=$username;
(empty($le))?$o_edit='N':$o_edit=$le;
$user_aktiv=$this->session->userdata("userid");
($hv=='Y' && $hc=='Y' || $user_aktiv=='Superuser')?
	$stat='':$stat='disabled';
?>
<script language="javascript" src="<?=base_url().'application/views/admin/js/userlist.js';?>"></script>
<script language="javascript">
$(document).ready(function(e) {
   $('#levelid').html("<? dropdown('user_level','idlevel','nmlevel',"where idlevel<>'1' order by nmlevel",$lvlid);?>");
   $('#oto_usernm').html("<? dropdown('users','userid','username',"where levelid<>'1' order by username",$this->session->userdata('userid'));?>");
	$('#userid').val('<?=$uid;?>');
	$('#username').val('<?=$unm;?>');
});
	function isi_oto(){
   		$('#oto_usernm').html("<? dropdown('users','userid','username',"where levelid<>'1' order by username",$this->session->userdata('userid'));?>");
	}
</script>
<div id='lock' class='black_overlay'></div>
<div class='contents'>
<table style="border-collapse:collapse" border="0" id='panel'>
<tr height="35px" align="center">
<td width="125px" class="j_panel " id="add">Add User</td>
<td width="125px" class="j_panel " id="list">User List</td>
<td width="125px" class="j_panel " id="hak">Hak Akses</td>
</tr></table>
<div class="pn_content">
<hr>
<span id="v_add" style="display:<?=$dsp;?>"><br />
<? 
if($ac=='Y' || $ae=='Y' || $user_aktiv=='Superuser'){
echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/form.cfg');
$zb->BuildForm('Adduser',true,'70%');
}else{
 no_auth();
}
?>
</span>
<span id='v_list' style='display:block'><br />
<?
if($le=='Y' || $lv=='Y' || $user_aktiv=='Superuser'){
$zb=new zetro_listBuilder('asset/bin/form.cfg');
$zb->ListHeader('Adduser','70%','listTable');
$no=0;//($page+1);
	foreach ($userlst->result_array() as $lst){
		 $no++;
		echo "<tbody><tr class='xx' align='center' id='n-".$lst['userid']."'>
			 <td class='kotak'>$no</td>
			 <td class='kotak'>".$lst['userid']."</td>
			 <td class='kotak' align='left'>".$lst['username']."</td>
			 <td class='kotak' id='l-".$lst['levelid']."' >".rdb("user_level","nmlevel","","where idlevel='".$lst['levelid']."'")."</td>
			 <td class='kotak' width='10%'>";
			 echo ($le=='Y' || $user_aktiv=='Superuser' )? $zb->event($lst['userid']):'&nbsp;';
			 echo "</td></tr>";
	}
echo "</tbody></table>\n";
}else{
	no_auth();
}
?>
</span>
<span id='v_hak' style='display:none'>
<?
//echo "<form id='frm3' name='frm3' action='' method='post'>\n<br>";
echo str_repeat('&nbsp;',5)."<font color='#000000'><strong>User Name : </strong></font>
<select id='oto_usernm' name='oto_usernm' $stat></select>\n <hr>";
$zb=new zetro_listBuilder('asset/bin/form.cfg');
$zb->ListHeader('UserOto','80%','listHak','nolist');
echo "<tbody></tbody></table>\n";
//echo "</form>";
?>
</span>

<table align="center" width="100%"><tr><td><? //=$paginator; ?></td></tr></table>
<? panel_end();?>
<span id='addlevel' style=" display:"><input type="button" id='addlvl' value='+' alt='Add user level' /></span>
<input type="hidden" id='prs' value='<?= empty($prs)?'':$prs;?>' />

<div id='lvladd'  style='display:none; border:5px solid #333; padding:0px; left:0; top:0; width:280px; max-height:300px; position:fixed; overflow:auto; z-index:9999'>
<table id='lvltbl0' width="100%" style='border-collapse:collapse'>
<tr><td colspan='2' bgcolor="#333" class=''>
<font style='font-size:large; color:#FFFFFF'>User Group</font></td>
<td bgcolor="#333" class='xy' align="center" id='close' width="10px"><font color="#FFFFFF"><b>X</b></font></td></tr>
</table>
<form id='frm2' name='frm2' action='' method='post'>
<table id='lvltbl' style='border-collapse:collapse' align="center">
<thead>
<tr class='header' align="center">
<td class='kotak' width='60px'>No.</td>
<td class='kotak ' width='180px'>Group Name</td><td width='10px' class='kotak'>&nbsp;</td></tr>
</thead>
<tbody>
</tbody>
<tfoot>
<tr bgcolor="#FFFFCC"><td class='kotak'  bgcolor="#FFFFCC"><b>Add Group</b></td>
<td class='kotak' bgcolor="#FFFFCC" ><input type='text' class='w90' id='nmlevel' name='nmlevel'/></td>
<td class='kotak' bgcolor="#FFFFCC"><input type='button' value='+' id='tambah' class='xx' disabled="disabled"/></td>
</tr>
</tfoot></table>
</form>
</div>

