<?php
defined('_JEXEC') or die('Restricted access');

class Kurulus_EditModelKurulus_Kaydet extends JModel {
	
	function kurulusGuncelle ($post, $user_id) {
		$db = JFactory::getOracleDBO ();
		
		$resultK = $this->updateKurulus ($user_id, $post);
		$resultD = $this->deleteIller ($user_id);
		$resultI = $this->insertIller ($user_id, $post);
		
		$returnValues = array ($resultK, $resultD, $resultI);
		
		if ( FormFactory::isThereError($returnValues))
			return JText::_("KURULUS_GUNCELLE_HATA");
		else
			return JText::_("KURULUS_GUNCELLE_BASARILI");
	}
	
	function standartKaydet ($data, $user_id, $evrak_id){
	    if ($evrak_id == -1){
    		$evrak_id = $this->basvuruOlustur($user_id, 1);
    	}
		
    	if ($evrak_id != -1){
			$colCount  = 8;
			$tableName = "meslek_standart";
			$values    = FormFactory::getTableValues ($data, array ($tableName, $colCount));
			$rowCount = count($values)/$colCount;

	    	$inpTablo 	= "tablo_".$tableName."_";
	    	$tabloId	= $tableName."_";
	    	
	    	$deleted = 0;
	    	$updated = 0;
	    	for ($i = 1; isset ($data[$tabloId.$i]); $i++){
	    		$inpName 	 = $inpTablo.$i;
	    		$standart_id = $data[$tabloId.$i];
	    		if (isset ($data[$inpName])){ // GUNCELLE
	    			$id = $updated * $colCount;	
	
	    			if (!$this-> meslekStandartGuncelle ($evrak_id, $standart_id, $values, $id))
	    				return JText::_("STANDART_GUNCELLE_HATA");
	    			
	    			$updated++;
	    		}else {				   // SIL
        			if (!$this->meslekStandartDurumGuncelle ($standart_id ))
    					return JText::_("STANDART_DURUM_GUNCELLE_HATA");
	    		}
	    	}
	    	
	    	// GERISINI EKLE
        	for ($j = 0; isset ($data["input".$tableName."-1"][($updated+$j)]); $j++){
	    		$id = ($updated+$j) * $colCount;
		    	if (!$this->meslekStandartEkle ($evrak_id, $values, $id))
		    		return JText::_("STANDART_EKLE_HATA");
	    	}
	    
	    	return JText::_("VERI_KAYDI_BASARILI");
    	}else
    		return JText::_("BASVURU_OLUSTURMA_HATA");
		
	}
	
	function yeterlilikKaydet ($data, $user_id, $evrak_id){
	    if ($evrak_id == -1){
    		$evrak_id = $this->basvuruOlustur($user_id, 2);
    	}
		
    	if ($evrak_id != -1){
			$colCount  = 7;
			$tableName = "yeterlilik";
			$values    = FormFactory::getTableValues ($data, array ($tableName, $colCount));
			$rowCount = count($values)/$colCount;
			
        	$inpTablo 	= "tablo_".$tableName."_";
	    	$tabloId	= $tableName."_";
	    	
	    	$deleted = 0;
	    	$updated = 0;
	    	for ($i = 1; isset ($data[$tabloId.$i]); $i++){
	    		$inpName 	 	= $inpTablo.$i;
	    		$yeterlilik_id 	= $data[$tabloId.$i];
	    		if (isset ($data[$inpName])){ // GUNCELLE
	    			$id = $updated * $colCount;	
	
	    			if (!$this->yeterlilikGuncelle ($evrak_id, $yeterlilik_id , $values, $id))
	    				return JText::_("YETERLILIK_GUNCELLE_HATA");
	    			
	    			$updated++;
	    		}else {				   // SIL
      				if (!$this->yeterlilikDurumGuncelle ($yeterlilik_id ))
    					return JText::_("YETERLILIK_SUREC_DURUM_GUNCELLE_HATA");
	    		}
	    	}
	    	
	    	// GERISINI EKLE
        	for ($j = 0; isset ($data["input".$tableName."-1"][($updated+$j)]); $j++){
	    		$id = ($updated+$j) * $colCount;
		    	if (!$this->yeterlilikEkle ($evrak_id, $values, $id))
		    		return JText::_("YETERLILIK_EKLE_HATA");
	    	}
					
	    	return JText::_("VERI_KAYDI_BASARILI");
    	}else
    		return JText::_("BASVURU_OLUSTURMA_HATA");
		
	}
	
	function meslekStandartGuncelle ($evrak_id, $standart_id, $values, $i){
		$tip = $this->getStandartBasvuruTipId ($standart_id);
		
		if ($tip == MS_PROTOKOL_BASVURU_TIP){
			return $this->meslekStandartVerisiGuncelle ($standart_id, $values, $i);
		}else{
			$this->meslekStandartDurumGuncelle ($standart_id);
			
			$yeniStandartId = $this->meslekStandartEkle ($evrak_id, $values, $i);
			//Taslak Haline getirilmemis
			if (!$this->taslakMi ($standart_id, MS_SEKTOR_TIPI)){
				return ($yeniStandartId != -1);
			}else{ //Guncellenmek istenen taslak haline getirilmis
				$result = false;
				
				if ($yeniStandartId != -1){
					$result = $this->toggleTaslakIds ($yeniStandartId, $standart_id, MS_SEKTOR_TIPI);
				}
				
				return $result;
			}
		}
	}
	
	function meslekStandartVerisiGuncelle ($standart_id, $values, $i){
		$_db = &JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$seviye_id 				= ($values [2+ $i] == "Seçiniz") ? null : $values [2+ $i];	//PM_SEVIYE
		$sektor_id				= ($values [3+ $i] == "Seçiniz") ? null : $values [3+ $i];
		$standart_adi 			= trim($values [$i]);
		$standart_tanimi		= trim($values [1 + $i]);
		$yasal_duzenleme 		= trim($values [4 + $i]);
		$mevcut_calisma 		= trim($values [5 + $i]);
		$baslangic_tarih	 	= trim($values [6 + $i]);
		$bitis_tarih 			= trim($values [7 + $i]);
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " UPDATE m_meslek_standartlari 
				 SET seviye_id = ?,
				 	 sektor_id = ?,
				 	 standart_adi = ?,
				 	 standart_tanimi = ?,
				 	 yasal_duzenleme = ?,
				 	 mevcut_calisma = ?,
				 	 baslangic_tarihi = to_date(?,'dd/mm/yyyy'),
				 	 bitis_tarihi = to_date(?,'dd/mm/yyyy')
				 WHERE standart_id = ?";
			    
		$params = array($seviye_id,
						$sektor_id,
						$standart_adi,
						$standart_tanimi,
						$yasal_duzenleme,
						$mevcut_calisma,
						$baslangic_tarih,
						$bitis_tarih,
						$standart_id
						);
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function meslekStandartDurumGuncelle ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = " UPDATE m_meslek_standartlari  
				 	SET MESLEK_STANDART_SUREC_DURUM_ID = ? 
				 WHERE standart_id = ?";
			         
		$params = array(PROTOKOL_LISTE_REDDEDILMIS_STANDART, $standart_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function meslekStandartEkle ($evrak_id, $values, $i){
		$standart_id = $this->meslekStandardiVerileriEkle ($values, $i);
		if ($standart_id != -1){
			$result = $this->meslekEvrakEkle($evrak_id, $standart_id);
		}
		
		if ($result)
			return $standart_id;
		else
			return -1;
	}
	
	function meslekEvrakEkle($evrak_id, $standart_id){
		$_db = &JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_meslek_stan_evrak 
				 values( ?, ? )";
			         
		$params = array($evrak_id, $standart_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function meslekStandardiVerileriEkle ($values, $i){
		$_db = &JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$standart_id			= $_db->getNextVal(MESLEK_STD_SEQ);														//PK
		$seviye_id 				= ($values [2+ $i] == "Seçiniz") ? null : $values [2+ $i];	//PM_SEVIYE
		$sektor_id				= ($values [3+ $i] == "Seçiniz") ? null : $values [3+ $i];
		$durum_id 				= ONAYLANMAMIS_STANDART;									//PM_MESLEK_STANDARTLARI_DURUM (Beklemede)
		$standart_adi 			= trim($values [$i]);
		$standart_tanimi		= trim($values [1 + $i]);
		$yasal_duzenleme 		= trim($values [4 + $i]);
		$mevcut_calisma 		= trim($values [5 + $i]);
		$baslangic_tarih	 	= trim($values [6 + $i]);
		$bitis_tarih 			= trim($values [7 + $i]);
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " INSERT INTO m_meslek_standartlari 
				 (STANDART_ID,SEVIYE_ID,SEKTOR_ID, MESLEK_STANDART_SUREC_DURUM_ID, STANDART_ADI, YASAL_DUZENLEME,MEVCUT_CALISMA,BASLANGIC_TARIHI,BITIS_TARIHI,STANDART_TANIMI)  
				 values( ?, ?, ?, ?, ?, ?, ?, to_date(?,'dd/mm/yyyy'), to_date(?,'dd/mm/yyyy'), ?)";
			         
		$params = array($standart_id,
						$seviye_id,
						$sektor_id,
						$durum_id,
						$standart_adi,
						$yasal_duzenleme,
						$mevcut_calisma,
						$baslangic_tarih,
						$bitis_tarih,
						$standart_tanimi
						);
						
		if ($_db->prep_exec_insert($sql, $params))
			return $standart_id;
		else 
			return -1;
	}
	
	function yeterlilikGuncelle ($evrak_id, $yeterlilik_id , $values, $i){
		$tip = $this->getYeterlilikBasvuruTipId ($yeterlilik_id);
		
		if ($tip == YET_PROTOKOL_BASVURU_TIP){
			return $this->yeterlilikVerileriGuncelle ($yeterlilik_id, $values, $i);
		}else{
			$this->yeterlilikDurumGuncelle ($yeterlilik_id);
			
			$yeniYeterlilikId = $this->yeterlilikEkle ($evrak_id, $values, $i);
			//Taslak Haline getirilmemis
			if (!$this->taslakMi ($yeterlilik_id, YET_SEKTOR_TIPI)){
				return ($yeniYeterlilikId != -1);
			}else{ //Guncellenmek istenen taslak haline getirilmis
				$result = false;
				
				if ($yeniYeterlilikId != -1){
					$result = $this->toggleTaslakIds ($yeniYeterlilikId, $yeterlilik_id, YET_SEKTOR_TIPI);
				}
				
				return $result;
			}
		}
		
	}
	
	function yeterlilikVerileriGuncelle ($yeterlilik_id, $values, $i){
		$_db = &JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/													//PK
		$seviye_id 				= ($values [$i+1] == "Seçiniz") ? null : $values [$i+1];	//PM_SEVIYE
		$sektor_id 				= ($values [$i+4] == "Seçiniz") ? null : $values [$i+4];
		$yeterlilik_adi 		= trim($values [$i]);
		$yeterlilik_yasal 		= trim($values [$i+2]);
		$baslangic_tarih	 	= trim($values [$i+5]);
		$bitis_tarih 			= trim($values [$i+6]);
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " UPDATE m_yeterlilik  
				 SET seviye_id = ?,
				 	 sektor_id = ?,
				 	 yeterlilik_adi = ?,
					 yeterlilik_yasal = ?, 
				 	 yeterlilik_baslangic = ?,
				 	 yeterlilik_bitis = ?
				 WHERE yeterlilik_id = ?";
			    
		$params = array($seviye_id,
						$sektor_id,
						$yeterlilik_adi,
						$yeterlilik_yasal,
						$baslangic_tarih,
						$bitis_tarih,
						$yeterlilik_id
						);
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikDurumGuncelle ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = " UPDATE m_yeterlilik   
				 	SET YETERLILIK_SUREC_DURUM_id = ? 
				 WHERE yeterlilik_id = ?";
			         
		$params = array(PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK, $yeterlilik_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikEkle ($evrak_id, $values, $i){
		$result = false;
		
		$yeterlilik_id = $this->yeterlilikVerileriEkle ($values, $i);
		if ($yeterlilik_id != -1){
			$this->yeterlilikEvrakEkle($evrak_id, $yeterlilik_id);
			$standart_id = ($values [($i+3)] == "Seçiniz") ? null : $values [($i+3)];
			$result = $this->yeterlilikStandartEkle ($yeterlilik_id, $standart_id);
		}
		
		return $yeterlilik_id;
	}
	
	function yeterlilikEvrakEkle($evrak_id, $yeterlilik_id){
		$_db = JFactory::getOracleDBO ();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_yeterlilik_evrak 
				 values( ?, ? )";
			         
		$params = array($yeterlilik_id, $evrak_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}

	function yeterlilikStandartEkle ($yeterlilik_id, $standart_id){
		$_db = JFactory::getOracleDBO ();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_standart_yeterlilik 
				 values( ?, ? )";
			         
		$params = array($yeterlilik_id,
						$standart_id
						);
	
		return $_db->prep_exec_insert($sql, $params);
	}

	function yeterlilikVerileriEkle($values, $i){
		$_db = JFactory::getOracleDBO ();
			
		/** Sabit Tablo Degerleri 
		****************************************************/
		$yeterlilik_id			= $_db->getNextVal(YETERLILIK_SEQ);														//PK
		$seviye_id 				= ($values [$i+1] == "Seçiniz") ? null : $values [$i+1];	//PM_SEVIYE
		$sektor_id 				= ($values [$i+4] == "Seçiniz") ? null : $values [$i+4];
		$YETERLILIK_SUREC_DURUM_id	= ONAYLANMAMIS_YETERLILIK;
		$yeterlilik_adi 		= trim($values [$i]);
		$yeterlilik_kodu 		= null;
		$yeterlilik_yasal 		= trim($values [$i+2]);
		$baslangic_tarih	 	= trim($values [$i+5]);
		$bitis_tarih 			= trim($values [$i+6]);
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " INSERT INTO m_yeterlilik 
				 (YETERLILIK_ID, SEVIYE_ID, SEKTOR_ID, YETERLILIK_SUREC_DURUM_ID, YETERLILIK_ADI, YETERLILIK_KODU, YETERLILIK_YASAL, YETERLILIK_BASLANGIC, YETERLILIK_BITIS )
				 values( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($yeterlilik_id,
						$seviye_id,
						$sektor_id,
						$YETERLILIK_SUREC_DURUM_id,
						$yeterlilik_adi,
						$yeterlilik_kodu,
						$yeterlilik_yasal,
						$baslangic_tarih,
						$bitis_tarih
						);
						
		if ( $_db->prep_exec_insert($sql, $params))
			return $yeterlilik_id;
		else
			return -1;
	}
	
	function toggleTaslakIds ($yeniId, $id, $tip){
		$db = JFactory::getOracleDBO ();
		
		if ($tip == MS_SEKTOR_TIPI){
			$sqlFrom = "M_TASLAK_MESLEK "; 
			$sqlWhere = "STANDART_ID "; 
		}else if ($tip == YET_SEKTOR_TIPI){
			$sqlFrom = "M_TASLAK_YETERLILIK "; 
			$sqlWhere = "YETERLILIK_ID "; 
		}
		
		$sql = "UPDATE ".$sqlFrom." 
					SET ".$sqlWhere." = ?  
				WHERE ".$sqlWhere." = ?";
		
		return $db->prep_exec_insert($sql, array ($yeniId, $id));
	}
	
	function taslakMi ($id, $tip){
		$db = JFactory::getOracleDBO ();
		
		if ($tip == MS_SEKTOR_TIPI){
			$sqlFrom = "M_TASLAK_MESLEK "; 
			$sqlWhere = "STANDART_ID "; 
		}else if ($tip == YET_SEKTOR_TIPI){
			$sqlFrom = "M_TASLAK_YETERLILIK "; 
			$sqlWhere = "YETERLILIK_ID "; 
		}
		
		$sql = "SELECT COUNT(*)  
				FROM ".$sqlFrom." 
				WHERE ".$sqlWhere." = ? ";
		
		$data = $db->prep_exec_array($sql, array ($id));
		
		if ($data[0] > 0)
			return true;
		else
			return false;
	}
	
	function updateKurulus ($user_id, $_POST){
		$db = JFactory::getOracleDBO ();
		
		$ad 		= trim($_POST["ad"]);
		$statu_id	= ($_POST['statu'] == "Seçiniz") ? null : $_POST['statu'];
		$yetkili 	= trim($_POST["yetkili"]);
		$unvan 		= trim($_POST["unvan"]);
		$adres 		= trim($_POST["adres"]);
		$posta_kodu = trim($_POST["posta_kodu"]);
		$telefon 	= trim($_POST["telefon"]);
		$faks 		= trim($_POST["faks"]);
		$eposta 	= trim($_POST["eposta"]);
		$web 		= trim($_POST["web"]);
		$sehir		= $_POST["sehir"];
		
		//Prepare sql statement
		$sql = "UPDATE m_kurulus 
				SET	kurulus_statu_id = ?, 
					kurulus_adi = ?, 
					kurulus_yetkilisi = ?, 
					kurulus_yetkili_unvani = ?, 
					kurulus_adresi = ?, 
					kurulus_posta_kodu = ?, 
					kurulus_telefon = ?, 
					kurulus_faks = ?, 
					kurulus_eposta = ?, 
					kurulus_web = ?,
					kurulus_sehir = ?	
				WHERE user_id = ".$user_id ;
			         
		$params = array($statu_id,
						$ad,
						$yetkili,
						$unvan,
						$adres,
						$posta_kodu,
						$telefon,
						$faks,
						$eposta,
						$web,
						$sehir
						);
						
		$results[] = $db->prep_exec_insert($sql, $params);
		
		//logo işlemleri baslangıc
		if(!empty($_FILES["logo"]["name"])){
			$type = $_FILES["logo"]["type"];
			$name = $_FILES["logo"]["name"];
			$tmp = $_FILES["logo"]["tmp_name"];
			$size = $_FILES["logo"]["size"];
			
			$sildir=EK_FOLDER."kurulus_logo/".$user_id."/";
			foreach(glob($sildir . '/*') as $file) {
				if(is_dir($file))
				rrmdir($file);
				else
				unlink($file);
			}
			rmdir($sildir);
			
			if(($type != "image/jpeg" and $type != "image/gif") or $size > 5500000){
				$mainframe->redirect("index.php?option=com_kurulus_edit", "Gönderdiğiniz dosya(lar)nın boyutu 5 mb dan büyük veya formatı jpg yada gif değil.", 'error');
			}
			else{
			
				if (!file_exists(EK_FOLDER."kurulus_logo/".$user_id."/")){
					mkdir(EK_FOLDER."kurulus_logo/".$user_id."/", 0700,true);
				}
			
			
				$normalFile = FormFactory::formatFilename ($name);
				//$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_basvuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
				$pathh =	EK_FOLDER."kurulus_logo/".$user_id."/".$normalFile;
				move_uploaded_file($tmp, $pathh);
			
			}
			
			$belge_adi = FormFactory::formatFilename($name);
			
			$sqlLogo="UPDATE M_KURULUS
										SET LOGO = ?
											WHERE USER_ID = ?";
			$params=array($belge_adi, $user_id);
			$results[] = $db->prep_exec_insert($sqlLogo, $params);
		}
		//logo işlemleri bitiş
		
		if($results[0] == true && ($results[1] == true || count($results) == 1)){
			return true;
		}
		else
			return false;
	}
	
	function insertIller ($user_id, $_POST){
		$iller		= $_POST["iller"];
		
		$this->insertIl ($user_id, $sehir);
		
		for ($i = 0; $i < count($iller); $i++){
			$this->insertIl ($user_id, $iller[$i]);
		}
	
	}
	
	function insertIl ($user_id, $il){
		$db = JFactory::getOracleDBO ();
		$sql = "INSERT INTO m_kurulus_faliyet_il 
				values( ?, ?)";
		
		$params = array ($user_id, $il);
		
		return $db->prep_exec_insert($sql, $params);
	}
	
	function deleteIller ($user_id){
		$db = JFactory::getOracleDBO ();
		
		$sql = "DELETE FROM m_kurulus_faliyet_il 
				WHERE user_id = ?";
		
		$params = array($user_id);
		
		return $db->prep_exec_insert($sql, $params);
	}
	
	function isIdExists ($table_name, $id_name, $id){
		$_db = &JFactory::getOracleDBO();

		$sql= "SELECT count(*) 
			   FROM ".$table_name." 
			   WHERE ".$id_name." = ?";
		
		$params = array ($id);
		
		$data = $_db->prep_exec_array($sql, $params);

		if ($data[0] > 0 )
			return true;
		else
			return false;
	}
	
	function basvuruOlustur ($user_id, $tur){
		$basvuru_durum	= ONAYLANMIS_BASVURU;
		
		if ($tur == 1){ // MESLEK STD
	    	$sayi_id 	 	= MS_PROTOKOL_SAYI_ID;
	    	$basvuru_tip 	= MS_PROTOKOL_BASVURU_TIP;
		}else if ($tur == 2){ // YETERLILIK
	    	$sayi_id 	 	= YET_PROTOKOL_SAYI_ID;
	    	$basvuru_tip 	= YET_PROTOKOL_BASVURU_TIP;
		}

    	
    	$evrak_id = FormFactory::evrakVerisiEkle($user_id, $sayi_id);
		if ($evrak_id != -1)
    		FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
		
		return $evrak_id;
	}
	
	function getOracleEvrakId ($user_id,$tur){
		$_db = &JFactory::getOracleDBO();
		
		if ($tur == 1){ // MESLEK STD
	    	$basvuru_tip 	= MS_PROTOKOL_BASVURU_TIP;
		}else if ($tur == 2){ // YETERLILIK
	    	$basvuru_tip 	= YET_PROTOKOL_BASVURU_TIP;
		}
		
		$sql= "SELECT evrak_id 
			   FROM m_basvuru 
			   WHERE basvuru_tip_id = ".$basvuru_tip." AND 
			   		 user_id = ?";
		
		$params = array ($user_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getStandartBasvuruTipId ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT basvuru_tip_id  
			   FROM m_basvuru 
			   	 JOIN m_meslek_stan_evrak USING (EVRAK_ID)
			   	 JOIN m_meslek_standartlari USING (STANDART_ID) 
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}

	function getYeterlilikBasvuruTipId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT basvuru_tip_id  
			   FROM m_basvuru 
			   	 JOIN m_yeterlilik_evrak USING (EVRAK_ID)
			   	 JOIN m_yeterlilik USING (YETERLILIK_ID) 
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}
}
?>