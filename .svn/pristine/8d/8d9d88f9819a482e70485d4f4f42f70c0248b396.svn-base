<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class Birim_YonetimiModelBirim_Yonetimi_Ajax extends JModel {

	function ajaxAddNewBirim (){
		/*OK	*/
		$_db = JFactory::getOracleDBO();
		$columns = array();
		//DB Columns
		$dbParams = array(	'yeniBirimEklePopup_BirimAdiTextBox', 
							'yeniBirimEklePopup_ReferansKoduTextBox', 
							'yeniBirimEklePopup_SeviyeTextBox' 
							//'yeniBirimEklePopup_YayınTarihiTextBox',
							//'yeniBirimEklePopup_RevizyonNoTextBox'
				);
		 
		$id = $_db->getNextVal('BIRIM_ID_seq');
		$columns[] = $id;
	
		foreach ($dbParams as $key ) {
			if(isset($_REQUEST[$key]))
			$columns[] = $_REQUEST[$key];
		}
	
		$sql = " INSERT INTO M_BIRIM (BIRIM_ID, BIRIM_ADI, BIRIM_KODU, BIRIM_SEVIYE, BAGIMSIZMI, BIRIM_ONAY_DURUM) 
					 VALUES (?, ?, ?, ?, 1,".PM_BIRIM_ONAY_DURUMU__SSNA_YOLLANMAMIS.")";//BIRIM_YAYIN_TAR, BIRIM_REV_NO,
		
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns))
		{
			$array = $_db->prep_exec("SELECT * FROM m_birim, pm_birim_onay_durumu WHERE m_birim.birim_onay_durum = pm_birim_onay_durumu.durum_id", array());
			ajax_success_response_with_array("Başarıyla Kaydedildi", $array);
			
		}
		else
		{
			ajax_error_response('Bir Hata Oluştu');
		}
		
		
	}
	
	
}
?>