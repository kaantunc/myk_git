<?php
defined('_JEXEC') or die('Restricted access');

class Yonetim_KuruluModelYonetim_Kurulu extends JModel {
	
	function getYonetimKurulu(){
		$db  = &JFactory::getOracleDBO();
		$sql= "SELECT 	UYE_ID,
						AD_SOYAD,
						UNVAN,
						KURUM,
						TO_CHAR(ETKINLIK_BASLANGIC_TARIHI, 'dd.mm.yyyy') AS ETKINLIK_BASLANGIC_TARIHI,
						TO_CHAR(ETKINLIK_BITIS_TARIHI, 'dd.mm.yyyy') AS ETKINLIK_BITIS_TARIHI,
						ETKIN,
						ACIKLAMA
			   FROM M_YONETIM_KURULU, PM_YETKI_DURUMU
			   WHERE M_YONETIM_KURULU.ETKIN=PM_YETKI_DURUMU.DURUM_ID
			   ORDER BY UYE_ID";
		return $db->prep_exec($sql, array());
	}
	
	function getUye($uyeID){
		$db  = &JFactory::getOracleDBO();
		$sql= "SELECT 	UYE_ID,
						AD_SOYAD,
						UNVAN,
						KURUM,
						TO_CHAR(ETKINLIK_BASLANGIC_TARIHI, 'dd.mm.yyyy') AS ETKINLIK_BASLANGIC_TARIHI,
						TO_CHAR(ETKINLIK_BITIS_TARIHI, 'dd.mm.yyyy') AS ETKINLIK_BITIS_TARIHI,
						ETKIN,
						ACIKLAMA
				FROM M_YONETIM_KURULU, PM_YETKI_DURUMU
				WHERE M_YONETIM_KURULU.ETKIN=PM_YETKI_DURUMU.DURUM_ID AND M_YONETIM_KURULU.UYE_ID = ?";
		$params=array($uyeID);
		return $db->prep_exec($sql, $params);
	}
	
	function getYonetimKuruluEtkinlikDurumlari()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DURUM_ID, ACIKLAMA
						FROM pm_yetki_durumu";
	
		$params = array ();
		return $db->prep_exec($sql, $params);
	
	}
	
	
}
?>