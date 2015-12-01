<?php
defined('_JEXEC') or die('Restricted access');

class Belgelendirme_BasvurModelBasvuru_Kaydet extends JModel {
	
	function belgelendirmeKaydet ($data, $layout, $evrak_id){
		$session = &JFactory::getSession ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$evrak_id = $data['evrak_id'];
	    if ($evrak_id == -1){
    		$evrak_id = $this->basvuruOlustur();
    	}
    	$session->set("evrak_id", $evrak_id);
    	
    	if ($evrak_id != -1 && $evrak_id != null){
			switch ($layout){
				case "irtibat":
					$sayfa = 2;
					$panelName = "irtibat_panel";
					
					$resultG = $this->basvuruGorevBirimEkle ($evrak_id, $data);
					$resultI = FormFactory2::irtibatVerileriKaydet($evrak_id, $panelName, $data);
					
					$returnValues = array ($resultG, $resultI);
					if (!FormFactory2::isThereError($returnValues)){
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					}
			
					break;
				case "faaliyet":
					$sayfa = 3;
					
					$resultF = $this->basvuruFaaliyetGuncelle($evrak_id, $data);			
					//TABLOLAR
					$tableName = "sektor";
					$resultS = FormFactory2::sektorVerileriKaydet($evrak_id, $tableName, $data);
					$tableName = "faaliyet";
					//$resultA = FormFactory2::faaliyetVerileriKaydet($evrak_id, $tableName, $data);
					$resultA = FormFactory2::patchForBelgelendirmeFaaliyetVerileriKaydet($evrak_id, $tableName, $data);
					$tableName = "yetkiTalep";
					$resultY = $this->yeterlilikTalebiKaydet($evrak_id, $data);
					
					$returnValues = array ($resultF, $resultS, $resultA, $resultY);
				if (!FormFactory2::isThereError($returnValues)){
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					}
					break;
				case "akreditasyon":
					$sayfa = 4;
					
					$panelName = "kAkreditasyonBilgi_panel";
					$rowCount	= 7;
					$result = $this->akreditasyonVerileriKaydet ($evrak_id, $panelName, $data, $rowCount);
					
					if ($result){
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					}
					break;
				case "sinav":
					$sayfa = 5;
					$resultK = $this->basvuruKapsamGuncelle($evrak_id, $data);
					//$resultS = $this->sinavMerkezKaydet 	($evrak_id, $data);			
					//PANELLER
					$panelName  = "disaridanHizmet_panel";
					$rowCount	= 11;
					$resultB =  FormFactory2::birlikteKurulusVerileriKaydet($evrak_id, $panelName, $data, $rowCount);
					
// 					$returnValues = array ($resultK, $resultS, $resultB);
					$returnValues = array ($resultK, $resultB);
					
					if (!FormFactory2::isThereError($returnValues)){
						$this->insertSavedPage ($sayfa, $evrak_id, $user_id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					}
					break;
				case "ek2":
					$sayfa = 6;
					
					$result = $this->BasvuruEkleriKaydet($_FILES, $data,$sayfa, $user->id, $evrak_id);
					if ($result){
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("Gönderdiğiniz dosya(lar)nın boyutu 30 mb dan büyük veya dosya formatları geçersizdir.");
					}
					break;
					
				case "ek":
					$sayfa = 7;
					
					$panelName = "personelForm_panel";
					$result = FormFactory2::kisiBilgiVerileriKaydet($evrak_id, $panelName, $data);
					if ($result){
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					}

					break;
					
				case "form":
						$sayfa = 8;
						
						if ($this->BasvuruDocsKaydet($_FILES, $data, $sayfa,$user_id,$evrak_id)){
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$this->deleteSavedPage ($sayfa, $evrak_id);
						$message = JText::_("Gönderdiğiniz dosya(lar)nın boyutu 30 mb dan büyük veya dosya formatları geçersizdir.");
					}
						break;
			}
			
			if ($message == JText::_("VERI_KAYDI_BASARILI") && $sayfa != 4 && $sayfa != 6 && $sayfa != 7 && $sayfa == 8){
				$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T3_BASVURU_TIP);
			}
    	}else{
    		return JText::_("BASVURU_KAYDI_BASARISIZ");
    	}
		
    	return $message;
	}
	
	function basvuruBitir ($evrak_id){
		$_db = JFactory::getOracleDBO ();
		$sql = "SELECT DURUM_ID
				FROM M_BELGELENDIRME_DURUM
		        WHERE  EVRAK_ID = ?";
		$params = array($evrak_id);
		$durum = $_db->prep_exec($sql, $params);
		
		if($durum[0][DURUM_ID] == ON_BASVURU_GONDERILMEDI)
			FormFactory2::belgeledirmeDurumGuncelle ($evrak_id, ON_BASVURU_INCELENIYOR);
		
		else if($durum[0][DURUM_ID] == ON_BASVURU_DUZELTME)
			FormFactory2::belgeledirmeDurumGuncelle ($evrak_id, ON_BASVURU_INCELENIYOR);
		
		else if($durum[0][DURUM_ID] == ON_BASVURU_ONAYLANDI)
			FormFactory2::belgeledirmeDurumGuncelle ($evrak_id, YETKI_INCELENIYOR);
		
		else if($durum[0][DURUM_ID] == YETKI_DUZELTME)
			FormFactory2::belgeledirmeDurumGuncelle ($evrak_id, YETKI_INCELENIYOR);
		
		
		$sql_user = "SELECT USER_ID,BASVURU_ILETISIM_ID FROM M_BASVURU WHERE EVRAK_ID = ?";
		$user = current($_db->prep_exec($sql_user, array($evrak_id)));
		
		$_db->prep_exec("DELETE FROM M_BASVURU_ILETISIM WHERE ILETISIM_ID = ?", array($user['BASVURU_ILETISIM_ID']));
		
		$sql_iletisim = "SELECT * FROM M_KURULUS_EDIT WHERE USER_ID = ? AND AKTIF = 1 AND ONAY_BEKLEYEN = 0";
		$data = current($_db->prep_exec($sql_iletisim, array($user['USER_ID'])));
		if(count(data) == 0){
			$sql_iletisim = "SELECT * FROM M_KURULUS WHERE USER_ID = ?";
			$data = current($_db->prep_exec($sql_iletisim, array($user['USER_ID'])));
		}
		$sql_iletisim = "INSERT INTO M_BASVURU_ILETISIM (USER_ID,
										KURULUS_STATU_ID,
										KURULUS_ADI,
										KURULUS_YETKILISI,
										KURULUS_YETKILI_UNVANI,
										KURULUS_ADRESI,
										KURULUS_POSTA_KODU,
										KURULUS_TELEFON,
										KURULUS_FAKS,
										KURULUS_EPOSTA,
										KURULUS_WEB,
										KURULUS_DURUM_ID,
										KURULUS_YETKILENDIRME_NUMARASI,
										KURULUS_SEHIR,
										LOGO)
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$_db->prep_exec_insert($sql_iletisim, array($data['USER_ID'],
													$data['KURULUS_STATU_ID'],
													$data['KURULUS_ADI'],
													$data['KURULUS_YETKILISI'],
													$data['KURULUS_YETKILI_UNVANI'],
													$data['KURULUS_ADRESI'],
													$data['KURULUS_POSTA_KODU'],
													$data['KURULUS_TELEFON'],
													$data['KURULUS_FAKS'],
													$data['KURULUS_EPOSTA'],
													$data['KURULUS_WEB'],
													$data['KURULUS_DURUM_ID'],
													$data['KURULUS_YETKILENDIRME_NUMARASI'],
													$data['KURULUS_SEHIR'],
													$data['LOGO']));
		$data_iletisim = current($_db->prep_exec("SELECT ILETISIM_ID FROM M_BASVURU_ILETISIM WHERE USER_ID = ? ORDER BY ILETISIM_ID DESC", array($user['USER_ID'])));
		
		$_db->prep_exec_insert("UPDATE M_BASVURU SET BASVURU_ILETISIM_ID = ? WHERE EVRAK_ID = ?",array($data_iletisim['ILETISIM_ID'],$evrak_id));
		//FormFactory2::belgeledirmeDurumGuncelle ($evrak_id, ONAYLANMAMIS_BASVURU);
		//FormFactory2::evrakKaydet ($evrak_id);
		//$this->clearSavedPages ($evrak_id);
	}
	
	function basvuruGorevBirimEkle ($evrak_id, $post){
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
	
	function basvuruFaaliyetGuncelle($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		$sure = 1;
		if (isset ($data['radio0']))
			$sure = $data['radio0']; //Radio
	
		/** Sabit Tablo Degerleri 
		****************************************************/
		$faaliyet_sure 			= $sure; 					//PM_FAALIYET_SURESI
		$personel_sayisi		= $data['personel_sayisi'];
		$hazirlama_ekibi		= 1;
		$ekip_sayisi 			= $data['ekip_sayisi'];
		$kurulus_talep_aciklama	= trim($data['madde_7a']);
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " UPDATE m_basvuru 
				 	SET faliyet_sure_id = ?,
				 		personel_sayisi = ?,
				 		hazirlama_ekibi = ?,
				 		ekip_sayisi = ?,
				 		kurulus_talep_aciklama = ?
				 WHERE evrak_id = ?";
			         
		$params = array($faaliyet_sure,
						$personel_sayisi,
						$hazirlama_ekibi,
						$ekip_sayisi,
						$kurulus_talep_aciklama,
						$evrak_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruKapsamGuncelle($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
			
		/** Sabit Tablo Degerleri 
		****************************************************/
		$gezici_birim 	 = null;
		$egitim_aciklama = null;
		$fiziki_aciklama = trim($data["madde_15"]);
		
		if ($data["radio0"])
			$gezici_birim 	 = trim($data["madde_11"]);
		if ($data["radio2"])
			$egitim_aciklama = trim($data["madde_14"]);

		if ($gezici_birim == null && $egitim_aciklama == null){
			$sqlPart = "gezici_birim = EMPTY_CLOB(), 
				 		egitim_aciklama = EMPTY_CLOB(),";
			$params = array( $fiziki_aciklama, $evrak_id);
		}else if ($gezici_birim == null){
			$sqlPart = "gezici_birim = EMPTY_CLOB(), 
			 			egitim_aciklama = ?,";
			$params = array( $egitim_aciklama, $fiziki_aciklama, $evrak_id);
		}else if ($egitim_aciklama == null){
			$sqlPart = "gezici_birim = ?, 
			 			egitim_aciklama = EMPTY_CLOB(),";
			$params = array( $gezici_birim, $fiziki_aciklama, $evrak_id);
		}else{
			$sqlPart = "gezici_birim = ?, 
			 			egitim_aciklama = ?,";
			$params = array( $gezici_birim,$egitim_aciklama, $fiziki_aciklama, $evrak_id);
		}	
			
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " UPDATE m_basvuru 
				 	SET ".$sqlPart." 
				 		teknik_fiziki_aciklama = ? 
				 WHERE evrak_id = ?";
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikTalebiKaydet($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		
		$colCount	=  5;
		$tableName 	= "yetkiTalep";
		$tableValues = FormFactory2::getTableValues ($_POST, array ($tableName, $colCount));
		//$result = $this->yeterlilikTalebiSil($evrak_id);
		
		for ($i = 0; ($i < count($tableValues)/$colCount); $i++){
			$id 	= $_db->getNextVal(YETERLILIK_TALEBI_SEQ);
			
			$yet = $data["inputyetkiTalep-1"][$i];
			//$seviye = $data["inputyetkiTalep-2"][$i];
			$belge = $data["inputyetkiTalep-2"][$i];
			$sinav = $data["inputyetkiTalep-3"][$i];
			
			$result = $this->yeterlilikTalebiVerisiEkle($evrak_id, $id, array($yet, $belge, $sinav));
		}
		//$r = print_r($data,true);
		//return $r;
		return $result;
	}
	
	function yeterlilikTalebiVerisiEkle($evrak_id, $id, $values){
		$_db = JFactory::getOracleDBO ();
		/** Sabit Tablo Degerleri 
		****************************************************/
		/*$yeterlilik_id = $values[2]; //yeterlilik_kodu
		$verilen_belge = $values[3];
		$yapilan_sinav = $values[4];*/
// 		$sql1 = "SELECT YETERLILIK_ADI FROM M_YETERLILIK WHERE YETERLILIK_SUREC_DURUM_ID = 1 AND YETERLILIK_ID = ?";
// 		$params = array($values[0]);
// 		$yeterlilik_adi = $_db->prep_exec($sql1, $params);
// 		$sql2 = "SELECT YETERLILIK_ID FROM M_YETERLILIK WHERE YETERLILIK_SUREC_DURUM_ID = 1 AND YETERLILIK_ADI = ? AND SEVIYE_ID = ?";
// 		$params = array($yeterlilik_adi[0][YETERLILIK_ADI],
// 						$values[1]);
// 		$yeterlilikid = $_db->prep_exec($sql2, $params);
		$yeterlilik_id = $values[0];
		$verilen_belge = $values[1];
		$yapilan_sinav = $values[2];
		//$yeterlilik_id = $yeterlilikid[0][YETERLILIK_ID];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " INSERT INTO m_belgelendirme_yet_talebi (EVRAK_ID, YETERLILIK_ID, VERILEN_BELGE, YAPILAN_SINAV) 
				 VALUES ( ?, ?, ?, ?)";
			         
		$params = array($evrak_id,
						$yeterlilik_id,
						$verilen_belge,
						$yapilan_sinav);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikTalebiSil($evrak_id){
		$_db = JFactory::getOracleDBO ();
		//Prepare sql statement
		$sql = " DELETE FROM m_belgelendirme_yet_talebi 
				 WHERE evrak_id = ?";
			         
		$params = array($evrak_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
        function BasvuruEkleriKaydet($datayeni, $dataeski, $sayfa, $user_id, $evrak_id){
          $db = & JFactory::getOracleDBO(); //Oracle  
          
          $sql1="DELETE FROM M_SINAV_DEGERLENDIRICI WHERE EVRAK_ID= ?";
          $db->prep_exec_insert($sql1, array($evrak_id));
          
          $sql2 = "SELECT USER_ID FROM M_BASVURU WHERE EVRAK_ID = ?";	
          $user = $db->prep_exec($sql2, array($evrak_id));
          
          $file = $datayeni['dosya'];
          $belgeAdi = array_keys($file['name']);
          $belgeAdi = $belgeAdi[0];
          $tipler = explode('.', $file['name'][$belgeAdi]);
          $tip = $tipler[1];
          if($file['size'][$belgeAdi]>0){
              
            if(($tip != 'rar' and 
            		$tip!='zip' and 
            		$file['type'][$belgeAdi]!="application/msword" and 
            		$file['type'][$belgeAdi]!="application/pdf" and 
            		$file['type'][$belgeAdi]!="application/vnd.ms-excel" and 
            		$file['type'][$belgeAdi]!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" and 
            		$file['type'][$belgeAdi]!="image/jpeg" and 
            		$file['type'][$belgeAdi]!="image/gif" and 
            		$file['type'][$belgeAdi]!="image/png" and 
            		$file['type'][$belgeAdi]!="application/vnd.openxmlformats-officedocument.presentationml.presentation" and 
            		$file['type'][$belgeAdi]!="application/vnd.ms-powerpoint" and
            		$file['type'][$belgeAdi]!="image/tiff" and
            		$file['type'][$belgeAdi]!="application/x-rar-compressed"  and 
            		$file['type'][$belgeAdi]!="application/zip") or $file['size'][$belgeAdi]>30000000){
                        //$mainframe->redirect("index.php?option=com_belgelendirme_basvur&layout=ek2&evrak_id=".$evrak_id, "Gönderdiğiniz dosya(lar)nın boyutu 10 mb dan büyük veya formatı Word ya da PDF değil.", 'error');
                    return false;
                }

                else {

                        if (!file_exists(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belgeAdi."/")){
                                mkdir(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belgeAdi, 0700,true);
                        }


                        $normalFile = FormFactory2::formatFilename ($file['name'][$belgeAdi]);
                        //$normalFile = $file['name'][$belgeAdi];
                        //$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_basvuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
                        $pathh =	EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belgeAdi."/" . $normalFile;
                        move_uploaded_file($file['tmp_name'][$belgeAdi],$pathh);

                }

//                $belge_adi = FormFactory2::formatFilename($file['name'][$belgeAdi]);
                $belge_adi = $file['name'][$belgeAdi];

                $sql="insert into M_BELGELENDIRME_BASVURU_EKLERI
                                                (EVRAK_ID,USER_ID,BELGE_ADI,TARIH,BELGE_TURU) values
                                                ( ".$evrak_id.",".$user[0][USER_ID].",? , ? , ? )";
                $params=array($normalFile,time(),$belgeAdi);
                $db->prep_exec_insert($sql, $params);  
          }
          
//          for($ll = 0; $ll < count($dataeski['yeterlilik']); $ll++){
//            $deger = "INSERT INTO M_SINAV_DEGERLENDIRICI
//                                                    (EVRAK_ID, USER_ID, YETERLILIK_ID, DEGERLENDIRICI) values
//                                                    ( ".$evrak_id.",".$user[0]["USER_ID"].",?, ? )";
//
//            $params=array($dataeski['yeterlilik'][$ll],$dataeski['degerlendirici'][$ll]);
//            $db->prep_exec_insert($deger, $params);
//            }
            return true;
        }
        
//	function BasvuruEkleriKaydet ($datayeni, $dataeski, $sayfa, $user_id, $evrak_id){
//		$db = & JFactory::getOracleDBO(); //Oracle
//		$sql1="DELETE FROM M_SINAV_DEGERLENDIRICI WHERE EVRAK_ID= ?";
//		$db->prep_exec_insert($sql1, array($evrak_id));
//		$sql2 = "SELECT USER_ID FROM M_BASVURU WHERE EVRAK_ID = ?";	
//		$user = $db->prep_exec($sql2, array($evrak_id));
//		
//		for($ll = 0; $ll < count($dataeski['yeterlilik']); $ll++){
//			$deger = "INSERT INTO M_SINAV_DEGERLENDIRICI
//								(EVRAK_ID, USER_ID, YETERLILIK_ID, DEGERLENDIRICI) values
//								( ".$evrak_id.",".$user[0]["USER_ID"].",?, ? )";
//			
//			$params=array($dataeski['yeterlilik'][$ll],$dataeski['degerlendirici'][$ll]);
//			$db->prep_exec_insert($deger, $params);
//			
//		}
//		
//		$sql="delete from M_BELGELENDIRME_BASVURU_EKLERI where EVRAK_ID= ".evrak_id."";
//		$db->prep_exec_insert($sql, array());
//		$belge = array("taahutname","dekont","organizasyonsema","surecrehber","sertifikaornek","gorevliliste","gorevlibilgi","gorevlibeyan","peryongorevtanim","kurucumetin","denetimrapor","protokolsozornek","akreditasyonbelge","akreditasyonrapor","kurdegkayit","imzasirku","bilancovergi","sgkborc","vergi","tanitim","misviz","urunhizmet","ulusproje","ekdokumantasyon");
//		for($j=0; $j<24;$j++){
//			if(!in_array($belge[$j],$dataeski[belgeadi])){
//				$sildir=EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belge[$j]."/";
//				foreach(glob($sildir . '/*') as $file) {
//					if(is_dir($file))
//					rrmdir($file);
//					else
//					unlink($file);
//				}
//				rmdir($sildir);
//			}
//			else if(in_array($belge[$j],$dataeski[belgeadi])){
//	
//				//Klasordeki Dosyaları AL Baslangıc
//	
//				$dosyarray = array();
//				//. içinde bulunduğunuz klasör
//				//alt klasörlerde çalışmak için opendir('dosya_yolu')
//				if ($klasor = opendir(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belge[$j]."/")) {
//					while (false !== ($girdi = readdir($klasor))) {
//						if ($girdi != "." && $girdi != "..") {
//							array_push($dosyarray, $girdi);
//						}
//					}
//					closedir($klasor);
//				}
//	
//				//Klasordeki Dosyaları Al Bitis
//				$dosyaeskiler = array();
//				$ttt=0;
//				while ($ttt < count($dataeski[dosyaadi][$belge[$j]])) {
//					array_push($dosyaeskiler, FormFactory2::formatFilename($dataeski[dosyaadi][$belge[$j]][$ttt]));
//					$ttt++;
//				}
//				$saysay = count($dosyarray);
//				for($kk=0; $kk<$saysay+1; $kk++){
//					if(!in_array($dosyarray[$kk],$dosyaeskiler)){
//						$sildir=EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belge[$j]."/".$dosyarray[$kk];
//						unlink($sildir);
//	
//					}
//					else{
//						$sqluseral = "SELECT user_id
//															FROM m_basvuru
//															WHERE evrak_id = ?";
//						
//						$params = array ($evrak_id);
//						$user = $db->prep_exec($sqluseral, $params);
//						
//						
//						$sql="insert into M_BELGELENDIRME_BASVURU_EKLERI
//								(EVRAK_ID,USER_ID,BELGE_ADI,TARIH,BELGE_TURU) values
//								( ".$evrak_id.",".$user[0][USER_ID].",? , ? , ?)";
//						$params=array($dosyarray[$kk],time(),$belge[$j]);
//						$db->prep_exec_insert($sql, $params);
//	
//					}
//				}
//			}
//		}
//	
//		$this->deleteSavedPage ($sayfa,  substr($evrak_pk, 0, 9));
//		$success=false;
//	
//		$setarat = array();
//		for ($i = 0; $i < 24; $i++){
//			if (isset($datayeni[dosya][name][$belge[$i]])){
//				array_push($setarat, $i);
//			}
//		}
//		for($jj = 0; $jj < count($setarat); $jj++){
//			$turuzun = count($datayeni[dosya][name][$belge[$setarat[$jj]]]);
//			//$datayeni[dosya][name][$belge[$setarat[$i]]]
//			for($kkk = 0; $kkk< $turuzun; $kkk++){
//				//$datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]
//	
//				if(($datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/msword" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/pdf" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/vnd.ms-excel" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/jpeg" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/gif" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/png" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/tiff" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/x-rar-compressed"  and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/zip") or $datayeni[dosya][size][$belge[$setarat[$jj]]][$kkk]>30000000){
//					//$mainframe->redirect("index.php?option=com_belgelendirme_basvur&layout=ek2&evrak_id=".$evrak_id, "Gönderdiğiniz dosya(lar)nın boyutu 10 mb dan büyük veya formatı Word ya da PDF değil.", 'error');
//                                    return false;
//				}
//				else {
//	
//					if (!file_exists(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belge[$setarat[$jj]]."/")){
//						mkdir(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belge[$setarat[$jj]], 0700,true);
//					}
//						
//						
//					$normalFile = FormFactory2::formatFilename ($datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]);
//					//$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_basvuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
//					$pathh =	EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
//					move_uploaded_file($datayeni[dosya][tmp_name][$belge[$setarat[$jj]]][$kkk],$pathh);
//	
//				}
//	
//				$belge_adi = FormFactory2::formatFilename($datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]);
//	
//				$sql="insert into M_BELGELENDIRME_BASVURU_EKLERI
//								(EVRAK_ID,USER_ID,BELGE_ADI,TARIH,BELGE_TURU) values
//								( ".$evrak_id.",".$user[0][USER_ID].",? , ? , ? )";
//				$params=array($belge_adi,time(),$belge[$setarat[$jj]]);
//				$db->prep_exec_insert($sql, $params);
//				$success=true;
//			}
//		}
//		$success = true;
//		return $success;
//	}
	
	function BasvuruDocsKaydet ($datayeni, $dataeski, $sayfa, $user_id, $evrak_id){
		$db = & JFactory::getOracleDBO(); //Oracle
		
		$file = $datayeni['dosya'];
		$belgeAdi = array_keys($file['name']);
		$belgeAdi = $belgeAdi[0];
		$tipler = explode('.', $file['name'][$belgeAdi]);
		$tip = $tipler[1];
		
		$belge_adi = $file['name'][$belgeAdi];
		
		if($file['size'][$belgeAdi]>0){
		
			if(($tip != 'rar' and $tip!='zip' and 
				$file['type'][$belgeAdi]!="application/msword" and 
				$file['type'][$belgeAdi]!="application/pdf" and 
				$file['type'][$belgeAdi]!="application/vnd.ms-excel" and 
				$file['type'][$belgeAdi]!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" and 
				$file['type'][$belgeAdi]!="image/jpeg" and 
				$file['type'][$belgeAdi]!="image/gif" and 
				$file['type'][$belgeAdi]!="image/png" and 
				$file['type'][$belgeAdi]!="image/tiff" and 
				$file['type'][$belgeAdi]!="application/vnd.openxmlformats-officedocument.presentationml.presentation" and
				$file['type'][$belgeAdi]!="application/vnd.ms-powerpoint" and
				$file['type'][$belgeAdi]!="application/x-rar-compressed"  and 
				$file['type'][$belgeAdi]!="application/zip") or $file['size'][$belgeAdi]>30000000){
				//$mainframe->redirect("index.php?option=com_belgelendirme_basvur&layout=ek2&evrak_id=".$evrak_id, "Gönderdiğiniz dosya(lar)nın boyutu 10 mb dan büyük veya formatı Word ya da PDF değil.", 'error');
				return false;
			}
		
			else {
		
				if (!file_exists(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belgeAdi."/")){
					mkdir(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belgeAdi, 0700,true);
				}
		
		
				$normalFile = FormFactory2::formatFilename($file['name'][$belgeAdi]);
				//$normalFile = $file['name'][$belgeAdi];
				//$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_basvuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
				$pathh =	EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belgeAdi."/" . $normalFile;
				move_uploaded_file($file['tmp_name'][$belgeAdi],$pathh);
		
				$belge_adi = $file['name'][$belgeAdi];
				$basTar = $dataeski['tarih'][$belgeAdi][0];
				$bitTar = isset($dataeski['tarih'][$belgeAdi][1])?$dataeski['tarih'][$belgeAdi][1]:null;
				if($belgeAdi == 'onsozlesme'){
					$sql="insert into M_BELGELENDIRME_DOCS
	                                                (EVRAK_ID,USER_ID,BELGE_ADI,BAS_TARIH,BIT_TARIH,BELGE_TURU) values
	                                                ( ".$evrak_id.",".$user_id.",? , ? , ? ,?)";
					$params=array($normalFile,$basTar,$bitTar,$belgeAdi);
					$db->prep_exec_insert($sql, $params);
				}
				else{
					$sql="insert into M_BELGELENDIRME_DOCS
	                                                (EVRAK_ID,USER_ID,BELGE_ADI,BAS_TARIH,BELGE_TURU) values
	                                                ( ".$evrak_id.",".$user_id.",? , ? , ? )";
					$params=array($normalFile,$basTar,$belgeAdi);
					$db->prep_exec_insert($sql, $params);
				}
		}
	}
// 		$sql="delete from M_BELGELENDIRME_DOCS where EVRAK_ID= ".evrak_id."";
// 		$db->prep_exec_insert($sql, array());
// 		$belge = array("onbasvuru", "yetkibasvuru", "onsozlesme", "yetsozlesme");
// 		for($j=0; $j<4;$j++){
// 			if(!in_array($belge[$j],$dataeski[belgeadi])){
// 				$sildir=EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belge[$j]."/";
// 				foreach(glob($sildir . '/*') as $file) {
// 					if(is_dir($file))
// 					rrmdir($file);
// 					else
// 					unlink($file);
// 				}
// 				rmdir($sildir);
// 			}
// 			else if(in_array($belge[$j],$dataeski[belgeadi])){
	
// 				//Klasordeki Dosyaları AL Baslangıc
	
// 				$dosyarray = array();
// 				//. içinde bulunduğunuz klasör
// 				//alt klasörlerde çalışmak için opendir('dosya_yolu')
// 				if ($klasor = opendir(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belge[$j]."/")) {
// 					while (false !== ($girdi = readdir($klasor))) {
// 						if ($girdi != "." && $girdi != "..") {
// 							array_push($dosyarray, $girdi);
// 						}
// 					}
// 					closedir($klasor);
// 				}
	
// 				//Klasordeki Dosyaları Al Bitis
// 				$dosyaeskiler = array();
// 				$ttt=0;
// 				while ($ttt < count($dataeski[dosya][$belge[$j]])) {
// 					array_push($dosyaeskiler, FormFactory2::formatFilename($dataeski[dosya][$belge[$j]][$ttt]));
// 					$ttt++;
// 				}
// 				$saysay = count($dosyarray);
// 				for($kk=0; $kk<$saysay+1; $kk++){
// 					if(!in_array($dosyarray[$kk],$dosyaeskiler)){
// 						$sildir=EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belge[$j]."/".$dosyarray[$kk];
// 						unlink($sildir);
	
// 					}
// 					else{
// 						if($belge[$j] == "onsozlesme" || $belge[$j] == "yetsozlesme"){
// 							$sql="insert into M_BELGELENDIRME_DOCS
// 																						(EVRAK_ID,USER_ID,BELGE_ADI,BAS_TARIH, BIT_TARIH, BELGE_TURU) values
// 																						( ".$evrak_id.",".$user_id.",? , ? , ? , ? )";
// 							$params=array($dosyarray[$kk], $dataeski[tarih][$belge[$j]][0], $dataeski[tarih][$belge[$j]][1], $belge[$j]);
// 						}
// 						else if($belge[$j] == "onbasvuru" || $belge[$j] == "yetkibasvuru"){
// 						$sql="insert into M_BELGELENDIRME_DOCS
// 																						(EVRAK_ID,USER_ID,BELGE_ADI,BAS_TARIH, BELGE_TURU) values
// 																						( ".$evrak_id.",".$user_id.",? , ? , ? )";
// 							$params=array($dosyarray[$kk], $dataeski[tarih][$belge[$j]][0], $belge[$j]);
// 						}
// 						$db->prep_exec_insert($sql, $params);
						
// 					}
// 				}
// 			}
// 		}
	
// 		$this->deleteSavedPage ($sayfa,  substr($evrak_pk, 0, 9));
// 		$success=false;
	
// 		$setarat = array();
// 		for ($i = 0; $i < 4; $i++){
// 			if (isset($datayeni[dosya][name][$belge[$i]])){
// 				array_push($setarat, $i);
// 			}
// 		}
// 		for($jj = 0; $jj < count($setarat); $jj++){
// 			$turuzun = count($datayeni[dosya][name][$belge[$setarat[$jj]]]);
// 			//$datayeni[dosya][name][$belge[$setarat[$i]]]
// 			for($kkk = 0; $kkk< $turuzun; $kkk++){
// 				//$datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]
	
// 				if(($datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/msword" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/pdf" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/vnd.ms-excel" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/jpeg" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/gif" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/png" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/tiff" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/x-rar-compressed" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/zip") or $datayeni[dosya][size][$belge[$setarat[$jj]]][$kkk]>30000000){
// 					//$mainframe->redirect("index.php?option=com_belgelendirme_basvur&layout=form&evrak_id=".$evrak_id, "Gönderdiğiniz dosya(lar)nın boyutu 5 mb dan büyük veya formatı Word ya da PDF değil.", 'error');
//                                     return false;
// 				}
// 				else {
	
// 					if (!file_exists(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belge[$setarat[$jj]]."/")){
// 						mkdir(EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belge[$setarat[$jj]], 0700,true);
// 					}
	
	
// 					$normalFile = FormFactory2::formatFilename ($datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]);
// 					//$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_basvuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
// 					$pathh =	EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrak_id."/DOCS/".$belge[$setarat[$jj]]."/" . $normalFile;
// 					move_uploaded_file($datayeni[dosya][tmp_name][$belge[$setarat[$jj]]][$kkk],$pathh);
	
// 				}
	
// 				$belge_adi = FormFactory2::formatFilename($datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]);
	
// 				if(isset($dataeski[tarih][$belge[$setarat[$jj]]][1])){
// 					$sql="insert into M_BELGELENDIRME_DOCS
// 															(EVRAK_ID,USER_ID,BELGE_ADI,BAS_TARIH, BIT_TARIH, BELGE_TURU) values
// 															( ".$evrak_id.",".$user_id.",? , ? , ? , ?)";
// 					$params=array($belge_adi, $dataeski[tarih][$belge[$setarat[$jj]]][0], $dataeski[tarih][$belge[$setarat[$jj]]][1], $belge[$setarat[$jj]]);
// 				}
// 				else{
// 					$sql="insert into M_BELGELENDIRME_DOCS
// 										(EVRAK_ID,USER_ID,BELGE_ADI,BAS_TARIH, BELGE_TURU) values
// 										( ".$evrak_id.",".$user_id.",? , ? , ? )";
// 					$params=array($belge_adi, $dataeski[tarih][$belge[$setarat[$jj]]][0], $belge[$setarat[$jj]]);
// 				}
// 				$db->prep_exec_insert($sql, $params);
// 				$success=true;
// 			}
// 		}
		$success = true;
		return $success;
	}
	
	//Basvuru Dokumanları Son
	
	
	
	public function akreditasyonVerileriKaydet ($evrak_id, $panelName, $data, $rowCount){
		$panelCount = $data["panelCount_".$panelName];
		$result = true;
		
		for ($i = 1; $result && ($i < $panelCount+2); $i++){
			$akHiddenId = $panelName.$i;
			if ($i == 1)
				$akHiddenId = $panelName;

			if (!isset ($_POST[$akHiddenId])){ 					// INSERT
				if (isset ($_POST["input".$akHiddenId."-2"])){
					$inputName 	= "input".$akHiddenId;		
					$panelValues =  FormFactory2::getPanelValues ($_POST, $inputName, $rowCount);
					$result = $this->akreditasyonVerisiEkle($evrak_id, $panelValues);
				}
				
			}else{ 
				$akId = $_POST[$akHiddenId];
				
				if (!isset ($_POST["input".$akHiddenId."-2"])){	// DELETE
					$result = $this->akreditasyonVerisiSil($evrak_id, $akId);
				}else{											// UPDATE
					$inputName 	= "input".$akHiddenId;		
					$panelValues =  FormFactory2::getPanelValues ($_POST, $inputName, $rowCount);
					$result = $this->akreditasyonVerisiGuncelle($evrak_id, $akId, $panelValues);
				}
			}		
		}
		
		return $result;
	}
	
	function akreditasyonVerisiEkle($evrak_id, $panelValues){
		$_db 		= & JFactory::getOracleDBO();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$akreditasyon_id		= $_db->getNextVal(AKREDITASYON_SEQ);
		$akreditasyon_adi		= $panelValues[0];
		$akreditasyon_path		= null;
		$akreditasyon_aciklama	= null;
		$akreditasyon_seviye	= $panelValues[1];
		$akreditasyon_standart	= $panelValues[2];
		$akreditasyon_baslangic = $panelValues[3];
		$akreditasyon_bitis		= $panelValues[4];
		$akreditasyon_denetim	= $panelValues[5];
		$akreditasyon_kapsam	= $panelValues[6];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO m_akreditasyon 
				values( ?, ?, ?, ?, ?, ?, ?,  to_date(?,'dd/mm/yyyy'),  to_date(?,'dd/mm/yyyy'),  to_date(?,'dd/mm/yyyy'),  to_date(?,'dd/mm/yyyy'))";
			         
		$params = array($evrak_id,
						$akreditasyon_id,
						$akreditasyon_adi,
						$akreditasyon_path,
						$akreditasyon_aciklama,
						$akreditasyon_seviye,
						$akreditasyon_standart,
						$akreditasyon_baslangic,
						$akreditasyon_bitis,
						$akreditasyon_denetim,
						$akreditasyon_kapsam);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function akreditasyonVerisiSil($evrak_id, $akId){
		$_db = & JFactory::getOracleDBO();
		
		//Prepare sql statement
		$sql = "DELETE FROM m_akreditasyon 
				WHERE evrak_id = ? AND akreditasyon_id = ?";
			         
		$params = array($evrak_id, $akId);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function akreditasyonVerisiGuncelle($evrak_id, $akId, $panelValues){
		$_db = & JFactory::getOracleDBO();

		/** Sabit Tablo Degerleri 
		****************************************************/
		$akreditasyon_adi		= $panelValues[0];
		$akreditasyon_path		= null;
		$akreditasyon_aciklama	= null;
		$akreditasyon_seviye	= $panelValues[1];
		$akreditasyon_standart	= $panelValues[2];
		$akreditasyon_baslangic = $panelValues[3];
		$akreditasyon_bitis		= $panelValues[4];
		$akreditasyon_denetim	= $panelValues[5];
		$akreditasyon_kapsam	= $panelValues[6];
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "UPDATE m_akreditasyon 
				SET akreditasyon_adi = ?, 
					akreditasyon_path = ?, 
					akreditasyon_aciklama = ?, 
					akreditasyon_seviye = ?, 
					akreditasyon_standardi = ?, 
					akreditasyon_baslangic =  to_date(?,'dd/mm/yyyy'), 
					akreditasyon_bitis =  to_date(?,'dd/mm/yyyy'), 
					akreditasyon_denetim =  to_date(?,'dd/mm/yyyy'), 
					akreditasyon_kapsam =  to_date(?,'dd/mm/yyyy')  
				WHERE evrak_id = ? AND akreditasyon_id = ?";
			         
		$params = array($akreditasyon_adi,
						$akreditasyon_path,
						$akreditasyon_aciklama,
						$akreditasyon_seviye,
						$akreditasyon_standart,
						$akreditasyon_baslangic,
						$akreditasyon_bitis,
						$akreditasyon_denetim,
						$akreditasyon_kapsam,
						$evrak_id,
						$akId);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function sinavMerkezKaydet ($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		$colCount	=  5;
		$tableName 	= "sinavGercekMerkez";
		$sinavValues = FormFactory2::getTableValues ($data, array ($tableName, $colCount), 1);
		$sinavmerkezler = $data["sinavGercekMerkez"];
		$say = 0;
		$result = $this->sinavMerkezSil ($evrak_id, $sinavmerkezler);
		
		for ($i = 0; $result && $i < count($sinavValues)/$colCount; $i++){
			if($sinavmerkezler[$say] != null || !empty($sinavmerkezler[$say])){
				$id = $i*$colCount;
				$ad				= $sinavValues[$id	 ];
				$yeterlilik_id 	= $sinavValues[$id+ 1];
				$sinav_sekli_id	= $sinavValues[$id+ 2];
				$temin_id		= $sinavValues[$id+ 3];
				$adres_bilgi	= $sinavValues[$id+ 4];
				$merkez_id = $sinavmerkezler[$say];
				
				$sqlUp = "UPDATE M_SINAV_MERKEZI SET EVRAK_ID = ?, MERKEZ_TEMIN_ID = ?, MERKEZ_ADI = ?, MERKEZ_ADRESI = ? WHERE MERKEZ_ID = ?";
				$params = array($evrak_id,
								$temin_id,
								$ad,
								$adres_bilgi,
								$merkez_id);
				$result = $_db->prep_exec_insert($sqlUp, $params);
				
				if ($sinav_sekli_id == 3){
					$result = $this->merkezSinavVerisiUpdate ($evrak_id, $merkez_id, $yeterlilik_id, 1);
					$result = $this->merkezSinavVerisiUpdate ($evrak_id, $merkez_id, $yeterlilik_id, 2);
				}else{
					$result = $this->merkezSinavVerisiUpdate ($evrak_id, $merkez_id, $yeterlilik_id, $sinav_sekli_id);
				}
			}
			else{
				$id = $i*$colCount;
				$ad				= $sinavValues[$id	 ];
				$yeterlilik_id 	= $sinavValues[$id+ 1];
				$sinav_sekli_id	= $sinavValues[$id+ 2];
				$temin_id		= $sinavValues[$id+ 3];	
				$adres_bilgi	= $sinavValues[$id+ 4];
				
				//M_SINAV_MERKEZI
				$merkez_id		= $this->sinavMerkeziVerisiEkle($evrak_id, $ad, $adres_bilgi,$temin_id);  		
							
				if ($merkez_id != -1){
					//M_MERKEZ_SINAV
					if ($sinav_sekli_id == 3){
						$result = $this->merkezSinavVerisiEkle ($evrak_id, $merkez_id, $yeterlilik_id, 1);
						$result = $this->merkezSinavVerisiEkle ($evrak_id, $merkez_id, $yeterlilik_id, 2);
					}else{
						$result = $this->merkezSinavVerisiEkle ($evrak_id, $merkez_id, $yeterlilik_id, $sinav_sekli_id);
					}
				}
			}
			$say++;
		}
		
		return $result;
	}
	
	function sinavMerkeziVerisiEkle ($evrak_id, $merkez_adi, $merkez_adresi, $merkez_temin_id){
		$_db = JFactory::getOracleDBO ();
		
		/** Sabit Tablo Degerleri 
		****************************************************/
		$merkez_id			= $_db->getNextVal(SINAV_MERKEZI_SEQ);	//PK
		$merkez_telefon		= null;
		$merkez_faks		= null;
		$merkez_eposta		= null;
		$merkez_web			= null;
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO M_SINAV_MERKEZI (EVRAK_ID, MERKEZ_ID, MERKEZ_TEMIN_ID, MERKEZ_ADI, MERKEZ_ADRESI, MERKEZ_TELEFON, MERKEZ_FAKS, MERKEZ_EPOSTA, MERKEZ_WEB)
				VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($evrak_id,
						$merkez_id,
						$merkez_temin_id,
						$merkez_adi,
						$merkez_adresi,
						$merkez_telefon,
						$merkez_faks,
						$merkez_eposta,
						$merkez_web);
	
		$result = $_db->prep_exec_insert($sql, $params);
		if ($result)
			return $merkez_id;
		else
			return -1;
	}
	
	function merkezSinavVerisiEkle ($evrak_id, $merkez_id, $yeterlilik_id, $sinav_sekli_id){
		$_db = JFactory::getOracleDBO ();
		/** Sabit Tablo Degerleri 
		****************************************************/
		$yeterlilik_aciklama = null;		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
				VALUES( ?, ?, ?, ?, ?)";
			         
		$params = array($evrak_id,
						$merkez_id,
						$yeterlilik_id,
						$yeterlilik_aciklama,
						$sinav_sekli_id);
									
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function merkezSinavVerisiUpdate ($evrak_id, $merkez_id, $yeterlilik_id, $sinav_sekli_id){
		$_db = JFactory::getOracleDBO ();
		
		//$sqlSil = "DELETE FROM M_MERKEZ_SINAV WHERE MERKEZ_ID = ? AND EVRAK_ID = ?";
		//$result = $_db->prep_exec_insert($sqlSil, array($merkez_id, $evrak_id));
		
		
		/** Sabit Tablo Degerleri
			****************************************************/
		$yeterlilik_aciklama = null;
		/** Sabit Tablo Degerleri Sonu
			****************************************************/
		//Prepare sql statement
		//$sql = "UPDATE M_MERKEZ_SINAV SET YETERLILIK_ID = ?, YETERLILIK_ACIKLAMA = ?, SINAV_SEKLI_ID = ? WHERE MERKEZ_ID = ? AND EVRAK_ID = ?";
		$sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
						VALUES( ?, ?, ?, ?, ?)";
		
		$params = array($evrak_id,
						$merkez_id,
						$yeterlilik_id,
						$yeterlilik_aciklama,
						$sinav_sekli_id);
			
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function sinavMerkezSil ($evrak_id, $sinavmerkezler){
		$resultS = $this->merkezSinavSil  ($evrak_id, $sinavmerkezler);
		$resultMS = $this->sinavMerkeziSil ($evrak_id, $sinavmerkezler);
		
		$returnValues = array ($resultS, $resultMS);
		return !FormFactory2::isThereError($returnValues);
	}
	
	function sinavMerkeziSil ($evrak_id, $sinavmerkezler){
		$_db = JFactory::getOracleDBO ();
		//Prepare sql statement
		$merkez = '';
		$say = 1;
		$uzun = count($sinavmerkezler);
		foreach($sinavmerkezler as $cows){
			if($uzun == $say){
				$merkez .= $cows;
			}
			else{
				$merkez = $cows.',';
			}
			$say++;
		}
		if($merkez != null || !empty($merkez)){
			$sql = "DELETE FROM M_SINAV_MERKEZI
				WHERE EVRAK_ID = ? AND MERKEZ_ID NOT IN(SELECT MERKEZ_ID FROM M_SINAV_TAKVIMI FULL JOIN M_SINAV_MERKEZI USING(MERKEZ_ID) WHERE MERKEZ_ID IN (".$merkez."))";
		}
		else{
			$sql = "DELETE FROM M_SINAV_MERKEZI
									WHERE EVRAK_ID = ?";
		}
				
		$params = array($evrak_id);
									
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function merkezSinavSil  ($evrak_id, $sinavmerkezler){
		$_db = JFactory::getOracleDBO ();
		//Prepare sql statement
		/*$merkez = '';
		$say = 1;
		$uzun = count($sinavmerkezler);
		foreach($sinavmerkezler as $cows){
			if($uzun == $say){
				$merkez .= $cows;
			}
			else{
				$merkez = $cows.',';
			}
			$say++;
		}
		
		if($merkez != null || !empty($merkez)){
			$sql = "DELETE FROM m_merkez_sinav
			WHERE EVRAK_ID = ? AND MERKEZ_ID NOT IN(".$merkez.")";
		}
		else{
			$sql = "DELETE FROM m_merkez_sinav
									WHERE EVRAK_ID = ?";
		}*/
		$sql = "DELETE FROM m_merkez_sinav
											WHERE EVRAK_ID = ?";
			         
		$params = array($evrak_id);
									
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruOlustur (){
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= T3_SAYI_ID;
    	$basvuru_tip 	= T3_BASVURU_TIP;
    	$basvuru_durum	= KAYDEDILMIS_BASVURU_SEKLI_ID;
    	$basvuru_durum1	= ON_BASVURU_GONDERILMEDI;
    	
    	$evrak_id = FormFactory2::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		if ($evrak_id != -1){
			$basvuru_tur = $_SESSION['basvuru_tur'];
			unset($_SESSION['basvuru_tur']);
    		FormFactory2::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum,$basvuru_tur);
			FormFactory2::BelgebasvuruOlustur($evrak_id, $basvuru_durum1);
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
	
	function isEkCountEnough($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT count(*) 
				FROM m_basvuru_ekler 
				WHERE evrak_id = ? AND basvuru_ek_tip < 20";
		
		$params = array ($evrak_id);
		$data = $db->prep_exec_array($sql, $params);
		
		if ($data[0] >= 19)
			return true;
		else
			return false;
	}
	
}
?>