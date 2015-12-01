<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');

class Uzman_KayitModelUzman_Kayit extends JModel {


	function uzmanKaydet (){
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
		
		$user_id 	= $this->userVerileriEkle ($dbOrc, $juser);
		if($_FILES[cv][size]>10500000){
			$mainframe->redirect("index.php?option=com_uzman_kayit", "Gönderdiğiniz CV'nin boyutu 10 mb dan büyük.", 'error');
		} else {
			
			if (!file_exists(EK_FOLDER."uzman/cv/".$user_id."/")){
				mkdir(EK_FOLDER."uzman/cv/".$user_id, 0700,true);;
			}
			$normalFile = FormFactory::formatFilename ($_FILES[cv][name]);
			$_FILES[cv][name]=	"uzman/cv/".$user_id."/" . $normalFile;		
			move_uploaded_file($_FILES[cv][tmp_name],EK_FOLDER.$_FILES[cv][name]);
						
						
		}
//		exit;
		
		if ( $user_id != -1){
			$resultK = $this->uzmanVerileriEkle	($dbOrc, $user_id, $_FILES[cv][name]); 			//M_UZMAN 				(Oracle)
			$resultU = $this->updateUserId			($db, $juser, $user_id); 		//jos_users 				(Joomla)
			$resultG = $this->updateAclGroup		($db, $juser); 					//jos_community_acl_users 	(Joomla)
		}else{
			$mainframe->redirect("index.php", "Kullanıcı Eklenirken Hata Oluştu", 'error');
		}
		
		
// 		$message = "İLETİŞİM BİLGİLERİNİZ KAYDEDİLMİŞTİR. BAŞVURUNUZU TAMAMLAMAK İÇİN <a href=index.php?option=com_uzman_basvur>TIKLAYINIZ</a>";
//		$type = "notice";
		
		$mainframe->redirect("index.php?option=com_uzman_basvur&layout=basvuru_bilgi", $message, $type);
			}
	
	function userVerileriEkle ($dbOrc, $juser){
		$user_id = $dbOrc->getNextVal(USER_SEQ);
		$fileName	= FormFactory::getNormalFilename($_POST[$ekAd.($updated+$j+1)]);				
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

	function getUzmanValues($user_id){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT *
				FROM M_UZMAN_HAVUZU
				WHERE user_id = ?";
	
		$params = array ($user_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function uzmanVerileriEkle ($dbOrc, $user_id, $cv){
		$tckimlik 		= $_POST['tckimlik'];
		$onek 		= $_POST['onek'];
		$ad 		= $_POST['ad'];
		$soyad 		= $_POST['soyad'];
		$kurum 		= $_POST['kurum'];
		$unvan 		= $_POST['unvan'];
		$kademe		= $_POST['kademe'];
		$derece		= $_POST['derece'];
		$adres 		= $_POST['adres'];
		$sehir 		= ($_POST["sehir"] == "Seçiniz") ? null : $_POST["sehir"];
		$posta_kodu = $_POST['posta_kodu'];
		$telefon 	= $_POST['telefon'];
		$faks 		= $_POST['faks'];
		$eposta 	= $_POST['eposta'];
		$web 		= $_POST['web'];
		$durum 		= 1;
		$alan="#";
		for($i=0;$i<count($_POST[alan]);$i++){
			$alan.=$_POST[alan][$i]."#";
		}
		$sektorler="#";
		for($i=0;$i<count($_POST[sektorler]);$i++){
			$sektorler.=$_POST[sektorler][$i]."#";
		}
		
		//Prepare sql statement
		$sql = "INSERT INTO M_UZMAN_HAVUZU 
				(USER_ID, TC_KIMLIK,ONEK, AD, SOYAD, KURUM, 
				 KURUM_UNVANI, KADEME, DERECE, ADRES, IL, POSTAKODU, TEL,  
				 FAX, EPOSTA, WEB, CV_PATH, DURUM, TARIH) 
				values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,".time().")";
			         
		$params = array($user_id,
						$tckimlik,
						$onek,
						$ad,
						$soyad,
						$kurum,
						$unvan,
						$kademe,
						$derece,
						$adres,
						$sehir,
						$posta_kodu,
						$telefon,
						$faks,
						$eposta,
						$web,
						$cv,
						$durum);
		return $dbOrc->prep_exec_insert($sql, $params);
	}


	
	function updateUserId($db, $juser, $user_id){
		$sql = "UPDATE #__users 
					SET tgUserId = ".$user_id.",active=3 
				WHERE id = ".$juser->id;
	
		return $db->Execute ($sql);
	}
	
	function updateAclGroup($db, $juser){
		/*************************************************************************/
		//UPDATE COMMUNITY_ACL GROUP (GENEL KULLANICI)
		$sql = "UPDATE #__community_acl_users 
					SET group_id = 21,  
						role_id = 20 
				WHERE user_id = ".$juser->id;
	
		return $db->Execute ($sql);
		/*************************************************************************/
	}
	
	function getBasvuru_alanlari(){
		$db = JFactory::getOracleDBO();		
		$sql = "SELECT  *
		FROM PM_UZMAN_HAVUZU_ALANLAR
		ORDER BY ALAN_NO";
			
		return $db->prep_exec($sql, array());
		
	}
	
	function getDeneyim_tipleri(){
		$db = JFactory::getOracleDBO();		
		$sql = "SELECT  *
		FROM PM_UZMAN_HAVUZU_DENEYIM_TIP
		ORDER BY DENEYIM_NO";
			
		return $db->prep_exec($sql, array());
		
	}
	
}

?>