<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_TaslakModelYeterlilik_Taslak_Yeni extends JModel {

	var $pages 		= array ("tanitim", "yeterlilik_kaynagi", "yeterlilik_sartlari", "yeterliligin_yapisi", "olcme_ve_degerlendirme", "aciklama", "ek_2", "ek_3", "ek_4", "ek_5", "ek_6", "ek_8", "ek_9", "birimler", "ogrenme_ciktilari"); 
	var $pageNames 	= array ("Tanıtım", "Yeterlilik Kaynağı", "Yeterlilik Şartları", "Yeterliliğin Yapısı", "Ölçme ve Değerlendirme", "Açıklama", "EK 2", "EK 3", "EK 4", "EK 5", "EK 6", "EK 8", "EK 9", "Birimler", "Öğrenme Çıktıları");
	
	function getPageTree ($user, $activeLayout, $evrak_id, $yeterlilik_id, $taslak = 0)
	{
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu($user);
		$canEdit = $this->canEdit ($user, $yeterlilik_id);
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';
		$sayfa = count ($this->pages);
		$saved = $this->getSavedPages ($evrak_id, $yeterlilik_id);
		
		$tree = '<div class="form_element" style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
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
					$value = 'value="Tüm Ön Taslağı Görüntüle" ';
						
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
				$tree .= $inp.$name.$onClick.$value.$disabled." />";
				
				$onClick = 'onclick = "sektorSorumlusuSubmit (2,'.$yeterlilik_id.')" ';
				$name  = 'name="onayla" ';
				$value = 'value="Yeterlilik Ön Taslağını Onayla" ';
				$tree .= $inp.$name.$onClick.$value." />";
			}
			
		}
		else // SEKTOR SORUMLUSU DEGIL, KURULUŞ
		{
			
			if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK &&
			   $yeterlilikDurumID != PM_YETERLILIK_DURUMU__TASLAK) //SS Onayina gonderilmemis On Taslak ve Taslak olmayanlar
			{
				if ($yeterlilikDurumID != PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK) //On Taslak Daha onaylanmamis
				{
					$onClick = 'onclick = "userSubmit (1,'.$yeterlilik_id.')" ';
					$value = 'value="Tüm Taslağı Görüntüle / Bitir" ';
			
					$disabled = 'disabled';
					if (count($saved) >= $sayfa){
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
		
		$tree .= '<div style="clear:both;"></div></div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'margin: 1px;';
			
			for ($j = 0; $j < count($saved); $j++){
				if ($saved[$j] == ($i+1)){
					$style	 = 'background-color:rgb(100,150,100);color:rgb(255,255,255); margin: 1px;';
					break;
				}
			}
			$input = '<input type="button" onClick="goToPageYeni(\''.$this->pages[$i].'\', '.$yeterlilik_id.')" class="btn" id="page'.$i.'" value="'.$this->pageNames[$i].'" ';
			if ($activeLayout == $this->pages[$i])
				$tree .= $input.$activeStyle.' />';
			else
				$tree .= $input.' style="'.$style.'" />'; 
		}
		
		$tree .= '<br /><div style="clear:both;"></div></div>';
		
		return $tree;
	}
	
	function getYorumDiv_SS ($evrak_id, $layout, $readOnly = true){
		$sayfa 	= $this->getSayfa ($layout);
		$read 	= "";
		
		$db  = &JFactory::getDBO();
		$sql = "SELECT yorum 
				FROM #__taslak_yorum 
				WHERE evrak_id = ".$evrak_id." AND  ss_yorumu_mu = 1 AND sayfa = ".$sayfa;
		
		if ($readOnly){ //Kurulus
			//Kaydedilen ve Gonderilen yorumu al 
			$sql .= " AND yorum_durum = 0";
			$read = "readOnly";
		}else{			//Sektor Sorumlusu
			//Kaydedilen son yorumu al
			$sql .= " ORDER BY id DESC";
		}
		
		$db->setQuery($sql);
		$data = $db->loadRow();
		
		$yorum = "";
		if ( !empty($data))
			$yorum = $data[0];
		
		return '<div style="padding-top:30px">
					<div class="form_item">
					  <div class="form_element cf_heading">
					  	<h1 class="contentheading">SEKTÖR SORUMLUSU YORUMLARI</h1>
					  </div>
					  <div class="cfclear">&nbsp;</div>
					</div>
					
					<div class="form_item">
						<div class="form_element cf_textarea"> 
							<textarea class="cf_inputbox" rows="5" '.$read.'
								id="yorum" title="" cols="70" name="yorum">'.$yorum.'</textarea>
						</div>
						<div class="cfclear">&nbsp;</div>
					</div>
				</div>';
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
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getAltBirim ($yeterlilik_id, $tur){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *   
			   FROM m_yeterlilik_alt_birim_yeni  
			   WHERE yeterlilik_id = ? AND yeterlilik_zorunlu = ? 
			   ORDER BY  yeterlilik_alt_birim_id asc";//yeterlilik_alt_birim_id
		
		$params = array ($yeterlilik_id, $tur);
		
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
		
		$sql= "SELECT yeterlilik_kurulus_adi   
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
	
	function getTerimValues ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *  
			   FROM m_yeterlilik_terim 
			   WHERE yeterlilik_id = ?     
			   ORDER BY terim_id";
		
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
				WHERE   ss_yorumu_mu = 1 AND evrak_id = ".$evrak_id;
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		return $data[0];
	}
	
	function getYorumDurumId_SS ($evrak_id){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT yorum_durum FROM #__taslak_yorum 
				WHERE  ss_yorumu_mu = 1 AND evrak_id = ".$evrak_id." 
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
	
	function getYeterlilikDurumId($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT yeterlilik_durum_id FROM m_yeterlilik WHERE yeterlilik_id = ?";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec_array($sql, $params);
	
		if (!empty($data))
		return $data[0];
		else
		return null;
	}
	
	function getYeterlilikSurecDurumId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT YETERLILIK_SUREC_DURUM_id 
				FROM m_yeterlilik  
				WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return ONAYLANMAMIS_YETERLILIK;
	}
	
	function getSayfa ($layout){
		for ($i = 0; $i < count($this->pages); $i++){
			if ($this->pages[$i] == $layout)
				break;
		}
		
		return $i+1;
	}
	
	function isTaslak ($evrak_id){
		return ($this->getEvrakDurumId ($evrak_id) == KAYDEDILMIS_BASVURU_SEKLI_ID);
	}
	
	function getYeterlilik ($user_id){
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
			   WHERE user_id = ? AND 
			   		 basvuru_durum_id = ".ONAYLANMIS_BASVURU." AND 
			   		(basvuru_tip_id = ".T2_BASVURU_TIP." OR 
			   		 basvuru_tip_id = ".YET_PROTOKOL_BASVURU_TIP.") AND 
			   		 YETERLILIK_SUREC_DURUM_id NOT IN ( ".ONAYLANMIS_YETERLILIK.", ".REDDEDILMIS_YETERLILIK.") AND 
    		   		 yeterlilik_id NOT IN (SELECT yeterlilik_id 
    									   FROM m_taslak_yeterlilik  
    				 						  JOIN ".DB_PREFIX.".evrak USING (evrak_id) 
    				 					   WHERE basvuru_sekli_id = ".KAYDEDILMIS_BASVURU_SEKLI_ID.") 
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
	
	function canEdit ($user, $evrak_id){
		$isSektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);	
		$isKurulus			= $this->yetkiliYeterlilikKurulusuMu ($user);
		$evrak_durum 		= $this->getEvrakDurumId ($evrak_id);	
		$yeterlilik_id		= $this->getYeterlilikId ($evrak_id);
		$editable			= $this->getEditable ($yeterlilik_id);
		$YETERLILIK_SUREC_DURUM	= $this->getYeterlilikDurumId ($yeterlilik_id);
		
	 	// Sektor Sorumlusu
		if ($isSektorSorumlusu){
			return true;
		}// Kurulus
		else if ($isKurulus){ 
			//On Basvuru Bitirme asamasindaysa
			if ($evrak_durum == KAYDEDILMEMIS_BASVURU_SEKLI_ID){	
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
					  TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  KARAR_SAYI 
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

}


?>
