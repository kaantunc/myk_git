<?php
session_start(); 
$basvurular = $this->belgebasvurular;
$basSayi = count($basvurular);
@$evrak_id = $_POST['evrak_id'];
if(isset($evrak_id)){
	@$_SESSION['evrak_id'] = $evrak_id;
	exit();}
?>

<form
	onsubmit="return validate('ChronoContact_belgelendirme_basvuru_t3')"
	action=""
	enctype="multipart/form-data" method="post"
	id="ChronoContact_belgelendirme_basvuru_t3"
	name="ChronoContact_belgelendirme_basvuru_t3">

	<!-- <input type="hidden" name="evrak_id" value="<?php $this->evrak_id ?>" />
	<input type='hidden' id="updated" value='0' name='updated'/> -->

<?php 
//echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">Belgelendirme Başvuruları</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div id="basvurular_div">
	<br>
		<h2>Yetki Başvuruları</h2>
		<br>
		<table id="basvurular" style="float:left; width:100%;text-align:center">
			<thead >
				<tr>
					<th>Basvuru Tarihi</th>
					<th>Belgelendirme Durumu</th>
					<th>İncele/Değiştir</th>
					<th>Başvuru Dökümanı</th>
					<th>Sil</th>
				</tr>
			</thead>
			<tbody id="yetkibasvuru" style="text-align:center;">
			<?php 
			for ($i=0; $i<$basSayi; $i++){
				if($basvurular[$i]['BASVURU_TURU'] == 0){
					echo '<tr id="belge_'.$i.'">';
	                echo '<td style="text-align:center;">'.$basvurular[$i][BASVURU_TARIHI].'</td>';
	                echo '<td style="text-align:center;">'.$basvurular[$i][DURUM].'</td>';
	                if($basvurular[$i][DURUM_ID] == 2 || $basvurular[$i][DURUM_ID] == 6){
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele/Değiştir" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                //yetki talebinde bulunmak için yeni ekler eklenicek
	                else if($basvurular[$i][DURUM_ID] == 10 || $basvurular[$i][DURUM_ID] == 14){
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele/Değiştir" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                else{
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                echo '<td><a target="_blank" href="index.php?option=com_belgelendirme_basvur&layout=pdf&format=pdf&form=3&id='.$basvurular[$i][EVRAK_ID].'">Başvuru Dökümanı</a></td>';
	                if($basvurular[$i]['DURUM_ID'] == 2){
	                	echo '<td><input type="button" onclick="deleteBelge('.$basvurular[$i]['EVRAK_ID'].')" value="Sil"/></td>';
	                }else{
	                	echo '<td><input type="button" disabled="disabled" value="Sil"/></td>';
	                }
					echo '</tr>';
			?>
				<!--<input type="hidden" name="evrak_id" value="<?php echo $basvurular[$i][EVRAK_ID]?>" />--> 
				<input type='hidden' id="updated" value='0' name='updated'/>
			<?php
				}
			}
			 ?>
			 </tbody>
		</table>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		<input type="button" name="satirEkleButton"  class="satirEkle" value="Yeni belgelendirme başvurusu ekle" onclick="goToNewPage(0)"/>
	</div>

<div style="margin-top:20px;">
<hr>
<br>
<h2>Kapsam Genişletme Başvuruları</h2>
<br>
<table id="basvurular" style="float:left; width:100%;text-align:center;">
			<thead >
				<tr>
					<th>Basvuru Tarihi</th>
					<th>Durum</th>
					<th>İncele/Değiştir</th>
					<th>Başvuru Dökümanı</th>
					<th>Sil</th>
				</tr>
			</thead>
			<tbody id="kapsambasvuru" style="text-align:center;">
			<?php 
			for ($i=0; $i<$basSayi; $i++){
				if($basvurular[$i]['BASVURU_TURU'] == 1){
					echo '<tr id="belge_'.$i.'">';
	                echo '<td style="text-align:center;">'.$basvurular[$i][BASVURU_TARIHI].'</td>';
	                echo '<td style="text-align:center;">'.$basvurular[$i][DURUM].'</td>';
	                if($basvurular[$i][DURUM_ID] == 2 || $basvurular[$i][DURUM_ID] == 6){
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele/Değiştir" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                //yetki talebinde bulunmak için yeni ekler eklenicek
	                else if($basvurular[$i][DURUM_ID] == 10 || $basvurular[$i][DURUM_ID] == 14){
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele/Değiştir" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                else{
	                	echo '<td style="text-align:center;"><input type="button" id="$basvurular[$i][EVRAK_ID]" class="gonder" value="İncele" onclick="goToPage2('.$basvurular[$i][EVRAK_ID].')"/></td>';
	                }
	                echo '<td><a target="_blank" href="index.php?option=com_belgelendirme_basvur&layout=pdf&format=pdf&form=3&id='.$basvurular[$i][EVRAK_ID].'">Başvuru Dökümanı</a></td>';
	                if($basvurular[$i]['DURUM_ID'] == 2){
	                	echo '<td><input type="button" onclick="deleteBelge('.$basvurular[$i]['EVRAK_ID'].')" value="Sil"/></td>';
	                }else{
	                	echo '<td><input type="button" disabled="disabled" value="Sil"/></td>';
	                }
					echo '</tr>';
			?>
				<!--<input type="hidden" name="evrak_id" value="<?php echo $basvurular[$i][EVRAK_ID]?>" />--> 
				<input type='hidden' id="updated" value='0' name='updated'/>
			<?php
				}
			}
			 ?>
			 </tbody>
		</table>	
		</div>
		<div class="cfclear" style="height:20px;">&nbsp;</div>
		
		<input type="button" name="satirEkleButton"  class="satirEkle" value="Yeni kapsam başvurusu ekle" onclick="goToNewPage(1)"/>
		
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
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
<script type="text/javascript">
	function deleteBelge(evrakId){
		if(confirm('Başvuruyu silmek istediğinizden emin misiniz?')){
			jQuery('#loaderGif').lightbox_me({
	            centered: true,
	            closeClick:false,
	            closeEsc:false
	        });
			jQuery.ajax({
				type:"POST",
				url:"index.php?option=com_belgelendirme_basvur&task=ajaxBelgeSil&format=raw",
				data:"evrakId="+evrakId,
				success:function(data){
					window.location.reload();
					}
			});
		}
	}
/*
jQuery(document).ready(function() {

	jQuery('#silButton').live('click', function() {
		var silno = jQuery(this).attr("class");
		jQuery("#"+silno).remove();	
	});

} );*/
 

</script>