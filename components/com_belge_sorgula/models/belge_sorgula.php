<?php
defined('_JEXEC') or die('Restricted access');

class Belge_SorgulaModelBelge_Sorgula extends JModel {
	
	function getBelgeDataByTcKimlikNo ($tckimlikno){
		$_db = JFactory::getOracleDBO ();
		
		$sql = " SELECT *
				 FROM M_BELGE_SORGU
				 WHERE TCKIMLIKNO = ?";
		
		$params = array ($tckimlikno);
		
		return $_db->prep_exec($sql, $params);
	}
}
?>