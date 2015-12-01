<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

//require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class Meslek_Std_TaslakModelGorus_Listele extends JModel {
	
    function getGorusler($db, $standartId){
    	    	
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
					FROM M_MESLEK_STANDART_GORUS
						WHERE STANDART_ID = ? 
					ORDER BY GORUS_ID";
							
		$gorusler = $db->prep_exec($sql, array($standartId));
		

		return $gorusler;
    }

    //PDF'de butun hepsini gostermek icin
    function getGorusAyrinti ($db, $standartId){
    	$sql = "
    	SELECT GORUS_ID,
    		TO_CHAR(SON_GORUS_TARIH, 'dd.mm.yyyy')
				AS SON_GORUS_TARIH_FORMATTED,
			GORUS_BILDIREN,
			GORUS_E_POSTA,
			GORUS_TELEFON,
			GORUS_FAKS,
	    	SIRA_NO,
	    	STANDART_ADI,
	    	SEVIYE_ADI,
	    	TO_CHAR(SON_GORUS_TARIH, 'dd.mm.yyyy') AS SON_GORUS_TARIH,
	    	GORUS_BILDIREN,
	    	GORUS_E_POSTA,
	    	GORUS_TELEFON,
	    	GORUS_FAKS,
	    	STANDART_YERI,
	    	GORUS_VE_ONERILER,
	    	DEGERLENDIRME,
	    	DUZELTME
	    	FROM M_MESLEK_STANDART_GORUS
	    	LEFT JOIN M_MESLEK_STANDART_GORUS_MADDE USING (GORUS_ID)
	    	JOIN PM_SEVIYE USING (SEVIYE_ID)
	    	JOIN M_MESLEK_STANDARTLARI USING (STANDART_ID)
    		WHERE STANDART_ID=?
    		ORDER BY GORUS_ID
    	";
							
		$gorusler = $db->prep_exec($sql, array($standartId));
		
		
		foreach ($gorusler as &$gorus)
		{
			$sql = "SELECT KURULUS_ADI
			FROM M_MESLEK_STANDARTLARI
			JOIN M_YETKI_STANDART USING (STANDART_ID)
			JOIN M_KURULUS_YETKI USING (YETKI_ID)
			JOIN M_KURULUS USING (USER_ID)
			WHERE STANDART_ID=?";
		
			$kuruluslar = $db->prep_exec_array($sql, array($standartId));
			$gorus['KURULUS_ADI']=implode(', ', $kuruluslar);
			$gorus['KURULUS_ADI_ARRAY'] = $kuruluslar;
		}
		
		return $gorusler;
		
    }
}
?>
