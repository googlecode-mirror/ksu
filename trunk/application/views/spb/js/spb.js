// JavaScript Document
/*
Author :Iswan Putera S.Kom
Created Date :20/05/2012
Function : jQuery SPB
*/
$(document).ready(function(e) {
    tglNow('#tgl_spb');
	lock('form#frm1 input#saved');
	$('table#fmrTable tr td#c25').append($('span#addlevel').contents());
	$('table#popup').attr('bgcolor','#CCC');
	$('#addlvl').click(function(){
	$('#lvladd').css({'top':'15%','left':'25%'});
	  $('#hgbarang').val('0');
	  $('#lvladd').show('slow');
	  $('div#lock').show();
	})
	$('#close').click(function(){
		$('#lvladd').hide('slow');
		$('div#lock').hide();
		$('#autosuggest_list').hide();
	});
	
	$('form#frm2 input#saved').click(function(){
		var grp=$('#nmgroup').val();
		var nmb=$('#nmbarang').val();
		var hgb=$('#hgbarang').val();
		if(grp!=''){
			if(nmb==''){ alert('Nama barang belum di tulis');}else{
				$.post('addbarang',
					  {'nmgroup':grp,'nmbarang':nmb,'hgbarang':hgb},
					  function(result){
						  $.post('jenisbarang',{'nmbarang':result},
						  function(result){
							  $('form#frm1 select#id_barang').html(result);
						  });
							  $('form#frm1 select#id_barang').val(nmb).select();
							  $('#nmbarang').val('');
							  $('#hgbarang').val('0');
							  $('#close').click();
					  });
			}
		}else{
			alert('Anda belum memilih Group')
		}
	});
	  $('form#frm2 input#nmbarang')
		.keyup(function(){
			var pos=$(this).offset();
			var hgt=$(this).height();
			$('#autosuggest_list').css({'left':pos.left,'top':pos.top+hgt+4});
			auto_suggest('auto_suggested',$(this).val(),$(this).attr('id'));
		})
		.keypress(function(e){
			$('div.autosuggest').hide();
			$(this).val($(this).val().toUpperCase());
			if(e.which==13) $('#hgbarang').focus().select();
		})
	
	$('#nama_spb')
		.keyup(function(){
			unlock('#saved');
			var pos=$(this).offset();
			var hgt=$(this).height();
			$('#autosuggest_list').css({'left':pos.left,'top':pos.top+hgt+4});
			auto_suggest('nm_suggested',$(this).val(),$(this).attr('id'));
		})
		.keypress(function(e){
			$('div.autosuggest').hide();
			$(this).val($(this).val().toUpperCase());
			if(e.which==13) $('#ktp_spb').focus().select();
		})
		
	$('#ktp_spb')
		.focus(function(){
			
		})
		.keypress(function(e){
			if(e.which==13) $(this).focusout();
		})
		.focusout(function(){
				$.post('cek_blacklist',{'ktp_spb':$(this).val()},
				function(result){
					//alert(result.length);
					if(result.length>16){
						$('#txtmsg').html(result);
						$('#info').show();
					    $('div#lock').show();
					}else{
					 $('#taksir_spb').focus().select();
					}
				});
		})
	$('#ok').click(function(){
		$('#ktp_spb').val('');
		$('#ktp_spb').focus().select();
		$('#info').hide();
		$('div#lock').hide();
	})
	
	$('#taksir_spb')
		.focus(function(){
			$(this).val(to_number($(this).val())).select();
		})
		.focusout(function(){
			var a=($(this).val());
			(a>0)? $('#nilai_spb').val((parseFloat(a)+(parseFloat(a)*10/100))):$('#nilai_spb').val('0');
			(a>0)? $(this).val(NumberFormat(a,'.','')):$(this).val('0');
			//$('#terbilang').hide();
		})
		.keyup(function(){
			var ox=$(this).offset();
			var oxs=$(this).width();
			var oxx=ox.left+oxs;
			$('#terbilang').css('left',oxx+10);
			$('#terbilang').css('top',ox.top+5);
			$('#terbilang').show();
			var a=($(this).val());
			$(this).terbilang({
				'style':"3",
				'output_div':"terbilang",
				'output_type':"text"
			})	
		})
		.keypress(function(e){
			if(e.which==13){
				$('#nilai_spb').focus().select();
			}
		})
		
	$('#nilai_spb')
		.focus(function(){
			//$(this).val(to_number($(this).val())).select();
			$('#jw_spb').val('30').select();
			$('#jt_spb').focus().select();
		})
		.focusout(function(){
			var a=($(this).val());
			(a>0)? $(this).val(NumberFormat(a,'.','')):$(this).val('0');
			//$('#terbilang').hide();
		})
	$('#jt_spb').focus(function(){
		var today=$('#tgl_spb').val();
		var durasi=$('#jw_spb').val();
		$(this).val(getNextDate(today,durasi,'/'));
	})
	$('form#frm1 input#saved').click(function(){
		$('#taksir_spb').val(to_number($('#taksir_spb').val()));
		$('#nilai_spb').val(to_number($('#nilai_spb').val()));
		unlock('input');
		if($('#ktp_spb')!=''){
		$('form#frm1').attr('action','simpan_spb');
		   document.frm1.submit();
		}else{
			alert('No. KTP tidak boleh kosong');
		}
	})
	$('#print_ulang').click(function(){
		if (confirm('Apakah printer sudah siap?')){
			$.post('print_slip',{
					'no_spb':$('#no_spb').val(),
					'tgl_spb':$('#tgl_spb').val(),
					'nama_spb':$('#nama_spb').val(),
					'ktp_spb':$('#ktp_spb').val(),
					'id_barang':$('#id_barang').val(),
					'taksir_spb':$('#taksir_spb').val(),
					'nilai_spb':$('#nilai_spb').val(),
					'jw_spb':$('#jw_spb').val(),
					'jt_spb':$('#jt_spb').val()},
					function(result){
						alert(result);
					})
		}
									
	})
	$('#reprintslip').click(function(){
		$.post('re_print');
	 })
	 
	$('#id_barang').change(function(){
		var nm=$('#nama_spb').val();
		var ktp=$("#ktp_spb").val();
		$.post('cek_ktp',{'nama_spb':nm,'ktp_spb':ktp},
			function(result){
				var obj=$.parseJSON(result);
				if (obj.nama_spb!=nm){
					alert('No KTP tersebut adalah milik\n'+obj.nama_spb+'\n Mohon di check lagi!');
					$('#ktp_spb').focus().select();
				}
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

function suggest_click(clicked,id){
	$('#'+id).val(clicked);
	setTimeout("$('#autosuggest_list').fadeOut(500);", 50);	
	if(id=='nama_spb') ktp_show(clicked);
}
function ktp_show(nm){
			$.post('ktp_nasabah',{'nama_spb':nm},
			function(result){
				//alert(result);
				$('#ktp_spb').val(result);
				$('#ktp_spb').focus().select();
			})
}