<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries'.DS.'form'.DS.'form.php');

class Meslek_Std_TaslakModelGorus_Kaydet extends JModel {

    function gorusKaydet($db, $data) {

		$standartId = $data['standartId'];
		$seviyeId = $data['seviyeId'];
		$son_gorus_tarihi = $data['son_gorus_tarihi'];
		$unvan = $data['unvan'];
		$e_posta = $data['e_posta'];
		$telefon = $data['telefon'];
		$faks = $data['faks'];
		
		$gorusId = $db->getNextVal('GORUS_ID_SEQ');
				
		//echo "gorusId: $gorusId<br />";
		
		$gorusSql = "INSERT INTO M_MESLEK_STANDART_GORUS
			VALUES(?, ?, ?, TO_DATE(?, 'dd.mm.yyyy'), ?, ?, ?, ?)";
		
		$params = array($gorusId,
						$standartId,
						$seviyeId,
						$son_gorus_tarihi,
						$unvan,
						$e_posta,
						$telefon,
						$faks);
						
		$db->prep_exec_insert($gorusSql, $params);

//			echo 'gorusler: <pre>';
//			print_r($params);	
//			echo '</pre>';	
		
		$bilgiValues = FormFactory::getTableValues($data, array("gorusTable", 5));
		
		$gorusMaddeSql = "INSERT INTO M_MESLEK_STANDART_GORUS_MADDE
			VALUES(?, ?, ?, ?, ?, ?)";
		
    	$valCount = count($bilgiValues);
		//echo "-$valCount-";
		for($i=0;$i<$valCount;$i += 5)
		{
			
			$postVals = array_slice($bilgiValues, $i, 5);
			
			array_splice($postVals, 0, 0, $gorusId);

//			echo 'bilgi values: <pre>';
//			print_r($postVals);	
//			echo '</pre>';	
			
			$db->prep_exec_insert($gorusMaddeSql, $postVals);
			
			//return "Sınav takviminiz eklenmştir.";
			
		}
		return "Görüş ve katkılarınız için teşekkür ederiz.";
    }
    
    function gorusCevapla($db, $data) {
		
		$gorusId = $data['gorusId'];
		
		if(!$this->canEdit($db, $gorusId))
			return "olmadı";
		
//			echo 'bilgi values: <pre>';
//			print_r($data);	
//			echo '</pre>';	
		
		$gorusMaddeSql = "UPDATE M_MESLEK_STANDART_GORUS_MADDE
				SET DEGERLENDIRME = ?,
					DUZELTME = ?
			WHERE GORUS_ID = ? AND SIRA_NO = ?";
		
		for($i=1;isset($data['degerlendirme_' . $i]);$i++){
			
			$params = array($data['degerlendirme_' . $i],
							$data['duzeltme_' . $i],
							$gorusId,
							$i
			);
			
//			echo 'params: <pre>';
//			print_r($params);	
//			echo '</pre>';	
			
			$db->prep_exec_insert($gorusMaddeSql, $params);
		}
		
		//die();
		return "Görüş ve öneriler için yaptığınız değerlendirme ve düzenlemeler kaydedilmiştir.";
    }
    

    function canEdit($db, $gorusId){
    	
    	$userId =& JFactory::getUser()->getOracleUserId();
    	    	
		$sql = "SELECT *
		FROM M_MESLEK_STANDARTLARI
		JOIN M_YETKI_STANDART USING (STANDART_ID)
		JOIN M_MESLEK_STANDART_GORUS USING (STANDART_ID)
		JOIN M_KURULUS_YETKI USING (YETKI_ID)
		WHERE GORUS_ID = ? AND USER_ID=?";
							
		$userIdRows = $db->prep_exec($sql, array($gorusId, $userId));
		
		if(count($userIdRows)>0)
			return true;
		else
			return false;
    	
    	
    }
}
?>
