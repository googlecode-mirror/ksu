// JavaScript Document
 $(document).ready(function(e) {
	var prs=$('#prs').val();
	if (prs=='nol'||prs==''){
		$('#jumlahbarang').removeClass('j_panel');
		$('#jumlahbarang').addClass('j_panel2');
		$('#lnk').val('lap_jumlahbarang');
		show_graph("chartdiv");
		}else{
		$('#nilaibarang').removeClass('j_panel');
		$('#nilaibarang').addClass('j_panel2');
		$('#lnk').val('lap_nilaibarang');
		show_graph("chartdiv2");
	}
	$('table#panel tr td:not(.flt,.plt)').click(function(){
	  var id=$(this).attr('id');
			$('#'+id).removeClass('j_panel');
			$('#'+id).addClass('j_panel2');
			$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('j_panel2');
			$('table#panel tr td:not(#'+id+',.flt,.plt)').addClass('j_panel');
			$('span#v_'+id).show();
			$('#lnk').val('lap_'+id);
			$('span:not(#ttl,#v_'+id+')').hide();
			if(id=='nilaibarang'){
				$.post('lap_nilaibarang',{'thn':$('#thn').val()},
				function(result){
					var dv=result.split(',');
					show_graph('chartdiv2');
					$('#thn').val(dv[2]).select();
				})
			}else if(id=='jumlahbarang'){
				$.post('lap_jumlahbarang',{'thn':$('#thn').val()},
				function(result){
					var dv=result.split(',');
					show_graph('chartdiv');
					$('#thn').val(dv[2]).select();
				})
			}
	});
	$('#thn').change(function(){
	 var th=$(this).val();
	 var prs=$('#prs').val();
	 var lnk=$('#lnk').val();
	 $.post(lnk,{'thn':th},function(result){
		 var dv=result.split(',');
		 $('#prs').val(dv[0]);
		 $('#thn').val(dv[2]).select();
		 show_graph(dv[1]);})
	})
});
