<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Sonucu_Gir extends JModel {
    
    function getOgrListe($db, $data){
    	
    	$sinavId = $data['sinavId'];  
    			
		//if(!evrakSahibiMi($evrakId))
			//return -1;
//    	
//    	echo '******<pre>';
//    	print_r($evrakId);
//    	echo '</pre>******';
    	
    	$sql = "SELECT * FROM M_OGRENCI_SINAV
    			NATURAL JOIN M_OGRENCI
			WHERE M_SINAV_ID = ?";
							
		$params = array($sinavId);
		$ogrenciler = $db->prep_exec($sql, $params);

		return $ogrenciler;
    }
    
    function getSinavDurumlariCombo($db){
    	
    	$sinavDurumSql = "SELECT * FROM PM_SINAV_DURUM";
		$sinavDurumlari = $db->loadList($sinavDurumSql);
		
		$comboText = '';
	    foreach($sinavDurumlari AS $sinavDurumu){
	
			if($sinavDurumu['SINAV_DURUM_ID'] !=0)// tan�mlanmad� y� alma
			$comboText .= '<option value="' . $sinavDurumu['SINAV_DURUM_ID'] . '">'.$sinavDurumu['SINAV_DURUM_ADI'].'</option>';
	
		}
    	
		return $comboText;
    }
    
    function getSinavSekli($db, $getData){
    	
    	$sinavId = $getData['sinavId'];    	
    			
		//if(!evrakSahibiMi($evrakId))
			//return -1;
    	
    	$sinavSekliSql = "SELECT SINAV_SEKLI_ID FROM M_SINAV
    			WHERE M_SINAV_ID = ?";
    	
    	$sinavSekli = $db->prep_exec($sinavSekliSql, array($sinavId));
    	
    	if(isset($sinavSekli[0]['SINAV_SEKLI_ID']))
			return $sinavSekli[0]['SINAV_SEKLI_ID'];
    	return -2;
    }
    
    function getSinavTuru($db, $getData){
    	
    	$sinavId = $getData['sinavId'];    	
    	    	    			
		//if(!evrakSahibiMi($evrakId))
			//return -1;
    	
    	$sinavSekliSql = "SELECT SINAV_TUR_ID FROM M_SINAV
    			WHERE M_SINAV_ID = ?";
    	
    	$sinavSekli = $db->prep_exec($sinavSekliSql, array($sinavId));
    	
    	if(isset($sinavSekli[0]['SINAV_TUR_ID']))
			return $sinavSekli[0]['SINAV_TUR_ID'];
    	return -2;
    }

}
?>
