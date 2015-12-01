<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class Protokol_YetModelProtokol_Ajax extends JModel {

	function ajaxUzatmaKaydet (){
		$_db = JFactory::getOracleDBO();
		$columns = array();
		//DB Columns
		$dbParams = array('protokolID', 'uzatmaAciklama');
		 
		$id = $_db->getNextVal(UZATMA_SEQ);
	
		foreach ($dbParams as $key ) {
			if(isset($_REQUEST[$key]))
				$columns[] = $_REQUEST[$key];
		}
		
		$columns[] = FormParametrik::harfleriTexttenCikar($_REQUEST['uzatmaSuresi']);
		$columns[] = $id;
	
		$sql = " INSERT INTO m_protokol_sure_uzatma (protokol_id, aciklama, uzatma_suresi, uzatma_id)
					 VALUES (?, ?, ?, ?)";
		
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns)){
			ajax_success_response('Satırlar Başarıyla Kaydedilmiştir.', $id);
		}
		else{
			ajax_error_response('Hata Oluştu');
		}
	}
	
	function ajaxUzatmaGuncelle (){	
		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];
		
		$columns = array();
	
		//DB Columns
		$dbParams = array('uzatmaSuresi', 'uzatmaAciklama', 'protokolID');
	
		foreach ($dbParams as $key ) {
			if(isset($_REQUEST[$key]))
			$columns[] = $_REQUEST[$key];
		}
		
		$columns[] = $id;
		
		$sql = " UPDATE m_protokol_sure_uzatma
				 	SET uzatma_suresi = ?,
				 		aciklama = ? 
				 WHERE protokol_id = ? AND uzatma_id = ?";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns)){
			ajax_success_response('Satır Başarıyla Kaydedilmiştir.');
		}else{
			ajax_error_response('Hata Oluştu');
		}
	}
	
	function ajaxUzatmaSil (){
		$protokolID = $_REQUEST['protokolID'];
		
		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];
		
		$sql = "DELETE FROM m_protokol_sure_uzatma WHERE protokol_id = ? AND uzatma_id = ?";
	
		if (@$_db->prep_exec_insert($sql, array($protokolID, $id))){
			ajax_success_response('Satır Başarıyla Kaydedilmiştir.');
		}
		else{
			ajax_error_response('Hata Oluştu');	
		}
	}
}
?>