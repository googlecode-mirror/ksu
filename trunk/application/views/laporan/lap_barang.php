<?php
empty($thn)?$thn=date('Y'):$thn=$thn;
empty($prs)?$prs='nol':$prs=$prs;
$img="<img src='".base_url()."asset/images/printer.png' id='print' title='Print Grafix' class='xx'>";
link_js('FusionCharts.js','asset/js');
link_js('zetro_number.js,lap_barang.js','asset/js,application/views/laporan/js');
$tahun="<select id='thn' name='thn'></select>";
panel_begin('Jumlah Barang,Nilai Barang','','Grafik Tahun : ,'.$tahun);
$zb=new zetro_listBuilder('asset/bin/zetro_form.cfg');
panel_multi('jumlahbarang',true);
?>
<div id='chartdiv'></div>

<?
panel_multi_end();
panel_multi('nilaibarang');
?>
<div id='chartdiv2'></div>
<?
panel_multi_end();
panel_end();

?><input type='text' value='<?=$prs;?>' id='prs' /><input type='text' value='' id='lnk' />
<script language='javascript'>
$(document).ready(function(e) {
    $('#thn').html("<? dropdown("spb","distinct(year(tgl_spb)) as thn",'','',$thn);?>");
});
function show_graph(id){
		   var chart = new FusionCharts("<?=base_url();?>chart/FCF_Column2D.swf", "ChartId", "600", "350");
		   chart.setDataURL("<?=base_url().$this->session->userdata('userid');?>_graph.xml");		
		  	 chart.render(id);
}
</script>
