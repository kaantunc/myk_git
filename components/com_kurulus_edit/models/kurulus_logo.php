<?php
defined('_JEXEC') or die('Restricted access');

class Kurulus_EditModelKurulus_Logo extends JModel {
	function Kuruluslar(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU
					FROM M_KURULUS
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) 
					  ORDER BY KURULUS_ADI ASC";
		
		return $db->prep_exec($sql, array());
	}
	
	function KurulusGetir($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU, M_BELGELENDIRME_KURULUS_SABLON.*
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
						JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU, M_BELGELENDIRME_KURULUS_SABLON.*
					FROM M_KURULUS
					JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  ";
		
		
// 		$sql = "SELECT * FROM M_KURULUS 
// 					JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
// 					WHERE USER_ID = ?";
		
		$data = $db->prep_exec($sql, array($post['kurulusId'],$post['kurulusId']));
		if($data){
			return $data[0];
		}
		else{
			$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ? 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU
					FROM M_KURULUS
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ? 
					 ";
		
			$data = $db->prep_exec($sql, array($post['kurulusId'],$post['kurulusId']));
			return $data[0];
		}
	}
	
	function kurulusLogoUpdate($post,$files){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$kurId = $post['kurulusId'];
		$ybKod = $post['ybKod'];
		$turkKod = $post['turkKod'];
		
		$sqlSablon = "SELECT * FROM M_BELGELENDIRME_KURULUS_SABLON WHERE KURULUS_ID = ?";
		$sablon = $db->prep_exec($sqlSablon, array($kurId));
		if(!$sablon){
			$sqlEkleSablon = "INSERT INTO M_BELGELENDIRME_KURULUS_SABLON (KURULUS_ID) VALUES(?)";
			$db->prep_exec_insert($sqlEkleSablon, array($kurId));
		}
		
		if(!empty($ybKod)){
			$sqlYbKod = "UPDATE M_KURULUS SET KURULUS_YETKILENDIRME_NUMARASI = ? WHERE USER_ID=?";
			$db->prep_exec_insert($sqlYbKod, array($ybKod,$kurId));
		}else{
			return "Yetkilendirme Kodu girilmeden diğer işlemlere devam edilemez.";
		}
		
		if(!empty($turkKod)){
			$sqlTurk = "UPDATE M_BELGELENDIRME_KURULUS_SABLON SET AKREDITASYON_NO = ?, DUZENLEYEN_ID = ? WHERE KURULUS_ID=?";
			$db->prep_exec_insert($sqlTurk, array($turkKod,$user_id,$kurId));
		}
		
		
		if(!empty($ybKod)){
			$kurLogo = $files['kurLogo'];
			if($kurLogo['size']>0){
				if($kurLogo['error'] == 0 && ($kurLogo['type'] == 'image/jpeg' || $kurLogo['type'] == 'image/png')){
					$name = explode('.', $kurLogo['name']);
					$type = $name[count($name)-1];
					$name = $ybKod.'.'.$type;
					$directory = EK_FOLDER.'kurulus_logo/'.$kurId;
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					
					if(move_uploaded_file($kurLogo['tmp_name'], $directory.'/'.$name)){
						$sqlLogo = "UPDATE M_KURULUS SET LOGO = ? WHERE USER_ID=?";
						$sqlLogoEdit = "UPDATE M_KURULUS_EDIT SET LOGO = ? WHERE USER_ID=? AND AKTIF = 1";
						$db->prep_exec_insert($sqlLogo, array($name,$kurId));
						$db->prep_exec_insert($sqlLogoEdit, array($name,$kurId));
					}
				}else{
					return "Eklemek istediğiniz Kuruluş Logosu formatı 'jpeg' veya 'png' olmalıdır.";
				}
			}
			
			$mykMarka = $files['mykMarka'];
			if($mykMarka['size']>0){
				if($mykMarka['error'] == 0 && $mykMarka['type'] == 'image/jpeg'){
					$name = explode('.', $mykMarka['name']);
					$type = $name[count($name)-1];
					$name = $ybKod.'-m.'.$type;
					if(move_uploaded_file($mykMarka['tmp_name'], EK_FOLDER.'logolar/'.$name)){
						$sqlLogo = "UPDATE M_BELGELENDIRME_KURULUS_SABLON SET MYK_MARKASI = ?, DUZENLEYEN_ID=? WHERE KURULUS_ID=?";
						$db->prep_exec_insert($sqlLogo, array($name,$user_id,$kurId));
					}
				}else{
					return "Eklemek istediğiniz MYK Markası formatı 'jpeg' olmalıdır.";
				}
			}
			
			if(!empty($turkKod)){
				$turkMarka = $files['turkMarka'];
				if($turkMarka['size']>0){
					if($turkMarka['error'] == 0 && $turkMarka['type'] == 'image/jpeg'){
						$name = explode('.', $turkMarka['name']);
						$type = $name[count($name)-1];
						$name = $turkKod.'.'.$type;
						if(move_uploaded_file($turkMarka['tmp_name'], EK_FOLDER.'logolar/'.$name)){
							$sqlLogo = "UPDATE M_BELGELENDIRME_KURULUS_SABLON SET TURKAK_MARKASI = ?, DUZENLEYEN_ID=? WHERE KURULUS_ID=?";
							$db->prep_exec_insert($sqlLogo, array($name,$user_id,$kurId));
						}
					}else{
						return "Eklemek istediğiniz TÜRKAK Markası formatı 'jpeg' olmalıdır.";
					}
				}
			}
			
			$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU, M_BELGELENDIRME_KURULUS_SABLON.*
				FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
						JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKODU, M_BELGELENDIRME_KURULUS_SABLON.*
					FROM M_KURULUS
					JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  ";
			$data = $db->prep_exec($sql, array($kurId,$kurId));
			if(!empty($data[0]['LOGO'])){
				$logo = explode('.',$data[0]['LOGO']);
				rename(EK_FOLDER.'kurulus_logo/'.$kurId.'/'.$data[0]['LOGO'],EK_FOLDER.'kurulus_logo/'.$kurId.'/'.$ybKod.'.'.$logo[count($logo)-1]);
				$sqlLogo = "UPDATE M_KURULUS SET LOGO = ? WHERE USER_ID=?";
				$db->prep_exec_insert($sqlLogo, array($ybKod.'.'.$logo[count($logo)-1],$kurId));
				$sqlLogoEdit = "UPDATE M_KURULUS_EDIT SET LOGO = ? WHERE USER_ID=? AND AKTIF = 1";
				$db->prep_exec_insert($sqlLogo, array($ybKod.'.'.$logo[count($logo)-1],$kurId));
			}
			
			if(!empty($data[0]['MYK_MARKASI'])){
				$myk = explode('.', $data[0]['MYK_MARKASI']);
				rename(EK_FOLDER.'logolar/'.$data[0]['MYK_MARKASI'],EK_FOLDER.'logolar/'.$ybKod.'-m.'.$myk[count($myk)-1]);
				$sqlLogo = "UPDATE M_BELGELENDIRME_KURULUS_SABLON SET MYK_MARKASI = ?, DUZENLEYEN_ID=? WHERE KURULUS_ID=?";
				$db->prep_exec_insert($sqlLogo, array($ybKod.'-m.'.$myk[count($myk)-1],$user_id,$kurId));
			}
			
			if(!empty($data[0]['TURKAK_MARKASI']) && !empty($turkKod)){
				$turk = explode('.', $data[0]['TURKAK_MARKASI']);
				rename(EK_FOLDER.'logolar/'.$data[0]['TURKAK_MARKASI'],EK_FOLDER.'logolar/'.$turkKod.'.'.$turk[count($turk)-1]);
				$sqlLogo = "UPDATE M_BELGELENDIRME_KURULUS_SABLON SET TURKAK_MARKASI = ?, DUZENLEYEN_ID=? WHERE KURULUS_ID=?";
				$db->prep_exec_insert($sqlLogo, array($turkKod.'.'.$turk[count($turk)-1],$user_id,$kurId));
			}
			
			return 'Başarıyla güncellenmiştir.';
		}
	}
}