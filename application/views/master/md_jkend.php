<script language="javascript">
	$(document).ready(function(e) {
        lock('select:not(#iddo)');
		lock('#noengine,#nochasis');
    });
</script>
<? $prs=@$_GET['prs'];
?>
<div class='contents'>
<div class="j_panel judul">Set Jenis Kas</div>
<div class="pn_content">
<hr>
<?

echo "<form id='frm1' name='frm1' action='' method='post'>";
$zb=new zetro_frmBuilder('asset/bin/zetro_form.cfg');
$zb->BuildForm('Kendaraan',true,'80%');
echo "<br/><hr/>";

			$zb2=new zetro_listBuilder('asset/bin/zetro_form.cfg');
			$zb2->ListHeader('Kendaraan','50%');
			$zn= new zetro_manager();
			$file='asset/bin/zetro_form.cfg';
			for ($i=1;$i<=$zn->Count("TipeKendaraan",$file);$i++){
				$data=explode(",",$zn->rContent("TipeKendaraan",$i,$file));
				echo "<tr align='center' class='xx'><td class='kotak'>$i</td>
					 <td class='kotak' align='left'>".$data[1]."</td>
					 <td class='kotak'>";
					 $zb2->event(true);
					 echo "</td></tr>\n\r";
			}
			
?>
</div>
