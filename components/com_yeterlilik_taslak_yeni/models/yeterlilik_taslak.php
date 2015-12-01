<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_TaslakModelYeterlilik_Taslak extends JModel {

	var $pages 		= array ("tanitim", "yeterlilik_kaynagi", "yeterlilik_sartlari", "yeterliligin_yapisi", "olcme_ve_degerlendirme", "aciklama", "ek_1", "ek_2", "ek_3", "ek_4", "ek_5", "ek_6", "ek_8", "ek_9", "birimler","alternatif"); 
	var $pageNames 	= array ("Tanıtım", "Yeterlilik Kaynağı", "Yeterlilik Şartları", "Yeterliliğin Yapısı", "Ölçme ve Değerlendirme", "Açıklama", "EK 1", "EK 2", "EK 3", "EK 4", "EK 5", "EK 6", "EK 8", "EK 9", "Birimler","Gruplandırma Alternatifleri");
	var $sayfalarZorunluMu 	= array ("1", 		"1", 				"1", 					"1", 					"1", 				"1", 		"0", 	"1", 	"1", 	"1", 	"1", 	"1", 	"1", 	"1", 	"1");
	
	function getPageTree ($user, $activeLayout, $evrak_id, $yeterlilik_id, $taslak = 0){
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu($user);
		$activeStyle = 'style="float:left; background-color:#b30000; color:white; padding:1px; margin: 1px;"';
		
		$sayfa = count ($this->pages);
		$saved = $this->getSavedPages ($evrak_id, $yeterlilik_id);
		
		$yeterlilikData = $this->getYeterlilikInfo($yeterlilik_id);
		
		$yeterlilikDurumuPM = $yeterlilikData[0]["YETERLILIK_DURUM_ADI"];
		$yeterlilikSurecDurumuPM = $yeterlilikData[0]["YETERLILIK_SUREC_DURUM_ADI"];
		
		$tree = "<div style='font-size:22px; float: left; width:99%; font-size: 1em; font-weight: normal; line-height: normal; font-family: Arial,Helvetica,sans-serif; margin-left:50px; '>
		<big><b>Yeterliliğin:</b></big>
		<br><b>Adı-Seviyesi:</b> ".$yeterlilikData[0]["YETERLILIK_ADI"]." - Seviye ".$yeterlilikData[0]["SEVIYE_ID"]." - Revizyon ".$yeterlilikData[0]["REVIZYON"]."
		<br><b>Durumu:</b> ".$yeterlilikDurumuPM."
		
		</div>";
		
		$tree .= '<div class="form_element" style="width:95%; text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		$inp = '<input style="float:left; padding:5px; margin: 5px;" type="button" ';
		$inpClosure = ' />';
		$value	 = "";
		$onClick = "";
		$disabled= "";
			$yeterlilikDurumID = $this->getYeterlilikDurumId ($yeterlilik_id);		
		
		if ($isSektorSorumlusu){
			if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK)
			{ 
				//sektor sorumlusu pdf onizlemesi yapabilsin
				if ($taslak == 0){
					$onClick = 'onclick = "userSubmit (1,'.$yeterlilik_id.')" ';
					$value = 'value="Tümünü Göster" ';
						
					$name  = 'name="gonder" ';
					$tree .= $inp.$name.$value.$onClick.$disabled." />";
				}
				//
				$disabled = '';
				if ($this->getYorumCount_SS ($evrak_id) == 0) // Daha Yorum Yok
					$disabled = 'disabled ';
				$onClick = 'onclick = "sektorSorumlusuSubmit (1,'.$yeterlilik_id.')" ';
				$name  = 'name="gonder" ';
				$value = 'value="Yorumları Gönder" ';
				//$tree .= $inp.$name.$onClick.$value.$disabled." />";
				if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__TASLAK){		
					
					$onClick = 'onclick = "sektorSorumlusuSubmit (2,'.$yeterlilik_id.')" ';
					$name  = 'name="onayla" ';
					$value = 'value="Yeterlilik Ön Taslağını Onayla" ';
					$tree .= $inp.$name.$onClick.$value." />";
				}
			}
			
		}
		else // SEKTOR SORUMLUSU DEGIL, KURULUÅ�
		{
			
			if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK &&
			   $yeterlilikDurumID != PM_YETERLILIK_DURUMU__TASLAK &&
				$yeterlilikDurumID != PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK	) //SS Onayina gonderilmemis On Taslak ve Taslak olmayanlar
			{
				if ($yeterlilikDurumID != PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK) //On Taslak Daha onaylanmamis
				{
					$onClick = 'onclick = "userSubmit (1,'.$yeterlilik_id.')" ';
					//$value = 'value="TÃ¼m TaslaÄŸÄ± GÃ¶rÃ¼ntÃ¼le / Bitir" ';
					$value = 'value="Ön Taslağı Sektör Sorumlusu İncelemesine Sun" ';
						
					$disabled = 'disabled';
					if (count($saved) >= $sayfa-1){
						$disabled = '';
					}
				}
				else // On Taslak onaylanip kurulusun bitirmesi icin sunulmus
				{
					$onClick = 'onclick = "userSubmit (2,'.$yeterlilik_id.')" ';
					$value = 'value="Tüm Taslağı Görüntüle  / Bitir" ';
			
					$disabled = '';
				}
			
				if ($onClick != ""){
					$name  = 'name="gonder" ';
					$tree .= $inp.$name.$value.$onClick.$disabled." />";
				}
			}
		}
		
				
		////
		$yeterlilikDurumu = $yeterlilikData[0]["YETERLILIK_DURUM_ID"];
		$yeterlilikSurecDurumu = $yeterlilikData[0]["YETERLILIK_SUREC_DURUM_ID"];
		
		if ($isSektorSorumlusu)
			$fonksiyonAdi = 'sektorSorumlusuSubmit2';
		else
			$fonksiyonAdi = 'userSubmit2';

		
		
		////
		
		
		
		$tree .= '<div style="clear:both;"></div></div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'float:left; margin: 1px; padding:1px;';
			
			for ($j = 0; $j < count($saved); $j++){
				if ($this->sayfalarZorunluMu[$i]=='0' || $saved[$j] == ($i+1)){
					$style	 = 'float:left; background-color:#006688; color:white; margin: 1px; padding:1px;';
					break;
				}
			}
			$input = '<input type="button" onClick="goToPage(\''.$this->pages[$i].'\', '.$yeterlilik_id.')" class="btn navpage" id="page'.$i.'" value="'.$this->pageNames[$i].'" ';
			if ($activeLayout == $this->pages[$i])
			{	
				$tree .= $input.$activeStyle.' />';
				//$tree .= $input.$activeStyle.$style.'" />';
				
				if($this->sayfalarZorunluMu[$i]=='0')
				{
					//
					//function insertSavedPage ($pageNum, $evrak_id, $juser_id, $basvuru_tur, $form_id)
					$basvuru_tur = YT2_BASVURU_TIP;
					$user = &JFactory::getUser();
					$evrak_id = $this->getOracleEvrakId ($yeterlilik_id);
					$pageNum = $i+1;
					$db = &JFactory::getDBO();
					
					$sql= "	REPLACE INTO #__user_evrak (user_id, evrak_id, basvuru_tur, saved_page, form_id)
					VALUES (".$user->id.", ".$evrak_id.",".$basvuru_tur.", ".$pageNum.", ".$yeterlilik_id.")";
					
					$db->Execute ($sql);
						
				}
				
				//
			}
			else
				$tree .= $input.' style="'.$style.'" />'; 
		}
		
		$tree .= '<br /><div style="clear:both;"></div></div>';
		
		return $tree;
	}
	
	function getPageTreeYeni ($user, $activeLayout, $evrak_id, $yeterlilik_id, $taslak = 0){
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu($user);
		$activeStyle = 'style="float:left; background-color:#b30000; color:white; padding:1px; margin: 1px;"';
	
		$sayfa = count ($this->pages);
		$saved = $this->getSavedPages ($evrak_id, $yeterlilik_id);
	
		$yeterlilikData = $this->getYeterlilikInfo($yeterlilik_id);
	
		$yeterlilikDurumuPM = $yeterlilikData[0]["YETERLILIK_DURUM_ADI"];
		$yeterlilikSurecDurumuPM = $yeterlilikData[0]["YETERLILIK_SUREC_DURUM_ADI"];
	
		$tree = "<div style='font-size:22px; float: left; width:99%; font-size: 1em; font-weight: normal; line-height: normal; font-family: Arial,Helvetica,sans-serif; margin-left:50px; '>
		<big><b>Yeterliliğin:</b></big>
		<br><b>Adı - Seviyesi:</b> ".$yeterlilikData[0]["YETERLILIK_ADI"]." - Seviye ".$yeterlilikData[0]["SEVIYE_ID"]." - Revizyon ".$yeterlilikData[0]["REVIZYON"]."
		<br><b>Durumu:</b> ".$yeterlilikDurumuPM."
	
		</div>";
	
		$tree .= '<div class="form_element" style="width:95%; text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
	
		$inp = '<input style="float:left; padding:5px; margin: 5px;" type="button" ';
		$inpClosure = ' />';
		$value	 = "";
		$onClick = "";
		$disabled= "";
		$yeterlilikDurumID = $this->getYeterlilikDurumId ($yeterlilik_id);
	
		if ($isSektorSorumlusu){
			if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK)
			{
				//
				$disabled = '';
				if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__TASLAK && $yeterlilikDurumID != PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK){

					$onClick = 'onclick = "" ';
					$name  = 'name="onayla" ';
					$value = 'value="Kuruluşa Geri Gönder" ';
					$id = 'id="ontaslak_kurulusa_gonder" ';
					$tree .= $inp.$name.$id.$onClick.$value." />";
						
					$script .= 'jQuery("#ontaslak_kurulusa_gonder").live("click",function(){
									if(confirm("Yeterlilik ön taslağı kuruluşa geri gönderilecek emin misiniz ?")){
										sektorSorumlusuSubmit (4,'.$yeterlilik_id.');
									}
								});';
					
					$onClick = 'onclick = "" ';
					$name  = 'name="onayla" ';
					$value = 'value="Yeterlilik Ön Taslağını Onayla" ';
					$id = 'id="ontaslak_onayla" ';
					$tree .= $inp.$name.$id.$onClick.$value." />";
					
					$script .= 'jQuery("#ontaslak_onayla").live("click",function(){
									if(confirm("Yeterlilik ön taslağı onaylanacak emin misiniz ?")){
										sektorSorumlusuSubmit (2,'.$yeterlilik_id.');
									}
								});';
				}
			}
				
		}
		else // SEKTOR SORUMLUSU DEGIL, KURULUÅ�
		{
				
			if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK &&
			$yeterlilikDurumID != PM_YETERLILIK_DURUMU__TASLAK &&
			$yeterlilikDurumID != PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK	) //SS Onayina gonderilmemis On Taslak ve Taslak olmayanlar
			{
				if ($yeterlilikDurumID != PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK) //On Taslak Daha onaylanmamis
				{
					$onClick = 'onclick = ""';
					$value = 'value="Ön Taslağı Sektör Sorumlusu İncelemesine Sun" ';
					$id = 'id="ss_sun" ';
					$disabled = '';
					$script = 'jQuery("#ss_sun").live("click",function(){
									if(confirm("Yeterlilik detayları Sektör Sorumlusunun incelemesine sunulanacak emin misiniz ?")){
										userSubmit (1,'.$yeterlilik_id.');
									}
								});';
				}
				else // On Taslak onaylanip kurulusun bitirmesi icin sunulmus
				{
					$onClick = 'onclick = "userSubmit (2,'.$yeterlilik_id.')" ';
					$value = 'value="Tüm Taslağı Görüntüle  / Bitir" ';
						
					$disabled = '';
				}
					
				
				$name  = 'name="gonder" ';
				$tree .= $inp.$name.$value.$id.$onClick.$disabled." />";
			}
		}
	
	
		////
		$yeterlilikDurumu = $yeterlilikData[0]["YETERLILIK_DURUM_ID"];
		$yeterlilikSurecDurumu = $yeterlilikData[0]["YETERLILIK_SUREC_DURUM_ID"];
	
		if ($isSektorSorumlusu)
			$fonksiyonAdi = 'sektorSorumlusuSubmit2';
		else
			$fonksiyonAdi = 'userSubmit2';
	
		////
	
		$tree .= '<div style="clear:both;"></div></div></div>';
	
		$tree .= '<script>'.$script.'</script>';
		
		return $tree;
	}
	
	function getYorumDiv_SS ($evrak_id, $layout, $readOnly = true)
	{
		$db = &JFactory::getOracleDBO();
		
		$sql= 'SELECT * FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ? 
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.' 
		AND SS_YORUMU_MU = 1 AND LAYOUT = ?';
		
		$params = array ($_GET['yeterlilik_id'], $layout);
		
		$data = $db->prep_exec($sql, $params);
		
		
		if ( !empty($data))
			$yorum = $data[0]['YORUM'];
		else if ( $readOnly == true)
			$yorum= 'Henüz Sektör Sorumlusu TarafÄ±ndan Bir Yorum Bildirilmemiş.';
		
		$divText =  '<div style="padding-top:30px">
					<div class="form_item">
					  <div class="form_element cf_heading">
					  	<h1 class="contentheading">SEKTÖR SORUMLUSU YORUMLARI</h1>
					  </div>
					  <div class="cfclear">&nbsp;</div>
					</div>
					
					<div class="form_item">
						<div class="form_element cf_textarea">';
		
					if ( $readOnly != true)
						$divText .= '<textarea class="cf_inputbox" rows="5" '.$read.'
								id="yorum" title="" cols="70" name="yorum">'.$yorum.'</textarea>';
					else
						$divText .= $yorum;
					
						$divText .= '</div>
						<div class="cfclear">&nbsp;</div>
					</div>
				</div>';
		
		return $divText;
	}
	
	function getYorumDiv_Kurulus ($evrak_id, $layout, $readOnly = true)
	{
		$db = &JFactory::getOracleDBO();
	
		$sql= 'SELECT * FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ?
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.'
		AND SS_YORUMU_MU = 0 AND LAYOUT = ?';
	
		$params = array ($_GET['yeterlilik_id'], $layout);
	
		$data = $db->prep_exec($sql, $params);
	
	
		if ( !empty($data))
			$yorum = $data[0]['YORUM'];
		else if ( $readOnly == true)
			$yorum= 'Henüz Sektör Sorumlusu Tarafından Bir Yorum Bildirilmemiş.';
	
		$divText =  '<div style="padding-top:30px">
		<div class="form_item">
		<div class="form_element cf_heading">
		<h1 class="contentheading">SEKTÖR SORUMLUSU YORUMLARI</h1>
		</div>
		<div class="cfclear">&nbsp;</div>
		</div>
			
		<div class="form_item">
		<div class="form_element cf_textarea">';
	
		if ( $readOnly != true)
			$divText .= '<textarea class="cf_inputbox" rows="5" '.$read.'
			id="yorum" title="" cols="70" name="yorum_Kurulus">'.$yorum.'</textarea>';
		else
			$divText .= $yorum;
			
		$divText .= '</div>
		<div class="cfclear">&nbsp;</div>
		</div>
		</div>';
	
		return $divText;
	}
	function getSavedPages ($evrak_id, $yeterlilik_id){
		$db = & JFactory::getDBO();
		
		$sql = "SELECT saved_page FROM #__user_evrak 
				WHERE evrak_id= ".$evrak_id. " AND form_id = ".$yeterlilik_id;
		$db->setQuery($sql);
		$data = $db->loadResultArray();
		
		return $data;
	}
	
	
	function getOracleEvrakId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT evrak_id 
			   FROM m_taslak_yeterlilik 
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}
	function getBiriminEk1Yazilari($birimID)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT birim_id, ek1_yazisi FROM m_birim_ek1 
			   WHERE birim_id = ? ORDER BY sira_no";
		
		$params = array ($birimID);
		
		$data = $_db->prep_exec($sql, $params);
		
		
		return $data;
		
	}
	function getGenelKurul()
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_genel_kurul
			where aktif_mi=1 order by sira";
		
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		
		return $data;
		
	}
	function getDistinctGenelKurul()
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT KURUM FROM m_genel_kurul where aktif_mi=1 order by sira";
		
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		
		return $data;
		
	}
	
	function getTaslakYeterlilik ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
			   FROM m_taslak_yeterlilik 
			   WHERE yeterlilik_id = ? 
			   ORDER BY yeterlilik_id";
		
		$lobCol = array ("YETERLILIK_AMAC",
						 "YETERLILIK_ORTAM",
						 "YETERLILIK_GRUP_ALTERNATIF",
						 "YETERLILIK_EGITIM_SEKIL",
						 "YETERLILIK_EGITIM_ICERIK",
						 "YETERLILIK_EGITIM_SURE",
						 "YETERLILIK_DENEYIM_NITELIK",
						 "YETERLILIK_DENEYIM_SURE",
						 "YETERLILIK_DIGER",
						 "YETERLILIK_DEGERLENDIRICI",
						 "YETERLILIK_GECERLILIK_SURE",
						 "YETERLILIK_METHOD_GOZETIM",
						 "YETERLILIK_DEG_YONTEM",
						 "YETERLILIK_EK_ACIKLAMA",
						 "SECMELI_ACIKLAMA",
						 "ZORUNLU_ACIKLAMA",
						 "ZORUNLU_BIRIMLER",
						 "SECMELI_BIRIMLER",
						 "BIRIMLERIN_GRUPLANDIRILMA",
						 "ILAVE_OGRENME_CIKTILARI",
						 "DEGERLENDIRICI_OLCUTLERI",
						 "DEGERLENDIRICI_OLCUT",
						 "MESLEKTE_YATAY_DIKEY",
						 "TERIM_ACIKLAMA");
		
		$params = array ($yeterlilik_id);
		
		for ($i = 0; $i < count($lobCol); $i++){
			$dataLob = $_db->prep_exec_clob($sql, $params, $lobCol[$i]);
			$data[$lobCol[$i]] = $dataLob;
		}
		
		$datas = $_db->prep_exec($sql, $params);
		$columns = current($datas); 
		$data['GORUSE_CIKMA_TARIHI'] = $columns['GORUSE_CIKMA_TARIHI'];
		$data['SINAVSIZ_BELGE_YENILEME'] = $columns['SINAVSIZ_BELGE_YENILEME'];
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getAltBirim ($yeterlilik_id, $tur){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT distinct m_birim.*, m_yeterlilik_birim.*   
			   FROM m_birim
			   join m_yeterlilik_birim on m_birim.birim_id = m_yeterlilik_birim.birim_id
				join M_BIRIM_OLCME_DEGERLENDIRME on m_birim.birim_id =   M_BIRIM_OLCME_DEGERLENDIRME.birim_id
			   WHERE m_birim.birim_id = m_yeterlilik_birim.birim_id 
			   AND m_yeterlilik_birim.yeterlilik_id = ? AND zorunlu = ? 
			   ORDER BY m_yeterlilik_birim.sira_no ASC";
		
		$params = array ($yeterlilik_id, $tur);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return array ();
	}
	
	function getAltBirimSinavsiz ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT distinct m_birim.*, m_yeterlilik_birim.*   
			   FROM m_birim
			   join m_yeterlilik_birim on m_birim.birim_id = m_yeterlilik_birim.birim_id
			   WHERE m_birim.birim_id = m_yeterlilik_birim.birim_id 
			   AND m_yeterlilik_birim.yeterlilik_id = ? and 
         m_birim.birim_id not in (select birim_id from m_birim_olcme_degerlendirme where m_birim_olcme_degerlendirme.birim_id = m_yeterlilik_birim.birim_id)
			   ORDER BY m_yeterlilik_birim.sira_no ASC";
	
		$params = array ($yeterlilik_id);

		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return array ();
	}
	
	function getDegerlendirmeArac ($yeterlilik_id, $tur){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yet_degerlendirme_arac  
			   WHERE yeterlilik_id = ? AND degerlendirme_tur_id = ? 
			   ORDER BY  degerlendirme_arac_id";
		
		$params = array ($yeterlilik_id, $tur);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return array();
	}
	
	function getBeceriYetkinlikValues ($yeterlilik_id, $tip){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeter_beceri_yetkinlik 
			   WHERE yeterlilik_id = ? AND beceri_yetkinlik_tipi = ?  
			   ORDER BY  beceri_yetkinlik_adi";//beceri_yetkinlik_id
		
		$params = array ($yeterlilik_id, $tip);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return array();
	}

	function getAltBirimBeceriYetkinlikValues ($yeterlilik_id, $tip){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT BECERI_YETKINLIK_ID,
					  BECERI_YETKINLIK_ADI,
					  YETERLILIK_ALT_BIRIM_ID, 
					  YETERLILIK_ALT_BIRIM_NO,
					  YETERLILIK_ALT_BIRIM_ADI, 
					  YETERLILIK_ALT_BIRIM_KODU,
					  YETERLILIK_ALT_BIRIM_SEVIYE,
					  YETERLILIK_ALT_BIRIM_KREDI,
					  YETERLILIK_ALT_BIRIM_YAYIN_TAR,
					  YETERLILIK_ALT_BIRIM_REV_NO,
					  YETERLILIK_ALT_BIRIM_REV_TAR,
					  YETERLILIK_ALT_BIRIM_MES_STA,
					  YETERLILIK_ALT_BIRIM_BIR_GELIS,
					  YETERLILIK_ALT_BIRIM_SEK_KOM,
					  YETERLILIK_ALT_BIRIM_ONAY_TAR
			   FROM m_yet_birim_beceri_yetkinlik y
			   	 JOIN M_YETERLILIK_ALT_BIRIM_YENI USING (yeterlilik_alt_birim_id) 
			   	 JOIN M_YETER_BECERI_YETKINLIK USING (BECERI_YETKINLIK_ID) 
			   WHERE y.yeterlilik_id = ? AND y.beceri_yetkinlik_tipi = ?  
			   ORDER BY YETERLILIK_ALT_BIRIM_ID";
		
		$params = array ($yeterlilik_id, $tip);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return array();
	}

	function getOnaylanmisAltBirim (){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik_alt_birim_yeni
			     JOIN m_yeterlilik USING (yeterlilik_id) 
			   	 JOIN pm_seviye USING (seviye_id) 
			   WHERE YETERLILIK_SUREC_DURUM_id = ".ONAYLANMIS_YETERLILIK."   
			   ORDER BY yeterlilik_alt_birim_adi";
		
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getKaynakValues ($yeterlilik_id, $tur){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik_kaynak 
			   WHERE yeterlilik_id = ? AND kaynak_tur_id = ?    
			   ORDER BY kaynak_id";
		
		$params = array ($yeterlilik_id, $tur);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getKurulusValues ($yeterlilik_id, $tur){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT yeterlilik_kurulus_adi, ilk_gelistirme_yapan, revize_yapan, revize_no    
			   FROM m_yeterlilik_kurulus  
			   WHERE yeterlilik_id = ? AND
			   		 yeterlilik_kurulus_tipi = ?     
			   ORDER BY yeterlilik_kurulus_id";
		
		$params = array ($yeterlilik_id, $tur);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getYeterlilikKaynagindanKurulusValues ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT STANDART_ADI, m_meslek_standartlari.seviye_id, m_taslak_meslek_gorev_alan.GOREV_ALAN_KURULUS,
		 gorev_alan_id, GOREV_ALAN_AD_SOYAD, GOREV_ALAN_UNVAN 
		 FROM m_yeterlilik_kaynak, M_taslak_meslek, m_taslak_meslek_gorev_alan, m_meslek_standartlari 
		WHERE M_TASLAK_MESLEK.STANDART_ID = m_meslek_standartlari.standart_id 
		AND m_taslak_meslek_gorev_alan.gorev_alan_tur_id=5 
		AND m_taslak_meslek_gorev_alan.taslak_meslek_id = m_taslak_meslek.taslak_meslek_id 
		AND m_taslak_meslek.standart_id=m_yeterlilik_kaynak.kaynak_id 
		AND m_yeterlilik_kaynak.yeterlilik_id = ?";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getTerimValues ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik_terim, m_terim 
			   WHERE m_yeterlilik_terim.terim_id = m_terim.terim_id 
			   AND yeterlilik_id = ?     
			   ORDER BY m_terim.terim_adi";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getStandartValues ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik_ulus_standart 
			   WHERE yeterlilik_id = ?     
			   ORDER BY standart_id";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getEk2Tablosu($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
		FROM m_yeterlilik_terim, m_terim 
		WHERE m_yeterlilik_terim.yeterlilik_id = ? 
			AND m_yeterlilik_terim.terim_id = m_terim.terim_id order by m_terim.terim_adi";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getEk5Tablosu($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_yeterlilik_kurulus WHERE yeterlilik_kurulus_tipi = ".YET_KATKI_SAGLAYAN_KURULUS." AND yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getEk6Tablosu($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_yeterlilik_kurulus 
		WHERE yeterlilik_kurulus_tipi = ".YET_GORUSE_GONDERILEN_KURULUS." 
		AND yeterlilik_id = ?
		ORDER BY sira_no";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getHazirlayanKurulus($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM M_TASLAK_YETERLILIK_HAZIRLAYAN
		WHERE yeterlilik_id = ?
		ORDER BY sira_no";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getSeviyeValues()
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM pm_seviye";
		
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getPMBirimEk2Turleri()
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM pm_birim_ek2_ek_tipi";
		
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getBagimliBirimlerOlanSektorValues()
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT DISTINCT SEKTOR_ID, SEKTOR_ADI 
FROM m_yeterlilik 
JOIN m_yeterlilik_birim USING (YETERLILIK_ID) 
JOIN pm_sektorler USING (SEKTOR_ID) 
WHERE YETERLILIK_ID != ?
AND YETERLILIK_DURUM_ID=".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK."
ORDER BY SEKTOR_ADI";
	
		$params = array ($_GET['yeterlilik_id']);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getSektorValues()
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM pm_sektorler";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getOgrenmeCiktilariByBirim($birim_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim__ogrenme_ciktisi, m_ogrenme_ciktisi 
WHERE m_birim__ogrenme_ciktisi.birim_id = ? 
AND m_birim__ogrenme_ciktisi.ogrenme_ciktisi_id = m_ogrenme_ciktisi.ogrenme_ciktisi_id
		ORDER BY m_ogrenme_ciktisi.ogrenme_ciktisi_id";
	
		$params = array ($birim_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getBasarimOlcutleriByOgrenmeCiktisi($ogrenmeCiktisiID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_ogrenme_ciktisi__basarim_olc, m_basarim_olcutu
WHERE m_ogrenme_ciktisi__basarim_olc.basarim_olcutu_id = m_basarim_olcutu.basarim_olcutu_id
		AND m_ogrenme_ciktisi__basarim_olc.ogrenme_ciktisi_id = ?
		ORDER BY m_ogrenme_ciktisi__basarim_olc.basarim_olcutu_id";
	
		$params = array ($ogrenmeCiktisiID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}

	function getBaglamByDisIDAndIliskiTipi($idlerArrayi, $iliski_tipi)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_baglam_iliski, m_baglam
WHERE m_baglam_iliski.baglam_id = m_baglam.baglam_id
AND m_baglam_iliski.dis_id IN (".implode(" , ", $idlerArrayi).")
AND m_baglam_iliski.iliski_tipi = ".$iliski_tipi."
ORDER BY m_baglam_iliski.dis_id";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	
	function getBirimlerleDetaylari($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$queryFields = "m_yeterlilik_birim.yeterlilik_id, m_yeterlilik_birim.birim_id, m_birim.birim_adi,
m_birim.birim_seviye,m_birim.birim_kredi,m_birim.birim_yayin_tar,m_birim.birim_rev_no,
m_birim.birim_rev_tar, m_yeterlilik_birim.zorunlu, m_ogrenme_ciktisi.ogrenme_ciktisi_id,
m_ogrenme_ciktisi.ogrenme_ciktisi_yazisi";
		
		$queryTables = "m_yeterlilik_birim, m_yeterlilik, m_birim, m_birim__ogrenme_ciktisi, m_ogrenme_ciktisi";
		
		$sql= "SELECT ".$queryFields." FROM ".$queryTables. "
WHERE m_yeterlilik_birim.yeterlilik_id = ?
AND m_yeterlilik_birim.yeterlilik_id = m_yeterlilik.yeterlilik_id
AND m_yeterlilik_birim.birim_id = m_birim.birim_id
AND m_birim.birim_id = m_birim__ogrenme_ciktisi.birim_id
AND m_birim__ogrenme_ciktisi.ogrenme_ciktisi_id = m_ogrenme_ciktisi.ogrenme_ciktisi_id
ORDER BY m_yeterlilik_birim.yeterlilik_id, m_yeterlilik_birim.birim_id, m_yeterlilik_birim.zorunlu
		";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getDegerlendirmeOgrenmeCiktiValues ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yet_degerlendirme_ogrenme 
			   		JOIN m_yet_degerlendirme_arac USING (degerlendirme_arac_id) 
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
function getDegerlendirmeOgrenmeCikti ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT m_yet_degerlendirme_arac.degerlendirme_arac_adi,m_yeter_beceri_yetkinlik.beceri_yetkinlik_adi
			FROM m_yet_degerlendirme_arac, m_yet_degerlendirme_ogrenme, m_yeter_beceri_yetkinlik 
			where m_yet_degerlendirme_arac.yeterlilik_id = ?
			and m_yet_degerlendirme_arac.degerlendirme_arac_id = m_yet_degerlendirme_ogrenme.degerlendirme_arac_id
			and m_yeter_beceri_yetkinlik.beceri_yetkinlik_id = m_yet_degerlendirme_ogrenme.beceri_yetkinlik_id";
		
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getYorumCount_SS ($evrak_id){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT count(*) FROM #__taslak_yorum 
				WHERE  ss_yorumu_mu = 1 AND evrak_id = ".$evrak_id;
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		return $data[0];
	}
	
	function getYorumDurumId_SS ($evrak_id){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT yorum_durum FROM #__taslak_yorum 
				WHERE evrak_id = ".$evrak_id." AND  ss_yorumu_mu = 1
				ORDER BY yorum_durum DESC";
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		if ( !empty($data))
			return $data[0];
		else
			return -1;
	}

	function getEvrakDurumId ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT basvuru_sekli_id  
				FROM ".DB_PREFIX.".evrak 
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID;
	}
	function getYeterlilikDurumId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT YETERLILIK_DURUM_id 
				FROM m_yeterlilik  
				WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return ONAYLANMAMIS_YETERLILIK;
	}
	
	function getYeterlilikSurecDurumId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql="select REVIZYON_DURUMU from M_YETERLILIK_REVIZYON where YETERLILIK_ID=".$yeterlilik_id." order by 
 REVIZYON_NO desc";
		$data=$_db->prep_exec_array($sql, array());
		
		if (!$data){
			$sql = "SELECT YETERLILIK_SUREC_DURUM_id 
					FROM m_yeterlilik  
					WHERE yeterlilik_id = ?";
			
			$params = array ($yeterlilik_id);
			
			$data = $_db->prep_exec_array($sql, $params);
		}
			return $data[0];
	}
	
	function getSayfa ($layout){
		for ($i = 0; $i < count($this->pages); $i++){
			if ($this->pages[$i] == $layout)
				break;
		}
		
		return $i+1;
	}
	
	function ajaxAdaGoreBagimsizBirimArat(){
		$_db = &JFactory::getOracleDBO();
		
		$birimAdiToSearchFor = $_REQUEST['BagimsizBirimEkle_NameTextBox'];
		
		$sql= "SELECT * FROM m_birim, pm_birim_onay_durumu
		WHERE m_birim.birim_onay_durum = pm_birim_onay_durumu.durum_id 
	AND m_birim.BAGIMSIZMI = 1 AND TURKCE_UPPER(BIRIM_ADI) LIKE TURKCE_UPPER(?)";
		
		
		$params = array ("%".$birimAdiToSearchFor."%");
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			ajax_success_response_with_array("BaÅŸarÄ±lÄ±", $data);
		else 
			ajax_error_response("Hatayla KarÅŸÄ±laÅŸÄ±ldÄ±");
	}
	
	function ajaxSeviyeVeSektoreGoreYeterlilikGetir(){
		$_db = &JFactory::getOracleDBO();
	
		$seviye = $_REQUEST['seviyeValue'];
		$sektor = $_REQUEST['sektor'];
		
		$sql= "SELECT YETERLILIK_ID, YETERLILIK_KODU||'/'||REVIZYON||' '||YETERLILIK_ADI AS YETERLILIK_ADI FROM m_yeterlilik JOIN m_taslak_yeterlilik USING (YETERLILIK_ID)
		WHERE SEVIYE_ID = ".$seviye." 
		AND SEKTOR_ID = ".$sektor." 
		AND YETERLILIK_DURUM_ID=".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK."
		ORDER BY yeterlilik_adi";
	
		//$params = array ($seviye, $sektor);
	
		$data = $_db->prep_exec($sql, array());//$params
	
 		if (count($data)>0)
			ajax_success_response_with_array("Başarılı", $data);
 		else
			ajax_error_response("Hatayla Karşılaşıldı");
	}
	function ajaxSektoreGoreSeviyeGetir(){
		$_db = &JFactory::getOracleDBO();
	
		$sektor = $_GET['sektor'];
		
		$sql= "SELECT DISTINCT SEVIYE_ID 
		FROM m_yeterlilik 
		JOIN m_yeterlilik_birim USING (YETERLILIK_ID) 
		JOIN M_BIRIM USING (birim_id)
		WHERE SEKTOR_ID = ".$sektor." 
		AND YETERLILIK_DURUM_ID=".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK."
		ORDER BY seviye_id";
	
		$data = $_db->prep_exec_array($sql, array());//$params
	
		ajax_success_response_with_array("BaÅŸarÄ±lÄ±", $data);
	}
	function ajaxKontrolListeliEk2DataGetir($element_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT olc_deg_harf, olc_deg_numara 
		FROM m_birim_ek2_kntrl_listeli JOIN m_birim_olcme_degerlendirme USING (birim_id) 
		WHERE ek2_kontrol_listeli_id = ? AND (olc_deg_harf ='T' OR olc_deg_harf ='P')";
		$params = array ($element_id);
		$data1 = $_db->prep_exec($sql, $params);
		
		$result['TUM_OLCME_DEGERLENDIRMELER'] = $data1;
		
		$sql= "SELECT * 
		FROM M_BIRIM_EK2_KNTRL_LISTELI_DGRL 
		WHERE ek2_kontrol_listeli_id = ?";
		$params = array ($element_id);
		$data2 = $_db->prep_exec($sql, $params);
		
		$result['SECILI_OLCME_DEGERLENDIRMELER'] = $data2;
		
		
		if (!empty($data1))
			ajax_success_response_with_array("BaÅŸarÄ±lÄ±", $result);
		else
			ajax_error_response("Hatayla KarÅŸÄ±laÅŸÄ±ldÄ±");
	}
	
	function ajaxKontrolListeliEk2DataKaydet()
	{
		$elementID = $_POST['ek2_kontrol_listeli_id_input'];
		$checkboxValues = $_GET['checkboxValue'];
		
		$_db = &JFactory::getOracleDBO();
		
		
		for($i=0; $i<count($checkboxValues); $i++)
		{
			$splitArray = split('-', $checkboxValues[$i]);
			$elementID = $splitArray[0];
			$harf = $splitArray[1];
			$numara = $splitArray[2];
				
			if($i==0)//ilk baÅŸta zaten varolanlarÄ± sil
			{
				$sql= "DELETE FROM M_BIRIM_EK2_KNTRL_LISTELI_DGRL WHERE EK2_KONTROL_LISTELI_ID=?";
				$params = array ($elementID);
				$result = $_db->prep_exec_insert($sql, $params);
			}
			
			$sql= "INSERT INTO M_BIRIM_EK2_KNTRL_LISTELI_DGRL
			(EK2_KONTROL_LISTELI_ID, DEGERLENDIRME_ARACI_HARF, DEGERLENDIRME_ARACI_NUMARA) 
			VALUES (?,?,?)";
			$params = array ($elementID, $harf, $numara);
			$result2 = $_db->prep_exec_insert($sql, $params);
			$result = $result && $result2;	
		}
		
		if ($result == true)
			ajax_success_response("BaÅŸarÄ±lÄ±");
		else
			ajax_error_response("Hatayla KarÅŸÄ±laÅŸÄ±ldÄ±");
	}
	function ajaxYeterliliginBirimleriniGetir(){
		$_db = &JFactory::getOracleDBO();
	
		$yeterlilikID = $_REQUEST['yeterlilikID'];
		
		//$sql= "SELECT * FROM m_yeterlilik, m_yeterlilik_birim, m_birim WHERE m_yeterlilik.yeterlilik_id = m_yeterlilik_birim.yeterlilik_id 
//AND m_yeterlilik_birim.birim_id = m_birim.birim_id AND m_birim.BAGIMLI_OLDUGU_YET_ID = ?";
		$sql = "SELECT m_yeterlilik.yeterlilik_id, m_yeterlilik.seviye_id, m_birim.birim_id, 
				m_birim.birim_kodu,
				m_birim.birim_adi,
				 m_birim.birim_kodu||' '||m_birim.birim_adi as birim_bilgisi, m_birim.birim_seviye, y2.*
		FROM m_yeterlilik, m_yeterlilik_birim, m_birim, pm_birim_onay_durumu, 
        (select yeterlilik_id as bagimli_oldugu_yet_id2,
          yeterlilik_adi as bagimli_oldugu_yeterlilik_adi,
          yeterlilik_kodu as bagimli_oldugu_yet_kodu,
          seviye_id as bagimli_oldugu_yet_seviye_id 
        from m_yeterlilik) y2
		WHERE m_yeterlilik.yeterlilik_id=?
		AND m_yeterlilik.yeterlilik_id = m_yeterlilik_birim.yeterlilik_id (+)
		AND m_yeterlilik_birim.birim_id = m_birim.birim_id (+)
		AND m_birim.birim_onay_durum = pm_birim_onay_durumu.durum_id (+)
    AND m_birim.bagimli_oldugu_yet_id = y2.bagimli_oldugu_yet_id2 (+)
		ORDER BY m_birim.birim_adi,m_yeterlilik_birim.birim_id,m_yeterlilik.yeterlilik_id";
		   
		$params = array ($yeterlilikID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			ajax_success_response_with_array("Başarılı", $data);
		else
			ajax_error_response("Hatayla Karşılaşıldı");
	}
	
	function ajaxSeciliBirimleriEkle($seciliBirimler){
		
	}
	
	function ajaxSaveBirimDetayi($birimID){
		
		$_db  = & JFactory::getOracleDBO();	
		$postData = JRequest::get( 'post' );
		$birimID = $_REQUEST["birimID"];
		
		$this->clearBirimDetayi($birimID);
		$this->insertBirimDetayi($postData, $birimID);
		
	}
	
	function clearBirimDetayi($birimID)
	{
		$_db  = & JFactory::getOracleDBO();
		
		$sql = "SELECT M_BIRIM__OGRENME_CIKTISI.BIRIM_ID, M_BIRIM__OGRENME_CIKTISI.OGRENME_CIKTISI_ID, M_OGRENME_CIKTISI__BASARIM_OLC.BASARIM_OLCUTU_ID 
		FROM M_BIRIM__OGRENME_CIKTISI, M_OGRENME_CIKTISI__BASARIM_OLC 
WHERE M_BIRIM__OGRENME_CIKTISI.OGRENME_CIKTISI_ID =  M_OGRENME_CIKTISI__BASARIM_OLC.OGRENME_CIKTISI_ID  (+)
		AND M_BIRIM__OGRENME_CIKTISI.BIRIM_ID =  ?";
		
		$params[] = $birimID;

		$result = $_db->prep_exec($sql, $params);
		
		$currentBirimID = "";
		$currentOgrenmeCiktisiID = "";
		$currentBasarimOlcutuID = "";
		
		$birimIDText = "";
		$ogrenmeCiktisiIDText = "";
		$basarimOlcutuIDText = "";
		
		
		for($i=0; $i<count($result); $i++)
		{
			if( $result[$i]["BIRIM_ID"] != $currentBirim && strlen($result[$i]["BIRIM_ID"])>0)
			{
				$currentBirimID = $result[$i]["BIRIM_ID"];
				
				if( $i != 0 )
					$birimIDText .= ", ";
				$birimIDText .= $currentBirimID;
			}
			
			if( $result[$i]["OGRENME_CIKTISI_ID"] != $currentOgrenmeCiktisiID && strlen($result[$i]["OGRENME_CIKTISI_ID"])>0)
			{
				$currentOgrenmeCiktisiID = $result[$i]["OGRENME_CIKTISI_ID"];
			
				if( $i != 0 )
					$ogrenmeCiktisiIDText .= ", ";
				$ogrenmeCiktisiIDText .= $currentOgrenmeCiktisiID;
			}
			
			if( $result[$i]["BASARIM_OLCUTU_ID"] != $currentBasarimOlcutuID && strlen($result[$i]["BASARIM_OLCUTU_ID"])>0)
			{
				$currentBasarimOlcutuID = $result[$i]["BASARIM_OLCUTU_ID"];
			
				if( $i != 0 )
					$basarimOlcutuIDText .= ", ";
				$basarimOlcutuIDText .= $currentBasarimOlcutuID;
			}
		}
		
		
		
		$_db  = & JFactory::getOracleDBO();
		
		if(strlen($basarimOlcutuIDText)!=0)
		{
		
			$sql = "DELETE FROM m_ogrenme_ciktisi__basarim_olc WHERE basarim_olcutu_id IN ( ".$basarimOlcutuIDText.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);
			
			$sql = "DELETE FROM m_baglam_iliski WHERE iliski_tipi = ".PM_BAGLAM_TIPI__BASARIM_OLCUTU_BAGLAMI." AND dis_id IN ( ".$basarimOlcutuIDText.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);
		
			$sql = "DELETE FROM m_basarim_olcutu WHERE basarim_olcutu_id IN ( ".$basarimOlcutuIDText.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);
		
		}
		
		if(strlen($ogrenmeCiktisiIDText)!=0)
		{
			$sql = "DELETE FROM m_birim__ogrenme_ciktisi WHERE ogrenme_ciktisi_id IN ( ".$ogrenmeCiktisiIDText.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);
		
		
			$sql = "DELETE FROM m_baglam_iliski WHERE iliski_tipi = ".PM_BAGLAM_TIPI__OGRENME_CIKTISI_BAGLAMI." AND dis_id IN ( ".$ogrenmeCiktisiIDText.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);
		
			$sql = "DELETE FROM m_ogrenme_ciktisi WHERE ogrenme_ciktisi_id IN ( ".$ogrenmeCiktisiIDText.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);
		}
		
		
		if(strlen($birimID)!=0)
		{
			$sql = "DELETE FROM m_baglam_iliski WHERE iliski_tipi = ".PM_BAGLAM_TIPI__BIRIM_BAGLAMI." AND dis_id IN ( ".$birimID.") ";
			$params[] = array();
			$result = @$_db->prep_exec_insert($sql, $params);	
		}
		
		
		$sql = "DELETE FROM m_birim_kaynak WHERE birim_id = ?";
		$result = @$_db->prep_exec_insert($sql, array($birimID));
		
		$sql = "DELETE FROM m_birim_ek1 WHERE birim_id = ?";
		$result = @$_db->prep_exec_insert($sql, array($birimID));
		
		$sql = "DELETE FROM m_birim_ek2_kntrl_listesiz WHERE birim_id = ?";
		$params = array($birimID);
		$result = @$_db->prep_exec_insert($sql, $params);
		
		$array1 = explode('-',$_POST['duzenlemedenGeriyeKalanKontrolListeliEk2_1']);
		$array2 = explode('-',$_POST['duzenlemedenGeriyeKalanKontrolListeliEk2_2']);
		
		$silinmemesiGerekenKontrolListeliEk2ler = array_merge($array1, $array2); 
		$silinmeyecekIDler = array();
		for($i=0; $i<count($silinmemesiGerekenKontrolListeliEk2ler); $i++)
		{
			if(strlen($silinmemesiGerekenKontrolListeliEk2ler[$i])>0)
			{
				$silinmeyecekIDler[] = $silinmemesiGerekenKontrolListeliEk2ler[$i];
			}
		}
		if(count($silinmeyecekIDler)!=0)
			$sqlPart = " AND EK2_KONTROL_LISTELI_ID NOT IN (".implode(", ", $silinmeyecekIDler).") ";
		else
			$sqlPart = '';
		
		$sql = "DELETE FROM m_birim_ek2_kntrl_listeli WHERE birim_id = ".$birimID." ".$sqlPart;
		$result = @$_db->prep_exec_insert($sql, array());
		
		
		
		
		$array1 = explode('-',$_POST['duzenlemedenGeriyeKalanTeorikSinavlar']);
		$array2 = explode('-',$_POST['duzenlemedenGeriyeKalanPerformansSinavlari']);
		
		$silinmemesiGerekenOlcmeDegerlendirmeIDleri = array_merge($array1, $array2); 
		$silinmeyecekIDler = array();
		for($i=0; $i<count($silinmemesiGerekenOlcmeDegerlendirmeIDleri); $i++)
		{
			if(strlen($silinmemesiGerekenOlcmeDegerlendirmeIDleri[$i])>0)
			{
				$silinmeyecekIDler[] = $silinmemesiGerekenOlcmeDegerlendirmeIDleri[$i];
			}
		}
		
		if(count($silinmeyecekIDler)!=0)
			$sqlPart = " AND ID NOT IN (".implode(", ", $silinmeyecekIDler).") ";
		else
			$sqlPart = '';
				
		$sql = "DELETE FROM m_birim_olcme_degerlendirme WHERE birim_id = ".$birimID." ".$sqlPart;
		$result = @$_db->prep_exec_insert($sql, array());
		
		$sql = "DELETE FROM m_birim_gelistiren_kurulus WHERE birim_id = ?";
		$params = array($birimID);
		$result = @$_db->prep_exec_insert($sql, $params);
		
		$sql = "DELETE FROM m_birim_dogrulayan_komite WHERE birim_id = ?";
		$params = array($birimID);
		$result = @$_db->prep_exec_insert($sql, $params);
		
		if(strlen($birimID)!=0)
		{
			$sql = "DELETE FROM M_BIRIM_YERINE_GECERLI WHERE BIRIM_ID = ?";
			$result = @$_db->prep_exec_insert($sql, array($birimID));
		}
		
	}
	function insertBirimDetayi($postData, $birimID)
	{
		$sqlResult = true;
		$_db  = & JFactory::getOracleDBO();
		
		$birimTur = $postData['birimTur'];
		$sqlYet = "SELECT BAGIMLI_OLDUGU_YET_ID FROM M_BIRIM WHERE BIRIM_ID = ?";
		$yetBirim = $_db->prep_exec($sqlYet, array($birimID));
		foreach($birimTur as $row){
			$nextAlt = $_db->getNextVal('SEQ_ALTERNATIF_TUR');
			$sqlAltTur = "INSERT INTO M_BIRIM_ALTERNATIF_TUR (ALTERNATIF_TUR_ID, BIRIM_ID, BIRIM_TUR, BIRIM_NUMARA, YETERLILIK_ID) VALUES (?,?,?,?,?)";
			foreach ($row as $cow){
				$tur = explode('_', $cow);
				$_db->prep_exec_insert($sqlAltTur, array($nextAlt,$birimID,$tur[1],$tur[2],$yetBirim[0]['BAGIMLI_OLDUGU_YET_ID']));
			}
		}
		
		$birimBaglamlari = $postData['birimBaglamlari-'.$birimID];
		$biriminOgrenmeCiktilari = $postData['ogrenmeCiktisi'][$birimID];
		$biriminOgrenmeCiktilarininBaglamlari = $postData['ogrenmeCiktisiBaglami'][$birimID];
		$biriminKaynaklari = $postData['birimeYeterlilikKaynagindanKaynak'][$birimID];

		foreach ($biriminKaynaklari as $kaynak)
		{
			$sql = "INSERT INTO m_birim_kaynak (birim_id, kaynak_id) VALUES (?,?) ";
			$params[] = $birimID;
			$params[] = $kaynak;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();//clear array
		}
		
		if(strlen($birimBaglamlari) > 0 )
		{
			$baglamID = $_db->getNextVal(BAGLAM_SEQ);
			$sql = "INSERT INTO m_baglam (baglam_id, baglam_aciklama) VALUES (?,?) ";
			$params[] = $baglamID;
			$params[] = $birimBaglamlari;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
			
			$sql = "INSERT INTO m_baglam_iliski (baglam_id, dis_id, iliski_tipi) VALUES (?,?, ".PM_BAGLAM_TIPI__BIRIM_BAGLAMI.") ";
			$params[] = $baglamID;
			$params[] = $birimID;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
			
		}
		
		for($i=0; $i<count($biriminOgrenmeCiktilari); $i++)
		{
			$ogrenmeCiktisiID = $_db->getNextVal (OGRENME_CIKTISI_SEQ);
			$ogrenmeCiktisiIDTable[$i+1] = $ogrenmeCiktisiID;
			
			$sql = "";
			$params = array();
			
			$sql = "INSERT  INTO m_ogrenme_ciktisi (ogrenme_ciktisi_id, ogrenme_ciktisi_yazisi) VALUES (?,?) ";
			$params[] = $ogrenmeCiktisiID;
			$params[] = $biriminOgrenmeCiktilari[$i+1];
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
			
			$sql = "INSERT  INTO m_birim__ogrenme_ciktisi (birim_id, ogrenme_ciktisi_id) VALUES (?,?) ";
			$params[] = $birimID;
			$params[] = $ogrenmeCiktisiID;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
			$baglamID = $_db->getNextVal(BAGLAM_SEQ);
			
			$sql = "INSERT  INTO m_baglam (baglam_id, baglam_aciklama) VALUES (?,?) ";
			$params[] = $baglamID;
			$params[] = $biriminOgrenmeCiktilarininBaglamlari[$i+1];
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
			$sql = "INSERT  INTO m_baglam_iliski (baglam_id, dis_id, iliski_tipi) VALUES (?,?, ".PM_BAGLAM_TIPI__OGRENME_CIKTISI_BAGLAMI.") ";
			$params[] = $baglamID;
			$params[] = $ogrenmeCiktisiID;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
			$biriminOgrenmeCiktilarininBasarimOlcutleri = $postData['basarimOlcutu-'.$birimID][$i+1];
			if(count($biriminOgrenmeCiktilarininBasarimOlcutleri)==0)
				$biriminOgrenmeCiktilarininBasarimOlcutleri = $postData['basarimOlcutu'][$birimID][$i+1];
					
			$biriminOgrenmeCiktilarininBasarimOlcutlerininBaglamlari = $postData['basarimOlcutuBaglami-'.$birimID][$i+1];
			if(count($biriminOgrenmeCiktilarininBasarimOlcutlerininBaglamlari)==0)
				$biriminOgrenmeCiktilarininBasarimOlcutlerininBaglamlari = $postData['basarimOlcutuBaglami'][$birimID][$i+1];
				
			for($j=0; $j<count($biriminOgrenmeCiktilarininBasarimOlcutleri); $j++)
			{
				$basarimOlcutuID = $_db->getNextVal(BASARIM_SEQ);
				$basarimOlcutuIDTable[($i+1)][($j+1)] = $basarimOlcutuID;
				
				$sql = "INSERT  INTO m_basarim_olcutu (basarim_olcutu_id, basarim_olcutu_adi, sira_no, BIRIM_ID) VALUES (?,?,?,?) ";
				$params[] = $basarimOlcutuID;
				$params[] = $biriminOgrenmeCiktilarininBasarimOlcutleri[$j];
				$params[] = $j;
				$params[] = $birimID;
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
					
				$sql = "INSERT  INTO m_ogrenme_ciktisi__basarim_olc (ogrenme_ciktisi_id, basarim_olcutu_id) VALUES (?,?) ";
				$params[] = $ogrenmeCiktisiID;
				$params[] = $basarimOlcutuID;
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
					
				
				$baglamID = $_db->getNextVal(BAGLAM_SEQ);
				
				$sql = "INSERT  INTO m_baglam (baglam_id, baglam_aciklama) VALUES (?,?) ";
				$params[] = $baglamID;
				$params[] = $biriminOgrenmeCiktilarininBasarimOlcutlerininBaglamlari[$j];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
					
				$sql = "INSERT  INTO m_baglam_iliski (baglam_id, dis_id, iliski_tipi) VALUES (?,?, ".PM_BAGLAM_TIPI__BASARIM_OLCUTU_BAGLAMI.") ";
				$params[] = $baglamID;
				$params[] = $basarimOlcutuID;
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
					
				
			}
			
			
		}
		
		
		$sql = "";
		$params = array();
			
		$buBiriminTeorikSinavlari 						 = $postData['buBiriminTeorikSinavlari'];
		$buBiriminPerformansSinavlari 					 = $postData['buBiriminPerformansSinavlari'];
		$buBiriminDigerSinavlari 						 = $postData['buBiriminDigerSinavlari'];
		$buBiriminTeorikSinavlarininSoruSayilari 		 = $postData['buBiriminTeorikSinavlarininSoruSayileri'];
		$buBiriminTeorikSinavlarininSoruSayilariMax 	 = $postData['buBiriminTeorikSinavlarininSoruSayilariMax'];
		$buBiriminTeorikSinavlarininMinDkSoruSureleri	 = $postData['buBiriminTeorikSinavlarininMinDkSoruSureleri'];
		$buBiriminTeorikSinavlarininMaxDkSoruSureleri 	 = $postData['buBiriminTeorikSinavlarininMaxDkSoruSureleri'];
		$buBiriminTeorikSinavlarininMinSnSoruSureleri	 = $postData['buBiriminTeorikSinavlarininMinSnSoruSureleri'];
		$buBiriminTeorikSinavlarininMaxSnSoruSureleri 	 = $postData['buBiriminTeorikSinavlarininMaxSnSoruSureleri'];
		$buBiriminTeorikSinavlarininBasariKriterleri 	 = $postData['buBiriminTeorikSinavlarininBasariKriterleri'];
		$buBiriminTeorikSinavlarininAdlari 	 			 = $postData['buBiriminTeorikSinavlarininAdlari'];
		$buBiriminTeorikSinavlariGecerlilikSuresi 	 	 = $postData['buBiriminTeorikSinavlariGecerlilikSuresi'];
		
		$buBiriminPerformansSinavlarininBasariKriterleri = $postData['buBiriminPerformansSinavlarininBasariKriterleri'];
		$buBiriminPerformansSinavlarininAdlari 			 = $postData['buBiriminPerformansSinavlarininAdlari'];
		$buBiriminPerformansSinavlariGecerlilikSuresi 	 = $postData['buBiriminPerformansSinavlariGecerlilikSuresi'];
		$buBiriminPerformansSinavlarininBasariKriterleriAciklama = $postData['buBiriminPerformansSinavlarininBasariKriterleriAciklama'];
		
		$buBiriminKontrolsuzEk2Degerleri 				 	= $postData['DegerlendirmeAraciTDCheckbox'];			
		$buBiriminKontrolListeliEk2Tablosu1SiraNolari 		= $postData['KontrolListeliEk2Tablosu1-SiraNo-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu1Inputs 	 		= $postData['KontrolListeliEk2Tablosu1-Input-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu1Inputs_BO_Text	= $postData['KontrolListeliEk2Tablosu1-standartBasarimOlcutu-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu1Selects 	 		= $postData['KontrolListeliEk2Tablosu1-Select-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu2SiraNolari 		= $postData['KontrolListeliEk2Tablosu2-SiraNo-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu2Inputs 	 		= $postData['KontrolListeliEk2Tablosu2-Input-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu2Selects	 		= $postData['KontrolListeliEk2Tablosu2-Select-'.$birimID];
		$buBiriminKontrolListeliEk2Tablosu2Inputs_BO_Text	= $postData['KontrolListeliEk2Tablosu2-standartBasarimOlcutu-'.$birimID];
		$buBiriminEk1Tablosu 								= $postData['biriminEk1leri-'.$birimID];
		
		for($i=0; $i<count($buBiriminEk1Tablosu); $i++)
		{	
			$sql = "INSERT INTO m_birim_ek1 (birim_id, ek1_yazisi, sira_no) VALUES (?,?,?) ";
			$params[] = $birimID;
			$params[] = $buBiriminEk1Tablosu[$i];
			$params[] = ($i+1);
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
		}

		
		$array1 = explode('-',$_POST['duzenlemedenGeriyeKalanKontrolListeliEk2_1']);
		$silinmeyecekKontrolListeliEk2_1ler = array();
		for($i=0; $i<count($array1); $i++)
			if(strlen($array1[$i])>0)
			$silinmeyecekKontrolListeliEk2_1ler[] = $array1[$i];
		
		for($i=0; $i<count($buBiriminKontrolListeliEk2Tablosu1Inputs); $i++)
		{
			$silinmeyecekIndex = $i;
			if( strlen($silinmeyecekKontrolListeliEk2_1ler[$silinmeyecekIndex]) > 0)
			{
				$degerlerarray = explode("#", $buBiriminKontrolListeliEk2Tablosu1Selects[$i]);
				$selectValueArray = explode("-", $degerlerarray[0]);
				$basarimText = $degerlerarray[1];
				$sqlBasarimOlcuId = "SELECT BASARIM_OLCUTU_ID FROM M_BASARIM_OLCUTU WHERE BIRIM_ID = ? AND BASARIM_OLCUTU_ADI = ?";
				$basarimOlcuID = $_db->prep_exec($sqlBasarimOlcuId, array($birimID, $basarimText));
				$inputValue = $buBiriminKontrolListeliEk2Tablosu1Inputs[$i];
				
				$sql = "UPDATE m_birim_ek2_kntrl_listeli  
				SET 
					OGRENME_CIKTISI_INDEX=?, 
					BASARIM_OLCUTU_INDEX=?, 
					EK_YAZISI=?, 
					OGRENME_CIKTISI_ID=?, 
					BASARIM_OLCUTU_ID=?, 
					MESLEK_STANDARDI_BO_TEXT=?,
					SIRA_NO=? 
				WHERE 
					EK2_KONTROL_LISTELI_ID=?";
				$params[] = $selectValueArray[0];
				$params[] = $selectValueArray[1];
				$params[] = $inputValue;
				$params[] = $ogrenmeCiktisiID;
				$params[] = $basarimOlcuID[0]["BASARIM_OLCUTU_ID"];
				//$params[] = $basarimOlcutuID;
				$params[] = $buBiriminKontrolListeliEk2Tablosu1Inputs_BO_Text[$i];
				$params[] = $buBiriminKontrolListeliEk2Tablosu1SiraNolari[$i];
				$params[] = $silinmeyecekKontrolListeliEk2_1ler[$silinmeyecekIndex];
								
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
			else
			{
				$degerlerarray = explode("#", $buBiriminKontrolListeliEk2Tablosu1Selects[$i]);
				$selectValueArray = explode("-", $degerlerarray[0]);
				$basarimText = $degerlerarray[1];
				$sqlBasarimOlcuId = "SELECT BASARIM_OLCUTU_ID FROM M_BASARIM_OLCUTU WHERE BIRIM_ID = ? AND BASARIM_OLCUTU_ADI = ?";
				$basarimOlcuID = $_db->prep_exec($sqlBasarimOlcuId, array($birimID, $basarimText));
				//$selectValueArray = explode("-", $buBiriminKontrolListeliEk2Tablosu1Selects[$i]);
				$inputValue = $buBiriminKontrolListeliEk2Tablosu1Inputs[$i];
				
				$sql = "INSERT  INTO m_birim_ek2_kntrl_listeli (
				EK2_KONTROL_LISTELI_ID, 
				OGRENME_CIKTISI_INDEX, 
				BASARIM_OLCUTU_INDEX, 
				EK_YAZISI, 
				EK_TIPI, 
				OGRENME_CIKTISI_ID, 
				BIRIM_ID, 
				BASARIM_OLCUTU_ID, 
				MESLEK_STANDARDI_BO_TEXT, 
				SIRA_NO)
				VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$params[] = $_db->getNextVal(EK2_KNTRL_LISTELI_DEG_ARAC_SEQ);
				$params[] = $selectValueArray[0];
				$params[] = $selectValueArray[1];
				$params[] = $inputValue;
				$params[] = PM_BIRIM_EK2_TIPI__YETKINLIK;
				$params[] = $ogrenmeCiktisiID;
				$params[] = $birimID;
				//$params[] = $basarimOlcutuID;
				$params[] = $basarimOlcuID[0]["BASARIM_OLCUTU_ID"];
				$params[] = $buBiriminKontrolListeliEk2Tablosu1Inputs_BO_Text[$i];
				$params[] = $buBiriminKontrolListeliEk2Tablosu1SiraNolari[$i];
				
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
		}
	
		$array2 = explode('-',$_POST['duzenlemedenGeriyeKalanKontrolListeliEk2_2']);
		$silinmeyecekKontrolListeliEk2_2ler = array();
		for($i=0; $i<count($array2); $i++)
			if(strlen($array2[$i])>0)
				$silinmeyecekKontrolListeliEk2_2ler[] = $array2[$i];
		
		for($i=0; $i<count($buBiriminKontrolListeliEk2Tablosu2Inputs); $i++)
		{
			$silinmeyecekIndex = $i;
			if( strlen($silinmeyecekKontrolListeliEk2_2ler[$silinmeyecekIndex]) > 0)
			{
				$degerlerarray = explode("#", $buBiriminKontrolListeliEk2Tablosu2Selects[$i]);
				$selectValueArray = explode("-", $degerlerarray[0]);
				$basarimText = $degerlerarray[1];
				$sqlBasarimOlcuId = "SELECT BASARIM_OLCUTU_ID FROM M_BASARIM_OLCUTU WHERE BIRIM_ID = ? AND BASARIM_OLCUTU_ADI = ?";
				$basarimOlcuID = $_db->prep_exec($sqlBasarimOlcuId, array($birimID, $basarimText));
				//$selectValueArray = explode("-", $buBiriminKontrolListeliEk2Tablosu2Selects[$i]);
				$inputValue = $buBiriminKontrolListeliEk2Tablosu2Inputs[$i];
					
				$sql = "UPDATE m_birim_ek2_kntrl_listeli 
				SET 
					OGRENME_CIKTISI_INDEX=?, 
					BASARIM_OLCUTU_INDEX=?, 
					EK_YAZISI=?, 
					OGRENME_CIKTISI_ID=?, 
					BASARIM_OLCUTU_ID=?, 
					MESLEK_STANDARDI_BO_TEXT=?,
					SIRA_NO=?
				WHERE 
					EK2_KONTROL_LISTELI_ID=?";
				$params[] = $selectValueArray[0];
				$params[] = $selectValueArray[1];
				$params[] = $inputValue;
				$params[] = $ogrenmeCiktisiID;
				$params[] = $basarimOlcuID[0]["BASARIM_OLCUTU_ID"];
				//$params[] = $basarimOlcutuID;
				$params[] = $buBiriminKontrolListeliEk2Tablosu2Inputs_BO_Text[$i];
				$params[] = $buBiriminKontrolListeliEk2Tablosu2SiraNolari[$silinmeyecekIndex];
				$params[] = $silinmeyecekKontrolListeliEk2_2ler[$silinmeyecekIndex];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
			else
			{
				$degerlerarray = explode("#", $buBiriminKontrolListeliEk2Tablosu2Selects[$i]);
				$selectValueArray = explode("-", $degerlerarray[0]);
				$basarimText = $degerlerarray[1];
				$sqlBasarimOlcuId = "SELECT BASARIM_OLCUTU_ID FROM M_BASARIM_OLCUTU WHERE BIRIM_ID = ? AND BASARIM_OLCUTU_ADI = ?";
				$basarimOlcuID = $_db->prep_exec($sqlBasarimOlcuId, array($birimID, $basarimText));
				//$selectValueArray = explode("-", $buBiriminKontrolListeliEk2Tablosu2Selects[$i]);
				$inputValue = $buBiriminKontrolListeliEk2Tablosu2Inputs[$i];
					
				$sql = "INSERT  INTO m_birim_ek2_kntrl_listeli (EK2_KONTROL_LISTELI_ID, OGRENME_CIKTISI_INDEX, BASARIM_OLCUTU_INDEX, EK_YAZISI, EK_TIPI, OGRENME_CIKTISI_ID, BASARIM_OLCUTU_ID, BIRIM_ID, MESLEK_STANDARDI_BO_TEXT,SIRA_NO)
				VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$params[] = $_db->getNextVal(EK2_KNTRL_LISTELI_DEG_ARAC_SEQ);
				$params[] = $selectValueArray[0];
				$params[] = $selectValueArray[1];
				$params[] = $inputValue;
				$params[] = PM_BIRIM_EK2_TIPI__ANLAYIS;
				$params[] = $ogrenmeCiktisiID;
				$params[] = $basarimOlcuID[0]["BASARIM_OLCUTU_ID"];
				//$params[] = $basarimOlcutuID;
				$params[] = $birimID;
				$params[] = $buBiriminKontrolListeliEk2Tablosu2Inputs_BO_Text[$i];
				$params[] = $buBiriminKontrolListeliEk2Tablosu2SiraNolari[$i];
				$sqlResultTemp =  $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
				
			}
			
		}
		
		
		$array1 = explode('-',$_POST['duzenlemedenGeriyeKalanTeorikSinavlar']);
		$silinmeyecekTeorikIDler = array();
		for($i=0; $i<count($array1); $i++)
			if(strlen($array1[$i])>0)
				$silinmeyecekTeorikIDler[] = $array1[$i];
		
		for($i=1; $i<=count($buBiriminTeorikSinavlari); $i++)
		{
			
			
			// EÄ�ER SÄ°LÄ°NMEYECEK IDLER Ä°Ã‡Ä°NDEYSE UPDATE
			$silinmeyecekIndex = $i-1;
			if( strlen($silinmeyecekTeorikIDler[$silinmeyecekIndex]) > 0)
			{
				$buBiriminOlcmeDegerlendirmeleriIDArray['T'][$i] = $silinmeyecekTeorikIDler[$silinmeyecekIndex];
					
				$sql = "UPDATE m_birim_olcme_degerlendirme 
			SET OLC_DEG_NUMARA=?, 
				OLC_DEG_ACIKLAMA=?,
				SORU_SAYISI=?, 
				SORU_SAYISI_MAX=?, 
				SORU_SURESI_MIN_DK=?, 
				SORU_SURESI_MIN_SN=?, 
				SORU_SURESI_MAX_DK=?, 
				SORU_SURESI_MAX_SN=?, 
				BASARI_KRITERI=?,
				OLC_DEG_ADI=?,
				OLC_DEG_GECERLILIK_SURESI=?
				WHERE ID=?";
				$params[] = $i;
				$params[] = $buBiriminTeorikSinavlari[$i];
				$params[] = $buBiriminTeorikSinavlarininSoruSayilari[$i];
				$params[] = $buBiriminTeorikSinavlarininSoruSayilariMax[$i];
				$params[] = $buBiriminTeorikSinavlarininMinDkSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininMinSnSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininMaxDkSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininMaxSnSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininBasariKriterleri[$i];
				$params[] = $buBiriminTeorikSinavlarininAdlari[$i];
				$params[] = $buBiriminTeorikSinavlariGecerlilikSuresi[$i];
				$params[] = $silinmeyecekTeorikIDler[$silinmeyecekIndex];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
			else
			{
				// DÄ°Ä�ER TÃœRLÃœ EKLEME
			
				$olcmeDegerlendirmeID = $_db->getNextVal(BIRIM_OLCME_DEGERLENDIRME_SEQ);
				
				$buBiriminOlcmeDegerlendirmeleriIDArray['T'][$i] = $olcmeDegerlendirmeID;
				
				$sql = "INSERT  INTO m_birim_olcme_degerlendirme (ID, BIRIM_ID, OLC_DEG_HARF, OLC_DEG_NUMARA, OLC_DEG_ACIKLAMA, 
				SORU_SAYISI, SORU_SAYISI_MAX, SORU_SURESI_MIN_DK, SORU_SURESI_MIN_SN, SORU_SURESI_MAX_DK, SORU_SURESI_MAX_SN, BASARI_KRITERI, OLC_DEG_ADI,OLC_DEG_GECERLILIK_SURESI) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$params[] = $olcmeDegerlendirmeID;
				$params[] = $birimID;
				$params[] = 'T';
				$params[] = $i;
				$params[] = $buBiriminTeorikSinavlari[$i];
				$params[] = $buBiriminTeorikSinavlarininSoruSayilari[$i];
				$params[] = $buBiriminTeorikSinavlarininSoruSayilariMax[$i];
				$params[] = $buBiriminTeorikSinavlarininMinDkSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininMinSnSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininMaxDkSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininMaxSnSoruSureleri[$i];
				$params[] = $buBiriminTeorikSinavlarininBasariKriterleri[$i];
				$params[] = $buBiriminTeorikSinavlarininAdlari[$i];
				$params[] = $buBiriminTeorikSinavlariGecerlilikSuresi[$i];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
				
			
			}
			
			
		}
		
		
		$array2 = explode('-',$_POST['duzenlemedenGeriyeKalanPerformansSinavlari']);
		$silinmeyecekPerformansIDler = array();
		for($i=0; $i<count($array2); $i++)
			if(strlen($array2[$i])>0)
				$silinmeyecekPerformansIDler[] = $array2[$i];
		
		
		for($i=1; $i<=count($buBiriminPerformansSinavlari); $i++)
		{
			
			$silinmeyecekIndex = $i-1;
			if( strlen($silinmeyecekPerformansIDler[$silinmeyecekIndex]) > 0)
			{
				$buBiriminOlcmeDegerlendirmeleriIDArray['P'][$i] = $silinmeyecekPerformansIDler[$silinmeyecekIndex];
					
				
				$sql = "UPDATE m_birim_olcme_degerlendirme 
			SET OLC_DEG_NUMARA=?, 
				OLC_DEG_ACIKLAMA=?, 
				BASARI_KRITERI=?, 
				BASARI_KRITERI_ACIKLAMA=?,
				OLC_DEG_ADI=?,
				OLC_DEG_GECERLILIK_SURESI=?
			WHERE ID=? ";
				$params[] = $i;
				$params[] = $buBiriminPerformansSinavlari[$i];
				$params[] = $buBiriminPerformansSinavlarininBasariKriterleri[$i];
				$params[] = $buBiriminPerformansSinavlarininBasariKriterleriAciklama[$i];
				$params[] = $buBiriminPerformansSinavlarininAdlari[$i];
				$params[] = $buBiriminPerformansSinavlariGecerlilikSuresi[$i];
				$params[] = $silinmeyecekPerformansIDler[$silinmeyecekIndex];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
			else
			{
				$olcmeDegerlendirmeID = $_db->getNextVal(BIRIM_OLCME_DEGERLENDIRME_SEQ);
					
				$buBiriminOlcmeDegerlendirmeleriIDArray['P'][$i] = $olcmeDegerlendirmeID;
				
					
				$sql = "INSERT  INTO m_birim_olcme_degerlendirme (ID, BIRIM_ID, OLC_DEG_HARF,OLC_DEG_NUMARA, OLC_DEG_ACIKLAMA, BASARI_KRITERI, BASARI_KRITERI_ACIKLAMA, OLC_DEG_ADI,OLC_DEG_GECERLILIK_SURESI)
				VALUES (?,?,?,?,?,?,?,?,?) ";
				$params[] = $olcmeDegerlendirmeID;
				$params[] = $birimID;
				$params[] = 'P';
				$params[] = $i;
				$params[] = $buBiriminPerformansSinavlari[$i];
				$params[] = $buBiriminPerformansSinavlarininBasariKriterleri[$i];
				$params[] = $buBiriminPerformansSinavlarininBasariKriterleriAciklama[$i];
				$params[] = $buBiriminPerformansSinavlarininAdlari[$i];
				$params[] = $buBiriminPerformansSinavlariGecerlilikSuresi[$i];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
			
				
		}
		for($i=1; $i<=count($buBiriminDigerSinavlari); $i++)
		{
			$olcmeDegerlendirmeID = $_db->getNextVal(BIRIM_OLCME_DEGERLENDIRME_SEQ);
			
			$buBiriminOlcmeDegerlendirmeleriIDArray['D'][$i] = $olcmeDegerlendirmeID;
				
			$sql = "INSERT  INTO m_birim_olcme_degerlendirme (ID, BIRIM_ID, OLC_DEG_HARF, OLC_DEG_NUMARA, OLC_DEG_ACIKLAMA)
			VALUES (?,?,?,?,?) ";
			$params[] = $olcmeDegerlendirmeID;
			$params[] = $birimID;
			$params[] = 'D';
			$params[] = $i;
			$params[] = $buBiriminDigerSinavlari[$i];
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
		}
		
		for($i=0; $i<count($buBiriminKontrolsuzEk2Degerleri); $i++)
		{
			$ek2Variables = explode('-', $buBiriminKontrolsuzEk2Degerleri[$i]);
			
			$sql = " INSERT INTO m_birim_ek2_kntrl_listesiz (BASARIM_OLCUTU_ID, OLCME_DEGERLENDIRME_ID, OGRENME_CIKTISI_INDEX, BASARIM_OLCUTU_INDEX, SINAV_IDENTIFIER, SINAV_INDEX, BIRIM_ID )
			VALUES (?,?, ?,?,?,?,?) ";
			$params[] = $basarimOlcutuIDTable[$ek2Variables[0]][$ek2Variables[1]];
			$params[] = $buBiriminOlcmeDegerlendirmeleriIDArray[$ek2Variables[2]][$ek2Variables[3]];
			$params[] = $ek2Variables[0];
			$params[] = $ek2Variables[1];
			$params[] = $ek2Variables[2];
			$params[] = $ek2Variables[3];
			$params[] = $birimID;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
				
		}
		
		$gelistirenKurulusUpdateSQL = array();
		
		if(isset($postData['yeterliligiGelistirenKuruluslarCheckbox-'.$birimID]) && isset($postData['birimGelistirenKuruluslar-'.$birimID])){
			$buBirimiGelistirenKuruluslar = array_merge($postData['yeterliligiGelistirenKuruluslarCheckbox-'.$birimID],$postData['birimGelistirenKuruluslar-'.$birimID]);
		}else if(isset($postData['yeterliligiGelistirenKuruluslarCheckbox-'.$birimID])){
			$buBirimiGelistirenKuruluslar = $postData['yeterliligiGelistirenKuruluslarCheckbox-'.$birimID];
		}else if(isset($postData['birimGelistirenKuruluslar-'.$birimID])){
			$buBirimiGelistirenKuruluslar = $postData['birimGelistirenKuruluslar-'.$birimID];
		}
		for($i=0; $i<count($buBirimiGelistirenKuruluslar); $i++)
		{
		
			$sql = " INSERT INTO m_birim_gelistiren_kurulus (BIRIM_ID, KURULUS_ADI, YETERLILIKTEN_ALINTI)
			VALUES (?,?,?) ";
			$params[] = $birimID;
			$params[] = $buBirimiGelistirenKuruluslar[$i];
			$params[] = 0;
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
		}
		
		$kontrolListeliOlcmeDegerlendirmesi = $postData['kontrolListeliOlcmeDegerlendirmesi'][$birimID];
		foreach($kontrolListeliOlcmeDegerlendirmesi as $kontrolListeliEk2ID => $sinavDegeri)
		{
			$sql = "DELETE FROM M_BIRIM_EK2_KNTRL_LISTELI_DGRL WHERE EK2_KONTROL_LISTELI_ID = ?";
			$params = array($kontrolListeliEk2ID);
			$result = @$_db->prep_exec_insert($sql, $params);
			$params = array();
			
			for($i=0; $i<count($sinavDegeri); $i++)
			{
				$sinavAdi = split('-', $sinavDegeri[$i]);
				$sql = "INSERT  INTO M_BIRIM_EK2_KNTRL_LISTELI_DGRL (EK2_KONTROL_LISTELI_ID, DEGERLENDIRME_ARACI_HARF, DEGERLENDIRME_ARACI_NUMARA)
				VALUES (?,?,?) ";
				$params[] = $kontrolListeliEk2ID;
				$params[] = $sinavAdi[0];
				$params[] = $sinavAdi[1];
				$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
				$sqlResult = $sqlResultTemp && $sqlResult;
				$params = array();
			}
			
		
		}
		
		$buBirimiDogrulayanKomite = $postData['birimDogrulayanSektorKomitesi-'.$birimID];
		for($i=0; $i<count($buBirimiDogrulayanKomite); $i++)
		{
		
			$sql = "INSERT  INTO m_birim_dogrulayan_komite (BIRIM_ID, KOMITE_UYESI_ADI)
			VALUES (?,?) ";
			$params[] = $birimID;
			$params[] = $buBirimiDogrulayanKomite[$i];
			$sqlResultTemp = $_db->prep_exec_insert($sql, $params);
			$sqlResult = $sqlResultTemp && $sqlResult;
			$params = array();
				
		}
		
		$updateSql = "UPDATE m_birim SET BIRIM_ADI=?, EK2_KONTROL_LISTELIMI = ?,BIRIM_EK1_ACIKLAMASI = ?  WHERE BIRIM_ID = ?";
		$updParams[] = $_POST['birimAdiTextbox'];
		
		$updParams[] = $_GET['ek2KontrolListeliMi'];
		$updParams[] = $_POST['EK1_EgitimIcerigiAciklamasi-'.$birimID];
		$updParams[] = $birimID;
		$updateResult = $_db->prep_exec_insert($updateSql, $updParams);

		
		$user = & JFactory::getUser();
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		if($isSektorSorumlusu)
		{
			$kaydedilecekBirimKodu = $_POST['birimDetayiPopup-BirimKodu-'.$birimID];
			$kaydedilecekBirimSeviyesi = $_POST['birimDetayiPopup-BirimSeviyesi-'.$birimID];
			$kaydedilecekBirimKredisi = $_POST['birimDetayiPopup-BirimKredisi-'.$birimID];
			$kaydedilecekBirimYayinTarihi = $_POST['birimDetayiPopup-BirimYayinTarihi-'.$birimID];
			$kaydedilecekBirimRevizyonNo = $_POST['birimDetayiPopup-BirimRevizyonNo-'.$birimID];
			$kaydedilecekBirimTarihi = $_POST['birimDetayiPopup-BirimTarihi-'.$birimID];
			$kaydedilecekMYKYKOnayTarihi = $_POST['birimDetayiPopup-MYKYKOnayTarihi-'.$birimID];
			$kaydedilecekMYKYKOnaySayi = $_POST['birimDetayiPopup-MYKYKOnaySayi-'.$birimID];
			$kaydedilecekBirimGecerlilikSuresi = $_POST['birimDetayiPopup-BirimGecerlilikSuresi-'.$birimID];
			$updParams = array();
			$updateSql = "UPDATE m_birim SET 
							BIRIM_KODU=?, 
							BIRIM_SEVIYE = ?,
							BIRIM_KREDI = ?,  
							BIRIM_YAYIN_TAR = TO_DATE(?,'dd.mm.yyyy'),
							BIRIM_REV_NO = ?,
							BIRIM_REV_TAR = TO_DATE(?,'dd.mm.yyyy'),
							BIRIM_MYK_YK_ONAY_TAR=?,
							BIRIM_MYK_YK_ONAY_SAYI=?,
							BIRIM_GECERLILIK_SURESI=?
						WHERE BIRIM_ID = ?";
			$updParams[] = $kaydedilecekBirimKodu;
			$updParams[] = $kaydedilecekBirimSeviyesi;
			$updParams[] = $kaydedilecekBirimKredisi;
			$updParams[] = $kaydedilecekBirimYayinTarihi;
			$updParams[] = $kaydedilecekBirimRevizyonNo;
			$updParams[] = $kaydedilecekBirimTarihi;
			$updParams[] = $kaydedilecekMYKYKOnayTarihi;
			$updParams[] = $kaydedilecekMYKYKOnaySayi;
			$updParams[] = $kaydedilecekBirimGecerlilikSuresi;
			$updParams[] = $birimID;
			
			$updateResult2 = $_db->prep_exec_insert($updateSql, $updParams);
			$updateResult = $updateResult && $updateResult2;
		}
		
		
		$yerineGecerliBirims = explode(",",$postData['yerineGecerliBirim-'.$birimID]);
		foreach ($yerineGecerliBirims as $val){
			$sql = 	"INSERT INTO M_BIRIM_YERINE_GECERLI(ID,BIRIM_ID,YERINE_GECERLI_BIRIM_ID,EKLENME_TARIHI,USER_ID) VALUES(?,?,?,?,?)";	
			$params = array($_db->getNextVal('SEQ_YERINGE_GECERLI_BIRIM_ID'),
						    $birimID,
						    $val,
							date(),
							$user->getOracleUserId ());
			$_db->prep_exec_insert($sql, $params);
		}
		 
		 if( $sqlResult == true)
		ajax_success_response_with_array("Başarılı", $postData);
		else
			ajax_error_response($sql);
		
	}
	
	function isTaslak ($evrak_id){
		return ($this->getEvrakDurumId ($evrak_id) == KAYDEDILMIS_BASVURU_SEKLI_ID);
	}
	
	function getYeterlilikInfo($yeterlilik_Id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_yeterlilik join pm_yeterlilik_durum using(yeterlilik_durum_id) join pm_yeterlilik_surec_durum using(yeterlilik_surec_durum_id)
				WHERE YETERLILIK_ID = ?";
		
		$params = array ($yeterlilik_Id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminEk2si_KontrolListesiz($birimID)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_birim_ek2_kntrl_listesiz
				JOIN M_BASARIM_OLCUTU USING (BASARIM_OLCUTU_ID)
				WHERE m_birim_ek2_kntrl_listesiz.birim_id = ? ORDER BY OGRENME_CIKTISI_INDEX, BASARIM_OLCUTU_INDEX, SINAV_IDENTIFIER, SINAV_INDEX";
		
		$params = array ($birimID);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminEk2si_KontrolListeli($birimID, $tabloTuru)
	{
		if($tabloTuru!='')
		{
			$_db = &JFactory::getOracleDBO();
			
			/*$sql= "SELECT m_birim_ek2_kntrl_listeli.*, basarim_olcutu_adi FROM m_birim_ek2_kntrl_listeli, M_BASARIM_OLCUTU
				 WHERE m_birim_ek2_kntrl_listeli.basarim_olcutu_id = m_basarim_olcutu.basarim_olcutu_id
				 AND birim_id = ? AND ek_tipi=".$tabloTuru." ORDER BY 
				 m_birim_ek2_kntrl_listeli.SIRA_NO";*/
			
			$sql= "SELECT m_birim_ek2_kntrl_listeli.*, basarim_olcutu_adi FROM m_birim_ek2_kntrl_listeli
							 JOIN M_BASARIM_OLCUTU ON M_BIRIM_EK2_KNTRL_LISTELI.BIRIM_ID = M_BASARIM_OLCUTU.BIRIM_ID 
							 AND M_BIRIM_EK2_KNTRL_LISTELI.BASARIM_OLCUTU_ID = M_BASARIM_OLCUTU.BASARIM_OLCUTU_ID
							 WHERE m_birim_ek2_kntrl_listeli.birim_id = ? AND m_birim_ek2_kntrl_listeli.ek_tipi=".$tabloTuru." ORDER BY 
							 m_birim_ek2_kntrl_listeli.SIRA_NO";
			
			$params = array ($birimID);
			
			$data = $_db->prep_exec($sql, $params);
			
			if (!empty($data))
				return $data;
			else
				return null;
		}
		else
		{
			$_db = &JFactory::getOracleDBO();
			
			$sql= "SELECT * FROM m_birim_ek2_kntrl_listeli
			WHERE birim_id = ?
			ORDER BY m_birim_ek2_kntrl_listeli.SIRA_NO ";
			
			$params = array ($birimID);
			
			$data = $_db->prep_exec($sql, $params);
			
			if (!empty($data))
				return $data;
			else
				return null;
		}
		
	}
	

	function getBiriminEk2KontrolListeli_OlcmeDegerlendirmesi($ek2KontrolListeliID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_ek2_kntrl_listeli_dgrl
		WHERE ek2_kontrol_listeli_id=?";
	
		$params = array ($ek2KontrolListeliID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminKaynaklari($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT kaynak_id FROM m_birim_kaynak
		WHERE birim_id = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec_array($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminKaynaklariTextListesi($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT standart_adi 
		FROM m_birim_kaynak JOIN m_meslek_standartlari ON (m_birim_kaynak.kaynak_id = m_meslek_standartlari.standart_id)
		WHERE birim_id = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec_array($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminKaynaklariListesi($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT *
		FROM m_birim_kaynak JOIN m_meslek_standartlari ON (m_birim_kaynak.kaynak_id = m_meslek_standartlari.standart_id)
		WHERE birim_id = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getYeterliliginSektoru($yeterlilik_Id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_yeterlilik, pm_sektorler
		WHERE  m_yeterlilik.sektor_id = pm_sektorler.sektor_id AND m_yeterlilik.yeterlilik_id = ?";
	
		$params = array ($yeterlilik_Id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBirimiGelistirenKuruluslar($birimID)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_birim_gelistiren_kurulus
				WHERE BIRIM_ID = ?";
		
		$params = array ($birimID);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getBirimiDogrulayanKomiteUyeleri($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_dogrulayan_komite
		WHERE BIRIM_ID = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getYeterlilik ($user_id){
		$_db = &JFactory::getOracleDBO();
	
		$params = array ($user_id);
	
		$sql = "SELECT m_yeterlilik.YETERLILIK_ID,
				m_yeterlilik.YETERLILIK_ADI,
				m_yeterlilik.YETERLILIK_KODU,
    			m_yeterlilik.SEVIYE_ID,
    			m_yeterlilik.REVIZYON,
				SEVIYE_ADI,
				YETERLILIK_BASLANGIC AS BASLANGIC_TARIHI_FORMATTED,
				YETERLILIK_SUREC_DURUM_ADI,
				m_yeterlilik.YETERLILIK_SUREC_DURUM_ID,
				m_yeterlilik.YETERLILIK_DURUM_ID,
				YETERLILIK_SUREC_DURUM_ADI,
				YETERLILIK_DURUM_ADI,
				m_yeterlilik.SEKTOR_ID,
				SEKTOR_ADI,
				user_id,
				M_YETERLILIK.YENI_MI
		FROM m_yeterlilik,
			pm_seviye,
			pm_yeterlilik_surec_durum,
			pm_yeterlilik_durum,
			pm_sektorler,
			m_yetki_yeterlilik,
			m_kurulus_yetki,
			m_yetki
		WHERE m_yeterlilik.YETERLILIK_ID = m_yetki_yeterlilik.YETERLILIK_ID
			AND m_yetki_yeterlilik.YETKI_ID = m_kurulus_yetki.YETKI_ID
			AND m_yetki_yeterlilik.YETKI_ID = m_yetki.YETKI_ID
			AND m_yetki.ETKIN = 1
			AND m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = pm_yeterlilik_surec_durum.YETERLILIK_SUREC_DURUM_ID
			AND m_yeterlilik.YETERLILIK_DURUM_ID = pm_yeterlilik_durum.YETERLILIK_DURUM_ID
			AND m_yeterlilik.SEKTOR_ID = pm_sektorler.SEKTOR_ID
			AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
			AND m_yeterlilik.yeterlilik_durum_id IN (".PM_YETERLILIK_DURUMU__ONTASLAK.")
			AND user_id = ?";
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getYeterlilikESKI ($user_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT 	YETERLILIK_ID,
						YETERLILIK_ADI,
						SEVIYE_ADI,
						SEKTOR_ADI 
			   FROM m_yeterlilik 
			   	  JOIN m_yeterlilik_evrak USING (yeterlilik_id) 
			   	  JOIN m_basvuru USING (evrak_id)
			   	  JOIN pm_seviye USING (seviye_id)
			   	  JOIN pm_sektorler USING (sektor_id) 
			   	  JOIN pm_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_id)  
			   WHERE user_id = 5596 AND 
         yeterlilik_durum_id in (-3,-2,-1,-0)
			   ORDER BY yeterlilik_id";
		
		$params = array ($user_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getOnayliYeterlilik (){//Azat
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik 
			   WHERE YETERLILIK_SUREC_DURUM_id = 1     
			   ORDER BY yeterlilik_adi";
			
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getZorunluHariciBirim ($yeterlilik_id){//Azat
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT *  
			   FROM m_yeterlilik_birim_harici 
			   WHERE yeterlilik_id=? and zorunlu=0";
			
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getSecmeliHariciBirim ($yeterlilik_id){//Azat
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT *  
			   FROM m_yeterlilik_birim_harici 
			   WHERE yeterlilik_id=? and zorunlu=1";
			
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	
	function getYeterlilikAltBirim ($yeterlilik_id){//Azat
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik_alt_birim_yeni 
			   WHERE yeterlilik_id=?     
			   ORDER BY yeterlilik_alt_birim_adi";
			
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getEklenmisBirim ($yeterlilik_id){//Azat
		$_db = &JFactory::getOracleDBO();
		$selectedFieldValues = "m_yeterlilik.yeterlilik_id, m_yeterlilik.seviye_id, 
		m_birim.birim_id, 
		m_birim.birim_kodu, 
		m_birim.birim_adi, 
		m_birim.birim_seviye, 
		m_birim.BIRIM_KREDI, 
		m_birim.BIRIM_YAYIN_TAR, 
		m_birim.BIRIM_REV_NO, 
		m_birim.BIRIM_REV_TAR,
		m_birim.EK2_KONTROL_LISTELIMI,
		m_birim.BIRIM_EK1_ACIKLAMASI,
		m_birim.bagimsizmi, 
		m_birim.BIRIM_MYK_YK_ONAY_TAR, 
		m_birim.BIRIM_MYK_YK_ONAY_SAYI, 
		m_birim.BIRIM_GECERLILIK_SURESI, 
		m_yeterlilik_birim.zorunlu, 
		m_yeterlilik_birim.sira_no, y2.*,'1' AS YENI_MI";
	
		$sql= "SELECT ".$selectedFieldValues."
		FROM m_yeterlilik, m_yeterlilik_birim, m_birim, pm_birim_onay_durumu, 
        (select yeterlilik_id as bagimli_oldugu_yet_id2,
          yeterlilik_adi as bagimli_oldugu_yeterlilik_adi,
          yeterlilik_kodu as bagimli_oldugu_yet_kodu,
          seviye_id as bagimli_oldugu_yet_seviye_id 
        from m_yeterlilik) y2
		WHERE m_yeterlilik.yeterlilik_id=?
		AND m_yeterlilik.yeterlilik_id = m_yeterlilik_birim.yeterlilik_id
		AND m_yeterlilik_birim.birim_id = m_birim.birim_id
		AND m_birim.birim_onay_durum = pm_birim_onay_durumu.durum_id(+)
    AND m_birim.bagimli_oldugu_yet_id = y2.bagimli_oldugu_yet_id2 (+)
		ORDER BY m_yeterlilik_birim.sira_no";
		
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
		
		for($i = 0 ; $i<count($data); $i++){
			$sql_birim = "SELECT COUNT(BILDIRIM_ID) AS BILDIRIM_SAYISI FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE BIRIM_ID = ?";
			$sayi = $_db->prep_exec($sql_birim, array($data[$i]['BIRIM_ID']));
			
			if($sayi[0]['BILDIRIM_SAYISI'] > 0){
				$data[$i]['BIRIM_PROTECH'] = true;
			}else{
				$data[$i]['BIRIM_PROTECH'] = false;
			}
		}
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getYeterlilikTumBirim (){//Azat
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_yeterlilik_alt_birim_yeni where YETERLILIK_ALT_BIRIM_ONAY_TAR<>'null'
			   ORDER BY yeterlilik_alt_birim_adi";
			
		$params = array ();
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getGenelKurulTarihleri ($etkin){
		$db = JFactory::getOracleDBO();
		$sql = "SELECT distinct tarih
			FROM M_GENEL_KURUL
			WHERE aktif_mi='".$etkin."'
			ORDER BY tarih desc";
		 
		return $db->prep_exec($sql, array());
	}
	
	function canEdit ($user, $yeterlilik_id){
		$juser 	= &JFactory::getUser();
		$user_id= $juser->getOracleUserId ();
		$isSektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);	
		$isYetkiliSektorSorumlusu  = FormFactory::getSorumluSektorId ($user_id, 1);	
		$isKurulus			= $this->yetkiliYeterlilikKurulusuMu ($user);
//		$evrak_durum 		= $this->getEvrakDurumId ($evrak_id);	
		//$yeterlilik_id		= $this->getYeterlilikId ($yeterlilik_id);
		$yeterlilik_durum 	  = $this->getYeterlilikDurumId ($yeterlilik_id);
		$editable			= $this->getEditable ($yeterlilik_id);
		$YETERLILIK_SUREC_DURUM	= $this->getYeterlilikSurecDurumId ($yeterlilik_id);
		
	 	// Sektor Sorumlusu
		if ($isSektorSorumlusu){
// 			if (in_array(0, $isYetkiliSektorSorumlusu)){
// 				return true;
// 			}
// 			if ($YETERLILIK_SUREC_DURUM == ONAYLANMIS_YETERLILIK){
// 				return false;
// 			}
			return true;
		}// Kurulus
		else if ($isKurulus){ 
			//On Basvuru Bitirme asamasindaysa
			if ($yeterlilik_durum == PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK){	
				return false;	
			}
			
			if ($editable == 1)
				return true;
			else if ($editable == 0)
				return false;
				
//			//Taslagi Bitirme asamasindaysa
//			if ($YETERLILIK_SUREC_DURUM == IMZA_BEKLENEN_YETERLILIK){
//				return false;
//			}
			
			return true;
			
		}else{
			return false;
		}
	}
	
	function getEditable ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT editable  
			   FROM m_taslak_yeterlilik    
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getYeterlilikId ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT yeterlilik_id 
				FROM m_taslak_yeterlilik  
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function yetkiliYeterlilikKurulusuMu ($user){
		return FormFactory::checkAclGroupId($user->id, YT2_GROUP_ID);
	}
	
	function getYeterlilikBilgi ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT YETERLILIK_ADI,
					  SEVIYE_ADI,
					  YETERLILIK_KODU,
					  REVIZYON_NO,
					  SEKTOR_ADI, 
					  TO_CHAR (m_yeterlilik.YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
					  TO_CHAR (m_yeterlilik.REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (m_yeterlilik.KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  KARAR_SAYI,
					  SEVIYE_ID,
					  YETERLILIK_SUREC_DURUM_ID,
					  YETERLILIK_DURUM_ID,
					  SEKTOR_ADI,
					  REVIZYON,
					  YENI_MI,
				      BELGE_ZORUNLULUK_DURUM,
					  TEHLIKELI_IS_DURUM
			   FROM m_yeterlilik 
			   	  JOIN m_taslak_yeterlilik USING (yeterlilik_id) 
			   	  JOIN pm_sektorler USING (sektor_id) 
			   	  JOIN pm_seviye USING (seviye_id) 
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);

		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function canOpenEkler ($yeterlilik_id, $user){
		if ($this->yetkiliYeterlilikKurulusuMu ($user))
			return true;
		else if (FormFactory::sektorSorumlusuMu ($user))
			return true;
		else if ($this->getYeterlilikDurumId ($yeterlilik_id) == ONAYLANMIS_YETERLILIK)
			return true;
			
		return false;
	}

	function getYeterlilikBirimleri($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * FROM m_yeterlilik, m_yeterlilik_birim, m_birim WHERe m_yeterlilik.yeterlilik_id = m_yeterlilik_birim.yeterlilik_id 
		AND m_yeterlilik_birim.birim_id = m_birim.birim_id AND m_yeterlilik.yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}

	function getBiriminOlcmeDegerlendirmeleri($birimID, $olcmeDegerlendirmeTipi )
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
		FROM m_birim_olcme_degerlendirme 
		WHERE birim_id=? AND olc_deg_harf=?
		ORDER BY OLC_DEG_HARF,OLC_DEG_NUMARA";
		
		$params = array ($birimID, $olcmeDegerlendirmeTipi );
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	
	function aktifYetkilendirmesiVarMi($yeterlilik_id, $user_id)
	{
	
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT * FROM M_YETKI_YETERLILIK JOIN M_YETKI USING (YETKI_ID) JOIN M_KURULUS_YETKI USING (YETKI_ID)
WHERE ETKIN=1 AND YETERLILIK_ID = ? AND USER_ID = ?";
		$params = array ($yeterlilik_id, $user_id);
	
		if(count($_db->prep_exec($sql, $params)) > 0)
			return true;
		else
			return false;
	}
	
	
	function getYeterlilikKaynagi($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT * FROM M_YETERLILIK_KAYNAK JOIN M_MESLEK_STANDARTLARI ON (M_YETERLILIK_KAYNAK.KAYNAK_ID = M_MESLEK_STANDARTLARI.STANDART_ID)
WHERE YETERLILIK_ID = ?";
		
		$params = array ($yeterlilik_id);
		
		return $_db->prep_exec($sql, $params);
	}
	function getEk2KontrolListele_DegerlendirmeAraclari ($ek2_kontrol_listeli_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_BIRIM_EK2_KNTRL_LISTELI_DGRL 
		where EK2_KONTROL_LISTELI_ID=? ORDER BY DEGERLENDIRME_ARACI_HARF, DEGERLENDIRME_ARACI_NUMARA";
		$params = array ($ek2_kontrol_listeli_id);
		
		return $_db->prep_exec($sql, $params);
	}
	
    function GetAlternatif($yeterlilik_id){
        $_db = &JFactory::getOracleDBO();
        $return = array();
        $sql = "SELECT ALTERNATIF_TIPI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
        
        $alternatifTip = $_db->prep_exec($sql,array($yeterlilik_id));
        $altTip = $alternatifTip[0]['ALTERNATIF_TIPI'];
        
        if($altTip == 1){
            $sql = "SELECT MIN_SECMELI_BIRIM_SAYISI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
            $data = $_db->prep_exec($sql,array($yeterlilik_id));
            return $data[0]['MIN_SECMELI_BIRIM_SAYISI'];
        }else {
           $sql = "SELECT * FROM M_YETERLILIK_ALTERNATIF
                            WHERE YETERLILIK_ID = ? ORDER BY ALTERNATIF_ID DESC";

            $data = $_db->prep_exec($sql, array($yeterlilik_id));
    // 		FROM m_birim, m_yeterlilik_birim
    // 		WHERE m_birim.birim_id = m_yeterlilik_birim.birim_id
            foreach ($data as $cow){
                    $return['data'][$cow['ALTERNATIF_ID']] = $cow;
                    $sql1 = "SELECT * FROM M_YETERLILIK_ALTERNATIF_BIRIM
                                            JOIN M_BIRIM ON M_YETERLILIK_ALTERNATIF_BIRIM.BIRIM_ID = M_BIRIM.BIRIM_ID
                                            JOIN M_YETERLILIK_BIRIM ON M_YETERLILIK_ALTERNATIF_BIRIM.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID
                                            WHERE ALTERNATIF_ID = ? ORDER BY M_BIRIM.BIRIM_ID ASC";

                    $birimdata = $_db->prep_exec($sql1, array($cow['ALTERNATIF_ID']));
                    if(count($birimdata) == 0){
                            $return['birims'][$cow['ALTERNATIF_ID']] = $birimdata;
                    }
                    else{
                            foreach ($birimdata as $tow){
                                    $return['birims'][$cow['ALTERNATIF_ID']][$tow['BIRIM_ID']] = $tow;
                            }
                    }
                    // 			$return['birims'][$cow['ALTERNATIF_ID']] = $birimdata;
            }

            return $return;
        }
    }

    function getAltBirimTur ($birims){
    	$_db = &JFactory::getOracleDBO();
    
    	$sql= "SELECT * FROM M_BIRIM_OLCME_DEGERLENDIRME WHERE BIRIM_ID = ? AND OLC_DEG_HARF != 'D' ORDER BY BIRIM_ID ASC, ID ASC";
    
    	$birimTur = array();
    	foreach ($birims as $row){
			$birimTur[$row['BIRIM_ID']] = $_db->prep_exec($sql, array($row['BIRIM_ID']));
    	}
    
    	if (!empty($birimTur))
    		return $birimTur;
    	else
    		return array ();
    }
    
    function AlternatifGetir($post){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_YETERLILIK_ALTERNATIF_BIRIM 
					JOIN M_BIRIM USING(BIRIM_ID) 
					WHERE ALTERNATIF_ID = ?";
		
		$data = $_db->prep_exec($sql, array($post['alternatifId']));
		
		$sqlAlt = "SELECT * FROM M_YETERLILIK_ALTERNATIF WHERE ALTERNATIF_ID = ?";
		
		$altBilgi = $_db->prep_exec($sqlAlt, array($post['alternatifId']));
		
		return array(0=>$data,1=>$altBilgi[0]);
    }
    
    function birimsTur($yeterlilik_id){
    	$_db = &JFactory::getOracleDBO();
    	
    	$sql = "SELECT * FROM M_BIRIM 
				JOIN M_YETERLILIK ON M_BIRIM.BAGIMLI_OLDUGU_YET_ID = M_YETERLILIK.YETERLILIK_ID 
    			WHERE YETERLILIK_ID = ?";
    	$birims = $_db->prep_exec($sql, array($yeterlilik_id));
    	
    	$birimturs = array();
    	$sqlBirimTur = "SELECT * FROM M_BIRIM 
						JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID)
						WHERE OLC_DEG_HARF != 'D' AND BIRIM_ID = ?";
    	foreach($birims as $row){
    		$turs = $_db->prep_exec($sqlBirimTur, array($row['BIRIM_ID']));
    		foreach($turs as $cow){
    			if($cow['OLC_DEG_HARF'] == 'T'){
    				$birimturs[$row['BIRIM_ID']]['T'][] = $cow;
    			}else if($cow['OLC_DEG_HARF'] == 'P'){
    				$birimturs[$row['BIRIM_ID']]['P'][] = $cow;
    			}
    		}
    	}
    	return $birimturs;
    }
    
    function kayitliBirimTur($yeterlilik_id){
    	$_db = &JFactory::getOracleDBO();
    	
    	$sql = "SELECT * FROM M_BIRIM
				JOIN M_YETERLILIK ON M_BIRIM.BAGIMLI_OLDUGU_YET_ID = M_YETERLILIK.YETERLILIK_ID
    			WHERE YETERLILIK_ID = ?";
    	$birims = $_db->prep_exec($sql, array($yeterlilik_id));
    	
    	$birimturs = array();
    	$sqlBirimTur = "SELECT * FROM M_BIRIM_ALTERNATIF_TUR
						WHERE BIRIM_ID = ?";
    	foreach($birims as $row){
    		$turs = $_db->prep_exec($sqlBirimTur, array($row['BIRIM_ID']));
    		foreach($turs as $cow){
    			$birimturs[$row['BIRIM_ID']][$cow['ALTERNATIF_TUR_ID']][] = $cow;
//     			if($cow['BIRIM_TUR'] == 'T'){
//     				$birimturs[$row['BIRIM_ID']]['T'][$cow['ALTERNATIF_TUR_ID']][] = $cow;
//     			}else if($cow['BIRIM_TUR'] == 'P'){
//     				$birimturs[$row['BIRIM_ID']]['P'][$cow['ALTERNATIF_TUR_ID']][] = $cow;
//     			}
    		}
    	}
    	return $birimturs;
    }
    
    function alternatifTurSil($post){
    	$_db = &JFactory::getOracleDBO();
    	$id = $post['alterTurId'];
    	
    	$sql= "DELETE FROM M_BIRIM_ALTERNATIF_TUR WHERE ALTERNATIF_TUR_ID=?";
		$params = array($id);
		$result = $_db->prep_exec_insert($sql, $params);
		if($result){
			return 1;
		}else{
			return 2;
		}
    }
    
    function getPmYeterlilikDurumlar(){
    	$db = &JFactory::getOracleDBO();
    	$yeterlilik_durum = $db->prep_exec("SELECT * FROM PM_YETERLILIK_DURUM ORDER BY YETERLILIK_DURUM_ID", array());
    	return $yeterlilik_durum;
    }
    function YeterlilikGetirByStatus($status){
    	$db = &JFactory::getOracleDBO();
    	$condition = ($status == null || $status == "" ? "" : " AND YETERLILIK_DURUM_ID=".$status);
    	$yeterlilikler = $db->prep_exec("SELECT M_YETERLILIK.YETERLILIK_ID,M_YETERLILIK.YETERLILIK_ADI||' - '||PM_SEVIYE.SEVIYE_ADI||' - Revizyon '||M_YETERLILIK.REVIZYON AS YETERLILIK_ADI FROM M_YETERLILIK INNER JOIN PM_SEVIYE ON M_YETERLILIK.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID WHERE 1 = 1 ".$condition." ORDER BY M_YETERLILIK.YETERLILIK_ADI", array());
    	return $yeterlilikler;
    }
    function getYeterlilikSablon($layout,$yetid) {
    	$db = &JFactory::getOracleDBO();
    	switch ($layout) {
    		case "tanitim":
    			$standartlar  = $db->prep_exec("SELECT * FROM M_YETERLILIK_ULUS_STANDART WHERE YETERLILIK_ID='".$yetid."'",array());
    			$yeterlilik_amac = $db->prep_exec_clob("SELECT * FROM M_TASLAK_YETERLILIK WHERE YETERLILIK_ID='".$yetid."'", array(), "YETERLILIK_AMAC");	
    			$result['AMAC']	= $yeterlilik_amac;
    			$i = 0;
    			foreach ($standartlar as $standart){
    				$result['STANDART'][$i] = $standart;
    				$i++;
    			}
    		break;
    		case "yeterlilik_kaynagi":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['YETERLILIK_EGITIM_SEKIL'] = $data['YETERLILIK_EGITIM_SEKIL'];
    		break;
    		case "yeterlilik_sartlari":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['YETERLILIK_EGITIM_SEKIL'] = $data['YETERLILIK_EGITIM_SEKIL'];
    		break;
    		case "yeterliligin_yapisi":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['BIRIMLERIN_GRUPLANDIRILMA'] = $data['BIRIMLERIN_GRUPLANDIRILMA'];
    			$result['ILAVE_OGRENME_CIKTILARI'] = $data['ILAVE_OGRENME_CIKTILARI'];
    		break;
    		case "olcme_ve_degerlendirme":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['YETERLILIK_ORTAM'] = $data['YETERLILIK_ORTAM'];
    		break;
    		case "aciklama":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['ACIKLAMA']['YETERLILIK_GECERLILIK_SURE'] = $data['YETERLILIK_GECERLILIK_SURE'];
    			$result['ACIKLAMA']['YETERLILIK_METHOD_GOZETIM'] = $data['YETERLILIK_METHOD_GOZETIM'];
    			$result['ACIKLAMA']['YETERLILIK_ORTAM'] = $data['YETERLILIK_DEG_YONTEM'];
    			$result['GELISTIREN'] = $this->getKurulusValues ($yetid, YET_GELISTIREN_KURULUS);
    		break;
    		case "ek_3":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['MESLEKTE_YATAY_DIKEY'] = $data['MESLEKTE_YATAY_DIKEY'];
    		break;
    		case "ek_4":
    			$data = $this->getTaslakYeterlilik ($yetid);
    			$result['DEGERLENDIRICI_OLCUT'] = $data['DEGERLENDIRICI_OLCUT'];
    		break;
    		case "ek_5":
    			$data = $this->getEk5Tablosu($yetid);
    			$result['KURUM_KURULUS'] = $data;
    		break;
    		case "ek_6":
    			$data = $this->getEk6Tablosu($yetid);
    			$result['KURUM_KURULUS'] = $data;
    		break;
    		case "ek_9":
    			$data = $this->getTaslakYeterlilik($yetid);
    			$result['YETERLILIK_EK_ACIKLAMA'] = $data['YETERLILIK_EK_ACIKLAMA'];
    		break;
    		default:
    			;
    		break;
    	}
    	return $result;
    }
    
    function getTaslakBilgi ($yeterlilik_id){
    	$_db = &JFactory::getOracleDBO();
    
    	$sql= "SELECT YETERLILIK_ADI,
					  SEVIYE_ADI,
					  SEKTOR_ADI,
					  YETERLILIK_SUREC_DURUM_ID,
					  YETERLILIK_SUREC_DURUM_ADI,
					  YETERLILIK_KODU,
					  EDITABLE,
					  ILK_TASLAK_PDF,
					  RESMI_GORUS_ONCESI_PDF,
					  SEKTOR_KOMITESI_ONCESI_PDF,
					  YONETIM_KURULU_ONCESI_PDF,
					  SON_TASLAK_PDF,
					  GECERLILIK_SURESI
			   FROM m_taslak_yeterlilik
			   	 JOIN m_yeterlilik 		  USING (yeterlilik_id)
			   	 JOIN pm_seviye    		  USING (seviye_id)
			   	 JOIN pm_sektorler 		  USING (sektor_id)
			   	 JOIN pm_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_id)
			   WHERE yeterlilik_id = ?";
  
    	$params = array ($yeterlilik_id);
    
    	$data = $_db->prep_exec($sql, $params);
    
    	if (!empty($data))
    		return $data[0];
    	else
    		return null;
    }
    
    
    function getRevizyonBilgi ($yeterlilik_id,$revizyon_no=""){
    	$_db = &JFactory::getOracleDBO();
    
    	if ($revizyon_no==""){
    		$revizyon_no=$this->revizyonVarMi($yeterlilik_id);
    	}
    	if ($revizyon_no=="00"){
    		$sql= "SELECT
					  REVIZYON_NO,
					  YETERLILIK_KODU,
					  TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  TO_CHAR (GORUSE_CIKMA_TARIHI, 'dd.mm.yyyy') GORUSE_CIKMA_TARIHI,
					  TO_CHAR (SON_GORUS_TARIHI	  , 'dd.mm.yyyy') SON_GORUS_TARIHI,
					  KARAR_SAYI
			   FROM m_yeterlilik
			   	  JOIN m_taslak_yeterlilik USING (yeterlilik_id)
			   WHERE yeterlilik_id = ?";
    		$params = array ($yeterlilik_id);
    	} else {
    		$sql= "SELECT
			REVIZYON_NO,
			YETERLILIK_KODU,
			TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
			TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
			TO_CHAR (YKK_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
			TO_CHAR (GORUSE_CIKMA_TARIHI, 'dd.mm.yyyy') GORUSE_CIKMA_TARIHI,
			TO_CHAR (SON_GORUS_TARIHI	  , 'dd.mm.yyyy') SON_GORUS_TARIHI,
			YKK_SAYISI as KARAR_SAYI,
			REVIZYON_DURUMU,
			RESMI_GORUS_ONCESI_PDF,
		  	SEKTOR_KOMITESI_ONCESI_PDF,
		  	YONETIM_KURULU_ONCESI_PDF,
		  	SON_TASLAK_PDF
    
			FROM m_yeterlilik_revizyon
			WHERE yeterlilik_id = ? and REVIZYON_NO= ? ";
    
    		$params = array ($yeterlilik_id,$revizyon_no);
    	}
    
    	$data = $_db->prep_exec($sql, $params);
    
    	if (!empty($data))
    		return $data[0];
    	else
    		return null;
    }
    
	function revizyonVarMi($yeterlilik_id){
    	$_db = &JFactory::getOracleDBO();
    	$sql="select REVIZYON from M_YETERLILIK where yeterlilik_id=$yeterlilik_id order by revizyon desc";
    	$sonuc=$_db->prep_exec($sql, array());
    	if ($sonuc){
    		return $sonuc[0]['REVIZYON'];
    	} else {
    		return "00";
    	}
    }
    
    function getYeterlilikDurum($revizyon_mu){
    	$_db = &JFactory::getOracleDBO();
    	if ($revizyon_mu==1){
    		$sqlpart="pm_YETERLILIK_REVIZYON_SUREC";
    	} else {
    		$sqlpart="pm_YETERLILIK_SUREC_DURUM";
    	}
    
    	$sql= "SELECT *
			   FROM ".$sqlpart."
			   WHERE YETERLILIK_SUREC_DURUM_id != ".PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK."
			   ORDER BY SIRA";
    
    	return $_db->loadList($sql);
    }
    
    function yeterlilikList() {
    	$db = &JFactory::getOracleDBO();
    	$sql = "SELECT YETERLILIK_ID,YETERLILIK_KODU|| '/' ||REVIZYON|| ' ' ||YETERLILIK_ADI AS YETERLILIK_BILGISI FROM M_YETERLILIK WHERE YETERLILIK_DURUM_ID = ".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK." ORDER BY YETERLILIK_ADI";
    	$data = $db->prep_exec($sql, array());
    	return $data;
    }
    
    function yerineGecerliBirimList($birimID){
    	$db = &JFactory::getOracleDBO();
    	$sql = "SELECT YERINE_GECERLI_BIRIM_ID,BIRIM_ADI FROM M_BIRIM_YERINE_GECERLI INNER JOIN M_BIRIM ON M_BIRIM_YERINE_GECERLI.BIRIM_ID = M_BIRIM.BIRIM_ID WHERE M_BIRIM_YERINE_GECERLI.BIRIM_ID = ?";
    	$data = $db->prep_exec($sql, array($birimID));
    	return $data;
    }
}
?>
