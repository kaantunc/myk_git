<?php
defined('_JEXEC') or die('Restricted access');

class DenetimModelDenetim extends JModel {

	function getDenetimListesi($kurulus_id)
	{
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT * 
			FROM M_DENETIM 
			JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID)  ";
		if($kurulus_id){
			$sql .= "WHERE M_DENETIM.DENETIM_KURULUS_ID =".$kurulus_id;
		}
	
		return $db->prep_exec($sql, array());
	
	}
	function getDenetimlerim()
	{
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM M_DENETIM
		JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID)
		WHERE M_KURULUS.USER_ID=?";
	
		return $db->prep_exec($sql, array($userId));//6905
		
	
	}
	
	function getKurulusunTumDenetimlerininIDleriByDenetimID($denetim_id)
	{
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT DENETIM_ID FROM M_DENETIM WHERE DENETIM_KURULUS_ID IN (SELECT DENETIM_KURULUS_ID FROM M_DENETIM WHERE DENETIM_ID = ?)";
	
		return $db->prep_exec_array($sql, array($denetim_id));
		
	
	}
	
	function denetimUcretiYatmisMi($denetimID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DENETIM_ID, DENETIM_UCRETI, SUM(DEKONT_UCRETI) AS DEKONT_TOPLAMI 
				FROM M_DENETIM 
					JOIN M_FINANS_KRLS_DENETIM_DEKONT USING (DENETIM_ID) 
					JOIN M_FINANS_DEKONT USING (DEKONT_ID)
				WHERE DENETIM_ID=?	
				GROUP BY DENETIM_ID, DENETIM_UCRETI
				";
		
		$denetimVeDekontToplami = $db->prep_exec($sql, array($denetimID));
		
		if(count($denetimVeDekontToplami)==0)
			return false;
		else if($denetimVeDekontToplami[0]['DENETIM_UCRETI'] > $denetimVeDekontToplami[0]['DEKONT_TOPLAMI'])
			return false;
		else
			return true;
	}
	
	function getBagliOldugumDenetimler()
	{
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
	
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM M_DENETIM
		JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID)
		WHERE M_KURULUS.USER_ID=?";
	
		return $db->prep_exec($sql, array($userId));//6905
	
	
	}
	function getDenetimByID($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT *
		FROM M_DENETIM JOIN PM_DENETIM_TURU USING (DENETIM_TURU) 
		WHERE DENETIM_ID = ?
		";
		
		$result = $db->prep_exec($sql, array($denetim_id));
		if(count($result)>0)
			return $result[0];
		else
			return null;
	}
		
	function getKuruluslarAsASelect($seciliKurulusID)
	{
		
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT KURULUS_ADI, M_KURULUS.USER_ID FROM M_BASVURU JOIN M_KURULUS ON (M_BASVURU.USER_ID = M_KURULUS.USER_ID)
WHERE basvuru_tip_id=3 AND basvuru_durum_id>=1 ORDER BY KURULUS_ADI ASC";
		$kuruluslar = $db->prep_exec($sql, array());
		$comboStr = '';
		if(isset($kuruluslar))
		{
			foreach ($kuruluslar as $row)
			{
				if($seciliKurulusID==$row['USER_ID'])
					$selected = ' selected="selected" ';
				else 
					$selected = '';
				
				$comboStr .= '<option value="'.$row['USER_ID'].'" '.$selected.' >'.$row['KURULUS_ADI'].'</option>';
			}
		}
	
		return $comboStr;
	}
	function getPMDenetimEkipRolleriAsSelectOptions()
	{
	
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM PM_DENETIM_EKIP_ROLU";
		$tablo = $db->prep_exec($sql, array());
		if(isset($tablo))
		{
			foreach ($tablo as $row)
			{
				$comboStr .= '<option value="'.$row['ROL_ID'].'" '.$selected.' >'.$row['ROL_ADI'].'</option>';
			}
		}
	
		return $comboStr;
	}
	function denetim_kaydet($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		$result = true;
		
		$kurulus_id = $_POST['kurulus'];
		$evrak_id = $_POST['belgeBasvuruSelect'];
		$denetimTuruSelect = $_POST['denetimTuruSelect'];
		
		if(strlen($denetim_id) == 0)
		{
			$denetim_id = $db->getNextVal(DENETIM_ID_SEQ);
			
			$sql = "SELECT * FROM m_kurulus WHERE user_id = ? ";
			$result = $db->prep_exec($sql, array($kurulus_id));
			
			$kurulusAdresi = $result[0]['KURULUS_ADRESI'];
			$kurulusPostaKodu = $result[0]['KURULUS_POSTA_KODU'];
			
			$ybKodu = '';
			
			$sql = "SELECT * FROM m_denetim WHERE denetim_kurulus_id=?";
			$rows = $db->prep_exec($sql, array($kurulus_id));
			if(count($rows)>0)
			{
				$ybKodu = $rows[0]['YB_KODU'];	
				$bkKodu = $rows[0]['BK_KODU'];
			}
			
			if(strlen($evrak_id) == 0){
				$sql = "INSERT INTO m_denetim (denetim_id, denetim_kurulus_id, denetim_turu, DENETIM_KURULUS_ADRESI, DENETIM_POSTA_KODU, YB_KODU) VALUES (?,?,?,?,?,?) ";
				$result = $db->prep_exec_insert($sql, array($denetim_id, $kurulus_id, $denetimTuruSelect, $kurulusAdresi, $kurulusPostaKodu, $ybKodu));
			}
			else{
				$sql = "INSERT INTO m_denetim (denetim_id, denetim_kurulus_id, denetim_turu, DENETIM_KURULUS_ADRESI, DENETIM_POSTA_KODU, YB_KODU, DENETIM_EVRAK_ID) VALUES (?,?,?,?,?,?,?) ";
				$result = $db->prep_exec_insert($sql, array($denetim_id, $kurulus_id, $denetimTuruSelect, $kurulusAdresi, $kurulusPostaKodu, $ybKodu,$evrak_id));
			}
			
		}
		else
		{
			$fields = array('ORGNZSYN_YAPISI_UYGUNLUK', 'EGITIM_BELGELENDIRME_AYRIMI','SORUMLULUKLAR_ACIK_MI', 'FAALIYET_ETKI_ONLEMI', 'INSAN_KAYNAGI_VAR_MI', 'SNV_YAPANLAR_SART_SAGLIYORMU', 'FIZIKI_ALTYAPI_UYGUNLUGU', 'TEKNIK_DONANIM_YETERLILIGI', 'MALI_YAPI_FLYTLERI_SAGLIYORMU', 'BELGELENDIRME_PROSEDURDERI', 'KAYITLARIN_INCELENMESI', 'GEZICI_SNV_INCELEMESI', 'ITIRAZ_SIKAYET_DEGERLENDIRME', 'FARKLI_SNV_HEYET_BIRLIGI', 'SNV_MATERYALININ_YET_UYUMU', 'YAPILAN_SNV_MTRYALI_TTRLILIGI', 'IC_DENETIM_KAYITLARI', 'DIS_DENETIM_SONUCLARI');
		
			$sql = "UPDATE m_denetim SET ";
			$updateArray = array();
			for ($i=0; $i<count($fields); $i++)
			{
				$sql .= $fields[$i].'=?, ';
				$updateArray[] = $_POST[$fields[$i]];
			}
			$sql .= ' DENETIM_KURULUS_ID=?, DENETIM_DOSYA_NO=?, DENETIM_KURULUS_ADRESI=?, DENETIM_POSTA_KODU=? WHERE denetim_id=? AND DENETIM_EVRAK_ID=? ';
			$updateArray[] = $kurulus_id;
			$updateArray[] = $_POST['dosyaNo'];
			$updateArray[] = $_POST['kurulusAdresi'];
			$updateArray[] = $_POST['postaKoduSehir'];
			
			$updateArray[] = $denetim_id;
			$updateArray[] = $evrak_id;
			
			$result = $db->prep_exec_insert($sql, $updateArray);
		
		}
		
		
		global $mainframe;
		$redirectUrl = "index.php?option=com_denetim&layout=denetim_ekibi&denetim_id=".$denetim_id;
		$mainframe->redirect($redirectUrl);
		
	}
	
	
	function getDenetimEkibiByDenetimIDAndRolu($denetim_id, $rol)
	{
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT * 
		FROM M_DENETIM_EKIP, M_UZMAN_HAVUZU, PM_DENETIM_EKIP_ROLU 
		WHERE M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID 
		AND M_DENETIM_EKIP.PERSONEL_ROLU = PM_DENETIM_EKIP_ROLU.ROL_ID
		AND DURUM=2 AND DENETIM_ID = ?
		AND M_DENETIM_EKIP.PERSONEL_ROLU = ?";
		
		return $db->prep_exec($sql, array($denetim_id, $rol));
		
	}
	
	function getDenetimUygunsuzluklariByDenetimID($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT *
		FROM M_UYGUNSUZLUK
		WHERE DENETIM_ID = ?";
		
		return $db->prep_exec($sql, array($denetim_id));
	}

	function getDenetimUygunsuzluklariByUygunsuzlukID($uygunsuzluk_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM  M_UYGUNSUZLUK JOIN PM_UYGUNSUZLUK_TURU ON ( M_UYGUNSUZLUK.UYGUNSUZLUK_TURU = PM_UYGUNSUZLUK_TURU.TUR_ID)
		WHERE UYGUNSUZLUK_ID = ?";
	
		$result =  $db->prep_exec($sql, array($uygunsuzluk_id));
		
		if(count($result)>0)
			return $result[0];
		else
			return null;
		
	}
	function getSeciliUygunsuzlugunDenetimi($uygunsuzluk_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM M_DENETIM 	JOIN PM_DENETIM_TURU USING (DENETIM_TURU) 
						JOIN M_UYGUNSUZLUK USING (DENETIM_ID)
		WHERE UYGUNSUZLUK_ID = ?";
	
		$result =  $db->prep_exec($sql, array($uygunsuzluk_id));
		
		if(count($result)>0)
			return $result[0];
		else
			return null;
		
	}
	
	
	function ekip_kaydet()
	{
		$ekipID = $_GET['kaydedilecekEkip'];
		$roller = $_GET['kaydedilecekRoller'];
		$ekipCalismaSureleri = $_GET['ekipCalisacakGunleri'];
		$ekipCalismaTarihleri = $_POST['ekipCalismaTarihleri'];
		$ekipCalismaTarihleri_Bitis = $_POST['ekipCalismaTarihleri_Bitis'];
		
		$denetim_id = $_GET['denetim_id'];
		$denetimUcreti = $_POST['denetimUcreti'];
		$denetimTarihi_Baslangic = $_POST['denetimTarihi_Baslangic'];
		$denetimTarihi_Bitis = $_POST['denetimTarihi_Bitis'];
		$denetimSuresi = $_GET['denetimSuresi'];
		$denetimGundemi = $_POST['denetimGundemi'];
		$uzmanDisindakiEkip = $_POST['uzmanDisindakiEkip'];
		
		if($denetim_id != null)
		{
			$db  = &JFactory::getOracleDBO();
		
			$sql = 'DELETE FROM M_UZMAN_CALISMA_SURESI WHERE CALISMA_SURESI_ID IN 
					(SELECT CALISMA_SURESI_ID
						FROM M_DENETIM_EKIP
						JOIN M_UZMAN_CALISMA_SURESI USING (CALISMA_SURESI_ID)
						JOIN M_UZMAN_HAVUZU ON (M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID)
						JOIN PM_DENETIM_EKIP_ROLU ON (M_DENETIM_EKIP.PERSONEL_ROLU = PM_DENETIM_EKIP_ROLU.ROL_ID)
						FULL JOIN (  SELECT SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_TOPLAM_GUN, UZMAN_ID AS USER_ID
										FROM M_UZMAN_CALISMA_SURESI
										WHERE gorevlendirildigi_mali_yil=?
										GROUP BY UZMAN_ID
								  ) USING (USER_ID)
						WHERE DURUM=2 AND DENETIM_ID = ?)';
			
			
			$db->prep_exec_insert($sql, array(date('Y'), $denetim_id));
			
			$sql = "DELETE FROM M_DENETIM_EKIP WHERE DENETIM_ID = ?";
			$db->prep_exec($sql, array($denetim_id));
				
			for($i=0; $i<count($ekipID); $i++)
			{
				$calismaSuresiID = $db->getNextVal('UZMAN_CALISMA_SURESI_ID_SEQ');
				$sql = "INSERT INTO M_UZMAN_CALISMA_SURESI 
				(UZMAN_ID, BASLANGIC_TARIHI, BITIS_TARIHI, GOREVLENDIRILDIGI_GUN_SAYISI, GOREVLENDIRME_ALANI, GOREVLENDIRILDIGI_MALI_YIL, CALISMA_SURESI_ID) 
				VALUES (?,TO_DATE(?, 'dd.mm.yyyy'),TO_DATE(?, 'dd.mm.yyyy'),?,?,?,?)";
				$db->prep_exec_insert($sql, array(	$ekipID[$i], 
													$ekipCalismaTarihleri[$i], 
													$ekipCalismaTarihleri_Bitis[$i],
													str_replace(array("."), array(","), $ekipCalismaSureleri[$i]), 
													$roller[$i], 
													date('Y'), 
													$calismaSuresiID ));
				
				$sql = "INSERT INTO M_DENETIM_EKIP (DENETIM_ID, PERSONEL_ID, PERSONEL_ROLU, CALISMA_SURESI_ID) VALUES (?,?,?,?)";
				$db->prep_exec_insert($sql, array($denetim_id, $ekipID[$i], $roller[$i], $calismaSuresiID ));
			}
			
			$sql = "UPDATE M_DENETIM SET UZMAN_DISINDAKI_EKIP=?, DENETIM_GUNDEMI=?, DENETIM_SURESI=?, DENETIM_TARIHI_BASLANGIC = TO_DATE(?, 'dd.mm.yyyy'), DENETIM_TARIHI_BITIS = TO_DATE(?, 'dd.mm.yyyy'), DENETIM_UCRETI = ? WHERE DENETIM_ID=?";
			$db->prep_exec_insert($sql, array($uzmanDisindakiEkip, $denetimGundemi, $denetimSuresi, $denetimTarihi_Baslangic, $denetimTarihi_Bitis, $denetimUcreti,  $denetim_id));
				
		}
	}
	
	function getDenetimUzmanlari()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_UZMAN_HAVUZU";
		return $db->prep_exec($sql, array());		
	}
	function getOnayliDenetimUzmanlari()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU FULL JOIN (  SELECT SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_GUN, UZMAN_ID AS USER_ID 
				                            FROM M_UZMAN_CALISMA_SURESI 
				                            WHERE gorevlendirildigi_mali_yil=? 
				                            GROUP BY UZMAN_ID
				                          ) USING (USER_ID) 
				WHERE DURUM=2";
		
		return $db->prep_exec($sql, array(date('Y')));
	}
	
	function getOnayliDenetimUzmanlari_BuDenetimdekiCalismalariHaric($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU FULL JOIN (  SELECT SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_GUN, UZMAN_ID AS USER_ID 
				                            FROM M_UZMAN_CALISMA_SURESI FULL JOIN M_DENETIM_EKIP USING (CALISMA_SURESI_ID)
				                            WHERE gorevlendirildigi_mali_yil=? AND ( DENETIM_ID IS NULL OR DENETIM_ID!=?) 
				                            GROUP BY UZMAN_ID
				                          ) USING (USER_ID) 
				WHERE BASVURU_DURUM=2 ORDER BY AD,SOYAD ASC";
	
		return $db->prep_exec($sql, array(date('Y'), $denetim_id));
	}
	
	function getDenetimEkibiByDenetimID($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = 'SELECT * 
				FROM M_DENETIM_EKIP 
				JOIN M_UZMAN_CALISMA_SURESI USING (CALISMA_SURESI_ID)
				JOIN M_UZMAN_HAVUZU ON (M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID)
				JOIN PM_DENETIM_EKIP_ROLU ON (M_DENETIM_EKIP.PERSONEL_ROLU = PM_DENETIM_EKIP_ROLU.ROL_ID)
				FULL JOIN (  SELECT SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_GUN, UZMAN_ID AS USER_ID 
				                            FROM M_UZMAN_CALISMA_SURESI FULL JOIN M_DENETIM_EKIP USING (CALISMA_SURESI_ID)
				                            WHERE gorevlendirildigi_mali_yil=? AND ( DENETIM_ID IS NULL OR DENETIM_ID!=?) 
				                            GROUP BY UZMAN_ID
				          ) USING (USER_ID) 
				WHERE BASVURU_DURUM=2 AND DENETIM_ID = ? 
				ORDER BY ROL_ID';
	
		
		return $db->prep_exec($sql, array(date('Y'),$denetim_id,$denetim_id));
	
	}
	function getKurulusAdiFromUygunsuzlukID($uygunsuzluk_id)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT KURULUS_ADI 
			FROM M_UYGUNSUZLUK JOIN M_DENETIM USING (DENETIM_ID) JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID )
	    	WHERE UYGUNSUZLUK_ID = ?";
		$result = $db->prep_exec($sql, array($uygunsuzluk_id));
		return $result[0]['KURULUS_ADI'];
	}
	
	function getKurulusAdiFromDenetimID($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT KURULUS_ADI
				FROM M_DENETIM JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID )
				WHERE DENETIM_ID = ?";
		$result = $db->prep_exec($sql, array($denetim_id));
		return $result[0]['KURULUS_ADI'];
	}
	
	function getKurulusFromDenetimID($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DISTINCT MKE.USER_ID AS USER_ID, MKE.KURULUS_ADI AS KURULUS_ADI,
      MKE.KURULUS_POSTA_KODU, MKE.KURULUS_ADRESI, MIL.IL_ADI
      FROM M_KURULUS MK
        INNER JOIN M_DENETIM MD ON (MK.USER_ID = MD.DENETIM_KURULUS_ID)
        INNER JOIN M_KURULUS_EDIT MKE ON (MK.USER_ID = MKE.USER_ID)
        INNER JOIN M_IL MIL ON (MKE.KURULUS_SEHIR = MIL.IL_ID)
        WHERE MKE.AKTIF = 1 AND MKE.ONAY_BEKLEYEN = 0 AND MD.DENETIM_ID = ?
    UNION
					SELECT DISTINCT MK.USER_ID AS USER_ID, MK.KURULUS_ADI AS KURULUS_ADI,
      MK.KURULUS_POSTA_KODU, MK.KURULUS_ADRESI, MIL.IL_ADI
      FROM M_KURULUS MK
         INNER JOIN M_IL MIL ON (MK.KURULUS_SEHIR = MIL.IL_ID)
        INNER JOIN M_DENETIM MD ON (MK.USER_ID = MD.DENETIM_KURULUS_ID)
        WHERE MK.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND MD.DENETIM_ID = ?";
		$result = $db->prep_exec($sql, array($denetim_id,$denetim_id));
		return $result[0];
	}
	
	function isDenetimValid($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_DENETIM WHERE DENETIM_ID=?";
		if(count($db->prep_exec($sql, array($denetim_id))) == 0)
			return false;
		else 
			return true;
	}
	
	function getEkipRolleri()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM PM_DENETIM_EKIP_ROLU";
		return $db->prep_exec($sql, array());
	}
	
	function raporKaydet($post, $denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		
		global $mainframe;
		
		if($_FILES[dosya][size]>5500000){
			$mainframe->redirect("index.php?option=com_denetim&layout=denetim_listele", "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
		}else if($_FILES[dosya][size] > 0 && $_FILES[dosya][error] == 0){
		
			$directory = EK_FOLDER."denetimler/".$denetim_id."/sonuc_belgeleri/";
			$sildir=EK_FOLDER."denetimler/".$denetim_id."/sonuc_belgeleri/";
			foreach(glob($sildir . '/*') as $file) {
				if(is_dir($file))
					rrmdir($file);
				else
					unlink($file);
			}
			rmdir($sildir);
			
			if (!file_exists($directory)){
				mkdir($directory, 0700,true);
			}
			$normalFile = FormFactory::formatFilename ($_FILES[dosya][name]);
			$_FILES[dosya][name] =	$directory . $normalFile;
			move_uploaded_file($_FILES[dosya][tmp_name],$_FILES[dosya][name]);
			$sql = "UPDATE M_DENETIM SET DENETIM_RAPOR_PATH = ? WHERE DENETIM_ID = ?";
			$db->prep_exec_insert($sql, array($normalFile, $denetim_id));
		}
		
		
		$rapor = $post['rapor'];
		
		$sql = "SELECT DENETIM_ID FROM M_DENETIM_RAPOR WHERE DENETIM_ID = ?";
		$data = $db->prep_exec($sql, array($denetim_id));
		
		if($data){
			$sqlDelete = "DELETE FROM M_DENETIM_RAPOR WHERE DENETIM_ID = ?";
			$db->prep_exec_insert($sqlDelete, array($denetim_id));
		}
		
		$arrayKey = array();
		$arrayVal = array();
		foreach($rapor as $key=>$val){
			$arrayKey[] = $key;
			$arrayVal[] = $val;
		}
		
		$sqlInsert = "INSERT INTO M_DENETIM_RAPOR (DENETIM_ID,".implode(',', $arrayKey).") VALUES(".$denetim_id.",?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		
		return $db->prep_exec_insert($sqlInsert, $arrayVal);
		
	}
	
	function getDenetimRapor($denetim_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_DENETIM_RAPOR WHERE DENETIM_ID = ?";
		$data = $db->prep_exec($sql, array($denetim_id));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function DenetimRaporOnayla($denetim_id){
		$db  = &JFactory::getOracleDBO();
		
		$sql="SELECT * FROM M_DENETIM_EKIP MDE
				INNER JOIN M_UZMAN_HAVUZU MUH ON (MDE.PERSONEL_ID = MUH.USER_ID) 
				WHERE MDE.DENETIM_ID = ? AND (MDE.PERSONEL_ROLU = 1 OR MDE.PERSONEL_ROLU = 2)";
		$ekip = $db->prep_exec($sql, array($denetim_id));
		
		$mailGorevli = array();
		
		$sqlIns = "INSERT INTO M_DENETIM_RAPOR_ONAY (DENETIM_ID, UZMAN_ID) VALUES(?,?)";
		foreach($ekip as $row){
			$db->prep_exec_insert($sqlIns, array($denetim_id, $row['USER_ID']));
			$mailGorevli[] = $row['EPOSTA'];
		}
		
		$baslik = 'MYK Denetim Raporu';
		$icerik = $row['DENETIM_ID']." Denetim ID'li denetim raporu onayınıza sunulmuştur. Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_uzman_havuzu&view=uzman_profile&layout=denetim";
		$to = $mailGorevli;
		FormFactory::sentEmail($baslik,$icerik,$to);
		
// 		$sqlRap = "UPDATE M_DENETIM SET DENETIM_RAPOR_PATH = 1 WHERE DENETIM_ID = ?";
// 		$db->prep_exec($sqlRap, array($denetim_id));
		
		$sql = "UPDATE M_DENETIM_RAPOR SET DURUM = 1 WHERE DENETIM_ID = ?";
		return $db->prep_exec_insert($sql, array($denetim_id));
	}
	
	function DenetimRaporOnayIptal($denetim_id){
		$db  = &JFactory::getOracleDBO();
		
		$sqlDet = "DELETE FROM M_DENETIM_RAPOR_ONAY WHERE DENETIM_ID = ?";
		$db->prep_exec_insert($sql, array($denetim_id));
		
// 		$sqlRap = "UPDATE M_DENETIM SET DENETIM_RAPOR_PATH = NULL WHERE DENETIM_ID = ?";
// 		$db->prep_exec($sqlRap, array($denetim_id));
		
		$sql = "UPDATE M_DENETIM_RAPOR SET DURUM = 0 WHERE DENETIM_ID = ?";
		return $db->prep_exec_insert($sql, array($denetim_id));
		
	}
	
	function uygunsuzlukKaydet_SS()
	{
		$denetim_id = $_POST['denetim_id'];
		$uygunsuzluk_id = $_POST['uygunsuzluk_id'];
		
		if(strlen($uygunsuzluk_id)==0)
		{
			if(strlen($denetim_id)==0)
			{
				//hata
			}
			else //uygunsuzluk id si yok ama denetim idsi var yani yeni kayıt etmiş
			{
				return $this->yeniUygunsuzlukTanimla($denetim_id);
			}
		}
		else
		{
			
			$sqlSetPart = 'UYGUNSUZLUK_SUREC_DURUM=?';
			$updateArray = array();
			
			$db  = &JFactory::getOracleDBO();
			$sql = "SELECT * FROM M_UYGUNSUZLUK WHERE UYGUNSUZLUK_ID = ?";
			$seciliuygunsuzluk = $db->prep_exec($sql, array($uygunsuzluk_id));
			$uygunsuzlukDurum = $seciliuygunsuzluk[0]['UYGUNSUZLUK_SUREC_DURUM'];
			$denetim_id = $seciliuygunsuzluk[0]['DENETIM_ID'];

			
			$db  = &JFactory::getOracleDBO();
			$uygunsuzlukNo = $_POST['uygunsuzlukNo'];
			$dosyaNo = $_POST['uygunsuzlukDosyaNo'];
			$kurulusTemsilcisi = $_POST['kurulusTemsilcisi'];
			$uygunsuzlukTuru = $_POST['uygunsuzlukTuru'];//buyuk-kucuk
			$yerindeTakipGerekliMi = $_POST['yerindeTakipGerekirMi'];
			$uygunsuzlukAciklamasi = $_POST['uygunsuzluguTespitEdilenKonu'];
			
			$path = 0;
			if(isset($_FILES['duzelticiFaaliyetDosya']) && $_FILES['duzelticiFaaliyetDosya']['error'] == 0){
				$file = $_FILES['duzelticiFaaliyetDosya'];
			
				$dosyaName = FormFactory::formatFilename ($file['name']);
				if (!file_exists(EK_FOLDER.'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya')) {
					mkdir(EK_FOLDER.'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya', 0777, true);
				}
				$path = 'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya/'.$dosyaName;
				move_uploaded_file($file["tmp_name"],EK_FOLDER.$path);
					
			
				$sql = "UPDATE M_UYGUNSUZLUK
				SET
				UYGUNSUZLUK_NO=?,
				DOSYA_NO=?,
				UYGUNSUZLUK_ACIKLAMASI=?,
				UYGUNSUZLUK_TURU=?,
				YERINDE_TAKIP_GEREKIR_MI=?,
				KURULUS_TEMSILCISI=?,
				UYGUNSUZLUK_SUREC_DURUM=?,
				DENETIM_ID=?,
				DUZELTICI_FILE = ?
				WHERE UYGUNSUZLUK_ID=?
				
				";
				
				$result = $db->prep_exec_insert($sql, array(
						$uygunsuzlukNo,
						$dosyaNo,
						$uygunsuzlukAciklamasi,
						$uygunsuzlukTuru,
						$yerindeTakipGerekliMi,
						$kurulusTemsilcisi,
						($uygunsuzlukDurum==1 ? PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI : $uygunsuzlukDurum),
						$denetim_id,
						$path,
						$uygunsuzluk_id
				));
			}else{
				$sql = "UPDATE M_UYGUNSUZLUK
				SET
				UYGUNSUZLUK_NO=?,
				DOSYA_NO=?,
				UYGUNSUZLUK_ACIKLAMASI=?,
				UYGUNSUZLUK_TURU=?,
				YERINDE_TAKIP_GEREKIR_MI=?,
				KURULUS_TEMSILCISI=?,
				UYGUNSUZLUK_SUREC_DURUM=?,
				DENETIM_ID=?
				WHERE UYGUNSUZLUK_ID=?
				
				";
				
				$result = $db->prep_exec_insert($sql, array(
						$uygunsuzlukNo,
						$dosyaNo,
						$uygunsuzlukAciklamasi,
						$uygunsuzlukTuru,
						$yerindeTakipGerekliMi,
						$kurulusTemsilcisi,
						($uygunsuzlukDurum==1 ? PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI : $uygunsuzlukDurum),
						$denetim_id,
						$uygunsuzluk_id
				));
			}
			
			//if($uygunsuzlukDurum==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_TANIMLANDI)
		//	{//tanımlanmış, yani düzenleyici faaliyet kaydetcez
				$faaliyetAciklama = $_POST['duzelticiFaaliyetAciklama'];
				$tamamlanmaSuresi = $_POST['tamamlanmaSuresi'];
				$duzelticiFaaliyetTarihi = $_POST['duzelticiFaaliyetTarih'];

				if($duzelticiFaaliyetTarihi != '')
				{
					$tarihPart=" DUZELTICI_FAALIYET_TARIHI=TO_DATE(?, 'dd.mm.yyyy'),";
					$parameters = array($duzelticiFaaliyetTarihi);
				}
				else
				{
					$tarihPart="  ";
					$parameters = array();
				}
					
				$db  = &JFactory::getOracleDBO();
				$sql = "UPDATE M_UYGUNSUZLUK
				SET ".$tarihPart."
				DUZELTICI_FAALIYET=?,
				TAMAMLANMA_SURESI=?
				WHERE UYGUNSUZLUK_ID = ?";
				$parameters[]= $faaliyetAciklama;
				$parameters[]= $tamamlanmaSuresi;
				$parameters[]= $uygunsuzluk_id;
				
				$result = $db->prep_exec_insert($sql, $parameters);
				
					
		//	}
		//	else if($uygunsuzlukDurum==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI)
		//	{//tanımlanmış, yani düzenleyici faaliyet kaydetcez
				$faaliyetYeterliMi = $_POST['duzelticiFaaliyetSonucu'];
				$faaliyetTarih = $_POST['duzelticiFaaliyetSonucTarih'];
				$faaliyetSonucAciklama = $_POST['duzelticiFaaliyetSonucuText'];
				
				if($faaliyetTarih != '')
				{
					$tarihPart=" DUZELTICI_FAALIYET_SNC_TARIHI=TO_DATE(?, 'dd.mm.yyyy'),";
					$parameters = array($faaliyetTarih);
				}
				else
				{
					$tarihPart="  ";
					$parameters = array();
				}
				
				
				$db  = &JFactory::getOracleDBO();
				$sql = "UPDATE M_UYGUNSUZLUK 
					SET ".$tarihPart."
						DUZELTICI_FAALIYET_SONUCU=?,
						DUZELTICI_FAALIYET_SNC_ACK=?,
						GIDERILDI_MI=? 
				WHERE UYGUNSUZLUK_ID = ?";
				$parameters[] = $faaliyetYeterliMi;
				$parameters[] = $faaliyetSonucAciklama;
				$parameters[] = $faaliyetYeterliMi;
				$parameters[] = $uygunsuzluk_id;
				
				$result = $db->prep_exec_insert($sql, $parameters);
					
				
	//		}
			//PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_SONUCLANDI ise zaten yapcak bişey yok
				$yeniSurecDurum = $uygunsuzlukDurum;
				if($uygunsuzlukDurum==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI)
				{
					$yeniSurecDurum = PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_SONUCLANDI;
					$sql = "UPDATE M_UYGUNSUZLUK
					SET UYGUNSUZLUK_SUREC_DURUM=?
					WHERE UYGUNSUZLUK_ID = ?";
					$parameters = array($yeniSurecDurum,$uygunsuzluk_id);
					
					$result = $db->prep_exec_insert($sql, $parameters);
						
				}
		}
		
	}
	
	function uygunsuzlukKaydet()
	{
		$user = & JFactory::getUser();
		$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
		
		$denetim_id = $_POST['denetim_id'];
		$uygunsuzluk_id = $_POST['uygunsuzluk_id'];
		
		if(strlen($uygunsuzluk_id)==0)
		{
			if(strlen($denetim_id)==0)
			{
				//hata
			}
			else //uygunsuzluk id si yok ama denetim idsi var yani yeni kayıt etmiş
			{
				return $this->yeniUygunsuzlukTanimla($denetim_id);
			}
		}
		else
		{
			$db  = &JFactory::getOracleDBO();
			$sql = "SELECT * FROM M_UYGUNSUZLUK WHERE UYGUNSUZLUK_ID = ?";
			$seciliuygunsuzluk = $db->prep_exec($sql, array($uygunsuzluk_id));
			$uygunsuzlukDurum = $seciliuygunsuzluk[0]['UYGUNSUZLUK_SUREC_DURUM'];
			
			$sqlDID = "SELECT DENETIM_ID FROM M_UYGUNSUZLUK WHERE UYGUNSUZLUK_ID=?";
			$denetim_id = $db->prep_exec($sqlDID, array($uygunsuzluk_id));
			$denetim_id = $denetim_id[0]['DENETIM_ID'];
			
			if($uygunsuzlukDurum==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_TANIMLANDI)
			{//tanımlanmış, yani düzenleyici faaliyet kaydetcez
				$faaliyetAciklama = $_POST['duzelticiFaaliyetAciklama'];
				$tamamlanmaSuresi = $_POST['tamamlanmaSuresi'];
				$duzelticiFaaliyetTarihi = $_POST['duzelticiFaaliyetTarih'];
				$path = 0;
				if(isset($_FILES['duzelticiFaaliyetDosya'])){
					$file = $_FILES['duzelticiFaaliyetDosya'];
					
					$dosyaName = FormFactory::formatFilename ($file['name']);
					if (!file_exists(EK_FOLDER.'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya')) {
						mkdir(EK_FOLDER.'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya', 0777, true);
					}
					$path = 'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya/'.$dosyaName;
					move_uploaded_file($file["tmp_name"],EK_FOLDER.$path);
					
				}
				
				$db  = &JFactory::getOracleDBO();
				$sql = "UPDATE M_UYGUNSUZLUK
				SET DUZELTICI_FAALIYET=?,
				TAMAMLANMA_SURESI=?,
				DUZELTICI_FAALIYET_TARIHI=TO_DATE(?, 'dd.mm.yyyy'),
				UYGUNSUZLUK_SUREC_DURUM=?,
				DUZELTICI_FILE = ?
				WHERE UYGUNSUZLUK_ID = ?";
				$parameters = array(
						$faaliyetAciklama,
						$tamamlanmaSuresi,
						$duzelticiFaaliyetTarihi,
						($denetlemesiYapilacakKurulusMu ? PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI : PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_TANIMLANDI),
						$path,
						$uygunsuzluk_id);
				
				return $db->prep_exec_insert($sql, $parameters);
				
					
			}
			else if($uygunsuzlukDurum==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI)
			{//tanımlanmış, yani düzenleyici faaliyet kaydetcez
				$faaliyetAciklama = $_POST['duzelticiFaaliyetAciklama'];
				$tamamlanmaSuresi = $_POST['tamamlanmaSuresi'];
				$duzelticiFaaliyetTarihi = $_POST['duzelticiFaaliyetTarih'];
				
				$path = 0;
				if(isset($_FILES['duzelticiFaaliyetDosya']) && $_FILES['duzelticiFaaliyetDosya']['size']>0){
					$file = $_FILES['duzelticiFaaliyetDosya'];
						
					$dosyaName = FormFactory::formatFilename ($file['name']);
					if (!file_exists(EK_FOLDER.'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya')) {
						mkdir(EK_FOLDER.'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya', 0777, true);
					}
					$path = 'denetimler/'.$denetim_id.'/'.$uygunsuzluk_id.'/duzeltici_dosya/'.$dosyaName;
					move_uploaded_file($file["tmp_name"],EK_FOLDER.$path);
					
					$db  = &JFactory::getOracleDBO();
					$sql = "UPDATE M_UYGUNSUZLUK
				SET DUZELTICI_FAALIYET=?,
				TAMAMLANMA_SURESI=?,
				DUZELTICI_FAALIYET_TARIHI=TO_DATE(?, 'dd.mm.yyyy'),
				DUZELTICI_FILE = ?
				WHERE UYGUNSUZLUK_ID = ?";
				$parameters = array(
						$faaliyetAciklama,
						$tamamlanmaSuresi,
						$duzelticiFaaliyetTarihi,
						$path,
						$uygunsuzluk_id);
				
				return $db->prep_exec_insert($sql, $parameters);
						
						
				}else{
					$db  = &JFactory::getOracleDBO();
					$sql = "UPDATE M_UYGUNSUZLUK
				SET DUZELTICI_FAALIYET=?,
				TAMAMLANMA_SURESI=?,
				DUZELTICI_FAALIYET_TARIHI=TO_DATE(?, 'dd.mm.yyyy')
				WHERE UYGUNSUZLUK_ID = ?";
				$parameters = array(
						$faaliyetAciklama,
						$tamamlanmaSuresi,
						$duzelticiFaaliyetTarihi,
						$uygunsuzluk_id);
				
				return $db->prep_exec_insert($sql, $parameters);
						
				}
			}
			//PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_SONUCLANDI ise zaten yapcak bişey yok
			
				
		}
		
	}
	function yeniUygunsuzlukTanimla($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
		$yeniUygunsuzlukID = $db->getNextVal(UYGUNSUZLUK_ID_SEQ);
		$uygunsuzlukNo = $_POST['uygunsuzlukNo'];
		$dosyaNo = $_POST['uygunsuzlukDosyaNo'];
		$kurulusTemsilcisi = $_POST['kurulusTemsilcisi'];
		$uygunsuzlukTuru = $_POST['uygunsuzlukTuru'];//buyuk-kucuk
		$yerindeTakipGerekliMi = $_POST['yerindeTakipGerekirMi'];
		$uygunsuzlukAciklamasi = $_POST['uygunsuzluguTespitEdilenKonu'];
		$uygunsuzlukSurecDurumu = PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_TANIMLANDI;
		
		$sql = "INSERT INTO M_UYGUNSUZLUK 
		(	UYGUNSUZLUK_ID,
			UYGUNSUZLUK_NO,
			DOSYA_NO,
			UYGUNSUZLUK_ACIKLAMASI,
			UYGUNSUZLUK_TURU,
			YERINDE_TAKIP_GEREKIR_MI,
			KURULUS_TEMSILCISI,
			UYGUNSUZLUK_SUREC_DURUM,
			DENETIM_ID,
			GIDERILDI_MI
		)
		VALUES (?,?,?,?,?,?,?,?,?,0)";
		
		return $db->prep_exec_insert($sql, array(	$yeniUygunsuzlukID, 
				$uygunsuzlukNo, 
				$dosyaNo,
				$uygunsuzlukAciklamasi,
				$uygunsuzlukTuru,
				$yerindeTakipGerekliMi,
				$kurulusTemsilcisi,
				$uygunsuzlukSurecDurumu,
				$denetim_id
		));
		
	}
	
	function togglePara($denetim_id)
	{
		
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT DENETIM_UCRETI_YATTI_MI
		FROM M_DENETIM 
		WHERE DENETIM_ID = ?";
		
		$denetimData = $db->prep_exec($sql, array($denetim_id));
		
		if($denetimData[0]['DENETIM_UCRETI_YATTI_MI'] == '1')
			$newValue = 0;
		else
			$newValue = 1;
		
		$sql = "UPDATE M_DENETIM SET DENETIM_UCRETI_YATTI_MI = ? WHERE DENETIM_ID = ?";
		return $db->prep_exec_insert($sql, array($newValue, $denetim_id));
			
		
	}
		
	
	function getSinavYetkisiVerilecekBirimler($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
		
		if($denetim_id != 0){
			$sqlEvrak = "SELECT DENETIM_EVRAK_ID FROM M_DENETIM WHERE DENETIM_ID=?";
			
			$evrak_id = $db->prep_exec($sqlEvrak, array($denetim_id));
			$evrak_id = $evrak_id[0]['DENETIM_EVRAK_ID'];
			
			$sql = "SELECT UNIQUE YETERLILIK_ID, YETERLILIK_ADI, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, SEVIYE_ID, BIRIM_SEVIYE, ZORUNLU,REVIZYON
				FROM M_BASVURU
				JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
				JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
				JOIN M_BIRIM USING (BIRIM_ID)
				JOIN M_YETERLILIK USING (YETERLILIK_ID)
				WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
			
				AND BASVURU_TIP_ID=3
				AND USER_ID=?
				AND EVRAK_ID=?
				ORDER BY YETERLILIK_ID, BIRIM_ID";
			return $db->prep_exec($sql, array($kurulus_id,$evrak_id));
		}else{
			$sql = "SELECT UNIQUE YETERLILIK_ID, YETERLILIK_ADI, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, SEVIYE_ID, BIRIM_SEVIYE, ZORUNLU,REVIZYON
					FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
					JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
					JOIN M_BIRIM USING (BIRIM_ID)
					JOIN M_YETERLILIK USING (YETERLILIK_ID)
					JOIN M_BELGELENDIRME_YET_TALEBI USING(YETERLILIK_ID)
					WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
						
					AND BASVURU_TIP_ID=3
					AND USER_ID=?
					ORDER BY YETERLILIK_ID, BIRIM_ID";
			return $db->prep_exec($sql, array($kurulus_id));
		}
		
// ESKİ **********************************************************************************//
// 		$sql = "SELECT UNIQUE YETERLILIK_ID, YETERLILIK_ADI, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, SEVIYE_ID, BIRIM_SEVIYE, ZORUNLU
// 		FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID) 
// 		JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID) 
// 		JOIN M_BIRIM USING (BIRIM_ID) 
// 		JOIN M_YETERLILIK USING (YETERLILIK_ID)
// 		JOIN M_BELGELENDIRME_YET_TALEBI USING(YETERLILIK_ID)
// 		WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6) 
		
// 		AND BASVURU_TIP_ID=3
// 		AND USER_ID=?
// 		ORDER BY YETERLILIK_ID, BIRIM_ID";
//ESKİ **********************************************************************************//
		
		
	}
	function getSinavYetkisiVerilecekBirimler_EskiFormattakiYeterlilikler($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
	
		if($denetim_id != 0){
			$sqlEvrak = "SELECT DENETIM_EVRAK_ID FROM M_DENETIM WHERE DENETIM_ID=?";
			
			$evrak_id = $db->prep_exec($sqlEvrak, array($denetim_id));
			$evrak_id = $evrak_id[0]['DENETIM_EVRAK_ID'];
			
			$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, SEVIYE_ID, SEVIYE_ID AS BIRIM_SEVIYE, YETERLILIK_ZORUNLU,REVIZYON
			FROM M_BASVURU 
			JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
			JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
			JOIN M_YETERLILIK USING (YETERLILIK_ID)
			WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
			
			AND BASVURU_TIP_ID=3
			AND USER_ID=?
			AND EVRAK_ID=?
			AND YENI_MI=0
			ORDER BY YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID";
			return $db->prep_exec($sql, array($kurulus_id,$evrak_id));
		}else{
			$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, SEVIYE_ID, SEVIYE_ID AS BIRIM_SEVIYE, YETERLILIK_ZORUNLU,REVIZYON
				FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
				JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
				JOIN M_YETERLILIK USING (YETERLILIK_ID)
				WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
					
				AND BASVURU_TIP_ID=3
				AND USER_ID=?
				AND YENI_MI=0
				ORDER BY YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID";
			return $db->prep_exec($sql, array($kurulus_id));
		}
// ESKİ **********************************************************************************//		
// 		$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, SEVIYE_ID, SEVIYE_ID AS BIRIM_SEVIYE, YETERLILIK_ZORUNLU
// 		FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
// 		JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
// 		JOIN M_YETERLILIK USING (YETERLILIK_ID)
// 		WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
	
// 		AND BASVURU_TIP_ID=3
// 		AND USER_ID=?
// 		AND YENI_MI=0
// 		ORDER BY YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID";
// ESKİ **********************************************************************************//	
		
	
	}
	function getSinavYetkisiVerilecekBirimIDleri($kurulus_id,$denetim_id=0)
	{
	
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sqlEvrak = "SELECT DENETIM_EVRAK_ID FROM M_DENETIM WHERE DENETIM_ID=?";
			
			$evrak_id = $db->prep_exec($sqlEvrak, array($denetim_id));
			$evrak_id = $evrak_id[0]['DENETIM_EVRAK_ID'];
			
			$sql = "SELECT BIRIM_ID
				FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
				JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
				JOIN M_BIRIM USING (BIRIM_ID)
				JOIN M_YETERLILIK USING (YETERLILIK_ID)
				WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
				AND BASVURU_TIP_ID=3
				AND USER_ID=?
				AND EVRAK_ID=?				
				AND YENI_MI=1
				ORDER BY YETERLILIK_ID, BIRIM_ID";
			return $db->prep_exec_array($sql, array($kurulus_id,$evrak_id));
		}else{
			$sql = "SELECT BIRIM_ID
				FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
				JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
				JOIN M_BIRIM USING (BIRIM_ID)
				JOIN M_YETERLILIK USING (YETERLILIK_ID)
				WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
				AND BASVURU_TIP_ID=3
				AND USER_ID=?
				AND YENI_MI=1
				ORDER BY YETERLILIK_ID, BIRIM_ID";
			return $db->prep_exec_array($sql, array($kurulus_id));
		}
// ESKİ **********************************************************************************//
// 		$sql = "SELECT BIRIM_ID
// 		FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
// 		JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
// 		JOIN M_BIRIM USING (BIRIM_ID)
// 		JOIN M_YETERLILIK USING (YETERLILIK_ID)
// 		WHERE (BASVURU_DURUM_ID=1 OR BASVURU_DURUM_ID = 6)
// 		AND BASVURU_TIP_ID=3
// 		AND USER_ID=?
// 		AND YENI_MI=1
// 		ORDER BY YETERLILIK_ID, BIRIM_ID";
// ESKİ **********************************************************************************//

	
	}
	function getSinavYetkisiVerilecekBirimIDleri_EskiFormattakiYeterlilikler($kurulus_id)
	{
	
			
		$db  = &JFactory::getOracleDBO();
	
		$sql = " SELECT YETERLILIK_ALT_BIRIM_ID
		FROM M_BASVURU JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
		JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
		JOIN M_YETERLILIK USING (YETERLILIK_ID)
		WHERE BASVURU_DURUM_ID=1
		AND BASVURU_TIP_ID=3
		AND USER_ID=?
		AND YENI_MI=0
		ORDER BY YETERLILIK_ID, YETERLILIK_ALT_BIRIM_I";
	
		return $db->prep_exec_array($sql, array($kurulus_id));
	
	}
	function getSinavYetkisiVerilmisBirimler($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sql = "SELECT BIRIM_ID
			FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
			WHERE DENETIM_KURULUS_ID=? 
			AND YETKININ_GERI_ALINDIGI_TARIH IS NULL AND DENETIM_ID=?";
		
			$result =  $db->prep_exec_array($sql, array($kurulus_id,$denetim_id));
		}else{
			$sql = "SELECT BIRIM_ID
			FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
			WHERE DENETIM_KURULUS_ID=?
			AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
			
			$result =  $db->prep_exec_array($sql, array($kurulus_id));
		}
		return $result;
		
	}
	
	function getSinavYetkisiVerilmisBirimler_EskiFormattakiYeterlilikler($kurulus_id)
	{
		getSinavYetkisiVerilmisBirimler($kurulus_id);		
	}
	
	function getSinavYetkisiVerilmisBirimler_Detaylariyla($kurulus_id,$denetim_id=0)
	{
	
		//BASVURU_DURUM_ID = 1 yazıyordu ama onu onaylanmışlar yapmak lazım
		
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sqlEvrak = "SELECT DENETIM_EVRAK_ID FROM M_DENETIM WHERE DENETIM_ID=?";
			
			$evrak_id = $db->prep_exec($sqlEvrak, array($denetim_id));
			$evrak_id = $evrak_id[0]['DENETIM_EVRAK_ID'];
			
			$sql = "SELECT DISTINCT M_BASVURU.USER_ID, M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK.REVIZYON, 
                M_BIRIM.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU, M_YETERLILIK.SEVIYE_ID, 
                M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI, M_DENETIM_YETKI.YETKININ_VERILDIGI_TARIH, 
                M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH
				FROM M_BASVURU
          	JOIN M_DENETIM ON M_BASVURU.USER_ID = M_DENETIM.DENETIM_KURULUS_ID
          	JOIN M_DENETIM_YETKI ON M_DENETIM.DENETIM_ID = M_DENETIM_YETKI.DENETIM_ID
          	JOIN M_BIRIM ON M_DENETIM_YETKI.BIRIM_ID = M_BIRIM.BIRIM_ID
			JOIN M_YETERLILIK ON M_BIRIM.BAGIMLI_OLDUGU_YET_ID = M_YETERLILIK.YETERLILIK_ID
			WHERE M_BASVURU.BASVURU_DURUM_ID=6
			AND M_BASVURU.BASVURU_TIP_ID=3
			AND M_BASVURU.USER_ID=?
      		AND M_BASVURU.EVRAK_ID = ?
			AND M_DENETIM_YETKI.ESKI_YET_ALTBIRIMINE_YETKI_MI = 0
			AND M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH IS NULL
			ORDER BY M_YETERLILIK.YETERLILIK_ID ASC, M_BIRIM.BIRIM_ID ASC, M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI ASC";
			return $db->prep_exec($sql, array($kurulus_id,$evrak_id));
		}else{
			$sql = "SELECT DISTINCT M_BASVURU.USER_ID, M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU, 
                M_BIRIM.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU, M_YETERLILIK.SEVIYE_ID, 
                M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI, M_DENETIM_YETKI.YETKININ_VERILDIGI_TARIH, 
                M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH
				FROM M_BASVURU
          	JOIN M_DENETIM ON M_BASVURU.USER_ID = M_DENETIM.DENETIM_KURULUS_ID
          	JOIN M_DENETIM_YETKI ON M_DENETIM.DENETIM_ID = M_DENETIM_YETKI.DENETIM_ID
          	JOIN M_BIRIM ON M_DENETIM_YETKI.BIRIM_ID = M_BIRIM.BIRIM_ID
			JOIN M_YETERLILIK ON M_BIRIM.BAGIMLI_OLDUGU_YET_ID = M_YETERLILIK.YETERLILIK_ID
			WHERE M_BASVURU.BASVURU_DURUM_ID=6
			AND M_BASVURU.BASVURU_TIP_ID=3
			AND M_BASVURU.USER_ID=?
			AND M_DENETIM_YETKI.ESKI_YET_ALTBIRIMINE_YETKI_MI = 0
			AND M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH IS NULL
			ORDER BY M_YETERLILIK.YETERLILIK_ID ASC, M_BIRIM.BIRIM_ID ASC, M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI ASC";
			return $db->prep_exec($sql, array($kurulus_id));
		}
// ESKİ ************************************************************************************************//		
// 		$sql = "SELECT USER_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, SEVIYE_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH
// 			FROM M_BASVURU 
// 				JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID) 
// 				JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID) 
// 				JOIN M_BIRIM USING (BIRIM_ID) 
// 				JOIN M_YETERLILIK USING (YETERLILIK_ID)
// 				JOIN M_DENETIM_YETKI USING (BIRIM_ID)
// 		WHERE BASVURU_DURUM_ID=6
// 		AND BASVURU_TIP_ID=3
// 		AND USER_ID=?
// 		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
// 		ORDER BY YETERLILIK_ID, BIRIM_ID";
// ESKİ ************************************************************************************************//	
		
	
	}
	
	function getSinavYetkisiVerilmisBirimler_Detaylariyla_EskiFormattakiYeterlilikler($kurulus_id,$denetim_id=0)
	{
		//BASVURU_DURUM_ID = 1 yazıyordu ama onu onaylanmışlar yapmak lazım
			
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sqlEvrak = "SELECT DENETIM_EVRAK_ID FROM M_DENETIM WHERE DENETIM_ID=?";
			
			$evrak_id = $db->prep_exec($sqlEvrak, array($denetim_id));
			$evrak_id = $evrak_id[0]['DENETIM_EVRAK_ID'];
			
			$sql = "SELECT DISTINCT M_BASVURU.USER_ID, M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK.REVIZYON,
	       M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID,
	       M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI,
	       M_YETERLILIK.YETERLILIK_KODU || '/' || M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
	       M_YETERLILIK.SEVIYE_ID,
	       M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI,
	       M_DENETIM_YETKI.YETKININ_VERILDIGI_TARIH,
	       M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH
			FROM M_BASVURU
			JOIN M_DENETIM ON M_BASVURU.USER_ID = M_DENETIM.DENETIM_KURULUS_ID
      JOIN M_DENETIM_YETKI ON M_DENETIM.DENETIM_ID = M_DENETIM_YETKI.DENETIM_ID
      JOIN M_YETERLILIK_ALT_BIRIM ON M_DENETIM_YETKI.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
			JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
      
     WHERE M_BASVURU.BASVURU_DURUM_ID=6
			AND M_BASVURU.BASVURU_TIP_ID=3
			AND M_BASVURU.USER_ID=?
			AND M_BASVURU.EVRAK_ID=?
			AND M_DENETIM_YETKI.ESKI_YET_ALTBIRIMINE_YETKI_MI = 1
			AND M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH IS NULL
			ORDER BY M_YETERLILIK.YETERLILIK_ID ASC, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID ASC, M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI ASC";
			return $db->prep_exec($sql, array($kurulus_id,$evrak_id));
		}else{
			$sql = "SELECT DISTINCT M_BASVURU.USER_ID, M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,
	       M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID,
	       M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI,
	       M_YETERLILIK.YETERLILIK_KODU || '/' || M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
	       M_YETERLILIK.SEVIYE_ID,
	       M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI,
	       M_DENETIM_YETKI.YETKININ_VERILDIGI_TARIH,
	       M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH
			FROM M_BASVURU
			JOIN M_DENETIM ON M_BASVURU.USER_ID = M_DENETIM.DENETIM_KURULUS_ID
      JOIN M_DENETIM_YETKI ON M_DENETIM.DENETIM_ID = M_DENETIM_YETKI.DENETIM_ID
      JOIN M_YETERLILIK_ALT_BIRIM ON M_DENETIM_YETKI.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
			JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
      
     WHERE M_BASVURU.BASVURU_DURUM_ID=6
			AND M_BASVURU.BASVURU_TIP_ID=3
			AND M_BASVURU.USER_ID=?
			AND M_DENETIM_YETKI.ESKI_YET_ALTBIRIMINE_YETKI_MI = 1
			AND M_DENETIM_YETKI.YETKININ_GERI_ALINDIGI_TARIH IS NULL
			ORDER BY M_YETERLILIK.YETERLILIK_ID ASC, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID ASC, M_DENETIM_YETKI.YETKI_KAPSAMI_YETKI_TARIHI ASC";
			return $db->prep_exec($sql, array($kurulus_id));
		}
// ESKİ ************************************************************************************************//		
// 		$sql = "SELECT USER_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, 
//        YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, 
//        YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, 
//        YETERLILIK_KODU || '/' || YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, 
//        SEVIYE_ID, 
//        YETKI_KAPSAMI_YETKI_TARIHI, 
//        YETKININ_VERILDIGI_TARIH, 
//        YETKININ_GERI_ALINDIGI_TARIH
// 		FROM M_BASVURU
// 		JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
// 		JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
// 		JOIN M_YETERLILIK USING (YETERLILIK_ID)
// 		JOIN M_DENETIM_YETKI ON  (M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID = M_DENETIM_YETKI.BIRIM_ID)
// 		WHERE BASVURU_DURUM_ID=6
// 		AND BASVURU_TIP_ID=3
// 		AND USER_ID=?
// 		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
// 		AND YENI_MI=0
// 		ORDER BY YETERLILIK_ID, YETERLILIK_ALT_BIRIM_ID";
// ESKİ ************************************************************************************************//	
		
	
	}
	
	function getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sql = "SELECT BIRIM_ID, YETKININ_VERILDIGI_TARIH
			FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
			WHERE DENETIM_KURULUS_ID=?
			AND ESKI_YET_ALTBIRIMINE_YETKI_MI=0
			AND DENETIM_ID=?
			AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
		
			return $db->prep_exec($sql, array($kurulus_id,$denetim_id));
		}else{
			$sql = "SELECT BIRIM_ID, YETKININ_VERILDIGI_TARIH
				FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID=?
				AND ESKI_YET_ALTBIRIMINE_YETKI_MI=0
				AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
			
			return $db->prep_exec($sql, array($kurulus_id));
		}
	}
	
	function getSinavYetkisiVerilmisBirimlerVeYetkiTarihleriFarkliDenetim($kurulus_id,$denetim_id){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT BIRIM_ID, YETKININ_VERILDIGI_TARIH
		FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
		WHERE DENETIM_KURULUS_ID=?
		AND ESKI_YET_ALTBIRIMINE_YETKI_MI=0
		AND DENETIM_ID NOT IN(?)
		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
		
		return $db->prep_exec($sql, array($kurulus_id,$denetim_id));
	}

	function getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sql = "SELECT BIRIM_ID, YETKININ_VERILDIGI_TARIH
				FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID=?
				AND DENETIM_ID=?
				AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
				AND ESKI_YET_ALTBIRIMINE_YETKI_MI=1";
			
			return $db->prep_exec($sql, array($kurulus_id,$denetim_id));
		}else{
			$sql = "SELECT BIRIM_ID, YETKININ_VERILDIGI_TARIH
				FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID=?
				AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
				AND ESKI_YET_ALTBIRIMINE_YETKI_MI=1";
				
			return $db->prep_exec($sql, array($kurulus_id));
		}
		
	}
	
	function getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterliliktenFarkliDenetim($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
		
			$sql = "SELECT BIRIM_ID, YETKININ_VERILDIGI_TARIH
				FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID=?
				AND DENETIM_ID NOT IN(?)
				AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
				AND ESKI_YET_ALTBIRIMINE_YETKI_MI=1";
				
			return $db->prep_exec($sql, array($kurulus_id,$denetim_id));
		
	
	}
	
	
	function getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri($kurulus_id,$denetim_id=0)
	{
// 		$db  = &JFactory::getOracleDBO();
	
// 		$sql = "SELECT BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH
// 		FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
// 		WHERE DENETIM_KURULUS_ID=?
// 		AND YETKININ_GERI_ALINDIGI_TARIH IS NOT NULL
// 		AND ESKI_YET_ALTBIRIMINE_YETKI_MI=0
// 		AND DENETIM_ID=?
// 		ORDER BY BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH";
	
// 		return $db->prep_exec($sql, array($kurulus_id,$denetim_id));

		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH
		FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
		WHERE DENETIM_KURULUS_ID=?
		AND YETKININ_GERI_ALINDIGI_TARIH IS NOT NULL
		AND ESKI_YET_ALTBIRIMINE_YETKI_MI=0
		ORDER BY BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH";
		
		return $db->prep_exec($sql, array($kurulus_id));
	}

	function getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten($kurulus_id,$denetim_id=0)
	{
		$db  = &JFactory::getOracleDBO();
		if($denetim_id != 0){
			$sql = "SELECT BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH
				FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID=?
				AND DENETIM_ID=?
				AND YETKININ_GERI_ALINDIGI_TARIH IS NOT NULL
				AND ESKI_YET_ALTBIRIMINE_YETKI_MI=1
				ORDER BY BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH";
			
			return $db->prep_exec($sql, array($kurulus_id,$denetim_id));
		}
		else{
			$sql = "SELECT BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH
				FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID=?
				AND YETKININ_GERI_ALINDIGI_TARIH IS NOT NULL
				AND ESKI_YET_ALTBIRIMINE_YETKI_MI=1
				ORDER BY BIRIM_ID, YETKININ_GERI_ALINDIGI_TARIH";
				
			return $db->prep_exec($sql, array($kurulus_id));
		}
		
	}
	
	function getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikler($kurulus_id)
	{
		getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri($kurulus_id);
	}
	
	function getBuDenetimDisindaSinavYetkisiVerilmisBirimler($kurulus_id, $current_denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT BIRIM_ID
		FROM M_DENETIM_YETKI JOIN M_DENETIM USING (DENETIM_ID)
		WHERE DENETIM_KURULUS_ID=? AND DENETIM_ID <> ? AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
	
		return $db->prep_exec_array($sql, array($kurulus_id, $current_denetim_id));
	}
	
	function yetkilendirmeyiKaydet()
	{
		$denetim_id = $_GET['denetim_id'];
		$asilDenetim = $this->getDenetimByID($denetim_id);
		$asilDenetimBaslangici = $asilDenetim['DENETIM_TARIHI_BASLANGIC'];
		
		$kurulusunTumDenetimleri = $this->getKurulusunTumDenetimlerininIDleriByDenetimID($denetim_id);
		
		$db  = &JFactory::getOracleDBO();
		
		
		//YENİ BİRİMLEEEEEEER 
		$oncedenYetkiVerilmisBirimler = $this->eksikIndexliArrayiDuzenle(array_unique($_POST['oncedenYetkiVerilmisBirimler']));
		$birimlerArray = $this->eksikIndexliArrayiDuzenle(array_unique($_POST['birimCheckbox']));
		
		
		for($i=0; $i<count($oncedenYetkiVerilmisBirimler); $i++)
		{
			if( ! in_array($oncedenYetkiVerilmisBirimler[$i], $birimlerArray))//onceden yetki verilmiş ama şimdi alınmış
			{
				$sql = "UPDATE M_DENETIM_YETKI SET YETKININ_GERI_ALINDIGI_DENETIM=".$denetim_id.", 
						YETKININ_GERI_ALINDIGI_TARIH='".$asilDenetimBaslangici."' 
						WHERE DENETIM_ID IN (".implode(',',$kurulusunTumDenetimleri).") 
						AND BIRIM_ID=".$oncedenYetkiVerilmisBirimler[$i]." AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
				$result = $db->prep_exec_insert($sql, array());
			}//else önceden varmış hala var
		}
		
		for($i=0; $i<count($birimlerArray); $i++)
		{
			if( ! in_array($birimlerArray[$i], $oncedenYetkiVerilmisBirimler))//çeklenmiş birimlerden (önceden yetki verilmiş olanlar) içinde olmayanlar için
			{
				$sql = "INSERT INTO M_DENETIM_YETKI (DENETIM_ID, BIRIM_ID, YETKININ_VERILDIGI_TARIH, ESKI_YET_ALTBIRIMINE_YETKI_MI) 
						VALUES (".$denetim_id.",".$birimlerArray[$i].", '".$asilDenetimBaslangici."', 0)";
				$result = $db->prep_exec_insert($sql, array());
			}
			//else simdi var ama onceden de varmış, bişey yapma
			
		}
		///////////// YENİ BİRİMLER BİTTİİİİİ

		//ESKİ BİRİMLEEEEEEER
		$oncedenYetkiVerilmisBirimler = $this->eksikIndexliArrayiDuzenle(array_unique($_POST['oncedenYetkiVerilmisBirimler_EskiFormattakiYeterliilk']));
		$birimlerArray = $this->eksikIndexliArrayiDuzenle(array_unique($_POST['birimCheckbox_EskiBirim']));
		for($i=0; $i<count($oncedenYetkiVerilmisBirimler); $i++)
		{
			if( ! in_array($oncedenYetkiVerilmisBirimler[$i], $birimlerArray))//onceden yetki verilmiş ama şimdi alınmış
			{
				$sql = "UPDATE M_DENETIM_YETKI SET YETKININ_GERI_ALINDIGI_DENETIM=".$denetim_id.", YETKININ_GERI_ALINDIGI_TARIH='".$asilDenetimBaslangici."' WHERE DENETIM_ID IN (".implode(',',$kurulusunTumDenetimleri).") AND BIRIM_ID=".$oncedenYetkiVerilmisBirimler[$i]." AND YETKININ_GERI_ALINDIGI_TARIH IS NULL";
				$result = $db->prep_exec_insert($sql, array());
			}//else önceden varmış hala var
		}
		
		for($i=0; $i<count($birimlerArray); $i++)
		{
			if( ! in_array($birimlerArray[$i], $oncedenYetkiVerilmisBirimler))//çeklenmiş birimlerden (önceden yetki verilmiş olanlar) içinde olmayanlar için
			{
				$sql = "INSERT INTO M_DENETIM_YETKI (DENETIM_ID, BIRIM_ID, YETKININ_VERILDIGI_TARIH, ESKI_YET_ALTBIRIMINE_YETKI_MI) VALUES (".$denetim_id.",".$birimlerArray[$i].", '".$asilDenetimBaslangici."', 1)";
				$result = $db->prep_exec_insert($sql, array());
			}
		//else simdi var ama onceden de varmış, bişey yapma
			
		}
		///////////// ESKİ BİRİMLER BİTTİİİİİ
		
		
		return $result;
		
		
	}
	
	function eksikIndexliArrayiDuzenle($array)
	{
		$resultToReturn = array();
		foreach($array as $arrayPart)
			$resultToReturn[] = $arrayPart;
		return $resultToReturn;
	}
	
	function ajaxCheckBKYBKodlari(){
		$_db = &JFactory::getOracleDBO();
	
		$yb = $_GET['yb'];
		$bk = $_GET['bk'];
		$denetim_id = $_GET['denetim_id'];
	
		$sql= "SELECT * FROM m_denetim WHERE BK_KODU=? AND DENETIM_KURULUS_ID NOT IN ( SELECT DENETIM_KURULUS_ID FROM M_DENETIM WHERE DENETIM_ID=?)";
	
		$params = array ($bk,$denetim_id);
	
		$result1 = $_db->prep_exec($sql, $params);
	
		if(count($result1) > 0)
			$data[] = '1';
		
		$sql= "SELECT * FROM m_denetim WHERE YB_KODU=? AND DENETIM_KURULUS_ID NOT IN ( SELECT DENETIM_KURULUS_ID FROM M_DENETIM WHERE DENETIM_ID=?)";
		$params = array ($yb, $denetim_id);
		
		
		$result2 = $_db->prep_exec($sql, $params);
		if(count($result2) > 0)
			$data[] = '2';
		
		
		if (empty($data))
			ajax_success_response("Başarılı");
		else
			ajax_error_response_with_array("Hatalı Değer", $data);
	}
	function ajaxBKKoduKullanimdaMi(){
		$_db = &JFactory::getOracleDBO();
	
		$bk = $_GET['bk'];
		
		$sql= "SELECT * FROM m_denetim WHERE BK_KODU=?";
		$params =  array($bk);
		if($_POST['denetim_id']!='')
		{
			$sql .= ' AND NOT DENETIM_ID=?';
		}
		
		$result = $_db->prep_exec($sql,$params);
		
		
		if (empty($result))
			ajax_success_response("Başarılı");
		else
			ajax_error_response_with_array("Hatalı Değer", $data);
	}	
	
	function kodKaydet()
	{
		$basvuruKodu = $_GET['bk'];
		$yetkiBelgesiKodu = $_GET['yb'];
		
		$denetim_id = $_GET['denetim_id'];
	
		$db  = &JFactory::getOracleDBO();
			
		$sql = "UPDATE M_DENETIM SET BK_KODU=? WHERE DENETIM_KURULUS_ID IN ( SELECT DENETIM_KURULUS_ID FROM M_DENETIM WHERE DENETIM_ID=?)";
		$result1 = $db->prep_exec_insert($sql, array($basvuruKodu, $denetim_id));
			
		$sql = "UPDATE M_DENETIM SET YB_KODU=? WHERE DENETIM_KURULUS_ID IN ( SELECT DENETIM_KURULUS_ID FROM M_DENETIM WHERE DENETIM_ID=?)";
		$result2 = $db->prep_exec_insert($sql, array($yetkiBelgesiKodu, $denetim_id));
		
		$result = $result1 && $result2;
		
		return $result;
	
	
	}
	
function ucretTarifesiKaydet()
	{
	$sil = array();
		$silinecekUcretler = $_POST['silinecekBelgelendirmeProgramlari'];
		$silinecek = explode("-", $silinecekUcretler[0]);
		for($ii = 0; $ii < count($silinecek)-1; $ii++){
				$sil[] = $silinecek[$ii]; 
		}
		$eklenecekUcretlerAciklama = $_POST['programAciklamasi'];
		$eklenecekUcretlerUcret = $_POST['programUcreti'];
		$eklenecekUcretlerIndirimliUcret = $_POST['indirimliUcret'];
		$kurulus_id = $_GET['kurulus_id'];
		$ucret_tarifesi_id = $_GET['ucret_tarifesi_id'];
	
		$db  = &JFactory::getOracleDBO();
			
		$sql = "DELETE FROM M_UCRET_TARIFESI_UCRETLERI WHERE UCRET_ID IN (".implode(', ', $sil).")";
		if(count($sil)!=0)
			$result = $db->prep_exec_insert($sql, array());
		
		for($i=0; $i<count($eklenecekUcretlerUcret); $i++)
		{
			if(	$eklenecekUcretlerAciklama[$i] != '' ||
			 	$eklenecekUcretlerUcret[$i] != '' ||
				$eklenecekUcretlerIndirimliUcret[$i] != '')//birinden biri doluysa
			{
				$sql = "INSERT INTO M_UCRET_TARIFESI_UCRETLERI 
				(UCRET_TARIFESI_ID, BELGELENDIRME_PROGRAMI_ACKLM,UCRET, INDIRIMLI_UCRET, UCRET_ID) 
				VALUES (?,?,?,?,?) ";
				$params = array();
				$params[] = $ucret_tarifesi_id;
				$params[] = $eklenecekUcretlerAciklama[$i];
				$params[] = $eklenecekUcretlerUcret[$i];
				$params[] = $eklenecekUcretlerIndirimliUcret[$i];
				$params[] = $db->getNextVal('UCRET_TARIFESI_UCRETLERI_SEQ');
				$result3 =  $db->prep_exec_insert($sql, $params);
				$result = $result && $result3;
			}
			
		}
		
		
		$sql = "UPDATE M_UCRET_TARIFESI SET GENEL_KURAL_SARTLAR=?, INDIRIMLER=? 
		WHERE UCRET_TARIFESI_ID=?";
		$params = array();
		$params[] = $_POST['genelKuralveSartlarTextArea'];
		$params[] = $_POST['ucretTarifesiTextArea'];
		$params[] = $ucret_tarifesi_id;
		
		$result2 = $db->prep_exec_insert($sql, $params);
		$result = $result && $result2;
		
		return $result;
	
	
	}
	
	
function yetkiKapsamiKaydet()
{
	$denetim_id = $_POST['denetim_id'];
	$tarihler = $_POST['yetkiTarihi'];
	$user_id = $_POST['user_id'];
	
	$db  = &JFactory::getOracleDBO();
	
	foreach ($tarihler as $yeterlilik_id => $tarih) {
		if(strlen($tarih[0])>0)
		{
			$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID=?";
			$params = array($yeterlilik_id);
			$yeterlilik = $db->prep_exec($sql, $params);
			if($yeterlilik[0]['YENI_MI']=='1')
			{
				$sql = "UPDATE M_DENETIM_YETKI
				SET YETKI_KAPSAMI_YETKI_TARIHI = TO_DATE(?, 'DD.MM.YYYY')
				WHERE (M_DENETIM_YETKI.BIRIM_ID, M_DENETIM_YETKI.DENETIM_ID)
				IN (SELECT BIRIM_ID, DENETIM_ID
					FROM 	M_BASVURU
							JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
							JOIN M_YETERLILIK_BIRIM USING (YETERLILIK_ID)
							JOIN M_BIRIM USING (BIRIM_ID)
							JOIN M_YETERLILIK USING (YETERLILIK_ID)
							JOIN M_DENETIM_YETKI USING (BIRIM_ID)
					WHERE BASVURU_DURUM_ID=6
					AND BASVURU_TIP_ID=3
					AND USER_ID = ?
					AND YETERLILIK_ID = ?
					AND DENETIM_ID IN (SELECT DENETIM_ID FROM M_DENETIM WHERE DENETIM_KURULUS_ID = ?)
					AND ESKI_YET_ALTBIRIMINE_YETKI_MI = 0
					AND YETKININ_GERI_ALINDIGI_TARIH IS NULL)";
				//AND ESKI_YET_ALTBIRIMINE_YETKI_MI = 1
// 				print_r('<pre>');
// 				print_r($tarih[0]);
// 				print_r($user_id);
// 				print_r($yeterlilik_id);
// 				print_r('</pre>');
// 				exit();
// 				die();
				$params = array($tarih[0], $user_id, $yeterlilik_id, $user_id);
					
				$result2 = $db->prep_exec_insert($sql, $params);
				
			}
			else
			{
				$sql = "UPDATE M_DENETIM_YETKI
				SET YETKI_KAPSAMI_YETKI_TARIHI = TO_DATE(?, 'DD.MM.YYYY')
				WHERE (M_DENETIM_YETKI.BIRIM_ID, M_DENETIM_YETKI.DENETIM_ID)
				IN (SELECT BIRIM_ID, DENETIM_ID
						FROM 	M_BASVURU
						JOIN M_BELGELENDIRME_YET_TALEBI USING (EVRAK_ID)
						JOIN M_YETERLILIK_ALT_BIRIM USING (YETERLILIK_ID)
						JOIN M_YETERLILIK USING (YETERLILIK_ID)
						JOIN M_DENETIM_YETKI ON (M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID=M_DENETIM_YETKI.BIRIM_ID)
						WHERE BASVURU_DURUM_ID=6
						AND BASVURU_TIP_ID=3
						AND USER_ID=?
						AND YETERLILIK_ID = ?
						AND DENETIM_ID IN (SELECT DENETIM_ID FROM M_DENETIM WHERE DENETIM_KURULUS_ID = ?)
						AND ESKI_YET_ALTBIRIMINE_YETKI_MI = 1
						AND YETKININ_GERI_ALINDIGI_TARIH IS NULL)";
						
				
				$params = array($tarih[0], $user_id, $yeterlilik_id, $user_id);
					
				$result2 = $db->prep_exec_insert($sql, $params);
			}
		}		
	}
}

	function ajaxSaveDisUzman(){
		$db  = &JFactory::getOracleDBO();
		$id = $_POST['DenetimId'];
		$ad = $_POST['DisAd'];
		$soyad = $_POST['DisSoyad'];
		$kurum = $_POST['DisKurum'];
		$unvan = $_POST['DisUnvan'];
		$rol = $_POST['DisRol'];
		$bastar = $_POST['DisBastar'];
		$bittar = $_POST['DisBittar'];
		$gun = $_POST['DisGun'];
		
		$sql = "INSERT INTO M_UZMAN_DIS (DENETIM_ID, AD, SOYAD, KURUM, UNVAN, ROL, BAS_TARIH, BIT_TARIH, GUN) VALUES (?,?,?,?,?,?,?,?,?) ";
		$result = $db->prep_exec_insert($sql, array($id, $ad, $soyad, $kurum, $unvan, $rol, $bastar, $bittar, $gun));
		
		if($result == true){
			$sql1 = "SELECT ID FROM M_UZMAN_DIS WHERE ROWNUM = 1 ORDER BY ID DESC";
			$result1 = $db->prep_exec($sql1,array());
		}
		$sql2 = "SELECT * FROM M_UZMAN_DIS JOIN PM_DENETIM_EKIP_ROLU ON M_UZMAN_DIS.ROL = PM_DENETIM_EKIP_ROLU.ROL_ID WHERE ID =?";
		$result = $db->prep_exec($sql2,array($result1[0]['ID']));
		echo json_encode($result);
	}
	
	function getuzmanDisByID($denetim_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM M_UZMAN_DIS JOIN PM_DENETIM_EKIP_ROLU ON M_UZMAN_DIS.ROL = PM_DENETIM_EKIP_ROLU.ROL_ID 
		WHERE DENETIM_ID = ?
		ORDER BY ID DESC";
	
		$result = $db->prep_exec($sql, array($denetim_id));
		if(count($result)>0)
			return $result;
		else
			return null;
	}
	
	function ajaxDelDisUzman()
	{
		$db  = &JFactory::getOracleDBO();
		
		$id = $_POST['DisId'];
		$denetim_id = $_POST['DenetimId'];
		$sql = "DELETE FROM M_UZMAN_DIS WHERE DENETIM_ID = ? AND ID = ?";
		$result = $db->prep_exec($sql, array($denetim_id,$id));
		return $result;
	}
	
	function ajaxGetDisUzman(){
		$db  = &JFactory::getOracleDBO();
		
		$id = $_POST['DisId'];
		$denetim_id = $_POST['DenetimId'];
		$sql = "SELECT *
		FROM M_UZMAN_DIS JOIN PM_DENETIM_EKIP_ROLU ON M_UZMAN_DIS.ROL = PM_DENETIM_EKIP_ROLU.ROL_ID 
		WHERE DENETIM_ID = ? AND ID = ?";
		$result = $db->prep_exec($sql, array($denetim_id,$id));
		echo json_encode($result);
	}
	
	function ajaxUpdateDisUzman(){
		$db  = &JFactory::getOracleDBO();
		
		$id = $_POST['DisId'];
		$denetim_id = $_POST['DenetimId'];
		$ad = $_POST['DisAd'];
		$soyad = $_POST['DisSoyad'];
		$kurum = $_POST['DisKurum'];
		$unvan = $_POST['DisUnvan'];
		$rol = $_POST['DisRol'];
		$bastar = $_POST['DisBas'];
		$bittar = $_POST['DisBit'];
		$gun = $_POST['DisGun'];
		
		$sql = "UPDATE M_UZMAN_DIS SET AD=?, SOYAD=?, KURUM=?, UNVAN=?, ROL=?, BAS_TARIH=?, BIT_TARIH=?, GUN=?
		WHERE DENETIM_ID = ? AND ID = ?";
		
		$deger = array(
				$ad,
				$soyad,
				$kurum,
				$unvan,
				$rol,
				$bastar,
				$bittar,
				$gun,
				$denetim_id,
				$id
		);
		$result = $db->prep_exec_insert($sql, $deger);
		
		if($result == true){
			$sql = "SELECT *
			FROM M_UZMAN_DIS JOIN PM_DENETIM_EKIP_ROLU ON M_UZMAN_DIS.ROL = PM_DENETIM_EKIP_ROLU.ROL_ID 
			WHERE DENETIM_ID = ? AND ID = ?";
			$result = $db->prep_exec($sql, array($denetim_id,$id));
			echo json_encode($result);
		}
	}
	
	function ajaxGetDisUzmanRols(){
		$db  = &JFactory::getOracleDBO();
		
		$rol = $_POST['RolId'];
		
		$sql = "SELECT *
				FROM PM_DENETIM_EKIP_ROLU
				WHERE ROL_ID != ?";
		$result = $db->prep_exec($sql, array($rol));
		echo json_encode($result);
	}
        
        function getBelgeBasvuru(){
            $_db = & JFactory::getOracleDBO();
            
            $dtur = $_POST['dtur'];
            $dkur = $_POST['dkur'];
            
          
            $sql = "SELECT * FROM M_BASVURU 
                JOIN M_BELGELENDIRME_DURUM USING(EVRAK_ID)
                WHERE USER_ID = ? AND BASVURU_TIP_ID = 3 AND DURUM_ID = 18 
                AND EVRAK_ID NOT IN(SELECT DENETIM_EVRAK_ID FROM M_DENETIM WHERE DENETIM_TURU IN(1,2) AND DENETIM_EVRAK_ID IS NOT NULL) 
                ORDER BY BASVURU_TARIHI DESC";
            
            $result =  $_db->prep_exec($sql,array($dkur));
            return $result;
        }

	function uygunsuzlukSil($post){
		$_db = & JFactory::getOracleDBO();
		
		$uyId = $post['uyId'];
		$sql = "DELETE FROM M_UYGUNSUZLUK WHERE UYGUNSUZLUK_ID=?";
		return $_db->prep_exec($sql, array($uyId));
	}
	
	function getKurulusDenetim($kurulus_id){
		$_db = & JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI
				FROM M_DENETIM
				JOIN M_KURULUS ON M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID";
		$sql .= " ORDER BY M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI ASC";
		$data = $_db->prep_exec($sql, array());
		
		for($i=0; $i<count($data); $i++){
			$sqlDen = "SELECT DENETIM_TARIHI_BASLANGIC, DENETIM_ID FROM M_DENETIM 
					WHERE DENETIM_KURULUS_ID = ? AND DENETIM_TARIHI_BASLANGIC IS NOT NULL
					ORDER BY DENETIM_TARIHI_BASLANGIC DESC";
			
			$tarih = $_db->prep_exec($sqlDen, array($data[$i]['USER_ID']));
			
			$data[$i]['SON_DENETIM'] = $tarih[0]['DENETIM_TARIHI_BASLANGIC'];
			$data[$i]['DENETIM_ID'] = $tarih[0]['DENETIM_ID'];
			
			$sqlUy = "SELECT COUNT(*) AS SAY FROM M_UYGUNSUZLUK WHERE DENETIM_ID=?";
			$uygunsuzluk = $_db->prep_exec($sqlUy, array($tarih[0]['DENETIM_ID']));
			
			$data[$i]['UYGUNSUZLUK'] = $uygunsuzluk[0]['SAY'];
		}
		
		return $data;
	}
	
	function denetimEkibiDenetimId($denetim_id){
		$db  = &JFactory::getOracleDBO();
		
		$sql = 'SELECT *
				FROM M_DENETIM_EKIP
				JOIN M_UZMAN_CALISMA_SURESI USING (CALISMA_SURESI_ID)
				JOIN M_UZMAN_HAVUZU ON (M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID)
				JOIN PM_DENETIM_EKIP_ROLU ON (M_DENETIM_EKIP.PERSONEL_ROLU = PM_DENETIM_EKIP_ROLU.ROL_ID)
				FULL JOIN (  SELECT SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_GUN, UZMAN_ID AS USER_ID
				                            FROM M_UZMAN_CALISMA_SURESI FULL JOIN M_DENETIM_EKIP USING (CALISMA_SURESI_ID)
				                            WHERE gorevlendirildigi_mali_yil=? AND ( DENETIM_ID IS NULL OR DENETIM_ID!=?)
				                            GROUP BY UZMAN_ID
				          ) USING (USER_ID)
				WHERE BASVURU_DURUM=2 AND DENETIM_ID = ?';
		
		
		$data = $db->prep_exec($sql, array(date('Y'),$denetim_id,$denetim_id));
		
		$sqlDis = "SELECT M_UZMAN_DIS.AD, M_UZMAN_DIS.SOYAD, M_UZMAN_DIS.GUN AS GOREVLENDIRILDIGI_GUN_SAYISI, PM_DENETIM_EKIP_ROLU.*
				FROM M_UZMAN_DIS
				JOIN PM_DENETIM_EKIP_ROLU ON (M_UZMAN_DIS.ROL = PM_DENETIM_EKIP_ROLU.ROL_ID) 
				WHERE M_UZMAN_DIS.DENETIM_ID = ?";
		
		$pat = $db->prep_exec($sqlDis, array($denetim_id));
		
		foreach ($pat as $row){
			$data[] = $row;
		}
		
		return $data;
	}
	
	function getDenetimRaporOnay($dId){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_DENETIM_RAPOR WHERE DENETIM_ID = ? AND DURUM = 1";
		if($db->prep_exec($sql, array($dId))){
			$sql = "SELECT * FROM M_DENETIM_RAPOR_ONAY WHERE DENETIM_ID = ? AND ONAY = 0";
			$data = $db->prep_exec($sql, array($dId));
			if($data){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
		
	}
	
	function getDenetimBasvurudakiSinavYerleri($kId,$dId,$durum = 1){
		$db = &JFactory::getOracleDBO();
		if($durum){
			$sql = "SELECT MSZ.*, ms.*, MY.YETERLILIK_ADI, MY.YETERLILIK_KODU, MY.SEVIYE_ID, MY.REVIZYON, PSS.SINAV_SEKLI_ADI, 
					PSM.MERKEZ_TEMIN_ADI, MSZ.MERKEZ_ID||'_'||MS.YETERLILIK_ID||'_'||MS.SINAV_SEKLI_ID AS MERKEZ 
					FROM M_DENETIM MD
					INNER JOIN M_SINAV_MERKEZI MSZ ON(MD.DENETIM_EVRAK_ID = MSZ.EVRAK_ID)
					JOIN m_merkez_sinav ms ON (MSZ.evrak_id = MS.EVRAK_ID AND MSZ.MERKEZ_ID = MS.MERKEZ_ID)   
		 	        JOIN m_yeterlilik MY ON (MS.yeterlilik_id = MY.YETERLILIK_ID)
		            JOIN pm_sinav_sekli PSS ON (MS.sinav_sekli_id = PSS.sinav_sekli_id)
		            JOIN pm_sinav_merkez_temin PSM ON (MSZ.MERKEZ_TEMIN_ID = PSM.merkez_temin_id) 
					WHERE MD.DENETIM_ID = ? 
					ORDER BY MSZ.MERKEZ_ADI ASC, MY.YETERLILIK_ADI ASC, MY.SEVIYE_ID ASC, MY.REVIZYON ASC, PSS.SINAV_SEKLI_ADI ASC";
			$data = $db->prep_exec($sql, array($dId));
		}else{
			$sql = "SELECT MSZ.*, ms.*, MY.YETERLILIK_ADI, MY.YETERLILIK_KODU, MY.SEVIYE_ID, MY.REVIZYON, PSS.SINAV_SEKLI_ADI, 
					PSM.MERKEZ_TEMIN_ADI, MSZ.MERKEZ_ID||'_'||MS.YETERLILIK_ID||'_'||MS.SINAV_SEKLI_ID AS MERKEZ 
					FROM M_BASVURU MB 
					INNER JOIN M_SINAV_MERKEZI MSZ ON(MB.EVRAK_ID = MSZ.EVRAK_ID)
					JOIN m_merkez_sinav ms ON (MSZ.evrak_id = MS.EVRAK_ID AND MSZ.MERKEZ_ID = MS.MERKEZ_ID)   
		 	        JOIN m_yeterlilik MY ON (MS.yeterlilik_id = MY.YETERLILIK_ID)
		            JOIN pm_sinav_sekli PSS ON (MS.sinav_sekli_id = PSS.sinav_sekli_id)
		            JOIN pm_sinav_merkez_temin PSM ON (MSZ.MERKEZ_TEMIN_ID = PSM.merkez_temin_id)
					WHERE MB.USER_ID = ? 
					ORDER BY MSZ.MERKEZ_ADI ASC, MY.YETERLILIK_ADI ASC, MY.SEVIYE_ID ASC, MY.REVIZYON ASC, PSS.SINAV_SEKLI_ADI ASC";
			$data = $db->prep_exec($sql, array($kId));
			
// 			$sql = "SELECT MBS.*, MY.YETERLILIK_ADI, MY.YETERLILIK_KODU, MY.SEVIYE_ID, MY.REVIZYON, PSS.SINAV_SEKLI_ADI, 
// 					PSM.MERKEZ_TEMIN_ADI, MBS.SINAV_YERI_ID||'_'||MBS.YETERLILIK_ID||'_'||MBS.SINAV_SEKLI_ID AS MERKEZ 
// 					FROM M_BELGELENDIRME_SINAV_YERI MBS 
// 					JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID) 
// 					JOIN pm_sinav_merkez_temin PSM ON (MBS.TEMIN_DURUMU = PSM.merkez_temin_id)
// 					WHERE MBS.ONAY_DURUMU = 1 AND KURULUS_ID = ?
// 					";
		}
		
		$sql = "SELECT MERKEZ_ID||'_'||YETERLILIK_ID||'_'||SINAV_SEKLI_ID AS MERKEZ FROM M_DENETIM_SINAV_MERKEZI WHERE DENETIM_ID = ?";
		$dataSM = $db->prep_exec_array($sql, array($dId));
		
		return array('allSM'=>$data,'savedSM'=>$dataSM);
	}
	
	function DenetimSMKaydet($post){
		$db = &JFactory::getOracleDBO();
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		
		$dId = $post['dId'];
		$sm = $post['sm'];
		
		$sqlIns = "INSERT INTO M_DENETIM_SINAV_MERKEZI (DENETIM_ID, MERKEZ_ID, YETERLILIK_ID, SINAV_SEKLI_ID) VALUES(?,?,?,?)";
		
		$sqlDel = "DELETE FROM M_DENETIM_SINAV_MERKEZI WHERE DENETIM_ID = ?";
		if($db->prep_exec_insert($sqlDel, array($dId))){
			$hata = 0;
			foreach($sm as $row){
				$dat = explode('_', $row);
				$mId = $dat[0];
				$yId = $dat[1];
				$sinavSekil = $dat[2];
				
				if(!$db->prep_exec_insert($sqlIns, array($dId,$mId,$yId,$sinavSekil))){
					$hata++;
				}
				
			}
			
			if($hata>0){
				return array('hata'=>1,'message'=>"Denetlenen Sınav Merkezleri Kaydedilirken Bir Hata Meydana geldi. Lütfen Tekrar Deneyin.");
			}else{
				return array('hata'=>0,'message'=>"Kayıt İşlemi Başarılı.");
			}
			
		}else{
			return array('hata'=>1,'message'=>"Denetlenen Sınav Merkezleri Kaydedilirken Bir Hata Meydana geldi. Lütfen Tekrar Deneyin.");
		}
	}
	
	function getDenetimBasvurudakiYeterlilik($kId,$dId,$durum = 1){
		$db = &JFactory::getOracleDBO();
		if($durum){
			$sql = "SELECT DISTINCT MY.* 
					FROM M_DENETIM MD
					INNER JOIN m_belgelendirme_yet_talebi MBY ON(MD.DENETIM_EVRAK_ID = MBY.EVRAK_ID)
					INNER JOIN M_YETERLILIK MY ON(MBY.YETERLILIK_ID = MY.YETERLILIK_ID)
					WHERE MD.DENETIM_ID = ?
					ORDER BY MY.YETERLILIK_ADI ASC, MY.SEVIYE_ID ASC, MY.REVIZYON ASC";
			$data = $db->prep_exec($sql, array($dId));
		}else{
// 			$sql = "SELECT DISTINCT MY.* 
// 					FROM M_BASVURU MB
// 					INNER JOIN m_belgelendirme_yet_talebi MBY ON(MB.EVRAK_ID = MBY.EVRAK_ID)
// 					INNER JOIN M_YETERLILIK MY ON(MBY.YETERLILIK_ID = MY.YETERLILIK_ID)
// 					WHERE MB.USER_ID = ?
// 					ORDER BY MY.YETERLILIK_ADI ASC, MY.SEVIYE_ID ASC, MY.REVIZYON ASC";
// 			$data = $db->prep_exec($sql, array($kId));

			$data = $this->getYetYetki($kId);
			$data2 = $this->yetkiDisiYets($kId);
			if(is_array($data2)){
				$data = $data+$data2;
			}
		}
	
		$sql = "SELECT YETERLILIK_ID FROM M_DENETIM_YETERLILIK WHERE DENETIM_ID = ?";
		$dataSM = $db->prep_exec_array($sql, array($dId));
	
		return array('allY'=>$data,'savedY'=>$dataSM);
	}
	
	private function getYetYetki($kurulus_id){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_YETERLILIK.* FROM M_BELGELENDIRME_YET_YETKI
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ?
				ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
	
		return $db->prep_exec($sql, array($kurulus_id));
	}
	
	private function yetkiDisiYets($kurulusId){
		$db = JFactory::getOracleDBO ();
		$sqlYet = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, REVIZYON
				FROM M_YETERLILIK
				WHERE YETERLILIK_KODU IN (SELECT DISTINCT YETERLILIK_KODU FROM M_BELGELENDIRME_YET_TALEBI
					JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_BASVURU USING(EVRAK_ID)
					WHERE USER_ID = ?)
				AND YETERLILIK_ID NOT IN(SELECT DISTINCT YETERLILIK_ID FROM M_BELGELENDIRME_YET_YETKI WHERE USER_ID=?)
				AND YETERLILIK_DURUM_ID = 2
				ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC, REVIZYON ASC";
	
		return $db->prep_exec($sqlYet, array($kurulusId,$kurulusId));
	}
	
	function DenetimYetKaydet($post){
		$db = &JFactory::getOracleDBO();
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
	
		$dId = $post['dId'];
		$sm = $post['sm'];
	
		$sqlIns = "INSERT INTO M_DENETIM_YETERLILIK (DENETIM_ID, YETERLILIK_ID) VALUES(?,?)";
	
		$sqlDel = "DELETE FROM M_DENETIM_YETERLILIK WHERE DENETIM_ID = ?";
		if($db->prep_exec_insert($sqlDel, array($dId))){
			$hata = 0;
			foreach($sm as $row){
	
				if(!$db->prep_exec_insert($sqlIns, array($dId,$row))){
					$hata++;
				}
	
			}
				
			if($hata>0){
				return array('hata'=>1,'message'=>"Denetlenen Yeterlilikler Kaydedilirken Bir Hata Meydana geldi. Lütfen Tekrar Deneyin.");
			}else{
				return array('hata'=>0,'message'=>"Kayıt İşlemi Başarılı.");
			}
				
		}else{
			return array('hata'=>1,'message'=>"Denetlenen Yeterlilikler Kaydedilirken Bir Hata Meydana geldi. Lütfen Tekrar Deneyin.");
		}
	}

    public function getAkIcDenetimEkleri($kId){
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT * FROM M_KURULUS_EK WHERE KURULUS_ID = ? AND BELGE_TUR = ? AND DURUM = 2";
        $dataAk = $db->prep_exec($sql, array($kId,'akdenetim'));
        $dataIc = $db->prep_exec($sql, array($kId,'icdenetim'));

        return array('akdenetim'=>$dataAk, 'icdenetim'=>$dataIc);
    }
}
?>