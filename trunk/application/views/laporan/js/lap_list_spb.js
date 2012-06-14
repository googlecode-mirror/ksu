// JavaScript Document
/*
Author :Iswan Putera S.Kom
Created Date :22/05/2012
Function : jQuery List SPB
*/
$(document).ready(function(e) {
	lock('#no_spb,#id_barang,#jw_spb,#jt_spb');
    var prs=$('#prs').val();
	if (prs==''){
		$('#daftarspb').removeClass('j_panel');
		$('#daftarspb').addClass('j_panel2');
		$('#yngaktif').val('daftarspb');
		}else{
		$('#add').removeClass('j_panel');
		$('#add').addClass('j_panel2');
		$('#yngaktif').val('perpanjangspb');
		$('#v_list').css('display','none');
	}

	$('table#panel tr td:not(.flt,.plt)').click(function(){
	  var id=$(this).attr('id');
			$('#'+id).removeClass('j_panel');
			$('#'+id).addClass('j_panel2');
			$('table#panel tr td:not(#'+id+')').removeClass('j_panel2');
			$('table#panel tr td:not(#'+id+',.flt,.plt)').addClass('j_panel');
			$('span#v_'+id).show();
			$('span:not(#v_'+id+')').hide();
			if(id=='perpanjangspb'){
				$('table#panel tr td.flt').hide();
				$.post('lap_perpanjang',
					{'no_spb':id},
					function(result){
						$('table#listdata tbody').html(result);
					});
			$('#yngaktif').val('perpanjangspb');
			}else if(id=='daftarspb'){
				$('table#panel tr td.flt').show();
			$('#yngaktif').val('daftarspb');
			}
	});
	
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
			$('form#frm1').attr('action','lap_daftar');
			document.frm1.submit();
	})
	$('#thn').change(function(){
			$('form#frm1').attr('action','lap_daftar');
			document.frm1.submit();
	})
	$('#printing').click(function(){
		var id=$('#yngaktif').val();
		var nm;
		(id=='daftarspb')?nm='listTable':nm='listdata';
		$('table#'+nm).attr('border','1');
		$('#v_'+id).print();
	})
});