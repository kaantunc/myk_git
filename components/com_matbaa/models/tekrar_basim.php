<?php
defined('_JEXEC') or die('Restricted access');
include ('libraries/phpqrcode/qrlib.php');

class MatbaaModelTekrar_Basim extends JModel {
	
	function BasilacakBelgeler($durum,$user_id=null){
		$db = JFactory::getOracleDBO ();
		if($user_id){
			$sql = "SELECT DISTINCT MBTB.*, MBS.*
					FROM M_BELGE_TEKRAR_BASIM MBTB
					JOIN M_BELGE_SORGU MBS ON MBTB.BELGE_ID = MBS.ID
					WHERE MBTB.DURUM = ? AND MBS.KURULUS_ID = ? ORDER BY MBTB.ISTEK_TARIHI ASC";
			$basilacak = $db->prep_exec($sql, array($durum,$user_id));
		}else{
			$sql = "SELECT DISTINCT MBTB.*, MBS.*
					FROM M_BELGE_TEKRAR_BASIM MBTB
					JOIN M_BELGE_SORGU MBS ON MBTB.BELGE_ID = MBS.ID
					WHERE MBTB.DURUM = ? ORDER BY MBTB.ISTEK_TARIHI ASC";
			$basilacak = $db->prep_exec($sql, array($durum));
		}
		
		$KurBilgi = array();
		foreach ($basilacak as $row){
			$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ? 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND USER_ID = ?
					  ORDER BY KURULUS_ADI ASC";
		
			$KurBilgi[$row['BASIM_ID']] = $db->prep_exec($sqlKur, array($row['KURULUS_ID'],$row['KURULUS_ID']));
		}
		
		return array('basilacak'=>$basilacak,'KurBilgi'=>$KurBilgi);
	}

	function getAdayBelgeExcel($basimId){
		$db = JFactory::getOracleDBO ();
		 
		$sqlBasim = "SELECT * FROM M_BELGE_TEKRAR_BASIM WHERE BASIM_ID = ?";
		$Basim = $db->prep_exec($sqlBasim, array($basimId));
		
		$sqlBilgi = "SELECT * FROM M_BELGE_SORGU WHERE ID = ?";
		$BelgeBilgi = $db->prep_exec($sqlBilgi, array($Basim[0]['BELGE_ID']));
		
		// Yeterlilik
		$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$dataYet = $db->prep_exec($sqlYet, array($BelgeBilgi[0]['YETERLILIK_ID']));
		
		// Kuruluş Bilgi
		$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, 
						M_KURULUS.LOGO, MBKS.MYK_MARKASI, MBKS.TURKAK_MARKASI, 
						M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI, MBKS.AKREDITASYON_NO, M_KURULUS_EDIT.KURULUS_WEB 
						FROM M_KURULUS
						JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
						JOIN M_BELGELENDIRME_KURULUS_SABLON MBKS ON M_KURULUS.USER_ID = MBKS.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ? 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, MBKS.MYK_MARKASI,
						MBKS.TURKAK_MARKASI, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI, MBKS.AKREDITASYON_NO,
						M_KURULUS.KURULUS_WEB
						FROM M_KURULUS
						JOIN M_BELGELENDIRME_KURULUS_SABLON MBKS ON M_KURULUS.USER_ID = MBKS.KURULUS_ID
					  	WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  	ORDER BY KURULUS_ADI ASC";
		
		$KurBilgi = $db->prep_exec($sqlKur, array($BelgeBilgi[0]['KURULUS_ID'],$BelgeBilgi[0]['KURULUS_ID']));
		
		// Eski belge numarası var mi?
		$sqlEdit = "SELECT * FROM M_BELGE_SORGU_OLD 
				WHERE ID = ? AND BELGENO != ? AND ROWNUM <= 1 
				ORDER BY DEG_TARIH ASC";
		$eskiBelge = $db->prep_exec($sqlEdit, array($Basim[0]['BELGE_ID'],$BelgeBilgi[0]['BELGENO']));
		
		// Başarılı Birimleri
		if($eskiBelge){
			$belgeNo = $eskiBelge[0]['BELGENO'];
		}else{
			$belgeNo = $BelgeBilgi[0]['BELGENO'];
		}
		
		$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?";
		
		$data2 = $db->prep_exec($sql, array($belgeNo));
		
		$AdayBirims = array();
		
		if($data2){
			if($dataYet[0]['YENI_MI']==1){
				$sqlBirim="SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM
					JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_KODU";
			
				foreach($data2 as $cow){
					$AdayBirims[$Basim[0]['BELGE_ID']] = $db->prep_exec($sqlBirim, array($cow['ID']));
				}
			}else{
				$sqlBirim="SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, M_YETERLILIK.YETERLILIK_KODU FROM M_BELGELENDIRME_BASARILI_BIRIM
					JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
					JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_NO";
			
				foreach($data2 as $cow){
					$birims = $db->prep_exec($sqlBirim, array($cow['ID']));
					for($t = 0; $t<count($birims); $t++){
						$birims[$t]['BIRIM_KODU'] = $birims[$t]['YETERLILIK_KODU'].'/'.$birims[$t]['BIRIM_NO'];
					}
					$AdayBirims[$Basim[0]['BELGE_ID']] = $birims;
				}
			}
		}else{
            $eskiSinavBirim = array();
            $sql = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 2";
            $pat = $db->prep_exec_array($sql, array($BelgeBilgi[0]['ID']));
            $patAr = explode('#', $pat[0]);
            foreach($patAr as $row){
                if(!empty($row)){
                    $eskiSinavBirim[] .= $row;
                }
            }
			
			if($dataYet[0]['YENI_MI'] == 1){
				$sqlBirim = "SELECT MB.BIRIM_ID, MB.BIRIM_KODU, MB.BIRIM_ADI FROM M_BIRIM MB
						JOIN M_YETERLILIK_BIRIM MYB ON (MB.BIRIM_ID = MYB.BIRIM_ID)
						WHERE MYB.YETERLILIK_ID = ? AND MB.BIRIM_ID IN (".implode(',', $eskiSinavBirim).")
						ORDER BY MB.BIRIM_KODU";
				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
				$AdayBirims[$BelgeBilgi[0]['ID']] = $birims;
					
			}else{
				$sqlBirim = "SELECT MB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MB.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID,
						MB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO
						FROM M_YETERLILIK_ALT_BIRIM MB
						WHERE MB.YETERLILIK_ID = ? AND MB.YETERLILIK_ALT_BIRIM_ID IN(".implode(',', $eskiSinavBirim).")
						ORDER BY MB.YETERLILIK_ALT_BIRIM_NO ASC";
				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
					
				foreach($birims as $key=>$row){
					$birims[$key]['BIRIM_KODU'] = $dataYet[0]['YETERLILIK_KODU'].'/'.$row['BIRIM_NO'];
				}
			
				$AdayBirims[$BelgeBilgi[0]['ID']] = $birims;
			}
		}
		
		return array('BelgeBilgi'=>$BelgeBilgi,'BasariliBirim'=>$AdayBirims,'Yeterlilik'=>$dataYet[0],'KurBilgi'=>$KurBilgi[0]);
	}
	
	function BelgeDurum($post){
		$db = JFactory::getOracleDBO ();
		if($post['durum'] == 2){
			$sql = "UPDATE M_BELGE_TEKRAR_BASIM SET DURUM = ?, BASIM_TARIHI = TO_DATE(sysdate, 'dd/mm/yyyy') WHERE BASIM_ID=?";
			$db->prep_exec_insert($sql, array($post['durum'],$post['basimId']));
		}
		else if($post['durum'] == 3) {
			$sql = "UPDATE M_BELGE_TEKRAR_BASIM SET DURUM = ?, GONDERIM_TARIHI = TO_DATE(sysdate, 'dd/mm/yyyy'), KARGONO=? WHERE BASIM_ID=?";
			$db->prep_exec_insert($sql, array($post['durum'],$post['kargoNo'],$post['basimId']));
		}
		
		return true;
	}
	
	function getKuruluslar($durum){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT M_KURULUS.*, M_KURULUS_EDIT.KURULUS_ADI as KUR_AD FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
					JOIN M_KURULUS ON KURULUS_ID = M_KURULUS.USER_ID
					LEFT JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
					WHERE MATBAA_DURUM = ? ORDER BY M_KURULUS.KURULUS_ADI ASC";
		
		return $db->prep_exec($sql, array($durum));
	}
	
	function getYeterlilikler($durum){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT YETERLILIK_ADI, YETERLILIK_KODU, REVIZYON, YETERLILIK_ID FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
					JOIN M_YETERLILIK USING(YETERLILIK_ID)
					WHERE MATBAA_DURUM = ? ORDER BY YETERLILIK_ADI ASC";
		
		return $db->prep_exec($sql, array($durum));
	}
	
	function SearchMatbaa($post){
		$db = JFactory::getOracleDBO ();
		
		$kurId = $post['kurId'];
		$yetId = $post['yetId'];
		$durum = $post['durum'];
		
		$sql = "SELECT DISTINCT M_BELGELENDIRME_MATBAA.SINAV_ID, MATBAA_ID,SINAV_TARIHI,ISTEK_TARIHI,BASIM_TARIHI,GONDERIM_TARIHI,KARGONO,YETERLILIK_KODU,YETERLILIK_ADI,REVIZYON,M_KURULUS.KURULUS_ADI,M_KURULUS.KURULUS_ADRESI,M_KURULUS.KURULUS_TELEFON 
				FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
	        		JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_KURULUS ON KURULUS_ID = M_KURULUS.USER_ID
					WHERE MATBAA_DURUM = ? ";
		
		if($kurId != 0){
			$sql .= " AND KURULUS_ID=".$kurId;
		}
		
		if($yetId != 0){
			$sql .= " AND YETERLILIK_ID=".$yetId;
		}
		
		$sql .= " ORDER BY ISTEK_TARIHI ASC";
		
		$data = $db->prep_exec($sql, array($durum));
		
		if($data){
			$adayCount = array();
			foreach ($data as $row){
				$sqlCount = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
				$adayCount[$row['MATBAA_ID']] = $db->prep_exec($sqlCount, array($row['MATBAA_ID']));
			}
			return array(0=>$data,1=>$adayCount);
		}
		else{
			return false;
		}
	}
	
	function takipNoGetir($post){
		$db = JFactory::getOracleDBO ();
		
		$basimId = $post['basimId'];
		$sql = "SELECT KARGONO FROM M_BELGE_TEKRAR_BASIM WHERE BASIM_ID = ?";
		$data = $db->prep_exec($sql, array($basimId));
		
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	function takipNoUpdate($post){
		$db = JFactory::getOracleDBO ();
	
		$basimId = $post['basimId'];
		$kargono = trim($post['kargono']);
		$sql = "UPDATE M_BELGE_TEKRAR_BASIM SET KARGONO = ? WHERE BASIM_ID = ?";
		$data = $db->prep_exec_insert($sql, array($kargono,$basimId));
	
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	function getKurulus(){
		$db = JFactory::getOracleDBO ();
		
		$sql="SELECT * FROM M_KURULUS WHERE KURULUS_DURUM_ID != 1";
		
		return $db->prep_exec($sql, array());
	}
}
?>