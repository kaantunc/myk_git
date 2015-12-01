<?php
session_start(); 
echo $this->userId;
$basvurular = $this->belgebasvurular;
$basSayi = count($basvurular);
@$evrak_id = $_POST['evrak_id'];
if(isset($evrak_id)){
	@$_SESSION['evrak_id'] = $evrak_id;
	exit();}
?>

<form
	onsubmit="return validate('ChronoContact_meslek_std_basvuru_t1')"
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t1"
	name="ChronoContact_meslek_std_basvuru_t1">


	<!-- <input type="hidden" name="evrak_id" value="<?php //$this->evrak_id ?>" />
	<input type='hidden' id="updated" value='0' name='updated'/> -->

<?php 
//echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">Yeterlilik Başvuruları</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div id="basvurular_div">
		<table id="basvurular" style="float:left; width:100%;text-align:center">
			<thead >
				<tr>
					<th>Basvuru Tarihi</th>
					<th>Durum</th>
					<th>İncele/Değiştir</th>
					<th>Sil</th>
				</tr>
			</thead>
			<?php 
			for ($i=0; $i<$basSayi; $i++){
			?>
			<tbody id="basvuru_<?php echo $i;?>">
			<?php
				
					echo '<tr id="belge_'.$i.'">';
	                echo '<td style="text-align:center;">'.$basvurular[$i][BASVURU_TARIHI].'</td>';
	                echo '<td style="text-align:center;">'.$basvurular[$i][DURUM].'</td>';
	                if($basvurular[$i][DURUM_ID] == -1 || $basvurular[$i][DURUM_ID] == -2){
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele/Değiştir" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                else{
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                if($basvurular[$i][DURUM_ID] == -1){
	               		echo '<td><input type="button" onclick="deleteBelge('.$basvurular[$i]['EVRAK_ID'].')" value="Sil"/></td>';
					}else{
						echo '<td><input type="button" disabled="disabled" value="Sil"/></td>';
					}
					echo '</tr>';
			?>
			</tbody>
				<!--<input type="hidden" name="evrak_id" value="<?php echo $basvurular[$i][EVRAK_ID]?>" />--> 
				<input type='hidden' id="updated" value='0' name='updated'/>
			<?php
				}
			 ?>
		</table>
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		<?php if($basSayi == 0){?>
		<input type="button" name="satirEkleButton"  class="satirEkle" value="Yeni Yeterlilik Başvurusu Ekle" onclick="goToNewPage()"/>
		<?php }
			else{
		?>
		<input type="button" name="satirEkleButton"  class="satirEkle" value="Yeni Yeterlilik Başvurusu Ekle" onclick="goToNewPage()"/>
		<?php }?>
<div class="cfclear">&nbsp;</div>	
</div>
<br>
<br>


<!--KAYDET BAS-->
<!--<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>-->
<!--KAYDET SON-->
</form>

<script type="text/javascript">
function goToPage2(evrak_id){
	window.location.href="index.php?option=com_yeterlilik_basvur&layout=basvuru_yeni&evrak_id="+evrak_id;
	}
function goToNewPage(){
	window.location.href="index.php?option=com_yeterlilik_basvur&layout=basvuru_yeni";
	}
function deleteBelge(evrakId){
	if(confirm('Başvuruyu silmek istediğinizden emin misiniz?')){
		jQuery('#loaderGif').lightbox_me({
            centered: true,
            closeClick:false,
            closeEsc:false
        });
		jQuery.ajax({
			type:"POST",
			url:"index.php?option=com_yeterlilik_basvur&task=ajaxBasvuruSil&format=raw",
			data:"evrakId="+evrakId,
			success:function(data){
				window.location.reload();
				}
		});
	}
}
 

</script>