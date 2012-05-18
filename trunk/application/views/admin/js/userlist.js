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
			
	})
	$('#addlvl').click(function(){
		var level=prompt("Add new user level",'');
		if (level!=null && level!=''){
			document.location.href="?pos=add&id="+level;
		}
		$(this).attr('disabled','disabled');
	});
	$('#saved').click(function(){
		$('#frm1').attr('action','addusersimpan');
		document.frm1.submit();
	})
});
