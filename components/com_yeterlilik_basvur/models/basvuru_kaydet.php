<?php
defined('_JEXEC') or die('Restricted access');
ini_set("display_erros", "1");
class Yeterlilik_BasvurModelBasvuru_Kaydet extends JModel {

	function yeterlilikKaydet ($data, $layout, $evrak_id){
		$session	 = &JFactory::getSession();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
	    if ($evrak_id == -1){
    		$evrak_id = $this->basvuruOlustur();
    	}
    	$session->set ("evrak_id", $evrak_id);
    	
    	if ($evrak_id != -1){
			switch ($layout){
				case "irtibat":
					$sayfa = 2;
					$panelName = "irtibat_panel";
					
					$resultG = $this->basvuruGorevBirimEkle ($user_id, $evrak_id, $data);
					$resultI = FormFactory::irtibatVerileriKaydet($evrak_id, $panelName, $data);
				
					$returnValues = array ($resultG, $resultI);
					if (!FormFactory::isThereError($returnValues))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					break;
				case "faaliyet":
					$sayfa = 3;
					
					$resultB = $this->basvuruVerileriGuncelle($user_id, $evrak_id, $data);	
					
					if (isset($data["path_organizasyonSema_0_1"])){
						$filePath = $data["path_organizasyonSema_0_1"];//.$data["filename_organizasyonSema_0_1"];
						FormFactory::organizasyonSemaKaydet ($evrak_id, $filePath);
					}

					//if (isset($data["path_mevcutAkKapsam_0_1"])){
						$tableName = "mevcutAkKapsam";
						$this->akreditasyonVerisiKaydet ($evrak_id, $data, $tableName);
					//}
					//PANELLER
					$panelName = "kurulus_panel";
					$rowCount	= 10;
					$resultK = FormFactory::birlikteKurulusVerileriKaydet($evrak_id, $panelName, $data, $rowCount);
					//TABLOLAR
					$tableName = "sektor";
					$resultS = FormFactory::sektorVerileriKaydet($evrak_id, $tableName, $data);
					$tableName = "faaliyet";
					$resultF = FormFactory::faaliyetVerileriKaydet($evrak_id, $tableName, $data);
					
					$returnValues = array ($resultB, $resultK, $resultS, $resultF);
					if (!FormFactory::isThereError($returnValues))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
						
					if (FormFactory::isPersonelCountEnough($evrak_id))
						$this->insertSavedPage (5, $evrak_id, $user->id, T2_BASVURU_TIP);
					else
						$this->deleteSavedPage (5, $evrak_id);
					break;
				case "kapsam":
					$sayfa = 4;
					
					$resultP = $this->basvuruPiyasaAciklamaGuncelle($evrak_id, $data);
					$resultY = $this->yeterlilikVerileriKaydet($evrak_id, $data);
					$resultB = $this->belirtilmekIstenenDigerHususGuncelle($evrak_id, $data);
					$tableName = "ekler";
					$resultE = FormFactory::basvuruEkleriKaydet($evrak_id, $tableName, $data);
					
					$returnValues = array ($resultP, $resultY, $resultE);
					if (!FormFactory::isThereError($returnValues))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					break;
				case "ek":
					$sayfa = 5;
					
					$panelName = "personelForm_panel";
					$result[] = FormFactory::kisiBilgiVerileriKaydet($evrak_id, $panelName, $data);
                                        $result[] = $this->KisiBilgiDosyaEkle($evrak_id);
					
					if ($result[0] || $result[1])
						$message = JText::_("VERI_KAYDI_BASARILI");
						
					if (FormFactory::isPersonelCountEnough($evrak_id))
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T2_BASVURU_TIP);
					else
						$this->deleteSavedPage ($sayfa, $evrak_id);
					break;
					
				case "basvuru_dokumani":
					$sayfa = 6;
					$evrak_id 	 = $_POST['evrak_id'];
				
					$this->raporKaydet ($evrak_id);
					$message = JText::_("VERI_KAYDI_BASARILI");
						
					break;
			}
			
			if ($message == JText::_("VERI_KAYDI_BASARILI"))
				$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T2_BASVURU_TIP);
    	}else {
    		return JText::_("BASVURU_KAYDI_BASARISIZ");
    	}
    	
    	return $message;
	}
	
	function basvuruBitir ($evrak_id){
		//FormFactory::evrakKaydet ($evrak_id);
		//FormFactory::listeDurumGuncelle ($user_id, 0, YET_SEKTOR_TIPI);
		FormFactory::basvuruDurumGuncelle ($evrak_id, ONAYLANMAMIS_BASVURU);
		$this->clearSavedPages ($evrak_id);
	}
        
                function KisiBilgiDosyaEkle($evrak_id){
            

		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT KISI_BILGI_DOSYASI FROM m_basvuru WHERE EVRAK_ID = ?";
		$data = $db->prep_exec($sql, array($evrak_id));
		$previouslySavedRaporPath = $data[0]['KISI_BILGI_DOSYASI'];
	
	
		//if(strlen($previouslySavedRaporPath)==0)
		//{
		//RAPOR UPDATE
		if ($_POST['raporSilCheckbox']=='1' && strlen($previouslySavedRaporPath)>0)
		{
			global $mainframe;
			$directory = EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/";
			$sildir=EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/".$previouslySavedRaporPath;
//			foreach(glob($sildir . '/*') as $file) {
				if(is_dir($sildir))
					rrmdir($sildir);
				else
					unlink($sildir);
//			}
			rmdir($sildir);
			
			$sql = "UPDATE m_basvuru SET KISI_BILGI_DOSYASI = '' WHERE EVRAK_ID = ?";
			return $db->prep_exec_insert($sql, array($evrak_id));
		}
		else
		{
				
			if(strlen($previouslySavedRaporPath)>0 && $_POST['degistirFieldSelected']=='1')
			{
				
				global $mainframe;
				$directory = EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/";
				$sildir=EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/".$previouslySavedRaporPath;
//				foreach(glob($sildir . '/*') as $file) {
					if(is_dir($sildir))
						rrmdir($sildir);
					else
						unlink($sildir);
//				}
				rmdir($sildir);
				
				
				if($_FILES[dosya][size][0]>20000000)
				{
					$mainframe->redirect("index.php?option=com_meslek_std_basvur&layout=ek", "Gönderilen dosyanın boyutu 20MB dan büyük olamaz", 'error');
				}
				else
				{
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$normalFile = strtotime("now").'_'.FormFactory::formatFilename ($_FILES[dosya][name][0]);
					$_FILES[dosya][name][0]=	$directory . $normalFile;
					move_uploaded_file($_FILES[dosya][tmp_name][0],$_FILES[dosya][name][0]);
					
					$sql = "UPDATE m_basvuru SET KISI_BILGI_DOSYASI = ? WHERE EVRAK_ID = ?";
					return $db->prep_exec_insert($sql, array($normalFile, $evrak_id));
				
				}
				
				
			}
                        else if(strlen($previouslySavedRaporPath)==0 && strlen($_FILES[dosya][name][0])>0){
                            if($_FILES[dosya][size][0]>20000000)
				{
					$mainframe->redirect("index.php?option=com_meslek_std_basvur&layout=ek", "Gönderilen dosyanın boyutu 20MB dan büyük olamaz", 'error');
				}
				else
				{
                                global $mainframe;
				$directory = EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/";
//                                    print_r($directory);
//                                    die();
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$normalFile = strtotime("now").'_'.FormFactory::formatFilename ($_FILES[dosya][name][0]);
					$_FILES[dosya][name][0]=	$directory . $normalFile;
					move_uploaded_file($_FILES[dosya][tmp_name][0],$_FILES[dosya][name][0]);
					
					$sql = "UPDATE m_basvuru SET KISI_BILGI_DOSYASI = ? WHERE EVRAK_ID = ?";
					return $db->prep_exec_insert($sql, array($normalFile, $evrak_id));
				
				}
                        }
		}
        }
	
	function basvuruGorevBirimEkle ($user_id, $evrak_id, $post){
		$_db = JFactory::getOracleDBO ();
		$ad 	 = $post['birim_ad'];
		$adres 	 = $post['birim_adres'];
		$telefon = $post['birim_telefon'];
		$faks 	 = $post['birim_faks'];
		$web 	 = $post['birim_web'];
		$eposta  = $post['birim_eposta'];
		
		$sql = " UPDATE m_basvuru 
				 	SET gorev_birim_adi = ?,
				 		gorev_birim_adresi = ?,
				 		gorev_birim_telefon = ?,
				 		gorev_birim_faks = ?,
				 		gorev_birim_web = ?,
				 		gorev_birim_eposta = ? 
				 WHERE evrak_id = ?";
		
		$params = array ($ad,
						 $adres,
						 $telefon,
						 $faks,
						 $web,
						 $eposta,
						 $evrak_id);
						 					 	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruVerileriGuncelle($user_id, $evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		$sure = 1;
		if (isset ($data['radio0']))
			$sure = $data['radio0']; //Radio
	
		/** Sabit Tablo Degerleri 
		****************************************************/
		$faaliyet_sure 		= $sure; 					//PM_FAALIYET_SURESI
		//$sema				= null;
		$personel_sayisi	= $data['personel_sayisi'];
		$hazirlama_ekibi	= 1;
		$ekip_sayisi		= trim($data['madde_7a2']);
		$ekip_aciklama 		= trim($data['madde_7a1']);	 
		$altyapi_aciklama	= trim($data['madde_9']);
		$dis_alim_hizmet	= null;
		$dis_alim_tedbir	= null;
		if ($data['radio3']){
			$dis_alim_hizmet= trim($data['madde_10a']);
			$dis_alim_tedbir= trim($data['madde_10b']);
		}
		$danisma_aciklama	= trim($data['madde_11']);
		$pilot_aciklama		= trim($data['madde_12']);
		
		if ($dis_alim_hizmet == null){
			$sqlPart = "dis_alim_hizmet = EMPTY_CLOB(),
						dis_alim_tedbir = EMPTY_CLOB(),";
			$params = array($faaliyet_sure,
							$personel_sayisi,
							$hazirlama_ekibi,
							$ekip_sayisi,
							$ekip_aciklama,
							$altyapi_aciklama,
							$danisma_aciklama,
							$pilot_aciklama,
							$evrak_id);
		}else{
			$sqlPart = "dis_alim_hizmet = ?,
						dis_alim_tedbir = ?,";
			
			$params = array($faaliyet_sure,
							$personel_sayisi,
							$hazirlama_ekibi,
							$ekip_sayisi,
							$ekip_aciklama,
							$altyapi_aciklama,
							$dis_alim_hizmet,
							$dis_alim_tedbir,
							$danisma_aciklama,
							$pilot_aciklama,
							$evrak_id);
		}
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " UPDATE m_basvuru 
				 	SET faliyet_sure_id = ?,
				 		personel_sayisi = ?,
				 		hazirlama_ekibi = ?,
				 		ekip_sayisi = ?,
				 		ekip_aciklama = ?,
				 		altyapi_aciklama = ?,
				 		".$sqlPart."
				 		danisma_aciklama = ?,
				 		pilot_aciklama = ?
				 WHERE evrak_id = ?";
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruPiyasaAciklamaGuncelle($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		$piyasa_aciklama = $data['madde_14'];
		
		$sql = " UPDATE m_basvuru 
				 	SET piyasa_aciklama = ? 
				 WHERE evrak_id = ?";
		
		$params = array ($piyasa_aciklama, $evrak_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	function belirtilmekIstenenDigerHususGuncelle($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		$piyasa_aciklama = $data['belirtilmekIstenenDigerHususTextArea'];
	
		$sql = " UPDATE m_basvuru
		SET belirtilecek_diger_hususlar = ?
		WHERE evrak_id = ?";
	
		$params = array ($piyasa_aciklama, $evrak_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}				
	
	function yeterlilikVerileriKaydet($evrak_id, $data){
		$resultS = $this->yeterlilikVerileriSil($evrak_id);
		$resultE = $this->yeterlilikVerileriEkle($evrak_id,$data);
		
		$returnValues = array ($resultS, $resultE);
		return !FormFactory::isThereError($returnValues);
	}
	

	function yeterlilikVerileriSil($evrak_id){
		$resultSE = $this->yeterlilikEvrakSil ($evrak_id);
		$resultSS = $this->yeterlilikStandartSil ($evrak_id);
		$resultYS = $this->yeterlilikSil ($evrak_id);
		
		$returnValues = array ($resultSE, $resultSS, $resultYS);
		return !FormFactory::isThereError($returnValues);
	}
	
	function yeterlilikEvrakSil ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM m_yeterlilik_evrak 
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikStandartSil ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM m_standart_yeterlilik  
				WHERE yeterlilik_id IN (SELECT yeterlilik_id 
					 				  	FROM m_yeterlilik_evrak 
					 				  	WHERE evrak_id = ?)";
		
		$params = array ($evrak_id);
					
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikSil ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM m_yeterlilik  
				WHERE yeterlilik_id IN (SELECT yeterlilik_id 
					 				  	FROM m_yeterlilik_evrak 
					 				  	WHERE evrak_id = ?)";
		
		$params = array ($evrak_id);
					
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikVerileriEkle($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		
		$colCount 	= 7;
		$tableName 	= "ongorulenYeterlilik";
		$yeterlilikValues = FormFactory::getTableValues ($data, array ($tableName, $colCount));
		$result = true;
		
		for ($i = 0; $result && ($i < count($yeterlilikValues)/$colCount); $i++){
			$id 	= $_db->getNextVal(YETERLILIK_SEQ);
			$result = $this->yeterlilikVerisiEkle($evrak_id, $id, $yeterlilikValues, ($i*$colCount));
		}
		
		return $result;
	}

	function yeterlilikVerisiEkle($evrak_id, $id, $values, $i){
		$result = false;
		
		if ($this->yeterlilikEkle ($id, $values, $i)){
			$result=$this->yeterlilikEvrakEkle($evrak_id, $id);
//			$standart_id = ($values [($i+3)] == "Seçiniz") ? null : $values [($i+3)];
//			$result = $this->yeterlilikStandartEkle ($id, $standart_id);
		}
		
		return $result;
	}

	function yeterlilikEvrakEkle($evrak_id, $id){
		$_db = JFactory::getOracleDBO ();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_yeterlilik_evrak 
				 values( ?, ? )";
			         
		$params = array($id, $evrak_id);
	
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

	function yeterlilikEkle($id, $values, $i){
		$_db = JFactory::getOracleDBO ();
			
		/** Sabit Tablo Degerleri 
		****************************************************/
		$yeterlilik_id			= $id;														//PK
		$seviye_id 				= ($values [$i+1] == "Seçiniz") ? null : $values [$i+1];	//PM_SEVIYE
		$sektor_id 				= ($values [$i+4] == "Seçiniz") ? null : $values [$i+4];
		$YETERLILIK_SUREC_DURUM_id	= ONAYLANMAMIS_YETERLILIK;
		$yeterlilik_adi 		= $values [$i];
		$yeterlilik_kodu 		= null;
		$yeterlilik_yasal 		= $values [$i+2];
		$kaynak_teskil_edenler 		= $values [$i+3];
		$baslangic_tarih	 	= $values [$i+5];
		$bitis_tarih 			= $values [$i+6];
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " INSERT INTO m_yeterlilik (YETERLILIK_ID, SEVIYE_ID, SEKTOR_ID, YETERLILIK_SUREC_DURUM_ID, YETERLILIK_ADI, YETERLILIK_KODU, YETERLILIK_YASAL, KAYNAK_TESKIL_EDENLER, YETERLILIK_BASLANGIC, YETERLILIK_BITIS ) values( ?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
			         
		$params = array($yeterlilik_id,
						$seviye_id,
						$sektor_id,
						$YETERLILIK_SUREC_DURUM_id,
						$yeterlilik_adi,
						$yeterlilik_kodu,
						$yeterlilik_yasal,
						$kaynak_teskil_edenler,
						$baslangic_tarih,
						$bitis_tarih
						);
	
		$sonuc= $_db->prep_exec_insert($sql, $params);
		return $sonuc;
	}
	
	function  akreditasyonVerisiKaydet ($evrak_id, $data, $tableName){
		if (isset($data["path_mevcutAkKapsam_0_1"])){
			$adlar 		 = $_POST ["input".$tableName."-1"];	    		
			$aciklamalar = $_POST ["input".$tableName."-2"];
		}	    		
    	$ekId 	= "akreditasyon_id_";
		$ekPath = "path_mevcutAkKapsam_0_";
		$ekFile = "filename_mevcutAkKapsam_0_";
		
		$updated = 0;
		for ($i = 1; isset ($_POST[$ekId.$i]); $i++){
			$ek_id 	 	 = $_POST[$ekId.$i];
			
			if (isset ($_POST[$ekPath.$i])){ // GUNCELLE
				$aciklama = $aciklamalar[$updated];
				$ad		  = $adlar[$updated];
				$path 	  = $_POST[$ekPath.$i].$_POST[$ekFile.$i];
	
				if (!$this->akreditasyonVerisiGuncelle ($ek_id, $ad, $aciklama,$path))
					return JText::_("VERI_GUNCELLE_HATA");
				
				$updated++;
			}else {				   // SIL
				if (!$this->akreditasyonVerisiSil ($ek_id))
					return JText::_("VERI_SIL_HATA");
			}
		}
		
		// GERISINI EKLE
		for ($j = 0; isset ($_POST["input".$tableName."-1"][($updated+$j)]); $j++){
			$aciklama 	= $aciklamalar [$updated+$j];
			$ad		 	= $adlar [$updated+$j];
			$filePath	= $_POST[$ekPath.($updated+$j+1)].$_POST[$ekFile.$i];
			
			if (!$this->akreditasyonVerisiEkle ($evrak_id, $ad, $aciklama, $filePath))
				return JText::_("VERI_EKLE_HATA");
		}
    	
    	return JText::_("VERI_KAYDI_BASARILI");
	}
	
	function akreditasyonVerisiEkle($evrak_pk, $ad, $aciklama, $filePath){
		$db = JFactory::getOracleDBO ();
		/** Sabit Tablo Degerleri 
		****************************************************/
		$akreditasyon_id		= $db->getNextVal(AKREDITASYON_SEQ);
		$akreditasyon_adi		= $ad;
		$akreditasyon_path		= $filePath;
		$akreditasyon_aciklama	= $aciklama;
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_akreditasyon 
				(EVRAK_ID, AKREDITASYON_ID, AKREDITASYON_ADI, AKREDITASYON_PATH, AKREDITASYON_ACIKLAMA) 
				values( ?, ?, ?, ?, ?)";
			         
		$params = array($evrak_pk,
						$akreditasyon_id,
						$akreditasyon_adi,
						$akreditasyon_path,
						$akreditasyon_aciklama);
	
		return $db->prep_exec_insert($sql, $params);
	}
	
	function akreditasyonVerisiGuncelle($id, $ad, $aciklama, $filePath){
		$db = JFactory::getOracleDBO ();

		//Prepare sql statement
		$sql = "UPDATE m_akreditasyon 
				SET akreditasyon_adi = ?,
					akreditasyon_path = ?,
					akreditasyon_aciklama = ?
				WHERE akreditasyon_id = ?";
			         
		$params = array($ad, $filePath, $aciklama, $id);
	
		return $db->prep_exec_insert($sql, $params);
	}
	
	function akreditasyonVerisiSil ($id){
		$db = JFactory::getOracleDBO ();
		//Prepare sql statement
		$sql = "DELETE FROM m_akreditasyon WHERE akreditasyon_id = ?";
			         
		$params = array($id);
	
		return $db->prep_exec_insert($sql, $params);
	}

	function basvuruOlustur() {
		$_db = &JFactory::getOracleDBO();
		
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= T2_SAYI_ID;
    	$basvuru_tip 	= T2_BASVURU_TIP;
    	$basvuru_durum	= KAYDEDILMEMIS_BASVURU;
    	
    	$evrak_id = $_db->getNextVal(EVRAK_SEQ);//FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		if ($evrak_id != -1){
    		FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
  		}
	
    	return $evrak_id;
    }

	function insertSavedPage ($pageNum, $evrak_id, $juser_id, $basvuru_tur){
		$db = &JFactory::getDBO();
		
		$sql= "	REPLACE INTO #__user_evrak (user_id, evrak_id,basvuru_tur,saved_page) 
				VALUES (".$juser_id.", ".$evrak_id.",".$basvuru_tur.",".$pageNum.")";
		
		return $db->Execute ($sql);
	}
	
	function clearSavedPages ($evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	DELETE FROM #__user_evrak  
				WHERE evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function deleteSavedPage ($page, $evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	DELETE FROM #__user_evrak  
				WHERE saved_page = ".$page." AND evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function raporKaydet($evrak_id,$dosya = null){
		$db  = &JFactory::getOracleDBO();
	
		if($dosya <> null){
			define('dosya', $dosya);
		}

		$sql = "SELECT BASVURU_EK_DOSYASI_PATH FROM m_basvuru WHERE EVRAK_ID = ?";
		$data = $db->prep_exec($sql, array($evrak_id));
		$previouslySavedRaporPath = $data[0]['BASVURU_EK_DOSYASI_PATH'];
	
		//if(strlen($previouslySavedRaporPath)==0)
		//{
		//RAPOR UPDATE
		if ($_POST['raporSilCheckbox']=='1' && strlen($previouslySavedRaporPath)>0){
			global $mainframe;
			$directory = EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/";
			$sildir=EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/".$previouslySavedRaporPath;
			//			foreach(glob($sildir . '/*') as $file) {
			if(is_dir($sildir))
				rrmdir($sildir);
			else
				unlink($sildir);
			//			}
			rmdir($sildir);
				
			$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = '' WHERE EVRAK_ID = ?";
			return $db->prep_exec_insert($sql, array($evrak_id));
		}else{
			if(strlen($previouslySavedRaporPath)>0 && $_POST['degistirFieldSelected']=='1')
			{
				global $mainframe;
				$directory = EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/";
				$sildir=EK_FOLDER."basvuruDosyalari/".$_POST["kurulus_id"]."/".$evrak_id."/".$previouslySavedRaporPath;
				//				foreach(glob($sildir . '/*') as $file) {
				if(is_dir($sildir))
					rrmdir($sildir);
				else
					unlink($sildir);
				//				}
				rmdir($sildir);
	
				if($_FILES[dosya][size][0]>5500000)
				{
					$mainframe->redirect("index.php?option=com_meslek_std_basvur&layout=basvuru_dokumani", "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
				}else{
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$normalFile = FormFactory::formatFilename ($_FILES[dosya][name][0]);
					$_FILES[dosya][name][0]=	$directory . $normalFile;
					move_uploaded_file($_FILES[dosya][tmp_name][0],$_FILES[dosya][name][0]);
						
					$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = ? WHERE EVRAK_ID = ?";
					return $db->prep_exec_insert($sql, array($normalFile, $evrak_id));
				}
			}else if(strlen($previouslySavedRaporPath)==0 && strlen($_FILES[dosya][name][0])>0){
				if($_FILES[dosya][size][0]>5500000){
					$mainframe->redirect("index.php?option=com_meslek_std_basvur&layout=basvuru_dokumani", "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
				}else{
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$normalFile = FormFactory::formatFilename ($_FILES[dosya][name][0]);
					$_FILES[dosya][name][0]=	$directory . $normalFile;
					move_uploaded_file($_FILES[dosya][tmp_name][0],$_FILES[dosya][name][0]);
						
					$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = ? WHERE EVRAK_ID = ?";
					return $db->prep_exec_insert($sql, array($normalFile, $evrak_id));
				}
			}
		}
	}
	

	function yeterlilikKaydetYeni($post,$files){

		$db = & JFactory::getOracleDBO();
		$session	 = &JFactory::getSession();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
	

		if ($post['evrak_id'] == -1){
			$evrak_id = $this->basvuruOlustur();
		}else{
			$evrak_id = $_POST['evrak_id'];
		}
		
		$sql_faaliyet = "DELETE FROM M_BASVURU_SEKTOR WHERE EVRAK_ID=?";
		$db->prep_exec($sql_faaliyet, array($evrak_id));
		
		for($i=0 ; $i<count($post['inputsektor-1']) ; $i++){
			$sql_faaliyet = "INSERT INTO M_BASVURU_SEKTOR (EVRAK_ID,SEKTOR_ID,SEKTOR_ACIKLAMA) VALUES(?,?,?)";
			$db->prep_exec_insert($sql_faaliyet, array($evrak_id,$post['inputsektor-1'][$i],$post['inputsektor-2'][$i]));
		}
	    if(count($post['ek_dokuman_aciklama']) > 0 && count($_FILES['ek_dokuman']['name']) > 0){
			for($i=0 ; $i<count($post['ek_dokuman_aciklama']) ; $i++){
				$id 	= $db->getNextVal(BASVURU_EK_ID_seq);
				$sql_ek = "INSERT INTO M_BASVURU_EKLER( EVRAK_ID,
														BASVURU_EK_ID,
														BASVURU_EK_ACIKLAMA,
														BASVURU_EK_TIP,
														BASVURU_EK_TARIH) VALUES(?,?,?,?,?)";
				$db->prep_exec_insert($sql_ek, array($evrak_id,
													 $id,
													 $post['ek_dokuman_aciklama'][$i],
													 "1",
													 $post['ek_dokuman_tarih'][$i]));
				$_FILES['ek_dokuman']['id'][$i] = $id;
			} 
	    }
		$sql_basvuru ="UPDATE M_BASVURU SET EVRAK_ID=?,
										    BASVURU_TARIHI=TO_TIMESTAMP('".$post['basvuru_tarihi']."','DD/MM/RRRR'),
											BELIRTILECEK_DIGER_HUSUSLAR=?,
											BASVURU_EK_DOSYASI_TARIH = TO_TIMESTAMP('".$post['basvuru_dokuman_tarihi']."','DD/MM/RRRR'),
											BASVURU_TIP_ID=?,
											BASVURU_TURU=?
									  WHERE EVRAK_ID=?";
		$db->prep_exec_insert($sql_basvuru, array($evrak_id,
												  $post['basvuru_aciklama'],
												  '2',
												  '0',
												  $evrak_id));
		
		$error_basvuru_dokuman  = $this->raporKaydetYeni($evrak_id,"basvuru_dokumani");
		$error_ek_dokuman       = $this->raporKaydetYeni($evrak_id,"ek_dokuman");
	
		$return  = array( 	'evrak_id' => $evrak_id,
							'file_upload_errors' => array_merge(basvuru_dokuman,$error_ek_dokuman));
		return $return;
	}
	
	
	function readDocument($path){
		
		$conf =& JFactory::getConfig();	
		$tmp_path = $conf->getValue('config.tmp_path');
		
		$acceptableFiles = array( 'application/msword' => "doc",//doc
								  'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => "docx",//docx,
								  'application/pdf' => "pdf" //pdf
							    );
								  		
		$finfo 		    = finfo_open(FILEINFO_MIME_TYPE);
	    $file_extension = finfo_file($finfo, $path);
		finfo_close($finfo);

		if(array_key_exists($file_extension, $acceptableFiles)){
	
			if($acceptableFiles[$file_extension] == "doc" || $acceptableFiles[$file_extension] == "docx"){
					
				require_once 'libraries/PHPWord-master/src/PhpWord/Autoloader.php';
				\PhpOffice\PhpWord\Autoloader::register();
			
				$phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
				$result = $this->write($phpWord, "temp", array('HTML' => 'html'),$tmp_path);
			
				$contents = file_get_contents($tmp_path.'/temp.html', true);
					
			}else if($acceptableFiles[$file_extension] == "pdf"){
				include 'libraries/pdfparser/vendor/autoload.php';
			
				$parser = new \Smalot\PdfParser\Parser();
				$pdf    = $parser->parseFile($path);
			
				$contents = $pdf->getText();
					
			}
		}
		return $contents;
	}
	
	function write($phpWord, $filename, $writers,$target_path)
	{ 
		$result = '';
		foreach ($writers as $writer => $extension) {
			$result .= date('H:i:s') . " Write to {$writer} format";
			if (!is_null($extension)) {
				$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, $writer);
				$xmlWriter->save($tmp_path . "/{$filename}.{$extension}");
				$result = true;
			} else {
				$result = false;
			}
		}
		return $result;
	}
	
	function raporKaydetYeni($evrak_id,$dosya = null){ ini_set("display_errors", "1");
		$db  = &JFactory::getOracleDBO();
		
		$user 	 	= &JFactory::getUser();
		$user_id	= $user->getOracleUserId ();
		
		$error = array();

		switch ($dosya) {
			
			case "dosya":
			case "basvuru_dokumani":
			
				$sql = "SELECT BASVURU_EK_DOSYASI_PATH, USER_ID FROM m_basvuru WHERE EVRAK_ID = ?";
				$data = $db->prep_exec($sql, array($evrak_id));
				$previouslySavedRaporPath = $data[0]['BASVURU_EK_DOSYASI_PATH'];
				$directory = EK_FOLDER."basvuruDosyalari/".$data[0]['USER_ID']."/".$evrak_id."/";
				//if(strlen($previouslySavedRaporPath)==0)
				//{
				//RAPOR UPDATE
				if ($_POST['raporSilCheckbox']=='1' && strlen($previouslySavedRaporPath)>0){
					global $mainframe;
					
					$sildir=EK_FOLDER."basvuruDosyalari/".$data[0]['USER_ID']."/".$evrak_id."/".$previouslySavedRaporPath;
					//			foreach(glob($sildir . '/*') as $file) {
					if(is_dir($sildir))
						rrmdir($sildir);
					else
						unlink($sildir);
					//			}
					rmdir($sildir);
				
					$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = '' WHERE EVRAK_ID = ?";
					return $db->prep_exec_insert($sql, array($evrak_id));
				}else{
					if(strlen($previouslySavedRaporPath)>0 && $_POST['degistirFieldSelected']=='1')
					{
						global $mainframe;
						$directory = EK_FOLDER."basvuruDosyalari/".$data[0]['USER_ID']."/".$evrak_id."/";
						$sildir=EK_FOLDER."basvuruDosyalari/".$data[0]['USER_ID']."/".$evrak_id."/".$previouslySavedRaporPath;
						//				foreach(glob($sildir . '/*') as $file) {
						if(is_dir($sildir))
							rrmdir($sildir);
						else
							unlink($sildir);
						//				}
						rmdir($sildir);
				
						if($_FILES[$dosya][size][0]>5500000)
						{
							array_push($error, array("file_type"     => $dosya,
													 "file_name"     => $_FILES[$dosya][name][0],
													 "error_summary" => "Dosya boyutu izin verilenin dışında"));
						}else{
							if (!file_exists($directory)){
								mkdir($directory, 0700,true);
							}
							$normalFile = FormFactory::formatFilename ($_FILES[$dosya][name][0]);
							$_FILES[$dosya][name][0]=	$directory . $normalFile;

							if(!move_uploaded_file($_FILES[$dosya][tmp_name][0],$_FILES[$dosya][name][0])){
								return false;
							}
							$content = $this->readDocument($_FILES[$dosya][name][0]);
							$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = ?,BASVURU_EK_DOSYASI_CONTENT = ? WHERE EVRAK_ID = ?";
							return $db->prep_exec_insert($sql, array($normalFile, $content, $evrak_id));
						}
					}else if(strlen($previouslySavedRaporPath)==0 && strlen($_FILES[$dosya][name][0])>0){
						if($_FILES[$dosya][size][0]>5500000){
							array_push($error, array("file_type"     => $dosya,
													"file_name"     => $_FILES[$dosya][name],
													"error_summary" => "Dosya boyutu izin verilenin dışında"));
						}else{
							if (!file_exists($directory)){
								mkdir($directory, 0700,true);
							}
							$normalFile = FormFactory::formatFilename ($_FILES[$dosya][name][0]);
							$_FILES[$dosya][name][0]=	$directory . $normalFile;
							
							$content = $this->readDocument($_FILES[$dosya][tmp_name][0]);
							
							move_uploaded_file($_FILES[$dosya][tmp_name][0],$_FILES[$dosya][name][0]);
							
							$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = ?,BASVURU_EK_DOSYASI_CONTENT = ? WHERE EVRAK_ID = ?";
							$db->prep_exec_insert($sql, array($normalFile, $content, $evrak_id));
						}
					}
				}
			break;
			
			case "ek_dokuman":
				
				$directory = EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/ek_dosya/";
				
				if (count($_POST['ek_dosya_sil']) > 0){
					foreach ($_POST['ek_dosya_sil'] as $data){
						
						unlink($sildir);
						
						rmdir($sildir);
						$db->prep_exec("DELETE FROM M_BASVURU_EKLER WHERE BASBURU_EK_ID = ?", $data);
					}
				}else{  
					
					for($i = 0 ; $i< count($_FILES[$dosya]['name']); $i++){
						
						if($_FILES[$dosya][size][$i]>5500000){
							array_push($error, array("file_type"     => $dosya,
													 "file_name"     => $_FILES[$dosya][name][$i],
													 "error_summary" => "Dosya boyutu izin verilenin dışında"));
						}else{
							
							if (!file_exists($directory)){
								mkdir($directory, 0700,true);
							}
							$normalFile = FormFactory::formatFilename ($_FILES[$dosya][name][$i]);
							$_FILES[$dosya][name][$i]=	$directory . $normalFile;

							$content = $this->readDocument($_FILES[$dosya][tmp_name][$i]);
							
							move_uploaded_file($_FILES[$dosya][tmp_name][$i],$_FILES[$dosya][name][$i]);
								
							$db->prep_exec_insert("UPDATE M_BASVURU_EKLER SET BASVURU_EK_ADI = ?,
																		  BASVURU_EK_PATH = ?,
																		  BASVURU_EK_CONTENT =? 
																    WHERE EVRAK_ID=? AND
																		  BASVURU_EK_ID=?",
									array($normalFile,$normalFile,$content,$evrak_id,$_FILES[$dosya]['id'][$i]));
						}
					}
					
				}
				
				break;	
			default:
				;
			break;
		}
		return $error;
	}
	function basvuruBitirYeni ($evrak_id){
		if($evrak_id <> ""){
			FormFactory::basvuruDurumGuncelle ($evrak_id, ONAYLANMAMIS_BASVURU);
			$data['status'] = "1"; 
			$data['result'] = "Başvuru başarıyla güncellendi"; 
		}else{
			$data['status'] = "0";
			$data['result'] = "Başvuru başarıyla güncelleme sırasında hata oluştu.";
		}
		return $data;
	}
	function BasvuruEkSil($ekId) {
		$db  = &JFactory::getOracleDBO();
		$user		 	= &JFactory::getUser();
		$user_id	 	= $user->getOracleUserId ();
		if($ekId<>""){
			$data = $db->prep_exec("SELECT * FROM M_BASVURU_EKLER WHERE BASVURU_EK_ID=?", array($ekId));
			$db->prep_exec("DELETE FROM M_BASVURU_EKLER WHERE BASVURU_EK_ID=?", array($ekId));
			
			$sildir=EK_FOLDER."basvuruDosyalari/".$user_id."/".$data[0]['EVRAK_ID']."/ek_dosya/".$data[0]['BASVURU_EK_PATH'];
			if(is_dir($sildir))
				rrmdir($sildir);
			else
				unlink($sildir);
			rmdir($sildir);
			
			$data['status'] = "1";
			$data['result'] = "Başvuru ek dosyası silme işlemi başarıyla gerçekleşti";
		}else{
			$data['status'] = "0";
			$data['result'] = "Başvuru ek dosyası silme işlemi esnasında hata oluştu";
		}
		return $data;
	}
}
?>
