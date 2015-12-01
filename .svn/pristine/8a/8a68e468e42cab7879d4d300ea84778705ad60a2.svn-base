<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

//require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class Meslek_Std_TaslakModelOnayli_Taslak_Listele extends JModel {
	
    function getTaslaklar($db){
		$user = & JFactory::getUser();
    	$userId = $user->getOracleUserId();
    	$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID));
    	
    	if ($isSektorSorumlusu){
        	$sektor	 = FormFactory::getSorumluSektorId ($userId, MS_SEKTOR_TIPI);
        	$sqlFromPart = "";
    		
        	if (count($sektor) > 0 ){
	    		$sqlConditionPart .= "m_meslek_standartlari.sektor_id IN ( ";
	    		
    			for ($i = 0; $i < count($sektor); $i++){
	    			$sqlConditionPart .= $sektor[$i];
	    			
	    			if ($i != count($sektor)-1){
	    				$sqlConditionPart .= ",";
	    			}
	    		}
	    		$sqlConditionPart .= ") ";
    		}
    		
    		$params = array ();
    	}else{
    		$sqlFromPart = " m_kurulus_yetki, ";    	
    		$sqlConditionPart = "m_yetki.YETKI_ID = m_kurulus_yetki.yetki_id AND m_kurulus_yetki.user_id = ?";
    		$params = array($userId);
    	}
    		$sql = "	SELECT  distinct
    						m_meslek_standartlari.standart_id, 
    						m_meslek_standartlari.standart_adi, 
    						sektor_adi, etkin, 
    						STANDART_SUREC_DURUM_ADI, 
    						TO_CHAR(BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI_FORMATTED, 
    						seviye_adi,
    						revizyon
						FROM ".$sqlFromPart." m_meslek_standartlari, 
							 M_YETKI_STANDART, 
							 m_yetki, 
							 PM_SEKTORLER, 
							 PM_MESLEK_STANDART_SUREC_DURUM, 
							 PM_SEVIYE,
							 m_taslak_meslek
						WHERE m_meslek_standartlari.MESLEK_STANDART_SUREC_DURUM_ID = PM_MESLEK_STANDART_SUREC_DURUM.MESLEK_STANDART_SUREC_DURUM_ID
							AND ".$sqlConditionPart." AND m_meslek_standartlari.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID
							AND m_meslek_standartlari.STANDART_ID = M_YETKI_STANDART.STANDART_ID (+)
							AND m_meslek_standartlari.SEKTOR_ID = PM_SEKTORLER.SEKTOR_ID
							AND m_taslak_meslek.standart_id=m_meslek_standartlari.STANDART_ID 
							AND M_YETKI_STANDART.YETKI_ID = m_yetki.YETKI_ID (+)
							AND m_meslek_standartlari.meslek_standart_durum_id = ".PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART."
			    		ORDER BY m_meslek_standartlari.standart_adi,PM_SEVIYE.seviye_adi";
    		
			$taslaklar = $db->prep_exec($sql, $params);
		return $taslaklar;
    }
    
    
    
    function ajaxRevizyonlariGetir()
    {
    	$standartID = $_REQUEST['standart_id'];
    }
}
?>
