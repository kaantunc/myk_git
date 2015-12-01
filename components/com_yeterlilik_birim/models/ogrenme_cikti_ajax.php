<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class Yeterlilik_BirimModelOgrenme_Cikti_Ajax extends JModel {
	
	function ajaxOgrenmeCiktisiSirasiGuncelle (){
		$_db = JFactory::getOracleDBO();
		$ogrenmeIDs  = $_REQUEST['ogrenme_ciktisi_id'];
			
		$sql = " UPDATE M_YETERLILIK_BIRIM_OGR_CIKTI
					 	SET SIRA_NO = ?
					 WHERE OGRENME_CIKTISI_ID = ?";
	
		$result = true;
		for($i = 1; $i <= count($ogrenmeIDs); $i++){
			$id = $ogrenmeIDs[$i-1];
			$result = $result && @$_db->prep_exec_insert($sql, array($i, $id));
		}
	
		return $result;
	}
	
	function ajaxBasarimOlcutuSirasiGuncelle (){
		$_db = JFactory::getOracleDBO();
		$basarimIDs  = $_REQUEST['basarim_olcutu_id'];
	
		$sql = " UPDATE M_YETERLILIK_BIRIM_BASARIM_OLC
					 	SET SIRA_NO = ?
					 WHERE BASARIM_OLCUTU_ID = ?";
	
		$result = true;
		for($i = 1; $i <= count($basarimIDs); $i++){
			$id = $basarimIDs[$i-1];
			$result = $result && @$_db->prep_exec_insert($sql, array($i, $id));
		}
	
		return $result;
	}
	
	//OGRENME CIKTISI
	function ajaxOgrenmeCiktisiEkle (){
		$_db = JFactory::getOracleDBO();
		$birimID = $_REQUEST['birimID'];
		$ogrenmeAdi = $_REQUEST['ogrenme_ciktisi'][0];
		$ogrenmeID = $_db->getNextVal(OGRENME_SEQ);
		$siraNo = $this->getNextOgrenmeSiraNo ($birimID);
	
		$sql = " INSERT INTO M_YETERLILIK_BIRIM_OGR_CIKTI
				 (OGRENME_CIKTISI_ID, YETERLILIK_BIRIM_ID, OGRENME_CIKTISI_ADI, SIRA_NO) VALUES 
				 (?, ?, ?, ?)";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($ogrenmeID, $birimID, $ogrenmeAdi, $siraNo))){
			ajax_success_response_with_array('Satır Başarıyla Kaydedildi.', array("ID" => $ogrenmeID, "siraNo" => $siraNo));
		}else{
			ajax_error_response('Hata Oluştu');
		}
	}
	
	function ajaxOgrenmeCiktisiGuncelle (){
		$_db = JFactory::getOracleDBO();
		$ogrenmeID  = $_REQUEST['ogrenme_ciktisi_id'][0];
		$ogrenmeAdi = $_REQUEST['ogrenme_ciktisi'][0];
	
		$sql = " UPDATE M_YETERLILIK_BIRIM_OGR_CIKTI
				 	SET OGRENME_CIKTISI_ADI = ?
				 WHERE OGRENME_CIKTISI_ID = ?";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($ogrenmeAdi, $ogrenmeID)))
			ajax_success_response('Satır Başarıyla Kaydedildi.');
		else
			ajax_error_response('Hata Oluştu');
	}
	
	function ajaxOgrenmeCiktisiSil (){
		$_db = JFactory::getOracleDBO();
		$ogrenmeID  = $_REQUEST['ogrenme_ciktisi_id'][0];
	
		//ILGILI BAGLAMLARI SIL
		//$result = $this->tumBaglamlariSil ($ogrenmeID);
		//ILGILI BASARIM OLCUTLERINI SIL
		//$result = $this->tumBasarimlariSil ($ogrenmeID);
	
		if ($result){
			$sql = "DELETE FROM M_YETERLILIK_BIRIM_OGR_CIKTI WHERE OGRENME_CIKTISI_ID = ?";
	
			//@ for disable error display
			if (@$_db->prep_exec_insert($sql, array($ogrenmeID))){
				ajax_success_response('Öğrenme Çıktısı Başarıyla Silindi.');
			}else{
				ajax_error_response('Hata Oluştu');
			}
		}else{
			ajax_error_response('İlgili Başarım Ölçütleri veya Bağlamlar Silinirken Hata Oluştu');
		}
	}
	
	function getNextOgrenmeSiraNo ($birimID){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT MAX(SIRA_NO) AS SIRA_NO
						FROM M_YETERLILIK_BIRIM_OGR_CIKTI
					WHERE YETERLILIK_BIRIM_ID = ?
					GROUP BY YETERLILIK_BIRIM_ID";
	
		$params = array ($birimID);
		$result = $db->prep_exec($sql, $params);
	
		return $result[0]["SIRA_NO"]+ 1;
	}
	
	//BASARIM OLCUTU
	function ajaxBasarimOlcutuEkle (){
		$_db = JFactory::getOracleDBO();
		$birimID = $_REQUEST['birimID'];
		$ogrenmeID = $_REQUEST['ogrenme_ciktisi_id'][0];
		$basarimAdi = $_REQUEST['basarim_olcutu'][0];
		$basarimID = $_db->getNextVal(BASARIM_SEQ);
		$siraNo = $this->getNextBasarimSiraNo ($ogrenmeID);
	
		$sql = " INSERT INTO M_YETERLILIK_BIRIM_BASARIM_OLC 
				 (BASARIM_OLCUTU_ID, OGRENME_CIKTISI_ID, BASARIM_OLCUTU_ADI, SIRA_NO, YETERLILIK_BIRIM_ID) VALUES 
				 (?, ?, ?, ?, ?)";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($basarimID, $ogrenmeID, $basarimAdi, $siraNo, $birimID))){
			$siraNoText = $this->getBasarimSiraNo ($basarimID);
			ajax_success_response_with_array('Satır Başarıyla Kaydedildi.', array("ID" => $basarimID, "siraNo" => $siraNoText));
		}else{
			ajax_error_response('Hata Oluştu');
		}
	}
	
	function ajaxBasarimOlcutuGuncelle (){
		$_db = JFactory::getOracleDBO();
		$basarimID  = $_REQUEST['basarim_olcutu_id'][0];
		$basarimAdi = $_REQUEST['basarim_olcutu'][0];
	
		$sql = " UPDATE M_YETERLILIK_BIRIM_BASARIM_OLC
				 	SET BASARIM_OLCUTU_ADI = ?
				 WHERE BASARIM_OLCUTU_ID = ?";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($basarimAdi, $basarimID)))
			ajax_success_response('Satır Başarıyla Kaydedildi.');
		else
			ajax_error_response('Hata Oluştu');
	}
	
	function ajaxBasarimOlcutuSil (){
		$_db = JFactory::getOracleDBO();
		$basarimID  = $_REQUEST['basarim_olcutu_id'][0];
	
		//ONCE ILGILI BAGLAMLARI SIL
		$result = $this->tumBaglamlariSil ($basarimID);
		
		if ($result){
			$sql = "DELETE FROM M_YETERLILIK_BIRIM_BASARIM_OLC WHERE BASARIM_OLCUTU_ID = ?";
		
			//@ for disable error display
			if (@$_db->prep_exec_insert($sql, array($basarimID))){
				ajax_success_response('Başarım Ölçütü Başarıyla Silindi.');
			}else{
				ajax_error_response('Hata Oluştu');
			}
		}else{
			ajax_error_response('İlgili Bağlamlar Silinirken Hata Oluştu');
		}
	}
	
	function getBasarimSiraNo ($basarimID){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT 	M_YETERLILIK_BIRIM_OGR_CIKTI.SIRA_NO AS OGR_SIRA_NO,
						M_YETERLILIK_BIRIM_BASARIM_OLC.SIRA_NO AS BAS_SIRA_NO
					FROM M_YETERLILIK_BIRIM_OGR_CIKTI
						 JOIN M_YETERLILIK_BIRIM_BASARIM_OLC USING (OGRENME_CIKTISI_ID)
				WHERE BASARIM_OLCUTU_ID = ?";
	
		$params = array ($basarimID);
		$result = $db->prep_exec($sql, $params);
	
		return $result[0]["OGR_SIRA_NO"].".".$result[0]["BAS_SIRA_NO"];
	}
	
	function getNextBasarimSiraNo ($ogrenmeID){
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT MAX(SIRA_NO) AS SIRA_NO 
					FROM M_YETERLILIK_BIRIM_BASARIM_OLC
				WHERE OGRENME_CIKTISI_ID = ?
				GROUP BY OGRENME_CIKTISI_ID";
	
		$params = array ($ogrenmeID);
		$result = $db->prep_exec($sql, $params);
	
		return $result[0]["SIRA_NO"]+ 1;
	}
	
	//BAGLAM
	function ajaxBaglamEkle (){
		$_db = JFactory::getOracleDBO();
		$birimID = $_REQUEST['birimID'];
		$basarimID = $_REQUEST['basarim_olcutu_id'][0];
		$baglamAdi = $_REQUEST['baglam'][0];
		$baglamID = $_db->getNextVal(BAGLAM_SEQ);
	
		$sql = " INSERT INTO M_YETERLILIK_BIRIM_BAGLAM
				 (BAGLAM_ID, BASARIM_OLCUTU_ID, BAGLAM_ADI, YETERLILIK_BIRIM_ID) VALUES 
				 (?, ?, ?, ?)";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($baglamID, $basarimID, $baglamAdi, $birimID))){
			$siraNo = $this->getBasarimSiraNo ($basarimID);
			ajax_success_response_with_array('Satır Başarıyla Kaydedildi.', array("ID" => $baglamID, "siraNo" => $siraNo));
		}else{
			ajax_error_response('Hata Oluştu');
		}
	}
	
	function ajaxBaglamGuncelle (){
		$_db = JFactory::getOracleDBO();
		$baglamID  = $_REQUEST['baglam_id'][0];
		$baglamAdi = $_REQUEST['baglam'][0];
	
		$sql = " UPDATE M_YETERLILIK_BIRIM_BAGLAM
				 	SET BAGLAM_ADI = ?
				 WHERE BAGLAM_ID = ?";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($baglamAdi, $baglamID)))
			ajax_success_response('Satır Başarıyla Kaydedildi.');
		else
			ajax_error_response('Hata Oluştu');
	}
	
	function ajaxBaglamSil (){
		$_db = JFactory::getOracleDBO();
		$baglamID  = $_REQUEST['baglam_id'][0];
	
		$sql = " DELETE FROM M_YETERLILIK_BIRIM_BAGLAM WHERE BAGLAM_ID = ?";

		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($baglamID)))
			ajax_success_response('Bağlam Başarıyla Silindi.');
		else
			ajax_error_response('Hata Oluştu');
	}
	
	function tumBaglamlariSil ($basarimID){
		$_db = JFactory::getOracleDBO();
		$sql = " DELETE FROM M_YETERLILIK_BIRIM_BAGLAM WHERE BASARIM_OLCUTU_ID = ?";
		return $_db->prep_exec_insert($sql, array($basarimID));
	}
	
}
?>