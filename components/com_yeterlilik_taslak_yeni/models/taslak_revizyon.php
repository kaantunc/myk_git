<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
$document = &JFactory::getDocument();
//$document->addScript( '/templates/elegance/js/jscal2.js' );
//$document->addScript( '/templates/elegance/js/lang/tr.js' );

class Yeterlilik_TaslakModelTaslak_Revizyon extends JModel {

	function canEdit($yeterlilik_id){
		$juser 	= &JFactory::getUser();
		$user_id= $juser->getOracleUserId ();
		$isYetkili=FormFactory::getSorumluSektorId ($user_id, 1);
		$YETERLILIK_SUREC_DURUM	= $this->getYeterlilikSurecDurumId ($yeterlilik_id);
		/*if (in_array(0, $isYetkili)){
			return true;
		}*/
		if (FormFactory::sektorSorumlusuMu($juser)){
			return true;
		}
		if ($YETERLILIK_SUREC_DURUM == ONAYLANMIS_YETERLILIK){
			return false;
		}
		return true;
	}
	function getYeterlilikSurecDurumId ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql="select REVIZYON_DURUMU from M_YETERLILIK_REVIZYON where YETERLILIK_ID=".$yeterlilik_id." order by
	 REVIZYON_NO desc";
		$data=$_db->prep_exec_array($sql);
	
		if (!$data){
			$sql = "SELECT YETERLILIK_SUREC_DURUM_id
						FROM m_yeterlilik  
						WHERE yeterlilik_id = ?";
				
			$params = array ($yeterlilik_id);
				
			$data = $_db->prep_exec_array($sql, $params);
		}
		return $data[0];
	}
	
	function revizyonKaydet ($data, $yeterlilik_id){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
//		exit;
		$resultY = true;
		$resultD = true;
		if ($data ["revizyonNo"]=="00"){
			$resultY = $this->yeterlilikRevizyonGuncelle ($data, $yeterlilik_id);
			$resultD = $this->yeterlilikDurumGuncelle ($data["revizyon_durum"], $yeterlilik_id);
		}
		$resultT = $this->taslakRevizyonGuncelle ($data, $yeterlilik_id);

		if ($resultY && $resultT && $resultD){
			return JText::_("VERI_KAYDI_BASARILI");
		}else{
			return JText::_("VERI_KAYDI_BASARISIZ");
		}
	}
	
	function revizyonVarMi($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select * from M_YETERLILIK_REVIZYON where yeterlilik_id=$yeterlilik_id order by revizyon_no desc";
		$sonuc=$_db->prep_exec($sql, array());
		if ($sonuc){
			return $sonuc[0][REVIZYON_NO];
		} else {
			return "00";
		}
	}
	function durumKontrol($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select REVIZYON_DURUMU,SON_TASLAK_PDF from M_YETERLILIK_REVIZYON where yeterlilik_id=$yeterlilik_id order by revizyon_no desc";
		$sonuc=$_db->prep_exec($sql, array());
		if ($sonuc){
			$durum=$sonuc[0][REVIZYON_DURUMU];
			$sonhali=$sonuc[0][SON_TASLAK_PDF];
		} else {
			$sql="select YETERLILIK_SUREC_DURUM_ID from M_YETERLILIK where yeterlilik_id=$yeterlilik_id";
			$sonuc=$_db->prep_exec($sql, array());
			$durum=$sonuc[0][YETERLILIK_SUREC_DURUM_ID];
			$sql="select SON_TASLAK_PDF from M_TASLAK_YETERLILIK where yeterlilik_id=$yeterlilik_id";
			$sonuc=$_db->prep_exec($sql, array());
			$sonhali=$sonuc[0][SON_TASLAK_PDF];
		}
		return array($durum,$sonhali);
	}
	
	
	function revizyonListesi($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		$sql="select * from M_YETERLILIK_REVIZYON where yeterlilik_id=$yeterlilik_id order by revizyon_no";
		return $_db->prep_exec($sql, array());
	}

	function yeterlilikRevizyonGuncelle ($data, $yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "UPDATE m_yeterlilik 
					SET YAYIN_TARIHI = to_date (?, 'dd/mm/yyyy'),
						KARAR_TARIHI = to_date (?, 'dd/mm/yyyy'),
						KARAR_SAYI = ?,
						YETERLILIK_KODU = ? ,
						GECERLILIK_SURESI = ?
			   WHERE yeterlilik_id = ?";
		// ikinci parametre yalnis yazilmis.
		// $data["tarih"] olan parametre $data["karar_tarih"] olarak degistirildi:
		$params = array ($data["yayin_tarihi"],
						 $data["karar_tarih"],
						 $data["sayi"],
						 $data["referans_kodu"],
						 $data["gecerlilik"],
						 $yeterlilik_id);
		
		return $_db->prep_exec_insert($sql, $params);
	}
		
	function taslakRevizyonGuncelle ($data, $yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		if ($data ["revizyonNo"]=="00"){
		$sql= "UPDATE m_taslak_yeterlilik 
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
			   WHERE yeterlilik_id = ?";
		
		$params = array ($data ["revizyon_tarih"],
						 "00",
						 $data ["editable"],
						 null,
						 $data ["path_taslakPdf_0_1"],
						 $data ["path_taslakPdf_0_2"],
						 $data ["path_taslakPdf_0_3"],
 						 $data ["goruse_cikma_tarihi"],
						 $data ["son_gorus_tarihi"],
						 $data ["path_taslakPdf_0_4"],
						 $yeterlilik_id);
		} else {
			FormParametrik::uyariKaydet(Array(YETERLILIK_REVIZYONU,$data ["revizyonNo"]),$yeterlilik_id,$data ["revizyon_durum"]);
			$sql="DELETE from M_YETERLILIK_REVIZYON where YETERLILIK_ID=$yeterlilik_id and REVIZYON_NO=".$data ["revizyonNo"];
			$_db->prep_exec_insert($sql, array());
			$sql= "UPDATE m_taslak_yeterlilik 
						SET EDITABLE = ?
				   WHERE yeterlilik_id = ?";
			
			$params = array ($data ["editable"], $yeterlilik_id);
			$_db->prep_exec_insert($sql, $params);
			$sql= "INSERT INTO M_YETERLILIK_REVIZYON 	(
				YETERLILIK_ID, 
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
				YETERLILIK_KODU
				) VALUES  (	?, ?, to_date (?, 'dd/mm/yyyy'), ?, to_date (?, 'dd/mm/yyyy'), ?, to_date (?, 'dd/mm/yyyy'), ?, ?, ?, ?, to_date (?, 'dd/mm/yyyy'), to_date (?, 'dd/mm/yyyy'),?)";
				
			
			$params = array ($yeterlilik_id,
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
					$data ["referans_kodu"]);
				
		}	
		
		$sqlGecSure = "UPDATE M_YETERLILIK SET GECERLILIK_SURESI = ? WHERE YETERLILIK_ID = ?";
		$_db->prep_exec_insert($sqlGecSure, array($data['gecerlilik'],$yeterlilik_id));
		
		return $_db->prep_exec_insert($sql, $params);
	}

	
	function yeterlilikDurumGuncelle ($durum, $yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		FormParametrik::uyariKaydet(Array(YETERLILIK,"00"),$yeterlilik_id,$durum);
		$sql= "UPDATE m_yeterlilik 
					SET YETERLILIK_SUREC_DURUM_id = $durum 
			   WHERE yeterlilik_id = $yeterlilik_id";
		$params = array ();
		
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function getTaslakBilgi ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT YETERLILIK_ADI,
					  SEVIYE_ADI,
					  SEKTOR_ADI,
					  YETERLILIK_SUREC_DURUM_ID,  
					  YETERLILIK_SUREC_DURUM_ADI,
					  YETERLILIK_KODU,
					  EDITABLE,
					  ILK_TASLAK_PDF,
					  RESMI_GORUS_ONCESI_PDF,
					  SEKTOR_KOMITESI_ONCESI_PDF,
					  YONETIM_KURULU_ONCESI_PDF,
					  SON_TASLAK_PDF,
					  GECERLILIK_SURESI 
			   FROM m_taslak_yeterlilik 
			   	 JOIN m_yeterlilik 		  USING (yeterlilik_id) 
			   	 JOIN pm_seviye    		  USING (seviye_id)
			   	 JOIN pm_sektorler 		  USING (sektor_id)			   	 
			   	 JOIN pm_YETERLILIK_SUREC_DURUM USING (YETERLILIK_SUREC_DURUM_id)			   	 
			   WHERE yeterlilik_id = ?";
		
		$params = array ($yeterlilik_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	
	function getRevizyonBilgi ($yeterlilik_id,$revizyon_no=""){
		$_db = &JFactory::getOracleDBO();
		
		if ($revizyon_no==""){
			$revizyon_no=$this->revizyonVarMi($yeterlilik_id);			
		}
		if ($revizyon_no=="00"){
		$sql= "SELECT 
					  REVIZYON_NO,
					  YETERLILIK_KODU,
					  TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  TO_CHAR (GORUSE_CIKMA_TARIHI, 'dd.mm.yyyy') GORUSE_CIKMA_TARIHI,
					  TO_CHAR (SON_GORUS_TARIHI	  , 'dd.mm.yyyy') SON_GORUS_TARIHI,
					  KARAR_SAYI
			   FROM m_yeterlilik 
			   	  JOIN m_taslak_yeterlilik USING (yeterlilik_id) 
			   WHERE yeterlilik_id = ?";
		$params = array ($yeterlilik_id);
		} else {
			$sql= "SELECT
			REVIZYON_NO, 
			YETERLILIK_KODU,
			TO_CHAR (YAYIN_TARIHI	  , 'dd.mm.yyyy') YAYIN_TARIHI,
			TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
			TO_CHAR (YKK_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
			TO_CHAR (GORUSE_CIKMA_TARIHI, 'dd.mm.yyyy') GORUSE_CIKMA_TARIHI,
			TO_CHAR (SON_GORUS_TARIHI	  , 'dd.mm.yyyy') SON_GORUS_TARIHI,
			YKK_SAYISI as KARAR_SAYI,
			REVIZYON_DURUMU,
			RESMI_GORUS_ONCESI_PDF,
		  	SEKTOR_KOMITESI_ONCESI_PDF,
		  	YONETIM_KURULU_ONCESI_PDF,
		  	SON_TASLAK_PDF 

			FROM m_yeterlilik_revizyon
			WHERE yeterlilik_id = ? and REVIZYON_NO= ? ";
				
		$params = array ($yeterlilik_id,$revizyon_no);
		}
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getYeterlilikDurum($revizyon_mu){
		$_db = &JFactory::getOracleDBO();
		$_db = &JFactory::getOracleDBO();
		if ($revizyon_mu==1){
			$sqlpart="pm_YETERLILIK_REVIZYON_SUREC";
		} else {
			$sqlpart="pm_YETERLILIK_SUREC_DURUM";
		}
		
		$sql= "SELECT *
			   FROM ".$sqlpart."
			   WHERE YETERLILIK_SUREC_DURUM_id != ".PROTOKOL_LISTE_REDDEDILMIS_YETERLILIK."
			   ORDER BY SIRA";
		
		return $_db->loadList($sql);
	}
	
	function pdfGoster ($yeterlilik_id, $id, $revize_no){
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
			$tablo="M_TASLAK_YETERLILIK";
			$sqlpart="";
		} else {
			$tablo="M_YETERLILIK_REVIZYON";
			$sqlpart="AND REVIZYON_NO=".$revize_no;
		}

		$sql = "SELECT ".$select.
			  " FROM ".$tablo."  
			    WHERE YETERLILIK_ID = ? ".$sqlpart;

		$r = $_db->prep_exec_array($sql, array ($yeterlilik_id));

		$file = $r[0];	
		FormFactory::readFileFromDB($file);
	}
	
	/**
	 * 
	 * Secilen PDF belgesinin veritabanindan silinmesini saglar
	 * @param integer $yeterlilik_id
	 * @param integer $id
	 */
	
	function pdfSil ($yeterlilik_id, $id, $revize_no){
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
			$tablo="M_TASLAK_YETERLILIK";
			$sqlpart="";
		} else {
			$tablo="M_YETERLILIK_REVIZYON";
			$sqlpart="AND REVIZYON_NO=".$revize_no;
		}

		$sql = "UPDATE ".$tablo."
					SET ".$select." = NULL 
			   WHERE YETERLILIK_ID = ? ".$sqlpart;
		
		$result = $_db->prep_exec_insert($sql, array ($yeterlilik_id));
		
		if ($result){
			return JText::_("PDF Başarıyla Silindi");
		}else{
			return JText::_("Silme İşlemi Başarısız");
		}
			
	}
	
	function pdfSilYeni ($yeterlilik_id, $id, $revize_no){
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
			case 5:
				$select = "YAYINLANMIS_YETERLILIK_PDF";
				break;
		}
	
		$tablo="M_TASLAK_YETERLILIK";
		$sqlpart="AND REVIZYON_NO=".$revize_no;
		$sql = "UPDATE ".$tablo."
					SET ".$select." = NULL
			   WHERE YETERLILIK_ID = ? ".$sqlpart;
	
		$result = $_db->prep_exec_insert($sql, array ($yeterlilik_id));
	
		if ($result){
			return JText::_("PDF Başarıyla Silindi");
		}else{
			return JText::_("Silme İşlemi Başarısız");
		}
			
	}
}
?>