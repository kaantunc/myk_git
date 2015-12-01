<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class Yeterlilik_BirimModelYeterlilik_Birim_Ajax extends JModel {

	function ajaxFetchExistingStandart (){
		$_db = JFactory::getOracleDBO();
		$birimID = $_REQUEST['birimID'];
		
		if(isset($_REQUEST['seviyeID']) && $_REQUEST['seviyeID']!=0)
			$seviyeText = " pm_seviye.seviye_id = ".$_REQUEST['seviyeID'];
		if(isset($_REQUEST['sektorID']) && $_REQUEST['sektorID']!=0)
			$sektorText = " pm_sektorler.sektor_id = ".$_REQUEST['sektorID'];
		if(isset($seviyeText) && isset($sektorText))
			$andText = " AND ";

		$sql = "SELECT 	m_meslek_standartlari.STANDART_ID,
							m_meslek_standartlari.STANDART_ADI, 
							pm_seviye.SEVIYE_ADI,
							pm_sektorler.SEKTOR_ADI,
							m_meslek_standartlari.STANDART_KODU,
							pm_meslek_standart_surec_durum.STANDART_SUREC_DURUM_ADI		
					FROM  m_meslek_standartlari, pm_seviye, pm_sektorler, pm_meslek_standart_surec_durum  
					WHERE m_meslek_standartlari.STANDART_ID NOT IN (SELECT NVL(STANDART_ID,-1) AS STANDART_ID FROM m_yeterlilik_birim_kaynak WHERE YETERLILIK_BIRIM_ID=".$birimID.")
						AND m_meslek_standartlari.meslek_standart_durum_id IN (".PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART.") 
						AND m_meslek_standartlari.meslek_standart_surec_durum_id NOT IN (".REDDEDILMIS_STANDART.")  
						AND m_meslek_standartlari.seviye_id = pm_seviye.seviye_id 
						AND m_meslek_standartlari.meslek_standart_surec_durum_id = pm_meslek_standart_surec_durum.meslek_standart_surec_durum_id
						AND m_meslek_standartlari.sektor_id = pm_sektorler.sektor_id 
						AND ".$seviyeText.$andText.$sektorText;

		@$result = $_db->prep_exec($sql, array());
				
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı');
	}
	
	function ajaxAddFromVarolanStandartlar (){
		$_db = JFactory::getOracleDBO();
		$eklenecekStandartlar = $_REQUEST['varolanStandartlarCheckbox'];
		$birimID = $_REQUEST['birimID'];	
		$kaynakID = $_db->getNextVal(KAYNAK_SEQ);
		
		$result = true;
		for($i=0; $i<count($eklenecekStandartlar); $i++)
		{
			$sql = "INSERT INTO m_yeterlilik_birim_kaynak(KAYNAK_ID, YETERLILIK_BIRIM_ID, STANDART_ID, KAYNAK_ACIKLAMA, KAYNAK_TUR_ID) VALUES (?,?,?,?,?)";
			$result = $result && $_db->prep_exec_insert($sql, array($kaynakID, $birimID, $eklenecekStandartlar[$i],'', KAYNAK_STANDART_TUR));
		}
		
		if($result)
		{
			// RESULT TRUE, BASARILI, YENI STANDARTLARI ARRAYA KOY YOLLA
			$sql = "SELECT	KAYNAK_ID,
							YETERLILIK_BIRIM_ID,
							KAYNAK_ACIKLAMA,
							KAYNAK_TUR_ID,
							STANDART_KODU,
							STANDART_ADI,
							STANDART_ID,
							SEVIYE_ADI
					FROM m_yeterlilik_birim_kaynak
			             LEFT JOIN m_meslek_standartlari USING (standart_id)
			             LEFT JOIN pm_seviye USING (seviye_id)
					WHERE yeterlilik_birim_id = ?";
			
			$params = array ($birimID);
			$kaynak = $_db->prep_exec($sql, $params);

			///////////////////////////
			ajax_success_response_with_array('Başarılı', $kaynak);
		}
		else
			ajax_error_response('Başarısız');
	}
	
	function ajaxKaynakKaydet (){
		$_db = JFactory::getOracleDBO();
		$aciklama = $_REQUEST['aciklama'];
		$birimID = $_REQUEST['birimID'];	
		$kaynakID = $_db->getNextVal(KAYNAK_SEQ);
	
		$sql = "INSERT INTO m_yeterlilik_birim_kaynak(KAYNAK_ID, YETERLILIK_BIRIM_ID, STANDART_ID, KAYNAK_ACIKLAMA, KAYNAK_TUR_ID) VALUES (?,?,?,?,?)";
		
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($kaynakID, $birimID, NULL, $aciklama, KAYNAK_STANDART_TUR)))
		{
			ajax_success_response('Satır Başarıyla Kaydedildi.', $kaynakID);
		}
		else
		{
			ajax_error_response('Kaynak Standart Eklenirken Sistemde bir Hata Oluştu');
		}
	}
	
	function ajaxKaynakGuncelle (){
		$_db = JFactory::getOracleDBO();
		$birimID  = $_REQUEST['birimID'];
		$kaynakID = $_REQUEST['id'];
		$aciklama = $_REQUEST['aciklama'];

		$sql = " UPDATE m_yeterlilik_birim_kaynak
				 	SET kaynak_aciklama = ?
				 WHERE kaynak_id = ? AND yeterlilik_birim_id = ?";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($aciklama, $kaynakID, $birimID)))
			ajax_success_response('Satır Başarıyla Kaydedildi.');
		else
			ajax_error_response('Hata Oluştu');
	}
	
	function ajaxKaynakSil (){
		$_db = JFactory::getOracleDBO();
		$kaynakID = $_POST['id'];
		$birimID = $_REQUEST['birimID'];
	
		$sql = "DELETE FROM m_yeterlilik_birim_kaynak WHERE kaynak_id = ? AND yeterlilik_birim_id = ?";
	
		if (@$_db->prep_exec_insert($sql, array($kaynakID, $birimID)))
		{
			$sonuc = true;

			// RESULT TRUE, BASARILI, YENI STANDARTLARI ARRAYA KOY YOLLA
			$sql = "SELECT	KAYNAK_ID,
							YETERLILIK_BIRIM_ID,
							KAYNAK_ACIKLAMA,
							KAYNAK_TUR_ID,
							STANDART_KODU,
							STANDART_ADI,
							STANDART_ID,
							SEVIYE_ADI
					FROM m_yeterlilik_birim_kaynak
			             LEFT JOIN m_meslek_standartlari USING (standart_id)
			             LEFT JOIN pm_seviye USING (seviye_id)
					WHERE yeterlilik_birim_id = ?";
			
			$params = array ($birimID);
			$kaynak =  $_db->prep_exec($sql, $params);
			/////////////
			ajax_success_response_with_array('Satır başarıyla silindi.', $kaynak);

		}
		else{
			ajax_error_response('Hata Oluştu.');
		}
	}
	
}
?>