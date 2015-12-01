<?php

defined('_JEXEC') or die('Restricted access');

	//$sinavSekli = $this->postData['sinav_sekli'];
	//$sinavTuru = $this->postData['sinav_turu'];
	//$evrakId = $this->postData['evrakId'];
	
	$sinavId = JRequest::getVar( 'sinavId' );
	$sinavTuru = JRequest::getVar( 'sinav_turu' );
	$deger = $this->degerlendirici;

?>
<form onsubmit="return validate('pratik_kaydet_form')"
		id="pratik_kaydet_form" 
		action="?option=com_sinav&task=SinavSonucuKaydet" method="post">
	<input type="hidden" value="<?php echo $sinavTuru?>" name="sinavTuru" />
	<input type="hidden" value="<?php echo $sinavId?>" name="sinavId" />
<div style="overflow-x:auto;">
		<table cellspacing="1">
			<tr class="tablo_header">
				<th>#</th>
				<th>Kuruluş Kayıt No</th>
				<th>TC Kimlik No</th>
				<th>Adı</th>
				<th>Soyadı</th>
				<th>Sınavı</th>
				<th>Aldığı Puan</th>
				<th>SONUÇ</th>
				<th>Gözetmen</th>
				<th>Değerlendirici</th>
			</tr>
			<?php
				if($this->ogrenciler[0] == 1){
				$rowCount=1;
				$rowClass="";
				foreach($this->ogrenciler[1] AS $satir){
					if($rowCount%2==0)
					$rowClass = "even_row";
					else
					$rowClass = "odd_row";
					echo '<tr class="'.$rowClass.'" style="text-align:center;">';
					echo '<td>'.$rowCount.'</td>';
					if(strlen($satir['SEKIL']) <= 0){
						echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
						echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nbsp;").'</td>';
						if($satir['OLC_DEG_HARF'] == 'P')
							echo '<td>'.($satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/PRATİK-'.$satir['OLC_DEG_NUMARA'].')'?$satir['ALT_BIRIM_ID'].' - '.$satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/PRATİK-'.$satir['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$satir['ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						else if($satir['OLC_DEG_HARF'] == 'T')
							echo '<td>'.($satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/TEORİK-'.$satir['OLC_DEG_NUMARA'].')'?$satir['ALT_BIRIM_ID'].' - '.$satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/TEORİK-'.$satir['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$satir['ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						else if($satir['OLC_DEG_HARF'] == 'D')
							echo '<td>'.($satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/DRATİK-'.$satir['OLC_DEG_NUMARA'].')'?$satir['ALT_BIRIM_ID'].' - '.$satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/DRATİK-'.$satir['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$satir['ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						echo '<td><input type="text" name="puan_'.$satir["TC_KIMLIK"].'[]" value="'.$satir["ALDIGI_NOT"].'"/></td>';
						if($satir["SINAV_DURUM_ID"] == 1){
							echo '<td><select class="comboReq" name="sinav_sonuc_'.$satir["TC_KIMLIK"].'[]" >'
								.'<option value="'.$satir["SINAV_DURUM_ID"].'">'.$this->sinavDurumlari[0][0]["SINAV_DURUM_ADI"].'</option>'
								.'<option value="2">'.$this->sinavDurumlari[0][1]["SINAV_DURUM_ADI"].'</option>'
								.'<option value="3">'.$this->sinavDurumlari[0][2]["SINAV_DURUM_ADI"].'</option>'
								.'</select></td>';
						}
						else if($satir["SINAV_DURUM_ID"] == 2){
							echo '<td><select class="comboReq" name="sinav_sonuc_'.$satir["TC_KIMLIK"].'[]" >'
							.'<option value="'.$satir["SINAV_DURUM_ID"].'">'.$this->sinavDurumlari[0][1]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="1">'.$this->sinavDurumlari[0][0]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="3">'.$this->sinavDurumlari[0][2]["SINAV_DURUM_ADI"].'</option>'
							.'</select></td>';
						}
						else if($satir["SINAV_DURUM_ID"] == 3){
							echo '<td><select class="comboReq" name="sinav_sonuc_'.$satir["TC_KIMLIK"].'[]" >'
							.'<option value="'.$satir["SINAV_DURUM_ID"].'">'.$this->sinavDurumlari[0][2]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="1">'.$this->sinavDurumlari[0][0]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="2">'.$this->sinavDurumlari[0][1]["SINAV_DURUM_ADI"].'</option>'
							.'</select></td>';
						}
						echo '<td><input type="text" name="gozetmen_'.$satir["TC_KIMLIK"].'[]" value="'.$satir["GOZETMEN"].'"/></td>';
						echo '<td><input type="text" id="deger_'.$rowCount.'" class="degerlendirici" name="deger_'.$satir["TC_KIMLIK"].'[]" value="'.$satir["DEGERLENDIRICI"].'"/></td>';
					}
					else{
						echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
						echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nbsp;").'</td>';
						if($satir['SEKIL'] == 0)
							echo '<td>'.($satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/TEORİK)'?$satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/TEORİK)':"&nbsp;").'<input type="hidden" value="'.$satir['ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						else if($satir['SEKIL'] == 1)
							echo '<td>'.($satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/PRATİK)'?$satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/PRATİK)':"&nbsp;").'<input type="hidden" value="'.$satir['ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						echo '<td><input type="text" name="puan_'.$satir["TC_KIMLIK"].'[]" value="'.$satir["ALDIGI_NOT"].'"/></td>';
						if($satir["SINAV_DURUM_ID"] == 1){
							echo '<td><select class="comboReq" name="sinav_sonuc_'.$satir["TC_KIMLIK"].'[]">'
							.'<option value="'.$satir["SINAV_DURUM_ID"].'">'.$this->sinavDurumlari[0][0]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="2">'.$this->sinavDurumlari[0][1]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="3">'.$this->sinavDurumlari[0][2]["SINAV_DURUM_ADI"].'</option>'
							.'</select></td>';
						}
						else if($satir["SINAV_DURUM_ID"] == 2){
							echo '<td><select class="comboReq" name="sinav_sonuc_'.$satir["TC_KIMLIK"].'[]" >'
							.'<option value="'.$satir["SINAV_DURUM_ID"].'">'.$this->sinavDurumlari[0][1]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="1">'.$this->sinavDurumlari[0][0]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="3">'.$this->sinavDurumlari[0][2]["SINAV_DURUM_ADI"].'</option>'
							.'</select></td>';
						}
						else if($satir["SINAV_DURUM_ID"] == 3){
							echo '<td><select class="comboReq" name="sinav_sonuc_'.$satir["TC_KIMLIK"].'[]" >'
							.'<option value="'.$satir["SINAV_DURUM_ID"].'">'.$this->sinavDurumlari[0][2]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="1">'.$this->sinavDurumlari[0][0]["SINAV_DURUM_ADI"].'</option>'
							.'<option value="2">'.$this->sinavDurumlari[0][1]["SINAV_DURUM_ADI"].'</option>'
							.'</select></td>';
						}
						echo '<td><input type="text" name="gozetmen_'.$satir["TC_KIMLIK"].'[]" value="'.$satir["GOZETMEN"].'"/></td>';
						echo '<td><input type="text" id="deger_'.$rowCount.'" class="degerlendirici" name="deger_'.$satir["TC_KIMLIK"].'[]" value="'.$satir["DEGERLENDIRICI"].'"/></td>';
					}
						?>
						
						<?php
					echo '</tr>';
					$rowCount++;
				}
			}
			else{
				$rowCount=1;
				$rowClass="";
				foreach($this->ogrenciler[1] AS $satir){
					if($rowCount%2==0)
					$rowClass = "even_row";
					else
					$rowClass = "odd_row";
					echo '<tr class="'.$rowClass.'" style="text-align:center;">';
					echo '<td>'.$rowCount.'</td>';
					if(strlen($satir['SEKIL']) <= 0){
						echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
						echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nbsp;").'</td>';
						if($satir['OLC_DEG_HARF'] == 'P')
						echo '<td>'.($satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/PRATİK-'.$satir['OLC_DEG_NUMARA'].')'?$satir['YETERLILIK_ALT_BIRIM_ID'].' - '.$satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/PRATİK-'.$satir['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$satir['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						else if($satir['OLC_DEG_HARF'] == 'T')
						echo '<td>'.($satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/TEORİK-'.$satir['OLC_DEG_NUMARA'].')'?$satir['YETERLILIK_ALT_BIRIM_ID'].' - '.$satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/TEORİK-'.$satir['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$satir['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						else if($satir['OLC_DEG_HARF'] == 'D')
						echo '<td>'.($satir['BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/DRATİK-'.$satir['OLC_DEG_NUMARA'].')'?$satir['YETERLILIK_ALT_BIRIM_ID'].' - '.$satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['BIRIM_KODU'].'/DRATİK-'.$satir['OLC_DEG_NUMARA'].')':"&nbsp;").'<input type="hidden" value="'.$satir['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
					}
					else{
						echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
						echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nbsp;").'</td>';
						echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nbsp;").'</td>';
						if($satir['SEKIL'] == 0)
						echo '<td>'.($satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/TEORİK)'?$satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/TEORİK)':"&nbsp;").'<input type="hidden" value="'.$satir['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
						else if($satir['SEKIL'] == 1)
						echo '<td>'.($satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/PRATİK)'?$satir['YETERLILIK_ALT_BIRIM_ADI'].'('.$satir['YETERLILIK_ALT_BIRIM_NO'].'/PRATİK)':"&nbsp;").'<input type="hidden" value="'.$satir['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]"/><input type="hidden" value="'.$satir['SEKIL'].'" name="altbirimSekil_'.$satir['TC_KIMLIK'].'[]"/></td>';
					}
					?>
										<td>
											<input type="text" name="puan_<?php echo $satir['TC_KIMLIK']?>[]"/>
										</td>
										<td>
											<select class="comboReq" name="sinav_sonuc_<?php echo $satir['TC_KIMLIK']?>[]">
												<option value="Seçiniz">Seçiniz</option>
												<?php echo $this->sinavDurumlari[1]?>
											</select>
										</td>
										<td>
											<input type="text" name="gozetmen_<?php echo $satir['TC_KIMLIK']?>[]"/>
										</td>
										<td>
											<input type="text" id="deger_<?php echo $rowCount;?>" class="degerlendirici" name="deger_<?php echo $satir['TC_KIMLIK']?>[]"/>
										</td>
										<?php
									echo '</tr>';
									$rowCount++;
								}
			}
			?>
		</table>
	</div>
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
		<input type="submit" value="Sonuçları Kaydet" />
</form>
<div id="revizyonlarPopupDiv" style="padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
<div id="Degerlen" style="overflow-y:auto; padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
<script type="text/javascript">
var turp='';
var str = new Array();
var degerarray = new Array();
var degerarrayId = new Array();
var str= <?php echo json_encode($deger); ?>;
 
for(var ii = 0; ii < str.length; ii++){
	turp += '<span><input type="checkbox" class="'+str[ii]['DEGERLENDIRICI'].replace(' ', '_')+'" id="'+str[ii]['DEGERLENDIRICI'].replace(' ', '_')+'" value="'+str[ii]['DEGERLENDIRICI']+'"/>		'+str[ii]['DEGERLENDIRICI']+'</span><br/>';
	degerarray[ii] = str[ii]['DEGERLENDIRICI'];
	degerarrayId[ii] = str[ii]['DEGERLENDIRICI'].replace(' ', '_');
}


jQuery(".degerlendirici").live("click",function(){
	 degerId = jQuery(this).attr('id');
	 //jQuery('.'+altbirimId).remove();
	 var altbirimdiv1 = '<div class="'+degerId+'" style="overflow-y:auto; padding:10px; width:400px; height:450px; background-color:white; display:none;">'+turp+'<input type="button" class="degerbitir" id="'+degerId+'" value="Bitir"/></div>';
	 if(!jQuery.contains(jQuery('body').html(), 'class="'+degerId+'"')){
		 jQuery('#Degerlen').html(altbirimdiv1);
		} 
		jQuery('.'+degerId).lightbox_me({
	        centered: true, 
	    });
});

jQuery('.degerbitir').live('click',function(){
	var degerbitirId = jQuery(this).attr('id');
	var degeryaz = '';
	
	for(var kk = 0; kk < degerarray.length; kk++){
		
		var checck = jQuery('.'+degerbitirId+' #'+degerarrayId[kk]).attr('checked')?true:false;
		if(checck == true){
			if(kk == (degerarray.length-1)){
				degeryaz += degerarray[kk];
				}
			else{	
				degeryaz += degerarray[kk]+',';
			}
			}
		else{
			}
		}

	jQuery('#'+degerbitirId).val(degeryaz);
	jQuery(".degerbitir").trigger("close");
	});
</script>