// JavaScript Document
 $(document).ready(function(e) {
    $('input:first').focus().select();
	$('table#fmrTable tr td#c23').append($('span#addlevel').contents());
    $('table#panel tr td').click(function(){
	  var id=$(this).attr('id');
			$('#'+id).removeClass('j_panel');
			$('#'+id).addClass('j_panel2');
			$('table#panel tr td:not(#'+id+')').removeClass('j_panel2');
			$('table#panel tr td:not(#'+id+')').addClass('j_panel');
			$('span#v_'+id).show();
			$('span:not(#v_'+id+')').hide();
			if(id=='add'){
				($('#saved').val()=='Simpan')?$('#saved').removeAttr('readonly'):'';
			}
			if(id=='list'){$('input:not(button)').val('');}
			
	})
	$('#addlvl').click(function(){
		var level=prompt("Add new user level",'');
		if (level!=null && level!=''){
			document.location.href="?pos=add&id="+level;
		}
		$(this).attr('disabled','disabled');
	});
	$('#saved').click(function(){
		var tp=$(this).val();
		(tp=='Simpan')?
		$('#frm1').attr('action','addusersimpan'):
		$('#frm1').attr('action','adduserupdate');
		document.frm1.submit();
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
				
			$('select#levelid option[text='+isi_tabel(id,'4')+']').select();
			$('#saved').val('Update');
			$('#password').attr('disabled','disabled');
			$('table#panel tr td#add').click();
			break;
			case 'del':
			break;	
		}
	})
function isi_tabel(id,kol){
	var isi=$('table#listTable tr#n-'+id+' td:nth-child('+kol+')').html();	
	return isi;
}

});

