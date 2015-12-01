<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Meslek_Std_TaslakModelTaslak_Adayi_Listele extends JModel {
	
	function getTaslakAday (){
		$_db  = &JFactory::getOracleDBO();
		$user = &JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID));
    	$params = array ();
    	$sektorPart = "";
    	$gond=$_GET["gondtip"]?$_GET["gondtip"]:"0"; //Azat Sekt�r Sorumlular�n�n kendilerine g�nderilmemi� �n taslaklar� da g�rmeleri i�in eklendi
		
    	if ($isSektorSorumlusu)
    	{
			if ($gond=="1")//Azat Sekt�r Sorumlular�n�n kendilerine g�nderilmemi� �n taslaklar� da g�rmeleri i�in eklendi
				$onTaslakDurumlariPart = "m_meslek_standartlari.meslek_standart_durum_id IN (".PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK.",".PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK.")";//Azat Sekt�r Sorumlular�n�n kendilerine g�nderilmemi� �n taslaklar� da g�rmeleri i�in eklendi
		
			else//Azat Sekt�r Sorumlular�n�n kendilerine g�nderilmemi� �n taslaklar� da g�rmeleri i�in eklendi
				$onTaslakDurumlariPart = "m_meslek_standartlari.meslek_standart_durum_id IN (".PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK.",".PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK.")";
			
			$sqlFromPart = "";
    		$sqlConditionPart = "";
    		
    		$sektor	 = FormFactory::getSorumluSektorId ($userId, MS_SEKTOR_TIPI); 		

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
    	}else{
    		$onTaslakDurumlariPart = "m_meslek_standartlari.meslek_standart_durum_id IN 
    								(".PM_MESLEK_STANDART_DURUMU__BASVURU.","
    								.PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK.","
    								.PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK.","
    								.PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK.","
    								.PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK.","
    								.")";
    		
    		
    		$sqlFromPart = " m_kurulus_yetki, ";    	
    		$sqlConditionPart = "AND m_yetki.yetki_id = m_kurulus_yetki.yetki_id AND m_kurulus_yetki.user_id = ?";
    		$params = array($userId);
    	}
    	
    	if (($isSektorSorumlusu && $sqlConditionPart!="")){
  											
    		$sql = "	SELECT UNIQUE 
    						m_meslek_standartlari.standart_id, 
    						m_meslek_standartlari.standart_adi, 
    						sektor_adi, 
    						etkin, 
    						STANDART_SUREC_DURUM_ADI, 
    						TO_CHAR(BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI_FORMATTED, 
    						seviye_adi,
    						revizyon
    		    		FROM ".$sqlFromPart." m_meslek_standartlari, 
    		    			  M_YETKI_STANDART, 
    		    			  m_yetki, 
    		    			  PM_SEKTORLER, 
    		    			  PM_MESLEK_STANDART_SUREC_DURUM, 
    		    			  PM_SEVIYE
    		    		WHERE m_meslek_standartlari.MESLEK_STANDART_SUREC_DURUM_ID = PM_MESLEK_STANDART_SUREC_DURUM.MESLEK_STANDART_SUREC_DURUM_ID
    		    			AND ".$sqlConditionPart." AND m_meslek_standartlari.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID
    		    			AND m_meslek_standartlari.STANDART_ID = M_YETKI_STANDART.STANDART_ID 
    		    			AND m_meslek_standartlari.SEKTOR_ID = PM_SEKTORLER.SEKTOR_ID
    		    			AND M_YETKI_STANDART.YETKI_ID = m_yetki.YETKI_ID 
    		    			AND (ETKIN != ".PM_YETKI_ETKINLIGI__ETKISIZ." or ETKIN is null)
    		    			AND ".$onTaslakDurumlariPart."
    					ORDER BY standart_adi";
    											
	        $data = $_db->prep_exec($sql, $params);	
    	}else{
    		$data = null;
    	}
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
		
}
?>