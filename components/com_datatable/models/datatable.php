<?php
defined('_JEXEC') or die('Restricted access');

include_once 'functions.php';

class DatatableModelDatatable extends JModel {

	function getDataFromDB (){
		$_db = JFactory::getOracleDBO();
		
		$sql = "SELECT ID,COLUMN1,COLUMN2,COLUMN3,COLUMN4,COLUMN5
				FROM A_DENEME";
		
		return $_db->prep_exec($sql, array());
	}
	
	function ajaxSaveRow (){
		$_db = JFactory::getOracleDBO();
		$columns = array();
		//DB Columns
		$dbParams = array('column1','column2' ,'column3' ,'column4', 'column5' );
		
		$id = $_db->getNextVal('BELGE_NO_SEQ');
		$columns[] = $id;
		
		foreach ($dbParams as $key ) {
			if(isset($_POST[$key]))
			$columns[] = $_POST[$key];
		}
		
		$sql = " INSERT INTO a_deneme (id, column1, column2, column3, column4, column5)
				 VALUES (?, ?, ?, ?, ?, ?)";

		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns))
			ajax_success_response('Satır başarıyla kaydedilmiştir.', $id);
		else
			ajax_error_response('Satır eklerken beklenmedik bir hata oluştu');
	}

	function ajaxEditRow (){
		$_db = JFactory::getOracleDBO();
		$columns = array();
		
		//DB Columns
		$dbParams = array('column1','column2' ,'column3' ,'column4', 'column5', 'id' );
		
		foreach ($dbParams as $key ) {
			if(isset($_POST[$key]))
			$columns[] = $_POST[$key];
		}
		
		$sql = " UPDATE a_deneme
				 	SET column1 = ?,
				 		column2 = ?,
				 		column3 = ?,
				 		column4 = ?,
				 		column5 = ?
				 WHERE id = ?";

		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns))
			ajax_success_response('Satır başarıyla kaydedilmiştir.');
		else
			ajax_error_response('Satır güncellenirken beklenmedik bir hata oluştu');
	}

	function ajaxDeleteRow (){
		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];
		
		$sql = " DELETE FROM a_deneme WHERE id = ?";

		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($id)))
			ajax_success_response('Satır başarıyla silindi.');
		else
			ajax_error_response('Satır silinirken beklenmedik bir hata oluştu');
	}
}

?>