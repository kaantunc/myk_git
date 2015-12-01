<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class BelgelendirmeyetkiModelBelgelendirme_Yetki extends JModel {
	
	public function getKurulus($kurulus_durum){
		$db = JFactory::getOracleDBO ();
		$user 	 	= &JFactory::getUser();
		$user_id	= $user->getOracleUserId ();
		$aut = FormFactory::checkAuthorization  ($user, 27);
		
		if($user_id == 40 || $aut){
			$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  JOIN M_BASVURU ON M_KURULUS.USER_ID = M_BASVURU.USER_ID
					  JOIN M_BELGELENDIRME_DURUM ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.") 
					  		AND M_BASVURU.BASVURU_TIP_ID = 3 AND M_BELGELENDIRME_DURUM.DURUM_ID = 20
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
					  JOIN M_BASVURU ON M_KURULUS.USER_ID = M_BASVURU.USER_ID
					  JOIN M_BELGELENDIRME_DURUM ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.")
					  		AND M_BASVURU.BASVURU_TIP_ID = 3 AND M_BELGELENDIRME_DURUM.DURUM_ID = 20
					  ORDER BY KURULUS_ADI ASC";
			return $db->prep_exec($sql, array());
		}else{
			$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  JOIN M_KURULUS_GOREVLI ON M_KURULUS.USER_ID = M_KURULUS_GOREVLI.KURULUS_ID
					JOIN M_BASVURU ON M_KURULUS.USER_ID = M_BASVURU.USER_ID
					  JOIN M_BELGELENDIRME_DURUM ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.")
					  		AND M_KURULUS_GOREVLI.TGUSERID = ? AND M_BASVURU.BASVURU_TIP_ID = 3 AND M_BELGELENDIRME_DURUM.DURUM_ID = 20
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_GOREVLI ON M_KURULUS.USER_ID = M_KURULUS_GOREVLI.KURULUS_ID
					  		JOIN M_BASVURU ON M_KURULUS.USER_ID = M_BASVURU.USER_ID
					  JOIN M_BELGELENDIRME_DURUM ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.")
					  		AND M_KURULUS_GOREVLI.TGUSERID = ? AND M_BASVURU.BASVURU_TIP_ID = 3 AND M_BELGELENDIRME_DURUM.DURUM_ID = 20
					  ORDER BY KURULUS_ADI ASC";
			return $db->prep_exec($sql, array($user_id,$user_id));
		}
		
// 		$sqlGorevli = "SELECT TGUSERID FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
// 		$gorevli = $_db->prep_exec($sqlGorevli, array($user_id));
	}
	
	public function getYetYetki($kurulus_id){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_YETERLILIK.* FROM M_BELGELENDIRME_YET_YETKI 
				INNER JOIN M_YETERLILIK ON(M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID) 
				WHERE M_BELGELENDIRME_YET_YETKI.USER_ID = ? 
				ORDER BY M_YETERLILIK.YETERLILIK_ADI ASC, M_YETERLILIK.YETERLILIK_KODU ASC, M_YETERLILIK.REVIZYON ASC";
		
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
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? ";
			}else{
				$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI, MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, 
						MBYY.YETKININ_VERILDIGI_TARIH, MBYY.YETKININ_GERI_ALINDIGI_TARIH, MBYY.DENETIM_ID, MBYY.DURUM
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? ";
			}
			
			$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
			
// 			$sql = "SELECT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.REVIZYON, M_YETERLILIK.YETERLILIK_ADI, MBYY.YET_ESKI_MI,
// 					MBYY.BIRIM_ID, M_BIRIM.BIRIM_ADI, M_BIRIM.BIRIM_KODU
// 					FROM M_BELGELENDIRME_YET_YETKI MBYY
// 					INNER JOIN M_YETERLILIK ON(MBYY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
// 					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
// 					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
// 					WHERE MBYY.USER_ID = ? AND M_YETERLILIK.YETERLILIK_ID = ?
		
// 			UNION
					
// 				SELECT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.REVIZYON, M_YETERLILIK.YETERLILIK_ADI, MBYY.YET_ESKI_MI,
// 					MBYY.BIRIM_ID, MYAB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU
// 					FROM M_BELGELENDIRME_YET_YETKI MBYY
// 					INNER JOIN M_YETERLILIK ON(MBYY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID)
// 					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
// 					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
// 					WHERE MBYY.USER_ID = ? AND M_YETERLILIK.YETERLILIK_ID = ?
			
// 					ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC,
// 					REVIZYON ASC, BIRIM_KODU ASC";
			
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
				AND YETERLILIK_DURUM_ID = 2
				ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC, REVIZYON ASC";
		
		return $db->prep_exec($sqlYet, array($kurulusId,$kurulusId));
	}
	
	public function getKurulusBilgi($kurulusId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_KURULUS.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_YETKI_ASKI.ASKI 
				FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
				UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS_YETKI_ASKI.ASKI 
				FROM M_KURULUS 
				LEFT JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
				  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
				  ";
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
			$kurBilgi = $this->getKurulusBilgi($kurulusId);
			$mailGorevli = array('mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
			// 			$mailGorevli = array('ktunc@myk.gov.tr');
			$baslik = 'Yetki Başvurusu Onayı';
			$icerik = $kurBilgi['KURULUS_ADI'].' kuruluşu için '.$yets['YETERLILIK_KODU'].'/'.$yets['REVIZYON'].' '.$yets['YETERLILIK_ADI'].' yeterliliğinden yetki başvurusu yapıldı. Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout=kurulus_yetki_duzenle&kurulusId='.$kurulusId.'&yetkiYet='.$yetId;
			$to = $mailGorevli;
			FormFactory::sentEmail($baslik,$icerik,$to);
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
		
		$hata = 0;
		//YENI KAYIT
		foreach($yeniKayit as $val){
			$tarih = explode(' ', $yetkiTarih[$val]);
			$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),?,?,1)";
			$param = array($kurulusId,$yetId,$val,$yet_eski_mi,$yetkiTur[$val]);
			
			if(!$db->prep_exec_insert($sql, $param)){
				$hata++;
			}
		}
		//YENI KAYIT SON
		
		//ESKI KAYITLAR
		foreach($kayitliBirims as $val){
			$tarih = explode(' ', $yetkiTarih[$val]);
			
			$sqlGetir = "SELECT TO_CHAR(YETKININ_VERILDIGI_TARIH,'DD/MM/YYYY') AS YVT, TO_CHAR(YETKININ_GERI_ALINDIGI_TARIH,'DD/MM/YYYY') AS YGT, DENETIM_ID, DURUM FROM M_BELGELENDIRME_YET_YETKI WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ? AND YET_ESKI_MI = ?";
			$degs = $db->prep_exec($sqlGetir, array($kurulusId,$yetId,$val,$yet_eski_mi));
			
			if($degs[0]['DURUM'] == 1){
				if($tarih[0] != $degs[0]['YVT'] || $yetkiTur[$val] != $degs[0]['DENETIM_ID']){
					$sqlDelete = "DELETE FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
					$db->prep_exec_insert($sqlDelete, array($kurulusId,$yetId,$val));
					
					$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),?,?,1)";
						
					$param = array($kurulusId,$yetId,$val,$yet_eski_mi,$yetkiTur[$val]);
				
					if(!$db->prep_exec_insert($sql, $param)){
						$hata++;
					}
				}
			}else{
				$sqlDelete = "DELETE FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
				$db->prep_exec_insert($sqlDelete, array($kurulusId,$yetId,$val));
				
				$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),?,?,1)";
				
				$param = array($kurulusId,$yetId,$val,$yet_eski_mi,$yetkiTur[$val]);
				
				if(!$db->prep_exec_insert($sql, $param)){
					$hata++;
				}
			}
		}
		//ESKI KAYITLAR SON
		
		//YETKISI ALINACAK
		foreach($yetkisiAlinacak as $key=>$val){
			$tarih = explode(' ', $yetkiTarih[$key]);
			$sqlGetir = "SELECT TO_CHAR(YETKININ_VERILDIGI_TARIH,'DD/MM/YYYY') AS YVT, TO_CHAR(YETKININ_GERI_ALINDIGI_TARIH,'DD/MM/YYYY') AS YGT, DENETIM_ID, DURUM FROM M_BELGELENDIRME_YET_YETKI WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ? AND YET_ESKI_MI = ?";
			$degs = $db->prep_exec($sqlGetir, array($kurulusId,$yetId,$key,$yet_eski_mi));
			
			if($degs[0]['DURUM'] == 0){
				if($tarih[0] != $degs[0]['YGT'] || $yetkiTur[$key] != $degs[0]['DENETIM_ID']){
					$sqlDelete = "DELETE FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
					$db->prep_exec_insert($sqlDelete, array($kurulusId,$yetId,$key));
					
					$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),?,?,0)";
						
					$param = array($kurulusId,$yetId,$key,$yet_eski_mi,$yetkiTur[$key]);
						
					if(!$db->prep_exec_insert($sql, $param)){
						$hata++;
					}
				}
			}else{
				$sqlDelete = "DELETE FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID = ? AND YETERLILIK_ID = ? AND BIRIM_ID = ?";
				$db->prep_exec_insert($sqlDelete, array($kurulusId,$yetId,$key));
				
				$sql = "INSERT INTO M_BELGELENDIRME_YET_YETKI_ONAY (USER_ID, YETERLILIK_ID, BIRIM_ID, YETKI_KAPSAMI_YETKI_TARIHI, YETKININ_VERILDIGI_TARIH, YETKININ_GERI_ALINDIGI_TARIH, YET_ESKI_MI,DENETIM_ID,DURUM)
				VALUES (?,?,?,TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),TO_DATE('".$tarih[0]."','DD/MM/YYYY'),?,?,0)";
				
				$param = array($kurulusId,$yetId,$key,$yet_eski_mi,$yetkiTur[$key]);
				
				if(!$db->prep_exec_insert($sql, $param)){
					$hata++;
				}
			}
			
		}
		//YETKISI ALINACAK SON
		
		
		if($hata>0){
			return 2;
		}else{
			$kurBilgi = $this->getKurulusBilgi($kurulusId);
			$mailGorevli = array('mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
// 			$mailGorevli = array('ktunc@myk.gov.tr');
			$baslik = 'Yetki Başvurusu Onayı';
			$icerik = $kurBilgi['KURULUS_ADI'].' kuruluşu için '.$yets['YETERLILIK_KODU'].'/'.$yets['REVIZYON'].' '.$yets['YETERLILIK_ADI'].' yeterliliğinden yetki başvurusu yapıldı. Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout=kurulus_yetki_duzenle&kurulusId='.$kurulusId.'&yetkiYet='.$yetId;
			$to = $mailGorevli;
			FormFactory::sentEmail($baslik,$icerik,$to);
			
			return 1;
		}
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
	
	public function getOnayBekleyen($kurId,$yetId){
		$db = JFactory::getOracleDBO ();
		
		$sql="SELECT * FROM M_BELGELENDIRME_YET_YETKI_ONAY WHERE USER_ID=? AND YETERLILIK_ID=?";
		$data = $db->prep_exec($sql, array($kurId,$yetId));
		
		if($data){
			return true;
		}else{
			return false;
		}
	}
	
	public function getAskidakiKuruluslar(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, 
				M_KURULUS_YETKI_ASKI.TARIH  
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  INNER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 
					UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS_YETKI_ASKI.TARIH 
				  FROM M_KURULUS
					  INNER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS.USER_ID = M_KURULUS_YETKI_ASKI.KURULUS_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) 
			ORDER BY KURULUS_ADI ASC";
		return $db->prep_exec($sql, array());
	}
	
	public function getAskiDisiKuruluslar(){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  JOIN M_BASVURU ON M_KURULUS.USER_ID = M_BASVURU.USER_ID
					  JOIN M_BELGELENDIRME_DURUM ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
					WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".SINAV_BELGELENDIRME_KURULUS_DURUM_IDS.") 
					  		AND M_BASVURU.BASVURU_TIP_ID = 3 AND M_BELGELENDIRME_DURUM.DURUM_ID = 20 AND 
						M_KURULUS.USER_ID NOT IN (SELECT KURULUS_ID FROM M_KURULUS_YETKI_ASKI)
					UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI
				  FROM M_KURULUS
					  JOIN M_BASVURU ON M_KURULUS.USER_ID = M_BASVURU.USER_ID
					  JOIN M_BELGELENDIRME_DURUM ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
					WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.KURULUS_DURUM_ID IN(".SINAV_BELGELENDIRME_KURULUS_DURUM_IDS.")
					AND M_BASVURU.BASVURU_TIP_ID = 3 AND M_BELGELENDIRME_DURUM.DURUM_ID = 20 AND
						M_KURULUS.USER_ID NOT IN (SELECT KURULUS_ID FROM M_KURULUS_YETKI_ASKI)
			ORDER BY KURULUS_ADI ASC";
		return $db->prep_exec($sql, array());
	}
	
	public function AskiyaAl($post){
		$db = JFactory::getOracleDBO ();
		
		$user 	 	= &JFactory::getUser();
		$user_id	= $user->getOracleUserId ();
		
		$sql="INSERT INTO M_KURULUS_YETKI_ASKI (KURULUS_ID,USER_ID,TARIH) VALUES(?,?,TO_DATE(?,'DD/MM/YYYY'))";
		$return = $db->prep_exec_insert($sql, array($post['kurulus'],$user_id,$post['tarih']));
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	public function AskiyiGeriAl($post){
		$db = JFactory::getOracleDBO ();
		
		$sql="DELETE FROM M_KURULUS_YETKI_ASKI WHERE KURULUS_ID = ?";
		$return = $db->prep_exec_insert($sql, array($post['kurId']));
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
}