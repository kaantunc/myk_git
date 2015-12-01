<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSinav_Sec extends JModel {
    
    function getSinavlar($db, $userId){
    	
    	if(!$userId)
    		$userId = JFactory::getUser()->getOracleUserId();
    	
    	$sql = "SELECT  USER_ID,M_SINAV_ID,
    					TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI,
    					TOPLAM_ADAY,
              YETERLILIK_ID,
    					YETERLILIK_ADI,
    					MERKEZ_ADI,
    					SEVIYE_ADI,
              SINAV_BIRIMLERI,
    					BASARILI_ADAY,
    					SINAV_SAAT
    						FROM M_SINAV
    						JOIN M_YETERLILIK USING (YETERLILIK_ID)
    						JOIN M_SINAV_MERKEZI USING (MERKEZ_ID)
    						JOIN PM_SEVIYE USING (SEVIYE_ID)
    			WHERE 	USER_ID = ?
    			ORDER BY SINAV_TARIHI ASC";
    	$butunSinav = array();
    	//YENİ YETERLILIKLER ICIN
    	/*$sqlYeni = "SELECT M_SINAV.USER_ID,
		        M_SINAV_ID,
		        M_SINAV.YETERLILIK_ID,
		        TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI,
		        MERKEZ_ADI,
		        SINAV_BIRIMLERI,
		        YETERLILIK_ADI,
		        SEVIYE_ADI,
		        ALT_BIRIM_ID,
		        BIRIM_ADI,
		        BIRIM_KODU,
		        OLC_DEG_HARF, 
		        OLC_DEG_NUMARA,
		        TOPLAM_ADAY,
		        BASARILI_ADAY
		        FROM M_SINAV
		        JOIN M_SINAV_TAKVIMI ON M_SINAV.SINAV_TARIHI = M_SINAV_TAKVIMI.TAKVIM_SINAV_TARIHI AND M_SINAV.MERKEZ_ID = M_SINAV_TAKVIMI.MERKEZ_ID
		        JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
		        JOIN M_BIRIM_OLCME_DEGERLENDIRME ON M_SINAV_TAKVIMI.ALT_BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.ID
		        JOIN M_YETERLILIK_BIRIM USING(BIRIM_ID)
		        JOIN M_BIRIM USING(BIRIM_ID)
		        JOIN M_SINAV_MERKEZI ON M_SINAV.MERKEZ_ID = M_SINAV_MERKEZI.MERKEZ_ID
		        JOIN PM_SEVIYE USING (SEVIYE_ID)
		        WHERE M_SINAV.USER_ID = ?
		        ORDER BY SINAV_TARIHI ASC";
		$sinavlar = $db->prep_exec($sqlYeni,array($userId));
		
		$sqlEski = " SELECT M_SINAV.USER_ID,
					        M_SINAV_ID,
					        M_SINAV.YETERLILIK_ID,
					        TO_CHAR(SINAV_TARIHI, 'dd.mm.yyyy') AS SINAV_TARIHI,
					        MERKEZ_ADI,
					        SINAV_BIRIMLERI,
					        YETERLILIK_ADI,
					        SEVIYE_ADI,
					        ALT_BIRIM_ID,
				            YETERLILIK_ALT_BIRIM_ADI,
				            SEKIL,
					        TOPLAM_ADAY,
					        BASARILI_ADAY
    						FROM M_SINAV
                JOIN M_SINAV_TAKVIMI ON M_SINAV.SINAV_TARIHI = M_SINAV_TAKVIMI.TAKVIM_SINAV_TARIHI AND M_SINAV.MERKEZ_ID = M_SINAV_TAKVIMI.MERKEZ_ID
    						JOIN M_YETERLILIK ON M_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
                JOIN M_YETERLILIK_ALT_BIRIM ON M_SINAV.YETERLILIK_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID AND M_SINAV_TAKVIMI.ALT_BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
    						JOIN M_SINAV_MERKEZI ON M_SINAV.MERKEZ_ID = M_SINAV_MERKEZI.MERKEZ_ID
    						JOIN PM_SEVIYE USING (SEVIYE_ID)
				WHERE M_SINAV.USER_ID = ?
		        ORDER BY SINAV_TARIHI ASC";
		*/
		$sinavlar = $db->prep_exec($sql,array($userId));
		return $sinavlar;
		//YENİ YETERLILIKLER ICIN SON
    }
    
    function getSinavSecBirimler($db, $postData){
    	$anabirimler = array();
   	 	$sekiller = array();
    	if(isset($postData['yetId'])){
    		$yetId = $postData['yetId'];
    		$birimler = isset($postData['altbirim']) ? $postData['altbirim'] : "";
    	}
    	else
    	return "";
    	$altbirimler = explode(' ', $birimler);
    	foreach($altbirimler as $rows){
    		$arabirim = explode('_', $rows);
    		array_push($anabirimler, $arabirim[0]);
    		array_push($sekiller, $arabirim[1]);
    	}
    	
    		$sql ="SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    		$params = array($yetId);
    		$yenimi = $db->prep_exec($sql, $params);
    
    		if($yenimi[0]['YENI_MI'] == 0)
    		{
    			foreach($anabirimler as $row){
    			$sql = "SELECT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO
    				   FROM M_YETERLILIK_ALT_BIRIM  
      				   WHERE YETERLILIK_ALT_BIRIM_ID = ? ORDER BY YETERLILIK_ALT_BIRIM_NO";
    
    			$params = array($row);
    			$kapsamlar['kapsamlar'][] = $db->prep_exec($sql, $params);
    
    			}
    		}
    		else if($yenimi[0]['YENI_MI'] == 1)
    		{
    			foreach($anabirimler as $row){
    			$sql = "SELECT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, OLC_DEG_HARF, OLC_DEG_NUMARA
    				    FROM M_YETERLILIK_BIRIM 
    				        JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) 
    				        JOIN M_BIRIM USING(BIRIM_ID)
    				        WHERE ID = ?
    				        ORDER BY ID, OLC_DEG_NUMARA";
    
    
    			$params = array($row);
    			$kapsamlar['kapsamlar'][] = $db->prep_exec($sql, $params);
    
    			}
    		}
    	$kapsamlar['sekiller'] = $sekiller;
    	if(count($kapsamlar) > 0){
    		$x=10;
    		ajax_success_response_with_array('Sorgu basarili', $kapsamlar);
    
    	}
    	else{
    		$y =20;
    		ajax_error_response('KayÄ±t bulunamadÄ±-'.$sql);
    	}
    }
    
    

}
?>
