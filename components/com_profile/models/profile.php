<?php

defined('_JEXEC') or die('Restricted access');

class ProfileModelProfile extends JModel {
	
	var $title 	  = "Kuruluş Profili"; 
	var $pages 	  = array ("kurulus_bilgi","irtibat","faaliyet","kapsam","ek","basvuru_dokumani");
	var $pageNames= array ("Kuruluş Bilgileri","İrtibat Bilgileri", "Faaliyet Bilgileri","Standart Kapsamı", "Kişi Bilgi Eki", "Başvuru Dökümanı");
	
	function profileKaydet ($post, $files, $layout, $kurulus_id){
		$session = &JFactory::getSession ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		switch ($layout){
			case "kurulus_bilgi":
				$returns = $this->KurulusBilgiKaydet($post,$files,$kurulus_id);
				return $returns;
			break;
			default:
		}
	}
	
	
	function KurulusBilgiKaydet($post,$files,$kurulus_id){
		$db  = &JFactory::getOracleDBO();
		
		$edit_id = array_key_exists('edit_id', $post)?$post['edit_id']:0;
		
		if($edit_id){
			return $this->KurulusEditUpdate($post,$files,$kurulus_id,$edit_id);
		}else{
			return $this->KurulusInsertEdit($post, $files, $kurulus_id);
		}
	}
	
	function KurulusEditUpdate($post,$files,$kurulus_id,$edit_id){
		$db  = &JFactory::getOracleDBO();
		
		$sqlIlkBilgi = "SELECT * FROM M_KURULUS WHERE USER_ID=?";
		$kurIlkBilgi = $db->prep_exec($sqlIlkBilgi, array($kurulus_id));
		
		if($post['yenilogo']){
			if($files['logo']['error'] == 0 && ($files["logo"]["type"] == 'image/jpg'
					|| $files["logo"]["type"] == 'image/jpeg'
					|| $files["logo"]["type"] == 'image/png'
					|| $files["logo"]["type"] == 'image/x-png'
					|| $files["logo"]["type"] == 'image/pjpeg')){
		
				$directory = EK_FOLDER."kurulus_logo/".$kurulus_id;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
		
				$fileName = explode('.',$files['logo']['name']);
				$name = $kurIlkBilgi[0]['KURULUS_YETKILENDIRME_NUMARASI'].'_'.$edit_id.'.'.$fileName[count($fileName)-1];
				$path = $directory.'/'.$name;
				if(!move_uploaded_file($files['logo']['tmp_name'], $path)){
					return 'Logo yükleme işleminde hata meydana geldi. Lütfen resim formatında tekrar deneyiniz.';
				}
				$getLogo = $name;
			}
		}else{
			$sqlBilgi = "SELECT LOGO FROM M_KURULUS_EDIT WHERE EDIT_ID = ? ";
			$dat = $db->prep_exec($sqlBilgi, array($edit_id));
			$getLogo = $dat[0]['LOGO'];
		}
		
		$sql = "UPDATE M_KURULUS_EDIT SET KURULUS_STATU_ID=?,KURULUS_ADI=?,KURULUS_KISA_ADI=?,VERGI_KIMLIK_NO=?,KURULUS_YETKILISI=?,KURULUS_YETKILI_UNVANI=?,
				KURULUS_ADRESI=?,KURULUS_POSTA_KODU=?,KURULUS_TELEFON=?,KURULUS_FAKS=?,KURULUS_EPOSTA=?,KURULUS_WEB=?,KURULUS_SEHIR=?,
				LOGO = ?, TARIH=TO_DATE(sysdate,'dd/mm/yyyy') WHERE EDIT_ID = ? AND USER_ID = ?";
		
		$params = array(
				$post['statu_edit'],
				$post['ad_edit'],
				$post['kisa_ad_edit'],
                $post['vergino_edit'],
				$post['yetkili_edit'],
				$post['unvan_edit'],
				$post['adres_edit'],
				$post['posta_kodu_edit'],
				$post['telefon_edit'],
				$post['faks_edit'],
				$post['eposta_edit'],
				$post['web_edit'],
				$post['sehir_edit'],
				$getLogo,
				$edit_id,
				$kurulus_id
		);
		
		$return = $db->prep_exec_insert($sql, $params);
		
		if($return){
			
			$sqlDeleteil = "DELETE FROM M_KURULUS_FALIYET_IL_EDIT WHERE EDIT_ID = ?";
			$db->prep_exec($sqlDeleteil, array($edit_id));
			
			$sqlIllerIN = "INSERT INTO M_KURULUS_FALIYET_IL_EDIT (EDIT_ID,USER_ID,IL_ID) VALUES(?,?,?)";
			
			foreach($post['iller_edit'] as $row){
				$db->prep_exec_insert($sqlIllerIN, array($edit_id,$kurulus_id,$row));
			}
			
			return 'Profil güncelleme işlemeniz başarıyla gerçekleşmiş ve dosya sorumlunuzun onayına sunulmuştur.';
		}else{
			return 'Profil güncelleme işlemenizde hata meydana gelmiştir. Lütfen tekrar deneyiniz.';
		}
		
	}
	
	function KurulusInsertEdit($post,$files,$kurulus_id){
		$db  = &JFactory::getOracleDBO();
		
		$sqlIlkBilgi = "SELECT * FROM M_KURULUS WHERE USER_ID=?";
		$kurIlkBilgi = $db->prep_exec($sqlIlkBilgi, array($kurulus_id));
		
		$edit_id = $db->getNextVal('SEQ_KURULUS_EDIT');
		
		if($post['yenilogo']){
			if($files['logo']['error'] == 0 && ($files["logo"]["type"] == 'image/jpg' 
				|| $files["logo"]["type"] == 'image/jpeg' 
				|| $files["logo"]["type"] == 'image/png' 
				|| $files["logo"]["type"] == 'image/x-png' 
				|| $files["logo"]["type"] == 'image/pjpeg')){
				
				$directory = EK_FOLDER."kurulus_logo/".$kurulus_id;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
				
				$fileName = explode('.',$files['logo']['name']);					
				$name = $kurIlkBilgi[0]['KURULUS_YETKILENDIRME_NUMARASI'].'_'.$edit_id.'.'.$fileName[count($fileName)-1];
				$path = $directory.'/'.$name;
				if(!move_uploaded_file($files['logo']['tmp_name'], $path)){
					return 'Logo yükleme işleminde hata meydana geldi. Lütfen resim formatında tekrar deneyiniz.';
				}
				$getLogo = $name;
			}
		}else{
			$sqlBilgi = "SELECT LOGO FROM M_KURULUS_EDIT WHERE USER_ID=? AND AKTIF = 1 AND ONAY_BEKLEYEN = 0";
			$getLogo = $db->prep_exec($sqlBilgi, array($kurulus_id));
			if(!$getLogo){
				$sqlBilgi = "SELECT LOGO FROM M_KURULUS WHERE USER_ID=?";
				$dat = $db->prep_exec($sqlBilgi, array($kurulus_id));
				$getLogo = $dat;
			}
			$getLogo = $getLogo[0]['LOGO'];
		}
		
		$sql = "INSERT INTO M_KURULUS_EDIT (EDIT_ID,USER_ID,KURULUS_STATU_ID,KURULUS_ADI,KURULUS_KISA_ADI,VERGI_KIMLIK_NO,KURULUS_YETKILISI,KURULUS_YETKILI_UNVANI,
				KURULUS_ADRESI,KURULUS_POSTA_KODU,KURULUS_TELEFON,KURULUS_FAKS,KURULUS_EPOSTA,KURULUS_WEB,KURULUS_SEHIR,
				LOGO,TARIH,AKTIF,ONAY_BEKLEYEN) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,TO_DATE(sysdate,'dd/mm/yyyy'),0,1)";
		
		$params = array(
				$edit_id,
				$kurulus_id,
				$post['statu_edit'],
				$post['ad_edit'],
				$post['kisa_ad_edit'],
                $post['vergino_edit'],
				$post['yetkili_edit'],
				$post['unvan_edit'],
				$post['adres_edit'],
				$post['posta_kodu_edit'],
				$post['telefon_edit'],
				$post['faks_edit'],
				$post['eposta_edit'],
				$post['web_edit'],
				$post['sehir_edit'],
				$getLogo
		);
		
		$return = $db->prep_exec_insert($sql, $params);
		
		if($return){
			$sqlIllerIN = "INSERT INTO M_KURULUS_FALIYET_IL_EDIT (EDIT_ID,USER_ID,IL_ID) VALUES(?,?,?)";
			
			foreach($post['iller_edit'] as $row){
				$db->prep_exec_insert($sqlIllerIN, array($edit_id,$kurulus_id,$row));
			}
			
			return 'Profil güncelleme işlemeniz başarıyla gerçekleşmiş ve dosya sorumlunuzun onayına sunulmuştur.';
		}else{
			return 'Profil güncelleme işlemenizde hata meydana gelmiştir. Lütfen tekrar deneyiniz.';
		}
	}
	
	function getAllKurulus($kurulus_durum=TUM_KURULUS_DURUM_IDS){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.")
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND KURULUS_DURUM_ID IN(".$kurulus_durum.")
				  ORDER BY KURULUS_ADI ASC";
		return $db->prep_exec($sql, array());
	}
	
	function getKurulusBilgi($kurulus){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_KURULUS WHERE USER_ID=?";
		return $db->prep_exec($sql, array($kurulus));
	}
	
	function KurulusEditBilgi($kurulusId){
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
	
	function KurulusBekleyenBilgi($kurulusId){
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT *
				FROM M_KURULUS_EDIT
					LEFT JOIN pm_kurulus_statu USING (KURULUS_STATU_ID)
					LEFT JOIN ".DB_PREFIX.".p_il ON (il_id = kurulus_sehir)
				WHERE user_id = ? AND ONAY_BEKLEYEN = 1 AND AKTIF = 0";
		
		$data = $db->prep_exec($sql, array($kurulusId));
		
		if (!empty($data)){
			return $data[0];
		}
		else{
			return false;
		}
		
	}
	
	function getKurulusIlEdit($edit_id, $pdf = 0){
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
	
	function ProfilOnayla($post){
		$db = & JFactory::getOracleDBO();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$sqlKurulusId = "SELECT USER_ID FROM M_KURULUS_EDIT WHERE EDIT_ID = ?";
		$kurId = $db->prep_exec_array($sqlKurulusId, array($post['editId']));
		
		$sqlUpEski = "UPDATE M_KURULUS_EDIT SET AKTIF = 0, ONAY_BEKLEYEN = 0 WHERE USER_ID = ?";
		if($db->prep_exec_insert($sqlUpEski, $kurId)){
			$sql = "UPDATE M_KURULUS_EDIT SET AKTIF = 1, ONAY_BEKLEYEN = 0, SEKTOR_SORUMLUSU = ? WHERE EDIT_ID = ?";
			return $db->prep_exec_insert($sql, array($user_id,$post['editId']));
		}else{
			return false;
		}
	}
	
	function BasvuruGetir($kurulusId,$tip=null){
		$db = & JFactory::getOracleDBO();
		
		if(empty($tip) || $tip == null){
			$sql = "SELECT EVRAK_ID, USER_ID, BASVURU_TIP_ID, BASVURU_TIP_ADI, BASVURU_TARIHI, 
					BASVURU_DURUM_ADI FROM M_BASVURU
				JOIN PM_BASVURU_DURUM USING(BASVURU_DURUM_ID)
				JOIN PM_BASVURU_TIP USING(BASVURU_TIP_ID)
				WHERE USER_ID = ? AND BASVURU_TIP_ID IN (1,2,3,4)
				ORDER BY BASVURU_TIP_ID ASC, EVRAK_ID DESC";
			
			$data = $db->prep_exec($sql, array($kurulusId));
		}else{
			$sql = "SELECT EVRAK_ID, USER_ID, BASVURU_TIP_ID, BASVURU_TIP_ADI, BASVURU_TARIHI, 
					BASVURU_DURUM_ADI FROM M_BASVURU
				JOIN PM_BASVURU_DURUM USING(BASVURU_DURUM_ID)
				JOIN PM_BASVURU_TIP USING(BASVURU_TIP_ID)
				WHERE USER_ID = ? AND BASVURU_TIP_ID = ?
				ORDER BY BASVURU_TIP_ID ASC, EVRAK_ID DESC";
			
			$data = $db->prep_exec($sql, array($kurulusId,$tip));
		}
		
		if($data){
			return $data;
		}
		else{
			return false;
		}
	}
	
	function getYetkiliYeterlilik($kurulus_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK.REVIZYON
			FROM M_YETERLILIK 
		  	JOIN M_BELGELENDIRME_YET_YETKI ON (M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID)
			WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1	
			AND M_BELGELENDIRME_YET_YETKI.USER_ID = ?
			ORDER BY YETERLILIK_ADI";
		
		$data = $db->prep_exec($sql, array($kurulus_id));
		
		if($data){
			return $data;
		}
		else{
			return false;
		}
	}
	
	function YetkiliBirims($kurulusId, $yetId){
		$db = & JFactory::getOracleDBO();
		
		$sqlYets = "SELECT *
		    	FROM m_yeterlilik
		    	WHERE m_yeterlilik.yeterlilik_id = ?";
		
		$yets = $db->prep_exec($sqlYets, array($yetId));
		
		if($yets[0]['YENI_MI'] == 0){
			$sql = "SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, 
					M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, M_BELGELENDIRME_YET_YETKI.YETKININ_VERILDIGI_TARIH AS TARIH 
					FROM M_BELGELENDIRME_YET_YETKI
					JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_YET_YETKI.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
					WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ? 
					AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
					AND M_BELGELENDIRME_YET_YETKI.YET_ESKI_MI = 1
					AND M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = ?
					ORDER BY M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO ";
			
			$data = $db->prep_exec($sql, array($kurulusId,$yetId));
			
		}else{
			$sql = "SELECT M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU, M_BELGELENDIRME_YET_YETKI.YETKININ_VERILDIGI_TARIH AS TARIH 
					FROM M_BELGELENDIRME_YET_YETKI
					JOIN M_BIRIM ON M_BELGELENDIRME_YET_YETKI.BIRIM_ID = M_BIRIM.BIRIM_ID
					WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ? 
					AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
					AND M_BELGELENDIRME_YET_YETKI.YET_ESKI_MI = 0
					AND M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = ?
					ORDER BY M_BIRIM.BIRIM_KODU";
			
			$data = $db->prep_exec($sql, array($kurulusId,$yetId));
		}
		
		return array(0=>$yets[0],1=>$data);
	}
	
	function getDegerlendirici($kurulusId){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT TC_KIMLIK, ADI, SOYADI, BEYAN, CV, ONAY_BEKLEYEN FROM M_BELGELENDIRME_DGRLNDRC_KRLS 
				JOIN M_BELGELENDIRME_DEGERLENDIRICI USING(TC_KIMLIK) 
				JOIN M_YETERLILIK USING(YETERLILIK_ID) 
				WHERE ETKIN = 1 AND KURULUS_ID = ?
        		ORDER BY ADI ASC, SOYADI ASC";

		$data = $db->prep_exec($sql, array($kurulusId));
		
		if($data){
			$sqlYets = "SELECT * FROM M_BELGELENDIRME_DGRLNDRC_KRLS 
						JOIN M_YETERLILIK USING(YETERLILIK_ID) 
						WHERE ETKIN = 1 AND KURULUS_ID = ? AND TC_KIMLIK = ?
						ORDER BY YETERLILIK_ADI ASC";
			$deger = array();
			foreach($data as $row){
				$deger[$row['TC_KIMLIK']] = $db->prep_exec($sqlYets, array($kurulusId,$row['TC_KIMLIK']));
			}
			return array(0=>$data,1=>$deger);
		}
		else{
			return false;
		}
	}
	
	function getProgramSinavYeri($user_id){
		$_db = JFactory::getOracleDBO ();
		
		$sql = "SELECT M_BELGELENDIRME_SINAV_YERI.*, M_YETERLILIK.*,
					M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
					FROM M_BELGELENDIRME_SINAV_YERI
				JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV_YERI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
				WHERE M_BELGELENDIRME_SINAV_YERI.KURULUS_ID=?
				 ORDER BY M_BELGELENDIRME_SINAV_YERI.BILDIRIM_DURUMU DESC, M_YETERLILIK.YETERLILIK_KODU ASC,M_YETERLILIK.YETERLILIK_ADI ASC ";
		
		$data = $_db->prep_exec($sql, array($user_id));
		
		$yers = array();
		foreach ($data as $row){
			if(in_array($row['SINAV_YERI_ID'], $yers)){
				$yers[$row['SINAV_YERI_ID']] = array();
			}
			$yers[$row['SINAV_YERI_ID']][] = $row;
		}
		return $yers;
	}
	
	function SinavSearch($kurulusId, $sinavTipi){
		$_db = JFactory::getOracleDBO();
	
		if($sinavTipi == 3){
				
			$sql = "select m_belgelendirme_sinav.*,m_yeterlilik.*,m_kurulus.*,
					m_yeterlilik_revizyon.revizyon_no, m_yeterlilik_revizyon.revizyon_durumu, m_yeterlilik_revizyon.yeterlilik_kodu as yeterlilik_rev_kod
					 from m_belgelendirme_sinav
					  join m_yeterlilik on m_belgelendirme_sinav.yeterlilik_id = m_yeterlilik.yeterlilik_id
					  join m_kurulus on kurulus_id = m_kurulus.user_id
					left join m_yeterlilik_revizyon on m_yeterlilik.yeterlilik_id = m_yeterlilik_revizyon.yeterlilik_id
					where ((bildirim_durumu = 0 AND BASLANGIC_TARIHI<TO_DATE(sysdate, 'dd/mm/yyyy')) OR (GECERLILIK_DURUMU = 2) OR (bildirim_durumu=1 AND BASLANGIC_TARIHI<TO_DATE(sysdate, 'dd/mm/yyyy') AND SINAV_ID NOT IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_SINAV_DOSYA)))";
				
			
				$sql .= " and m_belgelendirme_sinav.kurulus_id =".$kurulusId;
				
			return $_db->prep_exec($sql, array());
				
		}else{
			$sql = "select m_belgelendirme_sinav.*,m_yeterlilik.*,m_kurulus.*,
					m_yeterlilik_revizyon.revizyon_no, m_yeterlilik_revizyon.revizyon_durumu, m_yeterlilik_revizyon.yeterlilik_kodu as yeterlilik_rev_kod
					 from m_belgelendirme_sinav
					  join m_yeterlilik on m_belgelendirme_sinav.yeterlilik_id = m_yeterlilik.yeterlilik_id
					  join m_kurulus on kurulus_id = m_kurulus.user_id
					left join m_yeterlilik_revizyon on m_yeterlilik.yeterlilik_id = m_yeterlilik_revizyon.yeterlilik_id";
	
			if($sinavTipi == 1){
				$durum = 2;
			}else{
				$durum = 1;
			}
			$sql .= " where sonuc_durumu =".$durum." AND GECERLILIK_DURUMU = 1 AND bildirim_durumu = 1
					AND ((BASLANGIC_TARIHI<TO_DATE(sysdate, 'dd/mm/yyyy') AND SINAV_ID IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_SINAV_DOSYA)) OR (BASLANGIC_TARIHI>=TO_DATE(sysdate, 'dd/mm/yyyy')))";
	
			$sql .= " and m_belgelendirme_sinav.kurulus_id =".$kurulusId;
	
			$sql .= " order by m_belgelendirme_sinav.baslangic_tarihi asc";
	
			return $_db->prep_exec($sql, array());
		}
	}
	
	function getYetBelge($kurulusId){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT YETERLILIK_ID, COUNT(BELGENO) AS BELSAY
				FROM M_BELGE_SORGU
				WHERE KURULUS_ID = ?
				AND BELGENO NOT IN (SELECT BELGE_NO FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE KURULUS_ID = ?)
				GROUP BY YETERLILIK_ID
				ORDER BY YETERLILIK_ID";
		
		$dataBel = $db->prep_exec($sql, array($kurulusId,$kurulusId));
		
		$sqlHak = "select count(belge_no) as HAKSAY, yeterlilik_id from m_belgelendirme_hak_kazananlar
				where kurulus_id = ? and durum = 2
				group by yeterlilik_id
				order by yeterlilik_id";
		
		$dataHak = $db->prep_exec($sqlHak, array($kurulusId));
		
		$BelSayArray = array();
		
		foreach($dataBel as $row){
			$yets = FormFactory::getYets($row['YETERLILIK_ID']);
			$BelSayArray[$row['YETERLILIK_ID']] = array("BELSAY"=>$row['BELSAY'],
					"YETERLILIK_ADI"=>$yets['YETERLILIK_ADI'],
					"YETERLILIK_KODU"=>$yets['YETERLILIK_KODU'],
					"REVIZYON"=>$yets['REVIZYON'],
					"HAKSAY"=>0
			);
		}
		
		foreach($dataHak as $cow){
			if(!array_key_exists($cow['YETERLILIK_ID'], $BelSayArray)){
				$yets = FormFactory::getYets($cow['YETERLILIK_ID']);
				$BelSayArray[$cow['YETERLILIK_ID']] = array("HAKSAY"=>$cow['HAKSAY'],
						"YETERLILIK_ADI"=>$yets['YETERLILIK_ADI'],
						"YETERLILIK_KODU"=>$yets['YETERLILIK_KODU'],
						"REVIZYON"=>$yets['REVIZYON'],
						"BELSAY"=>0
				);
			}else{
				$BelSayArray[$cow['YETERLILIK_ID']]['HAKSAY'] = $cow['HAKSAY'];
			}
		}
		
		if($BelSayArray){
			return $BelSayArray;
		}else{
			return false;
		}
		
	}
	
	function docFormKaydet($post, $files, $kurulusId){
		$db = & JFactory::getOracleDBO();
		
		foreach ($files as $key=>$val){
			$typeN = explode('.', $val['name']);
			$type = $typeN[count($typeN)-1];
			if($val['type'] == 'application/pdf' || $val['type'] == 'application/msword' || $val['type'] == 'application/vnd.ms-excel' || $val['type'] == 'application/zip' 
					|| $val['type'] == 'application/x-rar-compressed' || $val['type'] == 'image/png' || $val['type'] == 'image/jpeg' || $val['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' 
		 			|| $val['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' 
					|| $val['type'] == '?application/octet-stream' || $type == 'zip' || $type == 'rar'){
				
				if($val['error'] > 0){
					return false;
				}else{
					$directory = EK_FOLDER.'kurulusEk/'.$kurulusId.'/'.$key;
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$name = FormFactory::formatFilename($val['name']);
					$path = 'kurulusEk/'.$kurulusId.'/'.$key.'/'.$name;
					
					if(move_uploaded_file($val['tmp_name'], $directory.'/'.$name)){
						$ek = array(
							$db->getNextVal('SEQ_KURULUS_EK'),
							$name,
							$path,
							$key,
							date('d/m/Y'),
							$kurulusId
						);
						
						$sql = "INSERT INTO M_KURULUS_EK (ID,BELGE,BELGE_PATH,BELGE_TUR,TARIH,KURULUS_ID) VALUES(?,?,?,?,?,?)";
						
						return $db->prep_exec_insert($sql, $ek);
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}
	}
	
	function getEks($kurulusId){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_KURULUS_EK WHERE KURULUS_ID = ? ORDER BY TARIH ASC";
		
		return $db->prep_exec($sql, array($kurulusId));
	}
	
	function BasvuruEks($kurulusId){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_BASVURU_EKLERI WHERE USER_ID = ?";
		$data = $db->prep_exec($sql, array($kurulusId));
		
		$belgeTuru = array();
		
		foreach ($data as $row){
			$belgeTuru[$row['BELGE_TURU']][] = $row;
		}
		
		return $belgeTuru;
	}
	
	function DocsOnayla($post,$kurulusId){
		$db = &JFactory::getOracleDBO();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$sql = "UPDATE M_KURULUS_EK SET DURUM = ? WHERE ID=? AND KURULUS_ID=?";
		
		$return = $db->prep_exec_insert($sql, array(2,$post['docId'],$kurulusId));
	}
	
	function DocsOnayKaldir($post,$kurulusId){
		$db = &JFactory::getOracleDBO();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$sql = "UPDATE M_KURULUS_EK SET DURUM = ? WHERE ID=? AND KURULUS_ID=?";
		
		$return = $db->prep_exec_insert($sql, array(1,$post['docId'],$kurulusId));
	}
	
	function DocsSil($post,$kurulusId){
		$db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM M_KURULUS_EK WHERE ID = ? AND KURULUS_ID = ? AND DURUM = 1";
		
		return $db->prep_exec($sql, array($post['docId'],$kurulusId));
	}
	
	function dosyaSorumlusu($kurulusId){
		$db = &JFactory::getOracleDBO();
		
		$sql = "SELECT TGUSERID FROM M_KURULUS_GOREVLI WHERE KURULUS_ID=? 
				ORDER BY BIRINCIL ASC";
		
		$data = $db->prep_exec($sql, array($kurulusId));
		
		$gorevli = array();
		
		foreach($data as $val){
			$mysqlDB = &JFactory::getDBO();
			
			$sqlMatbaa= "SELECT name FROM #__users as users
						WHERE tgUserId = ".$val['TGUSERID'];
			$mysqlDB->setQuery($sqlMatbaa);
			$gorevli[] = $mysqlDB->loadObjectList();
		}
		
		return $gorevli;
	}
	
	function getSinavYerleri($user_id){
		$_db = JFactory::getOracleDBO ();
	
		$sqlYerId = "SELECT DISTINCT SINAV_YERI_ID, YER_ADI, ADRES FROM M_BELGELENDIRME_SINAV_YERI WHERE KURULUS_ID = ? ORDER BY SINAV_YERI_ID ASC";
		$data = $_db->prep_exec($sqlYerId, array($user_id));
		
		if($data){
			return $data;
		}else{
			return false;
		}
		
	}
	
	function NotGetir($kurulusId,$notid = null,$user_id = null){
		$db = JFactory::getOracleDBO ();
		if($notid == null){
			$sql = "SELECT M_NOT.NOTU,
						   M_NOT.ID,
						   M_NOT.PUAN,
						   M_NOT.EKLENME_TARIHI,M_NOT.TGUSERID,M_KURULUS.KURULUS_ADI
					  FROM M_NOT
				INNER JOIN M_KURULUS ON M_NOT.KURULUS_ID = M_KURULUS.USER_ID WHERE M_KURULUS.USER_ID = ".$kurulusId;
		}else{
			$sql = "SELECT M_NOT.NOTU,
						   M_NOT.ID,
						   M_NOT.PUAN,
						   M_NOT.EKLENME_TARIHI,M_NOT.TGUSERID,M_KURULUS.KURULUS_ADI 
					  FROM M_NOT 
				INNER JOIN M_KURULUS ON M_NOT.KURULUS_ID = M_KURULUS.USER_ID WHERE M_NOT.ID = ".$notid." AND M_NOT.TGUSERID = ".$user_id;
		}
		$notDatas = $db->prep_exec($sql, array());
		$mysqlDB = &JFactory::getDBO();
		$datas = array();
		$i = 0;
		foreach ($notDatas as $notData){
			$sql= "SELECT name FROM jos_users
						WHERE tgUserId = ".$notData['TGUSERID'];
			$mysqlDB->setQuery($sql);
			$username = $mysqlDB->loadObjectList();
			$datas[$i] = array("NOTID"=>$notData['ID'],
							   "NOTU" => substr($notData['NOTU'],0,20),
							   "PUAN" => $notData['PUAN'],
							   "EKLENME_TARIHI" => $notData['EKLENME_TARIHI'],
							   "TGUSERID" => $notData['TGUSERID'],
							   "KURULUS_ADI" => $notData['KURULUS_ADI'],
							   "USERNAME" => $username[0]->name);
			$i++;
		}
		return $datas;
	}
	function NotEkle($post,$user_id){
		$db = &JFactory::getOracleDBO();
	
		$sql = "INSERT INTO M_NOT (NOTU,PUAN,TGUSERID,EKLENME_TARIHI,KURULUS_ID) VALUES(?,?,?,TO_DATE(sysdate,'dd/mm/yyyy'),?)";
		$params = array(
			$post['not'],
			$post['puan'],
			$user_id,
			$post['kurulusId']
		);
		$return = $db->prep_exec_insert($sql, $params);
		if($return){
			return "Not ekleme işlemi başarıyla gerçekleştirildi.";
		}else{
			return "Not ekleme işlemde hata oluştu.";
		}
	}
	
	function NotSil($post){
		$db = &JFactory::getOracleDBO();
	
		$sql = "DELETE FROM M_NOT WHERE ID = ?";
	
		return $db->prep_exec($sql, array($post['notId']));
	}

	function NotGuncelle($post,$user_id){
		$db = &JFactory::getOracleDBO();
	
		$sql = "UPDATE M_NOT SET M_NOT.PUAN=?,M_NOT.NOTU=?, M_NOT.TGUSERID=? WHERE M_NOT.ID=".$post['notId'];
	
		$return = $db->prep_exec_insert($sql, array($post['puan'],$post['not'],$user_id));
	
		if($return){
			$data['STATUS'] = 1;
			$data['STATUSNAME'] = 'Not güncelleme işlemeniz başarıyla gerçekleştirilmiştir.';
		}else{
			$data['STATUS'] = 1;
			$data['STATUSNAME'] = 'Not güncelleme işlemenizde hata meydana gelmiştir. Lütfen tekrar deneyiniz.';
		}
		return $data;
	}

	/* 
	 * Kurulusun sınavına giren adayların sayısı
	 * (yeterlilik bazında çekiliyor veriler)
	 * Bu fonksiyonu kullanmıyoruz artık
	 */
	function getKurulusSinavaGiren($kurulusId){
		$db = &JFactory::getOracleDBO();
	
		$sql = "select count(tc_kimlik) as say, yeterlilik_kodu, seviye_id, yeterlilik_adi, yeterlilik_id 
				from (select distinct tc_kimlik, seviye_id, yeterlilik_kodu, yeterlilik_adi,yeterlilik_id from m_belgelendirme_sinav
				join m_belgelendirme_aday_bildirim using(sinav_id,kurulus_id,yeterlilik_id)
				join m_yeterlilik using(yeterlilik_id)
				where sonuc_durumu = 2 and kurulus_id = ?)
				group by yeterlilik_kodu, yeterlilik_adi, seviye_id, yeterlilik_id
				order by yeterlilik_adi";
	
		$data = $db->prep_exec($sql, array($kurulusId));
		
		if($data){
			$return = array();
			foreach($data as $row){
				$return[$row['YETERLILIK_ID']] = $row;
			}
			return $return;
		}else{
			return false;
		}
	}
	
	/*
	 * Kurulusun sınavına girip, başarılı adayların sayısı
	 * (yeterlilik bazında çekiliyor veriler)
	 * Bu fonksiyonu kullanmıyoruz artık
	 */
	function getKurulusSinavBasarililar($kurulusId){
		$db = &JFactory::getOracleDBO();
	
		$sql = "select count(tc_kimlik) as say, yeterlilik_kodu, seviye_id, yeterlilik_adi, yeterlilik_id 
				from (select distinct tc_kimlik, seviye_id, yeterlilik_kodu, yeterlilik_adi, yeterlilik_id from m_belgelendirme_sinav
				join m_belgelendirme_hak_kazananlar using(yeterlilik_id, kurulus_id)
				join m_yeterlilik using(yeterlilik_id)
				where sonuc_durumu = 2 and kurulus_id = ?)
				group by yeterlilik_kodu, yeterlilik_adi, seviye_id, yeterlilik_id
				order by yeterlilik_adi";
	
		$data = $db->prep_exec($sql, array($kurulusId));
		if($data){
			$return = array();
			foreach($data as $row){
				$return[$row['YETERLILIK_ID']] = $row;
			}
			return $return;
		}else{
			return false;
		}
	}
	
	function getKurulusSinavGirenAndBasarili($kurulusId){
		$db = &JFactory::getOracleDBO();
		
		$sql = "select yeterlilik_id, yeterlilik_kodu, seviye_id, yeterlilik_adi, sinava_giren, belge_alan
from (select count(tc_kimlik) as sinava_giren, yeterlilik_kodu, seviye_id, yeterlilik_adi, yeterlilik_id 
				from (select distinct BA.tc_kimlik, M_YETERLILIK.seviye_id, M_YETERLILIK.yeterlilik_kodu, M_YETERLILIK.yeterlilik_adi,M_YETERLILIK.yeterlilik_id from m_belgelendirme_sinav bs
				join m_belgelendirme_aday_bildirim ba on (BS.sinav_id = BA.SINAV_ID)
				join m_yeterlilik on (ba.yeterlilik_id = M_YETERLILIK.yeterlilik_id)
				where bs.sonuc_durumu = 2 and ba.kurulus_id = ?)
				group by yeterlilik_kodu, yeterlilik_adi, seviye_id, yeterlilik_id
				order by yeterlilik_adi) sa

left join (
select count(tc_kimlik) as belge_alan, yeterlilik_id 
				from (select distinct tc_kimlik, seviye_id, yeterlilik_kodu, yeterlilik_adi, yeterlilik_id from m_belgelendirme_sinav
				join m_belgelendirme_hak_kazananlar using(yeterlilik_id, kurulus_id)
				join m_yeterlilik using(yeterlilik_id)
				where sonuc_durumu = 2 and kurulus_id = ? and DURUM = 2)
				group by yeterlilik_kodu, yeterlilik_adi, seviye_id, yeterlilik_id
				order by yeterlilik_adi
) ba
using(YETERLILIK_ID)";
		$data = $db->prep_exec($sql, array($kurulusId,$kurulusId));
		
		$BassizAday = array();
		
		foreach($data as $row){
			$bassiz = 0;
			$altTip = BelgelendirmeModelBelgelendirme_Islemleri::AlternatifTipi($row['YETERLILIK_ID']);
			$altBirim = BelgelendirmeModelBelgelendirme_Islemleri::AlteratifBirim($row['YETERLILIK_ID']);
			$BasSizAdaylarSql = "SELECT DISTINCT BA.TC_KIMLIK FROM M_BELGELENDIRME_ADAY_BILDIRIM BA
								INNER JOIN M_BELGELENDIRME_SINAV BS ON BA.SINAV_ID = BS.SINAV_ID
								WHERE BA.TC_KIMLIK NOT IN(SELECT DISTINCT TC_KIMLIK FROM M_BELGELENDIRME_HAK_KAZANANLAR 
								WHERE KURULUS_ID = ? AND YETERLILIK_ID = ?)
								AND BA.KURULUS_ID = ? AND BA.YETERLILIK_ID = ? AND BS.SONUC_DURUMU = 2";
			$adays = $db->prep_exec_array($BasSizAdaylarSql, array($kurulusId,$row['YETERLILIK_ID'],$kurulusId,$row['YETERLILIK_ID']));
			
			if($adays){
				foreach ($adays as $cow){
					$sonucBirim = $this->BasarisizMi($cow,$row['YETERLILIK_ID'],$altTip,$altBirim,date('d/m/Y'));
					if($sonucBirim != false){
						$bassiz++;
					}
				}
			}
			$BassizAday[$row['YETERLILIK_ID']] = $bassiz;
			
		}
		return array(0=>$data,1=>$BassizAday);
	}
	
	// YENİ Başarılı aday sorgusu
	function getKurulusSinavGirenAndBasariliYeni($kId){
		$db = &JFactory::getOracleDBO();
	
		// Sınava Giren Sayısı
		$sqlSinavaGiren = "SELECT COUNT(DISTINCT MBH.TC_KIMLIK) AS ADAY, MY.YETERLILIK_ID, MY.YETERLILIK_ADI, MY.YETERLILIK_KODU, 
				MY.REVIZYON, MY.SEVIYE_ID 
				FROM M_BELGELENDIRME_ADAY_BILDIRIM MBH
				INNER JOIN M_YETERLILIK MY ON(MBH.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MBH.SINAV_ID = MBS.SINAV_ID)
				WHERE MBH.KURULUS_ID = ? AND MBS.SONUC_DURUMU = 2
				GROUP BY MY.YETERLILIK_ID, MY.YETERLILIK_ADI, MY.YETERLILIK_KODU, 
				MY.REVIZYON, MY.SEVIYE_ID
				ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC, REVIZYON ASC";
		$dataSinavaGiren = $db->prep_exec($sqlSinavaGiren, array($kId));
		
		foreach($dataSinavaGiren as $key=>$row){
			// Belge Alan Sayısı
			$sqlBelgeli = "SELECT COUNT(DISTINCT MBH.TC_KIMLIK) AS ADAY
				FROM M_BELGELENDIRME_HAK_KAZANANLAR MBH
				INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MBH.SINAV_ID = MBS.SINAV_ID)
				WHERE MBH.KURULUS_ID = ? AND MBS.SONUC_DURUMU = 2 AND MBH.DURUM = 2 AND MBH.DURUM = 2 AND MBH.YETERLILIK_ID = ?
				";
			$dataBelgeli = $db->prep_exec($sqlBelgeli, array($kId,$row['YETERLILIK_ID'])); // Belgeli tüm adaylar
				
			// Belgeli adayların içinde sınavdan başarasız olan var mı?
			$sql = "SELECT
					COUNT(DISTINCT MBA.TC_KIMLIK) AS ADAY
					FROM M_BELGELENDIRME_ADAY_BILDIRIM MBA
					INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MBA.SINAV_ID = MBS.SINAV_ID)
					INNER JOIN M_BELGELENDIRME_HAK_KAZANANLAR MBH ON(MBA.TC_KIMLIK = MBH.TC_KIMLIK AND MBA.YETERLILIK_ID = MBH.YETERLILIK_ID)
					WHERE MBA.KURULUS_ID = ? AND MBS.SONUC_DURUMU = 2 AND MBA.YETERLILIK_ID = ?
					AND MBA.SINAV_TARIHI <= MBH.BELGE_BAS_TARIH AND MBA.BASARI_DURUMU != 1 AND MBH.DURUM = 2";
			$dataBelgeliBasarsiz = $db->prep_exec($sql, array($kId,$row['YETERLILIK_ID']));
		
			// Belgesiz adaylardan basarız olanlar.
			$sqlBelgesizBasarisiz = "SELECT COUNT(DISTINCT MBA.TC_KIMLIK) AS ADAY
					FROM M_BELGELENDIRME_ADAY_BILDIRIM MBA
					INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MBA.SINAV_ID = MBS.SINAV_ID)
					WHERE MBA.KURULUS_ID = ? AND MBS.SONUC_DURUMU = 2 AND MBA.YETERLILIK_ID = ?
						AND MBA.TC_KIMLIK NOT IN
						(
						SELECT DISTINCT TC_KIMLIK
							FROM M_BELGELENDIRME_HAK_KAZANANLAR
							WHERE KURULUS_ID = ? AND YETERLILIK_ID = ?
						)
					";
			$dataBelgesizBasarsiz = $db->prep_exec($sqlBelgesizBasarisiz, array($kId,$row['YETERLILIK_ID'],$kId,$row['YETERLILIK_ID']));
				
			$dataSinavaGiren[$key]['BELGELI'] = $dataBelgeli[0]['ADAY'];
			$dataSinavaGiren[$key]['BELGELIBASSIZ'] = $dataBelgeliBasarsiz[0]['ADAY'];
			$dataSinavaGiren[$key]['BELGESIZBASSIZ'] = $dataBelgesizBasarsiz[0]['ADAY'];
			$dataSinavaGiren[$key]['BASSIZ'] = $dataBelgesizBasarsiz[0]['ADAY']+$dataBelgeliBasarsiz[0]['ADAY'];
		}
		
		return $dataSinavaGiren;
	}
	
	function SendArchiveDoc($post) {
		$db = &JFactory::getOracleDBO();
		$sql = "UPDATE M_KURULUS_EK SET BELGE_TUR = '".$post['docType']."' WHERE ID='".$post['docId']."'";
		$return = $db->prep_exec_insert($sql, array(),true); 
	
		if($return){
			$data['STATUS'] = 1;
			$data['DOCTYPE'] = $post['docType'];
			$data['STATUSNAME'] = 'Dosya başarıyla arşivlenmiştir.';
		}else{
			$data['STATUS'] = 0;
			$data['STATUSNAME'] = 'Dosya arşivleme işleminde hata oluştu. Lütfen tekrar deneyiniz.';
		}
		return $data;
	}
	
	function RemoveFromArchieveDoc($post) {
		$db = &JFactory::getOracleDBO();
		$sql = "UPDATE M_KURULUS_EK SET BELGE_TUR = '".current(explode("_", $post['docType']))."' WHERE ID='".$post['docId']."'";
		$return = $db->prep_exec_insert($sql, array(),true);
		if($return){
			$data['STATUS'] = 1;
			$data['DOCTYPE'] = current(explode("_", $post['docType']));
			$data['STATUSNAME'] = 'Dosya başarıyla arşivden çıkartılmıştır.';
		}else{
			$data['STATUS'] = 0;
			$data['STATUSNAME'] = 'Dosya arşivden çıkarma işleminde hata oluştu. Lütfen tekrar deneyiniz.';
		}
		return $data;
	}
	
	// Test Amaclı bir bölüm
	function BasarisizMi($tckn, $yeterlilik_id, $alternatifTipi, $dataYet, $sinavTarihi, $tOncekiSinavId=null){
		$_db = JFactory::getOracleDBO ();
	
		$tckn = (string)$tckn;
		$yenimi = BelgelendirmeModelBelgelendirme_Islemleri::YeterlilikYenimi($yeterlilik_id);
	
		if($yenimi == 1){
			$zorunluBirims =$dataYet[1];
			$secmeliBirims = $dataYet[0];
			$basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,1,$yeterlilik_id,$sinavTarihi, $tOncekiSinavId);
			$basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,1,$yeterlilik_id,$sinavTarihi, $tOncekiSinavId);
			if(count($basariliZorunluBirimler) != count($zorunluBirims)){
				$sonuc=false;
			} else {
				$sonuc=true;
			}
	
			if ($sonuc and count($secmeliBirims)>0){
	
				if($alternatifTipi[0] == 1){
					if(count($basariliSecmeliBirimler) < $alternatifTipi[1]){
						$sonuc = false;
					}
				}else{
					if(count($alternatifTipi[1])>0){
						$basSecBirims = array();
						foreach($basariliSecmeliBirimler as $tow){
							$basSecBirims[] = $tow[0];
						}
						$sonuc = false;
						foreach($alternatifTipi[1] as $key=>$birimler){
							$say = 0;
							foreach($birimler as $birim){
								if (in_array($birim, $basSecBirims)){
									$say++;
								}
							}
							if($say == count($birimler)){
								$sonuc = true;
								break;
							}
						}
					}
				}
				if ($sonuc && count($basariliSecmeliBirimler)>0){
					return array_merge($basariliZorunluBirimler, $basariliSecmeliBirimler);
				}
			}
			if ($sonuc){
				return $basariliZorunluBirimler;
			} else {
				return false;
			}
			 
		}
		else{
			$zorunluBirims =$dataYet[1];
			$secmeliBirims = $dataYet[0];
			$basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,0,$yeterlilik_id, $sinavTarihi, $tOncekiSinavId);
			$basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,0,$yeterlilik_id, $sinavTarihi, $tOncekiSinavId);
			if(count($basariliZorunluBirimler) != count($zorunluBirims)){
				$sonuc=false;
			} else {
				$sonuc=true;
			}
			 
			if ($sonuc and count($secmeliBirims)>0){
				 
				if($alternatifTipi[0] == 1){
					if(count($basariliSecmeliBirimler) < $alternatifTipi[1]){
						$sonuc = false;
					}
				} else {
					$sonuc = false;
					foreach($alternatifTipi[1] as $birimler){
						$say = 0;
						foreach($birimler as $birim){
							if (in_array($birim, $basariliSecmeliBirimler)){
								$say++;
							}
						}
						if($say == count($birimler)){
							$sonuc = true;
							break;
						}
					}
	
				}
				if ($sonuc && count($basariliSecmeliBirimler)>0){
					return array_merge($basariliZorunluBirimler, $basariliSecmeliBirimler);
				}
			}
			if ($sonuc){
				return $basariliZorunluBirimler;
			} else {
				return false;
			}
		}
	
	}
	
	function BelgeHakkiAdayBirimler($data, $tckn, $yenimi, $yeterlilik_id, $sinavTarihi, $tOncekiSinavId=null){
		$_db = JFactory::getOracleDBO ();
		if($tOncekiSinavId){
			$sqlPlus = " and SINAV_ID IN (".implode(',',$tOncekiSinavId).")";
		}else{
			$sqlPlus = "";
		}
        $basariliBirimKontrol = array();
		if ($yenimi==1){
			foreach ($data as $birim_id=>$sinavTurleri){
				$sqlBirimTur = "SELECT * FROM M_BIRIM_ALTERNATIF_TUR WHERE BIRIM_ID = ? ORDER BY ALTERNATIF_TUR_ID ASC";
				$biriTur = $_db->prep_exec($sqlBirimTur, array($birim_id));
				$turler = array();
				if($biriTur){
					foreach ($biriTur as $till){
						$turler[$till['ALTERNATIF_TUR_ID']][] = $till['BIRIM_TUR'].$till['BIRIM_NUMARA'];
					}
					 
					foreach ($turler as $fill){
						$sinavId=array();
						foreach ($fill as $till){
							$sql="select KURULUS_ID, SINAV_TARIHI from M_BELGELENDIRME_ADAY_BILDIRIM
	                        		where TC_KIMLIK = ? and BIRIM_ID = ? and SINAV_TURU_KODU = ? and BASARI_DURUMU != 3
									and YETERLILIK_ID = ? and SINAV_TARIHI >= (SELECT TO_DATE(?)-367 FROM DUAL) and rownum=1";
							$sql .= $sqlPlus;
							$sql .= " order by SINAV_TARIHI desc";
							$param = array($tckn,$birim_id,$till,$yeterlilik_id,$sinavTarihi);
							$sinav = $_db->prep_exec($sql, $param);
							 
							foreach ($sinav as $value) {
								if(!in_array($till,$sinavId[$birim_id])){
									$sinavId[$birim_id][]=$till;
									if ($sinav[0]['SINAV_TARIHI']){
										$tarih[$birim_id]=$sinav[0]['SINAV_TARIHI'];
									}
								}
							}
						}
	
						foreach ($sinavId as $row){
							if (count($row) == count($fill)){
								if(!in_array($birim_id, $basariliBirimKontrol)){
									$basariliBirim[]=array($birim_id,$tarih[$birim_id]);
									$basariliBirimKontrol[]=$birim_id;
								}
							}
							 
						}
					}
				}
				else{
					$sinavId=array();
					foreach ($sinavTurleri as $sinavTuru){
						$sql="select KURULUS_ID, SINAV_TARIHI from M_BELGELENDIRME_ADAY_BILDIRIM"
							. " where TC_KIMLIK = ?"
							. " and BIRIM_ID = ?"
							. " and SINAV_TURU_KODU = ?"
							. " and BASARI_DURUMU != 3"
							. " and YETERLILIK_ID = ?"
							. " and SINAV_TARIHI >= (SELECT TO_DATE(?)-367 FROM DUAL)
		                               and rownum=1";
						$sql .= $sqlPlus;
						$sql .= " order by SINAV_TARIHI desc";
						$param = array($tckn,$birim_id,$sinavTuru,$yeterlilik_id, $sinavTarihi);
						$sinav = $_db->prep_exec($sql, $param);
	
						foreach ($sinav as $value) {
							if(!in_array($sinavTuru,$sinavId[$birim_id])){
								$sinavId[$birim_id][]=$sinavTuru;
								if ($sinav[0]['SINAV_TARIHI']){
									$tarih[$birim_id]=$sinav[0]['SINAV_TARIHI'];
								}
							}
						}
						 
					}
					foreach ($sinavId as $row){
						if (count($row) == count($sinavTurleri)){
							if(!in_array($birim_id, $basariliBirimKontrol)){
								$basariliBirim[]=array($birim_id,$tarih[$birim_id]);
								$basariliBirimKontrol[]=$birim_id;
							}
						}
					}
				}
			}
		} else {
			foreach ($data as $birim_id=>$sinavTurleri){
				$sinavId=array();
				foreach ($sinavTurleri as $till){
					$sql="select KURULUS_ID, SINAV_TARIHI from M_BELGELENDIRME_ADAY_BILDIRIM
	                    where TC_KIMLIK = ? and BIRIM_ID = ? and SINAV_TURU_KODU = ? and BASARI_DURUMU != 3
						and YETERLILIK_ID = ? and SINAV_TARIHI >= (SELECT TO_DATE(?)-367 FROM DUAL) and rownum=1";
					$sql .= $sqlPlus;
					$sql .= " order by SINAV_TARIHI desc";
					$param = array($tckn,$birim_id,$till,$yeterlilik_id, $sinavTarihi);
					$sinav = $_db->prep_exec($sql, $param);
					 
					foreach ($sinav as $value) {
						if(!in_array($till,$sinavId[$birim_id])){
							$sinavId[$birim_id][]=$till;
							if ($sinav[0]['SINAV_TARIHI']){
								$tarih[$birim_id]=$sinav[0]['SINAV_TARIHI'];
							}
						}
					}
				}
	
				foreach ($sinavId as $row){
					if (count($row) == count($sinavTurleri)){
						if(!in_array($birim_id, $basariliBirimKontrol)){
							$basariliBirim[]=array($birim_id,$tarih[$birim_id]);
							$basariliBirimKontrol[]=$birim_id;
						}
					}
				}
			}
		}
		return $basariliBirim;
	}
	// Test Amaclı Bölüm Son
	
	function degerlendiriciGetDatas($post) {
		$db  = &JFactory::getOracleDBO();
		$sql_log = "SELECT * FROM M_LOG
				        WHERE LOG_DATE >= (SELECT TO_CHAR(MAX(LOG_DATE),'DD-MM-YYYY') FROM M_LOG WHERE TABLE_IDCOLUMN = 'TC_KIMLIK' AND TABLE_ID = ?) AND
				              TABLE_IDCOLUMN = 'TC_KIMLIK' AND TABLE_ID = ?";
	
		$datas_logs = $db->prep_exec($sql_log, array($post['tcno'],$post['tcno']));
	
		$sql_degerlendirici = "SELECT * FROM M_BELGELENDIRME_DEGERLENDIRICI WHERE TC_KIMLIK = ?";
		$datas = current($db->prep_exec($sql_degerlendirici, array($post['tcno'])));
		$result = array();
		foreach($datas as $key => $val){
			$control = false;
			foreach($datas_logs as $datas_log){
				if($key == $datas_log['COLUMNNAME']){
					$result[$key]['OLDVALUE'] = $datas_log['OLDVALUE'];
					$result[$key]['NEWVALUE'] = $datas_log['NEWVALUE'];
					$control = true;
				}
			}
			if($control == false){
				$result[$key] = $val;
			}
		}
	
		$returned['STATUS'] = "1";
		$returned['RESULT'] = $result;
		return  $returned;
	}
	
	function degerlendiriciSubmitOrCancel($tcno,$durum) {
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE M_BELGELENDIRME_DEGERLENDIRICI SET ONAY_BEKLEYEN = ? WHERE TC_KIMLIK = ?";
		$db->prep_exec_insert($sql, array($durum,$tcno));
		if($durum == "0"){
			$return['STATUS'] = "1";
			$return['RESULT'] = "Değişiklik red talebi başarıyla işlenmiştir";
		}else if($durum == "1"){
			$return['STATUS'] = "1";
			$return['RESULT'] = "Onaylama işlemi başarıyla gerçekleşmiştir";
		}
		return $return;
	}
	function degerlendiriciSubmitForYeterlilik($post) {
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE M_BELGELENDIRME_DGRLNDRC_KRLS SET ONAY_BEKLEYEN_DGRLNDRC = ?,ONAY_TARIHI = ?,ACIKLAMA = ? WHERE YETERLILIK_ID = ? AND TC_KIMLIK = ?";
		$db->prep_exec_insert($sql, array($post['durum'],date('d/m/Y'),$post['aciklama'],$post['yetid'],$post['tcno']));
		
		if($post['durum'] == "0"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Yeterlilik için değerlendirici iptal işlemi başarıyla gerçekleşti";
		}else if($post['durum'] == "1"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Yeterlilik için değerlendirici onay işlemi başarıyla gerçekleşti";
		}else if($post['durum'] == "-1"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Yeterlilik için değerlendirici başarıyla reddedildi.";
		}
		return $datas;
	}
	
	function sinavYeriOnayla($post) {
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE M_BELGELENDIRME_SINAV_YERI SET ONAY_DURUMU = ?  WHERE SINAV_YERI_ID = ?";
		$db->prep_exec_insert($sql, array($post['durum'],$post['yerid']));
		
		if($post['durum'] == "0"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Sınav Yeri Onay İptal işlemi başarıyla gerçekleşti";
		}else if($post['durum'] == "1"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Sınav Yeri Onaylama işlemi başarıyla gerçekleşti";
		}
		return $datas;
	}
	
	function sinavYeriOnaylaForYeterlilik($post) {
		$db  = &JFactory::getOracleDBO();
		$sql = "UPDATE M_BELGELENDIRME_SINAV_YERI SET ONAY_DURUMU = ?,ONAY_TARIHI = ?  WHERE SINAV_YERI_ID = ? AND YETERLILIK_ID = ? AND SINAV_TURU = ?";
		$db->prep_exec_insert($sql, array($post['durum'],date('d/m/Y'),$post['yerid'],$post['yetid'],$post['sinavtur']));
	
		if($post['durum'] == "0"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Sınav Yeri Onay İptal işlemi başarıyla gerçekleşti";
		}else if($post['durum'] == "1"){
			$datas['STATUS'] = "1";
			$datas['RESULT'] = "Sınav Yeri Onaylama işlemi başarıyla gerçekleşti";
		}
		return $datas;
	}
	
	public function UcretTarifesiDonem($kurId,$yetId,$durum=2){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DONEM_ID, YIL, DONEM, TO_CHAR(TARIH,'DD/MM/YYYY') AS TARIH, USER_ID, YET_ID, DURUM FROM M_UCRET_TARIFESI_DONEM 
				WHERE USER_ID = ? AND YET_ID = ? AND DURUM = ?";
		
		$data = $db->prep_exec($sql, array($kurId,$yetId,$durum));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function getYetYetki($kurulus_id, $yetId=0, $durum=3){
		$db = JFactory::getOracleDBO ();
		$sqlEk = "";
// 		if(is_numeric($yetId) && $yetId){
// 			$sqlEk .= " AND MBYY.YETERLILIK_ID = ".$yetId;
// 		}
		
		if(is_numeric($durum)){
			$sqlEk .= " AND MUTD.DURUM = ".$durum;
		}
		
		$sql = "SELECT DISTINCT M_YETERLILIK.* 
				FROM M_BELGELENDIRME_YET_YETKI MBYY
				INNER JOIN M_YETERLILIK ON(MBYY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID) 
				WHERE MBYY.USER_ID = ? AND MBYY.DURUM = 1 
				ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
		$data = $db->prep_exec($sql, array($kurulus_id));
		
		$dataYets = array();
		foreach($data as $row){
			$sqlDonem = "SELECT DISTINCT M_YETERLILIK.*, MUTY.UCRET, MUTD.DURUM AS MUTDURUM, MUTD.DONEM_ID
				FROM M_BELGELENDIRME_YET_YETKI MBYY
				INNER JOIN M_YETERLILIK ON(MBYY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				INNER JOIN M_UCRET_TARIFESI_YET MUTY ON(MBYY.YETERLILIK_ID = MUTY.YETERLILIK_ID AND MBYY.USER_ID = MUTY.USER_ID)
				INNER JOIN M_UCRET_TARIFESI_DONEM MUTD ON(MBYY.YETERLILIK_ID = MUTD.YET_ID AND MBYY.USER_ID = MUTD.USER_ID AND MUTY.DONEM_ID = MUTD.DONEM_ID)
				WHERE MBYY.USER_ID = ? AND MBYY.DURUM = 1 AND MBYY.YETERLILIK_ID = ?";
			$sqlDonem .= $sqlEk;
			$sqlDonem .= " ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
			$dat = $db->prep_exec($sqlDonem, array($kurulus_id,$row['YETERLILIK_ID']));
			
			if($dat){
				$dataYets[] = $dat[0];
			}else{
				$dataYets[] = $row;
			}
		}
		
		return $dataYets;
	}
	
	public function getYetkiBirim($kurulus_id,$yetkiYets){
		$db = JFactory::getOracleDBO ();
	
		$yetkiBirims = array();
		
		foreach($yetkiYets as $row){
				
			if($row['YENI_MI'] == 1){
				if(isset($row['DONEM_ID'])){
					$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MUT.DONEM_ID = ?";
					$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
					$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID'],$row['DONEM_ID']));
				}else{
					$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1";
					$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
					$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID']));
				}
				
			}else{
				if(isset($row['DONEM_ID'])){
					$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND MBYY.DURUM = 1 AND MUT.DONEM_ID = ?";
					$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
					$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID'],$row['DONEM_ID']));
				}else{
					$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND MBYY.DURUM = 1";
					$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
					$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID']));
				}
				
			}
				
			
				
			
			
			
// 			if($row['YENI_MI'] == 1){
// 				foreach($yetkiBirims[$row['YETERLILIK_ID']] as $key=>$val){
					
// 						$sqlTur = "SELECT BIRIM_ID,OLC_DEG_HARF,OLC_DEG_NUMARA  FROM M_BIRIM_OLCME_DEGERLENDIRME
// 							WHERE BIRIM_ID = ? AND OLC_DEG_HARF != 'D'
// 								ORDER BY OLC_DEG_HARF DESC, OLC_DEG_NUMARA ASC";
							
// 						$pata = $db->prep_exec($sqlTur, array($val['BIRIM_ID']));
						
// 						// Ucre Tarifesi
// 						foreach ($pata as $cow){
// 							$birimTurs[$row['YETERLILIK_ID']][$val['BIRIM_ID']][] = $cow['OLC_DEG_HARF'].$cow['OLC_DEG_NUMARA'];
// 							$sqlUcret = 'SELECT * FROM M_UCRET_TARIFESI_TUR 
// 									WHERE BIRIM_ID = ? AND YETERLILIK_ID=? AND USER_ID=? AND TUR_KODU=?';
							
// 							$ucretler[$row['YETERLILIK_ID']][$val['BIRIM_ID']][$cow['OLC_DEG_HARF'].$cow['OLC_DEG_NUMARA']] = $db->prep_exec($sqlUcret, array($val['BIRIM_ID'],$row['YETERLILIK_ID'],$kurulus_id,$cow['OLC_DEG_HARF'].$cow['OLC_DEG_NUMARA']));
// 						}
// 				}
// 			}else{
// 				foreach($yetkiBirims[$row['YETERLILIK_ID']] as $key=>$val){
// 					$sqlTur = "SELECT BIRIM_ID, TUR_KODU, TUR FROM M_YETERLILIK_ALT_BIRIM_TUR
// 							WHERE BIRIM_ID = ? 
// 							ORDER BY TUR ASC, TUR_KODU ASC";
					
// 					$pata = $db->prep_exec($sqlTur, array($val['BIRIM_ID']));
// // 					$birimTurs[$row['YETERLILIK_ID']][$val['BIRIM_ID']] = $pata;
					
// 					// Ucre Tarifesi
// 					foreach ($pata as $cow){
// 						$birimTurs[$row['YETERLILIK_ID']][$val['BIRIM_ID']][] = $cow['TUR_KODU'];
// 						$sqlUcret = 'SELECT * FROM M_UCRET_TARIFESI_TUR
// 									WHERE BIRIM_ID = ? AND YETERLILIK_ID=? AND USER_ID=? AND TUR_KODU=?';
							
// 						$ucretler[$row['YETERLILIK_ID']][$val['BIRIM_ID']][$cow['TUR_KODU']] = $db->prep_exec($sqlUcret, array($val['BIRIM_ID'],$row['YETERLILIK_ID'],$kurulus_id,$cow['TUR_KODU']));
// 					}
// 				}
// 			}
			
		}
		
	
		return array('yetkiBirims'=>$yetkiBirims);
	}
	
	public function UcretDetay($kurId){
		$db = JFactory::getOracleDBO();
		$sql="SELECT * FROM M_UCRET_TARIFESI_DETAY WHERE USER_ID=?";
		$data = $db->prep_exec($sql, array($kurId));
		if($data){
			return $data[0]['DETAY'];
		}else{
			return null;
		}
	}
	
	
	public function UcretKaydet($post){
		$db = JFactory::getOracleDBO();
		$kId = $post['kId'];
		$yId = $post['yId'];
		$dId = $post['dId'];
		$donemYil = $post['UcretDonem'];
		
// 		$ucret = $post['UcretBirim'];
		$BirimUcret = $post['BirimUcret'];
		$yetUcret = $post['YetUcret'];
		
		if($dId){
			// Ucret Donemi Değişmiş olbilir. Tarihi Güncelle
			$sql = "UPDATE M_UCRET_TARIFESI_DONEM SET TARIH = TO_DATE(?,'DD/MM/YYYY')
					WHERE DONEM_ID = ? AND YET_ID = ? AND USER_ID = ?";
			$params = array(
					$donemYil,
					$dId,
					$yId,
					$kId
			);
			$return = $db->prep_exec_insert($sql, $params);
			if($return == false){
				return false;
			}
			// Döneme Ait Yeterlilik Ücret Tarifesi Sil
			$sqlDelete = "DELETE FROM M_UCRET_TARIFESI_YET WHERE USER_ID = ? AND YETERLILIK_ID = ? AND DONEM_ID=?";
			$db->prep_exec_insert($sqlDelete, array($kId,$yId,$dId));			
			// Döneme Ait Yeterlilik Ücret Tarifesi Ekle
			$sql = "INSERT INTO M_UCRET_TARIFESI_YET (USER_ID,YETERLILIK_ID,UCRET,DONEM_ID) VALUES(?,?,?,?)";
			$return = $db->prep_exec_insert($sql, array($kId,$yId,$yetUcret,$dId));
			if($return == false){
				return false;
			}
			// Döneme Ait Yeterlilik Birim Ücret Tarifesi Sil
			$sqlDelete = "DELETE FROM M_UCRET_TARIFESI WHERE USER_ID = ? AND YETERLILIK_ID = ? AND DONEM_ID = ?";
			$db->prep_exec_insert($sqlDelete, array($kId,$yId,$dId));
			// Döneme Ait Yeterlilik Birim Ücret Tarifesi Ekle
			$hata = 0;
			$sql = "INSERT INTO M_UCRET_TARIFESI (USER_ID,YETERLILIK_ID,BIRIM_ID,UCRET,DONEM_ID) VALUES(?,?,?,?,?)";
			foreach($BirimUcret as $key=>$val){
				$params = array(
						$kId,
						$yId,
						$key,
						$val,
						$dId
				);
				if(!$db->prep_exec_insert($sql, $params)){
					$hata++;
				}
			}
		}else{
			$sql = "SELECT COUNT(*) AS DONEM FROM M_UCRET_TARIFESI_DONEM WHERE USER_ID = ? AND YET_ID = ? AND DURUM != -1 AND TARIH > TO_DATE(?, 'DD/MM/YYYY') AND TARIH < TO_DATE(?, 'DD/MM/YYYY')";
			$firtDate = '01/01/'.(date('Y')+1);
			$lastDate = '31/12/'.(date('Y')-1);
			$data = $db->prep_exec($sql, array($kId,$yId,$lastDate,$firtDate));
			if($data){
				$donem = $data[0]['DONEM'];
				$yeniDonem = $donem+1;
				$dId = date('Y').$yeniDonem;
			}else{
				// İlk Dönem Kaydı Oluştur
				$yeniDonem = 1;
				$dId = date('Y').$yeniDonem;
			}
			
			$sql = "INSERT INTO M_UCRET_TARIFESI_DONEM (DONEM_ID,YIL,DONEM,USER_ID,YET_ID,TARIH) 
					VALUES(?,?,?,?,?,TO_DATE(?,'DD/MM/YYYY'))";
			$params = array(
					$dId,
					date('Y'),
					$yeniDonem,
					$kId,
					$yId,
					$donemYil
			);
			
			$return = $db->prep_exec_insert($sql, $params);
			if($return == false){
				return false;
			}
			
			// Döneme Ait Yeterlilik Ücret Tarifesi Ekle
			$sql = "INSERT INTO M_UCRET_TARIFESI_YET (USER_ID,YETERLILIK_ID,UCRET,DONEM_ID) VALUES(?,?,?,?)";
			$return = $db->prep_exec_insert($sql, array($kId,$yId,$yetUcret,$dId));
			if($return == false){
				return false;
			}
			
			$hata = 0;
			$sql = "INSERT INTO M_UCRET_TARIFESI (USER_ID,YETERLILIK_ID,BIRIM_ID,UCRET,DONEM_ID) VALUES(?,?,?,?,?)";
			foreach($BirimUcret as $key=>$val){
				$params = array(
						$kId,
						$yId,
						$key,
						$val,
						$dId
				);
				if(!$db->prep_exec_insert($sql, $params)){
					$hata++;
				}
			}
		}
		
// 		$sqlDelete = "DELETE FROM M_UCRET_TARIFESI_TUR WHERE USER_ID = ? AND YETERLILIK_ID = ?";
// 		$db->prep_exec_insert($sqlDelete, array($kId,$yId));
		
		if($hata>0){
			return false;
		}else{
			return true;
		}
	}
	
	public function UcretSartKaydet($post){
		$db = JFactory::getOracleDBO();
		$kurId = $post['kurId'];
		$detay = $post['detay'];
				
		$sqlDetayDel = "DELETE FROM M_UCRET_TARIFESI_DETAY WHERE USER_ID = ?";
		$db->prep_exec_insert($sqlDetayDel, array($kurId));
		
		$sqlDetay = "INSERT INTO M_UCRET_TARIFESI_DETAY (USER_ID,DETAY) VALUES(?,?)";
		$db->prep_exec_insert($sqlDetay, array($kurId,$detay));
		
		return true;
	}
	
	public function getYetYetkiDonem($kurulus_id, $yetId=0, $donemId=0){
		$db = JFactory::getOracleDBO ();
		$sqlEk = "";
		if(is_numeric($yetId) && $yetId){
			$sqlEk .= " AND MBYY.YETERLILIK_ID = ".$yetId;
		}
	
		if(is_numeric($donemId) && $donemId){
			$sqlEk .= " AND MUTY.DONEM_ID = ".$donemId;
		}
	
		$sql = "SELECT DISTINCT M_YETERLILIK.*, MUTY.UCRET
				FROM M_BELGELENDIRME_YET_YETKI MBYY
				INNER JOIN M_YETERLILIK ON(MBYY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				INNER JOIN M_UCRET_TARIFESI_YET MUTY ON(MBYY.YETERLILIK_ID = MUTY.YETERLILIK_ID AND MBYY.USER_ID = MUTY.USER_ID)
				WHERE MBYY.USER_ID = ? AND MBYY.DURUM = 1 ";
		$sql .= $sqlEk;
		$sql .= " ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
	
		return $db->prep_exec($sql, array($kurulus_id));
	}
	
	public function getYetkiBirimDonem($kurulus_id,$yetkiYets,$donemId){
		$db = JFactory::getOracleDBO ();
		
		$yetkiBirims = array();
		
		foreach($yetkiYets as $row){
		
			if($row['YENI_MI'] == 1){
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MUT.DONEM_ID = ?";
			}else{
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MUT.DONEM_ID = ?";
			}
		
			$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
		
			$yetkiBirims = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID'],$donemId));
		}
		return array('yetkiBirims'=>$yetkiBirims);
	}
	
	public function ajaxGetYetUcret($post){
		$db = JFactory::getOracleDBO();
		$kId = $post['uId'];
		$yId = $post['yId'];
		$return = array();
		
		$donemDurum0 = $this->UcretTarifesiDonem($kId,$yId,0);
		$donemDurum1 = $this->UcretTarifesiDonem($kId,$yId,1);
		$donemDurum2 = $this->UcretTarifesiDonem($kId,$yId,2);
		$donemDurum3 = $this->UcretTarifesiDonem($kId,$yId,3);
		
		if($donemDurum0){
			$donemId = $donemDurum0['DONEM_ID'];
			$donemBilgi = $donemDurum0;
		}else if($donemDurum1){
			$donemId = $donemDurum1['DONEM_ID'];
			$donemBilgi = $donemDurum1;
		}else if($donemDurum2){
			$donemId = $donemDurum2['DONEM_ID'];
			$donemBilgi = $donemDurum2;
		}else if($donemDurum3){
			$donemId = $donemDurum3['DONEM_ID'];
			$donemBilgi = $donemDurum3;
		}else{
			$donemId = 0;
			$donemBilgi = false;
		}
		
		$return['donemBilgi'] = $donemBilgi;
		
		if($donemId){
			$dataYet = $this->getYetYetkiDonem($kId,$yId,$donemId);
			$return['yets'] = $dataYet[0];
		}else{
			$sqlYet = "SELECT DISTINCT M_YETERLILIK.*, M_UCRET_TARIFESI_YET.UCRET
				FROM M_BELGELENDIRME_YET_YETKI
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				LEFT JOIN M_UCRET_TARIFESI_YET ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_UCRET_TARIFESI_YET.YETERLILIK_ID AND M_BELGELENDIRME_YET_YETKI.USER_ID = M_UCRET_TARIFESI_YET.USER_ID)
				WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ? AND M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = ? AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
				ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
			$dataYet = $db->prep_exec($sqlYet, array($kId,$yId));
			$return['yets'] = $dataYet[0];
		}
		
		if($donemId){
			$return['birims'] = $this->getYetkiBirimDonem($kId,$dataYet,$donemId);
		}else{
			if($dataYet[0]['YENI_MI'] == 1){
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					LEFT JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1";
			}else{
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					LEFT JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND MBYY.DURUM = 1";
			}
			
			$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
			
			$yetkiBirims = $db->prep_exec($sql, array($kId,$yId));
			$return['birims'] = array('yetkiBirims'=>$yetkiBirims);
		}
		
		$birimler = array();
		foreach($return['birims']['yetkiBirims'] as $tow){
			$birimler[] = $tow['BIRIM_ID'];
		}
		
		if($dataYet[0]['YENI_MI'] == 1){
			$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					LEFT JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MBYY.BIRIM_ID NOT IN(".implode(',', $birimler).")";
		}else{
			$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					LEFT JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND MBYY.DURUM = 1 AND MBYY.BIRIM_ID NOT IN(".implode(',', $birimler).")";
		}
			
		$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
			
		$dat = $db->prep_exec($sql, array($kId,$yId));
		
		foreach($dat as $cow){
			$return['birims']['yetkiBirims'][] = $cow;
		}
		
		return $return;
	}
	
	function getProfileIrtibatValues($userid){
		$_db 		= & JFactory::getOracleDBO();
		$sql = "SELECT *
				FROM m_kurulus_irtibat
				WHERE user_id = ? ORDER BY irtibat_id";
		
		$params = array ($userid);
		
		return $_db->prep_exec($sql, $params);
	}
	function irtibatkaydet($userid,$posted) {
		$_db 		= & JFactory::getOracleDBO();
		
		$panelName = "irtibat_panel";
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
					
					$irtibat_id			= $_db->getNextVal(IRTIBAT_SEQ);
					$irtibat_kisi_adi	= $panelValues[0];
					$irtibat_eposta		= $panelValues[1];
					$irtibat_telefon	= $panelValues[2];
					$irtibat_faks		= $panelValues[3];
					//Prepare sql statement
					$sql = "INSERT INTO m_kurulus_irtibat
									(irtibat_id, irtibat_kisi_adi, irtibat_eposta, irtibat_telefon, irtibat_faks,user_id)
									values( ?, ?, ?, ?, ?, ?)";
					$params = array($irtibat_id,
									$irtibat_kisi_adi,
									$irtibat_eposta,
									$irtibat_telefon,
									$irtibat_faks,
									$userid);
					$result = $_db->prep_exec_insert($sql, $params);
				}
		
			}else{
				$irtibatId = $posted[$irtibatHiddenId];
		
				if (!isset ($posted["input".$irtibatHiddenId."-2"])){	// DELETE
					$result =  FormFactory::irtibatVerisiSil($evrak_pk, $irtibatId);
				}else{													// UPDATE
					$inputName 	= "input".$irtibatHiddenId;
					$rowCount	= 4;
					$panelValues =  FormFactory::getPanelValues ($posted, $inputName, $rowCount);
					$irtibat_kisi_adi	= $panelValues[0];
					$irtibat_eposta		= $panelValues[1];
					$irtibat_telefon	= $panelValues[2];
					$irtibat_faks		= $panelValues[3];
					//Prepare sql statement
					$sql = "UPDATE m_kurulus_irtibat 
							SET irtibat_kisi_adi = ?, 
								irtibat_eposta = ?, 
								irtibat_telefon = ?,
								irtibat_faks = ? 
						  WHERE irtibat_id = ?";
						         
					$params = array($irtibat_kisi_adi,
									$irtibat_eposta,
									$irtibat_telefon,
									$irtibat_faks,
									$irtibatId);
					$result = $_db->prep_exec_insert($sql, $params);
				}
			}
		}
		return $result;
	}
	
	function ajaxGetYetUcretYetkilimi($post){
		$db = & JFactory::getOracleDBO();
		
		$user		 = &JFactory::getUser ();
		$group_id   = 27;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut = FormFactory::checkAuthorization ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$kurulusId = $post['uId'];
		$yetId = $post['yId'];
		
		$sql = "SELECT * FROM M_UCRET_TARIFESI_DONEM WHERE USER_ID = ? AND YET_ID = ? AND DURUM != 3 AND DURUM != -1 AND DURUM != -2 ";
		$data = $db->prep_exec($sql, array($kurulusId,$yetId));
		
		if($data){
			if($data[0]['DURUM'] == 1 && ($aut2 || $aut3)){
				return true;
			}else if($data[0]['DURUM'] == 2 && $aut){
				return true;
			}else if($data[0]['DURUM'] == 0){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
		
	}
	
	function ajaxUcretOnayaGonder($post){
		$db = & JFactory::getOracleDBO();
		
		$user		 = &JFactory::getUser ();
		$group_id   = 27;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut = FormFactory::checkAuthorization ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$kurulusId = $post['uId'];
		$yetId = $post['yId'];
		$durum = $post['durum'];
		$donemId = $post['donemId'];
		
		$kurBilgi = $this->KurulusEditBilgi($kurulusId);
		if(!$kurBilgi){
			$dat = $this->getKurulusBilgi($kurulusId);
			$kurBilgi = $dat[0];
		}
		$yetBilgiSql = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$yetDat = $db->prep_exec($yetBilgiSql, array($yetId));
		$yetBilgi = $yetDat[0];
		
		$mailGorevli = array('huseyin.toplu@myk.gov.tr','ktunc@myk.gov.tr');
		$aciklamaText = $kurBilgi['KURULUS_ADI'].' kuruluşu '.$yetBilgi['YETERLILIK_KODU'].'/'.$yetBilgi['REVIZYON'].' '.$yetBilgi['YETERLILIK_ADI'].' yeterliliğinin ücret tarifesini değiştirerek onayınıza sunmuştur. ';
		$link = 'http://portal.myk.gov.tr/index.php?option=com_profile&view=profile&layout=tarife&kurulus='.$kurulusId;
		
		$sql = "UPDATE M_UCRET_TARIFESI_DONEM SET DURUM = ? WHERE USER_ID = ? AND YET_ID = ?
						 AND DONEM_ID = ?";
		
			if($durum == 2 && ($aut2 || $aut3)){
				$return = $db->prep_exec_insert($sql, array($durum,$kurulusId,$yetId,$donemId));
				$mailGorevli[] = 'mordukaya@myk.gov.tr';
				$baslik = $kurBilgi['KURULUS_ADI'].' Ücret Tarifesi Yönetici Onayı.';
				
			}else if($durum == 3 && $aut){
				$sqlDon = "SELECT * FROM M_UCRET_TARIFESI_DONEM WHERE USER_ID = ? AND YET_ID = ? AND DURUM = 3";
				$data = $db->prep_exec($sqlDon, array($kurulusId,$yetId));
				if($data){
					$sqlUp = "UPDATE M_UCRET_TARIFESI_DONEM SET DURUM = -2 WHERE USER_ID = ? AND YET_ID = ? AND DURUM = 3";
					$db->prep_exec_insert($sqlUp, array($kurulusId,$yetId));
				}
				$return = $db->prep_exec_insert($sql, array($durum,$kurulusId,$yetId,$donemId));
			}else if($durum == 1){
				$return = $db->prep_exec_insert($sql, array($durum,$kurulusId,$yetId,$donemId));
				$baslik = $kurBilgi['KURULUS_ADI'].' Ücret Tarifesi Dosya Sorumlusu Onayı.';

			}else if($durum == 0 && ($aut || $aut2 || $aut3)){
				$return = $db->prep_exec_insert($sql, array($durum,$kurulusId,$yetId,$donemId));
			}else{
				return false;
			}
		
			if($return && ($durum == 2 || $durum == 1)){
				$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
				$gorevli = $db->prep_exec($sqlGorevli, array($kurulusId));
				
				$mysqlDB = &JFactory::getDBO();
				
				foreach($gorevli as $tow){
					$sqlMatbaa= "SELECT email FROM #__users as users
								WHERE tgUserId = ".$tow['TGUSERID'];
					$mysqlDB->setQuery($sqlMatbaa);
					$matbaaUser = $mysqlDB->loadObjectList();
					$mailGorevli[] = $matbaaUser[0]->email;
				
					FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $tow['TGUSERID']);
				}
				
				
				$icerik = $aciklamaText.$link;
				$to = $mailGorevli;
					
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return $return;
			}else if($return && $durum == 3){
				return true;
			}else{
				return false;
			}
	}
	
	function getOnayliUcretTarifeleri($kurId){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT DONEM_ID, YIL, DONEM, TO_CHAR(TARIH,'DD/MM/YYYY') AS TARIH, USER_ID, YET_ID, DURUM FROM M_UCRET_TARIFESI_DONEM WHERE DURUM = 3 AND USER_ID = ?";
		$data = $db->prep_exec($sql, array($kurId));
		
		$yets = array();
		foreach($data as $row){
			$yets[$row['YET_ID']] = $row;
		}
		
		return $yets;
	}
	
	function getOnayBekleyenUcretTarifeleri($kurId){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT DONEM_ID, YIL, DONEM, TO_CHAR(TARIH,'DD/MM/YYYY') AS TARIH, USER_ID, YET_ID, DURUM FROM M_UCRET_TARIFESI_DONEM WHERE (DURUM = 2 OR DURUM = 1) AND USER_ID = ?";
		$data = $db->prep_exec($sql, array($kurId));
	
		$yets = array();
		foreach($data as $row){
			$yets[$row['YET_ID']] = $row;
		}
	
		return $yets;
	}
	
	function verilenBelgelerDetayByYetId($kurulusId,$yeterlilikid){
		$db = & JFactory::getOracleDBO();
		
		
		$sql = "SELECT COUNT(BELGENO) AS BELSAY ,YETERLILIK_ID, TO_CHAR(BELGE_DUZENLEME_TARIHI, 'YYYY') AS YIL
				FROM M_BELGE_SORGU
				WHERE KURULUS_ID = ?
				AND BELGENO NOT IN (SELECT BELGE_NO FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE KURULUS_ID = ?)
				AND YETERLILIK_ID = ?
				
				GROUP BY TO_CHAR(BELGE_DUZENLEME_TARIHI, 'YYYY'),YETERLILIK_ID";
		
		$dataBel = $db->prep_exec($sql, array($kurulusId,$kurulusId,$yeterlilikid));
		
		$sqlHak = "select count(belge_no) as HAKSAY, yeterlilik_id,TO_CHAR(BELGE_BAS_TARIH, 'YYYY') AS YIL from m_belgelendirme_hak_kazananlar
				where kurulus_id = ? and durum = 2 AND YETERLILIK_ID = ?

GROUP BY TO_CHAR(BELGE_BAS_TARIH, 'YYYY'),YETERLILIK_ID";
		
		$dataHak = $db->prep_exec($sqlHak, array($kurulusId,$yeterlilikid));
		
		$yets = FormFactory::getYets($yeterlilikid);
		
		$BelSayArray = array();
		$BelSayArray[$yeterlilikid]['YETERLILIK_DATAS']['YETERLILIK_ID']  = $yets['YETERLILIK_ID'];
		$BelSayArray[$yeterlilikid]['YETERLILIK_DATAS']['YETERLILIK_ADI'] = $yets['YETERLILIK_ADI'];
		$BelSayArray[$yeterlilikid]['YETERLILIK_DATAS']['YETERLILIK_KODU']= $yets['YETERLILIK_KODU'];
		$BelSayArray[$yeterlilikid]['YETERLILIK_DATAS']['REVIZYON']= $yets['REVIZYON'];
		foreach($dataBel as $row){
			$BelSayArray[$yeterlilikid]['YETERLILIK_VERILEN_BELGE'][$row['YIL']] = array("BELSAY"=>$row['BELSAY'],
																		  				 "HAKSAY"=>0 );
		}
		
		foreach($dataHak as $cow){
			if(!array_key_exists($cow['YETERLILIK_ID'], $BelSayArray)){
				$yets = FormFactory::getYets($cow['YETERLILIK_ID']);
				$BelSayArray[$cow['YETERLILIK_ID']]['YETERLILIK_VERILEN_BELGE'][$row['YIL']] = array("HAKSAY"=>$cow['HAKSAY'],
																									 "YETERLILIK_ADI"=>$yets['YETERLILIK_ADI'],
																									 "YETERLILIK_KODU"=>$yets['YETERLILIK_KODU'],
																									 "REVIZYON"=>$yets['REVIZYON'],
																									 "BELSAY"=>0);
			}else{
				$BelSayArray[$cow['YETERLILIK_ID']]['YETERLILIK_VERILEN_BELGE'][$cow['YIL']]['HAKSAY'] = $cow['HAKSAY'];
			}
		}
		
		if($BelSayArray){
			return $BelSayArray;
		}else{
			return false;
		}
		
	}
	
	function verilenBelgelerDetay($kurulusId){
		$db = & JFactory::getOracleDBO();
		
		
		$sql = "SELECT COUNT(BELGENO) AS BELSAY , TO_CHAR(BELGE_DUZENLEME_TARIHI, 'YYYY') AS YIL
				FROM M_BELGE_SORGU
				WHERE KURULUS_ID = ?
				AND BELGENO NOT IN (SELECT BELGE_NO FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE KURULUS_ID = ?)
		
				GROUP BY TO_CHAR(BELGE_DUZENLEME_TARIHI, 'YYYY')";
		
		$dataBel = $db->prep_exec($sql, array($kurulusId,$kurulusId));
		
		$sqlHak = "select count(belge_no) as HAKSAY,TO_CHAR(BELGE_BAS_TARIH, 'YYYY') AS YIL from m_belgelendirme_hak_kazananlar
				where kurulus_id = ? and durum = 2 
		
GROUP BY TO_CHAR(BELGE_BAS_TARIH, 'YYYY')";
		
		$dataHak = $db->prep_exec($sqlHak, array($kurulusId));

		$BelSayArray = array();

		foreach($dataBel as $row){
			$BelSayArray['YETERLILIK_VERILEN_BELGE'][$row['YIL']] = array("BELSAY"=>$row['BELSAY'],
					"HAKSAY"=>0 );
		}
	
		foreach($dataHak as $cow){
				$BelSayArray['YETERLILIK_VERILEN_BELGE'][$cow['YIL']]['HAKSAY'] = $cow['HAKSAY'];
		}
		
		if($BelSayArray){
			return $BelSayArray;
		}else{
			return false;
		}
	}
	
	public function getYetYetkiOnayli($kurulus_id, $yetId=0){
		$db = JFactory::getOracleDBO ();
		
		$sqlEk = " AND (MUTD.DURUM = -2 OR MUTD.DURUM = 3)";
	
		$sqlDonem = "SELECT DISTINCT M_YETERLILIK.*, MUTY.UCRET, MUTD.DURUM AS MUTDURUM, MUTD.DONEM_ID, 
				TO_CHAR(MUTD.TARIH,'DD/MM/YYYY') AS MUTTARIH, MUTD.DONEM, MUTD.USER_ID
				FROM M_BELGELENDIRME_YET_YETKI MBYY
				INNER JOIN M_YETERLILIK ON(MBYY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				INNER JOIN M_UCRET_TARIFESI_YET MUTY ON(MBYY.YETERLILIK_ID = MUTY.YETERLILIK_ID AND MBYY.USER_ID = MUTY.USER_ID)
				INNER JOIN M_UCRET_TARIFESI_DONEM MUTD ON(MBYY.YETERLILIK_ID = MUTD.YET_ID AND MBYY.USER_ID = MUTD.USER_ID AND MUTY.DONEM_ID = MUTD.DONEM_ID)
				WHERE MBYY.USER_ID = ? AND MBYY.DURUM = 1 AND MBYY.YETERLILIK_ID = ?";
			$sqlDonem .= $sqlEk;
			$sqlDonem .= " ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
			$dataYets = $db->prep_exec($sqlDonem, array($kurulus_id,$yetId));
	
		return $dataYets;
	}
	
	public function getYetkiBirimOnayli($kurulus_id,$yetkiYets){
		$db = JFactory::getOracleDBO ();
	
		$yetkiBirims = array();
	
		foreach($yetkiYets as $row){
			if($row['YENI_MI'] == 1){
					$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MUT.DONEM_ID = ?";
					$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
					$yetkiBirims[$row['DONEM_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID'],$row['DONEM_ID']));
			}else{
					$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND MBYY.DURUM = 1 AND MUT.DONEM_ID = ?";
					$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
					$yetkiBirims[$row['DONEM_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID'],$row['DONEM_ID']));
			}
		}
	
		return array('yetkiBirims'=>$yetkiBirims);
	}
	
	public function ajaxGetYetUcretByDonem($post){
		$db = JFactory::getOracleDBO();
		$kId = $post['uId'];
		$yId = $post['yId'];
		$dId = $post['dId'];
		$return = array();
	
		$return['donemBilgi'] = $this->UcretTarifesiDonemByDonem($kId,$yId,$dId);
	
		$dataYet = $this->getYetYetkiDonem($kId,$yId,$dId);
		$return['yets'] = $dataYet[0];
		
		$return['birims'] = $this->getYetkiBirimDonem($kId,$dataYet,$dId);
	
		$birimler = array();
		foreach($return['birims']['yetkiBirims'] as $tow){
			$birimler[] = $tow['BIRIM_ID'];
		}
	
		if($dataYet[0]['YENI_MI'] == 1){
			$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					LEFT JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MBYY.BIRIM_ID NOT IN(".implode(',', $birimler).")";
		}else{
			$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					LEFT JOIN M_UCRET_TARIFESI MUT ON(MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND MBYY.DURUM = 1 AND MBYY.BIRIM_ID NOT IN(".implode(',', $birimler).")";
		}
			
		$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
			
		$dat = $db->prep_exec($sql, array($kId,$yId));
	
		foreach($dat as $cow){
			$return['birims']['yetkiBirims'][] = $cow;
		}
	
		return $return;
	}
	
	public function UcretTarifesiDonemByDonem($kurId,$yetId,$dId){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT DONEM_ID, YIL, DONEM, TO_CHAR(TARIH,'DD/MM/YYYY') AS TARIH, USER_ID, YET_ID, DURUM FROM M_UCRET_TARIFESI_DONEM
				WHERE USER_ID = ? AND YET_ID = ? AND DONEM_ID = ?";
	
		$data = $db->prep_exec($sql, array($kurId,$yetId,$dId));
	
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function UcretTarifeYet($kId){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT MY.* FROM M_UCRET_TARIFESI_DONEM MUTD 
				INNER JOIN M_YETERLILIK MY ON(MUTD.YET_ID = MY.YETERLILIK_ID) 
				WHERE MUTD.USER_ID = ? 
				ORDER BY MY.YETERLILIK_ADI ASC, MY.REVIZYON ASC";
		return $db->prep_exec($sql, array($kId));
	}
	
	function getKurulusTypeWithIds(){
		$type = array();
		
		$type['MESLEK_STD_KURULUS_DURUM_IDS'] = array();
		$datas = explode(',',MESLEK_STD_KURULUS_DURUM_IDS);
		foreach($datas as $key => $val){
			array_push($type['MESLEK_STD_KURULUS_DURUM_IDS'],trim($val));
		}
		
		$type['YETERLILIK_KURULUS_DURUM_IDS'] = array();
		$datas = explode(',',YETERLILIK_KURULUS_DURUM_IDS);
		foreach($datas as $key => $val){
			array_push($type['YETERLILIK_KURULUS_DURUM_IDS'],trim($val));
		}
		
		$type['SINAV_BELGELENDIRME_KURULUS_DURUM_IDS'] = array();
		$datas = explode(',',SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
		foreach($datas as $key => $val){
			array_push($type['SINAV_BELGELENDIRME_KURULUS_DURUM_IDS'],trim($val));
		}
		
		return $type;
	}
	
	public function getABKurulusBilgi($kId){
		$db = JFactory::getOracleDBO ();
		$sqlDonem = "SELECT * FROM AB_KURULUS_DONEM WHERE KURULUS_ID = ? ORDER BY TARIH";
		$sqlPro = "SELECT * FROM AB_KURULUS_PROTOKOL WHERE KURULUS_ID = ? ORDER BY TARIH";
		
		$dataDonem = $db->prep_exec($sqlDonem, array($kId));
		$dataPro = $db->prep_exec($sqlPro, array($kId));
		
		return array("pro"=>$dataPro, "donem"=>$dataDonem);
	}
	
	public function ABProKaydet($post,$files){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$proTar = $post['proTar'];
		$kId = $post['kId'];
		$proKDV = $post['proKDV'];
        $proVergiKimlik = $post['proVergiKimlik'];
		$pId = $post['pId'];
		$dId = $post['dId'];
		$proDok = $files['proDok'];
		
		if($dId == 0){
			if($proDok['error'] == 0 &&
					($proDok['type'] == "image/png" || $proDok['type'] == "image/jpeg" || $proDok['type'] == "image/gif"
							|| $proDok['type'] == "image/tiff" || $proDok['type'] == "application/zip" || $proDok['type'] == "application/x-rar-compressed"
							|| $proDok['type'] == "application/pdf")
			){
				$directory = EK_FOLDER."kurulus/".$kId."/ab_protokol";
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
					
				$fileName = explode('.',$proDok['name']);
				$name = date('YmdHis').'.'.$fileName[count($fileName)-1];
				$path = $directory.'/'.$name;
				if(!move_uploaded_file($proDok['tmp_name'], $path)){
					$return['hata'] = true;
					$return['message'] = 'Protokol dosyası yükleme işleminde hata meydana geldi. Lütfen protokol dosyası formatını kontrol ederek tekrar deneyiniz. (.png, .jpeg, .rar, .zip, .pdf)';
					return $return;
				}else{
					if($pId){
						$sqlIns = "UPDATE AB_KURULUS_PROTOKOL SET USER_ID = ?,PRO_TARIH = TO_DATE(?),PRO_DOK = ?, KDV = ?, VERGI_KIMLIK_NO = ?, TARIH = SYSDATE
						WHERE ID = ?";
						if($db->prep_exec_insert($sqlIns, array($user_id,$proTar,$name,$proKDV,$proVergiKimlik,$pId))){
							$return['hata'] = false;
							$return['message'] = 'AB Protokolü başarıyla eklendi.';
						}else{
							$return['hata'] = true;
							$return['message'] = 'Protokol dosyası yükleme işleminde hata meydana geldi. Lütfen tekrar deneyin.';
						}
					}else{
						$nextId = $db->getNextVal("SEQ_AB_PRO");
						$sqlIns = "INSERT INTO AB_KURULUS_PROTOKOL (ID,USER_ID,KURULUS_ID,PRO_TARIH,PRO_DOK,KDV,VERGI_KIMLIK_NO,TARIH)
						VALUES(?,?,?,TO_DATE(?),?,?,SYSDATE)";
						if($db->prep_exec_insert($sqlIns, array($nextId,$user_id,$kId,$proTar,$name,$proKDV,$proVergiKimlik))){
							$return['hata'] = false;
							$return['message'] = 'AB Protokolü başarıyla eklendi.';
						}else{
							$return['hata'] = true;
							$return['message'] = 'Protokol dosyası yükleme işleminde hata meydana geldi. Lütfen tekrar deneyin.';
						}
					}
				}
			}else{
				$return['hata'] = true;
				$return['message'] = 'Protokol dosyası yükleme işleminde hata meydana geldi. Lütfen protokol dosyası formatını kontrol ederek tekrar deneyiniz. (.png, .jpeg, .rar, .zip, .pdf)';
			}
		}else{
			$sqlIns = "UPDATE AB_KURULUS_PROTOKOL SET USER_ID = ?,PRO_TARIH = TO_DATE(?),KDV = ?, VERGI_KIMLIK_NO = ?, TARIH = SYSDATE
					WHERE ID = ?";
			if($db->prep_exec_insert($sqlIns, array($user_id,$proTar,$proKDV,$proVergiKimlik,$pId))){
				$return['hata'] = false;
				$return['message'] = 'AB Protokolü başarıyla eklendi.';
			}else{
				$return['hata'] = true;
				$return['message'] = 'Protokol dosyası yükleme işleminde hata meydana geldi. Lütfen tekrar deneyin.';
			}
		}

		return $return;
	}
	
	public function ABDonemKaydet($post){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$kId = $post['kId'];
		$BasTar = $post['BasTar'];
		$ucret = $post['ucret'];
		$aciklama = $post['aciklama'];
		
		if($post['dId']){
			$sqlIns = "UPDATE AB_KURULUS_DONEM SET BAS_TARIH = TO_DATE(?),UCRET = ?, ACIKLAMA = ?
				WHERE ID = ?";
			$params = array(
					$BasTar,
					$ucret,
					$aciklama,
					$post['dId']
			);
		}else{
			$nextId = $db->getNextVal('SEQ_AB_DONEM');
			
			$sqlIns = "INSERT INTO AB_KURULUS_DONEM (ID,KURULUS_ID,USER_ID,BAS_TARIH,UCRET,TARIH,ACIKLAMA)
				VALUES(?,?,?,TO_DATE(?),?,SYSDATE,?)";
			$params = array(
					$nextId,
					$kId,
					$user_id,
					$BasTar,
					$ucret,
					$aciklama
			);
		}
		
		if($db->prep_exec_insert($sqlIns, $params)){
			return true;
		}else{
			return false;
		}
	}
	
	public function DezUygulamaGuncelle($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "UPDATE AB_KURULUS_PROTOKOL SET DEZAVANTAJ = ? WHERE ID = ?";
		return $db->prep_exec_insert($sql, array($post['dId'],$post['id']), true);
	}
	
	public function HibeDonemDuzenle($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM AB_KURULUS_DONEM WHERE ID = ?";
		$data = $db->prep_exec($sql, array($post['dId']));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function AjaxKurProGetir($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM AB_KURULUS_PROTOKOL WHERE ID = ?";
		$data = $db->prep_exec($sql, array($post['pId']));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function ProDokSil($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM AB_KURULUS_PROTOKOL WHERE ID = ?";
		$data = $db->prep_exec($sql, array($post['pId']));
		if($data){
			$sqlDel = "UPDATE AB_KURULUS_PROTOKOL SET PRO_DOK = NULL WHERE ID = ?";
			if($db->prep_exec_insert($sqlDel, array($post['pId']))){
				unlink(EK_FOLDER.'kurulus/'.$data[0]['KURULUS_ID'].'/ab_protokol/'.$data[0]['PRO_DOK']);
				return true;
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function ProtokoluOlanKuruluslar(){
		$db = JFactory::getOracleDBO ();

        $sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI,
                M_KURULUS_EDIT.KURULUS_KISA_ADI AS KURULUS_KISA_ADI, M_KURULUS_EDIT.USER_ID AS KURULUS_ID,
                M_KURULUS_EDIT.VERGI_KIMLIK_NO AS VERGI_KIMLIK_NO,
                ABPRO.PRO_TARIH, ABDON.UCRET
				FROM M_KURULUS
				  INNER JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  INNER JOIN AB_KURULUS_PROTOKOL ABPRO ON M_KURULUS_EDIT.USER_ID = ABPRO.KURULUS_ID
				  LEFT JOIN AB_KURULUS_DONEM ABDON ON M_KURULUS_EDIT.USER_ID = ABDON.KURULUS_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0
				UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.KURULUS_KISA_ADI, M_KURULUS.USER_ID AS KURULUS_ID,
                M_KURULUS.VERGI_KIMLIK_NO, ABPRO.PRO_TARIH, ABDON.UCRET
				FROM M_KURULUS
				INNER JOIN AB_KURULUS_PROTOKOL ABPRO ON M_KURULUS.USER_ID = ABPRO.KURULUS_ID
				LEFT JOIN AB_KURULUS_DONEM ABDON ON M_KURULUS.USER_ID = ABDON.KURULUS_ID
				  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1)
				  ORDER BY UCRET DESC, KURULUS_ADI ASC";

		$data = $db->prep_exec($sql, array());

		return $data;
	}
	
	public function ProkoluDonemiOlanKuruluslar(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM AB_KURULUS_DONEM";
		$data = $db->prep_exec($sql, array());

		$don = array();
		foreach ($data as $row){
			$don[$row['KURULUS_ID']] = $row;
		}
		return $don;
	}

    public function AjaxGetKurVergiNo($post){
        $db = JFactory::getOracleDBO ();
        $kId = $post['kId'];
        return FormFactory::getKurulusBilgi($kId);
    }

    public function AjaxKurVergiNoGuncelle($post){
        $db = JFactory::getOracleDBO ();
        $kId = $post['kId'];
        $vergino = $post['vergino'];

        $sql = "SELECT * FROM M_KURULUS_EDIT WHERE USER_ID = ? AND AKTIF = 1";
        $dataAktif = $db->prep_exec($sql, array($kId));

        $sql = "SELECT * FROM M_KURULUS_EDIT WHERE USER_ID = ? AND AKTIF = 0 AND ONAY_BEKLEYEN = 1";
        $dataBekleyen = $db->prep_exec($sql, array($kId));

        $hata = 0;
        if($dataAktif){
            $sqlUp = "UPDATE M_KURULUS_EDIT SET VERGI_KIMLIK_NO = ? WHERE EDIT_ID = ? AND USER_ID = ?";
            if(!$db->prep_exec_insert($sqlUp,array($vergino,$dataAktif[0]['EDIT_ID'],$kId))){
                $hata++;
            }
        }

        if($dataBekleyen){
            $sqlUp = "UPDATE M_KURULUS_EDIT SET VERGI_KIMLIK_NO = ? WHERE EDIT_ID = ? AND USER_ID = ?";
            if(!$db->prep_exec_insert($sqlUp,array($vergino,$dataAktif[0]['EDIT_ID'],$kId))){
                $hata++;
            }
        }

        if(!$dataAktif){
            $sqlUp = "UPDATE M_KURULUS SET VERGI_KIMLIK_NO = ? WHERE USER_ID = ?";
            if(!$db->prep_exec_insert($sqlUp,array($vergino,$kId))){
                $hata++;
            }
        }

        if($hata>0){
            return false;
        }else{
            return true;
        }

    }

    function getAllKurulusWithoutPro($kurulus_durum=TUM_KURULUS_DURUM_IDS){
        $db  = &JFactory::getOracleDBO();

        $sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.")
				  AND M_KURULUS_EDIT.USER_ID NOT IN (SELECT KURULUS_ID FROM AB_KURULUS_PROTOKOL)
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND KURULUS_DURUM_ID IN(".$kurulus_durum.")
				  AND USER_ID NOT IN (SELECT KURULUS_ID FROM AB_KURULUS_PROTOKOL)
				  ORDER BY KURULUS_ADI ASC";
        return $db->prep_exec($sql, array());
    }
}
?>