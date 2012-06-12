// JavaScript Document
/*
Author :Iswan Putera S.Kom
Created Date :22/05/2012
Function : jQuery List SPB
*/
$(document).ready(function(e) {
	$('img.del').hide();
    $('img').click(function(){
	  var id=$(this).attr('id');
	  var tp=$(this).attr('class');
	  if(tp=='edit'){
	  $('#lvladd').css({'top':'15%','left':'25%','background-color':'#CCC'});
	  $('#no_spb').val(id);
	  $.post('spb_edit',{'no_spb':id},
	  function(result){
		  var obj=$.parseJSON(result);
		  $('#tgl_spb').val(obj.tgl_spb);
		  $('#nama_spb').val(obj.nama_spb);
		  $('#ktp_spb').val(obj.ktp_spb);
		  $('#id_barang').val(obj.id_barang).select();
		  $('#taksir_spb').val(obj.taksir_spb);
		  $('#nilai_spb').val(obj.nilai_spb);
		  $('#jw_spb').val(obj.jw_spb).select();
		  $('#jt_spb').val(obj.jt_spb);
	  });
	  $('#lvladd').show('slow');
	  $('div#lock').show();
	  }
	})
	$('#close').click(function(){
		$('#lvladd').hide('slow');
		$('div#lock').hide();
		$('#autosuggest_list').hide();
	});
	$('#nama_spb')
		.keypress(function(e){
			$(this).val($(this).val().toUpperCase());
			if(e.which==13) $('#ktp_spb').focus().select();
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
				$('#saved').focus();
			}
		})
	$('#saved')
		.focus(function(){
			$('#nilai_spb').val(NumberFormat($('#nilai_spb').val(),'.',''));
		})
		.click(function(){
			unlock('#no_spb,#id_barang,#jw_spb,#jt_spb');
			$('#taksir_spb').val(to_number($('#taksir_spb').val()));
			$('#nilai_spb').val(to_number($('#nilai_spb').val()));
			$('form#frm2').attr('action','spb_edit_simpan');
			document.frm2.submit();
		});
	$('#batal').click(function(){$('#close').click()});
	$('#bulan').change(function(){
			$('form#frm1').attr('action','daftar');
			document.frm1.submit();
	})
	$('#thn').change(function(){
			$('form#frm1').attr('action','daftar');
			document.frm1.submit();
	})
});