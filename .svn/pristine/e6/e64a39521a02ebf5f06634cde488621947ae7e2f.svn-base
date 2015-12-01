<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Yetki_Yeterlilik extends JModel {
    
    function getYetkiYeterlilik($db, $user_id){
    	$kurulussql = "SELECT KURULUS_ADI FROM M_KURULUS
    		              		WHERE USER_ID = ?";
    	$kurulusadi = $db->prep_exec($kurulussql, array($user_id));
    	
    	$yenimisql = "SELECT YETERLILIK_ID,YETERLILIK_ADI, YETERLILIK_KODU, YENI_MI FROM  M_BELGELENDIRME_YET_TALEBI 
				    	JOIN M_YETERLILIK USING(YETERLILIK_ID) 
				    	JOIN M_BASVURU USING(EVRAK_ID)
	              		WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 AND USER_ID = ? ORDER BY YETERLILIK_ID";
    	$yenimi = $db->prep_exec($yenimisql, array($user_id));
    	
    	$birimler = array();
    	$yetki_tarih = array();
    	$sonuc = array();
    	foreach($yenimi as $rows){
    		if($rows['YENI_MI'] == 0){
    			$birimsql = "SELECT DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU,
							   YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, 
							   YETERLILIK_ALT_BIRIM_KODU AS BIRIM_KODU
							   FROM M_YETERLILIK 
			  				   JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
			             	   JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
			             	   JOIN M_DENETIM USING(DENETIM_ID)
			  				   WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
							   AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
    			
    			$birimler[$rows["YETERLILIK_ID"]][] = $db->prep_exec($birimsql, array($rows["YETERLILIK_ID"], $user_id));
    			
    			$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
				            		FROM M_YETERLILIK 
				  				    JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
				             		JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
				             		JOIN M_DENETIM USING(DENETIM_ID)
				  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
				              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
									AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
    			
    			$yetki_tarih[$rows["YETERLILIK_ID"]][] = $db->prep_exec($yetkitarihsql, array($rows["YETERLILIK_ID"], $user_id));
    		}
    		else{
    			$birimsql = "SELECT  DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, BIRIM_ADI, BIRIM_KODU
						    	FROM M_YETERLILIK
				                JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
				                JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
				                JOIN M_DENETIM USING(DENETIM_ID)
			                    WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ?
			                    AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
    			
    			$birimler[$rows["YETERLILIK_ID"]][] = $db->prep_exec($birimsql, array($rows["YETERLILIK_ID"], $user_id));
    			
    			$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
				            		FROM M_YETERLILIK 
				  				     JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
				             		JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
				             		JOIN M_DENETIM USING(DENETIM_ID)
				  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
				              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL 
				              		AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
    			 
    			$yetki_tarih[$rows["YETERLILIK_ID"]][] = $db->prep_exec($yetkitarihsql, array($rows["YETERLILIK_ID"], $user_id));
    		}
    	}//FOREACH BİTİS
    	$sonuc[] = $yenimi;
    	$sonuc[] = $birimler;
    	$sonuc[] = $yetki_tarih;
    	$sonuc[] = $kurulusadi;
    	return $sonuc;
    }

}
?>
