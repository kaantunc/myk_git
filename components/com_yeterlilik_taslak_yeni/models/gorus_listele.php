<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Yeterlilik_TaslakModelGorus_Listele extends JModel {
	
    function getGorusler($db, $yeterlilikId){
    	    	
//    	echo '******<pre>';
//    	print_r($standartId);
//    	echo '</pre>******';
    	
		$sql = "SELECT  GORUS_ID,
						TO_CHAR(SON_GORUS_TARIH, 'dd.mm.yyyy')
								AS SON_GORUS_TARIH_FORMATTED,
						GORUS_BILDIREN,
						GORUS_E_POSTA,
						GORUS_TELEFON,
						GORUS_FAKS
					FROM M_YETERLILIK_GORUS
						WHERE YETERLILIK_ID = ? 
					ORDER BY GORUS_ID";
							
		$gorusler = $db->prep_exec($sql, array($yeterlilikId));
		

		return $gorusler;
    }
    
    //PDF'de butun hepsini gostermek icin
    function getGorusAyrinti ($db, $yeterlilikId){
    	/*$sql = "SELECT  GORUS_ID,
    					SIRA_NO, 
    					KURULUS_ADI, 
    					YETERLILIK_ADI,
    					SEVIYE_ADI,
    					TO_CHAR(SON_GORUS_TARIH, 'dd.mm.yyyy') AS SON_GORUS_TARIH,
    					GORUS_BILDIREN,
    					GORUS_E_POSTA,
    					GORUS_TELEFON,
    					GORUS_FAKS,
    					YETERLILIK_YERI,
    					GORUS_VE_ONERILER,
    					DEGERLENDIRME,
    					DUZELTME     					  
				FROM M_YETERLILIK_GORUS  
					JOIN M_YETERLILIK_GORUS_MADDE USING (GORUS_ID) 
					JOIN PM_SEVIYE USING (SEVIYE_ID) 
					JOIN M_YETERLILIK USING (YETERLILIK_ID) 
					JOIN M_YETERLILIK_EVRAK USING (YETERLILIK_ID) 
					JOIN M_BASVURU USING (EVRAK_ID) 
					JOIN M_KURULUS USING (USER_ID) 
				WHERE YETERLILIK_ID = ? 
					ORDER BY GORUS_ID, SIRA_NO";
					*/
    	$sql = "SELECT GORUS_ID,
	    	SIRA_NO,
	    	YETERLILIK_ADI,
	    	SEVIYE_ADI,
	    	TO_CHAR(SON_GORUS_TARIH, 'dd.mm.yyyy') AS SON_GORUS_TARIH,
	    	GORUS_BILDIREN,
	    	GORUS_E_POSTA,
	    	GORUS_TELEFON,
	    	GORUS_FAKS,
	    	YETERLILIK_YERI,
	    	GORUS_VE_ONERILER,
	    	DEGERLENDIRME,
	    	DUZELTME
	    	FROM M_YETERLILIK_GORUS
	    	LEFT JOIN M_YETERLILIK_GORUS_MADDE USING (GORUS_ID)
	    	JOIN PM_SEVIYE USING (SEVIYE_ID)
	    	JOIN M_YETERLILIK USING (YETERLILIK_ID)
    		WHERE YETERLILIK_ID=?";
							
		$gorusler = $db->prep_exec($sql, array($yeterlilikId));
		
		foreach ($gorusler as &$gorus)
		{
			$sql = "SELECT KURULUS_ADI 
			FROM M_YETERLILIK 
			JOIN M_YETKI_YETERLILIK USING (YETERLILIK_ID) 
			JOIN M_KURULUS_YETKI USING (YETKI_ID) 
			JOIN M_KURULUS USING (USER_ID)
			WHERE YETERLILIK_ID=?";
				
			$kuruluslar = $db->prep_exec_array($sql, array($yeterlilikId));
			$gorus['KURULUS_ADI']=implode(', ', $kuruluslar);
			$gorus['KURULUS_ADI_ARRAY'] = $kuruluslar;
		}
		
		return $gorusler;
		
    }

}
?>
