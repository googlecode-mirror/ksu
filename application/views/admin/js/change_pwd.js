/* JavaScript Document
Author	: Iswan Putera
url		: www.zetrosoft.vcom
Function: change password
*/
$(document).ready(function(e) {
    $('#saved').click(function(){
		var pwd1=$('#new_pass').val();
		var pwd2=$('#new_pass2').val();
		if(pwd2!=pwd1){
			alert('Re Pasword baru tidak cocok');
		}else{
		$('#frm1').attr('action','pwdupdate');
		document.frm1.submit();
		}
	})
			

	function match_pwd(){
		var xx=pwd1.match(pwd2);
		return xx;
	}
});