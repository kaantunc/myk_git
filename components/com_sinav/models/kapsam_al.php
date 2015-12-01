<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class SinavModelKapsam_Al extends JModel {

    function getKapsamlar($db, $postData){
    	
    	$yetId = isset($postData['yetId']) ? $postData['yetId'] : null;
    	    	
    	$id = isset($postData['inpId']) ? $postData['inpId'] : null;
    	
    	//echo "id: -$id-";
    			
		$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?";
		 
		$kapsamlar = $db->prep_exec($sql, array($yetId));
		
		$comboText = '';
		$isFirst = true;
		
		if(isset($kapsamlar)){
		foreach ($kapsamlar as $row){
			if($isFirst){
				if($id != null){
					$comboText .= $id."**";
				}
				$comboText .= $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
				$isFirst = false;
			}
			else
				$comboText .= "**". $row["YETERLILIK_ALT_BIRIM_ID"] . "##". $row["YETERLILIK_ALT_BIRIM_ADI"];
		}
			//$comboText.="**Başarısız##Başarısız";
		}
		
			echo $comboText;
			
			die();
    	
    }

}
?>
