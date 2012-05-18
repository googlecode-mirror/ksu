<? //include "asset/class/zetro_manager.php";
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
?>
<script language='javascript'>
	$(document).ready(function(e) {
        $('tr').click(function(){
			var id=$(this).attr('id');
			$('img#'+id).toggle();
			$('tr#c'+id).toggle('slow');
		});
	 $('.j_panel').css('width','405');
    });
</script>

<div class='contents'>
 <div class='j_panel judul'>Berikut adalah Otorisasi Anda Sebagai <span class='sorot'><?=$this->session->userdata('group');?></div>
<div class='pn_content'>
<hr><!--
<table width="100%" border="0">
  <tr id='d1' class='isi'>
    <td class='judul' colspan="9">
    <img src='<?=base_url();?>asset/images/arrows/down.png' id='d1' style='display:'>
    <img src='<?=base_url();?>asset/images/arrows/right.png' id='d1' style='display:none'><?= nbs(2);?>Control Menu</td>
  </tr>
  <? $jml=$zz->Count('Menu',$file);//main-menu
  	for ($i=1;$i<=$jml;$i++){
		$jml_sub=0;
		$xx=explode('|',$zz->rContent('Menu',$i,$file));
		$jml_sub=$zz->Count($xx[0],$file);
		($jml_sub==0)?$cs='colspan="3"':$cs='colspan="3"';
			?>
      <tr id='cd1' class='<?=$xx[0];?> isi' style='display:none'>
      <td width="20px" align="right"><img src='<?=base_url();?>asset/images/3.png'></td>
      <td <?=$cs;?> class="sub-judul"><?=$xx[0];?></td>
      <? /* if($jml_sub==0){
		  echo "<td>".nbs(2)."</td>";
		  echo "<td width='70px'>".img('asset/images/bullet.png').nbs(2)."Full</td>";
		  echo "<td width='70px'>".img('asset/images/bullet.png').nbs(2)."Create</td>";
		  echo "<td width='70px'>".img('asset/images/bullet.png').nbs(2)."Edit</td>";
		  echo "<td width='70px'>".img('asset/images/bullet.png').nbs(2)."View</td>";
		  echo "<td width='70px'>".img('asset/images/bullet.png').nbs(2)."Print</td>";
	  }*/
	  ?>
      </tr>
   <? //sub-menu1
   	  if($jml_sub>0){
		  for ($z=1;$z<=$jml_sub;$z++){
		$xxx=explode('|',$zz->rContent($xx[0],$z,$file));
		$jml_sub2=$zz->Count($xxx[0],$file);
		($full=='Y' && $idmenu==$xxx[0])? $im=img('asset/images/bullet.png'):$im=img('asset/images/bullet2.png');
		($create=='Y' && $idmenu==$xxx[0])? $im1=img('asset/images/bullet.png'):$im1=img('asset/images/bullet2.png');
		($edit=='Y' && $idmenu==$xxx[0])? $im2=img('asset/images/bullet.png'):$im2=img('asset/images/bullet2.png');
		($view=='Y' && $idmenu==$xxx[0])? $im3=img('asset/images/bullet.png'):$im3=img('asset/images/bullet2.png');
		($print=='Y' && $idmenu==$xxx[0])? $im4=img('asset/images/bullet.png'):$im4=img('asset/images/bullet2.png');
	?>		  
      <tr id='cd1' class='<?=$xxx[0];?> isi' style='display:none'>
      <td>&nbsp;</td>
      <td width="20px" align="right"><img src='<?=base_url();?>asset/images/3.png'></td>
      <td colspan='2' class="sub-judul"><?=$xxx[0];?></td>
      <? if($jml_sub2==0){
		  echo "<td width='70px'>$im".nbs(2)."Full</td>";
		  echo "<td width='70px'>$im1".nbs(2)."Create</td>";
		  echo "<td width='70px'>$im2".nbs(2)."Edit</td>";
		  echo "<td width='70px'>$im3".nbs(2)."View</td>";
		  echo "<td width='70px'>$im4".nbs(2)."Print</td>";
	  }
	  ?></tr>
   <? //sub-menu2
		  if($jml_sub2>0){
			  for ($z2=1;$z2<=$jml_sub2;$z2++){
				$xx2=explode('|',$zz->rContent($xxx[0],$z2,$file));
				$jml_sub3=$zz->Count($xx2[0],$file);
				($full=='Y' && $idmenu==$xx2[0])  ? $im2=img('asset/images/bullet.png') :$im2=img('asset/images/bullet2.png');
				($create=='Y' && $idmenu==$xx2[0])? $im21=img('asset/images/bullet.png'):$im12=img('asset/images/bullet2.png');
				($edit=='Y' && $idmenu==$xx2[0])  ? $im22=img('asset/images/bullet.png'):$im22=img('asset/images/bullet2.png');
				($view=='Y' && $idmenu==$xx2[0])  ? $im32=img('asset/images/bullet.png'):$im32=img('asset/images/bullet2.png');
				($print=='Y' && $idmenu==$xx2[0]) ? $im42=img('asset/images/bullet.png'):$im42=img('asset/images/bullet2.png');
			?>		  
			  <tr id='cd1' class='<?=$xx2[0];?> isi' style='display:none'>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td width="20px" align="right"><img src='<?=base_url();?>asset/images/3.png'></td>
			  <td class="sub-judul" width='200px'><?=$xx2[0];?></td>
			  <? if($jml_sub3==0){
			  echo "<td width='70px'>$im2".nbs(2)."Full</td>";
			  echo "<td width='70px'>$im12".nbs(2)."Create</td>";
			  echo "<td width='70px'>$im22".nbs(2)."Edit</td>";
			  echo "<td width='70px'>$im32".nbs(2)."View</td>";
			  echo "<td width='70px'>$im42".nbs(2)."Print</td>";
              }
	  ?>
              </tr>
	   <? 		} // end for sub-menu2
			}// end if sub-menu2
   		} // end for sub-menu1
   	 } //end if sub-menu1
   } // end for main-menu 
   ?>
  <tr id='d2' class='isi'>
    <td class='judul' colspan="9">
    <img src='<?=base_url();?>asset/images/arrows/down.png' id='d2' style='display:'>
    <img src='<?=base_url();?>asset/images/arrows/right.png' id='d2' style='display:none'><?= nbs(2);?>Control Area</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>-->
</div>
</div>