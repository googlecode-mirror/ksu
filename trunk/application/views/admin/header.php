<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
	$z_config='asset/bin/zetro_config.dll'
	
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>application/views/admin/images/icone.png" />
<link href="<?php echo base_url(); ?>application/views/admin/css/portal-style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>application/views/admin/css/zetro_css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo base_url(); ?>application/views/admin/js/dropdown.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url();?>application/views/admin/js/jquery.1.7.1.min.js" type="text/javascript"></script>
<script language="javascript" src="<?=base_url();?>application/views/admin/js/jquery_print.js" type="text/javascript"></script>
<script language="javascript">
	$(document).ready(function(e) {
        $('.sample_attach').css('z-index','10000');$('img.menux').click(function(){var id=$(this).attr("id");document.location.href="<?=base_url()?>index.php/"+id;})
    });
</script>
<title><?=$zz->rContent("WebPage","Title",$z_config)."-".$zz->rContent("WebPage","subtitle",$z_config);?></title>
</head>
<body>
<div id="menu-atas">
	<div class='logo'>
    <?=$zz->rContent("InfoCo","Name",$z_config);?>
    </div>
    <div class="menu">
    <?
	if($this->session->userdata('login')==true){
	 echo "<div class='welcome judul sorot' style='padding:5px;display:none'>Selamat datang 
    <span class='sorot'>".$this->session->userdata('username')."</span></div>";
	}
	$jml=$zz->Count('Menu Utama',$file);
		for ($i=1;$i<=$jml;$i++){
		$rst=explode('|',$zz->rContent('Menu Utama',$i,$file));
		$jml_sub=$zz->Count($rst[0],$file);
		 if($jml_sub==0){
				 echo "<div class='sub-menu'><a href='".base_url()."index.php/".$rst[1]."'>".$rst[0]."</a></div>";
			 }else{
				echo ($rst[1]!=Null)?
				  "<div id='parent_$i' class='sample_attach'><a  href='".base_url()."index.php/".$rst[1]."'>".$rst[0]."</a></div>":
				  "<div id='parent_$i' class='sample_attach'>".$rst[0]."</div>";
		 }
		 if($jml_sub>0){
			 echo "<div id='child_$i'>";
			 for ($z=1;$z<=$jml_sub;$z++){
					 $rst1=explode('|',$zz->rContent($rst[0],$z,$file));
				 echo "
				 <a class='sample_attach' href='".base_url()."index.php/".$rst1[1]."'>".$rst1[0]."</a>";
			 }
			 echo "</div>";
		 echo "<script type='text/javascript'>at_attach('parent_$i', 'child_$i', 'hover', 'y', 'pointer');</script>";
		 }
		 }
		
	?>
    </div>
    <div align="right" style="padding:10px; padding-right:25px; font-size:smaller">User Login: <?=$this->session->userdata('username');?></div>
</div>
