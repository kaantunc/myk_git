<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelTaslak_Listele extends JModel {
	
    function getTaslaklar($db){
		$user = & JFactory::getUser();
    	$userId = $user->getOracleUserId();
    	$isSektorSorumlusu = FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID);
    	
    	if ($isSektorSorumlusu){
    		$sektor	 = FormFactory::getSorumluSektorId ($userId, YET_SEKTOR_TIPI);
    		$sqlPart = "";
    		
    		if (count($sektor) > 0 ){
	    		$sqlPart .= "( ";
	    		
    			for ($i = 0; $i < count($sektor); $i++){
	    			$sqlPart .= " m_yeterlilik.sektor_id = ".$sektor[$i]." OR";
	    		}
	    		
	    		$sqlPart = substr ($sqlPart, 0, strlen($sqlPart)-2).") AND ";
    		}
    		
    		$params = array ();
    	}else{
    		$sqlPart = "USER_ID = ? AND ";
    		$params = array($userId);
    	}
    	
    	/*if ($sqlPart != ""){
			$sql = "SELECT  YETERLILIK_ID,
							YETERLILIK_ADI,
							SEVIYE_ADI,
							TO_CHAR(YETERLILIK_BASLANGIC, 'dd.mm.yyyy')
									AS BASLANGIC_TARIHI_FORMATTED,
							YETERLILIK_SUREC_DURUM_ADI,
							YETERLILIK_SUREC_DURUM_ID,
							SEKTOR_ID,
							SEKTOR_ADI,
							EVRAK_ID  
					FROM M_YETERLILIK
						NATURAL JOIN ".DB_PREFIX.".EVRAK 
						JOIN M_TASLAK_YETERLILIK USING (EVRAK_ID, YETERLILIK_ID) 
						JOIN M_BASVURU USING (EVRAK_ID, USER_ID) 
						JOIN PM_SEVIYE USING (SEVIYE_ID) 
						JOIN PM_SEKTORLER USING(SEKTOR_ID) 
						JOIN PM_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_ID) 
					WHERE ".$sqlPart."  
						  BASVURU_TIP_ID = ".YT2_BASVURU_TIP." AND 
						  BASVURU_SEKLI_ID = ".KAYDEDILMIS_BASVURU_SEKLI_ID." AND 
						  YETERLILIK_SUREC_DURUM_ID NOT IN (".ONAYLANMIS_YETERLILIK.",".PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK.")";
								
			$taslaklar = $db->prep_exec($sql, $params); */
    	
    	if ($sqlPart != ""){
    	
    		$sql = "SELECT DISTINCT m_yeterlilik.YETERLILIK_ID,
				m_yeterlilik.YETERLILIK_ADI,
				m_yeterlilik.YETERLILIK_KODU,
    			m_yeterlilik.SEVIYE_ID,
    			m_yeterlilik.REVIZYON,
	    		SEVIYE_ADI,
	    		YETERLILIK_TESLIM_TARIHI AS BASLANGIC_TARIHI_FORMATTED,
	    		YETERLILIK_SUREC_DURUM_ADI,
	    		YETERLILIK_DURUM_ADI,
	    		m_yeterlilik.YETERLILIK_SUREC_DURUM_ID,
	    		m_yeterlilik.YETERLILIK_DURUM_ID,
	    		m_yeterlilik.SEKTOR_ID,
	    		SEKTOR_ADI,
	    		M_YETERLILIK.YENI_MI
    		FROM m_yeterlilik,
	    		pm_seviye,
	    		pm_yeterlilik_surec_durum,
	    		pm_yeterlilik_durum,
	    		pm_sektorler,
	    		m_yetki_yeterlilik,
	    		m_kurulus_yetki,
	    		m_yetki
    		WHERE m_yeterlilik.YETERLILIK_ID = m_yetki_yeterlilik.YETERLILIK_ID
	    		AND m_yetki_yeterlilik.YETKI_ID = m_kurulus_yetki.YETKI_ID
	    		AND ".$sqlPart."
	    		m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = pm_yeterlilik_surec_durum.YETERLILIK_SUREC_DURUM_ID
	    		AND m_yeterlilik.YETERLILIK_DURUM_ID = pm_yeterlilik_durum.YETERLILIK_DURUM_ID
	    		AND m_yetki_yeterlilik.YETKI_ID = m_yetki.YETKI_ID
	    		AND m_yetki.ETKIN = 1
	    		AND m_yeterlilik.SEKTOR_ID = pm_sektorler.SEKTOR_ID
	    		AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
	    		AND m_yeterlilik.yeterlilik_durum_id IN (".PM_YETERLILIK_DURUMU__TASLAK.")";
	    		
    		$taslaklar = $db->prep_exec($sql, $params);
    	
    	
    	}else{
    		$taslaklar = null;
    	}
    	
		return $taslaklar;
    }
    
    function getVersionDatas($post) {
    	$db = & JFactory::getOracleDBO();
    	$sql = "SELECT  M_TASLAK_YETERLILIK.RESMI_GORUS_ONCESI_PDF,
						M_TASLAK_YETERLILIK.SEKTOR_KOMITESI_ONCESI_PDF,
						M_TASLAK_YETERLILIK.YONETIM_KURULU_ONCESI_PDF,
						M_TASLAK_YETERLILIK.SON_TASLAK_PDF
				   FROM M_TASLAK_YETERLILIK
    			  WHERE YETERLILIK_ID = ?";

    	$datas = $db->prep_exec($sql, array($post['yeterlilikid']));
    	$return['STATUS'] = "1";
    	foreach ($datas[0] as $key => $val){
    		if(strlen($val) > 10){
    			$datas[0][$key] = substr($val, 0,10)."....".substr($val, -3);
    		}else{
    			$datas[0][$key] = $val;
    		}
    	}
    	$return['datas'] = current($datas);
    	return $return;
    }
}
?>
