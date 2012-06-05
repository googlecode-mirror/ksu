// JavaScript Document
$(document).ready(function(e) {
    var prs=$('#prs').val();
	if (prs==''){
		$('#pilihbarang').removeClass('j_panel');
		$('#pilihbarang').addClass('j_panel2');
		$('table#panel tr td.plt').hide();
		$('table#panel tr td.flt').show();
		$.post('material_group',{'id':''},
		function(result){
			$('table#listdata tbody').html(result);
		})
		}else{
		$('#printlabel').removeClass('j_panel');
		$('#printlabel').addClass('j_panel2');
		$('table#panel tr td.plt').show();
		$('table#panel tr td.flt').hide();
	}
	$('table#panel tr td:not(.flt,.plt)').click(function(){
	  var id=$(this).attr('id');
	  var tt=$('span#ttl').html();
			$('#'+id).removeClass('j_panel');
			$('#'+id).addClass('j_panel2');
			$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('j_panel2');
			$('table#panel tr td:not(#'+id+',.flt,.plt)').addClass('j_panel');
			$('span#v_'+id).show();
			$('span:not(#ttl,#v_'+id+')').hide();
			if(id=='printlabel'){
				$('table#panel tr td:nth-child(4)').hide();
				$('table#panel tr td:nth-child(5)').hide();
				$('table#panel tr td.plt').show();
				$.post('labellelang',{'id':id},
				function(result){
					$('table#listlabel tbody').html(result);
				})
			}else if(id=='pilihbarang'){
				$('table#panel tr td:nth-child(4)').show();
				$('table#panel tr td:nth-child(5)').show();
				$('table#panel tr td.plt').hide();
				$.post('material_group',{'id':''},
				function(result){
					$('table#listdata tbody').html(result);
				})
			}
	})
	$('#print').click(function(){
		$('span#v_printlabel').print();
		$.post('hps_label_siap_print',{'no_spb':'','stat':'P'},
			function(result){
			$('table#listlabel tbody').html(result);
			});
	})

})
function cek4label(id){
	$.post('label_siap_print',{'no_spb':id,'stat':'Y'},
	function(result){
		$.post('material_group',{'id':''},
		function(result){
			//alert(result);
			$('table#listdata tbody').html(result);
		})
	});
}




	