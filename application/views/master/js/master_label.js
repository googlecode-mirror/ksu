// JavaScript Document
$(document).ready(function(e) {
    var prs=$('#prs').val();
	$('#re_prn')
		.removeAttr('checked')
		.css('cursor','pointer');
	
	if (prs==''){
		$('#pilihbarang').removeClass('j_panel');
		$('#pilihbarang').addClass('j_panel2');
		$('table#panel tr td.plt').hide();
		$('table#panel tr td.flt').show();
		$('table#panel tr td:nth-child(6)').hide();
		$('table#panel tr td:nth-child(7)').hide();
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
				$('table#panel tr td:nth-child(6)').hide();
				$('table#panel tr td:nth-child(7)').hide();
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
				$('#re_prn').click();
				$('table#listdata tbody').show();
				$('table#panel tr td:nth-child(6)').hide();
				$('table#panel tr td:nth-child(7)').hide();
			}
	})
	/*$('#print').click(function(){
		$('span#v_printlabel').print();
		$.post('hps_label_siap_print',{'no_spb':'','stat':'P'},
			function(result){
			$('table#listlabel tbody').html(result);
			});
	})*/
	$('#re_prn').click(function(){
		if($(this).is(':checked')){
				$('table#panel tr td:nth-child(6)').show();
				$('table#panel tr td:nth-child(7)').show();
				$('#spb_label').val('').focus().select();
				$('table#listdata tbody').hide();
		}else{
				$('table#panel tr td:nth-child(6)').hide();
				$('table#panel tr td:nth-child(7)').hide();
				$('#spb_label').val('');
				$.post('material_group',{'id':''},
				function(result){
					$('table#listdata tbody').html(result);
				})
				$('table#listdata tbody').show();
		}
	})
	$('#spb_label').keyup(function(){
			var pos=$(this).offset();
			var hgt=$(this).height();
			$('#autosuggest_list').css({'left':pos.left,'top':pos.top+hgt+4});
			auto_suggest('re_print_label',$(this).val(),$(this).attr('id'));
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
function cek42label(id){
	$.post('label_siap_print',{'no_spb':id,'stat':'Y'},
	function(result){
		$.post('re_print_data',{'str':$('#spb_label').val()},
		function(result){
			//alert(result);
			$('table#listdata tbody').html(result);
		})
	});
}

function auto_suggest(linked,str,id){
	//alert(str);
	if (str.length == 0) {
		$('#autosuggest_list').fadeOut(100);
	} else {
		$('#'+id).addClass('loading');
		$.post(linked,
			  {'str':str},
			  function(result){
				  if(result){
					$('#autosuggest_list').html(result);
					$('#autosuggest_list').fadeIn(100);
					$('#'+id).removeClass('loading');	  
				  }else{
					  $('div.autosuggest').hide();
					  $('#'+id).removeClass('loading');	  
				  }
			  })
	}
	
}

function suggest_click(str){
	$('#spb_label').val(str);
	setTimeout("$('#autosuggest_list').fadeOut(500);", 50);	
	$.post('re_print_data',{'str':str},
	function(result){
		$('table#listdata tbody').html(result);
	})
	$('table#listdata tbody').show();
}



	