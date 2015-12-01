<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_TaslakModelYeterlilik_Taslak extends JModel {

	var $pages 		= array ("tanitim", "kaynak", "zorunlu", "secmeli", "sart", "bilgi", "beceri", "yetkinlik", "sinav_bilgi", "aciklama_son", "ek_terim", "ek_birim", "ek_degerlendirme", "ek_katki", "ek_kurulus", "ek_7", "ek_8","alternatif"); 
	var $pageNames 	= array ("Tanıtım", "Yeterlilik Kaynağı", "Zorunlu Birimler", "Seçmeli Birimler", "Yeterlilik Şartları", "Bilgi", "Beceri", "Yetkinlik", "Sınav ve Değerlendirme", "Açıklama", "EK 1", "EK 2", "EK 3", "EK 4", "EK 5", "EK 7", "EK 8","Gruplandırma Alternatifleri");
	
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
				//$tree .= $inp.$name.$onClick.$value.$disabled." />";
				
				$onClick = 'onclick = "sektorSorumlusuSubmit (2,'.$yeterlilik_id.')" ';
				$name  = 'name="onayla" ';
				$value = 'value="Yeterlilik Ön Taslağını Onayla" ';
				$tree .= $inp.$name.$onClick.$value." />";
			}
			
		}
		else // SEKTOR SORUMLUSU DEGIL, KURULUŞ
		{
			
			if($yeterlilikDurumID != PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK &&
			   $yeterlilikDurumID != PM_YETERLILIK_DURUMU__TASLAK &&
				$yeterlilikDurumID != PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK	) //SS Onayina gonderilmemis On Taslak ve Taslak olmayanlar
			{
				if ($yeterlilikDurumID != PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK) //On Taslak Daha onaylanmamis
				{
					$onClick = 'onclick = "userSubmit (1,'.$yeterlilik_id.')" ';
					//$value = 'value="Tüm Taslağı Görüntüle / Bitir" ';
					$value = 'value="Ön Taslağı Sektör Sorumlusu İncelemesine Sun" ';
						
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
			$input = '<input type="button" onClick="goToPage(\''.$this->pages[$i].'\', '.$yeterlilik_id.')" class="btn" id="page'.$i.'" value="'.$this->pageNames[$i].'" ';
			if ($activeLayout == $this->pages[$i])
				$tree .= $input.$activeStyle.' />';
			else
				$tree .= $input.' style="'.$style.'" />'; 
		}
		
		$tree .= '<br /><div style="clear:both;"></div></div>';
		
		return $tree;
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
	
	
	function getYorumDiv_SS ($evrak_id, $layout, $readOnly = true){
		$db = &JFactory::getOracleDBO();
		
		$sql= 'SELECT * FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ? 
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.' 
		AND SS_YORUMU_MU = 1 AND LAYOUT = ?';
		
		$params = array ($_GET['yeterlilik_id'], $layout);
		
		$data = $db->prep_exec($sql, $params);
		
		
		if ( !empty($data))
			$yorum = $data[0]['YORUM'];
		else if ($readOnly == true)
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
		
					if ($readOnly != true)
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
	
	function getYorumDiv_Kurulus ($evrak_id, $layout, $readOnly = true){
		$db = &JFactory::getOracleDBO();
	
		$sql= 'SELECT * FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ?
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.'
		AND SS_YORUMU_MU = 0 AND LAYOUT = ?';
	
		$params = array ($_GET['yeterlilik_id'], $layout);
	
		$data = $db->prep_exec($sql, $params);
	
	
		if ( !empty($data))
			$yorum = $data[0]['YORUM'];
		else if ($readOnly == true)
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
			   FROM m_yeterlilik_alt_birim  
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
					  YETERLILIK_ALT_BIRIM_ADI, 
					  YETERLILIK_ALT_BIRIM_KODU,
					  YETERLILIK_ALT_BIRIM_KREDI,
					  YETERLILIK_ALT_BIRIM_NO    
			   FROM m_yet_birim_beceri_yetkinlik y
			   	 JOIN M_YETERLILIK_ALT_BIRIM USING (yeterlilik_alt_birim_id) 
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
			   FROM m_yeterlilik_alt_birim 
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
	
	function getYeterlilikSurecDurumId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql="select REVIZYON_DURUMU from M_YETERLILIK_REVIZYON where YETERLILIK_ID=".$yeterlilik_id." order by 
 				REVIZYON_NO desc";
		$data=$_db->prep_exec_array($sql);
		
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
	
	function isTaslak ($yeterlilik_id){
		
		$_db = &JFactory::getOracleDBO();
		$sql = "SELECT yeterlilik_durum_id
						FROM m_yeterlilik
						WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0]["yeterlilik_durum_id"] == PM_YETERLILIK_DURUMU__TASLAK;
		else
			return 0;
		
	}
	
	function getYeterlilik ($user_id){
		$_db = &JFactory::getOracleDBO();
		
		$params = array ($user_id);
		
		$sql = "SELECT m_yeterlilik.YETERLILIK_ID, 
					   m_yeterlilik.YETERLILIK_ADI, 
					   SEVIYE_ADI, 
					   YETERLILIK_BASLANGIC AS BASLANGIC_TARIHI_FORMATTED, 
					   YETERLILIK_SUREC_DURUM_ADI, 
					   m_yeterlilik.YETERLILIK_SUREC_DURUM_ID, 
					   m_yeterlilik.YETERLILIK_DURUM_ID,
					   m_yeterlilik.SEKTOR_ID, 
					   SEKTOR_ADI, 
					   user_id  
				FROM m_yeterlilik, 
					 pm_seviye, 
					 pm_yeterlilik_surec_durum, 
					 pm_sektorler, 
					 m_yetki_yeterlilik, 
					 m_kurulus_yetki, 
					 m_yetki
				WHERE m_yeterlilik.YETERLILIK_ID = m_yetki_yeterlilik.YETERLILIK_ID
					AND m_yetki_yeterlilik.YETKI_ID = m_kurulus_yetki.YETKI_ID
					AND m_yetki_yeterlilik.YETKI_ID = m_yetki.YETKI_ID
					AND m_yetki.ETKIN = 1
					AND m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = pm_yeterlilik_surec_durum.YETERLILIK_SUREC_DURUM_ID
					AND m_yeterlilik.SEKTOR_ID = pm_sektorler.SEKTOR_ID 
					AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
					AND yeterlilik_durum_id IN (".PM_YETERLILIK_DURUMU__ONTASLAK.")
					AND user_id = ?";
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function canEdit ($user, $yeterlilik_id){
		$juser 	= &JFactory::getUser();
		$user_id= $juser->getOracleUserId ();
		$isSektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);	
		$isYetkiliSektorSorumlusu  = FormFactory::getSorumluSektorId ($user_id, 1);	
		$isKurulus			= $this->yetkiliYeterlilikKurulusuMu ($user);	
		$editable			= $this->getEditable ($yeterlilik_id);
		$yeterlilik_durum 	  = $this->getYeterlilikDurumId ($yeterlilik_id);
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
	
	function GetAlternatif($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		$return = array();
		$sql = "SELECT * FROM M_YETERLILIK_ALTERNATIF 
				WHERE YETERLILIK_ID = ? ORDER BY ALTERNATIF_ID DESC";
		
		$data = $_db->prep_exec($sql, array($yeterlilik_id));
		
		foreach ($data as $cow){
			$return['data'][$cow['ALTERNATIF_ID']] = $cow;
			$sql1 = "SELECT * FROM M_YETERLILIK_ALTERNATIF_BIRIM 
						JOIN M_YETERLILIK_ALT_BIRIM ON BIRIM_ID = YETERLILIK_ALT_BIRIM_ID
						WHERE ALTERNATIF_ID = ? ORDER BY YETERLILIK_ALT_BIRIM_ID ASC";
			
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
	
	function getAjaxBagliBilgi($post){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "select * FROM m_yet_birim_beceri_yetkinlik where beceri_yetkinlik_id = ?";
		$result = $_db->prep_exec($sql, array($post['id']));
		return $result;
	}
	
	function ajaxDelBilgi($post){
		$_db = &JFactory::getOracleDBO();
		
		$sql ="DELETE FROM M_YETER_BECERI_YETKINLIK WHERE beceri_yetkinlik_id = ?";
		$result = $_db->prep_exec($sql, array($post['id']));
		return $result;
	}
	
	function ajaxGuncelleBilgi($post){
		$_db = &JFactory::getOracleDBO();
		
		$sql ="UPDATE M_YETER_BECERI_YETKINLIK SET BECERI_YETKINLIK_ADI=? WHERE beceri_yetkinlik_id = ?";
		$result = $_db->prep_exec_insert($sql, array($post['bilgi'],$post['id']));
		return $result;
	}
	
	function ajaxAddBilgi($post){
		$_db = &JFactory::getOracleDBO();
		
		$yetId = $post['yetId'];
		$list = explode("\n",$post['bilgi']);
		$tip = $post['tip'];
		foreach($list as $row){
			$beceri_yetkinlik_id  = $_db->getNextVal (BECERI_YETKINLIK_SEQ);
			$sql = "INSERT INTO M_YETER_BECERI_YETKINLIK (YETERLILIK_ID, BECERI_YETKINLIK_ID, BECERI_YETKINLIK_ADI, BECERI_YETKINLIK_TIPI)
					VALUES(?,?,?,?)";
			$_db->prep_exec_insert($sql, array($yetId,$beceri_yetkinlik_id,$row,$tip));
		}
		
		return true;
	}
	
	function ajaxEkBirimSil($post){
		$_db = &JFactory::getOracleDBO();
		
		$birim = $post['birimId'];
		$bilgi = $post['bilgiId'];
		
		$sql = "DELETE FROM M_YET_BIRIM_BECERI_YETKINLIK WHERE BECERI_YETKINLIK_ID=? AND YETERLILIK_ALT_BIRIM_ID=?";
		$_db->prep_exec($sql, array($bilgi,$birim));
		return true;
	}
	
	function ajaxZorunluBaglimi($post){
		$_db = &JFactory::getOracleDBO();
		
		$birim = $post['birimId'];
		$yetId = $post['yetId'];
		
		$sql = "SELECT * FROM M_YET_BIRIM_BECERI_YETKINLIK where yeterlilik_alt_birim_id = ? AND yeterlilik_id = ?";
		
		if($_db->prep_exec($sql, array($birim,$yetId))){
			return true;
		}else{
			return false;
		}
	}
	
	function ajaxZorunluSil($post){
		$_db = &JFactory::getOracleDBO();
	
		$birim = $post['birimId'];
		$yetId = $post['yetId'];
		$tur = $post['tur'];
	
		$sql = "DELETE FROM m_yeterlilik_alt_birim where yeterlilik_alt_birim_id = ? AND yeterlilik_id = ?";
		$_db->prep_exec($sql, array($birim,$yetId));
		
		$sql = "SELECT * FROM m_yeterlilik_alt_birim WHERE YETERLILIK_ID =? AND YETERLILIK_ZORUNLU=? ORDER BY YETERLILIK_ALT_BIRIM_ID ASC";
		$result = $_db->prep_exec($sql, array($yetId,$tur));
		
		if($tur == 1){
			$harf= "A";
		}else{
			$harf = "B";
		}
		
		$sqy = 1;
		foreach ($result as $row){
			$birimNo = $harf.$sqy;
			
			$sqlUp = "UPDATE m_yeterlilik_alt_birim SET YETERLILIK_ALT_BIRIM_NO=? WHERE YETERLILIK_ID=? AND YETERLILIK_ALT_BIRIM_ID=?";
			$result = $_db->prep_exec_insert($sqlUp, array($birimNo,$yetId,$row['YETERLILIK_ALT_BIRIM_ID']));
			$sqy++;
		}
		
		return true;
	}
	
	function ajaxZorunluGuncelle($post){
		$_db = &JFactory::getOracleDBO();
		
		$birimId = $post['birimId'];
		$yetId = $post['yetId'];
		$birim = $post['birim'];
		
		$sqlUp = "UPDATE m_yeterlilik_alt_birim SET YETERLILIK_ALT_BIRIM_ADI='?' WHERE YETERLILIK_ID=? AND YETERLILIK_ALT_BIRIM_ID=?";
		return $_db->prep_exec_insert($sql, array($birim,$yetId,$birimId));
	}
	
	function ajaxAciklamaKaydet($post){
		$_db  = & JFactory::getOracleDBO();
		
		$yeterlilik_id = $post['yetId'];
		$tur=$post['tur'];
		$aciklama = $post['acik'];
		//Prepare sql statement
		$sql = "";
		switch ($tur){
			case "zorunlu_birim":
				$sql = "UPDATE m_taslak_yeterlilik
						SET zorunlu_aciklama = ?
						WHERE yeterlilik_id = ?";
				break;
			case "secmeli_birim":
				$sql = "UPDATE m_taslak_yeterlilik
						SET secmeli_aciklama = ?
						WHERE yeterlilik_id = ?";
				break;
			case "ek_terim":
				$sql = "UPDATE m_taslak_yeterlilik
						SET terim_aciklama = ?
						WHERE yeterlilik_id = ?";
				break;
		}
		$params = array($aciklama, $yeterlilik_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function ajaxAlternatifKaydet ($post){
		$_db  = & JFactory::getOracleDBO();
	
		$alternatif = $post['alter'];
		$yeterlilik_id = $post['yetId'];
		//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik
				SET yeterlilik_grup_alternatif = ?
				WHERE yeterlilik_id = ?";
	
		$params = array($alternatif, $yeterlilik_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function turKaydet($post){
		$_db  = & JFactory::getOracleDBO();
		$birimId = $post['BirimId'];
		
		$sqlDelete = "DELETE FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ?";
		$result = $_db->prep_exec($sqlDelete, array($birimId));
		
			$sinavTuru = $post['TeorikSinavTuru'];
			$sinavAdi = $post['TeorikSinavAdi'];
			$sinavAciklama = $post['TeorikSinavAciklama'];
			$sql = "INSERT INTO M_YETERLILIK_ALT_BIRIM_TUR (BIRIM_ID,TUR_ADI,TUR_ACIKLAMA,TUR_KODU,TUR) VALUES(?,?,?,?,1)";
			for($i=1;$i<(count($sinavTuru)+1);$i++){
				if(!empty($sinavTuru[$i])){
					$_db->prep_exec_insert($sql, array($birimId,$sinavAdi[$i],$sinavAciklama[$i],ucwords(trim($sinavTuru[$i]))));
				}
			}
			
			$sinavTuru = $post['PerformansSinavTuru'];
			$sinavAdi = $post['PerformansSinavAdi'];
			$sinavAciklama = $post['PerformansSinavAciklama'];
			$sql = "INSERT INTO M_YETERLILIK_ALT_BIRIM_TUR (BIRIM_ID,TUR_ADI,TUR_ACIKLAMA,TUR_KODU,TUR) VALUES(?,?,?,?,2)";
			for($i=1;$i<(count($sinavTuru)+1);$i++){
				if(!empty($sinavTuru[$i])){
					$_db->prep_exec_insert($sql, array($birimId,$sinavAdi[$i],$sinavAciklama[$i],ucwords(trim($sinavTuru[$i]))));
				}
			}
			
			return true;
	}
	
	function getZorunluBirimTur($birims){
		$_db  = & JFactory::getOracleDBO();
		
		$birimler = array();
		$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ? ORDER BY TUR ASC,TUR_KODU ASC";
		foreach($birims as $row){
			$birimler[$row['YETERLILIK_ALT_BIRIM_ID']] = $_db->prep_exec($sql, array($row['YETERLILIK_ALT_BIRIM_ID']));
		}
		
		return $birimler;
	}
}
?>
