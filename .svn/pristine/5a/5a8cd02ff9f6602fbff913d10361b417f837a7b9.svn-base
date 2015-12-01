<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelTaslak_Adayi_Listele extends JModel {
	
	/*function getTaslakAday (){
		$_db  = &JFactory::getOracleDBO();
		$user = &JFactory::getUser();
		$userId = $user->getOracleUserId();
		$sektor	 = FormFactory::getSorumluSektorId ($userId, YET_SEKTOR_TIPI);
		
		$sektorPart = "";
    	if (count($sektor) > 0 ){
    		$sektorPart .= "AND ( ";
    		
    		for ($i = 0; $i < count($sektor); $i++){
    			$sektorPart .= " sektor_id = ".$sektor[$i]." OR";
    		}
    		
    		$sektorPart = substr ($sektorPart, 0, strlen($sektorPart)-2).") ";
    		
    		$sql= " SELECT 	YETERLILIK_ID,
							YETERLILIK_ADI,
							SEVIYE_ADI  
					FROM ".DB_PREFIX.".evrak 
						JOIN m_taslak_yeterlilik USING (evrak_id)
						JOIN m_yeterlilik USING (yeterlilik_id) 
						JOIN pm_seviye USING (seviye_id) 
					WHERE sayi_id = ".YT2_SAYI_ID." AND 
						  basvuru_sekli_id = ".ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID.$sektorPart." 
						  AND YETERLILIK_SUREC_DURUM_id NOT IN (".PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK.")
					ORDER BY yeterlilik_id";
			
			$params = array ();
			$data = $_db->prep_exec($sql, $params);
    	}else{
    		$data = null;
    	}
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
		*/
	
	function getTaslakAday (){
		$_db  = &JFactory::getOracleDBO();
		$db  = &JFactory::getOracleDBO();
		$user = &JFactory::getUser();
		$userId = $user->getOracleUserId();
		$sektor	 = FormFactory::getSorumluSektorId ($userId, YET_SEKTOR_TIPI);
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID));
			
		if ($isSektorSorumlusu){
			$onTaslakDurumlariPart = "m_yeterlilik.YETERLILIK_DURUM_ID IN (".PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK.",".PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK.")";
				
			$sektor	 = FormFactory::getSorumluSektorId ($userId, YET_SEKTOR_TIPI);
			$sqlPart = "";
	
			if (count($sektor) > 0){
				$sqlPart .= "m_yeterlilik.sektor_id IN ( ";
	
				for ($i = 0; $i < count($sektor); $i++){
					$sqlPart .= $sektor[$i];
					 
					if ($i != count($sektor)-1){
						$sqlPart .= ",";
					}
				}
	
				$sqlPart .= ") ";
			}
	
			$params = array ();
		}else{
			$onTaslakDurumlariPart = "m_yeterlilik.YETERLILIK_DURUM_ID IN
			(".PM_YETERLILIK_DURUMU__BASVURU.","
			.PM_YETERLILIK_DURUMU__OLUSTURULMAMIS_ONTASLAK.","
			.PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK.","
			.PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK.","
			.PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK.")";
				
			$sqlPart = "AND USER_ID = ? ";
			$params = array($userId);
		}
		if ($sqlPart != ""){
			$sql = "SELECT DISTINCT
				m_yeterlilik.YETERLILIK_ID,
				m_yeterlilik.YETERLILIK_ADI,
				SEVIYE_ADI,
				YETERLILIK_TESLIM_TARIHI AS BASLANGIC_TARIHI_FORMATTED,
				YETERLILIK_SUREC_DURUM_ADI,
				m_yeterlilik.YETERLILIK_SUREC_DURUM_ID,
				m_yeterlilik.SEKTOR_ID,
				SEKTOR_ADI,
				M_YETERLILIK.YENI_MI,
				CASE WHEN YETERLILIK_KODU IS NOT NULL THEN YETERLILIK_KODU
                ELSE ' Bos '
                END ||' - '|| REVIZYON AS YETERLILIK_BILGISI
			FROM m_yeterlilik,
				pm_seviye,
				pm_yeterlilik_surec_durum,
				pm_sektorler,
				m_yetki_yeterlilik,
				m_kurulus_yetki,
				m_yetki
			WHERE m_yeterlilik.YETERLILIK_ID = m_yetki_yeterlilik.YETERLILIK_ID
				AND m_yetki_yeterlilik.YETKI_ID = m_kurulus_yetki.YETKI_ID
				AND m_yetki_yeterlilik.YETKI_ID = m_yetki.YETKI_ID
				AND m_yetki.ETKIN = 1
				AND m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = pm_yeterlilik_surec_durum.YETERLILIK_SUREC_DURUM_ID
				AND m_yeterlilik.SEKTOR_ID = pm_sektorler.SEKTOR_ID
				AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
				AND ".$onTaslakDurumlariPart." AND ".$sqlPart;
	
			$ontaslaklar = $db->prep_exec($sql, $params);
		}
		else
		{
			$ontaslaklar = null;
		}
			
		return  $ontaslaklar;
	}
	
}
?>