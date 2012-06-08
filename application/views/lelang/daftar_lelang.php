<?php
empty($ttl)?$ttl0=0:$ttl0=$ttl;
$img="<img src='".base_url()."asset/images/printer.png' id='print' title='Print Label' class='xx'>";
link_js('zetro_number.js,daftar_lelang.js','asset/js,application/views/lelang/js');
panel_begin('Daftar Lelang','','<b><u>Daftar barang akan dilelang sampai hari ini :&nbsp;</u></b>,<b>'.date('l - d F Y').'</b>,&nbsp;|&nbsp,<b>Total Barang Siap Lelang : </b>&nbsp;,<span id=\'ttl\'>'.$ttl0.'</span>&nbsp;Item(s)',$img);
$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
panel_multi('daftarlelang',true);
?>
<table id='listdata' style='border-collapse:collapse'>
<thead>
<tr class='header'>
<th class='kotak' rowspan='2' width='20%'>URAIAN</th>
<th class='kotak' colspan='2' width='12%'>PENJUALAN</th>
<th class='kotak' rowspan='2' width='10%'>NAMA NASABAH</th>
<th class='kotak' rowspan='2' width='10%'>TAKSIR</th>
<th class='kotak' rowspan='2' width='10%'>NILAI TAKSIR</th>
<th class='kotak' rowspan='2' width='8%'>PERPAN JANGAN</th>
<th class='kotak' rowspan='2' width='12%'>JATUH TEMPO</th>
<th class='kotak' rowspan='2' width='8%'>LELANG</th>
</tr>
<tr class='header' align='center'>
<th class='kotak' width='6%'>NO.SPB</th>
<th class='kotak' width='6%'>TGL</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<?
panel_multi_end();
panel_end()?>
<input type='hidden' id='prs' value='' />

<div id='print_lelang' style="padding:5; display:none; width:60%">
<table id='listdata_le' width='98%' border='1' style='border-collapse:collapse'>
<thead>
<tr class='header'>
<tr class='header' align='center'>
<th class='kotak' width='5%'>NO</th>
<th class='kotak' width='60%'>NAMA BARANG</th>
<th class='kotak' width='35%'>NO. SPB</th>
</tr>
</thead>
<tbody>
</tbody>
</table>

</div>


