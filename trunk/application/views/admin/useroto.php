<div class='contents'>
<div class="j_panel judul">Create SPB</div>
<div class="pn_content">
<hr>
<? 
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('Spb',true,'80%');
/*$no=0;//($page+1);
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
*/
?>
<table align="center" width="100%"><tr><td><? //=$paginator; ?></td></tr></table>
</div>
</div>