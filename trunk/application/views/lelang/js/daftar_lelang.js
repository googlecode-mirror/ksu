// JavaScript Document
$(document).ready(function(e) {
    var prs=$('#prs').val();
	if (prs==''){
		$('#daftarlelang').removeClass('j_panel');
		$('#daftarlelang').addClass('j_panel2');
		$('table#panel tr td.plt').hide();
		}else{
		$('#labelbarang').removeClass('j_panel');
		$('#labelbarang').addClass('j_panel2');
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
	  		$('span#ttl').html(tt);
			if(id=='labelbarang'){
				$('table#panel tr td:nth-child(4)').hide();
				$('table#panel tr td:nth-child(5)').hide();
				$('table#panel tr td.plt').show();
				$.post('labellelang',{'id':id},
				function(result){
					$('table#listlabel tbody').html(result);
				})
			}else if(id=='daftarlelang'){
				$('table#panel tr td:nth-child(4)').show();
				$('table#panel tr td:nth-child(5)').show();
				$('table#panel tr td.plt').hide();
			}
	});
	
    	var id='';
		$.post('lap_perpanjang',
		{'no_spb':id},
		function(result){
			//alert(result);
			$('table#listdata tbody').html(result);
		});
	$('#print').click(function(){
		$('span#v_labelbarang').print();
	})

});

function upd_lelang(ide,st){
	var t=$('img.pros').attr('id');
	var	tt=t.split('-');
	$.post('upd_lelang',{'no_spb':ide,'stat':st,'ide':tt[1]},
	function(result){
		//alert(result);
		var hsl= new $.parseJSON(result)
		//$('table#listdata tbody tr#c-1-'+tt[1]+' td:last-child img.pros').attr({'src':hsl.gambar,'onclick':hsl.diklik});//.html('');
		$('table#panel tr td:last-child span#ttl').html(hsl.ttl);
		document.location.reload();
	});
}