<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_BasvurModelYeterlilik_Basvur extends JModel {

	var $title 	  = "Yeterlilik Başvuru Formu"; 
	var $pages 	  = array ("kurulus_bilgi","irtibat","faaliyet","kapsam","ek", "basvuru_dokumani");
	var $pageNames= array ("Kuruluş Bilgileri","İrtibat Bilgileri", "Faaliyet Bilgileri","Yeterlilik Kapsamı", "Kişi Bilgi Eki", "Başvuru Dökümanı");
	
	function getYeterlilikValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql =  "SELECT YETERLILIK_ID,
						SEVIYE_ID,
						SEKTOR_ID,
						YETERLILIK_SUREC_DURUM_ID,
						YETERLILIK_ADI,
						YETERLILIK_KODU,
						YETERLILIK_YASAL,
						KAYNAK_TESKIL_EDENLER,
						YETERLILIK_BASLANGIC,
						YETERLILIK_BITIS
				FROM m_yeterlilik 
					JOIN m_yeterlilik_evrak USING (yeterlilik_id)  
					 
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	function getYeterlilikPdfValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	KAYNAK_TESKIL_EDENLER,
						SEVIYE_ADI,
						SEKTOR_ADI,
						YETERLILIK_ADI,
						YETERLILIK_KODU,
						YETERLILIK_YASAL,
						YETERLILIK_BASLANGIC,
						YETERLILIK_BITIS
				FROM m_yeterlilik 
			        JOIN pm_seviye USING (seviye_id) 
			        JOIN pm_sektorler USING (sektor_id) 
			        JOIN m_yeterlilik_evrak USING (yeterlilik_id)  
				WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getAkreditasyonValues ($evrak_id){
		$db  = &JFactory::getOracleDBO();
		
		$sql = " SELECT AKREDITASYON_ID,
						AKREDITASYON_ADI,
						AKREDITASYON_PATH,
						AKREDITASYON_ACIKLAMA,
						AKREDITASYON_SEVIYE,
						AKREDITASYON_STANDARDI,
						TO_CHAR (AKREDITASYON_BASLANGIC , 'dd.mm.yyyy') as AKREDITASYON_BASLANGIC,
						TO_CHAR (AKREDITASYON_BITIS , 'dd.mm.yyyy') as AKREDITASYON_BITIS,
						TO_CHAR (AKREDITASYON_DENETIM , 'dd.mm.yyyy') as AKREDITASYON_DENETIM,
						TO_CHAR (AKREDITASYON_KAPSAM , 'dd.mm.yyyy') as AKREDITASYON_KAPSAM
				 FROM m_akreditasyon 
				 WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getBelgeBasvurular($userId){
		$db = &JFactory::getOracleDBO();
	
		$sql = "SELECT 	M_BASVURU.EVRAK_ID, M_BASVURU.USER_ID, TO_CHAR(BASVURU_TARIHI,'dd/mm/yyyy') as BASVURU_TARIHI,M_BASVURU.BASVURU_TIP_ID,BASVURU_DURUM_ADI AS DURUM,BASVURU_DURUM_ID AS DURUM_ID
				FROM M_BASVURU
        JOIN PM_BASVURU_DURUM USING(BASVURU_DURUM_ID)
		        WHERE M_BASVURU.BASVURU_TIP_ID = 2
		        AND M_BASVURU.USER_ID = ?";
	
		return $db->prep_exec($sql, array($userId));
	}
	
	function getBasvuruDurumu($evrak_id){
		$db = &JFactory::getOracleDBO();
	
		$sql = "SELECT 	M_BASVURU.EVRAK_ID, M_BASVURU.USER_ID, TO_CHAR(BASVURU_TARIHI,'dd/mm/yyyy') as BASVURU_TARIHI,M_BASVURU.BASVURU_TIP_ID,BASVURU_DURUM_ADI AS DURUM,BASVURU_DURUM_ID AS DURUM_ID
				FROM M_BASVURU
        JOIN PM_BASVURU_DURUM USING(BASVURU_DURUM_ID)
		        WHERE M_BASVURU.BASVURU_TIP_ID = 2
		        AND M_BASVURU.EVRAK_ID = ?";
	
		return $db->prep_exec($sql, array($evrak_id));
	}
	
	function ajaxBasvuruSil($post){
		$db = &JFactory::getOracleDBO();
	
		$sql="DELETE FROM M_BASVURU WHERE EVRAK_ID=?";
	
		return $db->prep_exec($sql, $post['evrakId']);
	}
	
	function getBasvuruDurumlari(){
		$_db = & JFactory::getOracleDBO();
		$sql = "SELECT BASVURU_DURUM_ID,BASVURU_DURUM_ADI FROM PM_BASVURU_DURUM";
		$data = $_db->prep_exec($sql,array());
		return $data;
	}
}
?>
