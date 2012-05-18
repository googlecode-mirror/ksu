// JavaScript Document
	$(document).ready(function(e) {
		lock('#saved');
		$('#tgllahir').css('color','#CCC');
		$('#tgllahir').val('dd/mm/yyyy');
		$('#tglmasuk').css('color','#CCC');
		$('#tglmasuk').val('dd/mm/yyyy');
		$('input:first').focus().select();	
		$('#jabatan').change(function(){
			//alert('yyy');
		  ($(this).text()!='')?unlock('#saved'):'';
		});
		$('#tgllahir')
			.focus(function(){
				$(this).select().val('');
				$('#tgllahir').css('color','#000');})
			.keyup(function(){ tanggal(this);})
			.focusout(function(){
				if($(this).val()==''){
				$('#tgllahir').css('color','#CCC');
				$('#tgllahir').val('dd/mm/yyyy');
				};
			})
		$('#tglmasuk')
			.focus(function(){
				$(this).select().val('');
				$('#tglmasuk').css('color','#000');})
			.keyup(function(){ tanggal(this);})
			.focusout(function(){
				if($(this).val()==''){
				$('#tglmasuk').css('color','#CCC');
				$('#tglmasuk').val('dd/mm/yyyy');
				}
			})
		$('#saved').click(function(){
			if(!isDate($('#tgllahir').val()) ||
				 !isDate($('#tglmasuk').val())){
				 alert('Format Tanggal lahir / tgl masuk salah');}else{
					$('#frm1').attr('action','sdm_drv_simpan');
					document.frm1.submit();
				 }
		})
	});
