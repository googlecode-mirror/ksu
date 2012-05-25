// JavaScript Document
 $(document).ready(function(e) {
    $('input:first').focus().select();
	$('table#fmrTable tr td#c23').append($('span#addlevel').contents());
    var prs=$('#prs').val();
	if (prs==''){
		$('#list').removeClass('j_panel');
		$('#list').addClass('j_panel2');
		}else{
		$('#add').removeClass('j_panel');
		$('#add').addClass('j_panel2');
		//$('#addlvl').attr('disabled','disabled');
		$('#v_list').css('display','none');
	}

	$('table#panel tr td').click(function(){
	  var id=$(this).attr('id');
			$('#'+id).removeClass('j_panel');
			$('#'+id).addClass('j_panel2');
			$('table#panel tr td:not(#'+id+')').removeClass('j_panel2');
			$('table#panel tr td:not(#'+id+')').addClass('j_panel');
			$('span#v_'+id).show();
			$('span:not(#v_'+id+')').hide();
			if(id=='add'){
				($('#saved').val()=='Submit')?$('#userid').removeAttr('readonly'):'';
			}
			if(id=='list'){
				$('input:not(:button,:submit,:reset)').val('');
				($('#saved').val()=='Submit')?$('#userid').removeAttr('readonly'):'';
				$('#password').removeAttr('disabled');
			}
			if(id=='hak'){
			$('#oto_usernm').change();
			}
			
	})
	$('#addlvl').click(function(){
	  var pos=$(this).offset();
	  var w=$(this).width();
	  $('#lvladd').css('left',pos.left+25+w);
	  $('#lvladd').css('top',pos.top+25);
	  $('#nmlevel').val('');
	  $.post('showlevel',{'idlevel':1},
	  function(result){
				$('table#lvltbl tbody tr').remove(this);
				$('table#lvltbl tbody').append(result);	
	  })
	  $('#lvladd').show('slow');
	  $('div#lock').show();

	});
	$('#saved').click(function(){
		var tp=$(this).val();
		(tp=='Submit')?
		$('#frm1').attr('action','addusersimpan'):
		$('#frm1').attr('action','adduserupdate');
		document.frm1.submit();
	})
	$('#batal').click(function(){
		$('#userid').removeAttr('readonly');
		$('#password').removeAttr('disabled');
		$('input:first').focus().select();
	})
	$('img').click(function(){
		var id=$(this).attr('id');
		var tp=$(this).attr('class');
		switch(tp){
			case 'edit':
			$('#userid')
				.val(id)
				.attr('readonly','readonly')
			$('#username')
				.val(isi_tabel(id,'3'))
				.focus().select();
			var lvid=$('table#listTable tr#n-'+id+' td:nth-child(4)').attr('id').split('-');
			$('#levelid').val(lvid[1]).select();
			$('#saved').val('Update');
			$('#password').attr('disabled','disabled');
			$('table#panel tr td#add').click();
			break;
			case 'del':
			if(confirm("Data ini akan di hapus?")){
			$.post('delete_user',
				{'userid':id},
				function(result){
					$('table#listTable tr#n-'+result).remove();
				});
			}
			break;	
		}
	})
	$('#close').click(function(){
		$('#lvladd').hide('slow');
		$('div#lock').hide();
	})
	$('#tambah').click(function(){
		var nmlevel=$('#nmlevel').val();
		$.post('userlevel',
			{'nmlevel':nmlevel},
			function(result){
				$('table#lvltbl tbody').html('');
				$('table#lvltbl tbody').html(result);
				$('#nmlevel').val('');	
			})
	});
	$('#nmlevel').keyup(function(){
		$('#tambah').removeAttr('disabled');
	});
	$('div#lvladd').mouseenter(function(){
		$('table#lvltbl tbody tr td#hps')
			.click(function(){
			  //if(confirm("Data ini akan di hapus?")){
				var lv=$(this).attr('abbr');
				$.post('delete_level',
					{'idlevel':lv},
					function(result){
						$('table#lvltbl tr#'+result).remove();
					});
			 // }
		})
		$('table#lvltbl tbody tr td#pilih')
			.click(function(){
				var aa=$(this).attr('abbr').split('-')
				$('#levelid').val(aa[1]).select();
				$('#close').click();
			})
	})
//-----------------user oto
	$('#oto_usernm').change(function(){
		var id=$(this).val();
		$.post('useroto',{'oto_usernm':id},
		function(result){
			//alert(result);
			$('table#listHak tbody tr').html('');
			$('table#listHak tbody').html(result);
		})
	})
	$('table#listHak').mouseenter(function(){
		$('input:checkbox').click(function(){
		var pos=$(this).is(':checked');
		var id=$(this).attr('id').split('-');
		var uid=$('#oto_usernm').val();
			$.post('useroto_update',
			{'idmenu':id[1],'idfld':id[0],'stat':pos,'userid':uid},
			function(result){ //alert(result);
			});
		})
	})
//-------function additional----------------
function isi_tabel(id,kol){
	var isi=$('table#listTable tr#n-'+id+' td:nth-child('+kol+')').html();	
	return isi;
}

});

