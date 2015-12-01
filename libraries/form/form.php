<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once('libraries/form/form_config.php');

class FormFactory
{

	public function sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID)
	{
		$db = JFactory::getOracleDBO();
		$fromUser = JFactory::getUser();
		$fromUserID = $fromUser->getOracleUserId();
	
		$sql = "INSERT INTO M_UYARILAR (UYARI_ID, FROM_USER_ID,	ACIKLAMA, LINK, TARIH, GORMEZDEN_GEL, TO_USER_ID)
		VALUES (?,?,?,?,?,?,?)";
	
		$params[]=$db->getNextVal(UYARI_ID_SEQ);
		$params[]=$fromUserID;
		$params[]=$aciklamaText;
		$params[]=$link;
		$params[]=time();
		$params[]=null;//görmezden gel = 0
		$params[]=$toUserID;
	
		return $db->prep_exec_insert($sql, $params);
	}
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
		$dis_kurum_id			= FormFactory::getBirimId ($user_id);
		
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
	
	function basvuruOlustur ($evrak_id, $user_id, $basvuru_tip, $basvuru_durum){
		$_db =& JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_basvuru 
				 (evrak_id, user_id, basvuru_tip_id, faliyet_sure_id, basvuru_durum_id, basvuru_tarihi, 
				 EKIP_ACIKLAMA, ALTYAPI_ACIKLAMA, DIS_ALIM_HIZMET, DIS_ALIM_TEDBIR, DANISMA_ACIKLAMA, PILOT_ACIKLAMA, KURULUS_TALEP_ACIKLAMA, GEZICI_BIRIM, EGITIM_ACIKLAMA, TEKNIK_FIZIKI_ACIKLAMA,PIYASA_ACIKLAMA) 
				 values( ?, ?, ?, 1, ? , SYSTIMESTAMP, 
				 		 EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB(),EMPTY_CLOB())";
			         
		$params = array($evrak_id,
						$user_id,
						$basvuru_tip,
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
	
	public function basvuruDurumGuncelle ($evrak_id, $durum){
		$_db =& JFactory::getOracleDBO();
		$sql = "SELECT USER_ID, BASVURU_TIP_ID FROM m_basvuru WHERE evrak_id=?";
		$data = $_db->prep_exec($sql, array($evrak_id));
		$user_id = $data[0]["USER_ID"];
		$tip = $data[0]["BASVURU_TIP_ID"];
		
		
		$sql = "SELECT EVRAK_ID FROM m_basvuru WHERE user_id=? AND  BASVURU_DURUM_ID=-1 and basvuru_tip_id = ".$tip." AND EVRAK_ID <> ?";
		//std ve yet. den durumu kaydedilmemiş başvuru olanlar
		$data = $_db->prep_exec_array($sql, array($user_id, $evrak_id));
		
		
		
		
		if(count($data)>0)
		{
			$sql = "DELETE FROM m_basvuru_bagli_kurulus WHERE evrak_id IN (".implode(", ", $data).")";
			$result =  $_db->prep_exec_insert($sql, array());
			
			$sql = "DELETE FROM m_basvuru_birlikte_kurulus WHERE evrak_id IN (".implode(", ", $data).")";
			$result =  $_db->prep_exec_insert($sql, array());
			
			$sql = "DELETE FROM m_basvuru_ekler WHERE evrak_id IN (".implode(", ", $data).")";
			$result =  $_db->prep_exec_insert($sql, array());
			
			$sql = "DELETE FROM m_basvuru_faliyet_alan WHERE evrak_id IN (".implode(", ", $data).")";
			$result =  $_db->prep_exec_insert($sql, array());
			
		//	$sql = "DELETE FROM m_basvuru_personel WHERE evrak_id IN (".implode(", ", $data).")";
		//	$result =  $_db->prep_exec_insert($sql, array());
			
			$sql = "DELETE FROM m_basvuru_sektor WHERE evrak_id IN (".implode(", ", $data).")";
			$result =  $_db->prep_exec_insert($sql, array());
			
			$sql = "DELETE FROM m_basvuru WHERE evrak_id IN (".implode(", ", $data).")";
			$result =  $_db->prep_exec_insert($sql, array());
		
			$query="delete jos_user_evrak where evrak_id IN (".implode(", ", $data).")";
			$sql=mysql_query($query);
			
				
		}
		
		
		
		$sql=mysql_query("select id from jos_users where tgUserid =".$user_id);
		$data=mysql_fetch_array($sql);
		
		$query="insert into jos_user_evrak set evrak_id=".$evrak_id.", user_id=".$data[0].", basvuru_tur=".$tip;
		$sql=mysql_query($query);
		
		$sql = "UPDATE m_basvuru   
				    SET basvuru_durum_id = ? 
				    WHERE evrak_id = ?";
				         
		$params = array($durum, $evrak_id);	
					
		return $_db->prep_exec_insert($sql, $params);
		
	}
	
	public function BelgelendirmebasvuruDurumGuncelle ($evrak_id, $durum){
		$_db =& JFactory::getOracleDBO();
		$mysql= & JFactory::getDBO();
		$sql = "UPDATE M_BELGELENDIRME_DURUM
							    SET DURUM_ID = ? 
							    WHERE EVRAK_ID = ?";
				
		$karams = array($durum, $evrak_id);
		
		if($durum == 4 || $durum == 18 || $durum == 10  || $durum == 20 || $durum == -2 || $durum == 12){

			$sql1 = "UPDATE m_basvuru
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
				$sqlquery = "select id from jos_users where tgUserId =".$user_id[0]['USER_ID'];
				$id = mysql_fetch_array(mysql_query($sqlquery));
				$menuguncelleson = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (12,11,11, ".$id['id'].")";
				$sorgu = mysql_query($menuguncelleson); 
			}
			$_db->prep_exec_insert($sql1, $params);
		}
		return $_db->prep_exec_insert($sql, $karams);
	}
	
	public function irtibatVerileriKaydet ($evrak_pk, $panelName, $posted){
		$panelCount = $posted["panelCount_".$panelName];
		$result = true;
		
		for ($i = 1; $result && ($i < $panelCount+2); $i++){
			$irtibatHiddenId = $panelName.$i;
			if ($i == 1)
				$irtibatHiddenId = $panelName;

			if (!isset ($posted[$irtibatHiddenId])){ 					// INSERT
				if (isset ($posted["input".$irtibatHiddenId."-2"])){
					$inputName 	= "input".$irtibatHiddenId;
					$rowCount	= 4;			
					$panelValues =  FormFactory::getPanelValues ($posted, $inputName, $rowCount);
					$result = FormFactory::irtibatVerisiEkle($evrak_pk, $panelValues);
				}
				
			}else{ 
				$irtibatId = $posted[$irtibatHiddenId];
				
				if (!isset ($posted["input".$irtibatHiddenId."-2"])){	// DELETE
					$result =  FormFactory::irtibatVerisiSil($evrak_pk, $irtibatId);
				}else{													// UPDATE
					$inputName 	= "input".$irtibatHiddenId;
					$rowCount	= 4;			
					$panelValues =  FormFactory::getPanelValues ($posted, $inputName, $rowCount);
					$result = FormFactory::irtibatVerisiGuncelle($evrak_pk, $irtibatId, $panelValues);
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
	
	public function sektorVerileriKaydet($evrak_pk, $tableName, $posted){
		$colCount = 3;
		$sektorValues = FormFactory::getTableValues ($posted, array ($tableName, $colCount));
		$result = FormFactory::sektorVerisiSil($evrak_pk);
		
		for ($i = 0; $result && ($i < count($sektorValues)/$colCount); $i++){
			$id 		= ($sektorValues[($i*$colCount)] == "Seçiniz") ? null : $sektorValues[($i*$colCount)];
			$aciklama 	= $sektorValues[($i*$colCount)+1];
			$results = FormFactory::sektorVerisiEkle($evrak_pk, $id, $aciklama);
		}
		
		return $results;
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
		$sql = "INSERT INTO m_basvuru_sektor (SEKTOR_ID,EVRAK_ID,SEKTOR_ACIKLAMA)
				values( '".$sektor_id."', '".$evrak_pk."', '".$sektor_aciklama."')";
			         
		$params = array($sektor_id,
						$evrak_pk,
						$sektor_aciklama,
						);
					
		$result= $_db->prep_exec_insert($sql, array());
		return $result;
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
	 * Belgelendirme basvurusu faaliyet bilgileri sekmesinde 6. bölüm
	 * faaliyet alanları kısmının paragraf şeklinde kullanılması icin
	 * eklendi:
	 * 
	 */
	public function patchForBelgelendirmeFaaliyetVerileriKaydet($evrak_pk, $tableName, $posted){
		$result = FormFactory::faaliyetVerisiSil($evrak_pk);
		
		if ($result){
			$alan	= $posted["inputfaaliyet-1"];
			$result = FormFactory::faaliyetVerisiEkle($evrak_pk, 1, $alan);
		}
		
		return $result;
	}
	
	public function faaliyetVerileriKaydet($evrak_pk, $tableName, $posted){
		$faaliyetValues = FormFactory::getTableValues ($posted, array ($tableName, 1));
		$result = FormFactory::faaliyetVerisiSil($evrak_pk);
		
		for ($i = 0; $result && ($i < count($faaliyetValues)); $i++){
			$id		= $i+1;
			$alan 	= $faaliyetValues[$i];
			$results = FormFactory::faaliyetVerisiEkle($evrak_pk, $id, $alan);
		}
		
		return $results;
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
	
	public function bagliKurulusVerileriKaydet($evrak_pk, $tableName, $posted){
		$kurulusValues = FormFactory::getTableValues ($posted, array ($tableName, 1));
		$result = FormFactory::bagliKurulusVerisiSil($evrak_pk);
		
		for ($i = 0; $result && ($i < count($kurulusValues)); $i++){
			$id		= $i+1;
			$alan 	= $kurulusValues[$i];
			$result = FormFactory::bagliKurulusVerisiEkle($evrak_pk, $id, $alan);
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
	
	public function birlikteKurulusVerileriKaydet($evrak_pk, $panelName, $posted, $rowCount){
		$result = false;
		
		if (isset ($posted["panelCount_".$panelName])){		
			$panelCount = $posted["panelCount_".$panelName];
			$result = true;
			
			$count = 1;
			for ($i = 1; $result && ($i < $panelCount+2); $i++){
				$kurulusHiddenId = $panelName.$i;
				if ($i == 1)
					$kurulusHiddenId = $panelName;
	
				if (!isset ($posted[$kurulusHiddenId])){ 					// INSERT
					if (isset ($posted["input".$kurulusHiddenId."-2"])){
						$inputName 	= "input".$kurulusHiddenId;
						$panelValues =  FormFactory::getPanelValues ($posted, $inputName, $rowCount);
						$result = FormFactory::birlikteKurulusVerisiEkle($evrak_pk, $panelValues);
						$count++;
					}
					
				}else{ 
					$kurulusId = $posted[$kurulusHiddenId];
					
					if (!isset ($posted["input".$kurulusHiddenId."-2"])){	// DELETE
						$result = FormFactory::birlikteKurulusVerisiSil($evrak_pk, $kurulusId);
					}else{													// UPDATE
						$inputName 	= "input".$kurulusHiddenId;
						$panelValues =  FormFactory::getPanelValues ($posted, $inputName, $rowCount);
						$result = FormFactory::birlikteKurulusVerisiGuncelle($evrak_pk, $kurulusId, $panelValues);
					}
				}		
			}
		}else{
			$result = FormFactory::birlikteKurulusVerileriSil($evrak_pk);
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
	
	public function basvuruEkleriKaydet($evrak_pk, $tableName, $posted, $tip = null, $aciklamaKolon = 1){
		$aciklamalar = $posted ["input".$tableName."-".$aciklamaKolon];	    		
    	$ekId 	= "ek_id_";
		$ekAd 	= "filename_".$tableName."_0_";
		$ekPath = "path_".$tableName."_0_";
		
		$updated = 0;
		for ($i = 1; isset ($posted[$ekId.$i]); $i++){	
			$inpFileName = $ekAd.$i;
			$ek_id 	 	 = $posted[$ekId.$i];
			if ($ek_id != -1){
				if (isset ($posted[$inpFileName])){ // GUNCELLE
					$aciklama = $aciklamalar[$updated];
					$file	  = $posted[$inpFileName];
					$path 	  = $posted[$ekPath.$i];
					$normalFile = FormFactory::getNormalFilename ($file);
		
					if (!FormFactory::basvuruEkiGuncelle ($ek_id, $aciklama, $path, $normalFile))
						return JText::_("VERI_GUNCELLE_HATA");
					
					$updated++;
					
				}else {				   // SIL
					if (!FormFactory::basvuruEkiSil ($ek_id))
						return JText::_("VERI_SIL_HATA");
				}
			}else{
				//Belgelendirme Basvuru Formu (ek2) / Aradaki ekleri ekle
				if (isset ($posted[$inpFileName])){
					$aciklama 	= $aciklamalar [$updated+$j];

					if (isset ($posted[$ekPath.($updated+$j+1)])){
						$filePath	= $posted[$ekPath.($updated+$j+1)];
						$fileName	= FormFactory::getNormalFilename($posted[$ekAd.($updated+$j+1)]);
						
						if (is_array($tip)){
							$ek_tip = $tip[$updated+$j];
						}else{
							$ek_tip = $tip;
						}
						
						
						if (!FormFactory::basvuruEkiEkle ($evrak_pk, $aciklama, $fileName,$filePath, $ek_tip))
							return JText::_("VERI_EKLE_HATA");			
					}
				}
				$updated++;
			}
		}
		
		// GERISINI EKLE
		for ($j = 0; isset ($posted["input".$tableName."-1"][($updated+$j)]); $j++){
			$aciklama 	= $aciklamalar [$updated+$j];

			if (isset ($posted[$ekPath.($updated+$j+1)])){
				$filePath	= $posted[$ekPath.($updated+$j+1)];
				$fileName	= FormFactory::getNormalFilename($posted[$ekAd.($updated+$j+1)]);
				
				if (is_array($tip)){
					$ek_tip = $tip[$updated+$j];
				}else{
					$ek_tip = $tip;
				}
				
				
				if (!FormFactory::basvuruEkiEkle ($evrak_pk, $aciklama, $fileName,$filePath, $ek_tip))
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
		$sonuc=$db->prep_exec_insert ($sql, $params);
		return $sonuc;
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
	
	public function kisiBilgiVerileriKaydet ($evrak_pk, $panelName, $posted){
		$panelCount = $posted["panelCount_".$panelName];
		$result = true;
		
		for ($i = 1; $result && $i < $panelCount+2; $i++){
			$kisiHiddenId = $panelName.$i;
			if ($i == 1)
				$kisiHiddenId = $panelName;

			if (!isset ($posted[$kisiHiddenId])){ 					// INSERT
				if (isset ($posted["input".$kisiHiddenId."-3"])){
					$result = FormFactory:: kisiBilgiVerisiEkle ($evrak_pk, $kisiHiddenId, $posted);
				}				
			}else{ 
				$kisiId = $posted[$kisiHiddenId];
				
				if (!isset ($posted["input".$kisiHiddenId."-3"])){	// DELETE
					$result = FormFactory::kisiBilgiVerisiSil ($kisiId);
				}else{												// UPDATE
					$result = FormFactory::kisiBilgiVerisiGuncelle ($evrak_pk, $kisiId, $kisiHiddenId, $posted);
				}
			}		
		}
		
		return $result;
		
	}
		
	private function kisiBilgiVerisiEkle ($evrak_pk, $panelName, $posted){
		$_db =& JFactory::getOracleDBO();
		$egitimColCount 	= 3;
		$sertifikaColCount 	= 4;
		$deneyimColCount 	= 5;
		$dilColCount 		= 5;
		$personel_id = $_db->getNextVal(PERSONEL_SEQ);
		
		$personelValues	 = FormFactory::getPanelValues ($posted, "input".$panelName, 9, 3);	//M_BASVURU_PERSONEL	
		$deneyimAciklama = $posted ["input".$panelName."-17"];
		$egitimValues	 = FormFactory::getTableValues ($posted, array ("div".$panelName."-13-12", $egitimColCount)); //M_PERSONEL_EGITIM
		$sertifikaValues = FormFactory::getTableValues ($posted, array ("div".$panelName."-15-14", $sertifikaColCount)); //M_PERSONEL_SERTIFIKA
		$deneyimValues	 = FormFactory::getTableValues ($posted, array ("div".$panelName."-19-18", $deneyimColCount)); //M_PERSONEL_DENEYIM		
		$dilValues		 = FormFactory::getTableValues ($posted, array ("div".$panelName."-21-20", $dilColCount)); //M_DILBILGISI
		
		$resultP = FormFactory::personelVerisiEkle ($evrak_pk, $personelValues, $deneyimAciklama, $personel_id);
		$resultE = FormFactory::egitimVerileriEkle 	($egitimValues, $personel_id, $egitimColCount);
		$resultS = FormFactory::sertifikaVerileriEkle($sertifikaValues, $personel_id, $sertifikaColCount);
		$resultD = FormFactory::deneyimVerileriEkle	($deneyimValues, $personel_id, $deneyimColCount);
		$resultDL = FormFactory::dilVerileriEkle 	($dilValues, $personel_id, $dilColCount);
		
		////////////////
		// Kısı bilgi ekindeki yeterlilik acıklaması icin:
		$resultYA = true;
		$yeterlilik_aciklama = "";
		if ($posted ["input".$panelName."-23"]) $yeterlilik_aciklama = $posted ["input".$panelName."-23"];
		if ($yeterlilik_aciklama != "")
			$resultYA = FormFactory::yeterlilikAciklamaKaydet ($personel_id, $yeterlilik_aciklama);
		////////////////
		//$returnValues = array ($resultP, $resultE, $resultS,$resultD, $resultDL);
		$returnValues = array ($resultP, $resultE, $resultS,$resultD, $resultDL, $resultYA);
		return !FormFactory::isThereError($returnValues);
	}
	
	private function kisiBilgiVerisiSil ($personel_id){
		$resultST = FormFactory::kisiBilgiTablolariSil ($personel_id);
		$resultS  = FormFactory::personelVerisiSil 	   ($personel_id);
		
		$returnValues = array ($resultST, $resultS);
		return !FormFactory::isThereError($returnValues);
	}
	
	private function kisiBilgiVerisiGuncelle ($evrak_pk, $personel_id, $panelName, $posted){
		$egitimColCount 	= 3;
		$sertifikaColCount 	= 4;
		$deneyimColCount 	= 5;
		$dilColCount 		= 5;
		
		$resultST = FormFactory::kisiBilgiTablolariSil ($personel_id);
		
		$personelValues	 = FormFactory::getPanelValues ($posted, "input".$panelName, 9, 3);	//M_BASVURU_PERSONEL	
		$deneyimAciklama = $posted ["input".$panelName."-17"];
		$egitimValues	 = FormFactory::getTableValues ($posted, array ("div".$panelName."-13-12", $egitimColCount)); //M_PERSONEL_EGITIM
		$sertifikaValues = FormFactory::getTableValues ($posted, array ("div".$panelName."-15-14", $sertifikaColCount)); //M_PERSONEL_SERTIFIKA
		$deneyimValues	 = FormFactory::getTableValues ($posted, array ("div".$panelName."-19-18", $deneyimColCount)); //M_PERSONEL_DENEYIM		
		$dilValues		 = FormFactory::getTableValues ($posted, array ("div".$panelName."-21-20", $dilColCount)); //M_DILBILGISI
		
		$resultP = FormFactory::personelVerisiGuncelle 	($personel_id, $personelValues, $deneyimAciklama);
		$resultE = FormFactory::egitimVerileriEkle 		($egitimValues, $personel_id, $egitimColCount);
		$resultS = FormFactory::sertifikaVerileriEkle	($sertifikaValues, $personel_id, $sertifikaColCount);
		$resultD = FormFactory::deneyimVerileriEkle		($deneyimValues, $personel_id, $deneyimColCount);
		$resultDL = FormFactory::dilVerileriEkle 		($dilValues, $personel_id, $dilColCount);
		
		////////////////
		// Kısı bilgi ekindeki yeterlilik acıklaması icin:
		$resultYA = true;
		$yeterlilik_aciklama = "";
		if ($posted ["input".$panelName."-23"]) $yeterlilik_aciklama = $posted ["input".$panelName."-23"];
		if ($yeterlilik_aciklama != "")
			$resultYA = FormFactory::yeterlilikAciklamaKaydet ($personel_id, $yeterlilik_aciklama);
		///////////////
		//$returnValues = array ($resultST, $resultP, $resultE, $resultS,$resultD, $resultDL);
		$returnValues = array ($resultST, $resultP, $resultE, $resultS,$resultD, $resultDL, $resultYA);
		return !FormFactory::isThereError($returnValues);
	}
	
	private function kisiBilgiTablolariSil ($personel_id){
		$resultE = FormFactory::egitimVerisiSil ($personel_id);
		$resultS = FormFactory::sertifikaVerisiSil ($personel_id);
		$resultD = FormFactory::deneyimVerisiSil ($personel_id);
		$resultDL = FormFactory::dilVerisiSil ($personel_id);
		
		$returnValues = array ($resultE, $resultS,$resultD, $resultDL);
		return !FormFactory::isThereError($returnValues);
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
			$result = FormFactory::egitimVerisiEkle ($panelValues, $personel_id, $id);
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
				values( ?, ?, ?, ?, ?)";
			         
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
			$result = FormFactory::sertifikaVerisiEkle ($panelValues, $personel_id, $id);
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
				values( ?, ?, ?, ?, ?, ?)";
			         
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
			$result = FormFactory::deneyimVerisiEkle ($panelValues, $personel_id, $id);
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
				values( ?, ?, ?, ?, ?, ?, ?)";
			         
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
								 
				$result = FormFactory::dilVerisiEkle ($values, $personel_id);
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
						
	
		return $_db->prep_exec_insert($sql, $params);
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
		
		$sql = "SELECT 	EVRAK_ID,
						BASVURU_TARIHI,
						FALIYET_SURE_ID,
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
						GOREV_BIRIM_EPOSTA,
						BELIRTILECEK_DIGER_HUSUSLAR,
						BASVURU_EK_DOSYASI_PATH,
						AKREDITASYON_FAALIYETI_ACK,
						USER_ID,
                        KISI_BILGI_DOSYASI,
						BASVURU_DURUM_ID
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
	
	function getPM_DenetimTuru(){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM pm_denetim_turu ORDER BY denetim_turu";
		
		$params = array ();
		
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
						EGITIM_BASLANGIC,
						EGITIM_BITIS,
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
						SERTIFIKA_TARIH,
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
						DENEYIM_BASLANGIC,
						DENEYIM_BITIS,
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
		$sonuc = $db->prep_exec($sql, $params);
		
		return $sonuc;
	}
	
	function checkAuthorization  ($user, $group_id){
		$result = true;
		if ($user->id != 0 ) { //Giris Yapmis Kullanici
			if (!FormFactory::checkAclGroupId ($user->id, $group_id)){
				$result = false;
			}
		}else{
			$result = false;
		}
		
		return $result;		
	}

	public function checkAclGroupId ($user_id, $group_id){
		if($user_id == 0)
			$result = false;
		else
		{
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
		}
		
		return $result;
	}
	
	function getTumSektorSorumlulari (){
		$mysql= & JFactory::getDBO();
	
		$sql = "SELECT
		id,
		tgUserId,
		name,
		username,
		email,
		block
		FROM `jos_users`
		WHERE `active` =2 AND block=0
		ORDER BY block,`name`";
		$users= $mysql->Execute ($sql);
	
		return $users->data;
	
	}
	
	function getPageTree ($user, $activeLayout, $evrak_id, $pages, $pageNames){
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;" ';
		$sayfa = count($pages);
		$saved = FormFactory::getSavedPages ($evrak_id);
		$saved[count($saved)] = 1;
		$tree = '<div class="form_element" style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
		$onClick = 'onclick = "basvuruGonder('.$evrak_id.')" ';
		$value = 'value="Tüm Basvuruyu Görüntüle / Bitir" ';
		
		$disabled = 'disabled="disabled"';
		
		if (count($saved)>= $sayfa){
			$disabled = '';
		}
			
		$name  = 'name="gonder" ';
		
		$tree .= $inp.$name.$value.$onClick.$disabled." />";
		
		$tree .= '<div style="clear:both;"></div></div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			for ($j = 0; $j < count($saved); $j++){
				if ($saved[$j] == ($i+1)){
					$style	 = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255); margin: 1px;" ';
					break;
				}
			}
			$input = '<input type="button" onclick="goToPage(\''.$pages[$i].'\', \''.$evrak_id.'\')" class="btn" id="page'.$i.'" value="'.$pageNames[$i].'" ';
			
			$disabled = '';
			/*if ($pages[$i]== "ek" && !in_array(3, $saved)){ // sayfa 3 kaydedilmis mi (faaliyet)
				$disabled = 'disabled="disabled"';
			}
		*/
			if ($activeLayout == $pages[$i])
				$tree .= $input.$activeStyle.$disabled.' />';
			else
				$tree .= $input.$style.$disabled.' />'; 
		}
		
		$tree .= '<br /></div>';
		
		return $tree;
	}
	
	function getCurrentEvrakId ($posted, $basvuru_tur, $user){
		$session = &JFactory::getSession();
		
		$evrak = $session->get("evrak_id");			 					//Kaydetme sayfasindan geldiyse
	
		if (!isset($evrak)){
			if (isset ($posted["evrak"])) 	  		 						//Sayfa arasinda dolaniyorsa
				$evrak = $posted["evrak_id"];	
			else
				$evrak = FormFactory::getEvrakId($user->id, $basvuru_tur);  //Sayfa yeni acildiysa
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
	
	public function getTableValues ($data, $paramArray, $t3=0){	
		$result 	= array();
		$inputName 	= "input".$paramArray[0];
		$colCount 	= $paramArray[1];
		$rowCount 	= 0;
		
		//Tablo Degerlerini array yap
		for ($i=0; $i < $colCount; $i++){
			$inp = $data[$inputName.'-'.($i+1)];
			if (isset ($inp))
				$array[$i] = $inp;
			else if ($t3){ //(T3) Radio Button olursa -> input<tablo_adi>-1-1 
				$rowCount 	= count (($data[$inputName.'-1']));
				$arr = array ();
				for ($j = 0; $j < $rowCount; $j++){
					$inp = $data[$inputName.'-'.($i+1).'-'.($j+1).'[]'];
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
				$result[$count] = trim ($array[$j][$i]);
				$count++;							
			}
		}
	
		
		/*echo "-----------------<br><pre>";
		print_r($result);
		echo "</pre>";*/
		
		return $result;
		
	}
	
	public function getPanelValues ($posted, $inputName, $rowCount, $addValue=2){	
		$result = array();
	
		//Tablo Degerlerini array yap
		for ($i=0; $i < $rowCount; $i++){
			$result[$i] = trim ($posted[$inputName.'-'.($i+$addValue)]);
		}
	
		return $result;
	}
	
	//Faaliyet bilgilerinde doldurulan ekip sayisi ile personel bilgi ekindeki tablo sayisini karsilastirir
	public function isPersonelCountEnough($evrak_id){
		$basvuru = FormFactory::getBasvuruValues ($evrak_id);
		$personel= FormFactory::getPersonelValues ($evrak_id);
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
		$uFileName = FormFactory::normalizeFilename($filename);
  		list($usec, $sec) = explode(" ",microtime()); 
		return $usec.$sec."_".FormFactory::formatFilename($uFileName);
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
		return FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID) || FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID) || FormFactory::checkAclGroupId($user->id, YONETICI_GROUP_ID) || FormFactory::checkAclGroupId($user->id, UZMAN_ONIZLEYICI_GROUP_ID);
	}
	
	
    //Sektor Sorumlusunun Sorumlu oldugu sektor idler
    function getSorumluSektorId ($user_id, $tip){
    	$db = & JFactory::getOracleDBO();
    	 
    	$sql = "SELECT sektor_id 
    			FROM M_YETKI_SEKTOR_SORUMLUSU 
    			WHERE user_id = ? AND YETKI_ALANI = ".$tip;
							
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
		
		/*$sql= "SELECT COUNT (*)   
			   FROM m_yeterlilik
			   	  JOIN m_yeterlilik_evrak USING (yeterlilik_id)   
			   	  JOIN m_basvuru USING (evrak_id) 
			   	  JOIN m_kurulus USING (user_id)   
			   WHERE yeterlilik_id = ? AND user_id = ?";
		*/
		$sql= "SELECT * FROM M_YETKI_YETERLILIK JOIN M_YETKI USING (YETKI_ID) JOIN M_KURULUS_YETKI USING (YETKI_ID)
WHERE ETKIN=1 AND YETERLILIK_ID = ? AND USER_ID = ?";
		
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
	
	function aktifStandartYetkilendirmesiVarMi($standart_id, $user_id)
	{
	
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT * FROM M_YETKI_STANDART 
			JOIN M_YETKI USING (YETKI_ID) 
			JOIN M_KURULUS_YETKI USING (YETKI_ID)
			WHERE ETKIN=1 AND STANDART_ID = ? AND USER_ID = ?";
		$params = array ($standart_id, $user_id);
	
		if(count($_db->prep_exec($sql, $params)) > 0)
			return true;
		else
			return false;
	}
	


	function ignoreBreaks ($str){
		return nl2br ($str);
	}
	
	function toUpperCase($input){ 
		$str = strtr ($input, array ('ğ'=>'Ğ','ü'=>'Ü','ş'=>'Ş','ı'=>'I','i'=>'İ','ö'=>'Ö', 'ç'=>'Ç'));
		return str_replace("  ", " ", mb_strtoupper ($str, "utf-8"));
	}
	
	function toLowerCase($input){
		$str = strtr($input, array('Ğ'=>'ğ', 'Ü'=>'ü', 'Ş'=>'ş', 'I'=>'ı', 'İ'=>'i', 'Ö'=>'ö', 'Ç'=>'ç'));
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
	
	function replaceNewLinesWithBRForJavascriptCode($stringToReplace)
	{
		$from = array("\r\n");
		$to   = array("<BR/>");
	
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
		$input = FormFactory::toLowerCase($input);
		$input = preg_replace('#\b('.implode('|', $conjunction).')\b#', 'Donotcapitalize$1', $input); 
    	$input = FormFactory::ucwordsTR($input);
    	return str_replace('Donotcapitalize', '', $input);
	}
	
	/**
	 * 
	 * Girdideki her kelimenin sadece ilk harfini buyuk olacak sekilde duzenler.
	 * Turkce karakterlerle de uyumludur.
	 * @param string $input
	 */
	
	function ucWordsTR ($input) {
		$input = FormFactory::toLowerCase($input);
		return preg_replace('#([^a-zığüşçö]|^)([a-z]|ş|ç|ö|ü|ğ|ı)#e', '"$1".FormFactory::toUpperCase("$2")', $input);
	}
	
	function buIDDenetlemesiYapilacakKurulusMu($user_id)
	{
		//com_denetim icin
		//SINAV VE BELGELENDİRME BAŞVURUSU YAPABİLİRSE 
		$result = false;
		if($user_id!='')
			$result = FormFactory::checkAclGroupId ($user_id, T3_GROUP_ID);
		//com_denetim icin
		return $result;

	}
	
	function buIDDenetciMi($user_id)
	{
		$result = false;
		if($user_id!='')
		{
			$_db = &JFactory::getOracleDBO();
			$sql= "SELECT * FROM M_DENETIM_EKIP
			WHERE PERSONEL_ID = ? AND PERSONEL_ROLU IN (1,2,3)";//1,2,3 sırasıyla başdenetci, denetci, yard.denetci
			$params = array ($user_id);
			
			$denetlenenDenetimler = $_db->prep_exec($sql, $params);
			if(count($denetlenenDenetimler)>0)
				$result=true;
		}
		//com_denetim icin
		return $result;
	}
	
	function buIDDenetlemedenSorumluSSMu($user_id)
	{
		$result = false;
		if($user_id!='')
		{
			$msMi = FormFactory::checkAclGroupId ($user_id, MS_SEKTOR_SORUMLUSU_GROUP_ID);
			$yetMi = FormFactory::checkAclGroupId ($user_id, YET_SEKTOR_SORUMLUSU_GROUP_ID);
			$muhasebeciMi = FormFactory::checkAclGroupId ($user_id, MUHASEBECI_GROUP_ID);
				
			$result = $msMi || $yetMi || $muhasebeciMi;
		}
		//com_denetim icin
		return $result;
	}
	
	function KurulusIcinGorevliMi($user_id,$kurulus_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_KURULUS_GOREVLI WHERE TGUSERID = ? AND KURULUS_ID = ?";
		
		if($_db->prep_exec($sql, array($user_id,$kurulus_id))){
			return true;
		}else{
			return false;
		}
	}
	
	function sentEmail($baslik, $icerik, $to,$html=false,$files=false){
		if(!strpos($_SERVER['SERVER_NAME'],"myk.gov")){
			return true;
		}
		$mailer =&JFactory::getMailer();
		$config =&JFactory::getConfig();
		$sender = array(
				$config->getValue( 'config.mailfrom' ),
				$config->getValue( 'config.fromname' ) );
		$mailer->setSender($sender);
		
		$mailer->addRecipient($to);
// 		if(strpos($_SERVER['SERVER_NAME'],"myk.gov")){
// 			$mailer->addRecipient($to);
// 		}else{
// 			$mailer->addRecipient(array('ktunc@myk.gov.tr','htoplu@myk.gov.tr'));
// 		}
		
		$mailer->setSubject($baslik);
		
		if($files <> false){
			$mailer->addAttachment($files);
		}
		if($html){
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
		}
		$mailer->setBody($icerik);
		
		$send = $mailer->Send();
	}
	
	function BasvuruTipleri(){
		$_db = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM PM_BASVURU_TIP";
		return $_db->prep_exec($sql, array());
	}
	
	function getKurulusGuncelBilgi($kurulusId){
		$db  = &JFactory::getOracleDBO();
			
		$sql = "SELECT * FROM M_KURULUS_EDIT
				LEFT JOIN pm_kurulus_statu USING (KURULUS_STATU_ID)
				LEFT JOIN ".DB_PREFIX.".p_il ON (il_id = kurulus_sehir)
				WHERE USER_ID=? AND ONAY_BEKLEYEN = 0 AND AKTIF = 1";
			
		$data = $db->prep_exec($sql, array($kurulusId));
			
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function getKurulusGuncelIl($edit_id, $pdf = 0){
		$db = & JFactory::getOracleDBO();
	
		if ($pdf){
			$sql = "SELECT il_adi
					FROM m_kurulus_faliyet_il_edit
						JOIN ".DB_PREFIX.".p_il USING (il_id)
					WHERE edit_id = ?";
		}else{
			$sql = "SELECT il_id
					FROM m_kurulus_faliyet_il_edit
					WHERE edit_id = ?";
		}
	
		$params = array ($edit_id);
		$data = $db->prep_exec_array($sql, $params);
	
		return $data;
	}
	
	function getKurulusGuncelBilgiByEditId($editId){
		$db = & JFactory::getOracleDBO();
	
		$sql = 'SELECT * FROM M_KURULUS_EDIT WHERE EDIT_ID = ?';
	
		$data = $db->prep_exec($sql, array($editId));
	
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function getYayindakiYetlilikler(){
		$db = & JFactory::getOracleDBO();
		
			$sql = "SELECT DISTINCT
					m_yeterlilik.YETERLILIK_ID,
					m_yeterlilik.YETERLILIK_ADI,
					m_yeterlilik.YETERLILIK_KODU,
					SEVIYE_ADI,
					YETERLILIK_BASLANGIC AS BASLANGIC_TARIHI_FORMATTED,
					YETERLILIK_SUREC_DURUM_ADI,
					m_yeterlilik.YETERLILIK_SUREC_DURUM_ID,
					m_yeterlilik.SEKTOR_ID,
					YENI_MI,
					m_taslak_yeterlilik.REVIZYON_NO,
					m_yeterlilik.revizyon
			FROM 	m_yeterlilik,
					m_taslak_yeterlilik,
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
					AND m_taslak_yeterlilik.yeterlilik_id = m_yeterlilik.yeterlilik_id
					AND m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = pm_yeterlilik_surec_durum.YETERLILIK_SUREC_DURUM_ID
					AND m_yeterlilik.SEKTOR_ID = pm_sektorler.SEKTOR_ID
					AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
					AND yeterlilik_durum_id = ".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK."
			order by m_yeterlilik.YETERLILIK_ADI,SEVIYE_ADI";
	
			$taslaklar = $db->prep_exec($sql, array());
		
		return $taslaklar;
	}
	
	function getYets($yetId){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT *
    	FROM m_yeterlilik
    	WHERE m_yeterlilik.yeterlilik_id = ?";
		
		$yeterlilik = $db->prep_exec($sql, array ($yetId));
		
		if (!empty ($yeterlilik))
			return $yeterlilik[0];
		else
			return null;
	}
	
	function getSektors(){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT *
    	FROM PM_SEKTORLER
		WHERE SEKTOR_DURUM = 1
    	ORDER BY SEKTOR_ADI ASC";
		
		$data = $db->prep_exec($sql, array());
		
		if (!empty ($data))
			return $data;
		else
			return null;
	}
	
	function getBelgeliSektors(){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT DISTINCT PM_SEKTORLER.*
    	FROM PM_SEKTORLER
		INNER JOIN M_YETERLILIK ON(PM_SEKTORLER.SEKTOR_ID = M_YETERLILIK.SEKTOR_ID)
		INNER JOIN M_BELGELENDIRME_YET_YETKI MBYY ON(M_YETERLILIK.YETERLILIK_ID = MBYY.YETERLILIK_ID)
		WHERE PM_SEKTORLER.SEKTOR_DURUM = 1 AND M_YETERLILIK.YETERLILIK_DURUM_ID = 2 AND MBYY.DURUM = 1
    	ORDER BY PM_SEKTORLER.SEKTOR_ADI ASC";
	
		$data = $db->prep_exec($sql, array());
	
		if (!empty ($data))
			return $data;
		else
			return null;
	}
	
	/**
	 * TCKimlikDogrulama(array("isim"=>"TEST","soyisim"=>"SOYAD","dogumyili"=>"1989","tcno"=>"11869794566"));
	 * parametereler
	 * tcno = TC Kimlik
	 * isim = İsim (Büyük harfle yazılmalı)
	 * soyisim = Soyisim (Büyük harfle yazılmalı)
	 * dogumyili = Doğum Yılı
	 * 
	 * Dönen Değerler
	 * true = Kimlik bilgileri doğru
	 * false = Kimlik bilgileri yanlış
	 * Eksik bilgilerin geri dönüşü olabiliyor (İsim bilgisi boş vb.)
	 *
	 * */
	function TCKimlikDogrulama($bilgiler){
	
		$gonder = '<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			<soap:Body>
			<TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
			<TCKimlikNo>'.trim($bilgiler["tcno"]).'</TCKimlikNo>
			<Ad>'.trim(FormFactory::toUpperCase($bilgiler["isim"])).'</Ad>
			<Soyad>'.trim(FormFactory::toUpperCase($bilgiler["soyisim"])).'</Soyad>
			<DogumYili>'.$bilgiler["dogumyili"].'</DogumYili>
			</TCKimlikNoDogrula>
			</soap:Body>
			</soap:Envelope>';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,            "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_POST,           true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS,    $gonder);
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
		'POST /Service/KPSPublic.asmx HTTP/1.1',
		'Host: tckimlik.nvi.gov.tr',
		'Content-Type: text/xml; charset=utf-8',
		'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
		'Content-Length: '.strlen($gonder)
		));
		$gelen = curl_exec($ch);
		curl_close($ch);
	
		return strip_tags($gelen);
	}
	
	function tehlikeliYeterlilik(){
		$db = & JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_YETERLILIK WHERE TEHLIKELI_IS_DURUM = 1";
		
		return  $db->prep_exec($sql, array());
	}

    function getKurulusBilgi($kurulusId){
        $db = JFactory::getOracleDBO ();
        $sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI,
                M_KURULUS_EDIT.KURULUS_KISA_ADI AS KURULUS_KISA_ADI, M_KURULUS_EDIT.USER_ID AS KURULUS_ID,
                M_KURULUS_EDIT.KURULUS_EPOSTA AS KURULUS_EPOSTA, M_KURULUS_EDIT.VERGI_KIMLIK_NO AS VERGI_KIMLIK_NO
				FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI, KURULUS_KISA_ADI, USER_ID AS KURULUS_ID,
                KURULUS_EPOSTA, VERGI_KIMLIK_NO
				FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
				  ORDER BY KURULUS_ADI ASC";
        $data = $db->prep_exec($sql, array($kurulusId,$kurulusId));

        if($data){
            return $data[0];
        }else{
            return false;
        }
    }
}
?>