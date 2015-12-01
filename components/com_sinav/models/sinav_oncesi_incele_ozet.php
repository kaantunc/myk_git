<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class SinavModelSinav_Oncesi_Incele_Ozet extends JModel {

    function getMerkezAdi($db, $postData){
    	
		$sql = "SELECT MERKEZ_ADI
					FROM M_SINAV_MERKEZI
				WHERE MERKEZ_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['sinav_yeri']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    function getYetAdi($db, $postData){
    	
		$sql = "SELECT YETERLILIK_ADI
					FROM M_YETERLILIK
				WHERE YETERLILIK_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['yeterlilik_konusu']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    function getTurAdi($db, $postData){
    	
		$sql = "SELECT SINAV_TUR_ADI
					FROM PM_SINAV_TURU
				WHERE SINAV_TUR_ID = ?";
		$yetkiNo = $db->prep_exec_array($sql,array($postData['sinav_turu']));

		if(!empty($yetkiNo))
			return $yetkiNo[0];
		else
			return false;
    
	}
	
    function getSekilAdi($db, $postData){
    	$sonuc = null;
    	$birimliste = array();
    	$sekilliste = array();
    	$sinavBirimler = $postData['sinav_sekli'];
		$birimler = explode(' ', $sinavBirimler);
		for($ii = 0; $ii < count($birimler); $ii++){
			$anabirim = explode('_', $birimler[$ii]);
			array_push($birimliste, $anabirim[0]);
			array_push($sekilliste, $anabirim[1]);	
		}
		if($sekilliste[0] == null){
			foreach($birimliste as $row){
			$sql = "SELECT ID,BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF, OLC_DEG_NUMARA 
				FROM M_BIRIM JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) 
				WHERE ID = ?
				ORDER BY ID";
			
			$yetkiNo[] = $db->prep_exec($sql,array($row));
			}
			if(!empty($yetkiNo)){
				for($jj = 0; $jj<count($yetkiNo); $jj++){
					$sonuc .= $yetkiNo[$jj][0]['ID'].'	-	'.$yetkiNo[$jj][0]['BIRIM_ADI'].$yetkiNo[$jj][0]['BIRIM_KODU'].$yetkiNo[$jj][0]['OLC_DEG_HARF'].$yetkiNo[$jj][0]['OLC_DEG_NUMARA'].'</br>';
					//$sonuc .= '<div style ="width:100%; float:left;">'.$yetkiNo[$jj][0]['ID'].'	-	'.$yetkiNo[$jj][0]['BIRIM_ADI'].$yetkiNo[$jj][0]['BIRIM_KODU'].$yetkiNo[$jj][0]['OLC_DEG_HARF'].$yetkiNo[$jj][0]['OLC_DEG_NUMARA'].'</div>';
				}
				return $sonuc;
			}
			else
			return false;
		}
		else{
			foreach($birimliste as $row){
				$sql = "SELECT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO
									FROM M_YETERLILIK_ALT_BIRIM
								WHERE YETERLILIK_ALT_BIRIM_ID = ?";
				
				$yetkiNo[] = $db->prep_exec($sql,array($row));
			}
			if(!empty($yetkiNo)){
				for($jj = 0; $jj<count($yetkiNo); $jj++){
					if($sekilliste[$jj] == 0)
						$sonuc .= $yetkiNo[$jj][0]['YETERLILIK_ALT_BIRIM_NO'].'	-	'.$yetkiNo[$jj][0]['YETERLILIK_ALT_BIRIM_ADI'].'	(Teorik)<br>';
					else
					$sonuc .= $yetkiNo[$jj][0]['YETERLILIK_ALT_BIRIM_NO'].'	-	'.$yetkiNo[$jj][0]['YETERLILIK_ALT_BIRIM_ADI'].'	(Pratik)<br>';
				}
				return $sonuc;
			}
			else
			return false;
		}
		
		
	}
	
	function getPdfSekilAdi($db, $postData){
		$sonuc = null;
		$birimliste = array();
		$sekilliste = array();
		$sinavBirimler = $postData['sinav_sekli'];
		$birimler = explode(' ', $sinavBirimler);
		for($ii = 0; $ii < count($birimler); $ii++){
			$anabirim = explode('_', $birimler[$ii]);
			array_push($birimliste, $anabirim[0]);
			array_push($sekilliste, $anabirim[1]);
		}
		if($sekilliste[0] == null){
			foreach($birimliste as $row){
				$sql = "SELECT ID,BIRIM_ADI, BIRIM_KODU, OLC_DEG_HARF, OLC_DEG_NUMARA
					FROM M_BIRIM JOIN M_BIRIM_OLCME_DEGERLENDIRME USING(BIRIM_ID) 
					WHERE ID = ?
					ORDER BY ID";
					
				$yetkiNo[] = $db->prep_exec($sql,array($row));
			}
			if(!empty($yetkiNo)){
				for($jj = 0; $jj<count($yetkiNo); $jj++){
					//$sonuc .= $yetkiNo[$jj][0]['ID'].'	-	'.$yetkiNo[$jj][0]['BIRIM_ADI'].$yetkiNo[$jj][0]['BIRIM_KODU'].$yetkiNo[$jj][0]['OLC_DEG_HARF'].$yetkiNo[$jj][0]['OLC_DEG_NUMARA'].'</br>';
					$sonuc .= '<div style ="width:100%; float:left;">'.$yetkiNo[$jj][0]['ID'].'	-	'.$yetkiNo[$jj][0]['BIRIM_ADI'].$yetkiNo[$jj][0]['BIRIM_KODU'].$yetkiNo[$jj][0]['OLC_DEG_HARF'].$yetkiNo[$jj][0]['OLC_DEG_NUMARA'].'</div>';
				}
				return $sonuc;
			}
			else
			return false;
		}
		else{
			foreach($birimliste as $row){
				$sql = "SELECT YETERLILIK_ALT_BIRIM_ID, YETERLILIK_ALT_BIRIM_ADI
										FROM M_YETERLILIK_ALT_BIRIM
									WHERE YETERLILIK_ALT_BIRIM_ID = ?";
	
				$yetkiNo[] = $db->prep_exec($sql,array($row));
			}
			if(!empty($yetkiNo)){
				for($jj = 0; $jj<count($yetkiNo); $jj++){
					if($sekilliste[$jj] == 0)
					$sonuc .= '<div style ="width:100%; float:left;">'.$birimler[$jj].'	-	'.$yetkiNo[$jj][0]['YETERLILIK_ALT_BIRIM_ADI'].'	(Teorik)</div>';
					else
					$sonuc .= '<div style ="width:100%; float:left;">'.$birimler[$jj].'	-	'.$yetkiNo[$jj][0]['YETERLILIK_ALT_BIRIM_ADI'].'	(Pratik)</div>';
				}
				return $sonuc;
			}
			else
			return false;
		}
	
	
	}

}
?>