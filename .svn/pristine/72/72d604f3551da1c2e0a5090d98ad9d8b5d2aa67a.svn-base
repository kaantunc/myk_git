<?php 
$link="belge2xls.php";
$sektorler = FormParametrik::getSektor();
?>
<div class="form_item" style="margin: 0 0 20px 0;">
  <div class="form_element cf_heading" style="margin:0;">
  		  		<h3 class="contentheading" style="border-bottom : 1px solid #42627D">Belge Almış Kişiler</h3>
	  	  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<table style="padding:10px 10px 10px 0;">
		<tr>
			<td>Sektöre Göre&nbsp;&nbsp;</td>
			<td>
				<select id="sektor" name="sektor" style="width:232px;">
					<option selected="selected" value="">Seçiniz</option>
					<?php 
					foreach($sektorler AS $sektor){
						if ($sektor['SEKTOR_DURUM'] >= 0){
							echo '<option value="'.$sektor['SEKTOR_ID'].'">'.$sektor['SEKTOR_ADI'].'</option>';
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tarih Aralığı</td>
			<td><input type="text" id="basTarih"  class="sinavTarih">&nbsp;&nbsp;<input type="text" id="bitTarih" class="sinavTarih"></td>
		</tr>
		<tr>
			<td>Sıralama Tipi&nbsp;&nbsp;</td>
			<td>
				<select id="siralama" name="siralama" style="width:232px;">
					<option>Tüm Belge Listesi</option>
					<option value="o=ad">Tüm Belge Listesi (Ada göre sıralı)</option>
					<option value="o=soyad">Tüm Belge Listesi (Soyada göre sıralı)</option>
					<option value="o=belge_duzenleme_tarihi">Tüm Belge Listesi (Düzenleme Tarihine eskiden yeniye sıralı)</option>
					<option value="o=belge_duzenleme_tarihi&ters=1">Tüm Belge Listesi (Düzenleme Tarihine yeniden eskiye sıralı)</option>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td style="padding:5px;"><input type="button" id="downloaddoc" value="İndir"/></td>
		</tr>
</table>
<script type="text/javascript">
<!--
	jQuery(document).ready(function(){
		jQuery("#downloaddoc").click(function(){ 
	
			var str1 = jQuery("#basTarih").val();
			var str2 = jQuery("#bitTarih").val();
			
			var d1 = new Date(str1.substr(6, 4), (str1.substr(3, 2) - 1), str1.substr(0, 2));
			var d2 = new Date(str2.substr(6, 4), (str2.substr(3, 2) - 1), str2.substr(0, 2));

			 if(d1 > d2){
				alert("Bitiş tarihi başlangıç tarihinden küçük olamaz !");
				return false;
			 }
			 window.location.assign("<?php echo $link?>?"+jQuery("#siralama option:selected").val()+
					                             "&sektor="+jQuery("#sektor option:selected").val()+
					                           "&bastarih="+jQuery("#basTarih").val()+
					                           "&bittarih="+jQuery("#bitTarih").val());
		});


		jQuery('.sinavTarih').live('hover',function(e){
			 e.preventDefault();
				jQuery(this).datepicker({
			        changeYear: true,
			        changeMonth: true
			     });
		});
	});
//-->
</script>