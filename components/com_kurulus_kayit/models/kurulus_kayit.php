<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');

class Kurulus_KayitModelKurulus_Kayit extends JModel {

	function kurulusKaydet (){
		
		global $mainframe;
		$db 	= & JFactory::getDBO(); 	  //Mysql
		$dbOrc 	= & JFactory::getOracleDBO(); //Oracle
		$juser 	= & JFactory::getUser(); 	  //Joomla User
		
		$message 	= YETKI_MESAJ;
		
		if ($juser->id == 0 ) { //Giris Yapmamis Kullanici
			$mainframe->redirect("index.php", $message, 'error');	
		}
		
		//$user_id 	= $this->userVerileriEkle ($dbOrc, $juser); 				//TG_USER 		(Oracle)
		//if ($user_id == -1){
		//	$mainframe->redirect("index.php", "Kullanıcı TG_USER Tablosuna eklenemedi", 'error');
		//}
		
		$birim_id 	= $this->birimVerileriEkle ($dbOrc); 						//P_BIRIM 		(Oracle)
		if ($birim_id == -1){
			$mainframe->redirect("index.php", "Kullanıcı Eklenirken Hata Oluştu", 'error');
		}
		
		//$result = $this->personelVerileriEkle($dbOrc, $user_id, $birim_id); 	//P_PERSONEL 	(Oracle)
		//if ($birim_id == -1){
		//	$mainframe->redirect("index.php", "Kullanıcı P_PERSONEL Tablosuna eklenemedi", 'error');
		//}
		
		$user_id = $this->getUserId ($dbOrc, $birim_id);
		
		if ( $user_id != -1){
			
			$resultK = $this->kurulusVerileriEkle	($dbOrc, $user_id); 			//M_KURULUS 				(Oracle)
			$resultB = $this->basvuruTipleriEkle 	($dbOrc, $user_id); 			//PM_USER_BASVURU_TIP		(Oracle)
			$resultI = $this->kurulusIllerEkle 	($dbOrc, $user_id); 			//M_KURULUS_FALIYET_IL		(Oracle)
			$resultT = $this->kurulusLogoEkle 	($dbOrc, $user_id); 			//M_KURULUS		(Oracle)
			$resultU = $this->updateUserId			($db, $juser, $user_id); 		//jos_users 				(Joomla)
			$resultG = $this->updateAclGroup		($db, $juser); 					//jos_community_acl_users 	(Joomla)
		}else{
			$mainframe->redirect("index.php", "Kullanıcı Eklenirken Hata Oluştu", 'error');
		}
		
		$message = "KURULUŞ KAYDINIZ BAŞARIYLA ALINMIŞTIR <br/> 
					TEKRAR GİRİŞ YAPTIĞINIZDA BAŞVURU FORMLARINI DOLDURABİLİRSİNİZ...";
		$type = "notice";
		
		$mainframe->redirect("index.php", $message, $type);
	}
	
	function userVerileriEkle ($dbOrc, $juser){
		$user_id = $dbOrc->getNextVal(USER_SEQ);
		
		//Prepare sql statement
		$sql = "INSERT INTO ".DB_PREFIX.".tg_user 
				(user_id, user_name, email_address, display_name) 
				values( ?, ?, ?, ?)";
		
		$params = array ($user_id,
						 $juser->username, 
						 $juser->email,
						 $juser->name 	//Display Name
						);
	
		if ($dbOrc->prep_exec_insert($sql, $params))	
			return $user_id;
		else
			return -1;
	}

	function kurulusVerileriEkle ($dbOrc, $user_id){
		$ad 		= $_POST['ad'];
		$statu_id	= ($_POST['statu'] == "Seçiniz") ? null : $_POST['statu'];
		$yetkili 	= $_POST['yetkili'];
		$unvan 		= $_POST['unvan'];
		$adres 		= $_POST['adres'];
		$sehir 		= ($_POST["sehir"] == "Seçiniz") ? null : $_POST["sehir"];
		$posta_kodu = $_POST['posta_kodu'];
		$telefon 	= $_POST['telefon'];
		$faks 		= $_POST['faks'];
		$eposta 	= $_POST['eposta'];
		$web 		= $_POST['web'];
		$durum_id	= KURULUS_DURUM_ID;
		
		//Prepare sql statement
		$sql = "INSERT INTO m_kurulus 
				(USER_ID, KURULUS_STATU_ID, KURULUS_ADI, KURULUS_YETKILISI, KURULUS_YETKILI_UNVANI,
				 KURULUS_ADRESI, KURULUS_SEHIR, KURULUS_POSTA_KODU, KURULUS_TELEFON, KURULUS_FAKS, 
				 KURULUS_EPOSTA, KURULUS_WEB, KURULUS_DURUM_ID, MS_LISTE_ONAY, YET_LISTE_ONAY) 
				values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0)";
			         
		$params = array($user_id,
						$statu_id,
						$ad,
						$yetkili,
						$unvan,
						$adres,
						$sehir,
						$posta_kodu,
						$telefon,
						$faks,
						$eposta,
						$web,
						$durum_id);
						
		return $dbOrc->prep_exec_insert($sql, $params);
	}

	function kurulusLogoEkle($dbOrc, $user_id){
		global $mainframe;
	 $type = $_FILES["logo"]["type"];
	 $name = $_FILES["logo"]["name"];
	 $tmp = $_FILES["logo"]["tmp_name"];
	 $size = $_FILES["logo"]["size"];
		if(($type != "image/jpeg" && $type != "image/gif" && $type != "image/png") || $size > 5500000){
					$mainframe->redirect("index.php?option=com_kurulus_kayit", "Gönderdiğiniz dosya(lar)nın boyutu 5 mb dan büyük veya formatı jpg yada gif değil.", 'error');
				}
				else {
	
					if (!file_exists(EK_FOLDER."kurulus_logo/".$user_id."/")){
						mkdir(EK_FOLDER."kurulus_logo/".$user_id."/", 0700,true);
					}
						
						
					$normalFile = FormFactory::formatFilename ($name);
					//$_FILES[$belge[$i]][name][$i]=	EK_FOLDER."akreditasyon_basvuru_ekleri/".$user_id."/".$belge[$setarat[$jj]]."/" . $normalFile;
					$pathh =	EK_FOLDER."kurulus_logo/".$user_id."/".$normalFile;
					move_uploaded_file($tmp, $pathh);
	
				}
	
				$belge_adi = FormFactory::formatFilename($name);
	
				$sql="UPDATE M_KURULUS
							SET LOGO = ?
								WHERE USER_ID = ?";
				$params=array($belge_adi, $user_id);
				return $dbOrc->prep_exec_insert($sql, $params);
			}
	
	function birimVerileriEkle ($dbOrc){
		$ad = $_POST['ad'];
		$birim_id = $dbOrc->getNextVal2(DB_PREFIX.".\"".BIRIM_SEQ."\"");
		
		//Prepare sql statement
		$sql = "INSERT INTO ".DB_PREFIX.".p_birim 
				(birim_id, parent_birim_id, birim_adi, birim_haber_kodu, dis_kurum_mu)  
				values(?, ?, ?, ?, ?)";
			         
		$params = array($birim_id,
						PARENT_BIRIM_ID,
						$ad,
						DIS_HABER_KODU,
						DIS_KURUM_MU
						);	
				
		if ($dbOrc->prep_exec_insert($sql, $params))
			return $birim_id;
		else
			return -1;
	}
	
	function getUserId ($dbOrc, $birim_id){
		//Prepare sql statement
		$sql = "SELECT user_id
				FROM ".DB_PREFIX.".p_personel
					JOIN ".DB_PREFIX.".p_birim USING (birim_id) 
				WHERE birim_id = ?";
			         
		$data = $dbOrc->prep_exec_array($sql, array($birim_id));
		if (isset($data[0]))
			return $data[0];
		else
			return -1;
	}

	function personelVerileriEkle ($dbOrc, $user_id, $birim_id ){
		$durum_id = PERSONEL_DURUM; //P_PERSONEL_DURUM (pasif)
		$yetkili = null;
		
		//Prepare sql statement
		$sql = "INSERT INTO ".DB_PREFIX.".p_personel 
				(user_id, birim_id, personel_durum_id, birim_yetkilisi) 
				values( ?, ?, ?, ?)";
		
		$params = array ($user_id,
						 $birim_id,
						 $durum_id,
						 $yetkili);
		
		return $dbOrc->prep_exec_insert($sql, $params);
	}
	
	function basvuruTipleriEkle ($dbOrc, $user_id){
		//$tip = $_POST['basvuru_tip'];
		$tip = array (1,2,3,4);
		
		for ($i = 0; $i < count ($tip); $i++){
			$tip_id = $tip[$i];
			$this->basvuruTipiEkle ($dbOrc, $user_id, $tip_id); 
		}
	}
	
	function basvuruTipiEkle ($dbOrc, $user_id, $tip_id){
		//Prepare sql statement
		$sql = "INSERT INTO pm_user_basvuru_tip 
				values(?, ?)";
		
		$params = array ($user_id,
						 $tip_id
						);
		
		return $dbOrc->prep_exec_insert($sql, $params);
	}
	
	function kurulusIllerEkle($dbOrc, $user_id){
		$faaliyet_iller = null;
		if (isset($_POST["iller"]))
			$faaliyet_iller = $_POST["iller"];
	
		for ($i = 0; $i < count($faaliyet_iller); $i++){
			$s = $this->kurulusIlEkle($dbOrc, $user_id, $faaliyet_iller[$i]);
		}
	
		return $s;
	}
	
	function kurulusIlEkle($dbOrc, $user_id, $il_id){
		//Prepare sql statement
		$sql = "INSERT INTO m_kurulus_faliyet_il 
				values(?, ?)";
		
		$params = array ($user_id,
						 $il_id);
	
		return $dbOrc->prep_exec_insert($sql, $params);
	}
	
	function updateUserId($db, $juser, $user_id){
		$sql = "UPDATE #__users 
					SET tgUserId = ".$user_id." 
				WHERE id = ".$juser->id;
	
		return $db->Execute ($sql);
	}
	
	function updateAclGroup($db, $juser){
		/*************************************************************************/
		//UPDATE COMMUNITY_ACL GROUP (GENEL KULLANICI)
		$sql = "UPDATE #__community_acl_users 
					SET group_id = 1,  
						role_id = 1, 
						function_id = 1 
				WHERE user_id = ".$juser->id;
	
		return $db->Execute ($sql);
		/*************************************************************************/
	}
	
}

?>