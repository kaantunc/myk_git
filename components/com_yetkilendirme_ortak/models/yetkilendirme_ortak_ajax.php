<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class Yetkilendirme_OrtakModelYetkilendirme_Ortak_Ajax extends JModel {

	function ajaxSaveRow (){
				
		$_db = JFactory::getOracleDBO();
		$columns = array();
		//DB Columns
		$dbParams = array('meslekSeviyesi', 'meslekAdi', 'protokolTeslim', 'meslekSektoru','revizyon');
		 
		$id = $_db->getNextVal('YETERLILIK_ID_seq');
		$columns[] = $id;
	
		foreach ($dbParams as $key ) {
			if(isset($_REQUEST[$key]))
			$columns[] = $_REQUEST[$key];
		}
	
		$sql = " INSERT INTO m_yeterlilik (yeterlilik_id, seviye_id, YETERLILIK_SUREC_DURUM_id, yeterlilik_adi, yeterlilik_teslim_tarihi, sektor_id, yeterlilik_durum_id,revizyon)
					 VALUES (?, ?, -4, ?, TO_DATE(?, 'dd.mm.yyyy'), ?, ".PM_YETERLILIK_DURUMU__OLUSTURULMAMIS_ONTASLAK.",?)";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns))
		{
			$sql2 = "INSERT INTO m_yetki_yeterlilik (yetki_id, yeterlilik_id) VALUES (?, ?)";
			$protokolID = $_REQUEST['protokolID'];
			
			if (@$_db->prep_exec_insert($sql2, array($protokolID, $id) ))
			{
				ajax_success_response('Satır başarıyla kaydedilmiştir.', $id);
				
				/*$sql3 = "INSERT INTO m_standart_yeterlilik VALUES (? , ?)";
				if (@$_db->prep_exec_insert($sql3, array($id, $_REQUEST['ulusalStandart'])))
				{
					ajax_success_response('SatÄ±r baÅŸarÄ±yla kaydedilmiÅŸtir.', $id);
				}
				else 
					ajax_error_response('YeterliliÄŸe Ulusal StandardÄ± Eklemede Hata OluÅŸtu.');
				*/
			}
			else 
				ajax_error_response('YeterliliÄŸi Protokole Eklemede Hata OluÅŸtu.');
		}
		else
		{
			ajax_error_response('Yeterlilik YaratÄ±rken Sistemde bir Hata OluÅŸtu');
		}
		
		
	}
	
	function ajaxEditRow (){
		
		$protokolID = $_REQUEST['protokolID'];
		
		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];
		
		$columns = array();
	
		//DB Columns
		$dbParams = array('meslekSeviyesi', 'meslekAdi', 'protokolTeslim', 'meslekSektoru', 'id');
	
		foreach ($dbParams as $key ) {
			if(isset($_POST[$key]))
			$columns[] = $_POST[$key];
		}
		
		$sql = " UPDATE m_yeterlilik
					 	SET seviye_id = ?,
					 		yeterlilik_adi = ?,
					 		yeterlilik_teslim_tarihi = TO_DATE(?, 'dd.mm.yyyy'),
					 		sektor_id = ?
					 WHERE yeterlilik_id = ?";
		if (@$_db->prep_exec_insert($sql, $columns))
			ajax_success_response('Satır başarıyla kaydedilmiştir.');
		
		//@ for disable error display
		/*if (@$_db->prep_exec_insert($sql, $columns))
		{
			$sql2 = "UPDATE m_standart_yeterlilik SET standart_id = ? WHERE yeterlilik_id=?";
			if (@$_db->prep_exec_insert($sql2, array($_POST['ulusalStandart'],$_POST['id'])))
				ajax_success_response('SatÄ±r baÅŸarÄ±yla kaydedilmiÅŸtir.');
			else 
				ajax_error_response('Hata OluÅŸtu');
		}
		else
			ajax_error_response('Hata OluÅŸtu');
		*/	
	}
	
	function ajaxDeleteRow (){
		
		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];
		
		$protokolID = $_REQUEST['protokolID'];
		
		$sql = "DELETE FROM m_yetki_yeterlilik WHERE yetki_id = ? AND yeterlilik_id = ?";
	/*
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, array($id)))
		{
		$sql2 = "UPDATE m_yeterlilik SET YETERLILIK_SUREC_DURUM_id= ? WHERE yeterlilik_id = ?";
		 */
				
		if (@$_db->prep_exec_insert($sql, array( $protokolID ,$id)))
		{
			$_db  = & JFactory::getOracleDBO();
			$sql = "Select yeterlilik_durum_id FROM m_yeterlilik WHERE yeterlilik_id = ?";
			$params = array($id);
			$result = $_db->prep_exec($sql, $params);
			$sonuc = true;
			
			if(	$result[0]["YETERLILIK_DURUM_ID"]== PM_YETERLILIK_DURUMU__OLUSTURULMAMIS_ONTASLAK )
			{
				$sql = "DELETE FROM m_yeterlilik WHERE yeterlilik_id =? ";
				$params = array($id);
				$sonuc =  $_db->prep_exec_insert($sql, $params);
			}
			
			$db  = &JFactory::getOracleDBO();
			$sql = "SELECT  YETKI_ID, 
							YETERLILIK_ID, 
							YETERLILIK_ADI, 
							SEVIYE_ID, 
							SEVIYE_ADI, 
							SEKTOR_ADI,
							REVIZYON, 
							TO_CHAR(YETERLILIK_TESLIM_TARIHI, 'dd.mm.yyyy') AS YETERLILIK_TESLIM_TARIHI 
		
					FROM 	m_yetki JOIN m_yetki_yeterlilik USING (YETKI_ID)
									JOIN m_yeterlilik USING (YETERLILIK_ID) 
									JOIN pm_sektorler USING (SEKTOR_ID) 
									JOIN pm_seviye USING (SEVIYE_ID)
					
					WHERE YETKI_ID = ? AND NOT YETERLILIK_SUREC_DURUM_ID = ?";
			
			$params = array ($protokolID, -3 ); //-3 ->deleted
			$protokolYeterlilikleri = $db->prep_exec($sql, $params);
			
			
			if($sonuc==true)
			ajax_success_response_with_array('SatÄ±r baÅŸarÄ±yla silindi.', $protokolYeterlilikleri);
			else
			ajax_error_response('Yeterlilik deÄŸiÅŸtirilmiÅŸ.');
		}
		else
			ajax_error_response('Protokolden Ã‡Ä±karmada Hata OluÅŸtu.');
			
			/*
		}
		else
			ajax_error_response('Yetki Standarttan ayrÄ±lamadÄ±');
			*/
	}

	function ajaxSaveRowMS (){

		$_db = JFactory::getOracleDBO();
		$columns = array();
		//DB Columns
		$dbParams = array('meslekSeviyesi', 'meslekAdi', 'hazirlamaBaslangic', 'hazirlamaBitis', 'meslekSektoru', 'revizyon');

		$id = $_db->getNextVal('MESLEK_STD_ID_seq');
		$columns[] = $id;

		foreach ($dbParams as $key ) {
			if(isset($_REQUEST[$key]))
				$columns[] = $_REQUEST[$key];
		}

		$sql = " INSERT INTO m_meslek_standartlari (standart_id, seviye_id, MESLEK_STANDART_SUREC_DURUM_ID, standart_adi, bitis_Tarihi, sektor_id, meslek_standart_durum_id,revizyon)
					 VALUES (?, ?, -4, ?, TO_DATE(?, 'dd.mm.yyyy'), ?, ".PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK.",?)";

		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns))
		{
			$sql2 = "INSERT INTO m_yetki_standart (yetki_id, standart_id) VALUES (?, ?)";
			$yetkilendirmeID = $_REQUEST['protokolID'];

			if (@$_db->prep_exec_insert($sql2, array($yetkilendirmeID, $id) ))
				ajax_success_response('Satır başarıyla kaydedilmiştir.', $id);
			else
				ajax_error_response('Standardı Yetkilendirmeye Eklemede Hata Oluştu.');
		}
		else
		{
			ajax_error_response('Standart Yaratırken Sistemde Bir Hata Oluştu');
		}


	}

	function ajaxEditRowMS (){
		$yetkilendirmeID = $_REQUEST['protokolID'];

		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];

		$columns = array();

		//DB Columns
		$dbParams = array('meslekSeviyesi', 'meslekAdi', 'hazirlamaBaslangic', 'meslekSektoru','revizyon', 'id');

		foreach ($dbParams as $key ) {
			if(isset($_POST[$key]))
				$columns[] = $_POST[$key];
		}

		$sql = " UPDATE m_meslek_standartlari
					 	SET seviye_id = ?,
					 		standart_adi = ?,
					 		bitis_Tarihi = TO_DATE(?, 'dd.mm.yyyy'),
					 		sektor_id = ?,
							revizyon = ?
					 WHERE standart_id = ?";

		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns))
			ajax_success_response('İlgili satır başarıyla kaydedildi.',$id);
		else
			ajax_error_response('Hata Oluştu');
	}

	function ajaxDeleteRowMS (){
		$_db = JFactory::getOracleDBO();
		$id = $_POST['id'];
		$standart_id = $id;

		$sql = "DELETE FROM m_yetki_standart WHERE standart_id = ? AND YETKI_ID = ?";

		$yetkilendirmeID = $_REQUEST['protokolID'];

		if (@$_db->prep_exec_insert($sql, array($id, $yetkilendirmeID)))
		{
			$sonuc = true;
			$_db  = & JFactory::getOracleDBO();

			$sql = "Select meslek_standart_durum_id FROM m_meslek_standartlari WHERE standart_id = ?";
			$params = array($standart_id);
			$result = $_db->prep_exec($sql, $params);

			if(	$result[0]["MESLEK_STANDART_DURUM_ID"]== PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK )
			{
				$sql = "DELETE FROM m_meslek_standartlari WHERE standart_id =? ";
				$params = array($standart_id);
				$sonuc =  $_db->prep_exec_insert($sql, $params);
			}
			//// BU KISIM MODELDE GETYETKILENDIRMESTANDARTLARI METODUNDAN
			$db  = &JFactory::getOracleDBO();
			$sql = "SELECT 	STANDART_ID,
								STANDART_ADI,
								SEVIYE_ID,
							    REVIZYON,
								SEVIYE_ADI,
								SEKTOR_ADI,
								MESLEK_STANDART_DURUM_ADI,
								TO_CHAR(m_meslek_standartlari.BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI,
								TO_CHAR(m_meslek_standartlari.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI
						FROM m_yetki, m_yetki_standart
							 JOIN m_meslek_standartlari USING (standart_id)
							 JOIN pm_sektorler USING (SEKTOR_ID)
							 JOIN pm_seviye USING (SEVIYE_ID)
							 JOIN PM_MESLEK_STANDART_DURUM USING (MESLEK_STANDART_DURUM_ID)
						WHERE m_yetki.YETKI_ID = m_yetki_standart.YETKI_ID
			      			AND m_yetki_standart.YETKI_ID = ?
					 		AND NOT MESLEK_STANDART_SUREC_DURUM_ID = ?";

			$params = array ($yetkilendirmeID, -3);
			$yeniStandartlar =  $db->prep_exec($sql, $params);
			/////////////
			if($sonuc==true)
			{
				ajax_success_response_with_array('Satır başarıyla silindi.', $yeniStandartlar);
			}
			else
				ajax_error_response('Standart değiştirilmiştir.');
		}
		else
			ajax_error_response('Standardı Yetkilendirmeden Çıkarırken Hata Oluştu.');


	}


	function ajaxFetchExistingYeterlilik ($revizyonMu){
	
		$array_YeterlilikDurumlari = array(PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK, PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK, PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK ,PM_MESLEK_STANDART_DURUMU__TASLAK);
	
		$arrayText = "";
		for($i=0; $i<count($array_YeterlilikDurumlari); $i++)
		{
			$arrayText .= $array_YeterlilikDurumlari[$i];
			if($i!=count($array_YeterlilikDurumlari)-1)//SONUNCU ELEMAN DEÄ�Ä°LSE
			$arrayText .= ", ";
		}
	
		if(isset($_REQUEST['seviyeID']) && $_REQUEST['seviyeID']!=0)
				$seviyeText = " seviye_id = ".$_REQUEST['seviyeID'];
			if(isset($_REQUEST['sektorID']) && $_REQUEST['sektorID']!=0)
				$sektorText = " sektor_id = ".$_REQUEST['sektorID'];
			if(isset($seviyeText) && isset($sektorText))
		$andText = " AND ";
			
				$protokolID = $_REQUEST['protokolID'];	
			
			$_db = JFactory::getOracleDBO();
	
			if($revizyonMu == '1') // BU KISIM YALAN OLDU
			{
				$surecDurumuFieldAdi = 'revizyon_durumu';
				$revizyonJoin = ' JOIN m_yeterlilik_revizyon USING (yeterlilik_id) JOIN pm_yeterlilik_revizyon_surec ON (m_yeterlilik_revizyon.revizyon_durumu = pm_yeterlilik_revizyon_surec.yeterlilik_surec_durum_id) ';
				$surecDurumuText = "yeterlilik_surec_durum_adi || ' (Revizyon No:' || revizyon_no || ')'  as yeterlilik_durum_adi";
			}
			else
			{
				$surecDurumuFieldAdi = 'yeterlilik_surec_durum_id';
				$revizyonJoin = '';
				$surecDurumuText = 'yeterlilik_durum_adi';
			}
				
				
			$sql = 'SELECT DISTINCT YETERLILIK_ID,
							YETERLILIK_ADI, 
							SEVIYE_ADI,
							REVIZYON,
							SEKTOR_ADI,
							TO_CHAR(YETERLILIK_TESLIM_TARIHI, \'dd.mm.yyyy\') AS YETERLILIK_TESLIM_TARIHI,
							'.$surecDurumuText.'
					FROM m_yeterlilik
					JOIN pm_seviye USING (SEVIYE_ID)
					JOIN pm_sektorler USING (SEKTOR_ID)
					JOIN pm_yeterlilik_durum USING (yeterlilik_durum_id)
					'.$revizyonJoin.'
					
					WHERE yeterlilik_id in (SELECT yeterlilik_id FROM m_yetki_yeterlilik)
					AND '.$seviyeText.$andText.$sektorText.'
					AND '.$surecDurumuFieldAdi.' NOT IN ('.REDDEDILMIS_YETERLILIK.', 14)';
			
			/*
		$sql2 = "SELECT 	m_yeterlilik.YETERLILIK_ID,
								m_yeterlilik.YETERLILIK_ADI, 
								pm_seviye.SEVIYE_ADI,
								pm_sektorler.SEKTOR_ADI,
								TO_CHAR(m_yeterlilik.YETERLILIK_TESLIM_TARIHI, 'dd.mm.yyyy') AS YETERLILIK_TESLIM_TARIHI,
								yeterlilik_durum_adi
						FROM  m_yeterlilik, pm_seviye, pm_sektorler, pm_yeterlilik_durum, m_taslak_yeterlilik 
						WHERE m_yeterlilik.yeterlilik_id = m_taslak_yeterlilik.yeterlilik_id
							AND m_yeterlilik.YETERLILIK_ID NOT IN (SELECT yeterlilik_id FROM m_yetki_yeterlilik WHERE YETKI_ID=".$protokolID.") 
							AND (m_yeterlilik.yeterlilik_durum_id IN (".$durum_id.") )
							AND m_yeterlilik.yeterlilik_surec_durum_id NOT IN (".REDDEDILMIS_YETERLILIK.")
							AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
							AND m_yeterlilik.yeterlilik_durum_id =  pm_yeterlilik_durum.yeterlilik_durum_id
							AND m_yeterlilik.sektor_id = pm_sektorler.sektor_id 
							AND ".$seviyeText.$andText.$sektorText."
		
							
							UNION 
							
							
							SELECT 	m_yeterlilik.YETERLILIK_ID,
								m_yeterlilik.YETERLILIK_ADI, 
								pm_seviye.SEVIYE_ADI,
								pm_sektorler.SEKTOR_ADI,
								TO_CHAR(m_yeterlilik.YETERLILIK_TESLIM_TARIHI, 'dd.mm.yyyy') AS YETERLILIK_TESLIM_TARIHI,
								pm_yeterlilik_revizyon_surec.yeterlilik_surec_durum_adi || ' (Revizyon No:' || m_yeterlilik_revizyon.revizyon_no || ')'  as yeterlilik_durum_adi
						FROM  m_yeterlilik, pm_seviye, pm_sektorler, pm_yeterlilik_durum , m_yeterlilik_revizyon, pm_yeterlilik_revizyon_surec, m_taslak_yeterlilik
						WHERE m_yeterlilik.yeterlilik_id = m_taslak_yeterlilik.yeterlilik_id
							AND m_yeterlilik.YETERLILIK_ID NOT IN (SELECT yeterlilik_id FROM m_yetki_yeterlilik WHERE YETKI_ID=".$protokolID.") 
							AND m_yeterlilik.yeterlilik_id = m_yeterlilik_revizyon.yeterlilik_id
              				AND m_yeterlilik_revizyon.revizyon_durumu = pm_yeterlilik_revizyon_surec.yeterlilik_surec_durum_id
  							AND (m_yeterlilik.yeterlilik_durum_id IN (".$arrayText.") AND m_yeterlilik.yeterlilik_id IN (SELECT yeterlilik_id FROM m_yeterlilik_revizyon ) )
							AND m_yeterlilik.yeterlilik_surec_durum_id NOT IN (".REDDEDILMIS_YETERLILIK.")
							AND m_yeterlilik.seviye_id = pm_seviye.seviye_id
							AND m_yeterlilik.yeterlilik_durum_id =  pm_yeterlilik_durum.yeterlilik_durum_id
							AND m_yeterlilik.sektor_id = pm_sektorler.sektor_id 
							AND ".$seviyeText.$andText.$sektorText."
							AND m_yeterlilik.yeterlilik_id IN (SELECT yeterlilik_id FROM m_yeterlilik_revizyon WHERE m_yeterlilik_revizyon.revizyon_durumu NOT IN (-1,1,-3) )
             
             ";
		*/
	
		$result = @$_db->prep_exec($sql, array());
		
		if (count($result)>0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı');
	
	}
	function ajaxFetchExistingStandart (){

		if(isset($_REQUEST['seviyeID']) && $_REQUEST['seviyeID']!=0)
			$seviyeText = " m_meslek_standartlari.seviye_id = ".$_REQUEST['seviyeID'];
		if(isset($_REQUEST['sektorID']) && $_REQUEST['sektorID']!=0)
			$sektorText = " m_meslek_standartlari.sektor_id = ".$_REQUEST['sektorID'];
		if(isset($seviyeText) && isset($sektorText))
			$andText = " AND ";

		$yetkilendirmeID = $_REQUEST['protokolID'];
		$_db = JFactory::getOracleDBO();

		$sql = "SELECT DISTINCT m_meslek_standartlari.STANDART_ID,
						m_meslek_standartlari.STANDART_ADI,
						pm_seviye.SEVIYE_ADI,
						pm_sektorler.SEKTOR_ADI,
						m_meslek_standartlari.REVIZYON,
						pm_meslek_standart_durum.meslek_standart_durum_adi,
						TO_CHAR(m_meslek_standartlari.BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI,
						TO_CHAR(m_meslek_standartlari.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI
				FROM m_meslek_standartlari
					INNER JOIN pm_seviye ON pm_seviye.SEVIYE_ID = m_meslek_standartlari.SEVIYE_ID
					INNER JOIN pm_sektorler ON pm_sektorler.SEKTOR_ID = m_meslek_standartlari.SEKTOR_ID
					INNER JOIN pm_meslek_standart_durum ON pm_meslek_standart_durum.meslek_standart_durum_id = m_meslek_standartlari.meslek_standart_durum_id

				WHERE ".$seviyeText.$andText.$sektorText."
					AND m_meslek_standartlari.meslek_standart_surec_durum_id NOT IN (".REDDEDILMIS_STANDART.")";
// m_meslek_standartlari.standart_id in (SELECT standart_id FROM m_yetki_standart)
		// AND
		$result = @$_db->prep_exec($sql, array());

		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response('Kayıt bulunamadı');
	}

	function ajaxAddFromVarolanYeterlilikler (){
		$eklenecekYeterlilikler = $_REQUEST['varolanYeterliliklerCheckbox'];
		$protokolID = $_REQUEST['protokolID'];

		$_db = JFactory::getOracleDBO();
		$result = true;

		for($i=0; $i<count($eklenecekYeterlilikler); $i++)
		{
			$revizyonCount = 0;
			$revizyonCountSql = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID= ?  ORDER BY REVIZYON";//ONAYLANDI, REDDEDILDI, SİLİNDİ
			$revizyonCountResult = $_db->prep_exec($revizyonCountSql, array($eklenecekYeterlilikler[$i]));
			$revizyonCount = $revizyonCountResult[count($revizyonCountResult)-1]["REVIZYON"];

			$sql = "INSERT INTO m_yetki_yeterlilik(YETKI_ID, YETERLILIK_ID, REVIZYON_NO) VALUES ( ?,?, ?)";
			$result = $result && $_db->prep_exec_insert($sql, array($protokolID, $eklenecekYeterlilikler[$i], $revizyonCount));
		}


		if($result == true)
		{
		// RESULT TRUE, BASARILI, YENI STANDARTLARI ARRAYA KOY YOLLA

			$db  = &JFactory::getOracleDBO();
		$sql = "SELECT  YETKI_ID,
							YETERLILIK_ID,
							YETERLILIK_ADI,
							SEVIYE_ID,
							REVIZYON,
							SEVIYE_ADI,
							SEKTOR_ADI,
							TO_CHAR(YETERLILIK_TESLIM_TARIHI, 'dd.mm.yyyy') AS YETERLILIK_TESLIM_TARIHI

					FROM 	m_yetki JOIN m_yetki_yeterlilik USING (YETKI_ID)
									JOIN m_yeterlilik USING (YETERLILIK_ID)
									JOIN pm_sektorler USING (SEKTOR_ID)
									JOIN pm_seviye USING (SEVIYE_ID)

					WHERE YETKI_ID = ? AND NOT YETERLILIK_SUREC_DURUM_ID = ?";

		$params = array ($protokolID, -3 ); //-3 ->deleted
		$protokolunYeterlilikleri = $db->prep_exec($sql, $params);

		///////////////////////////
		ajax_success_response_with_array('Başarılı', $protokolunYeterlilikleri);
		}
		else
			ajax_error_response('Başarısız');

	}

	function ajaxAddFromVarolanStandartlar (){
		$eklenecekStandartlar = $_REQUEST['varolanStandartlarCheckbox'];
		$yetkilendirmeID = $_REQUEST['protokolID'];

		$_db = JFactory::getOracleDBO();
		$result = true;
		for($i=0; $i<count($eklenecekStandartlar); $i++)
		{
			$revizyonCount = 0;
			$revizyonSql = "SELECT REVIZYON FROM M_MESLEK_STANDARTLARI WHERE STANDART_ID=?";
			$revizyonSqlResult = $_db->prep_exec($revizyonSql, array($eklenecekStandartlar[$i]));
			$revizyon = $revizyonSqlResult[0]["REVIZYON"];

			$sql = "INSERT INTO m_yetki_standart(YETKI_ID, STANDART_ID, REVIZYON_NO ) VALUES (?,?,?)";
			$result = $result && $_db->prep_exec_insert($sql, array($yetkilendirmeID, $eklenecekStandartlar[$i], $revizyon));
		}


		if($result == true)
		{
			// RESULT TRUE, BASARILI, YENI STANDARTLARI ARRAYA KOY YOLLA
			$db  = &JFactory::getOracleDBO();
			$sql = "SELECT 	STANDART_ID,
							STANDART_ADI,
							SEVIYE_ID,
							SEVIYE_ADI,
							REVIZYON,
							SEKTOR_ADI,
							MESLEK_STANDART_DURUM_ADI,
							TO_CHAR(m_meslek_standartlari.BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI,
							TO_CHAR(m_meslek_standartlari.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI
					FROM m_yetki, m_yetki_standart
						 JOIN m_meslek_standartlari USING (standart_id)
						 JOIN pm_sektorler USING (SEKTOR_ID)
						 JOIN pm_seviye USING (SEVIYE_ID)
						 JOIN PM_MESLEK_STANDART_DURUM USING (MESLEK_STANDART_DURUM_ID)
					WHERE m_yetki.YETKI_ID = m_yetki_standart.YETKI_ID
					AND m_yetki_standart.YETKI_ID = ?
					AND NOT MESLEK_STANDART_SUREC_DURUM_ID = ?";

			$params = array ($yetkilendirmeID, -3);
			$yetkilendirmeStandartlari = $db->prep_exec($sql, $params);

			ajax_success_response_with_array('Başarılı', $yetkilendirmeStandartlari);
		}
		else
			ajax_error_response('Başarısız');
	}

	function ajaxFilterYetkilendirmelerYet($kurulusAdi, $yeterlilikAdi, $yeterlilikSektorIDleri )
	{
		$db  = &JFactory::getOracleDBO();

		$condition = "";
		if(isset($kurulusAdi) && $kurulusAdi <> ""){
			$condition .= " AND M_KURULUS.KURULUS_ADI LIKE TURKCE_UPPER('".FormFactory::toLowerCase($kurulusAdi)."%') ";
		}

		if(isset($yeterlilikAdi) && $yeterlilikAdi <> ""){
			$condition .= " AND ((M_YETERLILIK.YETERLILIK_ADI LIKE TURKCE_UPPER('".FormFactory::toLowerCase($yeterlilikAdi)."%')) OR (M_MESLEK_STANDARTLARI.STANDART_ADI LIKE TURKCE_UPPER('".FormFactory::toLowerCase($yeterlilikAdi)."%'))) ";
		}

		if(count($yeterlilikSektorIDleri) > 0){
			$condition .= " AND ((M_YETERLILIK.SEKTOR_ID IN (".implode(",",$yeterlilikSektorIDleri).")) OR (M_MESLEK_STANDARTLARI.SEKTOR_ID IN (".implode(",",$yeterlilikSektorIDleri)."))) ";
		}

		$sql = "SELECT DISTINCT M_YETKI.YETKI_ID,
								M_YETKI.ADI,
								TO_CHAR(M_YETKI.IMZA_TARIHI, 'dd.mm.yyyy') AS IMZA_TARIHI,
								TO_CHAR(M_YETKI.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI,
								M_YETKI.ETKIN,
								pm_yetki_durumu.ACIKLAMA,
								M_YETKI.PROTOKOL_MU FROM M_YETKI
					 INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
					 INNER JOIN M_YETKI_YETERLILIK ON M_YETKI_YETERLILIK.YETKI_ID = M_YETKI.YETKI_ID
					 INNER JOIN M_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_YETKI_YETERLILIK.YETERLILIK_ID
					 INNER JOIN M_YETKI_STANDART ON M_YETKI_STANDART.YETKI_ID = M_YETKI.YETKI_ID
					 INNER JOIN M_MESLEK_STANDARTLARI ON M_MESLEK_STANDARTLARI.STANDART_ID = M_YETKI_STANDART.STANDART_ID
					 INNER JOIN M_KURULUS ON M_KURULUS.USER_ID = M_KURULUS_YETKI.USER_ID
					 INNER JOIN PM_YETKI_DURUMU ON PM_YETKI_DURUMU.DURUM_ID = M_YETKI.ETKIN
						  WHERE M_YETKI.YETKI_TURU = 3 ".$condition."
					   ORDER BY M_YETKI.ADI";


		$yetkilendirmeYeterlilikleri = $db->prep_exec($sql, array());

		if(count($yetkilendirmeYeterlilikleri)!=0)
			ajax_success_response_with_array('Başarılı', $yetkilendirmeYeterlilikleri);
		else
			ajax_error_response('Başrısız');
	
	}
	function ajaxFilterYetkilendirmelerMS($kurulusAdi, $standartAdi, $standartSektorIDleri )
	{
		$db  = &JFactory::getOracleDBO();

		$condition = " 1=1 ";
		if(isset($kurulusAdi) && $kurulusAdi <> ""){
			$condition .= " AND M_KURULUS.KURULUS_ADI LIKE TURKCE_UPPER('".FormFactory::toLowerCase($kurulusAdi)."%') ";
		}

		if(isset($standartAdi) && $standartAdi <> ""){
			$condition .= " AND M_MESLEK_STANDARTLARI.STANDART_ADI LIKE TURKCE_UPPER('".FormFactory::toLowerCase($standartAdi)."%') ";
		}

		if(count($standartSektorIDleri) > 0){
			$condition .= " AND M_MESLEK_STANDARTLARI.SEKTOR_ID IN (".implode(",",$standartSektorIDleri).") ";
		}

		$sql = "SELECT DISTINCT M_YETKI.YETKI_ID,
								M_YETKI.ADI,
								TO_CHAR(M_YETKI.IMZA_TARIHI, 'dd.mm.yyyy') AS IMZA_TARIHI,
								TO_CHAR(M_YETKI.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI,
								M_YETKI.ETKIN,
								pm_yetki_durumu.ACIKLAMA,
								M_YETKI.PROTOKOL_MU FROM M_YETKI
					 INNER JOIN M_KURULUS_YETKI ON M_KURULUS_YETKI.YETKI_ID = M_YETKI.YETKI_ID
					 INNER JOIN M_YETKI_STANDART ON M_YETKI_STANDART.YETKI_ID = M_YETKI.YETKI_ID
					 INNER JOIN M_KURULUS ON M_KURULUS.USER_ID = M_KURULUS_YETKI.USER_ID
					 INNER JOIN M_MESLEK_STANDARTLARI ON M_MESLEK_STANDARTLARI.STANDART_ID = M_YETKI_STANDART.STANDART_ID
					 INNER JOIN PM_YETKI_DURUMU ON PM_YETKI_DURUMU.DURUM_ID = M_YETKI.ETKIN
					      WHERE ".$condition."
					   ORDER BY M_YETKI.ADI";

		// PM_YETKILENDIRMETURU_MESLEKSTANDARDIYETKILENDIRME
		$yetkilendirmeStandartlari = $db->prep_exec($sql, array());

		if(count($yetkilendirmeStandartlari)!=0)
			ajax_success_response_with_array('Başarılı', $yetkilendirmeStandartlari);
		else
			ajax_error_response('Başrısız');

	}
	
	
	 
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
	
		$sql = " INSERT INTO m_yetki_sure_uzatma (yetki_id, aciklama, uzatma_suresi, uzatma_id)
		VALUES (?, ?, ?, ?)";
	
		//@ for disable error display
		if (@$_db->prep_exec_insert($sql, $columns)){
			ajax_success_response('Satır Başarıyla Kaydedilmiştir.', $id);
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
	
		$sql = " UPDATE m_yetki_sure_uzatma
		SET uzatma_suresi = ?,
		aciklama = ?
		WHERE yetki_id = ? AND uzatma_id = ?";
	
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
	
		$sql = "DELETE FROM m_yetki_sure_uzatma WHERE yetki_id = ? AND uzatma_id = ?";
	
		if (@$_db->prep_exec_insert($sql, array($protokolID, $id))){
			ajax_success_response('Satır Başarıyla Kaydedilmiştir.');
		}
		else{
			ajax_error_response('Hata Oluştu');
		}
	}

	function kurulusKaydetAjax($post)
	{
		$protokol_id = $post['protokol_id'];
		$kurulus_id = $post['kurulus_id'];
		$kurulusTuru = $post['kurulusTuru'];
		$tip = $post['tip'];
		if ($protokol_id == '' or $kurulus_id == '' or $kurulusTuru == '') {
			return "Hata";
		}


		$db = &JFactory::getOracleDBO();

		$sql = "delete from m_kurulus_yetki where user_id=? and YETKI_ID=?";
		$params = array($kurulus_id, $protokol_id);
		$db->prep_exec_insert($sql, $params);
		$mesaj = "Kuruluş, protokolden silindi.";
		if ($tip == "kaydet") {
			$sql = "INSERT INTO m_kurulus_yetki (user_id, YETKI_ID, kurulus_turu) VALUES (?, ?, ?)";
			$params = array($kurulus_id, $protokol_id, $kurulusTuru);
			$db->prep_exec_insert($sql, $params);
			$mesaj = "Kuruluş, protokole eklendi.";
		}
		return $mesaj;
	}


}
?>