<? 
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
	$z_config='asset/bin/zetro_config.dll'
?>

<div id="" style="display:none">
<table width="100%" height="98%"><tr valign="top"><td width='55%'>
<table width="100%">
<tr><td height="100px" >&nbsp;</td></tr>
<?
	$jml=$zz->Count('Menu',$file);
		for ($i=1;$i<=$jml;$i++){
		$rst=explode('|',$zz->rContent('Menu',$i,$file));
?>
<tr >
<td height="70px" valign="middle" width="50px"></td>
</tr>
<? } ?>
</table>
</td>
<td width='45%'>
<table width="90%"><tr><td height="100px">&nbsp;</td></tr>
<tr><td width='100%' align="left"><div id="infoco"><b><u>Company Profile</u></b><br /><br />
<?=$zz->rContent('InfoCo',"Name",$z_config)."<br>".
   $zz->rContent('InfoCo',"Address",$z_config)."<br>".
   $zz->rContent('InfoCo',"Kota",$z_config)."<br>".
   $zz->rContent('InfoCo',"Telp",$z_config)."<br>".
   $zz->rContent('InfoCo',"Fax",$z_config)."<br>";

?>
</div></td></tr>
</table>

</td></tr></table>
</div>