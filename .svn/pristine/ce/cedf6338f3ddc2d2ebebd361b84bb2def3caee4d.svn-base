<?php 
$model = &$this->getModel("sorugirisi");
$sektorler=$model->getSektorler();
$soruTipi=$model->getSoruTipi();
$zorlukDerecesi=$model->getZorlukDerecesi();
$teorikSoruSekli=$model->getTeorikSoruSekli();
$performansSoruSekli=$model->getPerformansSoruSekli();
$title="Soru Girişi";

if ($_GET["soru_id"]!=""){
	$title="Soru Güncelleme";
	$soru=$model->getSoruDetay();
	$seviyeler=seviyeFromSektor($soru["sektor"]);
	$yeterlilikler=yeterliliklerFromSektorSeviye($soru["sektor"],$soru["seviye"]);
}
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading"><?php  echo $title;?></h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<form
	enctype="multipart/form-data"
	id="ChronoContact_soru_kayit_formu"
	name="ChronoContact_soru_kayit_formu"
	method="post">
<input type="hidden" name="soru_id" id="soru_id" value="<?php echo $soru["soru"]["SORU_ID"];?>">



<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Sektör</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="sektor" name="sektor" onchange="getSeviye();">
		<?php
		echo "<option value=''>Sektör Seçiniz</option>";
		foreach($sektorler as $sektor){
			echo "<option value='".$sektor["SEKTOR_ID"]."'";
			if ($soru["sektor"]==$sektor["SEKTOR_ID"]){echo " selected";}
			echo ">".$sektor["SEKTOR_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Seviye</label>
	    <div id="seviyeDiv">
		    <select class="cf_inputbox required" style="width: 300px;" id="seviye" name="seviye" onchange="getYeterlilikler();">
			<?php
			echo "<option value=''>Önce Sektör Seçiniz</option>";
			foreach($seviyeler as $arr){
				echo "<option value='".$arr["SEVIYE_ID"]."'";
				if ($soru["seviye"]==$arr["SEVIYE_ID"]){echo " selected";}
				echo ">Seviye ".$arr["SEVIYE_ID"]."</option>";
			}
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
	    	<select class="required cf_label" style="width: 300px;" style="" id="yeterlilik_id" name="yeterlilik_id" onchange="eskiYeniTeorikPerformans();">
	    	<option value="">Sektör ve Seviye Seçiniz</option>
	    	<?php 
			foreach($yeterlilikler as $arr){
				echo "<option value='".$arr["YETERLILIK_ID"]."-".$arr["YENI_MI"]."'";
				if ($soru["soru"]["YETERLILIK_ID"]==$arr["YETERLILIK_ID"]){echo " selected";}
				echo ">".$arr["YETERLILIK_ADI"]."</option>";
			}
			?>
	    	</select>
	    </div>	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Teorik/Performans</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="soru_grubu_id" name="soru_grubu_id" onchange="eskiYeniTeorikPerformans(); soruTipiSec();">
		<?php
		foreach($soruTipi as $arr){
			echo "<option value='".$arr["SORU_TIPI_ID"]."'";
			if ($arr["SORU_TIPI_ID"]==$soru["soru"]["SORU_TIPI_ID"]){echo " selected";}
			echo ">".$arr["SORU_TIPI_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div id="yeni_yeterlilik_formatiDiv">
	</div>

	<div id="eski_yeterlilik_formatiDiv">
	</div>
		
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Kuruluş Soru Kodu</label>
	    <input class="cf_inputbox required" style="width: 300px;" title="" id="kurulus_soru_kodu" name="kurulus_soru_kodu" type="text" value="<?php echo $soru["soru"]["KURULUS_SORU_KODU"];?>"/>
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Oluşturan</label>
	    <input class="cf_inputbox required" style="width: 300px;" title="" id="olusturan" name="olusturan" type="text"  value="<?php echo $soru["soru"]["OLUSTURAN"];?>"/>
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
		<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Onaylayan</label>
	    <input class="cf_inputbox required" style="width: 300px;" title="" id="onaylayan" name="onaylayan" type="text"  value="<?php echo $soru["soru"]["ONAYLAYAN"];?>"/>
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;" name="yetkili_title">Oluşturma Tarihi</label>
	    <input class="cf_inputbox required tarih" style="width: 300px;" title="" id="olusturma_tarihi" name="olusturma_tarihi" type="text"  value="<?php echo $soru["soru"]["OLUSTURMA_TARIHI"];?>"/>
	  
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">TÜRKAK Onaylı mı?</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="turkak_onayli_mi" name="turkak_onayli_mi">
			<option value='1'<?php if ($soru["soru"]["TURKAK_ONAYLI_MI"]==1){echo " selected";}?>>Evet</option>
	    	<option value='2'<?php if ($soru["soru"]["TURKAK_ONAYLI_MI"]==2){echo " selected";}?>>Hayır</option>
	    </select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;">Zorluk Derecesi</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="zorluk_derecesi_id" name="zorluk_derecesi_id">
		<?php
		foreach($zorlukDerecesi as $arr){
			echo "<option value='".$arr["ZORLUK_DERECESI_ID"]."'";
			if ($arr["ZORLUK_DERECESI_ID"]==$soru["soru"]["ZORLUK_DERECESI_ID"]){echo " selected";}
			echo ">".$arr["ZORLUK_DERECESI_ADI"]."</option>";
		}
		?>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div id="teorikSoruTipiDiv">		

			
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Teorik Soru Tipi</label>
		    <select class="cf_inputbox required" style="width: 300px;" id="soru_tipi_id" name="soru_tipi_id" onchange="teorikSoruTipi(<?php echo $kayitliTeorikSoruTipi;?>);">
			<?php
			foreach($teorikSoruSekli as $arr){
				echo "<option value='".$arr["SORU_SEKLI_ID"]."'";
				if ($arr["SORU_SEKLI_ID"]==$soru["soru"]["SORU_SEKLI_ID"] and $soru["soru"]["SORU_TIPI_ID"]==1){echo " selected";}
				echo ">".$arr["SORU_SEKLI_ADI"]."</option>";
			}
			?>
			</select>
		    
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	</div>
	<div id="teorikSoruTipiDiv2" style="padding-top:5px; margin-top:10px; padding-bottom:10px;border:1px solid #aaaaaa; width:580px; background-color:#cccccc">		

		<div class="form_item" id="teorikDigerDiv" style="display:none;">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Diğer Açıklaması</label>
		    <input class="cf_inputbox" style="width: 300px;" title="" id="diger_aciklama" name="diger_aciklama" type="text" value="<?php 
		    echo  $soru["soru"]["DIGER_ACIKLAMA"];
		    ?>"/>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		
				
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Soru Puanı</label>
		    <input class="cf_inputbox textclass" style="width: 300px;" title="" id="soru_puani" name="soru_puani" type="text" value="<?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==1 and $soru["soru"]["PUANI"]!=0){
		    	echo  $soru["soru"]["PUANI"];
		    }?>"/>
		  	<input type="checkbox" class="cf_inputbox checkclass" name="esit_puanli" value="1" style="width:20px;height:20px;" onclick="if (jQuery(this).attr('checked')=='checked'){jQuery('#soru_puani').attr('disabled','disabled');}else{jQuery('#soru_puani').removeAttr('disabled');}" <?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==1 and $soru["soru"]["PUANI"]==0){
		    	echo  " checked";
		    }?>><label class="cf_label">Eşit puanli (100/Soru sayısı)</label>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		
		<div class="form_item">
		  <div class="form_element cf_textbox" style="width: 100%; float:left">
		    <label class="cf_label">Soru Metni</label>
		  </div>
		  <div class="form_element cf_textbox" style="float: left;">
		    <textarea class="cf_inputbox textareaclass" style="width: 510px; height:200px;" title="" id="soru_metni" name="soru_metni"><?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==1){
		    	echo  $soru["soru"]["SORU_METNI"];
		    }?></textarea>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Soru Görseli (jpg veya png)</label>
		    <?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==1){
		    	if($soru["soru"]["SORU_GORSELI_PATH"]==""){
		    		?>
    				<input class="cf_inputbox dosya" style="width: 300px;" title="" id="soru_gorsel" name="soru_gorsel" type="file" />
    				<?php    				    		
		    	} else {
		    		?>
		    		<input type="hidden" name="soru_gorseli_degisti" id="soru_gorseli_degisti" value=0>
					<input type="hidden" name="soru_gorseli_silindi" id="soru_gorseli_silindi" value=0>
					<div id="soruGorseliDiv">
					<a href=index.php?dl=<?php echo $soru["soru"]["SORU_GORSELI_PATH"];?>>İndir</a>
					<span onclick="dosyaislem('soru_gorseli_degisti','soruGorseliDiv','<input class=\'cf_inputbox dosya\' style=\'width: 300px;\' id=\'soru_gorsel\' name=\'soru_gorsel\' type=\'file\' />');">Değiştir</span>
					<span onclick="dosyaislem('soru_gorseli_silindi','soruGorseliDiv','');">Sil</span>
					</div>
					
					<?php 
		    	}
		    } else {
			?>
		    <input class="cf_inputbox dosya" style="width: 300px;" title="" id="soru_gorsel" name="soru_gorsel" type="file" />
		    <?php 
		    }
		    ?>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		
			
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Soru Dosyası (doc/pdf vs.)</label>
		    <?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==1){
		    	if($soru["soru"]["SORU_DOKUMANI_PATH"]==""){
		    		?>
    				<input class="cf_inputbox dosya" style="width: 300px;" title="" id="soru_dosya" name="soru_dosya" type="file" />
    				<?php    				    		
		    	} else {
		    		?>
		    		<input type="hidden" name="soru_dosyasi_degisti" id="soru_dosyasi_degisti" value=0>
					<input type="hidden" name="soru_dosyasi_silindi" id="soru_dosyasi_silindi" value=0>
					<div id="soruDosyasiDiv">
					<a href=index.php?dl=<?php echo $soru["soru"]["SORU_DOKUMANI_PATH"];?>>İndir</a>
					<span onclick="dosyaislem('soru_dosyasi_degisti','soruDosyasiDiv','<input class=\'cf_inputbox dosya\' style=\'width: 300px;\' id=\'soru_dosya\' name=\'soru_dosya\' type=\'file\' />');">Değiştir</span>
					<span onclick="dosyaislem('soru_dosyasi_silindi','soruDosyasiDiv','');">Sil</span>
					</div>
					
					<?php 
		    	}
		    } else {
			?>
		    <input class="cf_inputbox dosya" style="width: 300px;" title="" id="soru_dosya" name="soru_dosya" type="file" />
		    <?php 
		    }
		    ?>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>

		<div id="cevapDiv">
		</div>		
				
	</div>		
		
		
	<div id="performansSoruTipiDiv" style="display:none;">		

			
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Performans Soru Tipi</label>
		    <select class="cf_inputbox required" style="width: 300px;" id="soru_tipi_id_p" name="soru_tipi_id_p">
			<?php
			foreach($performansSoruSekli as $arr){
				echo "<option value='".$arr["SORU_SEKLI_ID"]."'";
				if ($arr["SORU_SEKLI_ID"]==$soru["soru"]["SORU_SEKLI_ID"] and $soru["soru"]["SORU_TIPI_ID"]==2){echo " selected";}
				echo ">".$arr["SORU_SEKLI_ADI"]."</option>";
			}
			?>
			</select>
		    
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	</div>
	<div id="performansSoruTipiDiv2" style="display:none;padding-top:5px; margin-top:10px; padding-bottom:10px;border:1px solid #aaaaaa; width:580px; background-color:#cccccc">		
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Soru Puanı</label>
		    <input class="cf_inputbox textclass" style="width: 300px;" title="" id="soru_puani_p" name="soru_puani_p" type="text" value="<?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==2 and $soru["soru"]["PUANI"]!=0){
		    	echo  $soru["soru"]["PUANI"];
		    }?>"/>
		  	<input type="checkbox" class="cf_inputbox checkclass" name="esit_puanli_p" value="1" style="width:20px;height:20px;"><label class="cf_label">Eşit puanli (100/Soru sayısı)</label>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		
		<div class="form_item">
		  <div class="form_element cf_textbox" style="width: 100%; float:left">
		    <label class="cf_label">Soru Metni</label>
		  </div>
		  <div class="form_element cf_textbox" style="float: left;">
		    <textarea class="cf_inputbox textareaclass required" style="width: 510px; height:200px;" title="" id="soru_metni_p" name="soru_metni_p"><?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==2){
		    	echo  $soru["soru"]["SORU_METNI"];
		    }?></textarea>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Soru Dosyası (image/pdf vs.)</label>
		    <?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==2){
		    	if($soru["soru"]["SORU_DOKUMANI_PATH"]==""){
		    		?>
    				<input class="cf_inputbox dosya" style="width: 300px;" title="" id="soru_dosya_p" name="soru_dosya_p" type="file" />
    				<?php    				    		
		    	} else {
		    		?>
		    		<input type="hidden" name="soru_dosyasi_p_degisti" id="soru_dosyasi_p_degisti" value=0>
					<input type="hidden" name="soru_dosyasi_p_silindi" id="soru_dosyasi_p_silindi" value=0>
					<div id="soruDosyasiPDiv">
					<a href=index.php?dl=<?php echo $soru["soru"]["SORU_DOKUMANI_PATH"];?>>İndir</a>
					<span onclick="dosyaislem('soru_dosyasi_p_degisti','soruDosyasiPDiv','<input class=\'cf_inputbox dosya\' style=\'width: 300px;\' id=\'soru_dosya_p\' name=\'soru_dosya_p\' type=\'file\' />');">Değiştir</span>
					<span onclick="dosyaislem('soru_dosyasi_p_silindi','soruDosyasiPDiv','');">Sil</span>
					</div>
					
					<?php 
		    	}
		    } else {
			?>
		    <input class="cf_inputbox dosya" style="width: 300px;" title="" id="soru_dosya_p" name="soru_dosya_p" type="file" />
		    <?php 
		    }
		    ?>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		
		<div class="form_item" id="cevapPerformans">
		  <div class="form_element cf_textbox" style="width: 100%; float:left;">
		    <label class="cf_label">Cevap</label>
		  </div>
		  <div class="form_element cf_textbox" style="float: left;">
		    <textarea class="cf_inputbox textareaclass required" style="width: 510px; height:200px;" title="" id="cevap_metni_p" name="cevap_metni_p"><?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==2){
		    	echo  $soru["cevap"][0]["CEVAP_METNI"];
		    }?></textarea>
		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
	
		<div class="form_item">
		  <div class="form_element cf_textbox">
		    <label class="cf_label" style="width: 200px;">Cevap Dosyası (image/pdf vs.)</label>
		    <?php 
		    if ($soru["soru"]["SORU_TIPI_ID"]==2){
		    	if($soru["cevap"][0]["CEVAP_DOSYA_PATH"]==""){
		    		?>
    				<input class="cf_inputbox dosya" style="width: 300px;" title="" id="cevap_dosya_p" name="cevap_dosya_p" type="file" />
    				<?php    				    		
		    	} else {
		    		?>
		    		<input type="hidden" name="cevap_dosyasi_p_degisti" id="soru_dosyasi_p_degisti" value=0>
					<input type="hidden" name="cevap_dosyasi_p_silindi" id="soru_dosyasi_p_silindi" value=0>
					<div id="cevapDosyasiPDiv">
					<a href=index.php?dl=<?php echo $soru["cevap"][0]["CEVAP_DOSYA_PATH"];?>>İndir</a>
					<span onclick="dosyaislem('cevap_dosyasi_p_degisti','cevapDosyasiPDiv','<input class=\'cf_inputbox dosya\' style=\'width: 300px;\' id=\'cevap_dosya_p\' name=\'cevap_dosya_p\' type=\'file\' />');">Değiştir</span>
					<span onclick="dosyaislem('cevap_dosyasi_p_silindi','cevapDosyasiPDiv','');">Sil</span>
					</div>
					
					<?php 
		    	}
		    } else {
			?>
		    <input class="cf_inputbox dosya" style="width: 300px;" title="" id="cevap_dosya_p" name="cevap_dosya_p" type="file" />
		    <?php 
		    }
		    ?>
		    		  </div>
		  <div class="cfclear">&nbsp;</div>
		</div>
		
		
	</div>		
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;"></label>
	    <input class="cf_inputbox" style="width: 100px;" title="" id="submit_button" name="submit_button" type="button" value="<?php echo ($_GET['soru_id']!='')?'Güncelle':'Kaydet' ?>" onclick="return validate('ChronoContact_soru_kayit_formu');" />
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	

		
</form>
<div id="icerik" style="font-size: 8px;"></div>
<?php 
function seviyeFromSektor($sektorId){
    	$db = JFactory::getOracleDBO();
    
    	$sql = "SELECT DISTINCT seviye_id 
    			FROM m_yeterlilik 
    			WHERE sektor_id=? 
    			AND yeterlilik_durum_id=?
    			ORDER BY seviye_id";
    
    	$result= $db->prep_exec($sql, array($sektorId,PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK));
		return $result;

}
function yeterliliklerFromSektorSeviye($sektor,$seviye){
	$db = JFactory::getOracleDBO();
	$sql = "SELECT yeterlilik_id,yeterlilik_adi,yeni_mi
	FROM m_yeterlilik
	WHERE seviye_id=?
	AND sektor_id=?
	AND yeterlilik_durum_id=?";
	
	$result= $db->prep_exec($sql, array($seviye,$sektor,PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK));
	return $result;	
}
function birimlerFromYeterlilik($yeterlilik_id){
	$db = JFactory::getOracleDBO();
	
	$sql = "SELECT yeni_mi
	FROM m_yeterlilik
	WHERE yeterlilik_id=?";	
	$result= $db->prep_exec_array($sql, array($yeterlilik_id));
	
	if ($result[0]==1){
		$sql="SELECT birim_id, birim_adi
		FROM m_birim
		JOIN m_yeterlilik_birim USING (birim_id)
		WHERE yeterlilik_id=?";
	} else {
		$sql="SELECT yeterlilik_alt_birim_id AS birim_id, yeterlilik_alt_birim_adi AS birim_adi
		FROM m_yeterlilik_alt_birim
		WHERE yeterlilik_id=?";
	}	 
	$result= $db->prep_exec($sql, array($yeterlilik_id));
	
	return $result;
}

function ogrenmeCiktilariFromBirim($birim){
	$db = JFactory::getOracleDBO();

	$sql = "SELECT ogrenme_ciktisi_id,ogrenme_ciktisi_yazisi
	FROM m_ogrenme_ciktisi
	JOIN m_birim__ogrenme_ciktisi USING (ogrenme_ciktisi_id)
	WHERE birim_id=?";

	$result= $db->prep_exec($sql, array($birim));
	return $result;
}

function basarimOlcutleriFromOgrenmeCiktilari($ogrenmeCiktisi){
	$db = JFactory::getOracleDBO();
	
    	$sql = "SELECT basarim_olcutu_id,basarim_olcutu_adi
    	FROM m_basarim_olcutu
    	JOIN m_ogrenme_ciktisi__basarim_olc USING (basarim_olcutu_id)
    	WHERE ogrenme_ciktisi_id=?";
		
	$result= $db->prep_exec($sql, array($ogrenmeCiktisi));
	return $result;
}
?>



<script>
function secenekEkle (id,text,sorudosya,dogru){
	window.i=window.i+1;
	if (id==undefined){
		id="";
	}
			
	if (text==undefined){
		text="";
	}
			
	if (sorudosya==undefined){
		sorudosya="";
	}
			
	if (dogru==undefined){
		dogru="";
	}
			
		var tipId=jQuery("#soru_tipi_id").val();
	var num="";
	var dogruMu="";
	if (dogru){
		dogruMu=" checked";
	}

	var dogru='<label class="cf_label">Doğru</label>'+
				'<input type="checkbox" class="cf_inputbox checkclass"  style="width:22px;height:22px;" name="dogrucevap['+window.i+']" value="1"'+dogruMu+'>'+
			'</td><td rowspan=2>';
	var dosya='</td></tr><tr><td>';
		    	if(sorudosya==""){
		    		dosya+='<input class="cf_inputbox dosya" style="width: 300px;" title="" id="cevap_file" name="cevap_file['+window.i+']" type="file" />';
		    	} else {
		    		dosya+='<input type="hidden" name="cevap_dosyasi_p_degisti['+window.i+']" id="soru_dosyasi_p_degisti-'+window.i+'" value=0>';
		    		dosya+='<input type="hidden" name="cevap_dosyasi_p_silindi['+window.i+']" id="soru_dosyasi_p_silindi-'+window.i+'" value=0>';
		    		dosya+='<div id="cevapFile-'+window.i+'">';
					dosya+='<input type=button  onclick="window.location.href=\'index.php?dl='+sorudosya+'\'" value="Dökümanı İndir">&nbsp;&nbsp;&nbsp;';
					dosya+='<input type=button onclick=\'dosyaislem("soru_dosyasi_p_degisti-'+window.i+'",   "cevapFile-'+window.i+'",   "<input type=file name=cevap_file['+window.i+'] id=cevap_file>")\' value="Dökümanı Değiştir">';
					dosya+='<input type=button onclick=\'dosyaislem("soru_dosyasi_p_silindi-'+window.i+'",   "cevapFile-'+window.i+'",   "")\' value="Dökümanı Sil">';
					dosya +='</div>';
					//			dosya+=' <input class="cf_inputbox dosya" style="width: 300px;" title="" id="cevap_dosya_p" name="cevap_dosya_p" type="file" />';
		    	}

		    	if (tipId==6){
		    		dogru="";
		    		dosya="";
		    		num='<div class="klasikCevapInput">'+(jQuery(".klasikcevap").length+1)+'</div></td><td>';
		    	}
		    	
		    	if (tipId==5){
		    		dogru="";
		    	}
		    	
		    		    	
	var satir='<div class="form_item klasikcevap" style="border:1px dotted; width:505px; margin-left:30px; margin-bottom:5px;">'+
		'<div class="form_element cf_textbox">'+
		'<table cellepadding=0 cellspcing=0><tr><td>'+num+
    	'<input class="cf_inputbox textclass" style="width: 350px;" title="" id="cevap_metni" name="cevap_metni['+window.i+']" type="text" value="'+text+'"/>'+
    	'</td><td rowspan=2>'+
    	dogru+
    	'<input type="button" class="silButon"value="Sil" onclick="silCevap(this);">'+
    	dosya+
    	'</td></tr></table>'+
	  	'</div>'+
  	'<div class="cfclear">&nbsp;</div>'+
	'</div>';
	if(jQuery(".klasikcevap").length != 0)
		jQuery(
				jQuery(".klasikcevap")[jQuery(".klasikcevap").length-1]
				).after(satir);
	else ///yani sade cevap 0 var
		jQuery('#cevap-0').after(satir);

}


function teorikSoruTipi(){
//	alert (jQuery("#soru_tipi_id").val()+' ');
	var tipId=jQuery("#soru_tipi_id").val();
	var metin='Yeni Seçenek Ekle';

	if (tipId==6){
		metin="Yeni İfade Ekle"
	}
	var cevapCoktan ='<div class="form_item" id="cevap-0">'
							+'<div class="form_element cf_textbox" style="width: 100%; float:left;">'
								+'<label class="cf_label">Cevap</label><input type="button" value="'+metin+'" id="secenekEkleButon" onclick="secenekEkle();">'
							+'</div>'
							+'<div class="cfclear">&nbsp;</div>'
						+'</div>';

	var cevapEvetHayir='<div class="form_item" id="cevap-1-a">'
						  +'<div class="form_element cf_textbox" style="width: 100%; float:left;">'
							  +'<label class="cf_label" style="width: 200px;">Cevap</label>'
							  +'<label class="cf_label">Evet</label><input name="cevap_metni[0]" type="radio" class="radioclass" style="margin-right:50px" value="1"<?php if ($soru["cevap"][0]["CEVAP_METNI"]==1){echo " checked";}?>>'
							  +'<label class="cf_label">Hayır</label><input name="cevap_metni[0]" type="radio" class="radioclass" value="2"<?php if ($soru["cevap"][0]["CEVAP_METNI"]==2){echo " checked";}?>>'
						  +'</div>'
						  +'<div class="cfclear">&nbsp;</div>'
					  +'</div>';

	var cevapDogruYanlis='<div class="form_item" id="cevap-1-a">'
							  +'<div class="form_element cf_textbox" style="width: 100%; float:left;">'
								  +'<label class="cf_label" style="width: 200px;">Cevap</label>'
								  +'<label class="cf_label">Doğru</label><input name="cevap_metni[0]" type="radio" class="radioclass" style="margin-right:50px" value="1"<?php if ($soru["cevap"][0]["CEVAP_METNI"]==1){echo " checked";}?>>'
								  +'<label class="cf_label">Yanlış</label><input name="cevap_metni[0]" type="radio" class="radioclass" value="2"<?php if ($soru["cevap"][0]["CEVAP_METNI"]==2){echo " checked";}?>>'
							  +'</div>'
							  +'<div class="cfclear">&nbsp;</div>'
						  +'</div>';
	
	var cevapAcikUclu='<div class="form_item" id="cevap-2">'
							 +'<div class="form_element cf_textbox" style="width: 100%; float:left;">'
							 	+'<label class="cf_label">Cevap</label>'
							 +'</div>'
							 +'<div class="form_element cf_textbox" style="float: left;">'
							 	+'<textarea class="cf_inputbox textareaclass" style="width: 510px; height:200px;" title="" id="cevap_metni" name="cevap_metni[0]"></textarea>'
							 +'</div>'
							 +'<div class="cfclear">&nbsp;</div>'
						+'</div>';
	
	
	if (tipId==8){
		jQuery("#teorikDigerDiv").show();
	} else {
		jQuery("#teorikDigerDiv").hide();
	}
	
	if (tipId=="" || tipId==1 || tipId==2|| tipId==5|| tipId==6){
		jQuery("#cevapDiv").html(cevapCoktan);
		<?php 
		if ($soru["soru"]["SORU_TIPI_ID"]!=1){
			echo "secenekEkle ();";
		} else {
			if ($soru["soru"]["SORU_SEKLI_ID"]==1 or $soru["soru"]["SORU_SEKLI_ID"]==2 or $soru["soru"]["SORU_SEKLI_ID"]==5 or $soru["soru"]["SORU_SEKLI_ID"]==6){
				foreach($soru["cevap"] as $arr){
					$satir = "secenekEkle (".$arr["CEVAP_ID"].",'".$arr["CEVAP_METNI"]."','".$arr["CEVAP_DOSYA_PATH"]."',".($arr["DOGRU_MU"]?$arr["DOGRU_MU"]:"0").");\n";
					echo $satir;
				}
			}
		}
		
		?>
	}
	
	if (tipId==4){
		jQuery("#cevapDiv").html(cevapEvetHayir);
	}
	
	if (tipId==3){
		jQuery("#cevapDiv").html(cevapDogruYanlis);
	}
	
	
	if (tipId==7 || tipId==8){
		jQuery("#cevapDiv").html(cevapAcikUclu);
		jQuery("#cevap_metni").val('<?php echo ereg_replace("\r\n","<br>",$soru["cevap"][0]["CEVAP_METNI"]);?>');
		str=jQuery("#cevap_metni").val();
		jQuery("#cevap_metni").val(str.replace(/<br>/gi, '\n'));
	}
	
}




jQuery( ".tarih" ).datepicker({ });
teorikSoruTipi();
soruTipiSec();
function validate(form){
	var x = true;
	jQuery("#ChronoContact_soru_kayit_formu select").filter(':visible').filter(".required").each(function(e){
		if (jQuery(this).val()==""){
			x = false;
			jQuery(this).css("border","1px red solid");
			jQuery("#icerik").html("<div id='mesaj'><font color=red><b>Zorunlu alanları doldurmalısınız.</b></font></div>");
			jQuery("#mesaj").hide(2500);
						
		}
	});
	jQuery("#ChronoContact_soru_kayit_formu input,#ChronoContact_soru_kayit_formu textarea").filter(':visible').filter(".required").each(function(e){
		if (jQuery(this).val()==""){
			x = false;
			jQuery(this).css("border","1px red solid");
			jQuery("#icerik").html("<div id='mesaj'><font color=red><b>Zorunlu alanları doldurmalısınız.</b></font></div>");
			jQuery("#mesaj").hide(2500);
						
		}
	});
//	x=true;
	if (x==true){
		kayitPost(form);
	}
	return x;
	
}
</script>
		
<?php 
if ($_GET["soru_id"]!=""){
	if ($soru['yeterlilik_yeni_mi']==1){
		$birimler=birimlerFromYeterlilik($soru["soru"]["YETERLILIK_ID"]);
		$ogrenmeCiktilari=ogrenmeCiktilariFromBirim($soru["soru"]["BIRIM_ID"]);
		$basarimOlcutleri=basarimOlcutleriFromOgrenmeCiktilari($soru["soru"]["OGRENME_CIKTISI_ID"]);
	} else {
		$beceri_yetk = $soru['beceri_yetkinlik'];
		echo '<script>eskiYeniTeorikPerformans(['.implode(',', $beceri_yetk).']);</script>';
	}
}	
	?>		