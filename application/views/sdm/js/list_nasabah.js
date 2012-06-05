// JavaScript Document
$(document).ready(function(e) {
    var prs=$('#prs').val();
	if (prs==''){
		$('#listnasabah').removeClass('j_panel');
		$('#listnasabah').addClass('j_panel2');
	}else if(prs=='bcl'){
		$('#blacklist').removeClass('j_panel');
		$('#blacklist').addClass('j_panel2');
	}

	//$('img.del').hide();
    $('img').click(function(){
	  var id=$(this).attr('id');
	  var tp=$(this).attr('class');
	  if(tp=='edit'){
	  lock('#nama_spb,#ktp_spb');
	  $('#lvladd').css({'top':'15%','left':'25%','background-color':'#CCC'});
	  $('#ktp_spb').val(id);
	  $.post('edit_client',{'ktp_spb':id},
	  function(result){
		  //alert(result);
		  var obj=$.parseJSON(result);
		  $('#nama_spb').val(obj.nama_spb);
		 // $('#ktp_spb').val(obj.ktp_spb);
		  $('#almnasabah').val(obj.almnasabah);
		  $('#almnasabah').focus().select();
	  });
	  $('#lvladd').show('slow');
	  $('div#lock').show();
	  }
	  if(tp=='del' && prs==''){
		 $.post('add_blacklist',{'ktp_spb':id},
		 function(result){
			 //alert(result);
			$('table#listTable tr:#'+id+' td:last-child').html(result); 
		 })
	  }
	  if(tp=='del' && prs=='bcl'){
		if(confirm('Yakin akan di keluarkan dari daftar?')){
			$.post('del_blacklist',{'ktp_spb':id},
			function(result){
				$('table#listTable tr:#'+id).remove();
			})
		}
	  }
	})
	
	$('#close').click(function(){
		$('#lvladd').hide('slow');
		$('div#lock').hide();
		$('#autosuggest_list').hide();
	});
	
	$('#saved').click(function(){
		unlock('#nama_spb,#ktp_spb');
			$('form#frm2').attr('action','edit_simpan');
			document.frm2.submit();
	})
});
