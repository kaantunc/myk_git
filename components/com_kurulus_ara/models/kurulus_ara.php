<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class KurulusAraModelKurulus_Ara extends JModel {
	
	public function getKuruluslar($kurulus_durum){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
				M_KURULUS_YETKI_ASKI.ASKI
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
						JOIN M_BELGELENDIRME_YET_YETKI ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
					LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
					M_KURULUS_YETKI_ASKI.ASKI
					FROM M_KURULUS
					  JOIN M_BELGELENDIRME_YET_YETKI ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
						LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
					 UNION 
		SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
				M_KURULUS_YETKI_ASKI.ASKI
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
						JOIN M_BELGELENDIRME_YET_YETKI ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
					LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_BELGELENDIRME_YET_YETKI.DURUM = 0
AND M_KURULUS_YETKI_ASKI.ASKI = 1
					  ORDER BY YBKODU ASC";
		return $db->prep_exec($sql, array());
		
	}
	
	public function getKuruluslarWithSektorAndYets($kurulus_durum,$post){
		$db = JFactory::getOracleDBO ();
		
		$sqlAra = "";
		
		if($post['yets'] != 0){
			$sqlAra .= " AND M_YETERLILIK.YETERLILIK_ID = ".$post['yets'];
		}
		
		if($post['sektor'] != 0){
			$sqlAra .= " AND M_YETERLILIK.SEKTOR_ID = ".$post['sektor'];
		}
		
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
					M_KURULUS_EDIT.KURULUS_ADRESI, M_KURULUS_EDIT.KURULUS_TELEFON, M_KURULUS_EDIT.KURULUS_FAKS, M_KURULUS_EDIT.KURULUS_EPOSTA, M_KURULUS_EDIT.KURULUS_WEB, M_KURULUS_EDIT.KURULUS_POSTA_KODU,
					M_KURULUS_YETKI_ASKI.ASKI
					FROM M_KURULUS
					JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					JOIN M_BELGELENDIRME_YET_YETKI ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
					JOIN M_YETERLILIK ON M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0  AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
					 ".$sqlAra."
				UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
					M_KURULUS.KURULUS_ADRESI, M_KURULUS.KURULUS_TELEFON, M_KURULUS.KURULUS_FAKS, M_KURULUS.KURULUS_EPOSTA, M_KURULUS.KURULUS_WEB, 
					M_KURULUS.KURULUS_POSTA_KODU, M_KURULUS_YETKI_ASKI.ASKI
					FROM M_KURULUS
					JOIN M_BELGELENDIRME_YET_YETKI ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
					JOIN M_YETERLILIK ON M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					 LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1)  AND M_BELGELENDIRME_YET_YETKI.DURUM = 1
					 ".$sqlAra."
				ORDER BY YBKODU ASC";
		
		return $db->prep_exec($sql, array());
	}
	
	public function getKurulus($kurId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, 
					M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
					M_KURULUS_EDIT.KURULUS_ADRESI, M_KURULUS_EDIT.KURULUS_TELEFON, M_KURULUS_EDIT.KURULUS_FAKS, 
					M_KURULUS_EDIT.KURULUS_EPOSTA, M_KURULUS_EDIT.KURULUS_WEB, M_KURULUS_EDIT.KURULUS_POSTA_KODU,
				 	M_KURULUS_YETKI_ASKI.ASKI, M_KURULUS_YETKI_ASKI.TARIH
					FROM M_KURULUS
					JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0
					AND M_KURULUS_EDIT.USER_ID = ?
				UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU,
					M_KURULUS.KURULUS_ADRESI, M_KURULUS.KURULUS_TELEFON, M_KURULUS.KURULUS_FAKS, M_KURULUS.KURULUS_EPOSTA, 
					M_KURULUS.KURULUS_WEB, M_KURULUS.KURULUS_POSTA_KODU, M_KURULUS_YETKI_ASKI.ASKI, M_KURULUS_YETKI_ASKI.TARIH
					FROM M_KURULUS
				LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1)
					AND M_KURULUS.USER_ID = ?
				";
		$data = $db->prep_exec($sql, array($kurId,$kurId));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function GetAllYeterlilik($sektor){
		$db = JFactory::getOracleDBO ();
		
		$sqlSor = "";
		if($sektor){
			$sqlSor = " AND M_YETERLILIK.SEKTOR_ID = ".$sektor;
		}
		
		$sql = "SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.YETERLILIK_ADI,
				M_YETERLILIK.REVIZYON, M_YETERLILIK.YENI_MI, M_YETERLILIK.SEVIYE_ID
				FROM M_BELGELENDIRME_YET_YETKI
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1";
		
		$sql .= $sqlSor;
		$sql .= " ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
		
		return $db->prep_exec($sql, array());
	}
	
	public function getYetYetki($kurulus_id,$yetId = null){
		$db = JFactory::getOracleDBO ();
		$yetSorgu = "";
		if(!empty($yetId) && $yetId != 0){
			$yetSorgu .= " AND M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = ".$yetId;
		}
		$sql = "SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.YETERLILIK_ADI, 
				M_YETERLILIK.REVIZYON, M_YETERLILIK.YENI_MI, M_YETERLILIK.SEVIYE_ID 
				FROM M_BELGELENDIRME_YET_YETKI
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ? AND M_BELGELENDIRME_YET_YETKI.DURUM = 1 ";
		$sql .= $yetSorgu;
		$sql .= "ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
		
		return $db->prep_exec($sql, array($kurulus_id));
	}
	
	public function getYetYetkiTarife($kurulus_id,$yetId = null){
		$db = JFactory::getOracleDBO ();
		$yetSorgu = "";
		if(!empty($yetId) && $yetId != 0){
			$yetSorgu .= " AND M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = ".$yetId;
		}
		$sql = "SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.YETERLILIK_ADI,
				M_YETERLILIK.REVIZYON, M_YETERLILIK.YENI_MI ,M_UCRET_TARIFESI_YET.UCRET, M_YETERLILIK.SEVIYE_ID
				FROM M_BELGELENDIRME_YET_YETKI
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
				INNER JOIN M_UCRET_TARIFESI_YET ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_UCRET_TARIFESI_YET.YETERLILIK_ID AND M_BELGELENDIRME_YET_YETKI.USER_ID = M_UCRET_TARIFESI_YET.USER_ID)
				INNER JOIN M_UCRET_TARIFESI_DONEM MUTD ON(M_BELGELENDIRME_YET_YETKI.USER_ID = MUTD.USER_ID AND M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = MUTD.YET_ID AND M_UCRET_TARIFESI_YET.DONEM_ID = MUTD.DONEM_ID)
				WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ? AND M_BELGELENDIRME_YET_YETKI.DURUM = 1 AND MUTD.DURUM = 3";
		$sql .= $yetSorgu;
		$sql .= "ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
	
		return $db->prep_exec($sql, array($kurulus_id));
	}
	
	public function getYetkiBirim($kurulus_id,$yetkiYets){
		$db = JFactory::getOracleDBO ();
	
		$yetkiBirims = array();
	
		foreach($yetkiYets as $row){
	
			if($row['YENI_MI'] == 1){
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND DURUM = 1";
			}else{
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ?  AND DURUM = 1";
			}
	
			$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
	
			$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID']));
		}
	
		return $yetkiBirims;
	}
	
	public function getYetkiBirimTarif($kurulus_id,$yetkiYets){
		$db = JFactory::getOracleDBO ();
	
		$yetkiBirims = array();
	
		foreach($yetkiYets as $row){
				
			if($row['YENI_MI'] == 1){
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON (MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI_DONEM MUTD ON(MBYY.USER_ID = MUTD.USER_ID AND MBYY.YETERLILIK_ID = MUTD.YET_ID AND MUT.DONEM_ID = MUTD.DONEM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MUTD.DURUM = 3";
			}else{
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM, MUT.UCRET
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI MUT ON (MBYY.USER_ID = MUT.USER_ID AND MBYY.YETERLILIK_ID = MUT.YETERLILIK_ID AND MBYY.BIRIM_ID = MUT.BIRIM_ID)
					INNER JOIN M_UCRET_TARIFESI_DONEM MUTD ON(MBYY.USER_ID = MUTD.USER_ID AND MBYY.YETERLILIK_ID = MUTD.YET_ID AND MUT.DONEM_ID = MUTD.DONEM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? AND MBYY.DURUM = 1 AND MUTD.DURUM = 3";
			}
				
			$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
				
			$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID']));
		}
	
		return $yetkiBirims;
	}
	
	public function yetkiDisiYets($kurulusId){
		$db = JFactory::getOracleDBO ();
// 		$sqlYet = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, REVIZYON 
// 				FROM m_belgelendirme_yet_talebi
// 				JOIN M_YETERLILIK USING(YETERLILIK_ID) 
// 				JOIN M_BASVURU USING(EVRAK_ID) 
// 				WHERE USER_ID = ? AND YETERLILIK_ID NOT IN(
// 					SELECT DISTINCT YETERLILIK_ID FROM M_BELGELENDIRME_YET_YETKI WHERE USER_ID=?
// 				) 
// 				ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC, REVIZYON ASC";
// 		$data = $db->prep_exec($sqlYet, array($kurulusId,$kurulusId));

		$sqlYet = "SELECT DISTINCT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, REVIZYON
				FROM M_YETERLILIK 
				WHERE YETERLILIK_KODU IN (SELECT DISTINCT YETERLILIK_KODU FROM M_BELGELENDIRME_YET_TALEBI
					JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_BASVURU USING(EVRAK_ID) 
					WHERE USER_ID = ?)
				AND YETERLILIK_ID NOT IN(SELECT DISTINCT YETERLILIK_ID FROM M_BELGELENDIRME_YET_YETKI WHERE USER_ID=?)
				ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC, REVIZYON ASC";
		
		return $db->prep_exec($sqlYet, array($kurulusId,$kurulusId));
	}
	
	public function getKurulusBilgi($kurulusId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
				  ORDER BY KURULUS_ADI ASC";
		$data = $db->prep_exec($sql, array($kurulusId,$kurulusId));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function getYeterlilik($yetId){
		$db = JFactory::getOracleDBO ();
		
		$sql="SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$data = $db->prep_exec($sql, array($yetId));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function getYeterlilikBirims($yetId){
		$db = JFactory::getOracleDBO ();
		
		$yets = $this->getYeterlilik($yetId);
		
		if($yets['YENI_MI'] == 1){
			$sql="SELECT M_BIRIM.BIRIM_ID, M_BIRIM.BIRIM_KODU, M_BIRIM.BIRIM_ADI FROM M_BIRIM 
					INNER JOIN M_YETERLILIK_BIRIM MYB ON(M_BIRIM.BIRIM_ID = MYB.BIRIM_ID) 
					WHERE MYB.YETERLILIK_ID = ? 
					ORDER BY M_BIRIM.BIRIM_KODU ASC";
		}else{
			$sql="SELECT MYAB.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, 
					MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI
					FROM M_YETERLILIK_ALT_BIRIM MYAB
					WHERE MYAB.YETERLILIK_ID = ?
					ORDER BY MYAB.YETERLILIK_ALT_BIRIM_NO ASC";
		}
		
		$birims = $db->prep_exec($sql, array($yetId));
		
		return $birims;
	}
	
	public function YeniYetkiKaydet($post){
		$db = JFactory::getOracleDBO ();
		
		$kurulusId = $post['kurulusId'];
		$yetId = $post['yetId'];
		$birims = $post['yetBirims'];
		$yetkiTur = $post['yetkiTur'];
		$yetkiTarih = $post['yetkiTarih'];
		
		$yets = $this->getYeterlilik($yetId);
		
		if($yets['YENI_MI'] == 1){
			$yet_eski_mi = 0;
		}else{
			$yet_eski_mi = 1;
		}
		
		
		$hata = 0;
		foreach($birims as $row){
			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('01-01-2000 00:00:00','DD/MM/YYYY HH24:MI:SS'),?,?,1)";
// 			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
// 				VALUES (?,?,?,TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('01-01-2000 00:00:00','DD/MM/YYYY HH24:MI:SS'),?,?,1)";
			$param = array(
				$kurulusId,
					$yetId,
					$row,
					$yet_eski_mi,
					$yetkiTur[$row]
			);
			if($db->prep_exec_insert($sql, $param)){
				
			}else{
				$hata++;
			}
		}
		
		if($hata>0){
			if(count($birims) == $hata){
				return 2;
			}else{
				return 3;
			}
		}else{
// 			FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['TGUSERID']);
			return 1;
		}
	}
	
	public function getKurulusYetkiliBirims($kurulusId,$yetId){
		$db = JFactory::getOracleDBO ();
		
		$sql="SELECT * FROM M_BELGELENDIRME_YET_YETKI WHERE USER_ID = ? AND YETERLILIK_ID = ?";
		$data = $db->prep_exec($sql, array($kurulusId,$yetId));
		
		$yetBirims = array();
		if($data){
			foreach($data as $row){
				$yetBirims[$row['BIRIM_ID']] = $row;
			}
			
			return $yetBirims;
		}else{
			return false;
		}
	}
	
	public function getKurulusYetkiliBirimsOnaysiz($kurulusId,$yetId){
		$db = JFactory::getOracleDBO ();
	
		$sql="SELECT * FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ?";
		$data = $db->prep_exec($sql, array($kurulusId,$yetId));
	
		$yetBirims = array();
		if($data){
			foreach($data as $row){
				$yetBirims[$row['BIRIM_ID']] = $row;
			}
				
			return $yetBirims;
		}else{
			return false;
		}
	}
	
	public function YetkiDuzenleKaydet($post){
		$db = JFactory::getOracleDBO ();
	
		$kurulusId = $post['kurulusId'];
		$yetId = $post['yetId'];
		$birims = $post['yetBirims'];
		$yetkiTur = $post['yetkiTur'];
		$yetkiTarih = $post['yetkiTarih'];
	
		$yets = $this->getYeterlilik($yetId);
		$oncedenYetkiBirims = $this->getKurulusYetkiliBirims($kurulusId,$yetId);
		$anaBirims = $this->getYeterlilikBirims($yetId);
		$anaBirimler = array();
		foreach ($anaBirims as $tow){
			$anaBirimler[$tow['BIRIM_ID']] = $tow;
		}
		
		if($yets['YENI_MI'] == 1){
			$yet_eski_mi = 0;
		}else{
			$yet_eski_mi = 1;
		}
		
		$yeniKayit = array();
		$kayitliBirims = array();
		$gelenBirimler = array();
		foreach($birims as $row){
			if(!array_key_exists($row, $oncedenYetkiBirims)){
				$yeniKayit[] = $row;
			}else{
				$kayitliBirims[] = $row;
			}
			$gelenBirimler[$row] = array();
		}
		
		$yetkisiAlinacak = array_diff_key($oncedenYetkiBirims, $gelenBirimler);
		
		$sqlDelete = "DELETE FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ?";
		$db->prep_exec_insert($sqlDelete, array($kurulusId,$yetId));
		
		$hata = 0;
		//YENI KAYIT
		foreach($yeniKayit as $val){
// 			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YET_ESKI_MI, DENETIM_ID,DURUM)
// 				VALUES (?,?,?,TO_DATE('".$yetkiTarih[$val]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$yetkiTarih[$val]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),?,?)";
// 			$param = array(
// 					$kurulusId,
// 					$yetId,
// 					$row,
// 					$yet_eski_mi,
// 					$yetkiTur[$val],
// 					1
// 			);
			$tarih = explode(' ', $yetkiTarih[$val]);
			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),?,?,1)";
			$db->prep_exec_insert($sql, array($kurulusId,$yetId,$val,$yet_eski_mi,$yetkiTur[$val]));
// 			if($db->prep_exec_insert($sql, $param)){
			
// 			}else{
// 				$hata++;
// 			}
		}
		//YENI KAYIT SON
		
		//ESKI KAYITLAR
		foreach($kayitliBirims as $val){
// 			$sql = "UPDATE M_BELGELENDIRME_YET_YETKI SET YETKININ_VERILDIGI_TARIH = TO_DATE('".$yetkiTarih[$val]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'), DENETIM_ID = ?, DURUM = 1
// 						WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
// 			$db->prep_exec_insert($sql, array($yetkiTur[$val],$kurulusId,$yetId,$val));
			$tarih = explode(' ', $yetkiTarih[$val]);
			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),?,?,1)";
			
			$db->prep_exec_insert($sql, array($kurulusId,$yetId,$val,$yet_eski_mi,$yetkiTur[$val]));
		}
		//ESKI KAYITLAR SON
		
		//YETKISI ALINACAK
		foreach($yetkisiAlinacak as $key=>$val){
			$tarih = explode(' ', $yetkiTarih[$key]);
			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$tarih[0]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),?,?,0)";
// 			$sql = "UPDATE M_BELGELENDIRME_YET_YETKI SET YETKININ_GERI_ALINDIGI_TARIH = TO_DATE('".$yetkiTarih[$key]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'), DENETIM_ID = ?, DURUM = 0
// 						WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
			$db->prep_exec_insert($sql, array($kurulusId,$yetId,$key,$yet_eski_mi,$yetkiTur[$key]));
		}
		//YETKISI ALINACAK SON
				
/*		$hata = 0;
		foreach($birims as $row){
			if(!array_key_exists($row, $oncedenYetkiBirims)){
				$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YET_ESKI_MI, DENETIM_ID)
				VALUES (?,?,?,TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'),?,?)";
				
				$param = array(
						$kurulusId,
						$yetId,
						$row,
// 						$yetkiTarih[$row].' '.date("H:i:s"),
// 						$yetkiTarih[$row].' '.date("H:i:s"),
// 						date('d-m-Y H:i:s'),
// 						date('d-m-Y H:i:s'),
						$yet_eski_mi,
						$yetkiTur[$row]
				);
				if($db->prep_exec_insert($sql, $param)){
				
				}else{
					$hata++;
				}
			}else{
				if($oncedenYetkiBirims[$row]['YETKININ_VERILDIGI_TARIH'] <= $oncedenYetkiBirims[$row]['YETKININ_GERI_ALINDIGI_TARIH']){
					$sql = "UPDATE M_BELGELENDIRME_YET_YETKI SET YETKININ_VERILDIGI_TARIH = TO_DATE('".$yetkiTarih[$row]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'), DENETIM_ID = ?
						WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
					$db->prep_exec_insert($sql, array($yetkiTur[$row],$kurulusId,$yetId,$row));
				}
			}
		}
		
		foreach($oncedenYetkiBirims as $key=>$val){
			if(!in_array($key, $birims)){
				$sql = "UPDATE M_BELGELENDIRME_YET_YETKI SET YETKININ_GERI_ALINDIGI_TARIH = TO_DATE('".$yetkiTarih[$key]." ".date("H:i:s")."','DD/MM/YYYY HH24:MI:SS'), DENETIM_ID = ?
						WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
				$db->prep_exec_insert($sql, array($yetkiTur[$key],$kurulusId,$yetId,$key));
			}
		}
*/		
		return 1;
// 		if($hata>0){
// 			if(count($birims) == $hata){
// 				return 2;
// 			}else{
// 				return 3;
// 			}
// 		}else{
// 			return 1;
// 		}
	}
	
	public function getKurulusDenetim($kurulusId){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM M_DENETIM 
				JOIN PM_DENETIM_TURU USING(DENETIM_TURU) 
				WHERE DENETIM_KURULUS_ID = ?";
		return $db->prep_exec($sql, array($kurulusId));
	}
	
	public function OnayBekleyenKurs(){
		$db = JFactory::getOracleDBO ();
		
		$sql="
		SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI 
			FROM M_BELGELENDIRME_YET_YETKI_ONAY
			JOIN M_KURULUS ON M_BELGELENDIRME_YET_YETKI_ONAY.USER_ID = M_KURULUS.USER_ID
			JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
			WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0
		UNION
		SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI 
			FROM M_BELGELENDIRME_YET_YETKI_ONAY
			JOIN M_KURULUS ON M_BELGELENDIRME_YET_YETKI_ONAY.USER_ID = M_KURULUS.USER_ID
			WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1)
		ORDER BY KURULUS_ADI ASC
		";
		
		return $db->prep_exec($sql, array());
	}
	
	public function OnayBekleyenYetsWithKurs($kurulusId){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT M_YETERLILIK.* FROM M_BELGELENDIRME_YET_YETKI_ONAY 
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI_ONAY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID) 
				WHERE M_BELGELENDIRME_YET_YETKI_ONAY.USER_ID = ? 
				ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
		
		return $db->prep_exec($sql, array($kurulusId));
	}
	
	public function YetkiOnayla($post){
		$db = JFactory::getOracleDBO ();
		
		$kurulusId = $post['kurulusId'];
		$yetId = $post['yetId'];
		$birims = $post['yetBirims'];
		
		$yets = $this->getYeterlilik($yetId);
		$oncedenYetkiBirims = $this->getKurulusYetkiliBirims($kurulusId,$yetId);
		$anaBirims = $this->getYeterlilikBirims($yetId);
		$anaBirimler = array();
		foreach ($anaBirims as $tow){
			$anaBirimler[$tow['BIRIM_ID']] = $tow;
		}
		
		if($yets['YENI_MI'] == 1){
			$yet_eski_mi = 0;
		}else{
			$yet_eski_mi = 1;
		}
		
		$yeniKayit = array();
		$kayitliBirims = array();
		$gelenBirimler = array();
		foreach($birims as $row){
			if(!array_key_exists($row, $oncedenYetkiBirims)){
				$yeniKayit[] = $row;
			}else{
				$kayitliBirims[] = $row;
			}
			$gelenBirimler[$row] = array();
		}
		
		$yetkisiAlinacak = array_diff_key($oncedenYetkiBirims, $gelenBirimler);
		
		//YENI KAYIT
		foreach($yeniKayit as $val){
			$sql="SELECT * FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID=? AND YETERLILIK_ID=? AND BIRIM_ID=?";
			$data = $db->prep_exec($sql, array($kurulusId,$yetId,$val));
			
			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI, DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'),TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'),TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'),?,?,?)";
			$param = array(
				$kurulusId,
				$yetId,
				$val,
				$data[0]['YETKI_KAPSAMI_YETKI_TARIHI'],
				$data[0]['YETKININ_VERILDIGI_TARIH'],
				$data[0]['YETKININ_GERI_ALINDIGI_TARIH'],
				$yet_eski_mi,
				$data[0]['DENETIM_ID'],
				1
			);
			
// 			$db->prep_exec_insert($sql, $param);
			if($db->prep_exec_insert($sql, $param)){
			
			}else{
				$hata++;
			}
		}
		//YENI KAYIT SON
		
		//Update edilecek
		foreach($kayitliBirims as $val){
			$sql="SELECT * FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID=? AND YETERLILIK_ID=? AND BIRIM_ID=?";
			$data = $db->prep_exec($sql, array($kurulusId,$yetId,$val));
			
			if($data[0]['DURUM'] == 1){
				$sqlUp = "UPDATE M_BELGELENDIRME_YET_YETKI
					SET YETKININ_VERILDIGI_TARIH = TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'), 
						DENETIM_ID = ?,
						DURUM = ?
				WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
				
				$param = array(
						$data[0]['YETKININ_VERILDIGI_TARIH'],
						$data[0]['DENETIM_ID'],
						1,
						$kurulusId,
						$yetId,
						$val,
				);
			}else{
				$sqlUp = "UPDATE M_BELGELENDIRME_YET_YETKI
					SET YETKININ_GERI_ALINDIGI_TARIH = TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'),
						DENETIM_ID = ?,
						DURUM = ?
				WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
				
				$param = array(
						$data[0]['YETKININ_GERI_ALINDIGI_TARIH'],
						$data[0]['DENETIM_ID'],
						0,
						$kurulusId,
						$yetId,
						$val,
				);
			}
			
			$db->prep_exec_insert($sqlUp, $param);
		}
		//Update edilecek SOn	
			
		$sqlDelete = "DELETE FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ?";
		$db->prep_exec_insert($sqlDelete, array($kurulusId,$yetId));
		
		return 1;
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
	
	public function YetkiTarihi($kurId){
		$db = JFactory::getOracleDBO();
		$sql="SELECT M_BELGELENDIRME_DOCS.*
				FROM M_BELGELENDIRME_DOCS 
				JOIN M_BASVURU ON M_BELGELENDIRME_DOCS.EVRAK_ID = M_BASVURU.EVRAK_ID
				WHERE M_BASVURU.USER_ID = ? AND M_BELGELENDIRME_DOCS.BELGE_TURU = 'yetsozlesme'
				AND ROWNUM = 1 AND M_BASVURU.BASVURU_DURUM_ID = 6 AND M_BELGELENDIRME_DOCS.BAS_TARIH IS NOT NULL
				ORDER BY M_BELGELENDIRME_DOCS.EVRAK_ID ASC ";
		$data = $db->prep_exec($sql, array($kurId));
		
		if($data){
			return $data[0]['BAS_TARIH'];
		}else{
			return null;
		}
	}
	
	public function getYetkiBirimTarife($kurulus_id,$yetkiYets){
		$db = JFactory::getOracleDBO ();
	
		$yetkiBirims = array();
		$birimTurs = array();
		$ucretler = array();
	
		foreach($yetkiYets as $row){
	
			if($row['YENI_MI'] == 1){
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
	
			$yetkiBirims[$row['YETERLILIK_ID']] = $db->prep_exec($sql, array($kurulus_id,$row['YETERLILIK_ID']));
				
				
			if($row['YENI_MI'] == 1){
				foreach($yetkiBirims[$row['YETERLILIK_ID']] as $key=>$val){
						
					$sqlTur = "SELECT BIRIM_ID,OLC_DEG_HARF,OLC_DEG_NUMARA  FROM M_BIRIM_OLCME_DEGERLENDIRME
							WHERE BIRIM_ID = ? AND OLC_DEG_HARF != 'D'
								ORDER BY OLC_DEG_HARF DESC, OLC_DEG_NUMARA ASC";
						
					$pata = $db->prep_exec($sqlTur, array($val['BIRIM_ID']));
	
					// Ucre Tarifesi
					foreach ($pata as $cow){
						$birimTurs[$row['YETERLILIK_ID']][$val['BIRIM_ID']][] = $cow['OLC_DEG_HARF'].$cow['OLC_DEG_NUMARA'];
						$sqlUcret = 'SELECT * FROM M_UCRET_TARIFESI_TUR
									WHERE BIRIM_ID = ? AND YETERLILIK_ID=? AND USER_ID=? AND TUR_KODU=?';
							
						$ucretler[$row['YETERLILIK_ID']][$val['BIRIM_ID']][$cow['OLC_DEG_HARF'].$cow['OLC_DEG_NUMARA']] = $db->prep_exec($sqlUcret, array($val['BIRIM_ID'],$row['YETERLILIK_ID'],$kurulus_id,$cow['OLC_DEG_HARF'].$cow['OLC_DEG_NUMARA']));
					}
				}
			}else{
				foreach($yetkiBirims[$row['YETERLILIK_ID']] as $key=>$val){
					$sqlTur = "SELECT BIRIM_ID, TUR_KODU, TUR FROM M_YETERLILIK_ALT_BIRIM_TUR
							WHERE BIRIM_ID = ?
							ORDER BY TUR ASC, TUR_KODU ASC";
						
					$pata = $db->prep_exec($sqlTur, array($val['BIRIM_ID']));
					// 					$birimTurs[$row['YETERLILIK_ID']][$val['BIRIM_ID']] = $pata;
						
					// Ucre Tarifesi
					foreach ($pata as $cow){
						$birimTurs[$row['YETERLILIK_ID']][$val['BIRIM_ID']][] = $cow['TUR_KODU'];
						$sqlUcret = 'SELECT * FROM M_UCRET_TARIFESI_TUR
									WHERE BIRIM_ID = ? AND YETERLILIK_ID=? AND USER_ID=? AND TUR_KODU=?';
							
						$ucretler[$row['YETERLILIK_ID']][$val['BIRIM_ID']][$cow['TUR_KODU']] = $db->prep_exec($sqlUcret, array($val['BIRIM_ID'],$row['YETERLILIK_ID'],$kurulus_id,$cow['TUR_KODU']));
					}
				}
			}
				
		}
	
	
		return array('yetkiBirims'=>$yetkiBirims,'turs'=>$birimTurs,'ucrets'=>$ucretler);
	}
}