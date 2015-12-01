<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Meslek_Std_TaslakModelTaslak_Revizyon extends JModel {
	
	function canEdit($standart_id){
		$juser 	= &JFactory::getUser();
		$user_id= $juser->getOracleUserId ();
		$isYetkili=FormFactory::getSorumluSektorId ($user_id, 2);
		$STANDART_SUREC_DURUM	= $this->getStandartSurecDurumId ($standart_id);
		if (in_array(0, $isYetkili)){
			return true;
		}
// 		if ($STANDART_SUREC_DURUM == PM_MESLEK_STANDART_SUREC_DURUMU__RESMI_GAZETEDE_YAYINLANDI){
// 			return false;
// 		}
		return true;
	}
	function getStandartSurecDurumId ($standart_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql="select REVIZYON_DURUMU from M_STANDART_REVIZYON where STANDART_ID=".$standart_id." order by
	 REVIZYON_NO desc";
		$data=$_db->prep_exec_array($sql);
	
		if (!$data){
			$sql = "SELECT MESLEK_STANDART_SUREC_DURUM_id
						FROM m_meslek_standartlari  
						WHERE standart_id = ?";
				
			$params = array ($standart_id);
				
			$data = $_db->prep_exec_array($sql, $params);
		}
		return $data[0];
	}
	function revizyonKaydet ($data, $standart_id){
		if ($data ["revizyonNo"]==""){
			return false;
		}
		$resultY = true;
		$resultD = true;
		if ($data ["revizyonNo"]=="00"){
				//if (isset ($data["referans_kodu"])){
			$resultY = $this->standartRevizyonGuncelle ($data, $standart_id);
			$resultD = $this->standartDurumGuncelle ($data["revizyon_durum"], $standart_id);
			//}
		}
		$resultT = $this->taslakRevizyonGuncelle ($data, $standart_id);
		
		if ($resultY && $resultT){
			return JText::_("VERI_KAYDI_BASARILI");
		}else{
			return JText::_("VERI_KAYDI_BASARISIZ");
		}
	}
	
	function standartRevizyonGuncelle ($data, $standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "UPDATE m_meslek_standartlari  
					SET KARAR_TARIHI = to_date (?, 'dd/mm/yyyy'),
						KARAR_SAYI = ?,
						RESMI_GAZETE_TARIH = to_date (?, 'dd/mm/yyyy'),
						RESMI_GAZETE_SAYI = ?,
						STANDART_KODU = ? 
			   WHERE standart_id = ?";
		
		$params = array ($data["karar_tarih"],
						 $data["sayi"],
						 $data["resmi_tarih"],
						 $data["resmi_sayi"],
						 $data["referans_kodu"],
						 $standart_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
		
	function revizyonVarMi($standart_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select * from M_STANDART_REVIZYON where standart_id=$standart_id order by revizyon_no desc";
		$sonuc=$_db->prep_exec($sql, array());
		if ($sonuc){
			return $sonuc[0][REVIZYON_NO];
		} else {
			return "00";
		}
	}
	
	function durumKontrol($standart_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select REVIZYON_DURUMU,SON_TASLAK_PDF from M_STANDART_REVIZYON where standart_id=$standart_id order by revizyon_no desc";
		$sonuc=$_db->prep_exec($sql, array());
		if ($sonuc){
			$durum=$sonuc[0][REVIZYON_DURUMU];
			$sonhali=$sonuc[0][SON_TASLAK_PDF];
		} else {
			$sql="select MESLEK_STANDART_SUREC_DURUM_ID from M_MESLEK_STANDARTLARI where standart_id=$standart_id";
			$sonuc=$_db->prep_exec($sql, array());
			$durum=$sonuc[0][MESLEK_STANDART_SUREC_DURUM_ID];
			$sql="select SON_TASLAK_PDF from M_TASLAK_MESLEK where standart_id=$standart_id";
			$sonuc=$_db->prep_exec($sql, array());
			$sonhali=$sonuc[0][SON_TASLAK_PDF];
		}
		return array($durum,$sonhali);
	}
	
	function revizyonListesi($standart_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select * from M_STANDART_REVIZYON where standart_id=$standart_id order by revizyon_no";
		return $_db->prep_exec($sql, array());
	}

	function taslakRevizyonGuncelle ($data, $standart_id){
		$_db = &JFactory::getOracleDBO();

		if ($data ["revizyonNo"]=="00"){
		
			$sql= "UPDATE m_taslak_meslek 
						SET REVIZYON_TARIHI = to_date (?, 'dd/mm/yyyy'), 
							REVIZYON_NO = ?,
							EDITABLE = ?,
							ILK_TASLAK_PDF = ?,
							RESMI_GORUS_ONCESI_PDF = ?,
							SEKTOR_KOMITESI_ONCESI_PDF = ?,
							YONETIM_KURULU_ONCESI_PDF = ?,
							GORUSE_CIKMA_TARIHI = to_date (?, 'dd/mm/yyyy'),
							SON_GORUS_TARIHI = to_date (?, 'dd/mm/yyyy'),
							SON_TASLAK_PDF = ?   
				   WHERE standart_id = ?";
			
			$params = array ($data ["revizyon_tarih"],
							 "00",
							 $data ["editable"],
							 null,
							 $data ["path_taslakPdf_0_1"],
							 $data ["path_taslakPdf_0_2"],
							 $data ["path_taslakPdf_0_3"],
							 //$data ["path_taslakPdf_0_4"].$data ["filename_taslakPdf_0_4"],
							 $data ["goruse_cikma_tarihi"],
							 $data ["son_gorus_tarihi"],
							 $data ["path_taslakPdf_0_4"],
							 $standart_id);
		} else {
			FormParametrik::uyariKaydet(Array(MESLEK_STANDARTI_REVIZYONU,$data ["revizyonNo"]),$standart_id,$data ["revizyon_durum"]);
				
			$sql="DELETE from M_STANDART_REVIZYON where STANDART_ID=$standart_id and REVIZYON_NO=".$data ["revizyonNo"];
			$_db->prep_exec_insert($sql, array());
			$sql= "UPDATE m_taslak_meslek 
						SET EDITABLE = ?
				   WHERE standart_id = ?";
			
			$params = array ($data ["editable"], $standart_id);
			$_db->prep_exec_insert($sql, $params);
			$sql= "INSERT INTO M_STANDART_REVIZYON 	(
			STANDART_ID,
			REVIZYON_NO,
			REVIZYON_TARIHI,
			REVIZYON_DURUMU,
			YKK_TARIHI,
			YKK_SAYISI,
			YAYIN_TARIHI,
			RESMI_GORUS_ONCESI_PDF,
			SEKTOR_KOMITESI_ONCESI_PDF,
			YONETIM_KURULU_ONCESI_PDF,
			SON_TASLAK_PDF,
			GORUSE_CIKMA_TARIHI,
			SON_GORUS_TARIHI,
			YETERLILIK_KODU,
			RESMI_GAZETE_TARIH,
			RESMI_GAZETE_SAYI
			) VALUES  (	?, ?, to_date (?, 'dd/mm/yyyy'), ?, to_date (?, 'dd/mm/yyyy'), ?, to_date (?, 'dd/mm/yyyy'), ?, ?, ?, ?, to_date (?, 'dd/mm/yyyy'), to_date (?, 'dd/mm/yyyy'),?,to_date (?, 'dd/mm/yyyy'),?)";
			
				
			$params = array ($standart_id,
					$data ["revizyonNo"],
					$data ["revizyon_tarih"],
					$data ["revizyon_durum"],
					$data ["karar_tarih"],
					$data ["sayi"],
					$data ["yayin_tarihi"],
					$data ["path_taslakPdf_0_1"],
					$data ["path_taslakPdf_0_2"],
					$data ["path_taslakPdf_0_3"],
					$data ["path_taslakPdf_0_4"],
					$data ["goruse_cikma_tarihi"],
					$data ["son_gorus_tarihi"],
					$data ["referans_kodu"],
					$data ["resmi_tarih"],
					$data ["resmi_sayi"]);
				
		}		
		$sonuc=$_db->prep_exec_insert($sql, $params);
		if ($sonuc===true){
			return true;
		} else {
			return false;
		}
	}
	
	function standartDurumGuncelle ($durum, $standart_id){
		$_db = &JFactory::getOracleDBO();
		
		FormParametrik::uyariKaydet(Array(MESLEK_STANDARTI,"00"),$standart_id,$durum);
		$sql= "UPDATE m_meslek_standartlari 
					SET MESLEK_STANDART_SUREC_DURUM_ID = ? 
			   WHERE standart_id = ?";
		
		$params = array ($durum, $standart_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function getTaslakBilgi ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT STANDART_ADI,
					  SEVIYE_ADI,
					  SEKTOR_ADI,
					  MESLEK_STANDART_SUREC_DURUM_ID, 
					  STANDART_SUREC_DURUM_ADI, 
					  EDITABLE,
					  STANDART_KODU,
					  ILK_TASLAK_PDF,
					  RESMI_GORUS_ONCESI_PDF,
					  SEKTOR_KOMITESI_ONCESI_PDF,
					  YONETIM_KURULU_ONCESI_PDF,
					  SON_TASLAK_PDF
			   FROM m_taslak_meslek 
			   	 JOIN m_meslek_standartlari		USING (standart_id) 
			   	 JOIN pm_seviye    				USING (seviye_id)
			   	 JOIN pm_sektorler 				USING (sektor_id)			   	 
			   	 JOIN pm_meslek_standart_surec_durum 	USING (MESLEK_STANDART_SUREC_DURUM_ID)			   	 
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getRevizyonBilgi ($standart_id,$revizyon_no=""){
		$_db = &JFactory::getOracleDBO();
		if ($revizyon_no==""){
			$revizyon_no=$this->revizyonVarMi($standart_id);
		}
		if ($revizyon_no=="00"){
		
		$sql= "SELECT STANDART_KODU,
					  REVIZYON_NO,
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  KARAR_SAYI, 
					  TO_CHAR (RESMI_GAZETE_TARIH , 'dd.mm.yyyy') RESMI_GAZETE_TARIH,
					  TO_CHAR (GORUSE_CIKMA_TARIHI, 'dd.mm.yyyy') GORUSE_CIKMA_TARIHI,
					  TO_CHAR (SON_GORUS_TARIHI	  , 'dd.mm.yyyy') SON_GORUS_TARIHI,
					  RESMI_GAZETE_SAYI  
			   FROM m_meslek_standartlari 
			   	  JOIN m_taslak_meslek USING (standart_id) 
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		} else {
			$sql= "SELECT
			REVIZYON_NO,
			YETERLILIK_KODU,
			TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
			TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
			TO_CHAR (YKK_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
			TO_CHAR (GORUSE_CIKMA_TARIHI, 'dd.mm.yyyy') GORUSE_CIKMA_TARIHI,
			TO_CHAR (SON_GORUS_TARIHI	  , 'dd.mm.yyyy') SON_GORUS_TARIHI,
			TO_CHAR (RESMI_GAZETE_TARIH, 'dd.mm.yyyy') RESMI_GAZETE_TARIH,
			YKK_SAYISI as KARAR_SAYI,
			REVIZYON_DURUMU,
			RESMI_GORUS_ONCESI_PDF,
			SEKTOR_KOMITESI_ONCESI_PDF,
			YONETIM_KURULU_ONCESI_PDF,
			RESMI_GAZETE_SAYI,
			SON_TASLAK_PDF
			
			FROM m_standart_revizyon
			WHERE standart_id = ? and REVIZYON_NO= ? ";
			
			$params = array ($standart_id,$revizyon_no);
				
		}		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getStandartDurum ($revizyon_mu){
		$_db = &JFactory::getOracleDBO();
		if ($revizyon_mu==1){
			$sqlpart="pm_standart_revizyon_surec";
		} else {
			$sqlpart="pm_meslek_standart_surec_durum";
		}
		$sql= "SELECT *  
			   FROM ".$sqlpart." 
			   WHERE MESLEK_STANDART_SUREC_DURUM_ID != ".PROTOKOL_LISTE_REDDEDILMIS_STANDART."
			   ORDER BY SIRA";
		
		return $_db->loadList($sql, array());		
	}
	
	function pdfGoster ($standart_id, $id, $revize_no){
 		$_db = &JFactory::getOracleDBO();
 		switch ($id){
//			case 1:
//				$select = "ILK_TASLAK_PDF";
//				break;
			case 1:
				$select = "RESMI_GORUS_ONCESI_PDF";
				break;
			case 2:
				$select = "SEKTOR_KOMITESI_ONCESI_PDF";
				break;
			case 3:
				$select = "YONETIM_KURULU_ONCESI_PDF";
				break;
			case 4:
				$select = "SON_TASLAK_PDF";
				break;
		}
		
		if ($revize_no=="00" or $revize_no==""){
			$tablo="M_TASLAK_MESLEK";
			$sqlpart="";
		} else {
			$tablo="M_STANDART_REVIZYON";
			$sqlpart="AND REVIZYON_NO=".$revize_no;
		}

		$sql = "SELECT ".$select.
			  " FROM ".$tablo."  
			    WHERE STANDART_ID = ? ".$sqlpart;
		
		$r = $_db->prep_exec_array($sql, array ($standart_id));

		$file = $r[0];	
		
		FormFactory::readFileFromDB($file);
	}
	
	/**
	 * 
	 * Secilen PDF belgesinin veritabanindan silinmesini saglar
	 * @param integer $standart_id
	 * @param integer $id
	 */
	
	function pdfSil ($standart_id, $id, $revize_no){
		$_db = &JFactory::getOracleDBO();
		
		switch ($id){
			case 1:
				$select = "RESMI_GORUS_ONCESI_PDF";
				break;
			case 2:
				$select = "SEKTOR_KOMITESI_ONCESI_PDF";
				break;
			case 3:
				$select = "YONETIM_KURULU_ONCESI_PDF";
				break;
			case 4:
				$select = "SON_TASLAK_PDF";
				break;
		}
		
		if ($revize_no=="00" or $revize_no==""){
			$tablo="M_TASLAK_MESLEK";
			$sqlpart="";
		} else {
			$tablo="M_STANDART_REVIZYON";
			$sqlpart="AND REVIZYON_NO=".$revize_no;
		}

		$sql = "UPDATE ".$tablo."
					SET ".$select." = NULL 
			   WHERE STANDART_ID = ? ".$sqlpart;
		
		
		$result = $_db->prep_exec_insert($sql, array ($standart_id));
		
		if ($result){
			return JText::_("PDF Başarıyla Silindi");
			//return "SQL: ".$sql. " SELECT: ".$select." STANDART_ID: ".$standart_id." ID: ".$id;
		}else{
			return JText::_("Silme İşlemi Başarısız");
		}
		
	}
}
?>