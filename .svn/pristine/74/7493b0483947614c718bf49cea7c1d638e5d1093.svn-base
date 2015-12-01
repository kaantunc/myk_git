<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries/PHPExcel-develop/Classes/PHPExcel/IOFactory.php');

class IstatistikModelIstatistik extends JModel {

	function SSgonderilmisMSonTas(){
		$db  = &JFactory::getOracleDBO();
		$user = &JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID));
    	$params = array ();
    	$sektorPart = "";
    	$gond=0; //Azat Sekt�r Sorumlular�n�n kendilerine g�nderilmemi� �n taslaklar� da g�rmeleri i�in eklendi
		
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
  											
//     		$sql = "	SELECT UNIQUE 
//     						m_meslek_standartlari.standart_id, 
//     						m_meslek_standartlari.standart_adi, 
//     						sektor_adi, 
//     						etkin, 
//     						STANDART_SUREC_DURUM_ADI, 
//     						TO_CHAR(BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI_FORMATTED, 
//     						seviye_adi
//     		    		FROM ".$sqlFromPart." m_meslek_standartlari, 
//     		    			  M_YETKI_STANDART, 
//     		    			  m_yetki, 
//     		    			  PM_SEKTORLER, 
//     		    			  PM_MESLEK_STANDART_SUREC_DURUM, 
//     		    			  PM_SEVIYE
//     		    		WHERE m_meslek_standartlari.MESLEK_STANDART_SUREC_DURUM_ID = PM_MESLEK_STANDART_SUREC_DURUM.MESLEK_STANDART_SUREC_DURUM_ID
//     		    			AND ".$sqlConditionPart." AND m_meslek_standartlari.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID
//     		    			AND m_meslek_standartlari.STANDART_ID = M_YETKI_STANDART.STANDART_ID 
//     		    			AND m_meslek_standartlari.SEKTOR_ID = PM_SEKTORLER.SEKTOR_ID
//     		    			AND M_YETKI_STANDART.YETKI_ID = m_yetki.YETKI_ID 
//     		    			AND (ETKIN != ".PM_YETKI_ETKINLIGI__ETKISIZ." or ETKIN is null)
//     		    			AND ".$onTaslakDurumlariPart."
//     					ORDER BY standart_adi";

    		$sql = "	SELECT UNIQUE
    						count(*) as say
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
    											
	        $data = $db->prep_exec($sql, $params);	
    	}else{
    		$data = null;
    	}
		
		if (!empty($data))
			return $data;
		else
			return null;
		
	}
	
	function SSgonderilmemisMSonTas(){
		$db  = &JFactory::getOracleDBO();
		$user = &JFactory::getUser();
		$userId = $user->getOracleUserId();
		$isSektorSorumlusu = (FormFactory::checkAclGroupId($user->id, MS_SEKTOR_SORUMLUSU_GROUP_ID));
		$params = array ();
		$sektorPart = "";
		$gond=1; //Azat Sekt�r Sorumlular�n�n kendilerine g�nderilmemi� �n taslaklar� da g�rmeleri i�in eklendi
		
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
				
// 			$sql = "	SELECT UNIQUE
//     						m_meslek_standartlari.standart_id,
//     						m_meslek_standartlari.standart_adi,
//     						sektor_adi,
//     						etkin,
//     						STANDART_SUREC_DURUM_ADI,
//     						TO_CHAR(BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI_FORMATTED,
//     						seviye_adi
//     		    		FROM ".$sqlFromPart." m_meslek_standartlari,
//     		    			  M_YETKI_STANDART,
//     		    			  m_yetki,
//     		    			  PM_SEKTORLER,
//     		    			  PM_MESLEK_STANDART_SUREC_DURUM,
//     		    			  PM_SEVIYE
//     		    		WHERE m_meslek_standartlari.MESLEK_STANDART_SUREC_DURUM_ID = PM_MESLEK_STANDART_SUREC_DURUM.MESLEK_STANDART_SUREC_DURUM_ID
//     		    			AND ".$sqlConditionPart." AND m_meslek_standartlari.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID
//     		    			AND m_meslek_standartlari.STANDART_ID = M_YETKI_STANDART.STANDART_ID
//     		    			AND m_meslek_standartlari.SEKTOR_ID = PM_SEKTORLER.SEKTOR_ID
//     		    			AND M_YETKI_STANDART.YETKI_ID = m_yetki.YETKI_ID
//     		    			AND (ETKIN != ".PM_YETKI_ETKINLIGI__ETKISIZ." or ETKIN is null)
//     		    			AND ".$onTaslakDurumlariPart."
//     					ORDER BY standart_adi";
				
			$sql = "	SELECT UNIQUE
    						count(*) as say
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
			
			$data = $db->prep_exec($sql, $params);
		}else{
			$data = null;
		}
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getAllStatistic(){
		$db  = &JFactory::getOracleDBO();
	
		
		$sql = "SELECT ISTATISTIK_KODU,ISTATISTIK_SAYISI,ISTATISTIK_SAYISI_EDIT FROM M_ISTATISTIK";
		$datas = $db->prep_exec($sql, array());
		
		foreach ($datas as $data){
			$pub_datas[$data['ISTATISTIK_KODU']]['ISTATISTIK_SAYISI'] = $data['ISTATISTIK_SAYISI'];
			$pub_datas[$data['ISTATISTIK_KODU']]['ISTATISTIK_SAYISI_EDIT'] = $data['ISTATISTIK_SAYISI_EDIT'];
		}
		
		
		$sql = "SELECT COUNT(M_KURULUS_YETKI.USER_ID) AS SAYI
				  FROM M_YETKI 
			INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
				 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
				       M_YETKI.YETKI_TURU = 1 
			  ORDER BY M_KURULUS_YETKI.USER_ID";
		$datas = $db->prep_exec($sql, array());
		$return['ums_kurulus_sayi'] 			 = $datas[0]['SAYI'];
//-----------------------------------------------------------------------------------		
		$sql = "SELECT COUNT(M_MESLEK_STANDARTLARI.STANDART_ID) AS SAYI
						  FROM M_YETKI 
					INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
				  INNER JOIN M_YETKI_STANDART ON M_YETKI_STANDART.YETKI_ID = M_YETKI.YETKI_ID
			    INNER JOIN M_MESLEK_STANDARTLARI ON M_MESLEK_STANDARTLARI.STANDART_ID = M_YETKI_STANDART.STANDART_ID
						 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
						       M_YETKI.YETKI_TURU = 1 AND 
		M_MESLEK_STANDARTLARI.MESLEK_STANDART_DURUM_ID != '-4' AND
		M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID != '-3'
					  ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI";
		$datas = $db->prep_exec($sql, array());
		$return['ums_hazirlanacak_sayi']		 = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_MESLEK_STANDARTLARI.STANDART_ID) AS SAYI
						  FROM M_YETKI 
					INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
				  INNER JOIN M_YETKI_STANDART ON M_YETKI_STANDART.YETKI_ID = M_YETKI.YETKI_ID
			    INNER JOIN M_MESLEK_STANDARTLARI ON M_MESLEK_STANDARTLARI.STANDART_ID = M_YETKI_STANDART.STANDART_ID
						 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
						       M_YETKI.YETKI_TURU = 1 AND 
		M_MESLEK_STANDARTLARI.MESLEK_STANDART_DURUM_ID != '-4' AND
		M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID != '-3'
					  ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI";
		$datas = $db->prep_exec($sql, array());
		$return['ums_calismaya_baslanilan_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_MESLEK_STANDARTLARI.STANDART_ID) AS SAYI  FROM M_MESLEK_STANDARTLARI WHERE
				M_MESLEK_STANDARTLARI.MESLEK_STANDART_DURUM_ID = '2' AND
				M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID = '14'
							  ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI";
		$datas = $db->prep_exec($sql, array());
		$return['ums_resmi_gazetede_sayi']		 = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_MESLEK_STANDARTLARI.STANDART_ID) AS SAYI  FROM M_MESLEK_STANDARTLARI WHERE
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_DURUM_ID = '2' AND
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID = '14' AND REVIZYON != '00'
								  ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI";
		$datas = $db->prep_exec($sql, array());
		$return['ums_guncellenen_sayi'] 		 = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_MESLEK_STANDARTLARI.STANDART_ID) AS SAYI FROM M_MESLEK_STANDARTLARI WHERE
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_DURUM_ID = '2' AND
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID = '14' AND TEHLIKELI_IS_DURUM = 1
								  ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI";
		$datas = $db->prep_exec($sql, array());
		$return['ums_tehlikeli_islerde_sayi']	 = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_MESLEK_STANDARTLARI.STANDART_ID) AS SAYI  
						FROM M_MESLEK_STANDARTLARI WHERE
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_DURUM_ID = '2' AND
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID = '14' AND
					M_MESLEK_STANDARTLARI.SEKTOR_ID = 11
				ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI";
		$datas = $db->prep_exec($sql, array());
		$return['ums_insaatta_yayinlanan_sayi']  = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		
		
		
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_KURULUS_YETKI.USER_ID) AS SAYI
				  FROM M_YETKI 
			INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
				 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
				       M_YETKI.YETKI_TURU = 2 
			  ORDER BY M_KURULUS_YETKI.USER_ID";
		$datas = $db->prep_exec($sql, array());
		$return['uy_kurulus_sayi'] 			      = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_YETERLILIK.YETERLILIK_ID) AS SAYI
				  FROM M_YETKI 
						INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
			      INNER JOIN M_YETKI_YETERLILIK ON M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID
			       INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID
							 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
							       M_YETKI.YETKI_TURU = 2 AND 
			M_YETERLILIK.YETERLILIK_DURUM_ID != '-4' AND 
			M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID != '-3' 
						  ORDER BY M_YETERLILIK.YETERLILIK_ID ";
		$datas = $db->prep_exec($sql, array());
		$return['uy_hazirlanacak_sayi']		      = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_YETERLILIK.YETERLILIK_ID) AS SAYI
							  FROM M_YETKI 
						INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
			      INNER JOIN M_YETKI_YETERLILIK ON M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID
			       INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID
							 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
							       M_YETKI.YETKI_TURU = 2 AND 
			M_YETERLILIK.YETERLILIK_DURUM_ID != '-4' AND 
			M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID != '-3' 
						  ORDER BY M_YETERLILIK.YETERLILIK_ID";
		$datas = $db->prep_exec($sql, array());
		$return['uy_calismalari_surdurulen_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_YETERLILIK.YETERLILIK_ID) AS SAYI
						  FROM M_YETKI 
					INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
		      INNER JOIN M_YETKI_YETERLILIK ON M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID
		       INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID
						 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
						       M_YETKI.YETKI_TURU = 2 AND 
		M_YETERLILIK.YETERLILIK_DURUM_ID = '2' AND 
		M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID = '1' 
					  ORDER BY M_YETERLILIK.YETERLILIK_ID ";
		$datas = $db->prep_exec($sql, array());
		$return['uy_onaylanan_sayi']		      = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_YETERLILIK.YETERLILIK_ID) AS SAYI
				  FROM M_YETKI 
			INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
		      INNER JOIN M_YETKI_YETERLILIK ON M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID
		       INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID
						 WHERE M_YETKI.PROTOKOL_MU = 1 AND 
						       M_YETKI.YETKI_TURU = 2 AND 
								M_YETERLILIK.YETERLILIK_DURUM_ID = '2' AND 
								M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID = '1' AND 
												M_YETERLILIK.REVIZYON != '00'
					  ORDER BY M_YETERLILIK.YETERLILIK_ID ";
		$datas = $db->prep_exec($sql, array());
		$return['uy_guncellenen_sayi'] 		      = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_YETERLILIK.YETERLILIK_ID) AS SAYI
				  FROM M_YETERLILIK WHERE M_YETERLILIK.YETERLILIK_DURUM_ID = '2' AND 
			M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID = '1' AND
	M_YETERLILIK.TEHLIKELI_IS_DURUM = '1'
			  ORDER BY M_YETERLILIK.YETERLILIK_ID";
		$datas = $db->prep_exec($sql, array());
		$return['uy_tehlikeli_islerde_sayi']	  = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_YETERLILIK.YETERLILIK_ID) AS SAYI
				  FROM M_YETERLILIK WHERE M_YETERLILIK.YETERLILIK_DURUM_ID = '2' AND 
			M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID = '1' AND
				M_YETERLILIK.SEKTOR_ID = 11
			  ORDER BY M_YETERLILIK.YETERLILIK_ID";
		$datas = $db->prep_exec($sql, array());
		$return['uy_insaatta_yayinlanan_sayi']    = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		
		
		
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(DISTINCT M_BELGELENDIRME_YET_YETKI.USER_ID) AS SAYI FROM M_BELGELENDIRME_YET_YETKI 
					LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
					INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
					WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1 AND M_BELGELENDIRME_YET_YETKI.USER_ID != '7021' AND M_KURULUS_YETKI_ASKI.ASKI IS NULL";
		$datas = $db->prep_exec($sql, array());
		$return['sb_kurulus_sayi'] 			      					     = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(DISTINCT M_BELGELENDIRME_YET_YETKI.USER_ID) AS SAYI FROM M_BELGELENDIRME_YET_YETKI
				LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID 
				INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
				WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1 AND M_YETERLILIK.TEHLIKELI_IS_DURUM = 1 AND 
					M_BELGELENDIRME_YET_YETKI.USER_ID != '7021'";
		$datas = $db->prep_exec($sql, array());
		$return['sb_tehlikeli_islerde_belgelendirme_yapan_kurulus_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(DISTINCT M_BELGELENDIRME_YET_YETKI.USER_ID) AS SAYI FROM M_BELGELENDIRME_YET_YETKI
	INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
LEFT OUTER JOIN M_YETERLILIK_SEKTOR ON M_YETERLILIK_SEKTOR.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
	LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID		
WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1 AND (M_YETERLILIK.SEKTOR_ID = '11' OR M_YETERLILIK_SEKTOR.RELATED_SEKTOR_ID = 11)";
		$datas = $db->prep_exec($sql, array());
		$return['sb_insaatta_belgelendirme_yapan_sayi']    			     = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(DISTINCT M_YETERLILIK.YETERLILIK_KODU)  AS SAYI FROM M_BELGELENDIRME_YET_YETKI 
				INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
				LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
				WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1";
		$datas = $db->prep_exec($sql, array());
		$return['sb_belgelendirme_yapilan_meslek_sayi']		             = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql_insaat_belge_sayi = "SELECT M_YETERLILIK.YETERLILIK_KODU FROM M_BELGELENDIRME_YET_YETKI 
				INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
				LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
				WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1 AND M_YETERLILIK.TEHLIKELI_IS_DURUM = 1 
GROUP BY M_YETERLILIK.YETERLILIK_KODU";
		$datas = $db->prep_exec($sql_insaat_belge_sayi, array());
		$return['sb_tehlikeli_islerde_belgelendirme_yapilan_meslek_sayi'] = count($datas);
		//-----------------------------------------------------------------------------------
		$sql_insaat_belge_sayi = "SELECT COUNT(DISTINCT M_YETERLILIK.YETERLILIK_KODU) AS SAYI FROM M_BELGELENDIRME_YET_YETKI
	INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
LEFT OUTER JOIN M_YETERLILIK_SEKTOR ON M_YETERLILIK_SEKTOR.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
	LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID			
WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1 AND (M_YETERLILIK.SEKTOR_ID = '11' OR M_YETERLILIK_SEKTOR.RELATED_SEKTOR_ID = 11)";
		$datas = $db->prep_exec($sql_insaat_belge_sayi, array());
		$return['sb_insatta_belgelendirilmesi_yapilan_meslek_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql_insaat_belge_sayi = "SELECT COUNT(DISTINCT M_YETERLILIK.SEKTOR_ID) AS SAYI FROM M_BELGELENDIRME_YET_YETKI 
				LEFT OUTER JOIN M_KURULUS_YETKI_ASKI ON M_KURULUS_YETKI_ASKI.KURULUS_ID = M_BELGELENDIRME_YET_YETKI.USER_ID
						INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID
						WHERE M_BELGELENDIRME_YET_YETKI.DURUM = 1";
		$datas = $db->prep_exec($sql_insaat_belge_sayi, array());
		$return['sb_belgelendirme_yapilan_sektor_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		
		
		
		//-----------------------------------------------------------------------------------
		$sql_insaat_belge_sayi = "SELECT COUNT(M_BELGE_SORGU.ID) AS SAYI FROM M_BELGE_SORGU";
		$datas = $db->prep_exec($sql_insaat_belge_sayi, array());
		$return['verilen_myk_belge_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_BELGE_SORGU.ID) AS SAYI FROM M_BELGE_SORGU
					INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGE_SORGU.YETERLILIK_ID
					LEFT OUTER JOIN M_YETERLILIK_SEKTOR ON M_YETERLILIK_SEKTOR.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					WHERE M_YETERLILIK.SEKTOR_ID = 11 OR M_YETERLILIK_SEKTOR.RELATED_SEKTOR_ID = 11";
		$datas = $db->prep_exec($sql, array());
		$return['insaatta_verilen_myk_belge_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(M_BELGE_SORGU.ID) AS SAYI FROM M_BELGE_SORGU
										INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_BELGE_SORGU.YETERLILIK_ID
										WHERE M_YETERLILIK.TEHLIKELI_IS_DURUM = 1";
		$datas = $db->prep_exec($sql, array());
		$return['tehlikeli_islerde_verilen_myk_belge_sayi'] = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		
		
		//-----------------------------------------------------------------------------------
		$sql = "SELECT COUNT(SEKTOR_ID) AS SAYI FROM PM_SEKTORLER WHERE SEKTOR_DURUM = 1";
		$datas = $db->prep_exec($sql, array());
		$return['sektor_sayi']		       = $datas[0]['SAYI'];
		//-----------------------------------------------------------------------------------
		$sql = "";
		$datas = $db->prep_exec($sql, array());
		$return['aktif_sektor_komite_sayi']= 23;
		//$datas[0]['SAYI'];
		
		foreach ($pub_datas as $key => $val){
			$pub_datas[$key]['ISTATISTIK_SAYISI'] = $return[$key];
		}
		
		return $pub_datas;
	}
	
	function savestatistics($post){

		$db  = &JFactory::getOracleDBO();
		
		$cols = array('ums_kurulus_sayi',
						'ums_hazirlanacak_sayi',
						'ums_calismaya_baslanilan_sayi',
						'ums_resmi_gazetede_sayi',
						'ums_guncellenen_sayi',
						'ums_tehlikeli_islerde_sayi',
						'ums_insaatta_yayinlanan_sayi',
						'uy_kurulus_sayi',
						'uy_hazirlanacak_sayi',
						'uy_calismalari_surdurulen_sayi',
						'uy_onaylanan_sayi',
						'uy_guncellenen_sayi',
						'uy_tehlikeli_islerde_sayi',
						'uy_insaatta_yayinlanan_sayi',
						'sb_kurulus_sayi',
						'sb_tehlikeli_islerde_belgelendirme_yapan_kurulus_sayi',
						'sb_insaatta_belgelendirme_yapan_sayi',
						'sb_belgelendirme_yapilan_meslek_sayi',
						'sb_tehlikeli_islerde_belgelendirme_yapilan_meslek_sayi',
						'sb_insatta_belgelendirilmesi_yapilan_meslek_sayi',
						'sb_belgelendirme_yapilan_sektor_sayi',
						'verilen_myk_belge_sayi',
						'insaatta_verilen_myk_belge_sayi',
						'tehlikeli_islerde_verilen_myk_belge_sayi',
						'sektor_sayi',
						'aktif_sektor_komite_sayi',
						'ums_yururluktrn_kaldirilan_sayi');
		foreach ($post as $key => $val){
			$col = substr($key, 0,-5);
			if(in_array($col,$cols)){
				$sql = "UPDATE M_ISTATISTIK SET ISTATISTIK_SAYISI_EDIT = ? WHERE ISTATISTIK_KODU = ?";
				$db->prep_exec_insert($sql, array($val,$col));
			}
		}
		
		return true;
	}
	
	function istatistik_meslek_detail($revizyon = false){
		
		$db  = &JFactory::getOracleDBO();
		
		if($revizyon == true){
			$condition = "AND M_MESLEK_STANDARTLARI.REVIZYON != '00'";
		}else{
			$condition = "";
		}
		$sql = "SELECT  M_KURULUS.USER_ID,
					M_YETKI_STANDART.YETKI_ID,
					M_MESLEK_STANDARTLARI.SEKTOR_ID,
					M_KURULUS.KURULUS_ADI,
					PM_SEKTORLER.SEKTOR_ADI,
					M_MESLEK_STANDARTLARI.STANDART_ADI,
					M_MESLEK_STANDARTLARI.MESLEK_STANDART_SUREC_DURUM_ID
 			  FROM M_MESLEK_STANDARTLARI
              JOIN M_YETKI_STANDART ON (M_MESLEK_STANDARTLARI.STANDART_ID=M_YETKI_STANDART.STANDART_ID)
              JOIN M_YETKI ON (M_YETKI.YETKI_ID=M_YETKI_STANDART.YETKI_ID)
              JOIN M_KURULUS_YETKI ON (M_KURULUS_YETKI.YETKI_ID=M_YETKI.YETKI_ID)
              JOIN M_KURULUS ON (M_KURULUS.USER_ID=M_KURULUS_YETKI.USER_ID)
              JOIN PM_SEKTORLER ON (PM_SEKTORLER.SEKTOR_ID=M_MESLEK_STANDARTLARI.SEKTOR_ID)
             WHERE MESLEK_STANDART_SUREC_DURUM_ID<>-3 AND
		           M_YETKI.ETKIN=1 AND
		           M_YETKI.PROTOKOL_MU=1 AND
		           M_YETKI.YETKI_TURU=1 ".$condition."
          ORDER BY KURULUS_ADI";
		$params = array();
		$datas  = $db->prep_exec($sql, $params);
		
		$result = array();
		foreach($datas as $data){
			if(!array_key_exists($data['SEKTOR_ID'], $result[$data['USER_ID']][$data['YETKI_ID']])){
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KURULUS_ADI']  = $data['KURULUS_ADI'];
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SEKTOR_ADI']  = $data['SEKTOR_ADI'];
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['PKS']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KTCD'] = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GA']   = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GDA']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['IEM']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SKA']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YKA']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YUG']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['RGY']  = 0;
			}
		
			if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '0' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '-2' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '-4'){
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KTCD']++;
					
			}else if($data[$data['USER_ID']]['MESLEK_STANDART_SUREC_DURUM_ID'] == '4'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GA']++;
					
			}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '6' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '7' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '8'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GDA']++;
			}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '-1' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '5' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '15'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['IEM']++;
			}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '2' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '3' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '9' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '11'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SKA']++;
			}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '10' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '12'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YKA']++;
			}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '1' || $data['MESLEK_STANDART_SUREC_DURUM_ID'] == '13'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YUG']++;
			}else if($data['MESLEK_STANDART_SUREC_DURUM_ID'] == '14'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['RGY']++;
			}
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['PKS']++;
		}
		
		return $result;
	}
	

	function istatistik_meslek(){

		$db  = &JFactory::getOracleDBO();
		$Durum_SurecDurum_Tablosu = array(
				array('-2, -1, -5, 0'	, '4'),
				array('-2, -1, -5, 0'	, '8, 7,6'),
				array(			 '-4'	, '-1,5, 15'),
				array('-2, -1, -5, 0'	, '2, 3,11, 9'),
				array('-2, -1, -5, 0'	, '10, 12'),
				array(			  '1'	, '1, 13'),
				array(			  '2'	, '14'),
		);
	
		for($i=0; $i<count($Durum_SurecDurum_Tablosu); $i++)
		{
			$sql = 'SELECT COUNT(DISTINCT STANDART_ID) AS "COUNT"
		FROM M_MESLEK_STANDARTLARI JOIN M_TASLAK_MESLEK USING (STANDART_ID)
		WHERE  MESLEK_STANDART_SUREC_DURUM_ID IN ('.$Durum_SurecDurum_Tablosu[$i][1].')';
			$params = array();
			$result = $db->prep_exec($sql, $params);
			$resultToReturn[] = $result[0]["COUNT"];
		}
		return $resultToReturn;
	}
	
	function istatistik_yeterlilik_detail(){
		
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT M_KURULUS.USER_ID,
					   M_YETKI_YETERLILIK.YETKI_ID,
					   M_YETERLILIK.SEKTOR_ID,
					   M_KURULUS.KURULUS_ADI,
					   PM_SEKTORLER.SEKTOR_ADI,
					   M_YETERLILIK.YETERLILIK_ID,
					   M_YETERLILIK.YETERLILIK_ADI,
					   M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID
	 			  FROM M_YETERLILIK
	              JOIN M_YETKI_YETERLILIK ON (M_YETERLILIK.YETERLILIK_ID=M_YETKI_YETERLILIK.YETERLILIK_ID)
	              JOIN M_YETKI ON (M_YETKI.YETKI_ID=M_YETKI_YETERLILIK.YETKI_ID)
	              JOIN M_KURULUS_YETKI ON (M_KURULUS_YETKI.YETKI_ID=M_YETKI.YETKI_ID)
	              JOIN M_KURULUS ON (M_KURULUS.USER_ID=M_KURULUS_YETKI.USER_ID)
	              JOIN PM_SEKTORLER ON (PM_SEKTORLER.SEKTOR_ID=M_YETERLILIK.SEKTOR_ID)
	             WHERE M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID<>-3 AND
			           M_YETKI.ETKIN=1 AND
			           M_YETKI.PROTOKOL_MU=1 AND
			           YETKI_TURU=2
	          ORDER BY KURULUS_ADI"; 
		$params = array();
		$datas  = $db->prep_exec($sql, $params);
		
		$result = array();
		foreach($datas as $data){
			if(!array_key_exists($data['SEKTOR_ID'], $result[$data['USER_ID']][$data['YETKI_ID']])){
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KURULUS_ADI']  = $data['KURULUS_ADI'];
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SEKTOR_ADI']  = $data['SEKTOR_ADI'];
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['PKS']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KTCD'] = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GA']   = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GDA']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['IEM']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SKA']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YKA']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YUG']  = 0;
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['RGY']  = 0;
			}
		
			if($data['YETERLILIK_SUREC_DURUM_ID'] == '0' || $data['YETERLILIK_SUREC_DURUM_ID'] == '-2' || $data['YETERLILIK_SUREC_DURUM_ID'] == '-4'){
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['KTCD']++;
					
			}else if($data[$data['USER_ID']]['YETERLILIK_SUREC_DURUM_ID'] == '4'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GA']++;
					
			}else if($data['YETERLILIK_SUREC_DURUM_ID'] == '6' || $data['YETERLILIK_SUREC_DURUM_ID'] == '7' || $data['YETERLILIK_SUREC_DURUM_ID'] == '8'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['GDA']++;
			}else if($data['YETERLILIK_SUREC_DURUM_ID'] == '-1' || $data['YETERLILIK_SUREC_DURUM_ID'] == '5' || $data['YETERLILIK_SUREC_DURUM_ID'] == '15'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['IEM']++;
			}else if($data['YETERLILIK_SUREC_DURUM_ID'] == '2' || $data['YETERLILIK_SUREC_DURUM_ID'] == '3' || $data['YETERLILIK_SUREC_DURUM_ID'] == '9' || $data['YETERLILIK_SUREC_DURUM_ID'] == '11'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['SKA']++;
			}else if($data['YETERLILIK_SUREC_DURUM_ID'] == '10' || $data['YETERLILIK_SUREC_DURUM_ID'] == '12'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YKA']++;
			}else if($data['YETERLILIK_SUREC_DURUM_ID'] == '1' || $data['YETERLILIK_SUREC_DURUM_ID'] == '13'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['YUG']++;
			}else if($data['YETERLILIK_SUREC_DURUM_ID'] == '14'){
					
				$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['RGY']++;
			}
			$result[$data['USER_ID']][$data['YETKI_ID']][$data['SEKTOR_ID']]['PKS']++;
		}
		
		return $result;
		
	}
	function istatistik_yeterlilik(){
	
	}
	
	function istatistik_protokol_standart(){

		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT M_YETKI.YETKI_ID,M_KURULUS.KURULUS_ADI,M_YETKI.IMZA_TARIHI,M_YETKI.BITIS_TARIHI,M_YETKI.SURESI,PM_SEKTORLER.SEKTOR_ADI,M_MESLEK_STANDARTLARI.STANDART_ID FROM M_YETKI 
					INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
					INNER JOIN M_YETKI_STANDART ON M_YETKI_STANDART.YETKI_ID = M_YETKI.YETKI_ID
					INNER JOIN M_MESLEK_STANDARTLARI ON M_MESLEK_STANDARTLARI.STANDART_ID = M_YETKI_STANDART.STANDART_ID
					INNER JOIN PM_SEKTORLER ON PM_SEKTORLER.SEKTOR_ID = M_MESLEK_STANDARTLARI.SEKTOR_ID
					INNER JOIN M_KURULUS ON M_KURULUS_YETKI.USER_ID = M_KURULUS.USER_ID
					WHERE M_YETKI.YETKI_TURU = 1 ORDER BY M_YETKI.YETKI_ID";
		$datas = $db->prep_exec($sql, array());
		
		foreach ($datas as $data){
			if(!array_key_exists($data['YETKI_ID'], $return)){
				$return[$data['YETKI_ID']]['YETERLILIK_SAYI'] = 0;
			}
			$return[$data['YETKI_ID']]['KURULUS_ADI'] = $data['KURULUS_ADI'];
			$return[$data['YETKI_ID']]['IMZA_TARIHI'] = $data['IMZA_TARIHI'];
			$return[$data['YETKI_ID']]['BITIS_TARIHI'] = $data['BITIS_TARIHI'];
			$return[$data['YETKI_ID']]['SURESI'] = $data['SURESI'];
			if(!in_array($data['SEKTOR_ADI'],$return[$data['YETKI_ID']]['SEKTORLER'])){
				$return[$data['YETKI_ID']]['SEKTORLER'][] = $data['SEKTOR_ADI'];
			}
			$return[$data['YETKI_ID']]['STANDART_SAYI']++;
		}
		
		return $return;
		
		
	}
	function istatistik_protokol_yeterlilik(){

		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT M_YETKI.YETKI_ID,M_KURULUS.KURULUS_ADI,M_YETKI.IMZA_TARIHI,M_YETKI.BITIS_TARIHI,M_YETKI.SURESI,PM_SEKTORLER.SEKTOR_ADI,M_YETERLILIK.YETERLILIK_ID
				 FROM M_YETKI 
					INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
					INNER JOIN M_YETKI_YETERLILIK ON M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID
					INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID
					INNER JOIN PM_SEKTORLER ON PM_SEKTORLER.SEKTOR_ID = M_YETERLILIK.SEKTOR_ID
					INNER JOIN M_KURULUS ON M_KURULUS_YETKI.USER_ID = M_KURULUS.USER_ID
					WHERE M_YETKI.YETKI_TURU = 2 ORDER BY M_YETKI.YETKI_ID";
		$datas = $db->prep_exec($sql, array());
		
		foreach ($datas as $data){
			if(!array_key_exists($data['YETKI_ID'], $return)){
				$return[$data['YETKI_ID']]['YETERLILIK_SAYI'] = 0;
			}
			$return[$data['YETKI_ID']]['KURULUS_ADI'] = $data['KURULUS_ADI'];
			$return[$data['YETKI_ID']]['IMZA_TARIHI'] = $data['IMZA_TARIHI'];
			$return[$data['YETKI_ID']]['BITIS_TARIHI'] = $data['BITIS_TARIHI'];
			$return[$data['YETKI_ID']]['SURESI'] = $data['SURESI'];
			if(!in_array($data['SEKTOR_ADI'],$return[$data['YETKI_ID']]['SEKTORLER'])){
				$return[$data['YETKI_ID']]['SEKTORLER'][] = $data['SEKTOR_ADI'];
			}
			$return[$data['YETKI_ID']]['YETERLILIK_SAYI']++;
		}
		
		return $return;
	}
}