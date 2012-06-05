<?php
empty($ttl)?$ttl0=0:$ttl0=$ttl;
$img="<img src='".base_url()."asset/images/printer.png' id='print' title='Print Label' class='xx'>";
link_js('zetro_number.js,daftar_lelang.js','asset/js,application/views/lelang/js');
panel_begin('Daftar Lelang, Label Barang','','<b><u>Daftar barang akan dilelang sampai hari ini :&nbsp;</u></b>,<b>'.date('l - d F Y').'</b>,&nbsp;|&nbsp,<b>Total Barang Siap Lelang : </b>&nbsp;,<span id=\'ttl\'>'.$ttl0.'</span>&nbsp;Item(s)',$img);
$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
panel_multi('daftarlelang',true);
panel_multi('labelbarang');
?>
<table border='0' id='listlabel' style='border-collapse:collapse' align="center">
<tbody>
</tbody>
</table>
<?
panel_multi_end();
panel_end();
?>