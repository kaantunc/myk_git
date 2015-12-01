<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelTaslak_Kaydet extends JModel {
	
    function taslakKaydet ($data, $layout, $evrak_id, $yeterlilik_id){
		$user = &JFactory::getUser();
				
		if ($evrak_id == -1){
    		$evrak_id 	  = $this->basvuruOlustur();
    		$taslakResult = $this->taslakYeterlilikOlustur ($evrak_id, $yeterlilik_id);
    		
    		if (!$taslakResult)
    			$evrak_id =-2;
    	}
    	
    	$this->dokunulmamissaOntaslagiKaydet($yeterlilik_id);
    	 	
    	if ($evrak_id != -1 && $evrak_id != null){
	    	switch ($layout){
	    		case "tanitim":
	    			$sayfaNum 	 = 1;
	    			$resultT = $this->tanitimKaydet ($data, $yeterlilik_id);
	    			$resultS = $this->uluslararasiStandartKaydet ($data, $yeterlilik_id);
	    			
	    			if ($resultT && $resultS)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;
	    		case "kaynak":
	    			$sayfaNum 	 = 2;
	    			$result = $this->kaynakKaydet ($data, $yeterlilik_id);
	    			
	    			if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;
	    		case "zorunlu":
	    			$sayfaNum 	= 3;
	    			$tur	 	= ZORUNLU_ALT_BIRIM;
	    			$tablo		= "zorunlu_birim";
	    			$message 	= $this->yeterlilikAltBirimKaydet ($data, $yeterlilik_id, $tur, $tablo);
	    			//$resultAck 	= $this->yeterlilikAciklamaKaydet ($data["zorunlu_aciklama"], $yeterlilik_id, $tablo);
	    			
// 	    			if (!$resultAck && $message == JText::_("VERI_KAYDI_BASARILI")){
// 	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
// 	    			}else if (!$resultAck){
// 	    				$message .= JText::_("VERI_KAYDI_BASARISIZ");
// 	    			}

	    			break;
        		case "secmeli":
	    			$sayfaNum 	= 4;
	    			$tur	 	= SECMELI_ALT_BIRIM;
	    			$tablo		= "secmeli_birim";
	    			$message 	= $this->yeterlilikAltBirimKaydet ($data, $yeterlilik_id, $tur, $tablo);
	    			$resultAlt  = $this->alternatifKaydet ($data["alternatif"], $yeterlilik_id);
	    			$resultAck	= $this->yeterlilikAciklamaKaydet($data["secmeli_aciklama"], $yeterlilik_id, $tablo);
	    			
	    			if ((!$resultAlt || !resultAck) && $message == JText::_("VERI_KAYDI_BASARILI")){
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			}else if (!$resultAlt || !resultAck){
	    				$message .= JText::_("VERI_KAYDI_BASARISIZ");
	    			}
	    				
	    			break;
        		case "sart":
	    			$sayfaNum 	 = 5;
	    			$result = $this->sartKaydet ($data, $yeterlilik_id);

	    			if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;
	    		case "bilgi":
	    			$sayfaNum 	 = 6;
	    			$tip 		 = YETERLILIK_BILGI;
	    			$tableName 	 = "bilgi";
	    			$message 	 = $this->beceriYetkinlikKaydet ($data, $yeterlilik_id,  $tip, $tableName);
       			
	    			break;		
	    		case "beceri":
	    			$sayfaNum 	 = 7;
        			$tip 		 = YETERLILIK_BECERI;
        			$tableName 	 = "beceri";
	    			$message 	 = $this->beceriYetkinlikKaydet ($data, $yeterlilik_id,  $tip, $tableName);
	    			break;		
	    		case "yetkinlik":
	    			$sayfaNum 	 = 8;
        			$tip 		 = YETERLILIK_YETKINLIK;
        			$tableName 	 = "yetkinlik";
	    			$message 	 = $this->beceriYetkinlikKaydet ($data, $yeterlilik_id, $tip, $tableName);
	    			break;		
	    		case "sinav_bilgi":
	    			$sayfaNum 	 = 9;
	    			$message = $this->degerlendirmeKaydet ($data, $yeterlilik_id);
	    			$resultO = $this->olcutKaydet ($data, $yeterlilik_id);
	    			
//        			if (!$resultO)
//	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;		
	    		case "aciklama_son":
	    			$sayfaNum 	 = 10;
	    			$resultA = $this->aciklamaKaydet ($data, $yeterlilik_id);
	    			$resultK =$this->kurulusKaydet ($data, $yeterlilik_id, YET_GELISTIREN_KURULUS);
	    			
            		if ($resultA && $resultK)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;		
	    		case "ek_terim":
	    			$sayfaNum 	= 11;
	    			$tablo		= "ek_terim";
	    			$result 	= $this->terimKaydet ($data, $yeterlilik_id);
	    			$resultAck	= $this->yeterlilikAciklamaKaydet($data["terim_aciklama"], $yeterlilik_id, $tablo);
	    			
            		if ($result && $resultAck)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;		
	    		case "ek_birim":
	    			$sayfaNum 	 = 12;
	    			
	    			$result 	 = $this->altBirimBeceriYetkinlikKaydet ($data,$yeterlilik_id);
// 	    			$tableNames	 = array ("bilgi", "beceri", "yetkinlik");
//             		$tip 		 = YETERLILIK_BILGI;
// 	    			$resultBilgi = $this->altBirimBeceriYetkinlikKaydet ($data,$yeterlilik_id, $tip, $tableNames[0]);
//             		$tip 		 = YETERLILIK_BECERI;
// 	    			$resultBeceri= $this->altBirimBeceriYetkinlikKaydet ($data,$yeterlilik_id, $tip, $tableNames[1]);
//             		$tip 		 = YETERLILIK_YETKINLIK;
// 	    			$resultYet 	 = $this->altBirimBeceriYetkinlikKaydet ($data,$yeterlilik_id, $tip, $tableNames[2]);
	    			
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;
        		case "ek_degerlendirme":
	    			$sayfaNum 	 = 13;

	    			$tableName	 = "degerlendirme";
	    			$result = $this->degerlendirmeOgrenmeCiktisiKaydet ($data,$yeterlilik_id, $tableName);
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_katki":
	    			$sayfaNum 	 = 14;

	    			$result =$this->kurulusKaydet ($data, $yeterlilik_id, YET_KATKI_SAGLAYAN_KURULUS);
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_kurulus":
	    			$sayfaNum 	 = 15;

	    			$result =$this->kurulusKaydet ($data, $yeterlilik_id, YET_GORUSE_GONDERILEN_KURULUS);
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_7":
	    			$sayfaNum 	 = 16;
	    			
	    			$tableName = "ekler";
	    			$result = FormFactory::basvuruEkleriKaydet($evrak_id, $tableName, $data, 1);    			
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_8":
	    			$sayfaNum 	 = 17;
					
	    			$tableName = "ekler";
	    			$result = $this->ekAciklamaKaydet ($data["aciklama"], $yeterlilik_id);
                	
					if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;	
        		case "alternatif":
        			$sayfaNum = 18;
        			if(isset($data['delete']) && $data['delete'] == 1){
        				$result = $this->DeleteAlternatif($data);
        				if ($result)
        					$message = JText::_("VERI_KAYDI_BASARILI");
        				else
        					$message = JText::_("VERI_KAYDI_BASARISIZ");
        			}
        			else if(isset($data['upGun']) && $data['upGun'] == 1){
        				$result = $this->GuncelleAlternatif($data,$yeterlilik_id);
        				if ($result)
        					$message = JText::_("VERI_KAYDI_BASARILI");
        				else
        					$message = JText::_("VERI_KAYDI_BASARISIZ");
        			}
        			else{
        				$result = $this->KaydetAlternatif($data,$yeterlilik_id);
        				if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    				else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
        			}
        			break;
	    	}
	    	
	    	if ($message == JText::_("VERI_KAYDI_BASARILI"))
    			$this->insertSavedPage ($sayfaNum, $evrak_id, $user->id, YT2_BASVURU_TIP, $yeterlilik_id);
		    	$this->updateDurum_Kaydedilmemisten_OnayaYollanmamisa($yeterlilik_id);
    	}
    	else{
    		return JText::_("BASVURU_KAYDI_BASARISIZ");
    	}
    	
    	return $message;
    }
    
	function yorumKaydet_SS ($post, $evrak_id, $layout){
		$db = &JFactory::getOracleDBO();
		
		$sql= 'DELETE FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ?
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.'
		AND SS_YORUMU_MU = 1 AND LAYOUT = ?';
		$params = array ($_GET['yeterlilik_id'], $layout);
		$data = $db->prep_exec($sql, $params);
		
		
		$sql= 'INSERT INTO m_taslak_yorum 
				(STD_VEYA_YET_ID,TASLAK_TIPI, SS_YORUMU_MU, LAYOUT, YORUM) 
		VALUES  (?, '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.', 1, ?, ?)';
		$params = array ($_GET['yeterlilik_id'], $layout, $post['yorum']);
		$sonuc = $db->prep_exec_insert($sql, $params);
		
		return $sonuc;
	}
	
	function yorumKaydet_Kurulus ($post, $evrak_id, $layout){
		$db = &JFactory::getOracleDBO();
	
		$sql= 'DELETE FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ?
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.'
		AND SS_YORUMU_MU = 0 AND LAYOUT = ?';
		$params = array ($_GET['yeterlilik_id'], $layout);
		$data = $db->prep_exec($sql, $params);
	
	
		$sql= 'INSERT INTO m_taslak_yorum
		(STD_VEYA_YET_ID,TASLAK_TIPI, SS_YORUMU_MU, LAYOUT, YORUM)
		VALUES  (?, '.PM_TASLAK_YORUM_TIPI__YETERLILIK_YORUMU.', 0, ?, ?)';
		$params = array ($_GET['yeterlilik_id'], $layout, $post['yorum']);
		$sonuc = $db->prep_exec_insert($sql, $params);
	
		return $sonuc;
	}
	
	function yorumlariGonder ($evrak_id){
		$this->clearPreviousYorum_SS ($evrak_id);
		$this->updateYorumDurum_SS ($evrak_id, 0);
	}
	
	function sektorSorumlusunaGonder ($yeterlilik_id){
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK);
		$this->updateEditable($yeterlilik_id, 0);
	}
	
	function onBasvuruOnayla ($yeterlilik_id){
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK);
	}
	
	function onBasvuruBitir ($evrak_id , $yeterlilik_id){
		$this->updateBasvuruDurum ($evrak_id, IMZA_BEKLENEN_BASVURU);
		$this->updateYeterlilikSurecDurum($yeterlilik_id, IMZA_BEKLENEN_YETERLILIK);
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__TASLAK);
		$this->updateEditable ($yeterlilik_id, 0);
		$this->clearSavedPages ($evrak_id);
		//$this->clearSavedYorum_SS ($evrak_id);
	}

	function tanitimKaydet ($data, $yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
    	    	
    	//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik 
				SET yeterlilik_amac = ?
				WHERE yeterlilik_id = ?";
			         
		$params = array($data["amac"],
						$yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function uluslararasiStandartKaydet ($data, $yeterlilik_id){
		$result = $this->uluslararasiStandartlariSil ($yeterlilik_id);
		
		$tableName = "standart";
		$standart 	   = $data["input".$tableName."-2"];
		$standart_ack  = $data["input".$tableName."-3"];
		
		for ($i = 0; $result && $i < count ($standart); $i++){
    		$standart_ad 		= $standart[$i];
    		$standart_aciklama	= $standart_ack [$i];
    		$result = $this->uluslararasiStandartEkle ($yeterlilik_id, $standart_ad, $standart_aciklama);
    	}
    	
    	return $result;
	}
	
	function uluslararasiStandartlariSil ($yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_ulus_standart 
				WHERE yeterlilik_id = ?";
			         
		$params = array($yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function uluslararasiStandartEkle ($yeterlilik_id, $standart_ad, $standart_aciklama){
 		$_db  = & JFactory::getOracleDBO();
 		
 		$standart_id = $_db->getNextVal (YET_STANDART_SEQ);
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_ulus_standart 
				values(?, ?, ?, ?)";
			         
		$params = array($standart_id, 
						$yeterlilik_id, 
						$standart_ad, 
						$standart_aciklama);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function alternatifKaydet ($alternatif, $yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
    	    	
    	//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik 
				SET yeterlilik_grup_alternatif = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($alternatif, $yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}

	function yeterlilikAciklamaKaydet($aciklama, $yeterlilik_id, $tur){
		$_db  = & JFactory::getOracleDBO();

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
	
	function sartKaydet ($data, $yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
    	    	
    	//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik 
				SET yeterlilik_egitim_sekil = ?,
					yeterlilik_egitim_icerik = ?,
					yeterlilik_egitim_sure = ?,
					yeterlilik_deneyim_nitelik = ?,
					yeterlilik_deneyim_sure = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($data["sekil"],
						$data["icerik"],
						$data["egitim_sure"],
						$data["nitelik"],
						$data["deneyim_sure"],
						$yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}

	function olcutKaydet ($data, $yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
    	    	
    	//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik 
				SET yeterlilik_diger = ?,
					yeterlilik_degerlendirici = ?,
					yeterlilik_ortam = ?  
				WHERE yeterlilik_id = ?";
			         
		$params = array($data["sinav_kosul"],
						$data["olcut"],
						$data["ortam"],
						$yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikAltBirimKaydet ($data, $yeterlilik_id, $tur, $tableName){
		$_db  = & JFactory::getOracleDBO();
		
		$birimSira 	 = $data["input".$tableName."-1"];
		$birimKredi = $data["input".$tableName."-2"];
		$birimAd	 = $data["input".$tableName."-3"];
		$rowCount 	 = count ($birimSira);

		if ($tur == ZORUNLU_ALT_BIRIM) {
			$siraHarf = "A";
			foreach ($birimKredi as $key=>$index){
				$birimKredi[$key]="";
			}
		} else {
			$siraHarf = "B";
		}
			
// 		$inpTablo 	= "tablo_".$tableName."_";
// 		$tabloId	= $tableName."_";
		
// 		$updated = 0;
// 		for ($i = 1; isset ($data[$tabloId.$i]); $i++){
// 			$inpName 	 	= $inpTablo.$i;
// 			$alt_birim_id 	= $data[$tabloId.$i];
// 			if (isset ($data[$inpName])){ // GUNCELLE
//     			$id 			 = $updated;
//     			$alt_birim_no  	 = $siraHarf.$birimSira[$id];
//     			$alt_birim_adi 	 = $birimAd[$id];
//     			$alt_birim_kredi = $birimKredi[$id];
//     			if (!$this->yeterlilikAltBirimGuncelle ($alt_birim_id, $alt_birim_no, $alt_birim_adi, $alt_birim_kredi)) //4
//     				return JText::_("ALT_BIRIM_GUNCELLE_HATA");
    				 
//     			$updated++;
// 			}else {				   // SIL
//    				if (!$this->yeterlilikAltBirimSil ($alt_birim_id, $tur))
//     				return JText::_("ALT_BIRIM_SIL_HATA");
// 			}
// 		}

		$sqlBirim = "SELECT * FROM m_yeterlilik_alt_birim WHERE YETERLILIK_ID=? AND YETERLILIK_ZORUNLU=?";
		$count = $_db->prep_exec($sqlBirim, array($yeterlilik_id,$tur));
		$count = count($count);
		
		$sira = $siraHarf.($count+1);
		
		if($this->yeterlilikAltBirimEkle($yeterlilik_id,$tur, $sira, $data['zbirim'])){
			return JText::_("VERI_KAYDI_BASARILI");
		}
		else{
			return JText::_("ALT_BIRIM_EKLE_HATA");
		}
		
		// GERISINI EKLE
// 		for ($j = 0; isset ($data["input".$tableName."-1"][($updated+$j)]); $j++){
// 			$id = $updated+$j;
//         	$alt_birim_no  	 = $siraHarf.$birimSira[$id];
//     		$alt_birim_adi 	 = $birimAd[$id];
//     		$alt_birim_kredi = $birimKredi[$id];
// 	    	if (!$this->yeterlilikAltBirimEkle ($yeterlilik_id, $tur, $alt_birim_no, $alt_birim_adi, $alt_birim_kredi))
// 	    		return JText::_("ALT_BIRIM_EKLE_HATA");
// 		}	

//     	return JText::_("VERI_KAYDI_BASARILI");
	}
		
	function tumYeterlilikAltBirimSil ($yeterlilik_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_alt_birim 
				WHERE yeterlilik_id = ? AND yeterlilik_zorunlu = ?";
			         
		$params = array($yeterlilik_id, $tur);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikAltBirimSil ($alt_birim_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_alt_birim 
				WHERE yeterlilik_alt_birim_id = ? AND yeterlilik_zorunlu = ?";
			         
		$params = array($alt_birim_id, $tur);

		return $_db->prep_exec_insert($sql, $params);
	}

	function yeterlilikAltBirimEkle ($yeterlilik_id, $tur, $alt_birim_no, $alt_birim_adi){
 		$_db  = & JFactory::getOracleDBO();

 		$alt_birim_id	 = $_db->getNextVal (YETERLILIK_ALT_BIRIM_SEQ);
 		$alt_birim_kodu	 = null;
 		$alt_birim_kredi = null;
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_alt_birim  
				values (?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($yeterlilik_id, 
						$alt_birim_id,
						$alt_birim_no,
						$alt_birim_adi,
						$alt_birim_kodu,
						$alt_birim_kredi,
						$tur);

		return $_db->prep_exec_insert($sql, $params);
	}

	function yeterlilikAltBirimGuncelle ($alt_birim_id, $alt_birim_no, $alt_birim_adi, $alt_birim_kredi){
 		$_db  = & JFactory::getOracleDBO();

    	//Prepare sql statement
		$sql = "UPDATE m_yeterlilik_alt_birim  
					SET yeterlilik_alt_birim_no = ?,
						yeterlilik_alt_birim_adi = ?,
						yeterlilik_alt_birim_kredi = ?
				WHERE yeterlilik_alt_birim_id = ?";
			         
		$params = array($alt_birim_no,
						$alt_birim_adi,
						$alt_birim_kredi,
						$alt_birim_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function degerlendirmeKaydet ($data, $yeterlilik_id){
		$colCount	 = 5;
		//TEORIK
		$tableName   = "teorik";
		$tur		 = TEORIK_OLCME_ARAC_TUR;
		$tableValues = FormFactory::getTableValues($data, array ($tableName, $colCount));
		$rowCount	 = count ($tableValues)/$colCount;

    	$message = $this->degerlendirmeAraciKaydet ($data, $tableValues, $yeterlilik_id, $tur, $tableName, $rowCount, $colCount);
		
    	//PERFORMANS
		$tableName   = "performans";
		$tur		 = PERFORMANS_OLCME_ARAC_TUR;
		$tableValues = FormFactory::getTableValues($data, array ($tableName, $colCount));
		$rowCount	 = count ($tableValues)/$colCount;
    	
    	$messageP = $this->degerlendirmeAraciKaydet ($data, $tableValues, $yeterlilik_id, $tur, $tableName, $rowCount, $colCount);

    	if ($message == $messageP)
    		return $message;
    	else
    		return $message." <br />".$messageP;
	}
	
	function degerlendirmeAraciKaydet ($data, $tableValues, $yeterlilik_id, $tur, $tableName, $rowCount, $colCount){
		$this->degerlendirmeleriSil ($yeterlilik_id, $tur);
		
		// HEPSINI EKLE
		for ($j = 0; isset ($data["input".$tableName."-1"][($updated+$j)]); $j++){
			$id = ($updated+$j) * $colCount;
	    	if (!$this->degerlendirmeEkle ($id, $tableValues, $yeterlilik_id, $tur))
	    		return JText::_("DEGERLENDIRME_EKLE_HATA");
		}

    	return JText::_("VERI_KAYDI_BASARILI");
	}

	function degerlendirmeEkle ($id, $tableValues, $yeterlilik_id, $tur){
 		$_db  = & JFactory::getOracleDBO();

 		$degerlendirme_arac_id = $_db->getNextVal (DEGERLENDIRME_ARAC_SEQ);
 		$arac 			= $tableValues[$id];
 		$materyal 		= $tableValues[$id+1];
 		$puanlama 		= $tableValues[$id+2];
 		$basari_olcut 	= $tableValues[$id+3];
 		$diger 			= $tableValues[$id+4];
    	//Prepare sql statement
		$sql = "INSERT INTO m_yet_degerlendirme_arac 
				values (?, ?, ?, ?, ?, ?, ?, ?)";
			         
		$params = array($degerlendirme_arac_id,
						$yeterlilik_id,
						$arac,
						$materyal,
						$puanlama,
						$basari_olcut,
						$diger,
						$tur);
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function degerlendirmeGuncelle ($id, $tableValues, $degerlendirme_arac_id){
 		$_db  = & JFactory::getOracleDBO();

 		$arac 			= $tableValues[$id];
 		$materyal 		= $tableValues[$id+1];
 		$puanlama 		= $tableValues[$id+2];
 		$basari_olcut 	= $tableValues[$id+3];
 		$diger 			= $tableValues[$id+4];
    	//Prepare sql statement
		$sql = "UPDATE m_yet_degerlendirme_arac 
				SET DEGERLENDIRME_ARAC_ADI = ?,
					DEGERLENDIRME_MATERYAL = ?, 
					DEGERLENDIRME_PUANLAMA = ?, 
					DEGERLENDIRME_BASARI_OLCUT = ?, 
					DEGERLENDIRME_DIGER = ? 
				WHERE degerlendirme_arac_id = ?";
			         
		$params = array($arac,
						$materyal,
						$puanlama,
						$basari_olcut,
						$diger,
						$degerlendirme_arac_id);
						
		return $_db->prep_exec_insert($sql, $params);
	}
    
	function degerlendirmeleriSil ($yeterlilik_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yet_degerlendirme_arac 
				WHERE yeterlilik_id = ? AND DEGERLENDIRME_TUR_ID = ?";
			         
		$params = array($yeterlilik_id, $tur);

		return $_db->prep_exec_insert($sql, $params);
	}

	function degerlendirmeSil ($degerlendirme_arac_id){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yet_degerlendirme_arac 
				WHERE degerlendirme_arac_id = ?";
			         
		$params = array($degerlendirme_arac_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function aciklamaKaydet ($data, $yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();

    	//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik 
				SET yeterlilik_gecerlilik_sure = ?,
					yeterlilik_method_gozetim = ?, 
					yeterlilik_deg_yontem = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($data["gecerlilik_sure"],
						$data["metod_gozetim"],
						$data["degerlendirme_yontem"],
						$yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function kurulusKaydet ($data, $yeterlilik_id, $tur){
		$result = $this->kuruluslariSil ($yeterlilik_id, $tur);
		
		$kurulus 	 = $data["inputkurulus-2"];		
		for ($i = 0; $result && $i < count($kurulus); $i++){
			$kurulus_adi = $kurulus[$i];
			$result = $this->kurulusEkle ($yeterlilik_id, $kurulus_adi, $tur);
		}
		
		return $result;
	}
	
	function kuruluslariSil ($yeterlilik_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_kurulus  
				WHERE yeterlilik_id = ? AND yeterlilik_kurulus_tipi = ?";
			         
		$params = array($yeterlilik_id, $tur);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function kurulusEkle ($yeterlilik_id, $kurulus_adi, $tur){
		$_db  = & JFactory::getOracleDBO();
		
		$kurulus_id = $_db->getNextVal (YETERLILIK_KURULUS_SEQ);
 		
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_kurulus (YETERLILIK_KURULUS_ID,YETERLILIK_ID,YETERLILIK_KURULUS_ADI,YETERLILIK_KURULUS_TIPI)  
				values (?, ?, ?, ?)";
			         
		$params = array($kurulus_id, 
						$yeterlilik_id, 
						$kurulus_adi,
						$tur);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function beceriYetkinlikKaydet ($data, $yeterlilik_id, $tip,  $tableName){
//     	$result = $this->beceriYetkinlikleriSil ($yeterlilik_id, $tip);
// 		$beceri_yetkinlik_adlar = $data["input".$tableName."-2"];
		
		$list = explode("\n",$data['bilgi']);
		
		foreach ($list as $row){
			if(!$this->beceriYetkinlikEkle ($row, $yeterlilik_id, $tip)){
				return JText::_("BECERI_YETKINLIK_EKLE_HATA");
			}
		}
		
		
// 		for ($i = 0; $result && $i < count ($beceri_yetkinlik_adlar); $i++){
//     		$beceri_yetkinlik_ad = $beceri_yetkinlik_adlar[$i];
//    		if (!$this->beceriYetkinlikEkle ($beceri_yetkinlik_ad, $yeterlilik_id, $tip))
// 	    		return JText::_("BECERI_YETKINLIK_EKLE_HATA");
//    		}
    	
    	return JText::_("VERI_KAYDI_BASARILI");
	}
	
	function beceriYetkinlikleriSil ($yeterlilik_id, $tip){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeter_beceri_yetkinlik 
				WHERE yeterlilik_id = ? AND beceri_yetkinlik_tipi = ?";
			         
		$params = array($yeterlilik_id, $tip);

		return $_db->prep_exec_insert($sql, $params);
	}

	function beceriYetkinlikGuncelle ($beceri_yetkinlik_id, $beceri_yetkinlik_ad){
 		$_db  = & JFactory::getOracleDBO();

    	//Prepare sql statement
		$sql = "UPDATE m_yeter_beceri_yetkinlik 
				SET beceri_yetkinlik_adi = ? 
				WHERE beceri_yetkinlik_id = ?";
			         
		$params = array($beceri_yetkinlik_ad,
						$beceri_yetkinlik_id);
						
		return $_db->prep_exec_insert($sql, $params);
	}

	function beceriYetkinlikSil ($beceri_yetkinlik_id){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeter_beceri_yetkinlik 
				WHERE beceri_yetkinlik_id = ?";
			         
		$params = array($beceri_yetkinlik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function beceriYetkinlikEkle ($beceri_yetkinlik_ad, $yeterlilik_id, $tip){
 		$_db  = & JFactory::getOracleDBO();

 		$beceri_yetkinlik_id  = $_db->getNextVal (BECERI_YETKINLIK_SEQ);
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeter_beceri_yetkinlik 
				values (?, ?, ?, ?)";
			         
		$params = array($yeterlilik_id,
						$beceri_yetkinlik_id,						
						$beceri_yetkinlik_ad,
						$tip);
		
		echo '<pre>';
		print_r($params);
		echo "</pre>";
								
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function kaynakKaydet ($data, $yeterlilik_id){
		$result = $this->kaynaklariSil ($yeterlilik_id);
		
		//KAYNAK MESLEK STANDARDI
		$tableName 		= "kaynak_meslek";
		$tur			= KAYNAK_STANDART_TUR;
		$kaynak_meslek 	= $data["input".$tableName."-3"];
		$kaynak_acikla	= $data["input".$tableName."-4"];
		
		for ($i = 0; $result && $i < count ($kaynak_meslek); $i++){
			$kaynak_id  	 = $kaynak_meslek[$i];
			$kaynak_aciklama = $kaynak_acikla[$i];
			$result = $this->kaynakEkle ($yeterlilik_id, $kaynak_id, $kaynak_aciklama, $tur);
		}
		
		//KAYNAK YETERLILIK ALT BIRIM
		$tableName 		= "kaynak_birim";
		$tur			= KAYNAK_YETERLILIK_TUR;
		$kaynak_birim 	= $data["input".$tableName."-2"];
		$kaynak_acikla	= $data["input".$tableName."-3"];
		
		for ($i = 0; $result && $i < count ($kaynak_birim); $i++){
			$kaynak_id  	 = $kaynak_birim[$i];
			$kaynak_aciklama = $kaynak_acikla[$i];
			$result = $this->kaynakEkle ($yeterlilik_id, $kaynak_id, $kaynak_aciklama, $tur);
		}
		
		return $result;
	}
	
	function kaynaklariSil ($yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_kaynak 
				WHERE yeterlilik_id = ?";
			         
		$params = array($yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function kaynakEkle ($yeterlilik_id, $kaynak_id, $kaynak_adi, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_kaynak 
				values(?, ?, ?, ?)";
			         
		$params = array($kaynak_id, 
						$yeterlilik_id, 
						$kaynak_adi, 
						$tur);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function terimKaydet ($data, $yeterlilik_id){
		$result = $this->terimleriSil ($yeterlilik_id);
		
		$tableName = "terimKisaltma";
		$terim 	   = $data["input".$tableName."-2"];
		$terim_ack = $data["input".$tableName."-3"];
		
		for ($i = 0; $result && $i < count ($terim); $i++){
    		$terim_ad 		= $terim[$i];
    		$terim_aciklama	= $terim_ack [$i];
    		$result = $this->terimEkle ($yeterlilik_id, $terim_ad, $terim_aciklama);
    	}
    	
    	return $result;
	}
	
	function terimleriSil ($yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_terim 
				WHERE yeterlilik_id = ?";
			         
		$params = array($yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function terimEkle ($yeterlilik_id, $terim_ad, $terim_aciklama){
 		$_db  = & JFactory::getOracleDBO();
 		
 		$terim_id = $_db->getNextVal(YET_TERIM_SEQ);
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_terim 
				values(?, ?, ?, ?)";
			         
		$params = array($terim_id, 
						$yeterlilik_id, 
						$terim_ad, 
						$terim_aciklama);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function altBirimBeceriYetkinlikKaydet ($data, $yeterlilik_id){
		
		$tip = $data['tip'];
		$birim = $data['birim'];
		$bilgiler = $data['bilgi'];
		
		foreach ($bilgiler as $row){
			if(!$this->altBirimBeceriYetkinlikVarmi($row, $birim, $yeterlilik_id, $tip)){
			$result = $this->altBirimBeceriYetkinlikEkle ($row, $birim, $yeterlilik_id, $tip);
			}
		}
    	
    	return $result;
	}
	
	function altBirimBeceriYetkinlikVarmi($row, $birim, $yeterlilik_id, $tip){
		$_db  = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM m_yet_birim_beceri_yetkinlik WHERE BECERI_YETKINLIK_ID=? AND YETERLILIK_ALT_BIRIM_ID=?
				AND YETERLILIK_ID=? AND BECERI_YETKINLIK_TIPI=?";
		return $_db->prep_exec($sql, array($row,$birim,$yeterlilik_id,$tip));
	}
	
	function altBirimBeceriYetkinlikleriSil ($yeterlilik_id, $tip){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yet_birim_beceri_yetkinlik 
				WHERE yeterlilik_id = ? AND beceri_yetkinlik_tipi = ?";
			         
		$params = array($yeterlilik_id, $tip);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function altBirimBeceriYetkinlikEkle ($beceri_yetkinlik_id, $alt_birim_id, $yeterlilik_id, $tip){
 		$_db  = & JFactory::getOracleDBO();

    	//Prepare sql statement
		$sql = "INSERT INTO m_yet_birim_beceri_yetkinlik  
				values ( ?, ?, ?, ?)";
		
		$params = array($beceri_yetkinlik_id,
						$alt_birim_id,
						$yeterlilik_id,
						$tip);
		echo $params[0]." - ".$params[1]." - ".$params[2]." - ".$params[3]." - "."<br>";				
		
		echo '<pre>';
		print_r($params);
		echo "</pre>";
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function krediDegeriKaydet ($data, $yeterlilik_id, $tableNames){
		for ($i = 0; $i < count($tableNames); $i++){
			$alt_birim_ids 	  = $data["input".$tableNames[$i]."-2"];
			$kredi			  = $data["input".$tableNames[$i]."-3"];
			
			for ($j = 0; $j < count($alt_birim_ids); $j++){
				$this->krediDegeriEkle ($alt_birim_ids[$j], $kredi[$j]);
			}
		}
	}
	
	function krediDegeriEkle ($alt_birim_id, $kredi ){
 		$_db  = & JFactory::getOracleDBO();

    	//Prepare sql statement
		$sql = "UPDATE m_yeterlilik_alt_birim 
					SET yeterlilik_alt_birim_kredi = ?  
				WHERE yeterlilik_alt_birim_id = ?";
			         
		$params = array($kredi,	$alt_birim_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function degerlendirmeOgrenmeCiktisiKaydet ($data, $yeterlilik_id, $tableName){
		$colCount	 = 2;
		$result = $this->degerlendirmeOgrenmeCiktisiSil ($yeterlilik_id);

		$tableName   = "degerlendirme";
		$tableValues = FormFactory::getTableValues($data, array ($tableName, $colCount));

		$rowCount	 = count ($tableValues)/$colCount;

    	for ($i = 0; $result && $i < $rowCount; $i++){
    		$id = $colCount*$i;
    		$result = $this->degerlendirmeOgrenmeCiktisiEkle ($id, $tableValues);
    	}
    	
    	return $result;
	}
	
	function degerlendirmeOgrenmeCiktisiSil ($yeterlilik_id){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yet_degerlendirme_ogrenme  
				WHERE degerlendirme_arac_id IN (SELECT degerlendirme_arac_id 
												FROM m_yet_degerlendirme_arac 
												WHERE yeterlilik_id = ?)";
			         
		$params = array($yeterlilik_id);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function degerlendirmeOgrenmeCiktisiEkle ($id, $tableValues){
 		$_db  = & JFactory::getOracleDBO();

 		$degerlendirme_id = $tableValues[$id];
 		$ogrenme_id 	  = $tableValues[$id+1];

    	//Prepare sql statement
		$sql = "INSERT INTO m_yet_degerlendirme_ogrenme 
				values (?, ?)";
			         
		$params = array($degerlendirme_id, $ogrenme_id);
						
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function ekAciklamaKaydet ($aciklama, $yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik  
					SET YETERLILIK_EK_ACIKLAMA = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($aciklama, $yeterlilik_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function basvuruOlustur() {
		$_db =& JFactory::getOracleDBO();
		
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= YT2_SAYI_ID;
    	$basvuru_tip 	= YT2_BASVURU_TIP;
    	$basvuru_durum	= KAYDEDILMEMIS_BASVURU;
    	
    	$evrak_id = $_db->getNextVal(EVRAK_SEQ);//FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_TASLAK_ADAYI_SEKLI_ID);
    	if ($evrak_id != -1)
			FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
	
    	return $evrak_id;
    }
    
    function taslakYeterlilikOlustur ($evrak_id, $yeterlilik_id){
		$_db =& JFactory::getOracleDBO();

		$rev_no = '00';
		//Prepare sql statement
		$sql = "INSERT INTO m_taslak_yeterlilik  
				(evrak_id, yeterlilik_id, revizyon_no , editable) 
				values(?, ?, ?, 1)";
			         
		$params = array($evrak_id, $yeterlilik_id, $rev_no);
	
		return $_db->prep_exec_insert($sql, $params);
    }
    
    function dokunulmamissaOntaslagiKaydet($yeterlilik_id)
    {
    	$_db  = & JFactory::getOracleDBO();
    
    	$sql = "Select yeterlilik_durum_id FROM m_yeterlilik WHERE yeterlilik_id = ?";
    	$params = array($yeterlilik_id);
    	$result = $_db->prep_exec($sql, $params);
    
    	if(	$result[0]["yeterlilik_durum_id"]== PM_YETERLILIK_DURUMU__OLUSTURULMAMIS_ONTASLAK )
    	{
    		$sql = "UPDATE m_yeterlilik SET yeterlilik_durum_id = ?";
    		$params = array(PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK);
    		return $_db->prep_exec_insert($sql, $params);
    	}
    	else
    		return false;
    }
    	
	function updateYorumDurum_SS ($evrak_id, $yorum_durum){
		$db  = &JFactory::getDBO ();
		$sql = "UPDATE #__taslak_yorum 
				SET yorum_durum = ".$yorum_durum."	
				WHERE evrak_id = ".$evrak_id." AND  ss_yorumu_mu = 1";

		return $db->Execute ($sql);
	}
	
	function updateBasvuruDurum ($evrak_id, $durum_id){
		$_db  = & JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "UPDATE m_basvuru 
				SET basvuru_durum_id = ? 
				WHERE evrak_id = ?";
			         
		$params = array($durum_id, $evrak_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function updateYeterlilikSurecDurum ($yeterlilik_id, $durum_id){
		$_db  = & JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "UPDATE m_yeterlilik  
				SET YETERLILIK_SUREC_DURUM_id = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($durum_id, $yeterlilik_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	function updateYeterlilikDurum ($yeterlilik_id, $durum_id){
		$_db  = & JFactory::getOracleDBO();
	
		//Prepare sql statement
		$sql = "UPDATE m_yeterlilik
					SET YETERLILIK_DURUM_id = ? 
					WHERE yeterlilik_id = ?";
	
		$params = array($durum_id, $yeterlilik_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	function updateEditable ($yeterlilik_id, $editable){
		$_db =& JFactory::getOracleDBO();
		
		$sql = "UPDATE m_taslak_yeterlilik  
				SET editable = ? 
				WHERE yeterlilik_id = ?";
		
		$params = array($editable,	$yeterlilik_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function clearPreviousYorum_SS ($evrak_id){
		$db = &JFactory::getDBO();
		$sayfalar = $this->getGonderilmemisYorumSayfa_SS ($evrak_id);
		
		if (count ($sayfalar) > 0 ){
			$sql= "	DELETE FROM #__taslak_yorum  
					WHERE evrak_id = ".$evrak_id." AND  ss_yorumu_mu = 1 AND 
						  yorum_durum = 0 ";
			
			for ($i = 0; $i < count ($sayfalar); $i++){
				$sql .= " AND sayfa = ".$sayfalar[$i];
			}
		}	
		
		return $db->Execute ($sql);
	}
	
	function getGonderilmemisYorumSayfa_SS ($evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	SELECT sayfa 
				FROM #__taslak_yorum 
				WHERE yorum_durum = -1 AND  ss_yorumu_mu = 1 AND evrak_id = ".$evrak_id;
		
		$db->setQuery($sql);
		$data = $db->loadRow();
		
		return $data;		
	}
    
	function insertSavedPage ($pageNum, $evrak_id, $juser_id, $basvuru_tur, $form_id){
		$db = &JFactory::getDBO();
		
		$sql= "	REPLACE INTO #__user_evrak (user_id, evrak_id, basvuru_tur, saved_page, form_id) 
				VALUES (".$juser_id.", ".$evrak_id.",".$basvuru_tur.", ".$pageNum.", ".$form_id.")";
		
		return $db->Execute ($sql);
	}
	
	function clearSavedPages ($evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	DELETE FROM #__user_evrak  
				WHERE evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function clearSavedYorum_SS ($evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	DELETE FROM #__taslak_yorum  
				WHERE  ss_yorumu_mu = 1 AND  evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function getSayfa ($layout){
		$pages 	= array ("tanitim", "kaynak", "zorunlu", "secmeli", "sart", "bilgi", "beceri", "yetkinlik", "sinav_bilgi", "aciklama_son", "ek_terim", "ek_birim");
		
		for ($i = 0; $i < count($pages); $i++){
			if ($pages[$i] == $layout)
				break;
		}
		
		return $i+1;
	}
	
	function updateDurum_Kaydedilmemisten_OnayaYollanmamisa($yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();
	
		$sql = "SELECT yeterlilik_durum_id
		FROM m_yeterlilik
		WHERE yeterlilik_id = ?";
	
		$params = array($yeterlilik_id);
		$sonuc =$_db->prep_exec_array($sql, $params);
		if ($sonuc[0]==-3){
			$sql = "UPDATE m_yeterlilik
			SET YETERLILIK_DURUM_id = ?
			WHERE yeterlilik_id = ?";
	
			$params = array(-2, $yeterlilik_id);
			$sonuc2= $_db->prep_exec_insert($sql, $params);
	
		}
		return "Başarılı";
	
	}
	
	function KaydetAlternatif($data,$yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();
		$alterName = $data['altName'];
		$birims = $data['Birims'];
		
		$sql = 'INSERT INTO M_YETERLILIK_ALTERNATIF (YETERLILIK_ID, ALTERNATIF_ADI) VALUES(?,?)';
		$params = array(
			$yeterlilik_id,
			$alterName
		);
		$sonuc = $_db->prep_exec_insert($sql, $params);
		if($sonuc){
			$sql1 = "SELECT ALTERNATIF_ID FROM M_YETERLILIK_ALTERNATIF WHERE YETERLILIK_ID=? AND ALTERNATIF_ADI = ?";
			
			$altId = $_db->prep_exec($sql1, array($yeterlilik_id,$alterName));
		}
		else{
			return false;
		}
		
		foreach ($birims as $cow){
			if(!$this->KaydetAlternatifBirims($altId[0]['ALTERNATIF_ID'],$cow)){
				return false;	
			}
		}
		return true;
	}
	
	function KaydetAlternatifBirims($altId,$birim){
		$_db  = & JFactory::getOracleDBO();
		$sql = 'INSERT INTO M_YETERLILIK_ALTERNATIF_BIRIM (ALTERNATIF_ID, BIRIM_ID) VALUES(?,?)';
		$params = array(
				$altId,
				$birim
		);
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function DeleteAlternatif($data){
		$_db  = & JFactory::getOracleDBO();
		
		$altId = $data['altId'];
		$sql = "DELETE FROM M_YETERLILIK_ALTERNATIF WHERE ALTERNATIF_ID = ?";
		$sonuc = $_db->prep_exec($sql,array($altId));
		if(!$sonuc){	
			$sqlBirims = "DELETE FROM M_YETERLILIK_ALTERNATIF_BIRIM WHERE ALTERNATIF_ID = ?";
			$sonnuc = $_db->prep_exec($sqlBirims,array($altId));
			return $sonnuc;
		}
	}
	
	function GuncelleAlternatif($data,$yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();
		
		$altId = $data['altId'];
		$alterName = $data['altName'];
		$birims = $data['Birims'];
		
		$sql = "UPDATE M_YETERLILIK_ALTERNATIF SET YETERLILIK_ID = ?, ALTERNATIF_ADI = ? WHERE ALTERNATIF_ID = ?";
		$params = array(
				$yeterlilik_id,
				$alterName,
				$altId
		);
		$sonuc = $_db->prep_exec_insert($sql, $params);
		if($sonuc){
			$this->DeleteAlternatifBirims($altId);
		}
		else{
			return false;
		}
		
		foreach ($birims as $cow){
			if(!$this->KaydetAlternatifBirims($altId,$cow)){
				return false;
			}
		}
		return true;
	}
	
	function DeleteAlternatifBirims($altId){
		$_db  = & JFactory::getOracleDBO();
		
		$sqlBirims = "DELETE FROM M_YETERLILIK_ALTERNATIF_BIRIM WHERE ALTERNATIF_ID = ?";
		$sonnuc = $_db->prep_exec($sqlBirims,array($altId));
		return $sonnuc;
	}
}
?>
