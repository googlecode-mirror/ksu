<div class='contents'>
<div class="j_panel judul" style="width:20%">List DO</div>
<div class="pn_content">
<hr>
<?
			$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
			$zb->ListHeader('Invoice','100%');
			$no=1;
			foreach($invoice->result_array() as $lst){
					echo "<tr class='xx' align='center' id='".$lst['iddo']."'>\n
						 <td class='kotak'>$no</td>\n
						 <td class='kotak'>".$lst['iddo']."</td>\n
						 <td class='kotak' align='left'>".rdb("customer","nmcus","nmcus","where idcus='".
						 	rdb("transaksi","idcus","idcus","where iddo='".$lst['iddo']."'")."'")."</td>\n
						 <td class='kotak' align='left'>".rdb("client","nmclient","nmclient","where idclient='".
						 	rdb("transaksi","idclient","idclient","where iddo='".$lst['iddo']."'")."'")."</td>\n
						 <td class='kotak' align='center'>".tglfromSql($lst['tgldo'])."</td>\n
						 <td class='kotak' align='center'>".tglfromSql($lst["doc_date"])."</td>\n
						 <td class='kotak' align='left'>".$lst['statusdo']."</td>\n
						 <td class='kotak'>";
						 /*if($oto['e']=='Y'){$zb->event($lst['iddo'],'','process');//}*/
						echo "<td></tr>";
						 $no++;
		}
	echo"</table>";//<table align='center' width='100%'><tr><td>$paginator</td></tr></table>";
?>
</div>
</div>
