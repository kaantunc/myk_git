<?php
error_reporting(E_ALL);
@ini_set("display_errors","1");

defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class Meslek_Std_TaslakModelAjax extends JModel {

    function Standart_Taslak_Terim_Ajax()
    {
        
    }
    
	function ajaxTaslakTerimGetir (){
		$_db = JFactory::getOracleDBO();
		$terimIds = $_REQUEST['terimIds'];
        $terimIds=explode(",",$terimIds);
        $sql2="";

		$sql = "SELECT *
					   FROM M_TERIM
			   WHERE terim_id in (";
       for ($i=0;$i<count($terimIds);$i++){
        $sql2.="'".$terimIds[$i]."',";
       }        
        $sql.=substr($sql2,0,-1);       
        $sql.= ")
			   ORDER BY terim_adi";

		$result = $_db->prep_exec($sql, array());
				
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı-'.$sql);
	}

	function ajaxYonetimKuruluGetir (){
		$db = JFactory::getOracleDBO();
        $tarih= $_REQUEST['tarih'];
		$sql = "SELECT *
				FROM M_YONETIM_KURULU
                WHERE tarih='".$tarih."'
                AND etkin='1'
                ORDER BY SIRA";
//                echo $sql;
		$result = $db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı-'.$sql);
	}
	
	function ajaxGenelKurulGetir (){
		$db = JFactory::getOracleDBO();
        $tarih= $_REQUEST['tarih'];
		$sql = "SELECT DISTINCT KURUM
				FROM M_GENEL_KURUL
                WHERE tarih='".$tarih."'";
//                echo $sql;
		$result = $db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı-'.$sql);
	}
	
	function ajaxKomiteGetir (){
		$db = JFactory::getOracleDBO();
        $tarih= $_REQUEST['tarih'];
        $sektor_id=$_REQUEST["sektor_id"];

		$sql = "SELECT *
				FROM M_SEKTOR_KOMITELERI
                WHERE tarih='".$tarih."'
                AND sektor_id='".$sektor_id."'
                ORDER BY SIRA";
//                echo $sql;
		$result = $db->prep_exec($sql, array());
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı-'.$sql);
	}
	
	
}
?>