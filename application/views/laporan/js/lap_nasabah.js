// JavaScript Document
 $(document).ready(function(e) {
	var prs=$('#prs').val();
	if (prs=='nol'||prs==''){
		$('#jumlahnasabah').removeClass('j_panel');
		$('#jumlahnasabah').addClass('j_panel2');
		$('#lnk').val('lap_jumlahnasabah');
		show_graph("chartdiv");
		}else{
		$('#nilaitaksir').removeClass('j_panel');
		$('#nilaitaksir').addClass('j_panel2');
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
			if(id=='nilaitaksir'){
				$.post('lap_nilaitaksir',{'thn':$('#thn').val()},
				function(result){
					var dv=result.split(',');
					show_graph(dv[1]);
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
