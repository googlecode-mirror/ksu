<? 
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
	$z_config='asset/bin/zetro_config.dll'
?>

<div id="" style="display:; padding-top:70px;">
<table width="100%"><tr valign="bottom" align="center"><td width='100%'>
<img src='<?=base_url();?>asset/images/about2.png' />
</td><tr>
<td width='100%' align="left">
<table width="90%">
<tr><td width='100%' align="left"><div id="infoco"><b><u>License To :</u></b><p></p>
<?=$zz->rContent('InfoCo',"Name",$z_config)."<br>".
   $zz->rContent('InfoCo',"Address",$z_config).",".
   $zz->rContent('InfoCo',"Kota",$z_config)."<br>".
   $zz->rContent('InfoCo',"Telp",$z_config).",".
   $zz->rContent('InfoCo',"Fax",$z_config)."<br>";

?>
</div></td></tr>
</table>

</td></tr></table>
</div>
<?
function serial_no($namaco){
$pjg = 4;
$jml = 4;
$SN='';

$charset=strtoupper(base64_encode(md5($namaco)));
//$charset = "48C93F6H1JKLMN0PQR57UVWXY2";
for($c=0; $c<$jml; $c++)
{
$rand = '';
for ($i=0; $i<mt_rand($pjg, $pjg); $i++)
{
$rand .= $charset[(mt_rand(0,(strlen($charset)-1)))];
}
$SN .= $rand;
if($c<($jml-1)) $SN .= "-";
}
return "Serial Number: ".$SN;
}

function SN_makeUID($str, $len=4) {
	 if( !is_string($str) || (strlen($str) == 0) ) { 
	 return $str; } 
	 $ret = ''; 
	 $len = ( intval($len) >= 4 ) ? intval($len) : 4; 
	 $block = array(); 
	 for( $i=0; $i<$len; $i++ ) { $block[] = 0; } 
	 $table = '48C93F6H1JKLMN0PQR57UVWXY2'; 
	 $tblen = strlen($table); 
	 for( $i=0, $l=strlen($str); $i<$l; $i++ ) { 
		 $idx = $i % $len; $chr = ord(substr($str, $i, 1));
		 $block[$idx] = ($block[$idx] + $chr) % $tblen; 
		 unset($idx, $chr); 
	 } 
	 for( $i=0; $i<$len; $i++ ) { $ret .= substr($table, $block[$i], 1); } 
	 unset($block, $table, $tblen); return $ret; 
}
function SN_makeSerial() { 
	$ret = ''; 
	$names = array( 'LOCALHOST', 'ZETROSOFT', 'ROOT', '80', 'ZETRO', 'WWWROOT/KSU' ); 
	$code = ''; 
	reset($names); 
	foreach( $names as $name ) { 
		$code .= ( isset($_SERVER[$name]) ) ? strval($_SERVER[$name]) : ''; 
		unset($name); 
	}
		$code = SN_makeUID(md5($code), 8); 
		$ret .= chunk_split($code, 4, '-'); 
		unset($names, $code); 
		$code = SN_makeUID(substr(sprintf('%010u', time()), 0, 8), 8); 
		$ret .= chunk_split($code, 4, '-'); 
		unset($code); 
		$code = SN_makeUID(date('l d F Y O U H i s', time()), 8); 
		$ret .= chunk_split($code, 4, '-');
		 unset($code); 
		$code = SN_makeUID(md5(uniqid(rand(), true)), 8); 
		$ret .= chunk_split($code, 4, '-'); 
		unset($code);
		 $ret = substr($ret, 0, -1); 
		 return $ret;
}
?>