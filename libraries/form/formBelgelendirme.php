<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once('libraries/form/form_config.php');

class FormFactory2
{
		
	public function evrakVerisiEkle($user_id, $sayi_id, $basvuru_sekli_id = KAYDEDILMIS_BASVURU_SEKLI_ID){
		$_db =& JFactory::getOracleDBO();
						
		////////////////////////////////////////////////
		//PK & FK's
		////////////////////////////////////////////////
		$evrak_id 			= $_db->getNextVal2(DB_PREFIX.".\"".EVRAK_SEQ."\"");//PK
		$gelis_sekli_id 	= GELIS_SEKLI_ID;					//P_GELIS_SEKLI
		$icerik_id 			= ICERIK_ID;						//P_ICERIK
		$kosul_id 			= KOSUL_ID;							//P_KOSUL
		$birim_id 			= null; 							//P_BIRIM
		////////////////////////////////////////////////
		$dis_kurum_id			= FormFactory2::getBirimId ($user_id);
		
		//Prepare sql statement
		$sql = "INSERT INTO ".DB_PREFIX.".evrak  
				(evrak_id, sayi_id, gelis_sekli_id, basvuru_sekli_id, evrak_tur_id, icerik_id, kosul_id, evrak_olusturma_tarihi, dis_kurum_id, user_id, birim_id) 
			    values( ?, ?, ?, ?, ?, ?, ?, SYSTIMESTAMP, ?, ?, ?)";
		
		$params = array($evrak_id,
						$sayi_id,
						$gelis_sekli_id,
						$basvuru_sekli_id,
						EVRAK_TUR_ID,
						$icerik_id,
						$kosul_id,
						$dis_kurum_id,
						$user_id,
						$birim_id
						);	

		if ($_db->prep_exec_insert($sql, $params))
			return $evrak_id;
		else
			return -1;
	}
	
	function basvuruOlustur ($evrak_id, $user_id, $basvuru_tip, $basvuru_durum, $basvuru_tur){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_basvuru 
				 (evrak_id, user_id, basvuru_tip_id, faliyet_sure_id, basvuru_durum_id, basvuru_turu, basvuru_tarihi, 
				 EKIP_ACIKLAMA, ALTYAPI_ACIKLAMA, DIS_ALIM_HIZMET, DIS_ALIM_TEDBIR, DANISMA_ACIKLAMA, PILOT_ACIKLAMA, KURULUS_TALEP_ACIKLAMA, GEZICI_BIRIM, EGITIM_ACIKLAMA, TEKNIK_FIZIKI_ACIKLAMA,PIYASA_ACIKLAMA) 
				 values( ?, ?, ?, 1, ? , ? , SYSTIMESTAMP, 
				 		 EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB())";
			         
		$params = array($evrak_id,
						$user_id,
						$basvuru_tip,
						$basvuru_durum,
						$basvuru_tur);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function BelgebasvuruOlustur ($evrak_id, $basvuru_durum){
		$_db =& JFactory::getOracleDBO();
	
		//Prepare sql statement
		$sql = " INSERT INTO m_belgelendirme_durum
					 (evrak_id, durum_id) 
					 values( ?, ?)";
	
		$params = array($evrak_id,
		$basvuru_durum);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	
	public function listeDurumGuncelle ($user_id, $durum, $tur){
		$_db =& JFactory::getOracleDBO();
	
		if ($tur == MS_SEKTOR_TIPI){
			$setPart = "ms_liste_onay";
		}else{
			$setPart = "yet_liste_onay";
		}
			
	
		//Prepare sql statement
		$sql = "UPDATE m_kurulus
				    SET ".$setPart." = ? 
				    WHERE user_id = ?";
	
		$params = array($durum, $user_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	public function getListeDurum ($user_id, $tur){
		$_db =& JFactory::getOracleDBO();
	
		if ($tur == MS_SEKTOR_TIPI){
			$selectPart = "ms_liste_onay";
		}else{
			$selectPart = "yet_liste_onay";
		}
	
		//Prepare sql statement
		$sql = "SELECT ".$selectPart."
				    FROM m_kurulus  
				    WHERE user_id = ?";
	
		$data = $_db->prep_exec_array($sql, array($user_id));
		return $data[0];
	}
	
	public function belgeledirmeDurumGuncelle ($evrak_id, $durum){ 
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "UPDATE m_belgelendirme_durum   
			    SET durum_id = ? 
			    WHERE evrak_id = ?";
			         
		$params = array($durum, $evrak_id);	
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	public function BelgelendirmebasvuruDurumGuncelle ($evrak_id, $durum){
		$_db =& JFactory::getOracleDBO();
		$sql = "UPDATE M_BELGELENDIRME_DURUM
								    SET DURUM_ID = ? 
								    WHERE EVRAK_ID = ?";
	
		$params = array($durum, $evrak_id);
	
		$_db->prep_exec_insert($sql, $params);
	
		if($durum == 4 || $durum == 18 || $durum == 10  || $durum == 20 || $durum == -2 || $durum == 12){
	
			$sql = "UPDATE m_basvuru
								    SET basvuru_durum_id = ? 
								    WHERE evrak_id = ?";
	
			if($durum == -2){
				$params = array('7', $evrak_id);
			}
			else if($durum == 4){
				$params = array('0', $evrak_id);
			}
			else if($durum == 10){
				$params = array('3', $evrak_id);
			}
			else if($durum == 12){
				$params = array('8', $evrak_id);
			}
			else if($durum == 18){
				$params = array('1', $evrak_id);
			}
			else if($durum == 20){
				$params = array('6', $evrak_id);
				$menuguncelle = "SELECT USER_ID FROM M_BASVURU WHERE EVRAK_ID = ?";
				$user_id = $_db->prep_exec($menuguncelle, array($evrak_id));
				$menuguncelle2 = "SELECT id FROM jos_users WHERE tgUserId = '.$user_id.'";
				$id = mysql_query($menuguncelle2);
				exit;
				$menuguncelleson = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (12,11,11, ".$id.")";
				$sorgu = mysql_query($menuguncelleson); 
			}
			return $_db->prep_exec_insert($sql, $params);
		}
	}
	
	public function irtibatVerileriKaydet ($evrak_pk, $panelName){
		$panelCount = $_POST["panelCount_".$panelName];
		$result = true;
		
		for ($i = 1; $result && ($i < $panelCount+2); $i++){
			$irtibatHiddenId = $panelName.$i;
			if ($i == 1)
				$irtibatHiddenId = $panelName;

			if (!isset ($_POST[$irtibatHiddenId])){ 					// INSERT
				if (isset ($_POST["input".$irtibatHiddenId."-2"])){
					$inputName 	= "input".$irtibatHiddenId;
					$rowCount	= 4;			
					$panelValues =  FormFactory2::getPanelValues ($_POST, $inputName, $rowCount);
					$result = FormFactory2::irtibatVerisiEkle($evrak_pk, $panelValues);
				}
				
			}else{ 
				$irtibatId = $_POST[$irtibatHiddenId];
				
				if (!isset ($_POST["input".$irtibatHiddenId."-2"])){	// DELETE
					$result =  FormFactory2::irtibatVerisiSil($evrak_pk, $irtibatId);
				}else{													// UPDATE
					$inputName 	= "input".$irtibatHiddenId;
					$rowCount	= 4;			
					$panelValues =  FormFactory2::getPanelValues ($_POST, $inputName, $rowCount);
					$result = FormFactory2::irtibatVerisiGuncelle($evrak_pk, $irtibatId, $panelValues);
				}
			}		
		}
		
		return $result;
	}
	
	private function irtibatVerisiEkle($evrak_pk, $panelValues){
		$_db 		= & JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$irtibat_id			= $_db->getNextVal(IRTIBAT_SEQ);
		$irtibat_kisi_adi	= $panelValues[0];
		$irtibat_eposta		= $panelValues[1];
		$irtibat_telefon	= $panelValues[2];
		$irtibat_faks		= $panelValues[3];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_kurulus_irtibat 
				(irtibat_id, evrak_id, irtibat_kisi_adi, irtibat_eposta, irtibat_telefon, irtibat_faks) 
				values( ?, ?, ?, ?, ?, ?)";
			         
		$params = array($irtibat_id,
						$evrak_pk,
						$irtibat_kisi_adi,
						$irtibat_eposta,
						$irtibat_telefon,
						$irtibat_faks
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function irtibatVerisiGuncelle($evrak_pk, $irtibatId, $panelValues){
		$_db 		= & JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$irtibat_kisi_adi	= $panelValues[0];
		$irtibat_eposta		= $panelValues[1];
		$irtibat_telefon	= $panelValues[2];
		$irtibat_faks		= $panelValues[3];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "UPDATE m_kurulus_irtibat 
				SET irtibat_kisi_adi = ?, 
					irtibat_eposta = ?, 
					irtibat_telefon = ?,
					irtibat_faks = ? 
				WHERE evrak_id = ? AND irtibat_id = ?";
			         
		$params = array($irtibat_kisi_adi,
						$irtibat_eposta,
						$irtibat_telefon,
						$irtibat_faks,
						$evrak_pk,
						$irtibatId
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function irtibatVerisiSil($evrak_pk, $irtibatId){
		$_db 		= & JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_kurulus_irtibat 
				WHERE evrak_id = ? AND irtibat_id = ?";
			         
		$params = array($evrak_pk,
						$irtibatId
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	public function sektorVerileriKaydet($evrak_pk, $tableName){
		$colCount = 2;
		$sektorValues = FormFactory2::getTableValues ($_POST, array ($tableName, $colCount));
		$result = FormFactory2::sektorVerisiSil($evrak_pk);
		
		for ($i = 0; $result && ($i < count($sektorValues)/$colCount); $i++){
			$id 		= ($sektorValues[($i*$colCount)] == "Seçiniz") ? null : $sektorValues[($i*$colCount)];
			$aciklama 	= $sektorValues[($i*$colCount)+1];
			$result = FormFactory2::sektorVerisiEkle($evrak_pk, $id, $aciklama);
		}
		
		return $result;
	}
	
	private function sektorVerisiEkle($evrak_pk, $id, $aciklama){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$sektor_id 		= $id;  			  //PM_SEKTORLER
		$sektor_aciklama= $aciklama;
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_basvuru_sektor 
				values( ?, ?, ?)";
			         
		$params = array($sektor_id,
						$evrak_pk,
						$sektor_aciklama,
						);
					
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function sektorVerisiSil($evrak_pk){
		$_db =& JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_sektor 
				WHERE evrak_id = ?";
			         
		$params = array ($evrak_pk);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	/**
	 * 
	 * Belgelendirme basvurusu faaliyet bilgileri sekmesinde 6. bÃ¶lÃ¼m
	 * faaliyet alanlarÄ± kÄ±smÄ±nÄ±n paragraf ÅŸeklinde kullanÄ±lmasÄ± icin
	 * eklendi:
	 * 
	 */
	public function patchForBelgelendirmeFaaliyetVerileriKaydet($evrak_pk, $tableName){
		$result = FormFactory2::faaliyetVerisiSil($evrak_pk);
		
		if ($result){
			$alan	= $_POST["inputfaaliyet-1"];
			$result = FormFactory2::faaliyetVerisiEkle($evrak_pk, 1, $alan);
		}
		
		return $result;
	}
	
	public function faaliyetVerileriKaydet($evrak_pk, $tableName){
		$faaliyetValues = FormFactory2::getTableValues ($_POST, array ($tableName, 1));
		$result = FormFactory2::faaliyetVerisiSil($evrak_pk);
		
		for ($i = 0; $result && ($i < count($faaliyetValues)); $i++){
			$id		= $i+1;
			$alan 	= $faaliyetValues[$i];
			$result = FormFactory2::faaliyetVerisiEkle($evrak_pk, $id, $alan);
		}
		
		return $result;
	}
	
	private function faaliyetVerisiEkle($evrak_pk, $id, $alan){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$faaliyet_alan_id	= $id;
		$faaliyet_alan_adi	= $alan;
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_basvuru_faliyet_alan 
				values( ?, ?, ?)";
			         
		$params = array($evrak_pk,
						$faaliyet_alan_id,
						$faaliyet_alan_adi
						);
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function faaliyetVerisiSil($evrak_pk){
		$_db =& JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_faliyet_alan 
				WHERE evrak_id = ?";
			         
		$params = array ($evrak_pk);
		
		return $_db->prep_exec_insert($sql, $params);
	}

	public function organizasyonSemaKaydet ($evrak_id, $filePath){
		$db 	= &JFactory::getOracleDBO();
		
		$sql = "UPDATE m_basvuru 
					SET organizasyon_semasi = '".$filePath."'  
				WHERE evrak_id = ".$evrak_id;
		
		$params = array ($filePath, $evrak_id);
		
		$db->prep_exec_insert ($sql, $params);
	}
	
	public function bagliKurulusVerileriKaydet($evrak_pk, $tableName){
		$kurulusValues = FormFactory2::getTableValues ($_POST, array ($tableName, 1));
		$result = FormFactory2::bagliKurulusVerisiSil($evrak_pk);
		
		for ($i = 0; $result && ($i < count($kurulusValues)); $i++){
			$id		= $i+1;
			$alan 	= $kurulusValues[$i];
			$result = FormFactory2::bagliKurulusVerisiEkle($evrak_pk, $id, $alan);
		}
		
		return $result;
	}
	
	private function bagliKurulusVerisiEkle($evrak_pk, $id, $alan){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$bagli_kurulus_id	= $id;
		$bagli_kurulus_adi	= $alan;
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_basvuru_bagli_kurulus 
				values( ?, ?, ?)";
			         
		$params = array($evrak_pk,
						$bagli_kurulus_id,
						$bagli_kurulus_adi
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function bagliKurulusVerisiSil($evrak_pk){
		$_db =& JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_bagli_kurulus 
				WHERE evrak_id = ?";
			         
		$params = array ($evrak_pk);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	public function birlikteKurulusVerileriKaydet($evrak_pk, $panelName, $posted=true, $rowCount){
		$result = false;
		
		if (isset ($_POST["panelCount_".$panelName])){		
			$panelCount = $_POST["panelCount_".$panelName];
			$result = true;
			
			$count = 1;
			for ($i = 1; $result && ($i < $panelCount+2); $i++){
				$kurulusHiddenId = $panelName.$i;
				if ($i == 1)
					$kurulusHiddenId = $panelName;
	
				if (!isset ($_POST[$kurulusHiddenId])){ 					// INSERT
					if (isset ($_POST["input".$kurulusHiddenId."-2"])){
						$inputName 	= "input".$kurulusHiddenId;
						$panelValues =  FormFactory2::getPanelValues ($_POST, $inputName, $rowCount);
						$result = FormFactory2::birlikteKurulusVerisiEkle($evrak_pk, $panelValues);
						$count++;
					}
					
				}else{ 
					$kurulusId = $_POST[$kurulusHiddenId];
					
					if (!isset ($_POST["input".$kurulusHiddenId."-2"])){	// DELETE
						$result = FormFactory2::birlikteKurulusVerisiSil($evrak_pk, $kurulusId);
					}else{													// UPDATE
						$inputName 	= "input".$kurulusHiddenId;
						$panelValues =  FormFactory2::getPanelValues ($_POST, $inputName, $rowCount);
						$result = FormFactory2::birlikteKurulusVerisiGuncelle($evrak_pk, $kurulusId, $panelValues);
					}
				}		
			}
		}else{
			$result = FormFactory2::birlikteKurulusVerileriSil($evrak_pk);
		}
		
		return $result;
	}
	
	private function birlikteKurulusVerisiEkle($evrak_pk, $panelValues){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$birlikte_id	= $_db->getNextVal(BIRLIKTE_KURULUS_SEQ);
		$statu_id		= ($panelValues[1] == "Seçiniz") ? null : $panelValues[1];
		$il_id 			= ($panelValues[4] == "Seçiniz") ? null : $panelValues[4];
		$ad				= $panelValues[0];
		$yetkili		= $panelValues[2];
		$adres 			= $panelValues[3];
		$posta_kodu 	= $panelValues[5];
		$telefon 		= $panelValues[6];
		$faks 			= $panelValues[7];
		$eposta 		= $panelValues[8];
		$web 			= $panelValues[9];
		$hizmet			= isset ($panelValues[10])? $panelValues[10] : null; 
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_basvuru_birlikte_kurulus 
				values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($evrak_pk,
						$birlikte_id,
						$statu_id,
						$il_id,
						$ad,
						$yetkili,
						$adres,
						$posta_kodu,
						$telefon,
						$faks,
						$eposta,
						$web,
						$hizmet
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function birlikteKurulusVerisiGuncelle($evrak_pk, $id, $panelValues){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$statu_id		= ($panelValues[1] == "Seçiniz") ? null : $panelValues[1];
		$il_id 			= ($panelValues[4] == "Seçiniz") ? null : $panelValues[4];
		$ad				= $panelValues[0];
		$yetkili		= $panelValues[2];
		$adres 			= $panelValues[3];
		$posta_kodu 	= $panelValues[5];
		$telefon 		= $panelValues[6];
		$faks 			= $panelValues[7];
		$eposta 		= $panelValues[8];
		$web 			= $panelValues[9];
		$hizmet			= isset ($panelValues[10])? $panelValues[10] : null; 
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "UPDATE m_basvuru_birlikte_kurulus 
				SET kurulus_statu_id = ?, 
					il_id = ?, 
					birlikte_kurulus_adi = ?,
					birlikte_kurulus_yetkilisi = ?,
					birlikte_kurulus_adres = ?, 
					birlikte_kurulus_postakod = ?,
					birlikte_kurulus_telefon = ?,
					birlikte_kurulus_faks = ?,
					birlikte_kurulus_eposta = ?,
					birlikte_kurulus_web = ?,
					birlikte_kurulus_hizmet = ?
				WHERE evrak_id = ? AND birlikte_kurulus_id = ?";

				         
		$params = array($statu_id,
						$il_id,
						$ad,
						$yetkili,
						$adres,
						$posta_kodu,
						$telefon,
						$faks,
						$eposta,
						$web,
						$hizmet,
						$evrak_pk,
						$id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function birlikteKurulusVerisiSil($evrak_pk, $id){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_birlikte_kurulus 
				WHERE evrak_id = ? AND birlikte_kurulus_id = ?";
			         
		$params = array($evrak_pk,
						$id	);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function birlikteKurulusVerileriSil($evrak_pk){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_birlikte_kurulus 
				WHERE evrak_id = ?";
			         
		$params = array($evrak_pk);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	public function basvuruEkleriKaydet($evrak_pk, $tableName, $posted=true, $tip = null, $aciklamaKolon = 1){
		$aciklamalar = $_POST ["input".$tableName."-".$aciklamaKolon];	    		
    	$ekId 	= "ek_id_";
		$ekAd 	= "filename_".$tableName."_0_";
		$ekPath = "path_".$tableName."_0_";
		
		$updated = 0;
		for ($i = 1; isset ($_POST[$ekId.$i]); $i++){	
			$inpFileName = $ekAd.$i;
			$ek_id 	 	 = $_POST[$ekId.$i];
			if ($ek_id != -1){
				if (isset ($_POST[$inpFileName])){ // GUNCELLE
					$aciklama = $aciklamalar[$updated];
					$file	  = $_POST[$inpFileName];
					$path 	  = $_POST[$ekPath.$i];
					$normalFile = FormFactory2::getNormalFilename ($file);
		
					if (!FormFactory2::basvuruEkiGuncelle ($ek_id, $aciklama, $path, $normalFile))
						return JText::_("VERI_GUNCELLE_HATA");
					
					$updated++;
					
				}else {				   // SIL
					if (!FormFactory2::basvuruEkiSil ($ek_id))
						return JText::_("VERI_SIL_HATA");
				}
			}else{
				//Belgelendirme Basvuru Formu (ek2) / Aradaki ekleri ekle
				if (isset ($_POST[$inpFileName])){
					$aciklama 	= $aciklamalar [$updated+$j];

					if (isset ($_POST[$ekPath.($updated+$j+1)])){
						$filePath	= $_POST[$ekPath.($updated+$j+1)];
						$fileName	= FormFactory2::getNormalFilename($_POST[$ekAd.($updated+$j+1)]);
						
						if (is_array($tip)){
							$ek_tip = $tip[$updated+$j];
						}else{
							$ek_tip = $tip;
						}
						
						
						if (!FormFactory2::basvuruEkiEkle ($evrak_pk, $aciklama, $fileName,$filePath, $ek_tip))
							return JText::_("VERI_EKLE_HATA");			
					}
				}
				$updated++;
			}
		}
		
		// GERISINI EKLE
		for ($j = 0; isset ($_POST["input".$tableName."-1"][($updated+$j)]); $j++){
			$aciklama 	= $aciklamalar [$updated+$j];

			if (isset ($_POST[$ekPath.($updated+$j+1)])){
				$filePath	= $_POST[$ekPath.($updated+$j+1)];
				$fileName	= FormFactory2::getNormalFilename($_POST[$ekAd.($updated+$j+1)]);
				
				if (is_array($tip)){
					$ek_tip = $tip[$updated+$j];
				}else{
					$ek_tip = $tip;
				}
				
				
				if (!FormFactory2::basvuruEkiEkle ($evrak_pk, $aciklama, $fileName,$filePath, $ek_tip))
					return JText::_("VERI_EKLE_HATA");			
			}
		}
    	
    	return JText::_("VERI_KAYDI_BASARILI");
	}
	
	private function basvuruEkiEkle ($evrak_id, $aciklama, $fileName,$filePath, $tip){
		$db 	= &JFactory::getOracleDBO();
		$ek_id 	= $db->getNextVal(BASVURU_EK_SEQ);
		
		$sql = "INSERT INTO m_basvuru_ekler 
				(EVRAK_ID,BASVURU_EK_ID, BASVURU_EK_ADI, BASVURU_EK_PATH, BASVURU_EK_ACIKLAMA, BASVURU_EK_TIP) 
				values (?, ?, ?, ?, ?, ?)";
		
		$params = array ($evrak_id, $ek_id, $fileName, $filePath, $aciklama, $tip);
		
		return $db->prep_exec_insert ($sql, $params);
	}
	
	private function basvuruEkiGuncelle($ekId, $aciklama, $path, $file){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "UPDATE m_basvuru_ekler 
					SET basvuru_ek_aciklama = ?,
						basvuru_ek_path = ?,
						basvuru_ek_adi = ?  
				WHERE basvuru_ek_id = ?";
			         
		$params = array($aciklama, $path, $file, $ekId);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function basvuruEkiSil($ekId){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_ekler   
				WHERE basvuru_ek_id = ?";
			         
		$params = array($ekId);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	public function kisiBilgiVerileriKaydet ($evrak_pk, $panelName){
		$panelCount = $_POST["panelCount_".$panelName];
		$result = true;
		
		for ($i = 1; $result && $i < $panelCount+2; $i++){
			$kisiHiddenId = $panelName.$i;
			if ($i == 1)
				$kisiHiddenId = $panelName;

			if (!isset ($_POST[$kisiHiddenId])){ 					// INSERT
				if (isset ($_POST["input".$kisiHiddenId."-3"])){
					$result = FormFactory2:: kisiBilgiVerisiEkle ($evrak_pk, $kisiHiddenId, $_POST);
				}				
			}else{ 
				$kisiId = $_POST[$kisiHiddenId];
				
				if (!isset ($_POST["input".$kisiHiddenId."-3"])){	// DELETE
					$result = FormFactory2::kisiBilgiVerisiSil ($kisiId);
				}else{												// UPDATE
					$result = FormFactory2::kisiBilgiVerisiGuncelle ($evrak_pk, $kisiId, $kisiHiddenId, $_POST);
				}
			}		
		}
		
		return $result;
		
	}
		
	private function kisiBilgiVerisiEkle ($evrak_pk, $panelName){
		$_db =& JFactory::getOracleDBO();
		$egitimColCount 	= 3;
		$sertifikaColCount 	= 4;
		$deneyimColCount 	= 5;
		$dilColCount 		= 5;
		$personel_id = $_db->getNextVal(PERSONEL_SEQ);
		
		$personelValues	 = FormFactory2::getPanelValues ($_POST, "input".$panelName, 9, 3);	//M_BASVURU_PERSONEL	
		$deneyimAciklama = $_POST ["input".$panelName."-17"];
		$egitimValues	 = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-13-12", $egitimColCount)); //M_PERSONEL_EGITIM
		$sertifikaValues = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-15-14", $sertifikaColCount)); //M_PERSONEL_SERTIFIKA
		$deneyimValues	 = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-19-18", $deneyimColCount)); //M_PERSONEL_DENEYIM		
		$dilValues		 = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-21-20", $dilColCount)); //M_DILBILGISI
		
		$resultP = FormFactory2::personelVerisiEkle ($evrak_pk, $personelValues, $deneyimAciklama, $personel_id);
		$resultE = FormFactory2::egitimVerileriEkle 	($egitimValues, $personel_id, $egitimColCount);
		$resultS = FormFactory2::sertifikaVerileriEkle($sertifikaValues, $personel_id, $sertifikaColCount);
		$resultD = FormFactory2::deneyimVerileriEkle	($deneyimValues, $personel_id, $deneyimColCount);
		$resultDL = FormFactory2::dilVerileriEkle 	($dilValues, $personel_id, $dilColCount);
		
		////////////////
		// KÄ±sÄ± bilgi ekindeki yeterlilik acÄ±klamasÄ± icin:
		$resultYA = true;
		$yeterlilik_aciklama = "";
		if ($_POST ["input".$panelName."-23"]) $yeterlilik_aciklama = $_POST ["input".$panelName."-23"];
		if ($yeterlilik_aciklama != "")
			$resultYA = FormFactory2::yeterlilikAciklamaKaydet ($personel_id, $yeterlilik_aciklama);
		////////////////
		//$returnValues = array ($resultP, $resultE, $resultS,$resultD, $resultDL);
		$returnValues = array ($resultP, $resultE, $resultS,$resultD, $resultDL, $resultYA);
		return !FormFactory2::isThereError($returnValues);
	}
	
	private function kisiBilgiVerisiSil ($personel_id){
		$resultST = FormFactory2::kisiBilgiTablolariSil ($personel_id);
		$resultS  = FormFactory2::personelVerisiSil 	   ($personel_id);
		
		$returnValues = array ($resultST, $resultS);
		return !FormFactory2::isThereError($returnValues);
	}
	
	private function kisiBilgiVerisiGuncelle ($evrak_pk, $personel_id, $panelName){
		$egitimColCount 	= 3;
		$sertifikaColCount 	= 4;
		$deneyimColCount 	= 5;
		$dilColCount 		= 5;
		
		$resultST = FormFactory2::kisiBilgiTablolariSil ($personel_id);
		
		$personelValues	 = FormFactory2::getPanelValues ($_POST, "input".$panelName, 9, 3);	//M_BASVURU_PERSONEL	
		$deneyimAciklama = $_POST ["input".$panelName."-17"];
		$egitimValues	 = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-13-12", $egitimColCount)); //M_PERSONEL_EGITIM
		$sertifikaValues = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-15-14", $sertifikaColCount)); //M_PERSONEL_SERTIFIKA
		$deneyimValues	 = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-19-18", $deneyimColCount)); //M_PERSONEL_DENEYIM		
		$dilValues		 = FormFactory2::getTableValues ($_POST, array ("div".$panelName."-21-20", $dilColCount)); //M_DILBILGISI
		
		$resultP = FormFactory2::personelVerisiGuncelle 	($personel_id, $personelValues, $deneyimAciklama);
		$resultE = FormFactory2::egitimVerileriEkle 		($egitimValues, $personel_id, $egitimColCount);
		$resultS = FormFactory2::sertifikaVerileriEkle	($sertifikaValues, $personel_id, $sertifikaColCount);
		$resultD = FormFactory2::deneyimVerileriEkle		($deneyimValues, $personel_id, $deneyimColCount);
		$resultDL = FormFactory2::dilVerileriEkle 		($dilValues, $personel_id, $dilColCount);
		
		////////////////
		// KÄ±sÄ± bilgi ekindeki yeterlilik acÄ±klamasÄ± icin:
		$resultYA = true;
		$yeterlilik_aciklama = "";
		if ($_POST ["input".$panelName."-23"]) $yeterlilik_aciklama = $_POST ["input".$panelName."-23"];
		if ($yeterlilik_aciklama != "")
			$resultYA = FormFactory2::yeterlilikAciklamaKaydet ($personel_id, $yeterlilik_aciklama);
		///////////////
		//$returnValues = array ($resultST, $resultP, $resultE, $resultS,$resultD, $resultDL);
		$returnValues = array ($resultST, $resultP, $resultE, $resultS,$resultD, $resultDL, $resultYA);
		return !FormFactory2::isThereError($returnValues);
	}
	
	private function kisiBilgiTablolariSil ($personel_id){
		$resultE = FormFactory2::egitimVerisiSil ($personel_id);
		$resultS = FormFactory2::sertifikaVerisiSil ($personel_id);
		$resultD = FormFactory2::deneyimVerisiSil ($personel_id);
		$resultDL = FormFactory2::dilVerisiSil ($personel_id);
		
		$returnValues = array ($resultE, $resultS,$resultD, $resultDL);
		return !FormFactory2::isThereError($returnValues);
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $personelId
	 * @param unknown_type $aciklama
	 */
	private function yeterlilikAciklamaKaydet ($personelId, $aciklama) {
		$_db =& JFactory::getOracleDBO();
		
		$personel_id 		 = $personelId;
		$personel_yeterlilik = $aciklama;
		//Prepare sql statement
		$sql = "UPDATE m_basvuru_personel
				SET gorevli_personel_yeterlilik = ?
				WHERE gorevli_personel_id = ?";		
		$params = array($personel_yeterlilik, $personel_id);
		
		return $_db->prep_exec_insert($sql, $params); 
	}
	
	private function personelVerisiEkle ($evrak_pk, $panelValues, $deneyimAciklama, $personel_id){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$personel_adi 		= $panelValues[1];
		$personel_soyad 	= $panelValues[2];
		$personel_sertifika = null;
		$personel_deneyim 	= $deneyimAciklama;
		$personel_telefon 	= $panelValues[3];
		$personel_faks 		= $panelValues[4];
		$personel_eposta 	= $panelValues[5];
		$personel_web 		= null;
		$personel_ogrenim 	= $panelValues[6];
		$personel_meslek 	= $panelValues[7];
		$personel_uzmanlik 	= $panelValues[8];
		$personel_kimlik	= $panelValues[0];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_basvuru_personel 
				(GOREVLI_PERSONEL_ID,
				EVRAK_ID,
				GOREVLI_PERSONEL_ADI,
				GOREVLI_PERSONEL_SOYAD,
				GOREVLI_PERSONEL_SERTIFIKA,
				GOREVLI_PERSONEL_DENEYIM,
				GOREVLI_PERSONEL_TELEFON,
				GOREVLI_PERSONEL_FAKS,
				GOREVLI_PERSONEL_EPOSTA,
				GOREVLI_PERSONEL_WEB,
				GOREVLI_PERSONEL_OGRENIM,
				GOREVLI_PERSONEL_MESLEK,
				GOREVLI_PERSONEL_UZMANLIK,
				GOREVLI_PERSONEL_KIMLIK_NO)
				values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($personel_id,
						$evrak_pk,
						$personel_adi,
						$personel_soyad,
						$personel_sertifika,
						$personel_deneyim,
						$personel_telefon,
						$personel_faks,
						$personel_eposta,
						$personel_web,
						$personel_ogrenim,
						$personel_meslek,
						$personel_uzmanlik,
						$personel_kimlik
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function personelVerisiGuncelle ($gorevli_personel_id, $panelValues, $deneyimAciklama){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$personel_kimlik	= $panelValues[0];
		$personel_adi 		= $panelValues[1];
		$personel_soyad 	= $panelValues[2];
		$personel_telefon 	= $panelValues[3];
		$personel_faks 		= $panelValues[4];
		$personel_eposta 	= $panelValues[5];
		$personel_ogrenim 	= $panelValues[6];
		$personel_meslek 	= $panelValues[7];
		$personel_uzmanlik 	= $panelValues[8];
		$personel_deneyim	= $deneyimAciklama;
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "UPDATE m_basvuru_personel 
				SET gorevli_personel_adi = ?,
					gorevli_personel_soyad = ?,
					gorevli_personel_telefon = ?,
					gorevli_personel_faks = ?,
					gorevli_personel_eposta = ?,
					gorevli_personel_ogrenim = ?,
					gorevli_personel_meslek = ?,
					gorevli_personel_uzmanlik = ?,
					gorevli_personel_deneyim = ?,
					gorevli_personel_kimlik_no = ?  
				WHERE gorevli_personel_id = ?";
			         
		$params = array($personel_adi,
						$personel_soyad,
						$personel_telefon,
						$personel_faks,
						$personel_eposta,
						$personel_ogrenim,
						$personel_meslek,
						$personel_uzmanlik,
						$personel_deneyim,
						$personel_kimlik,
						$gorevli_personel_id
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function personelVerisiSil 	($personel_id){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_basvuru_personel 
				WHERE gorevli_personel_id = ?";
			         
		$params = array($personel_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function egitimVerileriEkle ($panelValues, $personel_id, $colCount){
		$rowCount = count($panelValues) / $colCount;
		$result = true;
		
		for ( $i = 0; $result && $i < $rowCount; $i++){
			$id = $colCount*$i;
			$result = FormFactory2::egitimVerisiEkle ($panelValues, $personel_id, $id);
		}
		
		return $result;
	}
	
	private function egitimVerisiEkle ($panelValues, $personel_id, $id){
		$_db =& JFactory::getOracleDBO();

		/** Sabit Tablo Degerleri 
		****************************************************/
		$egitim_id			= $_db->getNextVal(EGITIM_SEQ);
		$egitim_baslangic	= $panelValues[$id];
		$egitim_bitis 		= $panelValues[$id+1];
		$egitim_yeri 		= $panelValues[$id+2];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_personel_egitim 
				(GOREVLI_PERSONEL_ID,
				EGITIM_ID,
				EGITIM_BASLANGIC,
				EGITIM_BITIS,
				EGITIM_YERI) 
				values( ?, ?, to_date(?,'yyyy'), to_date(?,'yyyy'), ?)";
			         
		$params = array($personel_id,
						$egitim_id,
						$egitim_baslangic,
						$egitim_bitis,
						$egitim_yeri
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function egitimVerisiSil($personel_id){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_personel_egitim 
				WHERE gorevli_personel_id = ?";
			         
		$params = array($personel_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function sertifikaVerileriEkle ($panelValues, $personel_id, $colCount){
		$rowCount = count($panelValues) / $colCount;
		$result = true;
		
		for ( $i = 0; $result && $i < $rowCount; $i++){
			$id = $colCount*$i;
			$result = FormFactory2::sertifikaVerisiEkle ($panelValues, $personel_id, $id);
		}
		
		return $result;
	}
	
	private function sertifikaVerisiEkle ($panelValues, $personel_id, $id){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$sertifika_id 		= $_db->getNextVal(SERTIFIKA_SEQ); 
		$sertifika_adi 		= $panelValues[$id];
		$sertifika_yer 		= $panelValues[$id+1];
		$sertifika_tarih 	= $panelValues[$id+2];
		$sertifika_aciklama = $panelValues[$id+3];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_personel_sertifika 
				(SERTIFIKA_ID,
				GOREVLI_PERSONEL_ID,
				SERTIFIKA_ADI,
				SERTIFIKA_YER,
				SERTIFIKA_TARIH,
				SERTIFIKA_ACIKLAMA) 
				values( ?, ?, ?, ?, to_date(?,'yyyy'), ?)";
			         
		$params = array($sertifika_id,
						$personel_id,
						$sertifika_adi,
						$sertifika_yer,
						$sertifika_tarih,
						$sertifika_aciklama
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}	
	
	private function sertifikaVerisiSil($personel_id){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_personel_sertifika 
				WHERE gorevli_personel_id = ?";
			         
		$params = array($personel_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function deneyimVerileriEkle ($panelValues, $personel_id, $colCount){
		$rowCount = count($panelValues) / $colCount;
		$result = true;
		
		for ( $i = 0; $result && $i < $rowCount; $i++){
			$id = $colCount*$i;
			$result = FormFactory2::deneyimVerisiEkle ($panelValues, $personel_id, $id);
		}
		
		return $result;
	}
	
	private function deneyimVerisiEkle ($panelValues, $personel_id, $id){
		$_db =& JFactory::getOracleDBO();

		/** Sabit Tablo Degerleri 
		****************************************************/
		$deneyim_id 		= $_db->getNextVal(DENEYIM_SEQ); 
		$deneyim_baslangic 	= $panelValues[$id];
		$deneyim_bitis 		= $panelValues[$id+1];
		$deneyim_isyeri 	= $panelValues[$id+2];
		$deneyim_unvan 		= $panelValues[$id+3];
		$deneyim_istanimi 	= $panelValues[$id+4];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_personel_deneyim 
				(GOREVLI_PERSONEL_ID,
				DENEYIM_ID,
				DENEYIM_BASLANGIC,
				DENEYIM_BITIS,
				DENEYIM_ISYERI,
				DENEYIM_UNVAN,
				DENEYIM_ISTANIMI) 
				values( ?, ?, to_date(?,'mm/yyyy'), to_date(?,'mm/yyyy'), ?, ?, ?)";
			         
		$params = array($personel_id,
						$deneyim_id, 
						$deneyim_baslangic,
						$deneyim_bitis,
						$deneyim_isyeri,
						$deneyim_unvan,
						$deneyim_istanimi
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function deneyimVerisiSil 	($personel_id){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_personel_deneyim 
				WHERE gorevli_personel_id = ?";
			         
		$params = array($personel_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function dilVerileriEkle ($panelValues, $personel_id){
		$colCount = 5;
		$dilCount = count($panelValues) / $colCount;

		$result = true;
		for ($i = 0; $i < $dilCount; $i++){
			$id = $i * $colCount;
			$dil_adi 		= $panelValues[$id];

			$dil_yetenek_id = array (OKUMA_ID, KONUSMA_ID, YAZMA_ID, ANLAMA_ID);
			$dil_derecesi 	= array ($panelValues[$id + 1],$panelValues[$id + 2],$panelValues[$id + 3],$panelValues[$id + 4] );
			
			for ($j = 0; $result && ($j < 4); $j++){
				$values = array ($dil_yetenek_id[$j], 
								 $dil_adi,
								 $dil_derecesi[$j]);
								 
				$result = FormFactory2::dilVerisiEkle ($values, $personel_id);
			}
		}
		return $result;
	}
	
	private function dilVerisiEkle ($panelValues, $personel_id){
		$_db =& JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$dilbilgisi_id  = $_db->getNextVal(DIL_SEQ);
		$dil_yetenek_id = $panelValues [0];
		$dil_adi		= $panelValues [1];
		$dil_derecesi	= $panelValues [2];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_dilbilgisi 
				(GOREVLI_PERSONEL_ID,
				DILBILGISI_ID,
				DIL_YETENEK_ID,
				DIL_ADI,
				DIL_DERECESI) 
				values( ?, ?, ?, ?, ?)";
			         
		$params = array($personel_id,
						$dilbilgisi_id,
						$dil_yetenek_id,
						$dil_adi,
						$dil_derecesi
						);
		if($dil_adi != ""){
			$_db->prep_exec_insert($sql, $params);
		}
						
	
		return true;
	}
	
	private function dilVerisiSil ($personel_id){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_dilbilgisi 
				WHERE gorevli_personel_id = ?";
			         
		$params = array($personel_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	private function getBirimId ($user_id){
		$_db =& JFactory::getOracleDBO();
		
		$sql = "SELECT birim_id 
				FROM ".DB_PREFIX.".p_personel 
				WHERE user_id = ?";
		
		$data = $_db->prep_exec_array($sql, array ($user_id));
		
		if (isset($data[0]))
			return $data[0];
		else
			return null;
	}
	
	function getMKurulusValues($evrak_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * 
				FROM m_kurulus 
					LEFT JOIN pm_kurulus_statu USING (KURULUS_STATU_ID) 
					JOIN m_basvuru USING (USER_ID) 
					LEFT JOIN ".DB_PREFIX.".p_il ON (il_id = kurulus_sehir)
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}

	function getKurulusValues($user_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * 
				FROM m_kurulus 
					LEFT JOIN pm_kurulus_statu USING (KURULUS_STATU_ID) 
					LEFT JOIN ".DB_PREFIX.".p_il ON (il_id = kurulus_sehir)
				WHERE user_id = ?";
		
		$params = array ($user_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getKurulusValuesEvrak($evrak_id){
		$db = & JFactory::getOracleDBO();
		
		$sqluseral = "SELECT user_id
							FROM m_basvuru
							WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		$user = $db->prep_exec($sqluseral, $params);
		
		
		$sql = "SELECT *
					FROM m_kurulus 
						LEFT JOIN pm_kurulus_statu USING (KURULUS_STATU_ID) 
						LEFT JOIN ".DB_PREFIX.".p_il ON (il_id = kurulus_sehir)
					WHERE user_id = ?";
	
		$params = array ($user[0][USER_ID]);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
		return $data[0];
		else
		return null;
	}
	
	function getMKurulusIlValues($evrak_id, $pdf = 0){
		$db = & JFactory::getOracleDBO();
		
		if ($pdf){
			$sql = "SELECT il_adi 
					FROM m_kurulus_faliyet_il 
						JOIN ".DB_PREFIX.".p_il USING (il_id) 
						JOIN m_basvuru USING (USER_ID)
					WHERE evrak_id = ?";
		}else{
			$sql = "SELECT il_id 
					FROM m_kurulus_faliyet_il 
						JOIN m_basvuru USING (USER_ID)	
					WHERE evrak_id = ?";
		}
		
		$params = array ($evrak_id);
		$data = $db->prep_exec_array($sql, $params);
		
		return $data;
	}

	function getKurulusIlValues($user_id, $pdf = 0){
		$db = & JFactory::getOracleDBO();
		
		if ($pdf){
			$sql = "SELECT il_adi 
					FROM m_kurulus_faliyet_il 
						JOIN ".DB_PREFIX.".p_il USING (il_id) 
					WHERE user_id = ?";
		}else{
			$sql = "SELECT il_id 
					FROM m_kurulus_faliyet_il 
					WHERE user_id = ?";
		}
		
		$params = array ($user_id);
		$data = $db->prep_exec_array($sql, $params);
		
		return $data;
	}
	
	function getKurulusIlValuesEvrak($evrak_id, $pdf = 0){
		$db = & JFactory::getOracleDBO();
	
		$sqluseral = "SELECT user_id
									FROM m_basvuru
									WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		$user = $db->prep_exec($sqluseral, $params);
		
		
		if ($pdf){
			$sql = "SELECT il_adi
						FROM m_kurulus_faliyet_il 
							JOIN ".DB_PREFIX.".p_il USING (il_id) 
						WHERE user_id = ?";
		}else{
			$sql = "SELECT il_id
						FROM m_kurulus_faliyet_il 
						WHERE user_id = ?";
		}
	
		$params = array ($user[0][USER_ID]);
		$data = $db->prep_exec_array($sql, $params);
	
		return $data;
	}
	
	function getStatu ($statu_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT kurulus_statu_adi
				FROM pm_kurulus_statu 
				WHERE kurulus_statu_id = ?";
	
		$param = array ($statu_id);
		$data = $db->prep_exec_array($sql, $param);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getBasvuruValues ($evrak_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT 	FALIYET_SURE_ID,
						FALIYET_SURE_ADI,
						UYE_SAYISI,
						ORGANIZASYON_SEMASI,
						PERSONEL_SAYISI,
						HAZIRLAMA_EKIBI,
						EKIP_SAYISI,
						GOREV_BIRIM_ADI,
						GOREV_BIRIM_ADRESI,
						GOREV_BIRIM_TELEFON,
						GOREV_BIRIM_FAKS,
						GOREV_BIRIM_WEB,
						GOREV_BIRIM_EPOSTA
				FROM m_basvuru 
					LEFT JOIN pm_faliyet_suresi USING (faliyet_sure_id)
				WHERE evrak_id = ?";
	
		$params = array ($evrak_id);
		//LOBsuz data
		$data = $db->prep_exec($sql, $params);
		

		
	
		if (!empty($data)){
			//LOBlu kisimlar
			$sql = "SELECT 	*	
					FROM m_basvuru 
					WHERE evrak_id = ?";
			
			$lobCol = array ("EKIP_ACIKLAMA",
							"ALTYAPI_ACIKLAMA",
							"DIS_ALIM_HIZMET",
							"DIS_ALIM_TEDBIR",
							"DANISMA_ACIKLAMA",
							"PIYASA_ACIKLAMA",
							"PILOT_ACIKLAMA",
							"KURULUS_TALEP_ACIKLAMA",
							"GEZICI_BIRIM",
							"EGITIM_ACIKLAMA",
                            "DIGER_HUSUSLAR",
							"TEKNIK_FIZIKI_ACIKLAMA");
			
			for ($i = 0; $i < count($lobCol); $i++){
				$dataLob = $db->prep_exec_clob($sql, $params, $lobCol[$i]);
				$data[0][$lobCol[$i]] = $dataLob;
			}
			

			
			return $data[0];
		}else
			return null;
	}
	
	function getIrtibatValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT * 
				FROM m_kurulus_irtibat 
				WHERE evrak_id = ? ORDER BY irtibat_id";
		
		$params = array ($evrak_id);
		
		return $db->prep_exec($sql, $params);
	}
	
	function getSektorValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_basvuru_sektor 
					JOIN pm_sektorler USING (sektor_id)
				WHERE evrak_id = ? ORDER BY sektor_id";
		
		$params = array ($evrak_id);
		
		return $db->prep_exec($sql, $params);
	}
	
	function getFaaliyetValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_basvuru_faliyet_alan 
				WHERE evrak_id = ? ORDER BY faliyet_alan_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getBagliKurulusValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_basvuru_bagli_kurulus 
				WHERE evrak_id = ? ORDER BY bagli_kurulus_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);	
	}
	
	function getBirlikteKurulusValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_basvuru_birlikte_kurulus 
					LEFT JOIN pm_kurulus_statu USING (KURULUS_STATU_ID)     
				    LEFT JOIN ".DB_PREFIX.".p_il USING (IL_ID)
				WHERE evrak_id = ? ORDER BY birlikte_kurulus_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getPersonelValues ($evrak_id){	
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_basvuru_personel 
				WHERE evrak_id = ? 
				ORDER BY gorevli_personel_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getEgitimValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	GOREVLI_PERSONEL_ID,
						TO_CHAR(EGITIM_BASLANGIC, 'yyyy') as EGITIM_BASLANGIC,
						TO_CHAR(EGITIM_BITIS, 'yyyy') as EGITIM_BITIS,
						EGITIM_YERI
				FROM m_basvuru_personel  
					LEFT JOIN m_personel_egitim USING (gorevli_personel_id) 
				WHERE evrak_id = ? 
				ORDER BY gorevli_personel_id, egitim_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}

	function getSertifikaValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	GOREVLI_PERSONEL_ID,
						SERTIFIKA_ADI,
						SERTIFIKA_YER,
						TO_CHAR(SERTIFIKA_TARIH, 'yyyy') as SERTIFIKA_TARIH,
						SERTIFIKA_ACIKLAMA 
				FROM m_basvuru_personel  
					LEFT JOIN m_personel_sertifika USING (gorevli_personel_id) 
				WHERE evrak_id = ? 
				ORDER BY gorevli_personel_id,sertifika_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getIsDeneyimValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	GOREVLI_PERSONEL_ID,
						TO_CHAR(DENEYIM_BASLANGIC, 'mm/yyyy') as DENEYIM_BASLANGIC,
						TO_CHAR(DENEYIM_BITIS, 'mm/yyyy') as DENEYIM_BITIS,
						DENEYIM_ISYERI,
						DENEYIM_UNVAN,
						DENEYIM_ISTANIMI 
				FROM m_basvuru_personel  
					LEFT JOIN m_personel_deneyim USING (gorevli_personel_id) 
				WHERE evrak_id = ? 
				ORDER BY gorevli_personel_id,deneyim_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}

	function getDilValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_basvuru_personel 
					LEFT JOIN m_dilbilgisi USING (gorevli_personel_id) 
				WHERE evrak_id = ? 
				ORDER BY gorevli_personel_id, dilbilgisi_id";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getBasvuruEkValues ($evrak_id, $tip = null){
		$db  = &JFactory::getOracleDBO();
		
		$params = array ($evrak_id);
		$sqlWhere = "";
		if ($tip != null){
			$sqlWhere = "AND BASVURU_EK_TIP = ?";
			$params[] = $tip;
		}
		
		$sql = "SELECT * 
				FROM m_basvuru_ekler 
				WHERE evrak_id = ? ".$sqlWhere;
		
		
		return $db->prep_exec($sql, $params);
	}
	
	function checkAuthorization  ($user, $group_id){
		$result = true;
		if ($user->id != 0 ) { //Giris Yapmis Kullanici
			if (!FormFactory2::checkAclGroupId ($user->id, $group_id)){
				$result = false;
			}
		}else{
			$result = false;
		}
		
		return $result;		
	}

	public function checkAclGroupId ($user_id, $group_id){
		$_db =& JFactory::getDBO();
		$result = true;
			
		$sql = "SELECT * 
				FROM #__community_acl_users 
				WHERE user_id = ".$user_id." AND group_id = ".$group_id;
		
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		if (empty($data)){
			$result = false;
		}
			
		return $result;
	}
	
	function getPageTree ($user, $activeLayout, $evrak_id, $pages, $pageNames,$user_id,$durum){
		$group_id1 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id2 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut1 = FormFactory2::checkAuthorization  ($user, $group_id1);
		$aut2 = FormFactory2::checkAuthorization ($user, $group_id2);
		
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;" ';
		$sayfa = count($pages);
		$saved = FormFactory2::getSavedPages ($evrak_id);
		$saved[count($saved)] = 1;
		$tree = '<div class="form_element" style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		if((!$aut1 || !$aut2) && ($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14)){
		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
		$onClick = 'onclick = "basvuruGonder('.$evrak_id.')" ';
		$value = 'value="Tüm Başvuruyu Görüntüle / Bitir" ';
		
		$disabled = 'disabled="disabled"';
		
		//if (count($saved)>= $sayfa){
		if (count($saved)>= 7){
			$disabled = '';
		}
			
		$name  = 'name="gonder" ';
		
		$tree .= $inp.$name.$value.$onClick.$disabled." />";
		}
		$tree .= '<div style="clear:both;"></div></div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			for ($j = 0; $j < count($saved); $j++){
				if ($saved[$j] == ($i+1)){
					$style	 = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255); margin: 1px;" ';
					break;
				}
			}
			if(isset($evrak_id)){
				$input = '<input type="button" onclick="goToPage(\''.$pages[$i].'\','.$evrak_id.')" class="btn" id="page'.$i.'" value="'.$pageNames[$i].'" ';
			}
			else{
				$input = '<input type="button" onclick="goToPage(\''.$pages[$i].'\')" class="btn" id="page'.$i.'" value="'.$pageNames[$i].'" ';
			}
				$disabled = '';
			if ($pages[$i]== "ek" && !in_array(3, $saved)){ // sayfa 3 kaydedilmis mi (faaliyet)
				$disabled = 'disabled="disabled"';
			}
		
			if ($activeLayout == $pages[$i])
				$tree .= $input.$activeStyle.$disabled.' />';
			else
				$tree .= $input.$style.$disabled.' />'; 
		}
		
		$tree .= '<br /></div>';
		
		return $tree;
		
	}
	
	function getCurrentEvrakId ($posted=true, $basvuru_tur, $user){
		$session = &JFactory::getSession();
		
		$evrak = $session->get("evrak_id");			 					//Kaydetme sayfasindan geldiyse
	
		if (!isset($evrak)){
			if (isset ($_POST["evrak"])) 	  		 						//Sayfa arasinda dolaniyorsa
				$evrak = $_POST["evrak_id"];	
			else
				$evrak = FormFactory2::getEvrakId($user->id, $basvuru_tur);  //Sayfa yeni acildiysa
		}else{
			$session->clear("evrak_id");
		}
		
		return $evrak;
	}
	
	function getEvrakId($user_id, $basvuru_tur){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT evrak_id FROM #__user_evrak 
				WHERE user_id = ".$user_id." AND basvuru_tur= ".$basvuru_tur;
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		if ( !empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getSavedPages ($evrak_id){
		$db = & JFactory::getDBO();
		
		$sql = "SELECT saved_page FROM #__user_evrak 
				WHERE evrak_id= ".$evrak_id;
		$db->setQuery($sql);
		$data = $db->loadResultArray();
		
		return $data;
	}
	
	public function getTableValues ($posted=true, $paramArray, $t3=0){
		$result 	= array();
		$inputName 	= "input".$paramArray[0];
		$colCount 	= $paramArray[1];
		$rowCount 	= 0;
		$radioSay = Array();
		
		//Tablo Degerlerini array yap
		for ($i=0; $i < $colCount; $i++){
			$inp = $_POST[$inputName.'-'.($i+1)];
			if (isset ($inp))
				$array[$i] = $inp;
			else if ($t3){ //(T3) Radio Button olursa -> input<tablo_adi>-1-1
				array_push($radioSay, $i); 
				$rowCount 	= count (($_POST[$inputName.'-1']));
				$arr = array ();
				for ($j = 0; $j < $rowCount; $j++){
					//$inp = $_POST['inputsinavGercekMerkez-4-1[]'];
					$inp = $_POST[$inputName.'-'.($i+1).'-'.($j+1)];
					if (isset ($inp))
						$arr[$j] = $inp;
				}	 
				
				$array[$i] = $arr;
			}
		}
		
		if (isset($array[0])){
			$rowCount = count($array[0]);
		}
		
		$count = 0;
		for ($i=0; $i < $rowCount; $i++){
			for($j=0; $j< $colCount; $j++){
				//$result[$count] = trim ($array[$j][$i]);
				if(in_array($j, $radioSay)){
					$result[$count] = trim ($array[$j][$i][0]);
				}
				else{
				$result[$count] = trim ($array[$j][$i]);
				}
				$count++;							
			}
		}
	
		
		/*echo "-----------------<br><pre>";
		print_r($result);
		echo "</pre>";
		*/
		return $result;
		
	}
	
	public function getPanelValues ($posted=true, $inputName, $rowCount, $addValue=2){
		$result = array();
	
		//Tablo Degerlerini array yap
		for ($i=0; $i < $rowCount; $i++){
			$result[$i] = trim ($_POST[$inputName.'-'.($i+$addValue)]);
		}
	
		return $result;
	}
	
	//Faaliyet bilgilerinde doldurulan ekip sayisi ile personel bilgi ekindeki tablo sayisini karsilastirir
	public function isPersonelCountEnough($evrak_id){
		$basvuru = FormFactory2::getBasvuruValues ($evrak_id);
		$personel= FormFactory2::getPersonelValues ($evrak_id);
		if ($basvuru["EKIP_SAYISI"] <= count($personel))
			return true;
		else
			return false;
	}
	
	// verilen array in elemanlarindan en az birisi false mu
	function isThereError($returnValues){
		foreach($returnValues AS $rv)
			if($rv === FALSE)
				return TRUE;
		return FALSE;
	}
	
	//php den javascript e degisken gecirirken newline ve double quote gibi karakterlerden kac
	function normalizeVariable ($var){
		return  preg_replace("/\r?\n/", "\\n", addslashes($var));
	}
	
	function generateUniqueFilename ($filename){
		$uFileName = FormFactory2::normalizeFilename($filename);
  		list($usec, $sec) = explode(" ",microtime()); 
		return $usec.$sec."_".FormFactory2::formatFilename($uFileName);
	}
	
	function getNormalFilename ($filename){
		return substr($filename, strpos($filename, '_') + 1, strlen($filename));
	}
	
	function formatFilename($name) {
		$search = array('ı', 'ç', 'ö', 'ğ', 'ü', 'ş', 'İ', 'Ç', 'Ö', 'Ğ', 'Ü', 'Ş', ' ' );
		$replace = array('i', 'c', 'o', 'g', 'u', 's', 'i', 'c', 'o', 'g', 'u', 's', '_' );
		$name = str_replace($search, $replace, $name);
		$name = strtolower($name);
		$name = preg_replace('/[^.a-z0-9]/','_', $name);
		return $name;
	}
	
	function sektorSorumlusuMu ($user){
		return FormFactory2::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID) || FormFactory2::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID) || FormFactory2::checkAclGroupId($user->id, YONETICI_GROUP_ID);
	}
	
    //Sektor Sorumlusunun Sorumlu oldugu sektor idler
    function getSorumluSektorId ($user_id, $tip){
    	$db = & JFactory::getOracleDBO();
    	 
    	$sql = "SELECT sektor_id 
    			FROM M_YETKI_SEKTOR_SORUMLUSU 
    			WHERE user_id = ? AND sektor_tipi = ".$tip;
							
		$sektor = $db->prep_exec_array($sql, array ($user_id));
		
		return $sektor;
    }
    
    function getTaslakSektorId ($id, $tip){
    	$db = & JFactory::getOracleDBO();
    	
    	if ($tip == MS_SEKTOR_TIPI){
    		$sqlFrom = "M_MESLEK_STANDARTLARI";
    		$sqlId = "STANDART_ID";
    	}else if ($tip == YET_SEKTOR_TIPI){
    		$sqlFrom = "M_YETERLILIK";
    		$sqlId = "YETERLILIK_ID";
    	}
    	
    	$sql = "SELECT sektor_id 
    			FROM ".$sqlFrom." 
    			WHERE ".$sqlId." = ?";
							
		$sektor = $db->prep_exec_array($sql, array ($id));
		
		if (!empty ($sektor))
			return $sektor[0];
		else
			return -1;
    }
    function getYeterlilik ($yeterlilik_id){
    	$db = & JFactory::getOracleDBO();
    	 
    	$sql = "SELECT *
    	FROM m_yeterlilik
    	WHERE m_yeterlilik.yeterlilik_id = ?";
    		
    	$yeterlilik = $db->prep_exec_array($sql, array ($yeterlilik_id));
    
    	if (!empty ($yeterlilik))
    		return $yeterlilik;
    	else
    		return null;
    }
	function normalizeFilename($filename){
	    $tr = array('s','S','i','I','g','G','ü','Ü','ö','Ö','Ç','ç');
	    $eng = array('s','S','i','I','g','G','u','U','o','O','C','c');
	    $filename = str_replace($tr,$eng,$filename);
	    return strtolower($filename);
	}
	

	function akreditasyonKurulusumu(){
	    $user_id = JFactory::getUser()->getOracleUserId();
	    $db = & JFactory::getOracleDBO();
	    $yetkilimi = false;
	    $sql = "SELECT KURULUS_DURUM_ID FROM M_KURULUS WHERE USER_ID = ?";
	    
	    $durumIdler = $db->prep_exec($sql, array($user_id));
	    
	    if(isset($durumIdler)){
	    	
	    	$ids = explode(',',AKREDITASYON_KURULUS_DURUM_IDS);
	    	
	    	foreach($ids AS $id){
	    		if($durumIdler[0]['KURULUS_DURUM_ID'] == $id){
	    			$yetkilimi= true;
	    			break;
	    		}
	    	}
	    	
	    	return $yetkilimi;
	    }	    
	}
	function belgelendirmeKurulusumu(){
	    $user_id = JFactory::getUser()->getOracleUserId();
	    $db = & JFactory::getOracleDBO();
	    $yetkilimi = false;
	    $sql = "SELECT KURULUS_DURUM_ID FROM M_KURULUS WHERE USER_ID = ?";
	    
	    $durumIdler = $db->prep_exec($sql, array($user_id));
	    
	    if(isset($durumIdler)){
	    	
	    	$ids = explode(',',SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
	    	
	    	foreach($ids AS $id){
	    		if($durumIdler[0]['KURULUS_DURUM_ID'] == $id){
	    			$yetkilimi= true;
	    			break;
	    		}
	    	}
	    	
	    	return $yetkilimi;
	    }	    
	}
	
	function yeterlilikHazirlamayaYetkiliMi ($userId, $yeterlilikId){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT COUNT (*)   
			   FROM m_yeterlilik
			   	  JOIN m_yeterlilik_evrak USING (yeterlilik_id)   
			   	  JOIN m_basvuru USING (evrak_id) 
			   	  JOIN m_kurulus USING (user_id)   
			   WHERE yeterlilik_id = ? AND user_id = ?";
		
		$params = array ($yeterlilikId, $userId);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if ($data[0] > 0)
			return true;
		else
			return false;
	}
	function yeterlilikHazirlamayaProtokoluVarMi ($userId, $yeterlilikID){
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT COUNT(*)
					FROM m_yetki, m_yetki_yeterlilik, m_kurulus_yetki 
					WHERE m_yetki.YETKI_ID = m_yetki_yeterlilik.YETKI_ID
					      AND m_kurulus_yetki.YETKI_ID = m_yetki.YETKI_ID
					AND yeterlilik_id = ? AND user_id = ?  
			";
	
		$params = array ($yeterlilikID, $userId);
	
		$data = $_db->prep_exec_array($sql, $params);
	
		if ($data[0] > 0)
		return true;
		else
		return false;
	}
	function standartHazirlamayaYetkiliMi ($userId, $standartId){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT COUNT (*)   
			   FROM m_meslek_standartlari
           		  JOIN m_meslek_stan_evrak USING (standart_id) 
			   	  JOIN m_basvuru USING (evrak_id) 
			   	  JOIN m_kurulus USING (user_id)   
			   WHERE standart_id = ? AND user_id = ?";
		
		$params = array ($standartId, $userId);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if ($data[0] > 0)
			return true;
		else
			return false;
	}
	function standartHazirlamayaProtokoluVarMi ($userId, $standartId){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT COUNT(*)   
				FROM m_yetki, m_yetki_standart, m_kurulus_yetki 
				WHERE m_yetki.YETKI_ID = m_yetki_standart.YETKI_ID
				      AND m_kurulus_yetki.YETKI_ID = m_yetki.YETKI_ID
				AND standart_id = ? AND user_id = ?  
		";
		
		$params = array ($standartId, $userId);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if ($data[0] > 0)
			return true;
		else
			return false;
	}


	function ignoreBreaks ($str){
		return nl2br ($str);
	}
	
	function toUpperCase($input){ 
		$str = strtr ($input, array ('ÄŸ'=>'Ä�','Ã¼'=>'Ãœ','ÅŸ'=>'Å�','Ä±'=>'I','i'=>'Ä°','Ã¶'=>'Ã–', 'Ã§'=>'Ã‡'));
		return mb_strtoupper ($str, "utf-8");
	}
	
	function toLowerCase($input){
		$str = strtr($input, array('Ä�'=>'ÄŸ', 'Ãœ'=>'Ã¼', 'Å�'=>'ÅŸ', 'I'=>'Ä±', 'Ä°'=>'i', 'Ã–'=>'Ã¶', 'Ã‡'=>'Ã§'));
		return mb_strtolower ($str, "utf-8");
	}
	
	function readFileFromDB ($file){
		//createShellConnection ();
		$file = EK_FOLDER.$file;
		if (file_exists($file)) {

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}
	
	function createShellConnection (){
		// Define the parameters for the shell command
		$location = "\\\\myk04\upload";
		$user = "Administrator";
		$pass = "Mykb2mAZ14";
		
		// Map the drive
		system("net use ".EK_LETTER.": \"".$location."\" ".$pass." /user:".$user." /persistent:no");
	}
	
	function replaceNewLinesForJavascriptCode($stringToReplace)
	{
		$from = array("\r\n");
		$to   = array(" ");
		
		$newphrase = str_replace($from, $to, $stringToReplace);
		return $newphrase;
	}
	
	
	/**
	 * 
	 * Girdideki kelimeleri sadece ilk harfi buyuk olacak sekilde duzenlerken
	 * baglaclarda tamamen kucuk harf gosterim esas alinir.
	 * @param string $input
	 */
	
	function ucWordsLeaveConjunction ($input){
		// Tamamen kucuk harf gosterilmesi istenen kelimeler $conjunction dizisine ilave edilebilir:
		$conjunction = array('ve', 'veya');
		$input = FormFactory2::toLowerCase($input);
		$input = preg_replace('#\b('.implode('|', $conjunction).')\b#', 'Donotcapitalize$1', $input); 
    	$input = FormFactory2::ucwordsTR($input);
    	return str_replace('Donotcapitalize', '', $input);
	}
	
	/**
	 * 
	 * Girdideki her kelimenin sadece ilk harfini buyuk olacak sekilde duzenler.
	 * Turkce karakterlerle de uyumludur.
	 * @param string $input
	 */
	
	function ucWordsTR ($input) {
		$input = FormFactory2::toLowerCase($input);
		return preg_replace('#([^a-zÄ±ÄŸÃ¼ÅŸÃ§Ã¶]|^)([a-z]|ÅŸ|Ã§|Ã¶|Ã¼|ÄŸ|Ä±)#e', '"$1".FormFactory2::toUpperCase("$2")', $input);
	}
	
	function mb_str_pad ($input, $pad_length, $pad_string, $pad_style, $encoding="UTF-8") {
		return str_pad($input,
				strlen($input)-mb_strlen($input,$encoding)+$pad_length, $pad_string, $pad_style);
	}
	
}
?>