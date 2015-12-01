<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class SinavModelTakvim_Ozet extends JModel {
	
    function getMerkezAdlari($db, $merkezIds){
    	
    	$soruStr = $this->getSoruStr($merkezIds);
    	
		$sql = "SELECT MERKEZ_ID, MERKEZ_ADI
					FROM M_SINAV_MERKEZI
				WHERE MERKEZ_ID IN ( ".$soruStr." )
					ORDER BY MERKEZ_ID ASC";
		 
		$merkezler = $db->prep_exec($sql, $merkezIds);
    	
		return $merkezler;
    }
    
    function getYetAdlari($db, $yetIds){
    	$yetler = array();
    	//$soruStr = $this->getSoruStr($yetIds);
		foreach($yetIds as $cows){
    	
		/*$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI
					FROM M_YETERLILIK
				WHERE YETERLILIK_ID IN ( ".$soruStr." )
					ORDER BY YETERLILIK_ID ASC";*/
			$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI
								FROM M_YETERLILIK
							WHERE YETERLILIK_ID = ?";
		
		$yetler[] = $db->prep_exec($sql, array($cows));
		}
		 
		return $yetler;
    }
    
    function getAltBirimAdlari_PdfIcin($db, $yetIds, $yeterlilik_idleri)
    {
    	$resultToReturn = array();
    	for($i=0; $i<count($yetIds); $i++)
    	{
    		$result = $db->prep_exec_array("SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID=?", array($yeterlilik_idleri[$i]));
    		$yeniMi = $result[0];
    		 
    		
    		$birimKodlari = explode(" ", $yetIds[$i]);
    		for($j=0; $j<count($birimKodlari); $j++)
    		{
    			$birimKodu = explode('_', $birimKodlari[$j]);
    			if($yeniMi == 1)
    			{
    				$sql = "SELECT DISTINCT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, OLC_DEG_HARF, OLC_DEG_NUMARA
    				FROM M_YETERLILIK_BIRIM
    				JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID)
    				JOIN M_BIRIM USING(BIRIM_ID)
    				WHERE ID = ? ";
    				$temp = $db->prep_exec($sql, array($birimKodu[0]));
    				if(count($temp)!=0)
    					$resultToReturn[$i][] = $temp[0];
    			}
    			else
    			{
    				$sql = "SELECT DISTINCT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO
    				FROM M_YETERLILIK_ALT_BIRIM
    				WHERE YETERLILIK_ALT_BIRIM_ID = ? ";
    				$temp = $db->prep_exec($sql, array($birimKodu[0]));
    				if(count($temp)!=0)
    				{
    					$temp[0]['OLCME_DEGERLENDIRME_KOD']=($birimKodu[1]=='0')?'T1':'P1';
    					$resultToReturn[$i][] = $temp[0];
    				}
    			}	
    			
    		}
    	}
    	
    	return $resultToReturn;
    	
    }
    
    function getAltBirimAdlari($db, $yetIds, $yeterlilik_idleri){
    	$yetler = array();
    	for($i=0; $i<count($yetIds); $i++)
    	{
    	$result = $db->prep_exec_array("SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID=?", array($yeterlilik_idleri[$i]));
    	$yeniMi = $result[0];
    	 
    	$say = 0;
    	for($j=0; $j<count($yetIds); $j++){
    		$altayir = $this->birimAyir($yetIds[$j]);
    
    		//if(strlen($altayir[1][0]) > 0)
    		if($yeniMi=='0')
    		{
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				$sql = "SELECT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO
    				FROM M_YETERLILIK_ALT_BIRIM
    				WHERE YETERLILIK_ALT_BIRIM_ID = ? ";
    				$yetler[$say][$ii] = $db->prep_exec($sql, array($altayir[0][$ii]));
    			}
    		}
    		else{
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				$sql = "SELECT ID, BIRIM_ID, BIRIM_ADI, BIRIM_KODU, OLC_DEG_ACIKLAMA, OLC_DEG_HARF, OLC_DEG_NUMARA
    				FROM M_YETERLILIK_BIRIM
    				JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID)
    				JOIN M_BIRIM USING(BIRIM_ID)
    				WHERE ID = ? ";
    				$yetler[$say][$ii] = $db->prep_exec($sql, array($altayir[0][$ii]));
    			}
    		}
    		$say++;
    	}
    	return $yetler;
    }
    }
    
    function getSekiller($db, $yetIds){
    	$say = 0;
    	foreach($yetIds as $rows){
    		$altayir = $this->birimAyir($rows);
    		 
    		if(strlen($altayir[1][0]) > 0){
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				
    				$sekiller[$say][$ii] = $altayir[1][$ii];
    			}
    		}
    		else{
    			for($ii = 0; $ii < count($altayir[0])-1; $ii++){
    				$sekiller[$say][$ii] = $altayir[1][$ii];
    			}
    		}
    		$say++;
    	}
    	return $sekiller;
    }
    
    private function birimAyir($altbirimler){
    	$butunbirimler = array();
    	$anabirimler = array();
    	$sekiller = array();
    	$birimler = explode(' ', $altbirimler);
    	foreach($birimler as $cows){
    		$birims = explode('_', $cows);
    		array_push($anabirimler, $birims[0]);
    		array_push($sekiller, $birims[1]);
    	}
    	array_push($butunbirimler, $anabirimler);
    	array_push($butunbirimler, $sekiller);
    	return $butunbirimler;
    }
    
    private function getSoruStr($array){
        $count = count($array);
    	$soruStr = '';
    	if($count > 0){
    		
    		$soruStr = '?';
    	
	    	for($i=1;$i<$count;$i++){
	    		$soruStr .= ',?';	
	    	}
    	
    	}
    	return $soruStr;
    }
    
    function getKurulusAdi($db, $userId){
    	$sql = "SELECT KURULUS_ADI FROM M_KURULUS WHERE USER_ID = ?";
    	return $db->prep_exec($sql, array($userId));
    }
}
?>

