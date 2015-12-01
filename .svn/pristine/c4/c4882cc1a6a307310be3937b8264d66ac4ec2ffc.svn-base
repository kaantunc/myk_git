<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Teknik_CalismaModelTeknik_Calisma extends JModel {
	function getUzmanHavuzu()
	{
		$db = JFactory::getOracleDBO();
			
		$sql = "SELECT *
		
		FROM M_UZMAN_HAVUZU
		FULL JOIN (SELECT M_UZMAN_CALISMA_SURESI.UZMAN_ID AS USER_ID, SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_GUN
		FROM M_UZMAN_CALISMA_SURESI
		FULL JOIN M_TEKNIK_CALISMA_GRUBU__UZMAN USING (CALISMA_SURESI_ID)
		WHERE GOREVLENDIRILDIGI_MALI_YIL=?
		GROUP BY M_UZMAN_CALISMA_SURESI.UZMAN_ID
		) USING (USER_ID)
			
			
		WHERE DURUM=2";
			
		$uzmanlar=  $db->prep_exec($sql, array(date('Y')));
			
		return $uzmanlar;
	}
	
	function getUzmanHavuzu_VeBuTCGDisindakiCalismaSaatleri ($tcgID){
		$db = JFactory::getOracleDBO();
			
		$sql = "SELECT * 

					FROM M_UZMAN_HAVUZU 
					FULL JOIN (SELECT M_UZMAN_CALISMA_SURESI.UZMAN_ID AS USER_ID, SUM(GOREVLENDIRILDIGI_GUN_SAYISI) AS CALISTIGI_GUN
					                  FROM M_UZMAN_CALISMA_SURESI 
					                  FULL JOIN M_TEKNIK_CALISMA_GRUBU__UZMAN USING (CALISMA_SURESI_ID) 
					                  WHERE (CALISMA_GRUBU_ID IS NULL OR CALISMA_GRUBU_ID != ?)
					                    AND GOREVLENDIRILDIGI_MALI_YIL=?
					                  GROUP BY M_UZMAN_CALISMA_SURESI.UZMAN_ID
					          ) USING (USER_ID)
					
					
					WHERE DURUM=2";
			
		$uzmanlar=  $db->prep_exec($sql, array($tcgID, date('Y')));
			
		return $uzmanlar;
	
	}
	
	function getSeciliTeknikCalismaninUzmanlari($tcgID)
	{
		$db = JFactory::getOracleDBO();
		$sql = 'SELECT * 

				FROM M_TEKNIK_CALISMA_GRUBU__UZMAN 
					FULL JOIN (SELECT M_UZMAN_CALISMA_SURESI.UZMAN_ID, SUM(GOREVLENDIRILDIGI_GUN_SAYISI)
								FROM M_UZMAN_CALISMA_SURESI 
								FULL JOIN M_TEKNIK_CALISMA_GRUBU__UZMAN USING (CALISMA_SURESI_ID) 
								WHERE (CALISMA_GRUBU_ID IS NULL OR CALISMA_GRUBU_ID != ?)
								  AND GOREVLENDIRILDIGI_MALI_YIL=?
								GROUP BY M_UZMAN_CALISMA_SURESI.UZMAN_ID
								) USING (UZMAN_ID)
					JOIN M_UZMAN_HAVUZU ON UZMAN_ID = M_UZMAN_HAVUZU.USER_ID
					JOIN M_UZMAN_CALISMA_SURESI USING (CALISMA_SURESI_ID)
				
				WHERE CALISMA_GRUBU_ID=?
				      AND DURUM=2 ';
		$seciliTeknikCalismaninUzmanlari=  $db->prep_exec($sql, array($tcgID, date('Y'), $tcgID));
		return $seciliTeknikCalismaninUzmanlari;
	}
	
	
	function teknikCalismaGrubuKaydet()
	{
		$grupAdi  = $_POST['teknikCalismaGrubuAdi'];
		$kullaniciAdi = $_POST['teknikCalismaGrubuKullaniciAdi'];
		$yetkili = $_POST['teknikCalismaGrubuYetkiliKisi'];
		$sifre = $_POST['teknikCalismaGrubuSifre'];
		$irtibatNo = $_POST['teknikCalismaGrubuIrtibatNo'];
		$email = $_POST['teknikCalismaGrubuEmaili'];
		
		$db= & JFactory::getDBO();
		$dbo = JFactory::getOracleDBO();
		
		
		$password	= $this->sifreOlustur($sifre);
		$TGUserID 	= $this->generateTGUserID();
		
		$sql="insert into jos_users 
		set tgUserId='".$TGUserID."',
		name='".$grupAdi."',	
		username='".$kullaniciAdi."',	
		email='".$email."', 
		password = '".$password."', 
		block='0',active=1,gid='18', usertype='Registered'";
		
		$sorgu=mysql_query($sql);
		$userid=mysql_insert_id();
	
		
		$sql="insert into jos_core_acl_aro (section_value, value, name) values('users','".$userid."','".$grupAdi."')";
		$sorgu=mysql_query($sql);
		$aroid=mysql_insert_id();
		$sql="insert into jos_core_acl_groups_aro_map (group_id, aro_id) values('18','".$aroid."')";
		$sorgu=mysql_query($sql);
	
		$message="Başarıyla Kaydedildi.";
	
		
		$sql = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (11,10,10, ".$userid.")";;
		$sorgu=mysql_query($sql);
		$sql = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (5,5,5, ".$userid.")";;
		$sorgu=mysql_query($sql);
		$sql = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (2,2,6, ".$userid.")";;
		$sorgu=mysql_query($sql);
		$sql = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (18,17,17, ".$userid.")";;
		$sorgu=mysql_query($sql);
		$sql = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (13,12,12, ".$userid.")";;
		$sorgu=mysql_query($sql);
		$sql = "INSERT INTO jos_community_acl_users(group_id, role_id, function_id, user_id) VALUES (14,13,13, ".$userid.")";;
		$sorgu=mysql_query($sql);
		
		//// JOOMLA TARAFINA EKLENDİ
		
			
		$sql = "INSERT 
		INTO M_KURULUS 
		(USER_ID, KURULUS_ADI, KURULUS_YETKILISI, KURULUS_TELEFON, KURULUS_DURUM_ID, MS_LISTE_ONAY, YET_LISTE_ONAY ) 
		VALUES (?,?,?,?, 6,1,1)";
		$result =  $dbo->prep_exec($sql, array($TGUserID, $grupAdi, $yetkili,$irtibatNo ));
			
		
		$yetkiIDleri = $_POST['sektorSorumlulari'];
		$yetkiIDleri = $_GET['kaydedilecekEkip'];
		
		$ekipCalismaSureleri = $_GET['ekipCalisacakGunleri'];
		$ekipCalismaTarihleri = $_POST['ekipCalismaTarihleri'];
		$ekipCalismaTarihleri_Bitis = $_POST['ekipCalismaTarihleri_Bitis'];
		
		for($i=0; $i<count($yetkiIDleri); $i++)
		{
			
			$calismaSuresiID = $dbo->getNextVal('UZMAN_CALISMA_SURESI_ID_SEQ');
			$sql = "INSERT INTO M_UZMAN_CALISMA_SURESI
			(UZMAN_ID, BASLANGIC_TARIHI, BITIS_TARIHI, GOREVLENDIRILDIGI_GUN_SAYISI, GOREVLENDIRME_ALANI, GOREVLENDIRILDIGI_MALI_YIL, CALISMA_SURESI_ID)
			VALUES (?,TO_DATE(?, 'dd.mm.yyyy'),TO_DATE(?, 'dd.mm.yyyy'),?,?,?,?)";
			$dbo->prep_exec_insert($sql, array(	$yetkiIDleri[$i],
					$ekipCalismaTarihleri[$i],
					$ekipCalismaTarihleri_Bitis[$i],
					str_replace(array("."), array(","), $ekipCalismaSureleri[$i]),
					PM_UZMAN_CALISMA_TIPI__TEKNIK_CALISMA_GRUBU,
					date('Y'),
					$calismaSuresiID ));
				
			
			$sql = "INSERT INTO M_TEKNIK_CALISMA_GRUBU__UZMAN (CALISMA_GRUBU_ID, UZMAN_ID, CALISMA_SURESI_ID) VALUES (?,?,?)";
			$result =  $dbo->prep_exec($sql, array($TGUserID, $yetkiIDleri[$i], $calismaSuresiID));
			
		}
		
		$sql = "INSERT INTO M_TEKNIK_CALISMA_GRUBU (USER_ID) VALUES (?)";
		$result =  $dbo->prep_exec_insert($sql, array($TGUserID));
			
		
		
		return $message;
		
	}
	
	
	function teknikCalismaGrubuUpdateEt()
	{
		$grupAdi  = $_POST['teknikCalismaGrubuAdi'];
		$kullaniciAdi = $_POST['teknikCalismaGrubuKullaniciAdi'];
		$yetkili = $_POST['teknikCalismaGrubuYetkiliKisi'];
		$irtibatNo = $_POST['teknikCalismaGrubuIrtibatNo'];
		$email = $_POST['teknikCalismaGrubuEmaili'];
	
		$db= & JFactory::getDBO();
		$dbo = JFactory::getOracleDBO();
	
		$sifre = $_POST['teknikCalismaGrubuSifre'];

		if($sifre!='')
		{
			$password	= $this->sifreOlustur($sifre);
			$sqlPasswordPart = ", password = '".$password."'";
		}
		$TGUserID 	= $_POST['userIdToUpdate'];
	
		$sql="update jos_users set 
		name='".$grupAdi."',
		username='".$kullaniciAdi."',
		email='".$email."'"
		.$sqlPasswordPart."
		WHERE tgUserId='".$TGUserID."'";
	
		$sorgu=mysql_query($sql);
		
	
		$message="Başarıyla Kaydedildi.";
	
	
		//// JOOMLA TARAFINA EKLENDİ
	
			
		$sql = "UPDATE M_KURULUS
		SET KURULUS_ADI=?, KURULUS_YETKILISI=?, KURULUS_TELEFON=? 
		WHERE USER_ID=?";
		$result =  $dbo->prep_exec($sql, array($grupAdi, $yetkili,$irtibatNo, $TGUserID ));
			
	
		$yetkiIDleri = $_GET['kaydedilecekEkip'];
		$ekipCalismaSureleri = $_GET['ekipCalisacakGunleri'];
		$ekipCalismaTarihleri = $_POST['ekipCalismaTarihleri'];
		$ekipCalismaTarihleri_Bitis = $_POST['ekipCalismaTarihleri_Bitis'];
		
		$sql = "DELETE FROM M_TEKNIK_CALISMA_GRUBU__UZMAN WHERE CALISMA_GRUBU_ID=?";
		$result =  $dbo->prep_exec_insert($sql, array($TGUserID));
		
		$silinecekCalismaSureleriIDleri = $_POST['silinecekCalismaSureleriIDleri'];
		if(count($silinecekCalismaSureleriIDleri)>0)
		{
			$sql = "DELETE FROM M_UZMAN_CALISMA_SURESI WHERE CALISMA_SURESI_ID IN (?)";
			$result =  $dbo->prep_exec_insert($sql, array(implode(',', $silinecekCalismaSureleriIDleri)));
		}
			
		for($i=0; $i<count($yetkiIDleri); $i++)
		{
			
			
			$calismaSuresiID = $dbo->getNextVal('UZMAN_CALISMA_SURESI_ID_SEQ');
			$sql = "INSERT INTO M_UZMAN_CALISMA_SURESI 
				(UZMAN_ID, BASLANGIC_TARIHI, BITIS_TARIHI, GOREVLENDIRILDIGI_GUN_SAYISI, GOREVLENDIRME_ALANI, GOREVLENDIRILDIGI_MALI_YIL, CALISMA_SURESI_ID) 
				VALUES (?,TO_DATE(?, 'dd.mm.yyyy'),TO_DATE(?, 'dd.mm.yyyy'),?,?,?,?)";
				$dbo->prep_exec_insert($sql, array(	$yetkiIDleri[$i], 
													$ekipCalismaTarihleri[$i], 
													$ekipCalismaTarihleri_Bitis[$i], 
													str_replace(array("."), array(","), $ekipCalismaSureleri[$i]), 
													PM_UZMAN_CALISMA_TIPI__TEKNIK_CALISMA_GRUBU, 
													date('Y'), 
													$calismaSuresiID ));
				
			
			$sql = "INSERT INTO M_TEKNIK_CALISMA_GRUBU__UZMAN (CALISMA_GRUBU_ID, UZMAN_ID, CALISMA_SURESI_ID) VALUES (?,?,?)";
			$result =  $dbo->prep_exec($sql, array($TGUserID, $yetkiIDleri[$i], $calismaSuresiID));
			
		}
	
			
	
	
		return $message;
	
	}
	
	function generateTGUserID()
	{
		$dbo = JFactory::getOracleDBO();
    	return $dbo->getNextValDYS("USER_ID_seq");
    	
	}
	
	function sektorSorumlusuEkle ($post) {
		
		 
		
	}
	
	function sifreOlustur($sifre){
		jimport('joomla.mail.helper');
		jimport('joomla.user.helper');
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($sifre, $salt);
		$password	= $crypt.':'.$salt;
		return $password;
	}
	
	function getTeknikCalismaGruplari()
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_TEKNIK_CALISMA_GRUBU JOIN M_KURULUS USING (USER_ID)";
		$result =  $db->prep_exec($sql, array());
		return $result;
	}
}
?>
