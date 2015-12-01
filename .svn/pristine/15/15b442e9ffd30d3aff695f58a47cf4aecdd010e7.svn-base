<?php
$ogrenmeCiktilari = $this->ogrenmeCiktilari;
//$basarimOlcutleri = $this->basarimOlcutleri;
//$baglamlar = $this->baglamlar;
?>
<div class="wrapper">
	<div class="form_item">
		<div class="form_element cf_heading">
			<h1 class="contentheading">Yeterlilik Öğrenme Çıktıları</h1>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<input type="hidden" id="birimID" name="birimID" value="<?php echo $this->birimID;?>" />

	<div class="form_item">
		<div class="sortable1">		
			<div class="ogrenme-ekle-button">
				<input type="submit" value="Öğrenme Çıktısı Ekle" name="ogrenme_ekle" class="ogrenme_ekle" />
			</div>
		
			<?php 
			if (!empty($ogrenmeCiktilari)){ 						//OGRENME CIKTILARI
				foreach($ogrenmeCiktilari as $ogrenmeCiktisi){				
					$ogrenmeID = $ogrenmeCiktisi ["OGRENME_CIKTISI_ID"];
					$ogrenmeAdi = $ogrenmeCiktisi ["OGRENME_CIKTISI_ADI"];
					$ogrenmeSiraNo = $ogrenmeCiktisi ["SIRA_NO"];
					$basarimOlcutleri = getBasarimOlcutByOgrenmeID ($ogrenmeID);
			?>
			<div class="ogrenme_ciktisi_wrapper">
				<div class="sort_button"></div>
				
				<div class="basarim-ekle-button">
					<input type="submit" value="Başarım Ölçütü Ekle" name="basarim_ekle" class="basarim_ekle" />
				</div>
			
				<div class="ogrenme_ciktisi">
					<div class="ui-icon ui-icon-minusthick ogrenme_expand_button"></div>
					<div class="siraNo"><?php echo $ogrenmeSiraNo;?>.</div>
					<div class="ogrenme_input ogrenme_input_click"><?php echo $ogrenmeAdi;?></div>
					<div class="cfclear">&nbsp;</div>
				</div>

				<div class="sortable2">						
					<?php
					if (!empty($basarimOlcutleri)){ 				//BASARIM OLCUTLERI
						foreach($basarimOlcutleri as $basarimOlcutu){
							$basarimID = $basarimOlcutu ["BASARIM_OLCUTU_ID"];
							$basarimAdi = $basarimOlcutu ["BASARIM_OLCUTU_ADI"];
							$basarimSiraNo = $ogrenmeSiraNo.".".$basarimOlcutu ["SIRA_NO"];
							$baglamlar = getBaglamByBasarimID ($basarimID);
					?>
					<div class="basarim_olcutu_wrapper">
						<div class="sort_button"></div>
						<div class="basarim_olcutu">
							<div class="siraNo"><?php echo $basarimSiraNo;?>.</div>
							<div class="ogrenme_input basarim_input_click"><?php echo $basarimAdi;?></div>
							<input type="hidden" name="basarim_olcutu_id[]" value="<?php echo $basarimID; ?>" />
							<div class="cfclear">&nbsp;</div>
						</div>
							<?php
							if (!empty($baglamlar)){ 				//BAGLAMLAR
								foreach($baglamlar as $baglam){
									$baglamID = $baglam ["BAGLAM_ID"];
									$baglamAdi = $baglam ["BAGLAM_ADI"];
							?>
						<div class="baglam">
							<div class="siraNo"><?php echo $basarimSiraNo;?>.</div>
							<div class="ogrenme_input baglam_input_click"> <?php echo $baglamAdi;?></div>
							<input type="hidden" name="baglam_id[]" value="<?php echo $baglamID; ?>"/>
							<div class="cfclear">&nbsp;</div>
						</div>
							<?php
								}
							}
							?>
						
						<a href="" class="baglam_ekle"><div class="baglam_ekle_button"></div> Bağlam Ekle</a>
						<div class="cfclear">&nbsp;</div>
					</div>
					<?php
						}
					}
					?>
					<div class="cfclear">&nbsp;</div>
					
				</div>
				
				<div class="submit_button_bo">
					<input type="submit" value="Başarım Ölçütü Sırası Kaydet"
						name="bo-sira-kaydet" id="bo-sira-kaydet" />
				</div>

				<div class="ogrenme-ciktisi-id">
					<input type="hidden" name="ogrenme_ciktisi_id[]" value="<?php echo $ogrenmeID; ?>" />
				</div>
				
				<div class="cfclear">&nbsp;</div>
			</div>
		<?php
			}
		}
		?>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="submit_button_oc">
		<input type="submit" value="Öğrenme Çıktısı Sırası Kaydet"
			name="oc-sira-kaydet" id="oc-sira-kaydet" />
	</div>

	<div class="cfclear">&nbsp;</div>
</div>

<div id="dialog-confirm" title="<?php echo JText::_("DELETE_CONFIRM_TITLE");?>">
	<p>
		<span class="ui-icon ui-icon-alert"	style="float: left; margin: 0 7px 20px 0;"></span>
		<?php echo JText::_("DELETE_CONFIRM_TEXT");?>
	</p>
</div>

<?php 

function getBasarimOlcutByOgrenmeID ($ogrenmeID){
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT 	BASARIM_OLCUTU_ID,
					OGRENME_CIKTISI_ID,
					BASARIM_OLCUTU_ADI,
					SIRA_NO
			FROM M_YETERLILIK_BIRIM_BASARIM_OLC 
			WHERE OGRENME_CIKTISI_ID = ?
				ORDER BY SIRA_NO";

	$params = array ($ogrenmeID);
	return $db->prep_exec($sql, $params);
}

function getBaglamByBasarimID ($basarimID){
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT 	BAGLAM_ID,
					BASARIM_OLCUTU_ID,
					BAGLAM_ADI,
					SIRA_NO
			FROM M_YETERLILIK_BIRIM_BAGLAM 
			WHERE BASARIM_OLCUTU_ID = ?
				ORDER BY BAGLAM_ID";

	$params = array ($basarimID);
	return $db->prep_exec($sql, $params);
}

?>