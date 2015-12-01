<?php
defined('_JEXEC') or die('Restricted access');

class Kurulus_EditModelKurulus_Edit extends JModel {
	
	var $pagesM 		= array ("kurulus_bilgi"); 
	var $pageNamesM 	= array ("Kuruluş İletişim Bilgisi");

	var $pagesY 		= array ("kurulus_bilgi" );
	var $pageNamesY 	= array ("Kuruluş İletişim Bilgisi"); //standart ve yeterlilik düzenleme protokolden yapıldığı için düzenleme sayfaları buradan kaldırıldı.
/*	
	var $pagesM 		= array ("kurulus_bilgi", "meslek_std_liste"); 
	var $pageNamesM 	= array ("Kuruluş İletişim Bilgisi","Meslek Standardı Listesi" );

	var $pagesY 		= array ("kurulus_bilgi" , "yeterlilik_liste" );
	var $pageNamesY 	= array ("Kuruluş İletişim Bilgisi", "Yeterlilik Listesi"); */
	
	var $pagesB 		= array ("kurulus_bilgi");
	var $pageNamesB 	= array ("Kuruluş İletişim Bilgisi");
	
	var $pagesA 		= array ("kurulus_bilgi");
	var $pageNamesA 	= array ("Kuruluş İletişim Bilgisi");
	
	function getPageTree ($activeLayout, $tur, $id){
		if ($tur == 1){
			$pages 		= $this->pagesM;
			$pageNames 	= $this->pageNamesM;
		}else if ($tur == 2){
			$pages 		= $this->pagesY;
			$pageNames 	= $this->pageNamesY;
		}
		else if($tur == 3){
			$pages 		= $this->pagesB;
			$pageNames 	= $this->pageNamesB;
		}
		else if($tur == 4){
			$pages 		= $this->pagesA;
			$pageNames 	= $this->pageNamesA;
		}
		
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';
		$sayfa = count ($pages);
		
		$tree = '<div class="form_item" style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			$input = '<input type="button" onClick="goToPage(\''.$pages[$i].'\',\''.$tur.'\',\''.$id.'\')" class="btn" id="page'.$i.'" value="'.$pageNames[$i].'" ';
			if ($activeLayout == $pages[$i])
				$tree .= $input.$activeStyle.' />';
			else
				$tree .= $input.$style.' />'; 
		}
		
		$tree .= '<br></div></div>';
		
		return $tree;
	}

	function getKuruluslar ($kurulus_turu){
		$db = JFactory::getOracleDBO ();
		
		if ($kurulus_turu == 1){ // Meslek Standardi Hazirlayan
			$sqlWhere = "KURULUS_DURUM_ID IN (".MESLEK_STD_KURULUS_DURUM_IDS.")"; 
		}else if ($kurulus_turu == 2){// Yeterlilik Hazirlayan
			$sqlWhere = "KURULUS_DURUM_ID IN (".YETERLILIK_KURULUS_DURUM_IDS.")";
		}else if($kurulus_turu == 3){// Sinav ve Belgelendirme Hazirlayan
			$sqlWhere = "KURULUS_DURUM_ID IN (".SINAV_BELGELENDIRME_KURULUS_DURUM_IDS.")";
		}else if($kurulus_turu == 4){// Akreditasyon Hazirlayan
			$sqlWhere = "KURULUS_DURUM_ID IN (".AKREDITASYON_KURULUS_DURUM_IDS.")";
		}
		
		$sql = "SELECT * 
		        FROM M_KURULUS 
		        	JOIN PM_KURULUS_DURUM USING (KURULUS_DURUM_ID) 
			    WHERE ".$sqlWhere." ORDER BY KURULUS_ADI ASC";
	
		return $db->prep_exec($sql, array());
	}
	
	function getMeslekValues ($user_id){	
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DISTINCT 
						seviye_id, 
						seviye_adi,
						sektor_id, 
						sektor_adi, 
						standart_id, 
						standart_adi,
						standart_tanimi, 
						yasal_duzenleme, 
						mevcut_calisma, 
						TO_CHAR (baslangic_tarihi, 'dd.mm.yyyy') as baslangic_tarihi, 
						TO_CHAR (bitis_tarihi, 'dd.mm.yyyy') as bitis_tarihi 
				FROM m_meslek_standartlari  
					NATURAL JOIN m_basvuru 
					JOIN m_meslek_stan_evrak USING (standart_id, evrak_id)  
					JOIN pm_seviye USING (seviye_id)  
					JOIN pm_sektorler USING (sektor_id)  
				WHERE user_id = ? AND 
					  basvuru_durum_id = ".ONAYLANMIS_BASVURU." AND 
					  MESLEK_STANDART_SUREC_DURUM_ID NOT IN (".PROTOKOL_LISTE_REDDEDILMIS_STANDART.")  
				ORDER BY standart_adi, seviye_id";
		
		$params = array ($user_id);
		return $db->prep_exec($sql, $params);
	}
	
	function getYeterlilikValues ($user_id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DISTINCT
						YETERLILIK_ID,
						STANDART_ID,
						SEVIYE_ID,
						SEKTOR_ID,
						YETERLILIK_SUREC_DURUM_ID,
						YETERLILIK_ADI,
						YETERLILIK_KODU,
						YETERLILIK_YASAL,
						YETERLILIK_BASLANGIC as YETERLILIK_BASLANGIC,
						YETERLILIK_BITIS as YETERLILIK_BITIS 
				FROM m_yeterlilik 
					NATURAL JOIN m_basvuru 
					JOIN m_yeterlilik_evrak USING (yeterlilik_id, evrak_id)  
					JOIN m_standart_yeterlilik USING (yeterlilik_id) 
				WHERE user_id = ?  AND 
					  basvuru_durum_id = ".ONAYLANMIS_BASVURU." AND 
					  YETERLILIK_SUREC_DURUM_id NOT IN ( ".PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK.") 
				ORDER BY YETERLILIK_ADI, SEVIYE_ID";
		
		$params = array ($user_id);
		return $db->prep_exec($sql, $params);
	}
	
	function isTaslak ($id){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT COUNT(*) 
				FROM m_taslak_meslek  
				WHERE standart_id = ?";
		
		$params = array ($id);
		$result = $db->prep_exec_array($sql, $params);
		
		return ($result[0]>0);
	}
	
}