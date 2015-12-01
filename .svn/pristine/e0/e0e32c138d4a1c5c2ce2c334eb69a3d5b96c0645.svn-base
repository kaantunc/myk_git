<?php
defined('_JEXEC') or die('Restricted access');

class Meslek_Std_BasvurModelBasvuru_Kaydet extends JModel {

	function standartKaydet ($data, $layout, &$evrak_id){
		$message = "";
		$session = &JFactory::getSession();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
	    if ($evrak_id == -1){
    		$evrak_id = $this->basvuruOlustur();
    	} 
    	if (count($this->basvuruVarMi($evrak_id)) == 0){
    		$basvuru_tip 	= T1_BASVURU_TIP;
    		$basvuru_durum	= KAYDEDILMEMIS_BASVURU;    		
   			FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
		}
    	$session->set ("evrak_id", $evrak_id);
    	
    	if ($evrak_id != -1){
			switch ($layout){
				case "irtibat":
					$sayfa = 2;
					$panelName = "irtibat_panel";
					$result = FormFactory::irtibatVerileriKaydet($evrak_id, $panelName, $data);
					
					if ($result)
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
						
					break;
				case "faaliyet":
					$sayfa = 3;
					
					$resultB = $this->basvuruVerileriGuncelle($user_id, $evrak_id, $data);
					if (isset($data["path_organizasyonSemasiorganizasyonSema_0_1"])){
						$filePath = $data["path_organizasyonSemasiorganizasyonSema_0_1"];
						FormFactory::organizasyonSemaKaydet ($evrak_id, $filePath);
					}
								
					//PANELLER
					$panelName = "kurulus_panel";
					$rowCount	= 10;
					$resultK = FormFactory::birlikteKurulusVerileriKaydet($evrak_id, $panelName, $data, $rowCount);
					
					//TABLOLAR
					$tableName = "sektor";
					$resultS = FormFactory::sektorVerileriKaydet($evrak_id, $tableName, $data);
					
					$tableName = "faaliyet";
					$resultF = FormFactory::faaliyetVerileriKaydet($evrak_id, $tableName, $data);
					
					$tableName = "kurulus";
					$resultBK = FormFactory::bagliKurulusVerileriKaydet($evrak_id, $tableName, $data);
					
					$returnValues = array ($resultB, $resultK, $resultS, $resultF, $resultBK);
					if (!FormFactory::isThereError($returnValues))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
						
// 					if (FormFactory::isPersonelCountEnough($evrak_id))
// 						$this->insertSavedPage (5, $evrak_id, $user->id, T1_BASVURU_TIP);
// 					else
// 						$this->deleteSavedPage (5, $evrak_id);
						
// 					break;
				case "kapsam":
					$sayfa = 4;
					
					$resultP = $this->basvuruPiyasaAciklamaGuncelle($user_id, $evrak_id, $data);
					$resultD = $this->basvuruDigerHususlarGuncelle($user_id, $evrak_id, $data);
					
					$tableName = "meslek_standart";
					$resultM = $this->meslekVerileriKaydet($evrak_id, $tableName, $data);
					
					$tableName = "ekler";
					$resultE = FormFactory::basvuruEkleriKaydet($evrak_id, $tableName, $data);

					$returnValues = array ($resultP, $resultM, $resultE, $resultD);
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
					
					if ($result[0] || $result[1]){
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					
					if(!FormFactory::isPersonelCountEnough($evrak_id) && $result[0]){
						$this->deleteSavedPage ($sayfa, $evrak_id );
					}
						
// 					if (FormFactory::isPersonelCountEnough($evrak_id))
// 						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T1_BASVURU_TIP);
// 					else
// 						$this->deleteSavedPage ($sayfa, $evrak_id );
					break;
				case "basvuru_dokumani":
					$sayfa = 6;
					$evrak_id 	 = $_POST['evrak_id'];
					 
					$this->raporKaydet ($evrak_id);
					$message = JText::_("VERI_KAYDI_BASARILI");
					
					break;
			}
			
			if ($message == JText::_("VERI_KAYDI_BASARILI"))
				$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T1_BASVURU_TIP);
    	}else{
    		return JText::_("BASVURU_KAYDI_BASARISIZ");
    	}
		
    	return $message;
	}
	
	function basvuruBitir ($evrak_id, $user_id){
		//FormFactory::evrakKaydet ($evrak_id);
		//FormFactory::listeDurumGuncelle ($user_id, 0, MS_SEKTOR_TIPI);
		FormFactory::basvuruDurumGuncelle ($evrak_id, ONAYLANMAMIS_BASVURU);
		$this->clearSavedPages ($evrak_id);
	}
		
	function basvuruPiyasaAciklamaGuncelle($user_id, $evrak_id, $data){
		$_db = &JFactory::getOracleDBO();
		$piyasa_aciklama = $data['madde_12'];
		
		$sql = " UPDATE m_basvuru 
				 	SET piyasa_aciklama = ? 
				 WHERE evrak_id = ?";
		
		$params = array ($piyasa_aciklama, $evrak_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruDigerHususlarGuncelle($user_id, $evrak_id, $data){
		$_db = &JFactory::getOracleDBO();
		$diger_hususlar = $data['madde_13'];
		
		$sql = " UPDATE m_basvuru 
				 	SET diger_hususlar = ? 
				 WHERE evrak_id = ?";
		
		$params = array ($diger_hususlar, $evrak_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruVerileriGuncelle($user_id, $evrak_id, $data){
		$_db = &JFactory::getOracleDBO();
		
		$sure = 1;
		if (isset ($data['radio0']))
			$sure = $data['radio0']; //Radio
	
		/** Sabit Tablo Degerleri 
		****************************************************/
		$faaliyet_sure 		= $sure; 						//PM_FAALIYET_SURESI
		$basvuru_tip		= T1_BASVURU_TIP; 		   	   	//PM_BASVURU_TIP (Meslek Standardi Basvurusu)
		//$basvuru_durum		= ONAYLANMAMIS_BASVURU;			//PM_BASVURU_DURUM
		$uye_sayisi			= $data['kisi_sayisi'];
		$personel_sayisi	= $data['personel_sayisi'];
		$hazirlama_ekibi	= $data['radio1'];
		$ekip_sayisi 		= null;
		if ($hazirlama_ekibi) {
			$ekip_sayisi	= $data['madde_6a2'];
			$ekip_aciklama 	= trim($data['madde_6a1']);	
		}else{
			$ekip_aciklama	= trim($data['madde_6b']);
		}
		$altyapi_aciklama	= trim($data['madde_8']);
		$dis_alim_hizmet	= null;
		$dis_alim_tedbir	= null;
		if ($data['radio3']){
			$dis_alim_hizmet	= trim($data['madde_9a']);
			$dis_alim_tedbir	= trim($data['madde_9b']);
		}
		$danisma_aciklama	= trim($data['madde_10']);
		
		if ($dis_alim_hizmet == null){
			$params = array($faaliyet_sure,
					$basvuru_tip,
					$uye_sayisi,
					$personel_sayisi,
					$hazirlama_ekibi,
					$ekip_sayisi,
					$ekip_aciklama,
					$altyapi_aciklama,
					$danisma_aciklama,
					$evrak_id);
			$sql = " UPDATE m_basvuru
					SET 	faliyet_sure_id = ?,
					basvuru_tip_id = ?,
					uye_sayisi = ?,
					personel_sayisi = ?,
					hazirlama_ekibi = ?,
					ekip_sayisi = ?,
					ekip_aciklama = ?,
					altyapi_aciklama = ?,
					dis_alim_hizmet = EMPTY_CLOB(),
					dis_alim_tedbir = EMPTY_CLOB(),
					danisma_aciklama = ?
					WHERE evrak_id = ?";
	
		}else{
			$params = array($faaliyet_sure,
					$basvuru_tip,
					$uye_sayisi,
					$personel_sayisi,
					$hazirlama_ekibi,
					$ekip_sayisi,
					$ekip_aciklama,
					$altyapi_aciklama,
					$dis_alim_hizmet,
					$dis_alim_tedbir,
					$danisma_aciklama,
					$evrak_id);
			$sql = " UPDATE m_basvuru
				SET 	faliyet_sure_id = ?,
				basvuru_tip_id = ?,
				uye_sayisi = ?,
				personel_sayisi = ?,
				hazirlama_ekibi = ?,
				ekip_sayisi = ?,
				ekip_aciklama = ?,
				altyapi_aciklama = ?,
				dis_alim_hizmet = ?,
				dis_alim_tedbir = ?,
				danisma_aciklama = ?
				WHERE evrak_id = ?";
				
		}
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
	
		return $_db->prep_exec_insert($sql, $params);
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
	
	function meslekVerileriKaydet($evrak_id, $tableName, $data){
		$resultS = $this->meslekVerileriSil($evrak_id);
		$resultE = $this->meslekVerileriEkle($evrak_id, $tableName, $data);
		
		$returnValues = array ($resultS, $resultE);
		return !FormFactory::isThereError($returnValues);
	}
	
	function meslekVerileriSil($evrak_id){
		$resultSE = $this->meslekEvrakSil ($evrak_id);
		$resultS  = $this->meslekStandardiSil ($evrak_id);
		
		$returnValues = array ($resultSE, $resultS);
		return !FormFactory::isThereError($returnValues);
	}
	
	function meslekEvrakSil ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM m_meslek_stan_evrak 
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function meslekStandardiSil ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM m_meslek_standartlari  
				WHERE standart_id IN (SELECT standart_id
					 				  FROM m_meslek_stan_evrak 
					 				  WHERE evrak_id = ?)";
		
		$params = array ($evrak_id);
					
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function meslekVerileriEkle($evrak_id, $tableName, $data){
		$_db = &JFactory::getOracleDBO();
		
		$colCount = 8;
		$meslekValues = FormFactory::getTableValues ($data, array ($tableName, $colCount));
		$rowCount = count($meslekValues)/$colCount;
		$result = true;
		
		for ($i = 0; $result && ($i < $rowCount); $i++){
			$id 	= $_db->getNextVal(MESLEK_STD_SEQ);
			$result = $this->meslekVerisiEkle($evrak_id, $id, $meslekValues, $colCount*$i);
		}
		
		return $result;
	}
	
	function meslekVerisiEkle($evrak_id, $id, $values, $i){
		$result = false;
		
		if ($this->meslekStandardiEkle ($id, $values,$i)){
			$result = $this->meslekEvrakEkle($evrak_id, $id);
		}
		
		return $result;
	}
	
	function meslekEvrakEkle($evrak_id, $id){
		$_db = &JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = " INSERT INTO m_meslek_stan_evrak 
				 values( ?, ? )";
			         
		$params = array($evrak_id, $id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function meslekStandardiEkle ($id, $values, $i){
		$_db = &JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$standart_id			= $id;														//PK
		$seviye_id 				= ($values [2+ $i] == "Seçiniz") ? null : $values [2+ $i];	//PM_SEVIYE
		$sektor_id				= ($values [3+ $i] == "Seçiniz") ? null : $values [3+ $i];
		$surec_durum_id			= ONAYLANMAMIS_STANDART;									//PM_MESLEK_STANDARTLARI_SUREC_DURUM (Beklemede)
		$durum_id				= PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK;						//PM_MESLEK_STANDARTLARI_DURUM (Basvuru)
		$standart_adi 			= $values [$i];
		$standart_tanimi		= $values [1 + $i];
		$yasal_duzenleme 		= $values [4 + $i];
		$mevcut_calisma 		= $values [5 + $i];
		$baslangic_tarih	 	= $values [6 + $i];
		$bitis_tarih 			= $values [7 + $i];
		$uluslar_arasi_standart = null;
		$standart_kodu			= null;
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " INSERT INTO m_meslek_standartlari 
				 (STANDART_ID,SEVIYE_ID,SEKTOR_ID, MESLEK_STANDART_SUREC_DURUM_ID, STANDART_ADI, YASAL_DUZENLEME,MEVCUT_CALISMA,BASLANGIC_TARIHI,BITIS_TARIHI,ULUSLAR_ARASI_STANDART,STANDART_KODU,STANDART_TANIMI, MESLEK_STANDART_DURUM_ID)  
				 values( ?, ?, ?, ?, ?, ?, ?, to_date(?,'dd/mm/yyyy'), to_date(?,'dd/mm/yyyy'), ?, ?, ?, ?)";
			         
		$params = array($standart_id,
						$seviye_id,
						$sektor_id,
						$surec_durum_id,
						$standart_adi,
						$yasal_duzenleme,
						$mevcut_calisma,
						$baslangic_tarih,
						$bitis_tarih,
						$uluslar_arasi_standart,
						$standart_kodu,
						$standart_tanimi,
                        $durum_id
						);
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	
	function basvuruOlustur (){
		$_db = &JFactory::getOracleDBO();
		
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= T1_SAYI_ID;
    	$basvuru_tip 	= T1_BASVURU_TIP;
    	//$basvuru_durum	= ONAYLANMAMIS_BASVURU;
    	$basvuru_durum	= KAYDEDILMEMIS_BASVURU;
    	
    	$evrak_id = $_db->getNextVal(EVRAK_SEQ);//FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		if ($evrak_id != -1){
    		FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
		}
		
		return $evrak_id;
	}
	
	function basvuruVarMi($evrak_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select * from m_basvuru where evrak_id=".$evrak_id;
		$sonuc=$_db->prep_exec($sql, array());
		return $sonuc;
		
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
				WHERE saved_page = ".$page." AND 
					  evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function raporKaydet($evrak_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT BASVURU_EK_DOSYASI_PATH FROM m_basvuru WHERE EVRAK_ID = ?";
		$data = $db->prep_exec($sql, array($evrak_id));
		$previouslySavedRaporPath = $data[0]['BASVURU_EK_DOSYASI_PATH'];
	
	
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
			
			$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = '' WHERE EVRAK_ID = ?";
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
				
				
				if($_FILES[dosya][size][0]>5500000)
				{
					$mainframe->redirect("index.php?option=com_meslek_std_basvur&layout=basvuru_dokumani", "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
				}
				else
				{
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
                        else if(strlen($previouslySavedRaporPath)==0 && strlen($_FILES[dosya][name][0])>0){
                            if($_FILES[dosya][size][0]>5500000)
				{
					$mainframe->redirect("index.php?option=com_meslek_std_basvur&layout=basvuru_dokumani", "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
				}
				else
				{
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
	
	
	function standartKaydetYeni($post,$files){

		$db 		= & JFactory::getOracleDBO();
		$session	= &JFactory::getSession();
		$user 	 	= &JFactory::getUser ();
		$user_id 	= $user->getOracleUserId ();
	
		if ($post['evrak_id'] == -1){
			$evrak_id = $this->basvuruOlustur();
			$post['basvuru_durumu'] = '-1';
		}else{
			$evrak_id = $_POST['evrak_id'];
		}
	
		$sql_faaliyet = "DELETE FROM M_BASVURU_SEKTOR WHERE EVRAK_ID=?";
		$db->prep_exec($sql_faaliyet, array($evrak_id));
	
		for($i=0 ; $i<count($post['inputsektor-1']) ; $i++){
			if($post['inputsektor-1'][$i] <> "Seçiniz" && isset($post['inputsektor-1'][$i])){
				$sql_faaliyet = "INSERT INTO M_BASVURU_SEKTOR (EVRAK_ID,SEKTOR_ID,SEKTOR_ACIKLAMA) VALUES(?,?,?)";
				$db->prep_exec_insert($sql_faaliyet, array($evrak_id,$post['inputsektor-1'][$i],$post['inputsektor-2'][$i]));
			}
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
				'1',
				'0',
				$evrak_id));
	
		FormFactory::BelgelendirmebasvuruDurumGuncelle ($evrak_id, $post['basvuru_durumu']);
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
					
				$sql = "SELECT BASVURU_EK_DOSYASI_PATH,USER_ID FROM m_basvuru WHERE EVRAK_ID = ?";
				$data = $db->prep_exec($sql, array($evrak_id));
				$previouslySavedRaporPath = $data[0]['BASVURU_EK_DOSYASI_PATH'];
				$user_id = $data[0]['USER_ID'];
				$directory = EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/";
				//if(strlen($previouslySavedRaporPath)==0)
				//{
				//RAPOR UPDATE
				if ($_POST['raporSilCheckbox']=='1' && strlen($previouslySavedRaporPath)>0){
					global $mainframe;
						
					$sildir=EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/".$previouslySavedRaporPath;
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
						$directory = EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/";
						$sildir=EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/".$previouslySavedRaporPath;
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
							$_FILES[$dosya][name]=	$directory . $normalFile;
								
							// $content = $this->readDocument($_FILES[$dosya][tmp_name][0]);
							
							move_uploaded_file($_FILES[$dosya][tmp_name][0],$_FILES[$dosya][name]);
		
							$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = ?,BASVURU_EK_DOSYASI_CONTENT = ? WHERE EVRAK_ID = ?";
							return $db->prep_exec_insert($sql, array($normalFile, $content, $evrak_id));
						}
					}else if(strlen($previouslySavedRaporPath)==0 && strlen($_FILES[$dosya][name])>0){
						if($_FILES[$dosya][size][0]>5500000){
							array_push($error, array("file_type"     => $dosya,
							"file_name"     => $_FILES[$dosya][name],
							"error_summary" => "Dosya boyutu izin verilenin dışında"));
						}else{
							if (!file_exists($directory)){
								mkdir($directory, 0700,true);
							}
							$normalFile = FormFactory::formatFilename ($_FILES[$dosya][name]);
							$_FILES[$dosya][name]=	$directory . $normalFile;
								
							// $content = $this->readDocument($_FILES[$dosya][tmp_name]);
							move_uploaded_file($_FILES[$dosya][tmp_name],$_FILES[$dosya][name]);
								
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
		
							// $content = $this->readDocument($_FILES[$dosya][tmp_name][$i]);
								
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