<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelOnayli_Taslak_Listele extends JModel {
	
   /* function getTaslaklar($db){
		$user = & JFactory::getUser();
    	$userId = $user->getOracleUserId();
    	$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID));
    	
    	if ($isSektorSorumlusu){
    		$sektor	 = FormFactory::getSorumluSektorId ($userId, YET_SEKTOR_TIPI);
    		$sqlPart = "";
    		
    		if (count($sektor) > 0 ){
	    		$sqlPart .= "( ";
	    		
    			for ($i = 0; $i < count($sektor); $i++){
	    			$sqlPart .= " sektor_id = ".$sektor[$i]." OR";
	    		}
	    		
	    		$sqlPart = substr ($sqlPart, 0, strlen($sqlPart)-2).") AND ";
    		}
    		
    		$params = array ();
    	}else{
    		$sqlPart = "USER_ID = ? AND ";
    		$params = array($userId);
    	}
    	
    	if ($sqlPart != ""){
			$sql = "SELECT  YETERLILIK_ID,
							YETERLILIK_ADI,
							SEVIYE_ADI,
							TO_CHAR(YETERLILIK_BASLANGIC, 'dd.mm.yyyy')
									AS BASLANGIC_TARIHI_FORMATTED,
							YETERLILIK_SUREC_DURUM_ADI,
							YETERLILIK_SUREC_DURUM_ID,
							YETERLILIK_DURUM_ADI,
							YETERLILIK_DURUM_ID,
							SEKTOR_ID,
							SEKTOR_ADI,
							EVRAK_ID,
							YENI_MI  
					FROM M_YETERLILIK
						NATURAL JOIN ".DB_PREFIX.".EVRAK 
						JOIN M_TASLAK_YETERLILIK USING (EVRAK_ID, YETERLILIK_ID) 
						JOIN M_BASVURU USING (EVRAK_ID, USER_ID) 
						JOIN PM_SEVIYE USING (SEVIYE_ID) 
						JOIN PM_SEKTORLER USING(SEKTOR_ID) 
						JOIN PM_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_ID)
						JOIN PM_YETERLILIK_DURUM USING (YETERLILIK_DURUM_ID) 
					WHERE ".$sqlPart." 
						  BASVURU_TIP_ID = ".YT2_BASVURU_TIP." AND 
						  BASVURU_SEKLI_ID = ".KAYDEDILMIS_BASVURU_SEKLI_ID." AND 
						  YETERLILIK_SUREC_DURUM_ID = ".ONAYLANMIS_YETERLILIK;
								
			$taslaklar = $db->prep_exec($sql, $params);
    	}else{
    		$taslaklar = null;
    	}
		return $taslaklar;
    }
    */
	
	function getTaslaklar($db){
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, YET_SEKTOR_SORUMLUSU_GROUP_ID));
		 
		if ($isSektorSorumlusu){
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
			$sqlPart = " m_kurulus_yetki.user_id = ? ";
			$params = array($userId);
		}
		 
		if ($sqlPart != ""){
			$sql = "SELECT DISTINCT m_yeterlilik.YETERLILIK_ID, 
			            			m_yeterlilik.YETERLILIK_ID, 
									m_yeterlilik.YETERLILIK_ADI, 
									m_yeterlilik.YETERLILIK_KODU, 
									m_yeterlilik.SEVIYE_ID, 
									m_yeterlilik.REVIZYON, 
									SEVIYE_ADI, 
									YETERLILIK_BASLANGIC AS BASLANGIC_TARIHI_FORMATTED, 
									YETERLILIK_SUREC_DURUM_ADI, 
									m_yeterlilik.YETERLILIK_SUREC_DURUM_ID, 
									m_yeterlilik.SEKTOR_ID, 
									SEKTOR_ADI, 
									SON_TASLAK_PDF, 
									YENI_MI, 
									m_taslak_yeterlilik.REVIZYON_NO
			FROM 	m_yeterlilik, 
					m_taslak_yeterlilik,
					M_YETKI, 
					M_YETKI_YETERLILIK,
					pm_seviye, pm_yeterlilik_surec_durum, pm_sektorler
			WHERE  m_taslak_yeterlilik.yeterlilik_id = m_yeterlilik.yeterlilik_id AND
					M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID AND
					M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID AND
					m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = pm_yeterlilik_surec_durum.YETERLILIK_SUREC_DURUM_ID 
					AND m_yeterlilik.SEKTOR_ID = pm_sektorler.SEKTOR_ID
					AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
					AND yeterlilik_durum_id = ".PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK."
					AND ".$sqlPart."
			order by m_yeterlilik.YETERLILIK_ADI,SEVIYE_ADI";
	
			$taslaklar = $db->prep_exec($sql, $params);
		}else{
			$taslaklar = null;
		}
		return $taslaklar;
	}
	
    function getRevizyonByYeterlilikID($yeterlilikID)
    {
    	$db = & JFactory::getOracleDBO();
    	$sql  = 'SELECT 
    	m_yeterlilik_revizyon.REVIZYON_NO, 
    	m_yeterlilik_revizyon.SON_TASLAK_PDF, 
    	pm_yeterlilik_revizyon_surec.YETERLILIK_SUREC_DURUM_ADI
    	
    	FROM m_yeterlilik_revizyon, pm_yeterlilik_revizyon_surec 
    	
    	WHERE m_yeterlilik_revizyon.revizyon_durumu =  pm_yeterlilik_revizyon_surec.yeterlilik_surec_durum_id  
    	AND yeterlilik_id = '.$yeterlilikID.' 
    	
    	ORDER BY m_yeterlilik_revizyon.REVIZYON_NO '; 
    	$revizyonlar = $db->prep_exec($sql);
		return $revizyonlar;    	
    }
    
    function getYeterlilikSonTaslakByYeterlilikID($yeterlilikID)
    {
    	$db = & JFactory::getOracleDBO();
    
    	$sql = 'SELECT * FROM M_TASLAK_YETERLILIK
    	WHERE YETERLILIK_ID = ?';
    	
    	$revizyonlar = $db->prep_exec($sql, array($yeterlilikID));
    	
    	return $revizyonlar;
    }
    function getYeterlilikDatas($yeterlilikKodu){
    	$db = & JFactory::getOracleDBO();
    	
    	$sql = "SELECT  DISTINCT M_KURULUS.KURULUS_ADI,
				M_YETERLILIK.YETERLILIK_ID,
				M_YETERLILIK.YETERLILIK_KODU,
				M_YETERLILIK.YETERLILIK_ADI,
				M_YETERLILIK.SEVIYE_ID,
				PM_SEVIYE.SEVIYE_ADI,
				PM_SEKTORLER.SEKTOR_ADI,
				M_YETERLILIK.REVIZYON,
				M_TASLAK_YETERLILIK.SON_TASLAK_PDF
				FROM M_YETERLILIK
				LEFT JOIN M_BELGELENDIRME_YET_YETKI ON M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				LEFT JOIN M_TASLAK_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_TASLAK_YETERLILIK.YETERLILIK_ID
				LEFT JOIN M_KURULUS ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
				INNER JOIN PM_SEVIYE ON M_YETERLILIK.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID
				INNER JOIN PM_SEKTORLER ON M_YETERLILIK.SEKTOR_ID = PM_SEKTORLER.SEKTOR_ID
		WHERE M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID = ".ONAYLANMIS_YETERLILIK." AND YETERLILIK_KODU = '".$yeterlilikKodu."' ORDER BY M_YETERLILIK.YETERLILIK_ADI,M_YETERLILIK.REVIZYON";
    	
    	$datas = $db->prep_exec($sql, array());
    	$grouped = array();
    	foreach ($datas as $data){
    		if($data['YETERLILIK_KODU'] <> ""){
    			$code = explode("-",$data['YETERLILIK_KODU']);
    	
    			$konum = strpos($code[1], "/");
    			if($konum !== false){
    				$code[1] = current(explode("/", $code[1]));
    			}
    			$array_code = trim($code[0])."-".trim($code[1]);
    		}else{
    			$search = array('Ç','ç','Ğ','ğ','İ','i','Ö','ö','Ş','ş','Ü','ü',' ');
    			$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','_');
    			$array_code = str_replace($search,$replace,$data['YETERLILIK_ADI']);
    			$array_code = strtolower($array_code)."-".$data['SEVIYE_ID'];
    		}
    	
    		if(!array_key_exists($array_code,$grouped)){
    	
    			$grouped[$array_code]['YETERLILIK_KODU'] = $data['YETERLILIK_KODU'];
    			$grouped[$array_code]['YETERLILIK_ADI']= mb_strtolower( str_replace(array('I', 'Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç'), array('ı', 'ğ', 'ü', 'ş', 'i', 'ö', 'ç'), $data['YETERLILIK_ADI']), "UTF-8");
    			$grouped[$array_code]['SEVIYE_ADI']    = $data['SEVIYE_ADI'];
    			$grouped[$array_code]['SEKTOR_ADI']    = $data['SEKTOR_ADI'];
    			$grouped[$array_code]['REVIZYONBILGILERI'] = array();
    		}
    	
    		if(!array_key_exists($data['REVIZYON'],$grouped[$array_code]['REVIZYONBILGILERI'])){
    			$grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']] = array('YETERLILIK_ID'  => $data['YETERLILIK_ID'],
    					'REVIZYON'       => $data['REVIZYON'],
    					'SON_TASLAK_PDF' => $data['SON_TASLAK_PDF']);
    			$grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'] = array();
    		}
    	
    		if($data['KURULUS_ADI'] <> ""){
    			array_push($grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'], $data['KURULUS_ADI']);
    		}
    	}
    	return $grouped;
    }
   
}
?>
