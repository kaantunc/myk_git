<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelTaslak_Kaydet extends JModel {
	
    function taslakKaydet ($data, $layout, $evrak_id, $yeterlilik_id){
		$user = &JFactory::getUser();
		
		if ($evrak_id == -1)
		{
    		$evrak_id 	  = $this->basvuruOlustur();
    		$taslakResult = $this->taslakYeterlilikOlustur ($evrak_id, $yeterlilik_id);
    		
    		if (!$taslakResult)
    			$evrak_id =-2;
    	}
    	 	
    	if ($evrak_id != -1 && $evrak_id != null)
    	{
	    	switch ($layout)
	    	{
	    		case "tanitim":
	    			$sayfaNum 	 = 1;
	    			$resultT = $this->tanitimKaydet ($data, $yeterlilik_id);
	    			$resultS = $this->uluslararasiStandartKaydet ($data, $yeterlilik_id);
	    			
	    			if ($resultT && $resultS)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;
	    		case "yeterlilik_kaynagi":
	    			$sayfaNum 	 = 2;
	    			$result = $this->kaynakKaydet ($data, $yeterlilik_id);
	    			
	    			if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;
	    		case "yeterlilik_sartlari":
	    			$sayfaNum 	 = 3;
	    			$result = $this->sartKaydet ($data, $yeterlilik_id);

	    			if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				
	    			break;
	    		case "yeterliligin_yapisi":
	    			$sayfaNum 			= 4;
	    			$tablo				= array ("kaynak_yeterlilik_zorunlu", "kaynak_yeterlilik_secmeli","birimlerin_gruplandirilma","ilave_ogrenme_ciktilari");
	    				
	    			$tur	 			= ZORUNLU_ALT_BIRIM;
	    			//$resultZorunlu 		= $this->yeterlilikAciklamaKaydet ($data["zorunlu_aciklama"], $yeterlilik_id, $tablo[0]);
	    			//$message 			= $this->yeterlilikHariciBirimKaydet ($data, $yeterlilik_id, $tur, $tablo[0]);
	    				
	    				
					$tur	 			= SECMELI_ALT_BIRIM;
					//$resultSecmeli		= $this->yeterlilikAciklamaKaydet($data["secmeli_aciklama"], $yeterlilik_id, $tablo[1]);
					//$message 			= $this->yeterlilikHariciBirimKaydet ($data, $yeterlilik_id, $tur, $tablo[1]);
					
					$tur	 			= BIRIMLERIN_GRUPLANDIRILMA;
					$resultBirimlerin 	= $this->yeterlilikAciklamaKaydet ($data["birimlerin_gruplandirilma"], $yeterlilik_id, $tablo[2]);
					
					$tur	 			= ILAVE_OGRENME_CIKTILARI;
					$resultIlave 		= $this->yeterlilikAciklamaKaydet ($data["ilave_ogrenme_ciktilari"], $yeterlilik_id, $tablo[3]);
					
					
	    			if ($resultBirimlerin && $resultIlave)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;
				case "olcme_ve_degerlendirme":
	    			$sayfaNum 	 = 5;
	    		//	$message = $this->degerlendirmeKaydet ($data, $yeterlilik_id);
	    			$resultO = $this->olcutKaydet ($data, $yeterlilik_id);
	    			
        			if (!$resultO)
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
        			else 
        				$message = JText::_("VERI_KAYDI_BASARILI");
	    				
	    			break;
	    		case "aciklama":
	    			$sayfaNum 	 = 6;
	    			$resultA = $this->aciklamaKaydet ($data, $yeterlilik_id);
	    			$resultK =$this->yeterliligiGelistirenKurulusKaydet ($data, $yeterlilik_id, YET_GELISTIREN_KURULUS);
	    			
            		if ($resultA && $resultK)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;		
	    		case "ek_1":
	    			$sayfaNum 	= 7;
	    			/*$tablo		= "ek_terim";
	    			$resultAck	= $this->yeterlilikAciklamaKaydet($data["terim_aciklama"], $yeterlilik_id, $tablo);
	    			
            		if ($result && $resultAck)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			*/
	    			$message = JText::_("VERI_KAYDI_BASARILI");
	    			break;		
	    		case "ek_2":
	    			$sayfaNum 	= 8;
	    			/*
	    			$result 	= $this->terimKaydet ($data, $yeterlilik_id);
	    			
            		if ($result && $resultAck)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				*/
	    			$tablo		= "ek_terim";
	    			$resultAck	= $this->yeterlilikAciklamaKaydet($data["terim_aciklama"], $yeterlilik_id, $tablo);
	    			
	    			$user = &JFactory::getUser();
	    			$_db  = & JFactory::getOracleDBO();
	    			
	    			$terimId=$data["terimId"];
	    			$sql = "DELETE FROM M_YETERLILIK_TERIM
	    			WHERE yeterlilik_id = ".$yeterlilik_id;
	    			$_db->prep_exec_insert($sql, "");
	    			for ($i=0;$i<count($terimId);$i++){
	    				$sql = "INSERT INTO M_YETERLILIK_TERIM(terim_id, yeterlilik_id)
	    				values (".$terimId[$i].", ".$yeterlilik_id.")";
	    				$_db->prep_exec_insert($sql, "");
	    			}
	    			
	    			for ($i=0;$i<count($data["terimAdi"]);$i++){
	    				$terim_id = $_db->getNextVal (TERIM_SEQ);
	    			
	    				$terim_adi = FormFactory::toUpperCase($data["terimAdi"][$i]);
	    				$terim_aciklama=$data["terimAciklama"][$i];
	    			
	    				//Prepare sql statement
	    				$sql = "INSERT INTO M_TERIM
	    				values (?, ?, ?)";
	    				$params = array($terim_id,
	    						$terim_adi,
	    						$terim_aciklama
	    				);
	    				$_db->prep_exec_insert($sql, $params);
	    			
	    				$sql = "INSERT INTO M_YETERLILIK_TERIM(terim_id, yeterlilik_id)
	    				values (?, ?)";
	    				$params = array($terim_id,
	    						$yeterlilik_id
	    				);
	    			
	    				$_db->prep_exec_insert($sql, $params);
	    			}
	    			
	    			for ($i=0;$i<count($data["terimAdiUp"]);$i++){
	    				$terim_id = $data["terimIdUp"][$i];
	    			
	    				$terim_adi = FormFactory::toUpperCase($data["terimAdiUp"][$i]);
	    				$terim_aciklama=$data["terimAciklamaUp"][$i];
	    			
	    				//Prepare sql statement
	    				$sql = "UPDATE M_TERIM SET TERIM_ADI=?, TERIM_ACIKLAMA=?
                				WHERE TERIM_ID=?";
	    				$params = array(
	    						$terim_adi,
	    						$terim_aciklama,
	    						$terim_id
	    				);
	    				$_db->prep_exec_insert($sql, $params);
	    			}
	    			
	    			$message = JText::_("VERI_KAYDI_BASARILI");
	    			
	    			break;		
	    		case "ek_3":
	    			$sayfaNum 	 = 9;
					$tableName = "meslekte_yatay_dikey";
	    			$result = $this->meslekteYatayDikeyKaydet ($data["meslekte_yatay_dikey"], $yeterlilik_id);
                	
					if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;
				case "ek_4":
	    			$sayfaNum 	 = 10;
					$tableName = "degerlendirici_olcut";
	    			$result = $this->degerlendiriciOlcutKaydet ($data["degerlendirici_olcut"], $yeterlilik_id);
                	
					if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;	
        		case "ek_5":
	    			$sayfaNum 	 = 11;

	    			$result =$this->kurulusKaydet ($data, $yeterlilik_id, YET_KATKI_SAGLAYAN_KURULUS);
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_6":
	    			$sayfaNum 	 = 12;

	    			$result =$this->kurulusKaydet ($data, $yeterlilik_id, YET_GORUSE_GONDERILEN_KURULUS);
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_8":
	    			$sayfaNum 	 = 13;
	    			
	    			$tableName = "ekler";
	    			$result = FormFactory::basvuruEkleriKaydet($evrak_id, $tableName, $data, 2); //2 YETKILENDIRME ICIN   			
                	if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;			
        		case "ek_9":
	    			$sayfaNum 	 = 14;
					
	    			$tableName = "ekler";
	    			$result = $this->ekAciklamaKaydet ($data["aciklama"], $yeterlilik_id);
                	
					if ($result)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;
				case "birimler":
					
	    			$sayfaNum 			= 15;
	    			$tablo				= array ("zorunlu_birim", "secmeli_birim");
					
	    			$this->clearPreviousBirimler($yeterlilik_id);
	    			
					$message 			= $this->yeterlilikBirimleriniKaydet();
					if ($message)
						$message = JText::_("VERI_KAYDI_BASARILI");
						
	    			break;
	    		case "alternatif":
	    			$sayfaNum = 16;
	    				if(isset($data['delete']) && $data['delete'] == 1){
	    					$result = $this->DeleteAlternatif($data,1);
	    					if ($result)
	    						$message = JText::_("VERI_KAYDI_BASARILI");
	    					else
	    						$message = JText::_("VERI_KAYDI_BASARISIZ");
	    				}
                                        else if(isset($data['delete']) && $data['delete'] == 2){
                                                $result = $this->DeleteAlternatif($data,2);
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
				/*case "ogrenme_ciktilari":
	    			$sayfaNum 			= 15;
	    			$tablo				= array ("zorunlu_birim", "secmeli_birim");
					
	    			$tur	 			= ZORUNLU_ALT_BIRIM;
					$resultZorunlu 		= $this->yeterlilikAciklamaKaydet ($data["zorunlu_aciklama"], $yeterlilik_id, $tablo[0]);
					$message 			= $this->yeterlilikAltBirimKaydet ($data, $yeterlilik_id, $tur, $tablo[0]);
					
					$tur	 			= SECMELI_ALT_BIRIM;
					$resultSecmeli		= $this->yeterlilikAciklamaKaydet($data["secmeli_aciklama"], $yeterlilik_id, $tablo[1]);
					$message 			= $this->yeterlilikAltBirimKaydet ($data, $yeterlilik_id, $tur, $tablo[1]);
					
					if ($resultZorunlu && $resultSecmeli)
	    				$message = JText::_("VERI_KAYDI_BASARILI");
	    			else
	    				$message = JText::_("VERI_KAYDI_BASARISIZ");
	    			break;*/
				}//end switch
				
			    if ($message == JText::_("VERI_KAYDI_BASARILI"))
			    {	
			    	$insertPageResult = $this->insertSavedPage ($sayfaNum, $evrak_id, $user->id, YT2_BASVURU_TIP, $yeterlilik_id);
			    	$this->updateDurum_Kaydedilmemisten_OnayaYollanmamisa($yeterlilik_id);
			    }			    	
    		}
    		else
    			return JText::_("BASVURU_KAYDI_BASARISIZ");
    	
    	
    	return $message;
    }
    
	function sektorSorumlusunaGonder ($evrak_id, $yeterlilik_id){
		$this->updateEvrakTur ($evrak_id, ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID);
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK);
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
	
	function yorumlariGonder ($evrak_id){
		$this->clearPreviousYorum_SS ($evrak_id);
		$this->updateYorumDurum_SS ($evrak_id, 0);
	}
	
	function onBasvuruOnayla ($evrak_id, $yeterlilik_id){
		$this->updateEvrakTur ($evrak_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK);
		$this->updateYeterlilikSurecDurum ($yeterlilik_id, ONAYLANMAMIS_YETERLILIK);
	}
	
	function onBasvuruOnaylaYeni ($evrak_id, $yeterlilik_id){
		$this->updateEvrakTur ($evrak_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__TASLAK);
		$this->updateYeterlilikSurecDurum ($yeterlilik_id, ONAYLANMAMIS_YETERLILIK);
	}
	
	function basvuruKurulusaGonder ($evrak_id, $yeterlilik_id){
		$this->updateEvrakTur ($evrak_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		$this->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK);
		$this->updateYeterlilikSurecDurum ($yeterlilik_id, KURULUSTAN_DUZELTME_ISTENEN_YETERLILIK);
	}
	
	function clearPreviousBirimler ($yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();
			
		//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_birim
		WHERE yeterlilik_id = ?";
		
		$params = array($yeterlilik_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	function onBasvuruBitir ($evrak_id , $yeterlilik_id){
		//FormFactory::evrakKaydet ($evrak_id);
		$this->updateBasvuruDurum ($evrak_id, IMZA_BEKLENEN_BASVURU);
		$this->updateYeterlilikSurecDurum ($yeterlilik_id, IMZA_BEKLENEN_YETERLILIK);
		$this->updateYeterlilikDurum ($yeterlilik_id, PM_YETERLILIK_DURUMU__TASLAK);
		$this->updateEditable ($yeterlilik_id, 0);
		$this->clearSavedPages ($evrak_id);
		//$this->clearSavedYorum_SS ($evrak_id);
	}
	
	function yeterlilikBirimleriniKaydet()
	{
		$_db  = & JFactory::getOracleDBO();
	    
		
		$resultMessage = "";
		
		
		
		$yeterlilikID = $_REQUEST["yeterlilik_id"];
		
		$kendiBirimi["ID"] = $_REQUEST["kendiBirimiHiddenInput-IDler"];
        $kendiBirimi["ZORUNLULUK"] = $_REQUEST["kendiBirimiHiddenInput-Zorunluluklar"];
        $kendiBirimi["ADLAR"] = $_REQUEST["kendiBirimiHiddenInput-Adlar"];
	    $kendiBirimi["KODLAR"] = $_REQUEST["kendiBirimiHiddenInput-Kodlar"];
	    $kendiBirimi["SEVIYELER"] = $_REQUEST["kendiBirimiHiddenInput-Seviyeler"];
	    $kendiBirimi["SIRA_NO"] = $_REQUEST["kendiBirimiHiddenInput-SiraNo"];
	    
	    $disBirim["ID"] = $_REQUEST["disBirimHiddenInput-IDler"];
	    $disBirim["ZORUNLULUK"] = $_REQUEST["disBirimHiddenInput-Zorunluluklar"];
	    $disBirim["SIRA_NO"] = $_REQUEST["disBirimHiddenInput-SiraNo"];
	    
	    $sql = "";
	    $params = array();
	    
	    $updateParams = array();
	     
	    for($i=0; $i<count($disBirim["ID"]); $i++)
	    {
	    	if ($disBirim["ID"][$i]!="NaN"){
	    	$sql .= " INTO M_YETERLILIK_BIRIM (yeterlilik_id, birim_id, zorunlu, sira_no) VALUES (?, ?, ?, ?) ";
	    	$params[] = $yeterlilikID;
	    	$params[] = $disBirim["ID"][$i];
	    	$params[] = $disBirim["ZORUNLULUK"][$i];
	    	$params[] = is_numeric($disBirim["SIRA_NO"][$i]) == false ? 100 : $disBirim["SIRA_NO"][$i] ;
			}
	    }
	    
	    for($i=0; $i<count($kendiBirimi["ID"]); $i++)
	    {
	    	if(substr($kendiBirimi["ID"][$i], 0, 1) == "-")
	    	{	
	    		$newBirimID = $_db->getNextVal (BIRIM_SEQ);
    	
	    		$sql .= " INTO M_BIRIM (BIRIM_ID, BIRIM_ADI, BIRIM_KODU, BIRIM_SEVIYE, BAGIMSIZMI, BAGIMLI_OLDUGU_YET_ID) VALUES (?,?,?,?,?,?) ";
	    		$params[] = $newBirimID;
	    		$params[] = $kendiBirimi["ADLAR"][$i];
	    		$params[] = $kendiBirimi["KODLAR"][$i];
	    		$params[] = $kendiBirimi["SEVIYELER"][$i];
	    		$params[] = PM_BIRIM_BAGIMSIZLIK_DURUMU__BAGIMLI;
	    		$params[] = $yeterlilikID;
	    		
	    		$birimIDToSave = $newBirimID;
	    	}
	    	else
	    	{
	    		$updateSQL[] = "UPDATE M_BIRIM SET birim_adi = ?, birim_kodu = ?,  birim_seviye = ? WHERE birim_id=?";
	    		$updateParams[$i][] = $kendiBirimi["ADLAR"][$i];
	    		$updateParams[$i][] = $kendiBirimi["KODLAR"][$i];
	    		$updateParams[$i][] = $kendiBirimi["SEVIYELER"][$i];
	    		$updateParams[$i][] = $kendiBirimi["ID"][$i];
	    		
	    		$birimIDToSave = $kendiBirimi["ID"][$i];
	    	}
	    	
	    	$sql .= " INTO M_YETERLILIK_BIRIM (yeterlilik_id, birim_id, zorunlu, sira_no) VALUES (?,?,?,?) ";
	    	$params[] = $yeterlilikID;
	    	$params[] = $birimIDToSave;
	    	$params[] = $kendiBirimi["ZORUNLULUK"][$i];
	    	$params[] = is_nan($kendiBirimi["SIRA_NO"][$i]) == true ? 100 : $kendiBirimi["SIRA_NO"][$i];
	    	
	    }
	    if ($sql){
	    	$sql = "INSERT ALL ".$sql." SELECT * FROM dual";
	    }
	    
	    
	    
	    /*echo "<pre>";
	    print_r($_REQUEST);
	    echo "</pre><br>";
	    echo $sql;
	    exit;*/
	    if ($sql){
	    if(count($updateParams)>0)
	    {
	    	for($i=0; $i<count($updateParams); $i++)
	    		@$_db->prep_exec_insert($updateSQL[$i], $updateParams[$i]);
	    }
	    if($_db->prep_exec_insert($sql, $params) ==true)
 	    	$message = JText::_("VERI_KAYDI_BASARILI");
 	    else
	    	$message = JText::_("VERI_KAYDI_BASARISIZ");
	    } else {
	    	$message = "KAYDEDİLECEK VERİ YOK";
	    }
		return $message;
	}

//	function basvuruOnayla ($evrak_id, $yeterlilik_id){
//		$this->updateBasvuruDurum ($evrak_id, IMZA_BEKLENEN_BASVURU);
//		$this->updateYeterlilikSurecDurum ($yeterlilik_id, IMZA_BEKLENEN_YETERLILIK);
//	}
	
//	function basvuruBitir ($evrak_id){
//		$this->clearSavedPages ($evrak_id);
//	}

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
			case "birimlerin_gruplandirilma":
				$sql = "UPDATE m_taslak_yeterlilik 
						SET birimlerin_gruplandirilma = ?
						WHERE yeterlilik_id = ?";				
				break;
			case "ilave_ogrenme_ciktilari":
				$sql = "UPDATE m_taslak_yeterlilik 
						SET ilave_ogrenme_ciktilari = ?
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
	
	function yeterlilikBirimKaydet($aciklama, $yeterlilik_id, $tur){
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
			case "birimlerin_gruplandirilma":
				$sql = "UPDATE m_taslak_yeterlilik 
						SET birimlerin_gruplandirilma = ?
						WHERE yeterlilik_id = ?";				
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
		$birimSira 	 	 = $data["input".$tableName."-1"];
		$birimAd	 	 = $data["input".$tableName."-3"];
		$birimKodu  	 = $data["input".$tableName."-4"];
		$birimSeviye	 = $data["input".$tableName."-5"];
		$birimKredi      = $data["input".$tableName."-6"];
		$birimYayintar 	 = $data["input".$tableName."-7"];
		$birimRevno 	 = $data["input".$tableName."-8"];
		$birimRevtar   	 = $data["input".$tableName."-9"];
		$birimMessta   	 = $data["input".$tableName."-10"];
		
		$birimBirgelis   = $data["input".$tableName."-11"];
		$birimSekkom  	 = $data["input".$tableName."-12"];
		$birimOnaytar    = $data["input".$tableName."-13"];
		$rowCount 	 	 = count ($birimSira);
		
		if ($tur == ZORUNLU_ALT_BIRIM)
			$siraHarf = "A";
		else
			$siraHarf = "B";
			
		$inpTablo 	= "tablo_".$tableName."_";
		$tabloId	= $tableName."_";
		
		$this->tumYeterlilikAltBirimSil ($yeterlilik_id, $tur);
		
		// HEPSINI EKLE
		for ($j = 0; isset ($data["input".$tableName."-1"][$j]); $j++){
			$id = $j;
        	$alt_birim_no  			= $siraHarf.$birimSira[$id];
    		$alt_birim_adi 			= $birimAd[$id];
    		$alt_birim_kodu 		= $birimKodu[$id];
			$alt_birim_seviye   	= $birimSeviye[$id];
			$alt_birim_kredi    	= $birimKredi[$id];
			$alt_birim_yayintar     = $birimYayintar[$id];
			$alt_birim_revno    	= $birimRevno[$id];
			$alt_birim_revtar  	    = $birimRevtar[$id];
			$alt_birim_messta  	    = $birimMessta[$id];
			
			$alt_birim_birgelis	    = $birimBirgelis[$id];
			$alt_birim_sekkom  	    = $birimSekkom[$id];
			$alt_birim_onaytar 	    = $birimOnaytar[$id];
			
			if (!$this->yeterlilikAltBirimEkle_Compact($yeterlilik_id, $tur, $alt_birim_no, $alt_birim_adi))
	    		return JText::_("ALT_BIRIM_EKLE_HATA");
		}	

    	return JText::_("VERI_KAYDI_BASARILI");
	}
	
	function tumYeterlilikAltBirimSil ($yeterlilik_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_alt_birim_yeni
				WHERE yeterlilik_id = ? AND yeterlilik_zorunlu = ?";
			         
		$params = array($yeterlilik_id, $tur);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function yeterlilikAltBirimSil ($alt_birim_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
 		
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_alt_birim_yeni 
				WHERE yeterlilik_alt_birim_id = ? AND yeterlilik_zorunlu = ?";
			         
		$params = array($alt_birim_id, $tur);

		return $_db->prep_exec_insert($sql, $params);
	}

	function yeterlilikAltBirimEkle ($yeterlilik_id, 
									 $tur, 
									 $alt_birim_no, 
									 $alt_birim_adi, 
									 $alt_birim_kodu, 
									 $alt_birim_seviye, 
									 $alt_birim_kredi, 
									 $alt_birim_yayintar, 
									 $alt_birim_revno, 
									 $alt_birim_revtar,
									 $alt_birim_messta,
									 $alt_birim_birgelis,
									 $alt_birim_sekkom,
									 $alt_birim_onaytar){
 		$_db  = & JFactory::getOracleDBO();

 		$alt_birim_id	 = $_db->getNextVal (YETERLILIK_ALT_BIRIM_SEQ);
 		
		//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_alt_birim  
				values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$params = array($yeterlilik_id, 
						$alt_birim_id,
						$alt_birim_no,
						$alt_birim_adi,
						$alt_birim_kodu,
						$alt_birim_seviye,
						$alt_birim_kredi,
						$alt_birim_yayintar,
						$alt_birim_revno, 
						$alt_birim_revtar,
						$alt_birim_messta,
						$alt_birim_birgelis,
						$alt_birim_sekkom,
						$alt_birim_onaytar,
						$tur);

		return $_db->prep_exec_insert($sql, $params);
	}
	function yeterlilikAltBirimEkle_Compact ($yeterlilik_id, $tur, $alt_birim_no, $alt_birim_adi){
		$_db  = & JFactory::getOracleDBO();
	
		$alt_birim_id	 = $_db->getNextVal (YETERLILIK_ALT_BIRIM_SEQ);
			
		//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_alt_birim_yeni 
			(YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_NO, 
			YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ZORUNLU)
			VALUES (?, ?, ?, ?, ?)";
		$params = array($yeterlilik_id, $alt_birim_id, $alt_birim_no, $alt_birim_adi, $tur);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	function yeterlilikAltBirimGuncelle ($alt_birim_id, 
										 $alt_birim_no, 
										 $alt_birim_adi, 
										 $alt_birim_kodu, 
										 $alt_birim_seviye, 
										 $alt_birim_kredi, 
										 $alt_birim_yayintar, 
										 $alt_birim_revno, 
										 $alt_birim_revtar,
										 $alt_birim_messta,
										 $alt_birim_birgelis,
										 $alt_birim_sekkom,
										 $alt_birim_onaytar){
 		$_db  = & JFactory::getOracleDBO();
		
    	//Prepare sql statement
		$sql = "UPDATE m_yeterlilik_alt_birim  
					SET yeterlilik_alt_birim_no = ?,
						yeterlilik_alt_birim_adi = ?,
						yeterlilik_alt_birim_kodu = ?,
						yeterlilik_alt_birim_seviye = ?,
						yeterlilik_alt_birim_kredi = ?,
						yeterlilik_alt_birim_yayin_tar = ?,
						yeterlilik_alt_birim_rev_no = ?,
						yeterlilik_alt_birim_rev_tar = ?,
						yeterlilik_alt_birim_mes_sta = ?,
						yeterlilik_alt_birim_bir_gelis = ?,
						yeterlilik_alt_birim_sek_kom = ?,
						yeterlilik_alt_birim_onay_tar = ?,
				WHERE yeterlilik_alt_birim_id = ?";
			         
		$params = array($alt_birim_no,
						$alt_birim_adi,
						$alt_birim_kodu,
						$alt_birim_id,
						$alt_birim_seviye,
						$alt_birim_kredi,
						$alt_birim_yayintar, 
						$alt_birim_revno,
						$alt_birim_revtar,
						$alt_birim_messta,
						$alt_birim_birgelis,
						$alt_birim_sekkom,
						$alt_birim_onaytar);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function degerlendirmeKaydet ($data, $yeterlilik_id){
//		$colCount	 = 5;
//		$result = $this->degerlendirmeleriSil ($yeterlilik_id);
//		
//		//TEORIK
//		$tableName   = "teorik";
//		$tur		 = TEORIK_OLCME_ARAC_TUR;
//		$tableValues = FormFactory::getTableValues($data, array ($tableName, $colCount));
//		$rowCount	 = count ($tableValues)/$colCount;
//
//    	for ($i = 0; $result && $i < $rowCount; $i++){
//    		$id = $colCount*$i;
//    		$result = $this->degerlendirmeEkle ($id, $tableValues, $yeterlilik_id, $tur);
//    	}
//    	
//    	//PRATIK
//		$tableName   = "performans";
//		$tur		 = PERFORMANS_OLCME_ARAC_TUR;
//		$tableValues = FormFactory::getTableValues($data, array ($tableName, $colCount));
//		$rowCount	 = count ($tableValues)/$colCount;
//		
//    	for ($i = 0; $result && $i < $rowCount; $i++){
//    		$id = $colCount*$i;
//    		$result = $this->degerlendirmeEkle ($id, $tableValues, $yeterlilik_id, $tur);
//    	}
//    	
//    	return $result;
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
		
		$revizeNoArray = $data["inputkurulus-5"];
		
		for ($i = 0; $result && $i < count($kurulus); $i++)
		{
			
			$ilkGelistirmeArray = $data["inputkurulus-3"."-".($i+1)][0];
			$revizeArray = $data["inputkurulus-4"."-".($i+1)][0];
			if($revizeArray=="on")
			{	$revizeValue = 1;
				$revizeNoValue = $revizeNoArray[$i];
			}
			else
			{	
				$revizeValue = 0;
				$revizeNoValue = "";
			}
			if($ilkGelistirmeArray=="on")
				$ilkGelistirmeValue = 1;
			else
				$ilkGelistirmeValue = 0;
			
			$kurulus_adi = $kurulus[$i];
		
			$result = $this->kurulusEkle ($yeterlilik_id, $kurulus_adi, $tur, $ilkGelistirmeValue, $revizeValue, $revizeNoValue, ($i+1) );
		}
		
		return $result;
	}
	
	function yeterliligiGelistirenKurulusKaydet ($data, $yeterlilik_id, $tur){
		$result = $this->kuruluslariSil ($yeterlilik_id, $tur);
		
		$kurulus 	 = $data["inputkurulus-2"];
		
		$revizeNoArray = $data["inputkurulus-5"];
		$revizyonCheckBoxlari = $data['revizyonCheckBoxlari'];
		$ilkGelistirenCheckBoxlari = $data['ilkGelistirenCheckBoxlari'];
		
		for ($i = 0; $result && $i < count($kurulus); $i++)
		{	
			$ilkGelistirmeValue = $ilkGelistirenCheckBoxlari[$i];
			$revizeValue = $revizyonCheckBoxlari[$i];
			$revizeNoValue = $revizeNoArray[$i];
			$kurulus_adi = $kurulus[$i];
		
			$result = $this->kurulusEkle ($yeterlilik_id, $kurulus_adi, $tur, $ilkGelistirmeValue, $revizeValue, $revizeNoValue );
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
	
	function kurulusEkle ($yeterlilik_id, $kurulus_adi, $tur, $ilkGelistirmeValue, $revizeValue, $revizeNoValue, $sira_no){
		$_db  = & JFactory::getOracleDBO();
		
		$kurulus_id = $_db->getNextVal (YETERLILIK_KURULUS_SEQ);
 		
    	//Prepare sql statement
		$sql = "INSERT INTO m_yeterlilik_kurulus(YETERLILIK_KURULUS_ID,
												 YETERLILIK_ID,
												 YETERLILIK_KURULUS_ADI,
												 YETERLILIK_KURULUS_TIPI,
												 ILK_GELISTIRME_YAPAN,
												 REVIZE_YAPAN,
												 REVIZE_NO,
												 SIRA_NO) 
				values (?, ?, ?, ?, ?, ?, ? , ?)";
			         
		$params = array($kurulus_id, 
						$yeterlilik_id, 
						$kurulus_adi,
						$tur,
						$ilkGelistirmeValue, 
						$revizeValue, 
						$revizeNoValue,
						$sira_no
				);

		return $_db->prep_exec_insert($sql, $params);
	}
	
	function beceriYetkinlikKaydet ($data, $yeterlilik_id, $tip,  $tableName){
    	$result = $this->beceriYetkinlikleriSil ($yeterlilik_id, $tip);
		
		$beceri_yetkinlik_adlar = $data["input".$tableName."-2"];
		
		for ($i = 0; $result && $i < count ($beceri_yetkinlik_adlar); $i++){
    		$beceri_yetkinlik_ad = $beceri_yetkinlik_adlar[$i];
   		if (!$this->beceriYetkinlikEkle ($beceri_yetkinlik_ad, $yeterlilik_id, $tip))
	    		return JText::_("BECERI_YETKINLIK_EKLE_HATA");
   	}
    	
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
	
	function yeterlilikHariciBirimKaydet ($data, $yeterlilik_id, $tur, $tablo){
		$result = $this->hariciBirimleriSil ($yeterlilik_id,$tur);
		$tableName 		= $tablo;
		$kaynak_birim 	= $data["input".$tableName."-3"];
		
		for ($i = 0; $result && $i < count ($kaynak_birim); $i++){
			$kaynak_id  	 = $kaynak_birim[$i];
			$result = $this->hariciBirimEkle ($yeterlilik_id, $kaynak_id, $tur);
		}
		
		return $result;
	}
	
	function hariciBirimEkle ($yeterlilik_id, $kaynak_id, $tur){
 		$_db  = & JFactory::getOracleDBO();
		if ($tur==ZORUNLU_ALT_BIRIM)
			$tur='0';
		else
			$tur='1';
    	//Prepare sql statement
			
		$sql = "INSERT INTO m_yeterlilik_birim_harici
				values(?, ?, ?)";
			         
		$params = array($yeterlilik_id, 
						$kaynak_id, 
						$tur);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function  hariciBirimleriSil ($yeterlilik_id,$tur){
 		$_db  = & JFactory::getOracleDBO();
 		if ($tur==ZORUNLU_ALT_BIRIM)
			$tur='0';
		else
			$tur='1';
    	//Prepare sql statement
		$sql = "DELETE FROM m_yeterlilik_birim_harici 
				WHERE yeterlilik_id = ? and zorunlu = ?";
			         
		$params = array($yeterlilik_id,$tur);
	
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
	
	function altBirimBeceriYetkinlikKaydet ($data, $yeterlilik_id, $tip, $tableName){
		$result = $this->altBirimBeceriYetkinlikleriSil ($yeterlilik_id, $tip);
		
		$alt_birim_ids 	  = $data["input".$tableName."-2"];
		$beceri_yetkinlik = $data["input".$tableName."-3"];
		
		for ($i = 0; $result && $i < count ($beceri_yetkinlik); $i++){
			$alt_birim_id 		 = $alt_birim_ids[$i];
    		$beceri_yetkinlik_id = $beceri_yetkinlik[$i];
    		$result = $this->altBirimBeceriYetkinlikEkle ($beceri_yetkinlik_id, $alt_birim_id, $yeterlilik_id, $tip);
    	}
    	
    	return $result;
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
	function degerlendiriciOlcutKaydet ($aciklama, $yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik  
					SET DEGERLENDIRICI_OLCUT = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($aciklama, $yeterlilik_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	function meslekteYatayDikeyKaydet ($aciklama, $yeterlilik_id){
		$_db  = & JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "UPDATE m_taslak_yeterlilik  
					SET MESLEKTE_YATAY_DIKEY = ? 
				WHERE yeterlilik_id = ?";
			         
		$params = array($aciklama, $yeterlilik_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	function basvuruOlustur() {
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= YT2_SAYI_ID;
    	$basvuru_tip 	= YT2_BASVURU_TIP;
    	$basvuru_durum	= ONAYLANMAMIS_BASVURU;
    	
    	$evrak_id = FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_TASLAK_ADAYI_SEKLI_ID);
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
    
	function updateEvrakTur ($evrak_id, $tur_id){
		$_db  = & JFactory::getOracleDBO();

		//Prepare sql statement
		$sql = "UPDATE ".DB_PREFIX.".evrak 
				SET basvuru_sekli_id = ? 
				WHERE evrak_id = ?";
			         
		$params = array($tur_id, $evrak_id);
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function updateYorumDurum_SS ($evrak_id, $yorum_durum){
		$db  = &JFactory::getDBO ();
		$sql = "UPDATE #__taslak_yorum 
				SET yorum_durum = ".$yorum_durum."	
				WHERE ss_yorumu_mu = 1 AND evrak_id = ".$evrak_id;

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
		FormParametrik::uyariKaydet(Array(YETERLILIK,"00"),$yeterlilik_id,"");
		
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
				WHERE ss_yorumu_mu = 1 AND evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function getSayfa ($layout){
		$pages 	= array ("tanitim", "yeterlilik_kaynagi", "yeterlilik_sartlari", "yeterliligin_yapisi", "olcme_ve_degerlendirme", "aciklama", "ek_2", "ek_3", "ek_4", "ek_5", "ek_6", "ek_8", "ek_9", "birimler", "ogrenme_ciktilari");
		
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
                $altTipi = $data['altTipi'];
                $altSay = $data['altSay'];
	
                if($altTipi == 2){
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
                    $sql = "UPDATE M_YETERLILIK SET ALTERNATIF_TIPI = 2, MIN_SECMELI_BIRIM_SAYISI = NULL WHERE YETERLILIK_ID = ?";
                    return $_db->prep_exec_insert($sql,array($yeterlilik_id));
                }
                else if($altTipi == 1){
                    $sql = "UPDATE M_YETERLILIK SET ALTERNATIF_TIPI = 1, MIN_SECMELI_BIRIM_SAYISI = ? WHERE YETERLILIK_ID = ?";
                    return $_db->prep_exec_insert($sql,array((int)$altSay,$yeterlilik_id));
                }
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
	
	function DeleteAlternatif($data,$tip){
		$_db  = & JFactory::getOracleDBO();
	
		$altId = $data['altId'];
                /* @var $yetId type */
                $yetId = $data['yetId'];
                
                if($tip == 1 && !empty($yetId)){
                    $sql = "UPDATE M_YETERLILIK SET ALTERNATIF_TIPI = 1,MIN_SECMELI_BIRIM_SAYISI = NULL WHERE YETERLILIK_ID = ?";
                    return $_db->prep_exec_insert($sql,array($yetId));
                }
                else if($tip == 2 && !empty($altId)){
                    $sqlYet = "SELECT YETERLILIK_ID FROM M_YETERLILIK_ALTERNATIF WHERE ALTERNATIF_ID = ?";
                    $yeterlilik = $_db->prep_exec($sqlYet,array($altId));
                    
                    $sql = "DELETE FROM M_YETERLILIK_ALTERNATIF WHERE ALTERNATIF_ID = ?";
                    $sonuc = $_db->prep_exec($sql,array($altId));
                    if(!$sonuc){
                            $sqlBirims = "DELETE FROM M_YETERLILIK_ALTERNATIF_BIRIM WHERE ALTERNATIF_ID = ?";
                            $sonnuc = $_db->prep_exec($sqlBirims,array($altId));
                    }
                    
                    $yeterlilik_id = $yeterlilik[0]['YETERLILIK_ID'];
                    $sql = "SELECT * FROM M_YETERLILIK_ALTERNATIF WHERE YETERLILIK_ID = ?";
                    $alts = $_db->prep_exec($sql,array($yeterlilik_id));
                    
                    if(count($alts) == 0){
                       $sql = "UPDATE M_YETERLILIK SET ALTERNATIF_TIPI = 1,MIN_SECMELI_BIRIM_SAYISI = NULL WHERE YETERLILIK_ID = ?";
                        return $_db->prep_exec_insert($sql,array($yeterlilik_id));
                    }
                    
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
	
	function taslakKaydetYeni($post,$evrak_id) {
		$_db  = & JFactory::getOracleDBO();
		$section = $_GET['section'];
		$yeterlilik_id = $post['yeterlilik_id'];
		$user 	= &JFactory::getUser();
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		if ($evrak_id == -1)
		{
			$evrak_id 	  = $this->basvuruOlustur();
			$taslakResult = $this->taslakYeterlilikOlustur ($evrak_id, $yeterlilik_id);
		
			if (!$taslakResult)
				$evrak_id =-2;
		}
		 
		if ($evrak_id != -1 && $evrak_id != null)
		{
			if(!$isSektorSorumlusu){
				$sql = "UPDATE M_YETERLILIK SET CALISMA_BASLAMA_DURUM = ? WHERE YETERLILIK_ID = ?";
				$_db->prep_exec_insert($sql,array('1',$yeterlilik_id));
			}
			switch ($section) {
				case 'section1':
					if($isSektorSorumlusu){
						$sql= "UPDATE m_yeterlilik
								SET YAYIN_TARIHI = to_date (?, 'dd/mm/yyyy'),
									KARAR_TARIHI = to_date (?, 'dd/mm/yyyy'),
									KARAR_SAYI = ?,
									YETERLILIK_KODU = ?,
									YETERLILIK_SUREC_DURUM_ID = ?,
									BELGE_ZORUNLULUK_DURUM = ?,
									TEHLIKELI_IS_DURUM = ?
						   WHERE yeterlilik_id = ?";
						$params = array ($post['yayinTarihi'],
											$post['onayTarihi'],
											$post['onaySayisi'],
											$post['referans_kodu'],
											$post['revizyon_durum'],
											$post['belge_zorunluluk_durum'],
										    $post['tehlikeli_is_durum'],
											$yeterlilik_id);
						
						$_db->prep_exec_insert($sql, $params);
					}
					if(isset($post['revizyon_durum']) && $post['revizyon_durum'] <> ""){
						if($post['revizyon_durum'] == "1"){
							$yeterlilikDurumId = "2";
						}else if($post['revizyon_durum'] == "-4"){
							$yeterlilikDurumId = "-2";
						}else if($post['revizyon_durum'] == "3"){
							$yeterlilikDurumId = "-2";
						}else{
							$yeterlilikDurumId = "1";
						}
						$sql= "UPDATE m_yeterlilik SET YETERLILIK_DURUM_ID = ? WHERE yeterlilik_id = ?";
						$parameter = array($yeterlilikDurumId,
								$yeterlilik_id);
						$_db->prep_exec_insert($sql, $parameter);
					}
					
					$sql = "UPDATE m_taslak_yeterlilik
								SET GORUSE_CIKMA_TARIHI = to_date (?, 'dd/mm/yyyy')
								WHERE yeterlilik_id = ?";
				
					$params = array ($post ["goruse_cikma_tarihi"],
									 $yeterlilik_id);
					
					$_db->prep_exec_insert($sql, $params);
					
					$standart['inputstandart-2'] = $post['inputstandart-2'];
					$standart['inputstandart-3'] = $post['inputstandart-3'];
					
					$this->uluslararasiStandartKaydet ($standart, $yeterlilik_id);
					
					$i = 0 ;
					$kurulusArray = array();
					foreach ($post['inputkurulus-2'] as $kurulus){
						$kurulusArray['inputkurulus-2'][$i] = $kurulus;
						$kurulusArray['ilkGelistirenCheckBoxlari'][$i] = (isset($post['inputkurulus-3-'.($i+1)]) == 'on' ? '1' : '0');
						$kurulusArray['revizyonCheckBoxlari'][$i] = (isset($post['inputkurulus-4-'.($i+1)]) == 'on' ? '1' : '0');
						$i++;
					}
				
					$result = $this->yeterliligiGelistirenKurulusKaydet ($kurulusArray, $yeterlilik_id, YET_GELISTIREN_KURULUS);
				break;
				case 'section2':
				
					$sql= "UPDATE m_yeterlilik
									SET GECERLILIK_SURESI = ?
				   				WHERE yeterlilik_id = ?";
					$params = array ($post['gecerlilik_suresi'],
									 $yeterlilik_id);
					
					$_db->prep_exec_insert($sql, $params);
					
					$sql = "UPDATE m_taslak_yeterlilik
								SET yeterlilik_gecerlilik_sure = ?,
									yeterlilik_method_gozetim = ?,
									yeterlilik_deg_yontem = ?,
							        SINAVSIZ_BELGE_YENILEME = ?
								WHERE yeterlilik_id = ?";
					
					$params = array($post['gecerlilik_suresi'],
									$post['gozetim'],
									$post["degerlendirme_yontem"],
							        $post['sinavsiz_belge'],
									$yeterlilik_id);
					
					$_db->prep_exec_insert($sql, $params);
						
				break;
				case 'section3':
					
					$this->clearPreviousBirimler($yeterlilik_id);
					
					$resultMessage = "";
					$yeterlilikID = $yeterlilik_id;
					
					$kendiBirimi["ID"] 			= $post["kendibirimId"];
					$kendiBirimi["ZORUNLULUK"]  = $post["kendizorunluSecmeliDurumu"];				
					$kendiBirimi["ADLAR"] 		= $post["kendibirimAdi"];
					$kendiBirimi["KODLAR"] 		= $post["kendibirimKodu"];
					$kendiBirimi["SEVIYELER"] 	= $post["kendibirimSeviyesi"];
					$kendiBirimi["SIRA_NO"] 	= $post["kendibirimSiraNo"];
					 
					$disBirim["ID"] 		= $post["disbirimId"];
					$disBirim["ZORUNLULUK"] = $post["diszorunluSecmeliDurumu"];
					$disBirim["SIRA_NO"] 	= $post["disbirimSiraNo"];
					 
					$sql = "";
					$params = array();
					 
					$updateParams = array();
					
					for($i=0; $i<count($disBirim["ID"]); $i++){
						
						if ($disBirim["ID"][$i]!="NaN"){
							$sql .= " INTO M_YETERLILIK_BIRIM (yeterlilik_id, birim_id, zorunlu, sira_no) VALUES (?, ?, ?, ?) ";
					    	$params[] = $yeterlilikID;
									    	$params[] = $disBirim["ID"][$i];
									    	$params[] = $disBirim["ZORUNLULUK"][$i];
					    	$params[] = is_numeric($disBirim["SIRA_NO"][$i]) == false ? 100 : $disBirim["SIRA_NO"][$i] ;
						}
					}
					 
					for($i=0; $i<count($kendiBirimi["ID"]); $i++){
						
						if(substr($kendiBirimi["ID"][$i], 0, 1) == "-")
						{
							$newBirimID = $_db->getNextVal (BIRIM_SEQ);
							 
							$sql .= " INTO M_BIRIM (BIRIM_ID, BIRIM_ADI, BIRIM_KODU, BIRIM_SEVIYE, BAGIMSIZMI, BAGIMLI_OLDUGU_YET_ID) VALUES (?,?,?,?,?,?) ";
				    		$params[] = $newBirimID;
				    		$params[] = $kendiBirimi["ADLAR"][$i];
				    		$params[] = $kendiBirimi["KODLAR"][$i];
		    				$params[] = $kendiBirimi["SEVIYELER"][$i];
		    				$params[] = PM_BIRIM_BAGIMSIZLIK_DURUMU__BAGIMLI;
		    				$params[] = $yeterlilikID;
		    				 
		    				$birimIDToSave = $newBirimID;
						}
						else
						{
							$updateSQL[] = "UPDATE M_BIRIM SET birim_adi = ?, birim_kodu = ?,  birim_seviye = ? WHERE birim_id=?";
				    		$updateParams[$i][] = $kendiBirimi["ADLAR"][$i];
				    		$updateParams[$i][] = $kendiBirimi["KODLAR"][$i];
				    		$updateParams[$i][] = $kendiBirimi["SEVIYELER"][$i];
				    		$updateParams[$i][] = $kendiBirimi["ID"][$i];
							 
							$birimIDToSave = $kendiBirimi["ID"][$i];
						}
						
						$sql .= " INTO M_YETERLILIK_BIRIM (yeterlilik_id, birim_id, zorunlu, sira_no) VALUES (?,?,?,?) ";
						$params[] = $yeterlilikID;
				    	$params[] = $birimIDToSave;
				    	$params[] = $kendiBirimi["ZORUNLULUK"][$i];
				    	$params[] = is_nan($kendiBirimi["SIRA_NO"][$i]) == true ? 100 : $kendiBirimi["SIRA_NO"][$i];
					
					}
					if ($sql){
					$sql = "INSERT ALL ".$sql." SELECT * FROM dual";
					}
					 
	    			if ($sql){
			    		if(count($updateParams)>0)
			    		{
			    		 for($i=0; $i<count($updateParams); $i++)
			    			@$_db->prep_exec_insert($updateSQL[$i], $updateParams[$i]);
						}
						if($_db->prep_exec_insert($sql, $params) ==true)
							$message = JText::_("VERI_KAYDI_BASARILI");
							else
							$message = JText::_("VERI_KAYDI_BASARISIZ");
					} else {
						$message = "KAYDEDİLECEK VERİ YOK";
					}
					return $message;
				break;
				case 'section4': 
					$post['yetId'] = $yeterlilik_id;
					if(isset($post['delete']) && $post['delete'] == 1){
						$result = $this->DeleteAlternatif($post,1);
					}
					else if(isset($post['delete']) && $post['delete'] == 2){
						$result = $this->DeleteAlternatif($post,2);
					}
					else if(isset($post['upGun']) && $post['upGun'] == 1){
						$result = $this->GuncelleAlternatif($post,$yeterlilik_id);
					}
					else{ 
						$result = $this->KaydetAlternatif($post,$yeterlilik_id); 
					}
				break;
				case 'section5':
					$sql= "UPDATE m_taslak_yeterlilik
						SET RESMI_GORUS_ONCESI_PDF = ?,
							SEKTOR_KOMITESI_ONCESI_PDF = ?,
							YONETIM_KURULU_ONCESI_PDF = ?,
							SON_TASLAK_PDF = ?
				   WHERE yeterlilik_id = ?";
				
				   $params = array (
							$post ["path_taslakPdf_0_1"],
							$post ["path_taslakPdf_0_2"],
							$post ["path_taslakPdf_0_3"],
							$post ["path_taslakPdf_0_4"],
							$yeterlilik_id);
				   $_db->prep_exec_insert($sql, $params);
// 				   $this->readDocument($path);
				break;
				case 'section6':
						$sql = "UPDATE m_taslak_yeterlilik
								SET degerlendirici_olcut = ?
								WHERE yeterlilik_id = ?";
					
					$params = array($post['degerlendirici_olcut'],
									$yeterlilik_id);
					
					$_db->prep_exec_insert($sql, $params);
				break;
				default:
					;
				break;
			}
		}
	     return true;
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
}
?>
