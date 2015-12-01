<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/functions.php');

class AjaxModelAjax extends JModel {

	function getStandartSeviye (){
		$_db = JFactory::getOracleDBO();
		$sektorID = $_REQUEST['sektorID'];
		$tip = $_REQUEST['tip'];
		$taslak = $_REQUEST['taslak'];
        if ($tip=="meslek"){
            $sqlPart="m_meslek_standartlari";
            if ($taslak){
            	$sqlPart2="meslek_standart_durum_id in (-2,-1,0,1,2)";
            } else {
            	$sqlPart2="meslek_standart_durum_id =2";
            }
        } else {
            $sqlPart="m_yeterlilik";
            if ($taslak){
            	$sqlPart2="yeterlilik_durum_id in (-2,-1,0,1,2)";
            } else {
            	$sqlPart2="yeterlilik_durum_id =2";
            }
        }
		
		$sql = "SELECT distinct s.seviye_id,s.seviye_adi 
        FROM ".$sqlPart." m, pm_seviye s
        WHERE m.sektor_id=".$sektorID."
        AND m.seviye_id=s.seviye_id
        AND $sqlPart2
        ORDER by s.seviye_adi";
		$result = $_db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı');
	}

	function getStandart (){
		$_db = JFactory::getOracleDBO();
		$sektorID = $_REQUEST['sektorID'];
		$seviyeID = $_REQUEST['seviyeID'];
		$tip = $_REQUEST['tip'];
		$taslak = $_REQUEST['taslak'];
		if ($tip=="meslek"){
/*		$sql = "SELECT distinct m_taslak_meslek.taslak_meslek_id, m_meslek_standartlari.standart_adi 
        FROM m_meslek_standartlari , m_taslak_meslek 
        WHERE m_meslek_standartlari.sektor_id=".$sektorID."
        AND m_meslek_standartlari.seviye_id=".$seviyeID."
        AND m_meslek_standartlari.standart_id=m_taslak_meslek.standart_id
        ORDER by m_meslek_standartlari.standart_adi";
*/
		    if ($taslak){
            	$sqlPart2="meslek_standart_durum_id in (-2,-1,0,1,2)";
            } else {
            	$sqlPart2="meslek_standart_durum_id =2";
            }
            
			$sql = "SELECT 	taslak_meslek_ID,
        	STANDART_ADI,
        	SEVIYE_ADI, 
        	SEKTOR_ADI,meslek_standart_durum_id
        	FROM m_meslek_STANDARTLARI
			   	  JOIN pm_seviye USING (seviye_id)
			   	  JOIN pm_sektorler USING (sektor_id) 
			   	  JOIN m_taslak_meslek USING (standart_id) 
			   	  JOIN pm_meslek_standart_SUREC_DURUM USING (meslek_standart_SUREC_DURUM_id)  
			   WHERE 
         		".$sqlPart2." 
         		and sektor_id=".$sektorID."
         		and seviye_id=".$seviyeID."
			   ORDER BY STANDART_ADI";
        	        	 
        } else {
            if ($taslak){
            	$sqlPart2="yeterlilik_durum_id in (-2,-1,0,1,2)";
            } else {
            	$sqlPart2="yeterlilik_durum_id =2";
            }
        	
        	$sql = "SELECT 	YETERLILIK_ID,
						YETERLILIK_ADI,
						SEVIYE_ADI, 
						SEKTOR_ADI,yeterlilik_durum_id 
			   FROM m_yeterlilik 
			   	  JOIN pm_seviye USING (seviye_id)
			   	  JOIN pm_sektorler USING (sektor_id) 
			   	  JOIN pm_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_id)  
			   WHERE 
         		".$sqlPart2."
         		and sektor_id=".$sektorID."
         		and seviye_id=".$seviyeID."
			   ORDER BY yeterlilik_ADI";
        }

		$result = $_db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı');
	}


	function getTerim (){
		$_db = JFactory::getOracleDBO();
		$standartYeterlilikID = $_REQUEST['standartYeterlilikID'];
		$tip = $_REQUEST['tip'];
        if ($tip=="meslek"){
            $sqlPart="m_standart_taslak_terim";
            $neID="taslak_id";
		$sql= "SELECT m_terim.*
					   FROM M_TERIM,  m_standart_taslak_terim
			   WHERE m_standart_taslak_terim.taslak_id = ".$standartYeterlilikID." and 
               m_standart_taslak_terim.terim_id = M_TERIM.terim_id
			   ORDER BY M_TERIM.terim_adi";
        } else {
	        $sql= "SELECT m_terim.*
	        FROM M_TERIM,  m_yeterlilik_terim
	        WHERE m_yeterlilik_terim.yeterlilik_id = ".$standartYeterlilikID." and
	        m_yeterlilik_terim.terim_id = M_TERIM.terim_id
	        ORDER BY M_TERIM.terim_adi";
        }
        
		
		$result = $_db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı<br>'.$sql);
	}

	function getTerimAra (){
		$_db = JFactory::getOracleDBO();
//        $orj  = array ('İ','I','Ğ','Ü','Ş','Ö','Ç','ı','i','ğ','ü','ş','ç','ö');  
//        $conv = array ('İ','I','Ğ','Ü','Ş','Ö','Ç','I','İ','Ğ','Ü','Ş','Ç','Ö'); 
        $kelime  = iconv( 'UTF-8','ISO-8859-9', strtoupper($_REQUEST['veri'])); 
        $a=$_db->prep_exec_insert("alter session set NLS_COMP=LINGUISTIC", $params);
        $b=$_db->prep_exec_insert("alter session set NLS_SORT=BINARY_CI", $params);
		$sql= "SELECT *
					   FROM M_TERIM
			   WHERE terim_adi like '%".$kelime."%'
			   ORDER BY terim_adi";
		
		$result = $_db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı<br>'.$a.'-'.$b.'-', $result);
		else
			ajax_error_response('Kayıt bulunamadı<br>'.$a.'-'.$b.'-'.$sql);
	}

	function uyariTekrarGosterme(){
		$_db = &JFactory::getOracleDBO();
		$id = $_REQUEST['id'];
		
		$sql= "UPDATE m_uyarilar
		SET gormezden_gel = 1
		WHERE uyari_id = ?";
		
		$params = array ($id);
		
		return $_db->prep_exec_insert($sql, $params);
		
		ajax_success_response("Başarılı");
	}

	function uyariTumunuTemizle(){
		$_db = &JFactory::getOracleDBO();
		$id = $_REQUEST['id'];
		
		$sql= "UPDATE m_uyarilar
		SET gormezden_gel = 1
		WHERE to_user_id = ?";
		
		$params = array ($id);
		
		return $_db->prep_exec_insert($sql, $params);
		
		ajax_success_response("Başarılı");
	}

	
}
?>