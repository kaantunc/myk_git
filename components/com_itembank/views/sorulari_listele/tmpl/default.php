<?php 
$model = &$this->getModel();
$model2 = &$this->getModel("sorugirisi");
$sektorler=$model2->getSektorler();
$soruTipi=$model2->getSoruTipi();
$zorlukDerecesi=$model2->getZorlukDerecesi();
$teorikSoruSekli=$model2->getTeorikSoruSekli();
$performansSoruSekli=$model2->getPerformansSoruSekli();
$kullaniciTipi=$model->kullaniciTipi();
$kuruluslar=$model->getKuruluslar();
$getPMSoruDurum=$model->getPMSoruDurum();
if ($kullaniciTipi==2){
	$baslik="Soru Arama";
}
if ($kullaniciTipi==1){
	$baslik="Sorularım";
}
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading"><?php echo $baslik;?></h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<form
	enctype="multipart/form-data"
	id="soru_arama_formu"
	name="soru_arama_formu"
	method="post">

<?php 
if ($kullaniciTipi==2){
?>	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Kuruluş</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="kurulus_id" name="kurulus_id" onchange="">
		<?php
		echo "<option value=''>Hepsi</option>";
		foreach($kuruluslar as $kurulus){
			echo "<option value='".$kurulus["USER_ID"]."'>".$kurulus["KURULUS_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<label class="cf_label" style="width: 200px;">Sektör</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="sektor" name="sektor" onchange="getSeviye(jQuery(this).val());">
		<?php
		echo "<option value=''>Sektör Seçiniz</option>";
		foreach($sektorler as $sektor){
			echo "<option value='".$sektor["SEKTOR_ID"]."'>".$sektor["SEKTOR_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Seviyesi</label>
	    <div id="seviyeDiv">
		    <select class="cf_inputbox required" style="width: 300px;" id="seviye" name="seviye" onchange="getYeterlilikler(jQuery('#sektor').val(),jQuery(this).val());">
			<?php
			echo "<option value=''>Önce Sektör Seçiniz</option>";
			?>
			</select>
	    </div>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_inputbox">
	    <label class="cf_label" style="width: 200px;">Yeterlilik</label>
	    <div id="yeterlilikDiv">
	    	<select class="required cf_label" style="width: 300px;" style="" id="yeterlilik_id" name="yeterlilik_id" onchange="eskiYeniTeorikPerformans('', true);">
	    	<option value="">Sektör ve Seviye Seçiniz</option>
	    	</select>
	    </div>	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Teorik/Performans</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="soru_grubu_id" name="soru_grubu_id" onchange="eskiYeniTeorikPerformans('', true); soruTipiSec();">
	    <option value=''>Hepsi</option>
	    <?php
		foreach($soruTipi as $arr){
			echo "<option value='".$arr["SORU_TIPI_ID"]."'>".$arr["SORU_TIPI_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
				
	<div id="performansSoruTipiDiv" style="display:none;">		

			
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Performans Soru Tipi</label>
		    <select class="cf_inputbox required" style="width: 300px;" id="soru_tipi_id_p" name="soru_tipi_id_p">
		    <option value=''>Hepsi</option>
		    <?php
			foreach($performansSoruSekli as $arr){
				echo "<option value='".$arr["SORU_SEKLI_ID"]."'>".$arr["SORU_SEKLI_ADI"]."</option>";
			}
			?>
			</select>
		    
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	</div>
		
	<div id="teorikSoruTipiDiv">		

			
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Teorik Soru Tipi</label>
		    <select class="cf_inputbox required" style="width: 300px;" id="soru_tipi_id" name="soru_tipi_id" onchange="teorikSoruTipi();">
		    <option value=''>Hepsi</option>
			<?php
			foreach($teorikSoruSekli as $arr){
				echo "<option value='".$arr["SORU_SEKLI_ID"]."'>".$arr["SORU_SEKLI_ADI"]."</option>";
			}
			?>
			</select>
		    
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	</div>
	
	
	
	<div id="yeni_yeterlilik_formatiDiv">
		<div class="form_item">
		  <div class="form_element cf_inputbox">
		    <label class="cf_label" style="width: 200px;">Birim</label>
		    <div id="birimlerDiv">
		    	<select class="required cf_label" style="width: 300px;" style="" id="birim_id" name="birim_id" onchange="">
		    	<option value="">Önce Yeterlilik Seçiniz</option>
		    	</select>
		    </div>	  
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		<div class="form_item">
		  <div class="form_element cf_inputbox">
		    <label class="cf_label" style="width: 200px;">Öğrenme Çıktısı</label>
		    <div id="ogrenmeCiktisiDiv">
		    	<select class="required cf_label" style="width: 300px;" style="" id="ogrenme_ciktisi_id" name="ogrenme_ciktisi_id" onchange="getBasarimOlcutu(jQuery(this).val());">
		    	<option value="">Önce Birim Seçiniz</option>
		    	</select>
		    </div>	  
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		<div class="form_item">
		  <div class="form_element cf_inputbox">
		    <label class="cf_label" style="width: 200px;">Başarım Ölçütü</label>
		    <div id="basarimOlcutuDiv">
		    	<select class="required cf_label" style="width: 300px;" style="" id="basarim_olcutu_id" name="basarim_olcutu_id">
		    	<option value="">Önce Öğrenme Çıktısı Seçiniz</option>
		    	</select>
		    </div>	  
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>	
	</div>

	<div id="eski_yeterlilik_formatiDiv">
	</div>
	
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">TÜRKAK Onaylı mı?</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="turkak_onayli_mi" name="turkak_onayli_mi">
			<option value=''>Hepsi</option>
   			<option value='1'>Evet</option>
   	    	<option value='2'>Hayır</option>
	    </select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Zorluk Derecesi</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="zorluk_derecesi_id" name="zorluk_derecesi_id">
		    <option value=''>Hepsi</option>
	    <?php
		foreach($zorlukDerecesi as $arr){
			echo "<option value='".$arr["ZORLUK_DERECESI_ID"]."'>".$arr["ZORLUK_DERECESI_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Soru Durumu</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="durum_id" name="durum_id" onchange="">
		<?php
		echo "<option value=''>Hepsi</option>";
		foreach($getPMSoruDurum as $durum){
			echo "<option value='".$durum["SORU_DURUM_ID"]."'>".$durum["SORU_DURUM_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Oluşturma Tarihi</label>
	    <input class="cf_inputbox required tarih" style="width: 137px;" title="" id="o_baslangic_tarihi" name="o_baslangic_tarihi" type="text" />
	    <label class="cf_label" style="">&nbsp;&nbsp;-</label>
	    <input class="cf_inputbox required tarih" style="width: 137px;" title="" id="o_bitis_tarihi" name="o_bitis_tarihi" type="text" />    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
			
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Sisteme Kayıt Tarihi</label>
	    <input class="cf_inputbox required tarih" style="width: 137px;" title="" id="s_baslangic_tarihi" name="s_baslangic_tarihi" type="text" />
	    <label class="cf_label" style="">&nbsp;&nbsp;-</label>
	    <input class="cf_inputbox required tarih" style="width: 137px;" title="" id="s_bitis_tarihi" name="s_bitis_tarihi" type="text" />    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Kuruluş Soru Kodu</label>
	    <input class="cf_inputbox required" style="width: 300px;" title="" id="kurulus_soru_kodu" name="kurulus_soru_kodu" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Soru Metni</label>
	    <input class="cf_inputbox required" style="width: 300px;" title="" id="soru_metni" name="soru_metni" type="text" />
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;"></label>
	    <input class="cf_inputbox" style="width: 100px;" title="" id="submit_button" name="submit_button" type="button" value="Ara" onclick="ara();" />
	    <!--input class="cf_inputbox" style="width: 100px;" title="" id="submit_button" name="submit_button" type="button" value="Ara" onclick="ara(jQuery('#sektor').val(),jQuery('#seviye').val(),jQuery('#yeterlilik_id').val(),jQuery('#birim_id').val(),jQuery('#ogrenme_ciktisi_id').val(),jQuery('#basarim_olcutu_id').val(),jQuery('#soru_metni').val());" /-->
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	</form>
	<div id="listeDiv" style="margin-top:20px;  font-size:10px;"></div>
<script>
soruTipiSec();
function ara(){
	jQuery("#listeDiv").html("<center><font color=red><b>Lütfen Bekleyiniz</b></font></center>");
	var url = 'index.php?option=com_itembank&task=ara&format=raw';
    postdata=jQuery("#soru_arama_formu").serialize();
    var seviyeIcerik="";
    var turkak="";
    var satirNo=0;
	jQuery.post(
        url,postdata, function(data) {
            if(data['success']){
                var gelenIcerik = data['array'];
                var adet = gelenIcerik.length;
                 icerik='<form id="listeForm">';
                for(var i=0;i<adet;i++){
                	satirNo++;
                	if (gelenIcerik[i]["TURKAK_ONAYLI_MI"]=="1"){
                    	turkak=" (TÜRKAK)";
                	}
                	icerik+='<div id="detayDiv'+satirNo+'" style="display:none; background-color:#ffffff; padding:5px; border: 1px dotted #000000">';
					icerik+='<b>K. Oluşturan:</b> '+gelenIcerik[i]["OLUSTURAN"]+'<br>';
					icerik+='<b>K. Onaylayan:</b> '+gelenIcerik[i]["ONAYLAYAN"]+'<br>';
					icerik+='<b>Kayıt Tarihi:</b> '+gelenIcerik[i]["KAYIT_TARIHI"]+'<br>';
					icerik+='<b>Son Güncelleyen:</b> '+gelenIcerik[i]["SON_GUNCELLEYEN_ID"]+'<br>';
					icerik+='<b>Son Güncelleme Tarihi:</b> '+gelenIcerik[i]["SON_GUNCELLEME_TARIHI"]+'<br>';
					
                	icerik+='</div>';
                    icerik +='<table cellspacing="1" bgcolor="#999999">'+
		                    '<thead><tr bgcolor="#dddddd">'+
		                    '<th style="padding:2px;">Kuruluş</th>'+
		                    '<th style="padding:2px;">Sektör</th>'+
		                    '<th style="padding:2px;">Yeterlilik</th>';
		                    //'<th style="padding:2px;">Birim</th>'+
		                    //'<th style="padding:2px;">Öğrenme Çıktısı</th>'+
		            if (gelenIcerik[i]["BASARIM_OLCUTU_ADI"]=="")
		            	icerik +='<th style="padding:2px;">Beceri Yetkinlik</th>';
		            else
			            icerik +='<th style="padding:2px;">Başarım Ölçütü</th>';	
			            
			        icerik +='<th style="padding:2px;">Durumu</th>'+
		                    '<th style="padding:2px;">O. Tarihi</th>'+
		                    '<th style="padding:2px;">Soru Tipi</th>'+
		                    '<th style="padding:2px;">Soru Şekli</th>'+
		                    '<th style="padding:2px;">İşlem</th>'+
		                    '<th style="padding:2px;">Seç</th>'+
		                    '</tr></thead><tbody>';
                	icerik=icerik+'<tr bgcolor="#ffffff">'

                	icerik=icerik + '<td style="padding:2px;">'+toTitleCase(gelenIcerik[i]["KURULUS_ADI"])+'</td>';
                	icerik=icerik + '<td style="padding:2px;" align="center">'+gelenIcerik[i]["SEKTOR_ADI"]+'</td>';
                	icerik=icerik + '<td style="padding:2px;" align="center">'+toTitleCase(gelenIcerik[i]["YETERLILIK_ADI"])+' (Seviye'+gelenIcerik[i]["SEVIYE_ID"]+')<br>'+gelenIcerik[i]["YETERLILIK_KODU"]+'</td>';
                	if (gelenIcerik[i]["BASARIM_OLCUTU_ADI"]==""){
                    //    icerik=icerik + '<td style="padding:2px;" align="center">'+(gelenIcerik[i]["YETERLILIK_ALT_BIRIM_ADI"])+'<br>'+gelenIcerik[i]["YETERLILIK_KODU"]+'-'+gelenIcerik[i]["YETERLILIK_ALT_BIRIM_NO"]+'</td>';                                       		
                		icerik=icerik + '<td style="padding:2px;" align="center">'+toTitleCase((gelenIcerik[i]["BECERI_YETKINLIK"]!=undefined)?gelenIcerik[i]["BECERI_YETKINLIK"]:'')+'</td>';
                    } else {
                		icerik=icerik + '<td style="padding:2px;" align="center">'+toTitleCase(gelenIcerik[i]["BASARIM_OLCUTU_ADI"])+'</td>';
                    	//icerik=icerik + '<td style="padding:2px;" align="center">'+(gelenIcerik[i]["BIRIM_ADI"])+'<br>'+gelenIcerik[i]["BIRIM_KODU"]+'</td>';                                       		
                	}
                	//icerik=icerik + '<td style="padding:2px;" align="center">'+toTitleCase(gelenIcerik[i]["OGRENME_CIKTISI_YAZISI"])+'</td>';
                	icerik=icerik + '<td style="padding:2px;" align="center">'+toTitleCase(gelenIcerik[i]["SORU_DURUM_ADI"])+turkak+'</td>';
                	icerik=icerik + '<td style="padding:2px;" align="center">'+gelenIcerik[i]["OLUSTURMA_TARIHI"]+'</td>';
                	icerik=icerik + '<td style="padding:2px;" align="center">'+gelenIcerik[i]["SORU_TIPI_ADI"]+'</td>';
                  	icerik=icerik + '<td style="padding:2px;" align="center">'+gelenIcerik[i]["SORU_SEKLI_ADI"]+'</td>';                                       		
                	icerik=icerik + '<td style="padding:2px;" align="center">';
    				icerik=icerik + '<a onclick="jQuery(\'#detayDiv'+satirNo+'\').lightbox_me({centered: true,});" style="cursor: pointer;">Detay</a><br>';
    				<?php 
    				if ($kullaniciTipi==2){ 
    					
    					?>icerik=icerik + '<a href=index.php?option=com_itembank&view=sorugirisi&soru_id='+gelenIcerik[i]["SORU_ID"]+'>Düzenle</a>';<?php 
					} 
					else 
					{ 
						?>if (gelenIcerik[i]["SORU_DURUM_ID"]==1 || gelenIcerik[i]["SORU_DURUM_ID"]==7)
						{ //İşlem yapılmamışsa ve Düzenleme durumundaysa
	               			icerik=icerik + '<a href=index.php?option=com_itembank&view=sorugirisi&soru_id='+gelenIcerik[i]["SORU_ID"]+'>Düzenle</a>';
		                }<?php 
					}?>

                	icerik=icerik + '</td>';
                    icerik=icerik + '<td align="center">';
    				
					<?php if ($kullaniciTipi==2){ ?>
                    	icerik=icerik + '<input type="checkbox" name="soruId[]" class="soruId" value="'+gelenIcerik[i]["SORU_ID"]+'">';
                	<?php } else { ?>
	                	if (gelenIcerik[i]["SORU_DURUM_ID"]==1){
	                		icerik=icerik + '<input type="checkbox" name="soruId[]" class="soruId" value="'+gelenIcerik[i]["SORU_ID"]+'">';
	                	}
                	<?php }?>
                    icerik=icerik + '</td>';
                    icerik=icerik + '</tr>';
					icerik+='<tr bgcolor="#ffffff"><td colspan=12>'+gelenIcerik[i]["icerik"]+'</td></tr>';   
					icerik=icerik+'</tbody></table><br>';               
                }
                icerik=icerik+'</form><center>';
				<?php	                
				if ($kullaniciTipi==2){
                
	                echo "icerik=icerik+'<select name=\"yeni_durum_id\" id=\"yeni_durum_id\" style=\"margin-top:20px;\">';";
	                foreach($getPMSoruDurum as $durum){
	                	echo "icerik=icerik+ '<option value=".$durum["SORU_DURUM_ID"].">".$durum["SORU_DURUM_ADI"]."</option>';\n";
	                }                
	                echo "icerik=icerik+'</select>';";
	                echo "icerik=icerik+'<input type=\"button\" value=\"Seçilenlerin Durumunu Değiştir\" onclick=\"durumDegistir();\" style=\"margin-top:20px;\">';";
                }
                if ($kullaniciTipi==1){
                ?>
                icerik=icerik+'<input type="button" value="Seçilenleri Sil" onclick="secilenleriSil();" style="margin-top:20px;">';
                <?php 
				}
				?>
                icerik=icerik+'<br><input type="button" value="Hepsini Seç" onclick="hepsiniSec(1)" style="margin-top:20px;">';
                icerik=icerik+'<input type="button" value="Hiçbirini Seçme" onclick="hepsiniSec(0)" style="margin-top:20px;"></center>';
                                                
                jQuery("#listeDiv").html(icerik);
            }else{
            	jQuery("#listeDiv").html("<center><font color=red><b>Seçtiğiniz kriterlerde soru bulunamadı</b></font></center>");
            
            }
    	},"json"
    );
}
		
jQuery( ".tarih" ).datepicker({ });
</script>