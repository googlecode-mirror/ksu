// JavaScript Document
/*
Author :Iswan Putera S.Kom
Created Date :22/05/2012
Function : jQuery List SPB
*/
$(document).ready(function(e) {
    lock('#nama_spb,#ktp_spb,#tgl_spb')
	$('#no_spb').focus().select();
	$('#no_spb')
		.keyup(function(){
			unlock('#saved');
			var pos=$(this).offset();
			var hgt=$(this).height();
			var wdh=$(this).width();
			$('#autosuggest_list').css({'left':pos.left+5,'top':pos.top+hgt+2,'width':wdh});
			auto_suggest('nospb_suggested',$(this).val(),$(this).attr('id'));
		})
		.keypress(function(){
			var id=$(this).val();
			data_show(id);
			$('#ktp_spb').focus().select();
		})
		
		$('#close').click(function(){
			$('#lvladd').hide('slow');
			$('div#lock').hide();
			$('#autosuggest_list').hide();
		});
		
		$('#tindakan').change(function(){
			var id=$(this).val();
			var bunga=$('#bungane').val();
			if(id=='Y'){
				$('tr#hrg').show();
				$('#bayar').val(bunga);
				$('#bayar').focus().select();
			}else{
				$('tr#hrg').hide();
			}
		});
		$('#bayar').keyup(function(){
			var a=($(this).val());
			$(this).terbilang({
				'style':"3",
				'output_div':"terbilang",
				'output_type':"text"
			})	
		})
		$('input#simpan').click(function(){
			$.post('pp_update',
					{'no_spb':$('#nospb').val(),
					'pp_ke':$('#ppke').val(),
					'pp_stat':$('#tindakan').val(),
					'pp_bayar':$('#bayar').val()},
					function(result){
					//alert(result);
						show_list($('#nospb').val());
						$('#close').click();
					})
			})
		
});

function auto_suggest(linked,str,id){
	//alert(str);
	if (str.length == 0) {
		$('#autosuggest_list').fadeOut(100);
	} else {
		$('#'+id).addClass('loading');
		$.post(linked,
			  {'str':str},
			  function(result){
				  //alert(result);
				  if(result!='<ul>'){
					$('#autosuggest_list').html(result);
					$('#autosuggest_list').fadeIn(100);
					$('#'+id).removeClass('loading');	  
				  }else{
					  $('#autosuggest_list').hide();
					  $('#'+id).removeClass('loading');	  
				  }
			  })
	}
	
}

function suggest_click(clicked,id){
	$('#'+id).val(clicked);
	setTimeout("$('#autosuggest_list').fadeOut(500);", 50);	
	 data_show(clicked);
	 show_list(clicked);
}


function data_show(id){
	  $.post('spb_edit',{'no_spb':id},
	  function(result){
		  var obj=$.parseJSON(result);
		  $('#tgl_spb').val(obj.tgl_spb);
		  $('#nama_spb').val(obj.nama_spb);
		  $('#ktp_spb').val(obj.ktp_spb);
	  })
}
function show_list(id){
		  	$.post('list_perpanjang',{'no_spb':id},
		  	function(result){
				$('table#listTable tbody').html(result);
			});
	
}

function aksi_click(no_spb,pp_ke,bunga){
	$('#nospb').val(no_spb);
	$('#ppke').val(pp_ke);
	$('#bungane').val(bunga);
	  $('#tindakan').val('').select();
	  $('#bayar').val('0');
	  $('#lvladd').css({'top':'40%','left':'30%','background-color':'#CCC'});
	  $('#lvladd').show('slow');
	  $('div#lock').show();
}

function reset_upd(no_spb,pp_ke,stat){
	$.post('reset_aksi',{
			'no_spb':no_spb,
			'pp_ke':pp_ke,
			'pp_stat':stat},
			function(result){
				//alert(result);
				show_list(no_spb);
			})
}