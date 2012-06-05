<? 
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
	$z_config='asset/bin/zetro_config.dll'
?>

<div id="" style="display:block; padding-top:70px;">
<table width="100%"><tr valign="bottom" align="center"><td width='100%'>
<img src='<?=base_url();?>asset/images/about2.png' /></td></tr>
<tr><td align='center'><a style='color:#00F;' href='http://zetrosoft.com'>www.zetrosoft.com</a> | Contact : HP: 081213290809 , email :contact@zetrosoft.com |</td>
<td width='100%' align="left" style="display:none">
<table width="90%"><tr><td>&nbsp;</td></tr>
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