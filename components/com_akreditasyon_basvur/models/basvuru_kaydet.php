<?php
defined('_JEXEC') or die('Restricted access');

class Akreditasyon_BasvurModelBasvuru_Kaydet extends JModel {
	
	function basvuruKaydet ($data, $layout, $evrak_id){
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
					
					$resultG = $this->basvuruGorevBirimEkle ($evrak_id, $data);
					$resultI = FormFactory::irtibatVerileriKaydet($evrak_id, $panelName, $data);
				
					$returnValues = array ($resultG, $resultI);
					if (!FormFactory::isThereError($returnValues))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
					break;
				case "faaliyet":
					$sayfa = 3;
					
					$resultB = $this->basvuruFaaliyetGuncelle($evrak_id, $data);
					//PANELLER
					$panelName = "kurulus_panel";
					$rowCount	= 10;
					$resultK = FormFactory::birlikteKurulusVerileriKaydet($evrak_id, $panelName, $data, $rowCount);			
					//TABLOLAR
					$tableName = "sektor";
					$resultS = FormFactory::sektorVerileriKaydet($evrak_id, $tableName, $data);
					$tableName = "faaliyet";
					$resultF = FormFactory::faaliyetVerileriKaydet($evrak_id, $tableName, $data);
					$tableName = "yetkiTalep";
					$resultT = $this->yeterlilikTalebiKaydet($evrak_id, $data);
					
					$returnValues = array ($resultB, $resultK, $resultS, $resultF, $resultT);
					if (!FormFactory::isThereError($returnValues))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
						
					if (FormFactory::isPersonelCountEnough($evrak_id))
						$this->insertSavedPage (4, $evrak_id, $user->id, T4_BASVURU_TIP);
					else
						$this->deleteSavedPage (4, $evrak_id);
					break;
				case "ek":
					$sayfa = 4;
					$panelName = "personelForm_panel";
					$result = FormFactory::kisiBilgiVerileriKaydet($evrak_id, $panelName, $data);
					
					if ($result)
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = JText::_("VERI_KAYDI_BASARISIZ");
						
					if (FormFactory::isPersonelCountEnough($evrak_id))
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T4_BASVURU_TIP);
					else
						$this->deleteSavedPage ($sayfa, $evrak_id);
					break;
				case "basvuru_ekleri":
					$sayfa = 5;
					if ($this->BasvuruEkleriKaydet($_FILES, $data,$sayfa,$user_id))
					$message = JText::_("VERI_KAYDI_BASARILI");
					else
					$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
						
					
					if (FormFactory::isPersonelCountEnough($evrak_id))
						$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T4_BASVURU_TIP);
					else
						$this->deleteSavedPage ($sayfa, $evrak_id);
					
					break;
			}
			
			if ($message == JText::_("VERI_KAYDI_BASARILI") && $sayfa != 4)
				$this->insertSavedPage ($sayfa, $evrak_id, $user->id, T4_BASVURU_TIP);
    	}else {
    		return JText::_("BASVURU_KAYDI_BASARISIZ");
    	}
    	
    	return $message;
	}
	
	function basvuruBitir ($evrak_id){
		echo"<pre>";
		print_r($_REQUEST);
		echo"</pre>";
		exit;		
		FormFactory::evrakKaydet ($evrak_id);
		$this->clearSavedPages ($evrak_id);
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
		$faaliyet_sure 		= $sure; 					//PM_FAALIYET_SURESI
		$personel_sayisi	= $data['personel_sayisi'];
		$hazirlama_ekibi	= 1;
		$ekip_sayisi		= trim($data['kisi_sayisi']);
		//$ekip_aciklama 	= trim($data['madde_7a1']);	 
		$altyapi_aciklama	= trim($data['fiziki']);
		$akreditasyonFaaliyetAciklama = $_POST['akreditasyonFaaliyetAciklama'];
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		$sql = " UPDATE m_basvuru 
				 	SET faliyet_sure_id = ?,
				 		personel_sayisi = ?,
				 		hazirlama_ekibi = ?,
				 		ekip_sayisi = ?,
				 		altyapi_aciklama = ?,
				 		akreditasyon_faaliyeti_ack =?
				 WHERE evrak_id = ?";
			         
		$params = array($faaliyet_sure,
						$personel_sayisi,
						$hazirlama_ekibi,
						$ekip_sayisi,
						$altyapi_aciklama,
						$akreditasyonFaaliyetAciklama,
						$evrak_id );
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikTalebiKaydet($evrak_id, $data){
		$_db = JFactory::getOracleDBO ();
		
		$colCount	=  5;
		$tableName 	= "yetkiTalep";
		$tableValues = FormFactory::getTableValues ($_POST, array ($tableName, $colCount));
		$result = true;
		
		$this->yeterlilikTalebiSil($evrak_id);
		
		for ($i = 0; $result && ($i < count($tableValues)/$colCount); $i++){
			$id 	= $_db->getNextVal(YETERLILIK_TALEBI_SEQ);
			$result = $this->yeterlilikTalebiVerisiEkle($evrak_id, $id, $tableValues, ($i*$colCount));
		}
		
		return $result;
	}
	
	function yeterlilikTalebiVerisiEkle($evrak_id, $id, $values, $startIndex){
		$_db = JFactory::getOracleDBO ();
		/** Sabit Tablo Degerleri 
		****************************************************/
		$yeterlilik_id = $values[$startIndex+0]; //yeterlilik_kodu
		$verilen_belge = $values[$startIndex+2];
		$yapilan_sinav = $values[$startIndex+3];
		
		
		/** Sabit Tablo Degerleri Sonu 
		****************************************************/
		//Prepare sql statement
		
		$selectSql = "SELECT * FROM m_yeterlilik_talebi where EVRAK_ID=? AND YETERLILIK_ID=?";
		$selectParams = $params = array($evrak_id, $yeterlilik_id);
		$rslt = $_db->prep_exec($selectSql, $selectParams);
		
		if(count($rslt)==0)
		{
			$sql = " INSERT INTO m_yeterlilik_talebi 
			(EVRAK_ID, YETERLILIK_ID, VERILEN_BELGE, YAPILAN_SINAV)
			values( ?, ?, ?, ?)";
			
			$params = array($evrak_id,
					$yeterlilik_id,
					$verilen_belge,
					$yapilan_sinav);
			
			return $_db->prep_exec_insert($sql, $params);
		}
		else
		{
			$sql = " UPDATE m_yeterlilik_talebi SET VERILEN_BELGE=?, YAPILAN_SINAV=?
			WHERE EVRAK_ID=? AND YETERLILIK_ID=?";
			
			$params = array($verilen_belge,
							$yapilan_sinav,
							$evrak_id,
							$yeterlilik_id);
			
			return $_db->prep_exec_insert($sql, $params);
		}
		
	}
	
	function yeterlilikTalebiSil($evrak_id){
		$_db = JFactory::getOracleDBO ();
		//Prepare sql statement
		$sql = " DELETE FROM m_yeterlilik_talebi 
				 WHERE evrak_id = ?";
			         
		$params = array($evrak_id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function BasvuruEkleriKaydet ($datayeni, $dataeski, $sayfa, $user_id){
		/*echo "1<pre>";
		//print_r($dataeski);
		print_r($datayeni[dosya][type]);
		echo "</pre>";
		exit;*/
		global $mainframe;
		
		$evrakId = ($dataeski['evrak_id']!=-1) ? $dataeski['evrak_id'] : $this->basvuruOlustur();
			
			
		$db 	= & JFactory::getOracleDBO(); //Oracle
		$sql="delete from M_AKREDITASYON_BASVURU_EKLERI where USER_ID= ".$user_id."";
		$db->prep_exec_insert($sql, array());
		$belge = array("taahutname","dekont","organizasyonsema","surecrehber","gorevliliste","gorevlibilgi","gorevlibeyan","peryongorevtanim","kurucumetin","denetimrapor","protokolsozornek","kurdegkayit","imzasirku","bilancovergi","sgkborc","vergi","tanitim","misviz","urunhizmet","ulusproje","ekdokumantasyon");
		for($j=0; $j<20;$j++){
			if(!in_array($belge[$j],$dataeski[belgeadi])){
				$sildir=EK_FOLDER."akreditasyon_bavuru_ekleri/".$evrakId.'/'.$belge[$j]."/";
				foreach(glob($sildir . '/*') as $file) {
					if(is_dir($file))
					rrmdir($file);
					else
					unlink($file);
				}
				rmdir($sildir);
			}
			else if(in_array($belge[$j],$dataeski[belgeadi])){
				
				//Klasordeki Dosyaları AL Baslangıc
				
				$dosyarray = array();
				//. içinde bulunduğunuz klasör
				//alt klasörlerde çalışmak için opendir('dosya_yolu')
				if ($klasor = opendir(EK_FOLDER."akreditasyon_bavuru_ekleri/".$evrakId."/".$belge[$j]."/")) {
					while (false !== ($girdi = readdir($klasor))) {
						if ($girdi != "." && $girdi != "..") {
							array_push($dosyarray, $girdi);
						}
					}
					closedir($klasor);
				}
				
				//Klasordeki Dosyaları Al Bitis
				$dosyaeskiler = array();
				$ttt=0;
				while ($ttt < count($dataeski[dosyaadi][$belge[$j]])) {
					array_push($dosyaeskiler, FormFactory::formatFilename($dataeski[dosyaadi][$belge[$j]][$ttt]));
					$ttt++;
				}
				$saysay = count($dosyarray);
				for($kk=0; $kk<$saysay+1; $kk++){
					if(!in_array($dosyarray[$kk],$dosyaeskiler)){
						$sildir=EK_FOLDER."akreditasyon_bavuru_ekleri/".$evrakId."/".$belge[$j]."/".$dosyarray[$kk];
						unlink($sildir);
						
					}
					else{
						$sql="insert into M_AKREDITASYON_BASVURU_EKLERI
							(EVRAK_ID, USER_ID,BELGE_ADI,TARIH,BELGE_TURU) values
							( ?, ".$user_id.",? , ? , ?)";
						$params=array($evrakId, $dosyarray[$kk], time(),$belge[$j]);
						$db->prep_exec_insert($sql, $params);
						
					}
				}
			}
	}
	
		$this->deleteSavedPage ($sayfa,  substr($evrak_pk, 0, 9));
		$success=false;
		
		$setarat = array();
		for ($i = 0; $i < 20; $i++){
			if (isset($datayeni[dosya][name][$belge[$i]])){
				array_push($setarat, $i);
			}
		}	
		for($jj = 0; $jj < count($setarat); $jj++){
			$turuzun = count($datayeni[dosya][name][$belge[$setarat[$jj]]]);
			//$datayeni[dosya][name][$belge[$setarat[$i]]]
			for($kkk = 0; $kkk< $turuzun; $kkk++){
				//$datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]
				
				if(($datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/msword" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/pdf" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/vnd.ms-excel" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/jpeg" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="image/gif" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/x-rar-compressed" and $datayeni[dosya][type][$belge[$setarat[$jj]]][$kkk]!="application/zip") or $datayeni[dosya][size][$belge[$setarat[$jj]]][$kkk]>5500000){
					$mainframe->redirect("index.php?option=com_akreditasyon_basvur&layout=basvuru_ekleri", "Gönderdiğiniz dosya(lar)nın boyutu 5 mb dan büyük veya formatı Word ya da PDF değil.", 'error');
				} 
				else {
	
					if (!file_exists(EK_FOLDER."akreditasyon_bavuru_ekleri/".$evrakId."/".$belge[$setarat[$jj]]."/")){
						mkdir(EK_FOLDER."akreditasyon_bavuru_ekleri/".$evrakId."/".$belge[$setarat[$jj]], 0700,true);
					}
					
					  
					$normalFile = FormFactory::formatFilename ($datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]);
					//$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_bavuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
					$pathh =	EK_FOLDER."akreditasyon_bavuru_ekleri/".$evrakId."/".$belge[$setarat[$jj]]."/" . $normalFile;
					move_uploaded_file($datayeni[dosya][tmp_name][$belge[$setarat[$jj]]][$kkk],$pathh);
	
				}
	
				$belgename = FormFactory::formatFilename($datayeni[dosya][name][$belge[$setarat[$jj]]][$kkk]);
	
				$sql="insert into M_AKREDITASYON_BASVURU_EKLERI
							(EVRAK_ID, USER_ID,BELGE_ADI,TARIH,BELGE_TURU) values
							( ?, ".$user_id.",? , ? , ? )";
				$params=array($evrakId, $belgename, time(),$belge[$setarat[$jj]]);
				$db->prep_exec_insert($sql, $params);
				$success=true;
			}
		}
		return $success;
	}
	
	
	function basvuruOlustur (){
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= T4_SAYI_ID;
    	$basvuru_tip 	= T4_BASVURU_TIP;
    	$basvuru_durum	= ONAYLANMAMIS_BASVURU;
    	
    	$evrak_id = FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		if ($evrak_id != -1)
    		FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
		
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
}
?>