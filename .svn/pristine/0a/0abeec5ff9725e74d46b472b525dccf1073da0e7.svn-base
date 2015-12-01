<style>
.defaultTextarea
{
	width:400px;
	height:50px;
	margin-bottom:5px;
}
.h4CustomStyle
{
	padding-top: 15px;
}

</style>

<?php 
if( $this->seciliDenetim != null)
{
	$seciliDenetim = $this->seciliDenetim;
	$denetim_id = $_REQUEST['denetim_id'];
}	
?>

<form method="POST" action="index.php?option=com_denetim&task=denetim_kaydet&denetim_id=<?php echo $denetim_id; ?>">

<h3>BELGELENDİRME KURULUŞLARI İÇİN DENETİM FORMU</h3><br>

<?php 
if($seciliDenetim!=null)
{
	$dosyaNo = $seciliDenetim['BK_KODU'];
	echo '<div style="float:left; width:100%;">
		<div style="float:left; width:10%;">DOSYA NO</div>
		<div style="float:left; width:89%;"><input disabled type="text" id="bkKodu" class="numberInput" name="dosyaNo" value="'.$dosyaNo.'" ><font id="errorText" color="red"></font></div>
	</div>';
}
else
{
	echo '<div style="float:left; width:100%;">
	<div style="float:left; width:10%;">DOSYA NO</div>
	<div style="float:left; width:89%;">Denetim Ekranında Düzenlenecektir<font id="errorText" color="red"></font></div>
	</div>';
}
?>
<div style="float:left; width:100%; padding-bottom:15px; padding-top:4px;">
	<div style="float:left; width:10%;">DENETİM TÜRÜ</div>
	<div style="float:left; width:89%;">
		<select name="denetimTuruSelect" id="denetimTur">
			<?php 
				$options = FormFactory::getPM_DenetimTuru();
                                $selecTur = 0;
				foreach($options as $opt)
				{
                                    if($opt['DENETIM_TURU']==$seciliDenetim['DENETIM_TURU']){
                                        echo '<option selected value="'.$opt['DENETIM_TURU'].'">'.$opt['DENETIM_TURU_ACIKLAMA'].'</option>';
                                        $selecTur++;
                                    }else{
                                        echo '<option value="'.$opt['DENETIM_TURU'].'">'.$opt['DENETIM_TURU_ACIKLAMA'].'</option>';
                                    }
                                    
//					$selected = ($opt['DENETIM_TURU']==$seciliDenetim['DENETIM_TURU']) ? ' selected ': ' ';
                                        
//					echo '<option '.$selected.' value="'.$opt['DENETIM_TURU'].'">'.$opt['DENETIM_TURU_ACIKLAMA'].'</option>';
				}
                                if($selecTur == 0){
                                    echo '<option selected value="0">Seçiniz</option>';
                                }
			?>
		</select>
	</div>
</div>

<div style="float:left; width:100%;">
<h4>Belgelendirme Kuruluşunun Adı-Tanımı</h4><br>

<table border="0" style="width:100%;">
	<tr>
		<td>Kuruluşun Adı:</td>
		<td>
		<?php 
		
		if(strlen($denetim_id)>0)
		{
			echo '<select disabled name="kurulusSelect" class="comboReq">'.
			$this->kuruluslarSelectOptions. 
				'</select>';
			echo '<input type="hidden" name="kurulus" value="'.$seciliDenetim['DENETIM_KURULUS_ID'].'">';
		}
		else
		{
			echo '<select name="kurulus" class="comboReq" id="denetimKurId" disabled><option value="0">Seçiniz</option>'.
					$this->kuruluslarSelectOptions.
			'</select>';
		}
		
		?>
		</td>
	</tr>
        
        <tr id="belgeBasvuru" style="display: none">
		<td>Kuruluşun Başvurusu:</td>
		<td><select id="belgeBasvuruSelect" name="belgeBasvuruSelect"></select> <a id="incele" target="_blank" href="#">İncele</a> 
		<?php 
		
//		if(strlen($denetim_id)>0)
//		{
//			echo '<select disabled name="kurulusSelect" class="comboReq">'.
//			$this->kuruluslarSelectOptions. 
//				'</select>';
//			echo '<input type="hidden" name="kurulus" value="'.$seciliDenetim['DENETIM_KURULUS_ID'].'">';
//		}
//		else
//		{
//			echo '<select name="kurulus" class="comboReq" id="denetimKurId" disabled><option value="0">Seçiniz</option>'.
//					$this->kuruluslarSelectOptions.
//			'</select>';
//		}
		
		?>
		</td>
	</tr>
	
	<?php
			if($denetim_id != '') 
			{
				$adresValue = $seciliDenetim['DENETIM_KURULUS_ADRESI'];
				$postaKoduValue = $seciliDenetim['DENETIM_POSTA_KODU'];
			}
			else
			{
				$adresShow=' display:none; ';
				$postaKoduShow = ' display:none; ';
			}
			
			?>
	
	<tr style="<?php echo $adresShow;?>">
		<td>Adres:</td>
		<td><textarea name="kurulusAdresi" style="width:65%;">
			<?php echo $adresValue; ?>
			</textarea>
			
		</td>
	</tr>
	<tr style="<?php echo $postaKoduShow;?>">
		<td>Posta Kodu / Şehir:</td>
		<td>
			<input type="text" name="postaKoduSehir" style="width:65%;" value="<?php echo $postaKoduValue; ?>" >
		</td>
	</tr>
	
</table><br>
<?php 
$user = & JFactory::getUser();
$userId = $user->getOracleUserId();
$denetciMi = FormFactory::buIDDenetciMi($userId);
$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);


if(strlen($seciliDenetim['DENETIM_RAPOR_PATH'])>0 && !$denetlemesiYapilacakKurulusMu )
{
?>
	<h4 class="h4CustomStyle">1) Organizasyon Yapısı, Görev Ve Sorumluluklar</h4>
	
	<br>	Organizasyon yapısının uygunluğu
	<br>	<textarea class="defaultTextarea" name="ORGNZSYN_YAPISI_UYGUNLUK" ><?php echo $seciliDenetim['ORGNZSYN_YAPISI_UYGUNLUK']; ?></textarea>
	<br>	Eğitim belgelendirme ayrımı
	<br>	<textarea class="defaultTextarea" name="EGITIM_BELGELENDIRME_AYRIMI" ><?php echo $seciliDenetim['EGITIM_BELGELENDIRME_AYRIMI']; ?></textarea>
	<br>	Kritik görevlerde sorumluluklar açık olarak belirlenmiş mi?
	<br>	<textarea class="defaultTextarea" name="SORUMLULUKLAR_ACIK_MI" ><?php echo $seciliDenetim['SORUMLULUKLAR_ACIK_MI']; ?></textarea>
	<br>	Belgelendirme faaliyetlerinin etkilenmemesine yönelik önlemler
	<br>	<textarea class="defaultTextarea" name="FAALIYET_ETKI_ONLEMI" ><?php echo $seciliDenetim['FAALIYET_ETKI_ONLEMI']; ?></textarea>
	
	
	<h4 class="h4CustomStyle">2) İnsan kaynakları, fiziki, teknik ve mali imkanları</h4>
	
	<br>	Kuruluşun yetki kapsamındaki faaliyetleri için yeterli (sayı ve nitelik olarak) insan kaynağı var mı?
	<br>	<textarea class="defaultTextarea" name="INSAN_KAYNAGI_VAR_MI" ><?php echo $seciliDenetim['INSAN_KAYNAGI_VAR_MI']; ?></textarea>
	<br>	Sınav yapanlar ilgili ulusal yeterliliğin şartlarını sağlıyor mu?
	<br>	<textarea class="defaultTextarea" name="SNV_YAPANLAR_SART_SAGLIYORMU" ><?php echo $seciliDenetim['SNV_YAPANLAR_SART_SAGLIYORMU']; ?></textarea>
	<br>	Fiziki altyapının faaliyetleri gerçekleştirmeye uygunluğu
	<br>	<textarea class="defaultTextarea" name="FIZIKI_ALTYAPI_UYGUNLUGU" ><?php echo $seciliDenetim['FIZIKI_ALTYAPI_UYGUNLUGU']; ?></textarea>
	<br>	Teknik donanımın yeterliliği
	<br>	<textarea class="defaultTextarea" name="TEKNIK_DONANIM_YETERLILIGI" ><?php echo $seciliDenetim['TEKNIK_DONANIM_YETERLILIGI']; ?></textarea>
	<br>	Mali yapısının faaliyetleri sürdürmeyi sağlaması
	<br>	<textarea class="defaultTextarea" name="MALI_YAPI_FLYTLERI_SAGLIYORMU" ><?php echo $seciliDenetim['MALI_YAPI_FLYTLERI_SAGLIYORMU']; ?></textarea>
	
	<h4 class="h4CustomStyle">3) Sınav ve belgelendirme süreçleri</h4>
	
	<br>	Sınav belgelendirme süreçlerine ilişkin prosedürler ve uygulama uyumu
	<br>	<textarea class="defaultTextarea" name="BELGELENDIRME_PROSEDURDERI" ><?php echo $seciliDenetim['BELGELENDIRME_PROSEDURDERI']; ?></textarea>
	<br>	Tutulan kayıtların incelenmesi
	<br>	<textarea class="defaultTextarea" name="KAYITLARIN_INCELENMESI" ><?php echo $seciliDenetim['KAYITLARIN_INCELENMESI']; ?></textarea>
	<br>	Gezici sınav birimleri ile gerçekleştirilen sınavlara ilişkin inceleme
	<br>	<textarea class="defaultTextarea" name="GEZICI_SNV_INCELEMESI" ><?php echo $seciliDenetim['GEZICI_SNV_INCELEMESI']; ?></textarea>
	<br>	İtiraz ve şikayetlerin değerlendirilmesine ilişkin prosedürler ve kayıtların incelenmesi
	<br>	<textarea class="defaultTextarea" name="ITIRAZ_SIKAYET_DEGERLENDIRME" ><?php echo $seciliDenetim['ITIRAZ_SIKAYET_DEGERLENDIRME']; ?></textarea>
	<br>	Farklı sınav heyetleri arasındaki değerlendirmelerde uygulama birliğinin sağlanmasına yönelik önlemler
	<br>	<textarea class="defaultTextarea" name="FARKLI_SNV_HEYET_BIRLIGI" ><?php echo $seciliDenetim['FARKLI_SNV_HEYET_BIRLIGI']; ?></textarea>
	
	<h4 class="h4CustomStyle">4) Sınav materyali</h4>
	
	<br>	Mevcut sınav materyalinin ilgili ulusal yeterliliklerle uyumu
	<br>	<textarea class="defaultTextarea" name="SNV_MATERYALININ_YET_UYUMU" ><?php echo $seciliDenetim['SNV_MATERYALININ_YET_UYUMU']; ?></textarea>
	<br>	Yapılan sınavlar ile sınav materyalinin tutarlılığı
	<br>	<textarea class="defaultTextarea" name="YAPILAN_SNV_MTRYALI_TTRLILIGI" ><?php echo $seciliDenetim['YAPILAN_SNV_MTRYALI_TTRLILIGI']; ?></textarea>
	
	<h4 class="h4CustomStyle">5) İç / Dış Denetimler</h4>
	
	<br>	İç denetim kayıtları
	<br>	<textarea class="defaultTextarea" name="IC_DENETIM_KAYITLARI" ><?php echo $seciliDenetim['IC_DENETIM_KAYITLARI']; ?></textarea>
	<br>	Dış denetimler ve sonuçları
	<br>	<textarea class="defaultTextarea" name="DIS_DENETIM_SONUCLARI" ><?php echo $seciliDenetim['DIS_DENETIM_SONUCLARI']; ?></textarea>
	
<?php 
}
?>

</div><br><br>
<?php 
if($isSektorSorumlusu)
	echo '<input type="submit" id="kaydetButton" class="kaydetButton" value="DENETİM PLANLAMASI OLUŞTUR" >'
	
?>


</form>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#denetimTur').live('change',function(e){
       e.preventDefault();
       jQuery('#denetimKurId').prop('disabled',true);
       jQuery('#denetimKurId').children('option:selected').prop('selected',false);
       jQuery('#denetimKurId').children('option[value="0"]').prop('selected',true);
       jQuery('#belgeBasvuruSelect').html('');
       jQuery('#belgeBasvuru').hide();
       jQuery('#incele').attr('href','#');
       var dtur = jQuery(this).val();
       if(dtur > 0){
           jQuery('#denetimKurId').prop('disabled',false);
       }else{
           jQuery('#denetimKurId').prop('disabled',true);
       }
    });
    
    jQuery('#denetimKurId').live('change',function(e){
         e.preventDefault();
         jQuery('#belgeBasvuruSelect').html('');
         jQuery('#belgeBasvuru').hide();
         jQuery('#incele').attr('href','#');
         var dtur = jQuery('#denetimTur').val();
         var dkur = jQuery(this).val();
         if(dkur != 0){
            if(dtur == 1 || dtur == 2){
                jQuery.ajax({
                    type: 'POST',
                    url: "index.php?option=com_denetim&task=ajaxBelgeBasvuru&format=raw",
                    data: 'dtur='+dtur+'&dkur='+dkur,
                    success: function (data) {
                        var dat = jQuery.parseJSON(data);
                      
                        if(dat.length > 0){
                            var ekle = '<option value="0">Seçiniz</option>';
                            jQuery.each(dat,function(key,vall){
                                var expa = vall['BASVURU_TARIHI'].split(' ');
                                ekle += '<option value="'+vall['EVRAK_ID']+'">'+expa[0]+'</option>'; 
                            });
                            jQuery('#belgeBasvuruSelect').html(ekle);
                        	jQuery('#belgeBasvuru').show();
                        }else{
                            jQuery('#denetimKurId').children('option:selected').prop('selected',false);
                            jQuery('#denetimKurId').children('option[value="0"]').prop('selected',true);
                            alert('Seçmiş olduğunuz kuruluşun "Yetkilendirme Denetimi" ve "Kapsam Genişletme" denetim türlerinden denetim yapabileceğiniz başvuru bulunmamaktadır.');
                        }
                    }
                });
            }
        }
        else{
            jQuery('#belgeBasvuru').hide();
        }
    });

    jQuery('#belgeBasvuruSelect').live('change',function(e){
        e.preventDefault();
        jQuery('#incele').attr('href','#');
        var evrakId = jQuery(this).val();
        if(evrakId != 0){
        	jQuery('#incele').attr('href','index.php?option=com_belgelendirme_basvur&layout=kurulus_bilgi&evrak_id='+evrakId);
        }
	});
});
    
    
jQuery(".numberInput").live("keydown", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) || 
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 40)) {

    	if(event.keyCode == 38 && event.currentTarget.value!="")//yukarı
       		event.currentTarget.value = parseInt(event.currentTarget.value)+1;  
    	else if(event.keyCode == 40  && event.currentTarget.value!="")//aşagı
   			event.currentTarget.value = parseInt(event.currentTarget.value)-1;  
    	

             // let it happen, don't do anything
             return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        } 
        
              
    }
});

jQuery('#bkKodu').change(function(e){
	checkIfValuesAreOK();
});

function checkIfValuesAreOK()
{
	var BKValue = jQuery('#bkKodu').val();
	
	//if(BKValue.length==1)
	//	BKValue = '0'+BKValue;
	
	jQuery('#errorText').attr('color', 'red').html("Kontrol Ediliyor").show();
	jQuery('#kaydetButton').attr('disabled', 'disabled');
	jQuery('#kaydetButton').css('border', '1px solid red');
	
	jQuery.ajax({
		  url: "index.php?option=com_denetim&task=ajaxBKKoduKullanimdaMi&format=raw&bk="+BKValue+"&denetim_id="+<?php echo isset($_GET['denetim_id'])?$_GET['denetim_id']:0;?>,
		  data: null,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				 jQuery('#bkKodu').css('border', '1px solid #c0c0c0');
				 jQuery('#kaydetButton').css('border', '1px solid #c0c0c0');
				 jQuery('#errorText').attr('color', 'green').html("Kullanılabilir");
				 jQuery('#kaydetButton').removeAttr('disabled');
				 
			  }
			  else
			  {
				jQuery('#kaydetButton').css('border', '1px solid red');
				jQuery('#bkKodu').css('border', '1px solid red');
				jQuery('#errorText').attr('color', 'red').html("Kod kullanımda").show();
				jQuery('#kaydetButton').attr('disabled', 'disabled');
				
			  }
		  }
	});
	
}

</script>







