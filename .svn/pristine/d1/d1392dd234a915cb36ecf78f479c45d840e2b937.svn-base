<?php
defined('_JEXEC') or die('Restricted access');


class Yetkilendirme_MsModelYetkilendirme_Ms extends JModel {

	function getKuruluslar_MeslekStandardiYetkili (){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	USER_ID,
						KURULUS_ADI,
						KURULUS_YETKILISI,
						KURULUS_YETKILI_UNVANI,
						KURULUS_ADRESI,
						KURULUS_WEB,
						KURULUS_DURUM_ID,
						KURULUS_YETKILENDIRME_NUMARASI,
						KURULUS_SEHIR  
					FROM m_kurulus    
					WHERE kurulus_durum_id IN (?,?,?,?,?,?,?,?)
					ORDER BY USER_ID";
	
		$params = array ("2", "6", "7", "8", "12", "13", "14", "16" );
		return $db->prep_exec($sql, $params);
	}
	
	
	/*OK*/function getKuruluslar_Tumu (){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	USER_ID,
		KURULUS_ADI,
		KURULUS_YETKILISI,
		KURULUS_YETKILI_UNVANI,
		KURULUS_ADRESI,
		KURULUS_WEB,
		KURULUS_DURUM_ID,
		KURULUS_YETKILENDIRME_NUMARASI,
		KURULUS_SEHIR
		FROM m_kurulus
		
		ORDER BY KURULUS_ADI";
		
		return $db->prep_exec($sql, array());
	}
	
	
	function getYetkilendirmeler()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	YETKI_ID, 
						ADI, 
						TO_CHAR(IMZA_TARIHI, 'dd.mm.yyyy') AS IMZA_TARIHI, 
						TO_CHAR(BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI, 
						ETKIN,
						ACIKLAMA,
						ILGILI_PROTOKOL_ID,
						SURESI,
						YETKILENDIRME_TURU,
						PROTOKOL_MU
					FROM m_yetki, pm_yetki_durumu 
					WHERE m_yetki.etkin = pm_yetki_durumu.durum_id AND m_yetki.yetki_turu = ?
					ORDER BY YETKI_ID";
		
		$params = array (PM_YETKILENDIRMETURU_MESLEKSTANDARDIYETKILENDIRME);
		return $db->prep_exec($sql, $params);
		
	}
	function getYetkilendirme($yetkilendirmeID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	YETKI_ID, 
						ADI, 
						TO_CHAR(IMZA_TARIHI, 'dd.mm.yyyy') AS IMZA_TARIHI, 
						TO_CHAR(BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI, 
						ETKIN,
						DOSYA, 
						ACIKLAMA, 
						ILGILI_PROTOKOL_ID,
						SURESI,
						YETKILENDIRME_TURU,
						PROTOKOL_MU
					FROM m_yetki, pm_yetki_durumu 
					WHERE m_yetki.etkin = pm_yetki_durumu.durum_id AND m_yetki.YETKI_ID = ?";
		
		$params = array ($yetkilendirmeID);
		return $db->prep_exec($sql, $params);
	}
	
	function meslekStandardiYetkilendirmesiMi($yetkilendirmeID)
	{
		$result = false;
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM m_yetki WHERE yetki_turu = ? AND YETKI_ID = ?";
		
		$params = array ( PM_YETKILENDIRMETURU_MESLEKSTANDARDIYETKILENDIRME ,$yetkilendirmeID);
		if(count($db->prep_exec($sql, $params)) > 0)
			$result = true;
		
		return $result;
	}
	
	function getYetkilendirmeKuruluslari($yetkilendirmeID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_Kurulus_yetki, m_kurulus 
				WHERE m_Kurulus.USER_id = M_kurulus_yetki.USER_ID AND m_kurulus_yetki.YETKI_ID = ?
				ORDER BY m_kurulus.user_id";
		
		$params = array ($yetkilendirmeID);
		return $db->prep_exec($sql, $params);
	}
	
	function getYetkilendirmeStandartlari($yetkilendirmeID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	STANDART_ID,
						STANDART_ADI,
						SEVIYE_ID,
						SEVIYE_ADI, 
						SEKTOR_ADI,
						REVIZYON,
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
				AND NOT MESLEK_STANDART_DURUM_ID IS NULL";
		
		$params = array ($yetkilendirmeID);
		return $db->prep_exec($sql, $params);
	}
	function getProtokolunSektorleri($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM m_yetki_sektor WHERE yetki_id = ?";
	
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	function getUzatmalar($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM m_yetki_sure_uzatma WHERE yetki_id = ?";
		
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	
	function getYetkilendirmeEtkinlikDurumlari()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DURUM_ID, ACIKLAMA
					FROM pm_yetki_durumu";
	
		$params = array ();
		return $db->prep_exec($sql, $params);
	
	}

	function getOncedenVarolanStandartlar()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT STANDART_ID,
						STANDART_ADI,
						m_meslek_standartlari.SEVIYE_ID,
						SEVIYE_ADI, 
						SEKTOR_ADI, 
						TO_CHAR(m_meslek_standartlari.BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI, 
						TO_CHAR(m_meslek_standartlari.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI  
				FROM m_meslek_standartlari, pm_seviye, pm_sektorler 
				WHERE m_meslek_standartlari.seviye_id = pm_seviye.seviye_id AND m_meslek_standartlari.sektor_id = pm_sektorler.sektor_id
				";
		
		return $db->prep_exec($sql, $params);
	}
	
	function getMeslekStandartSektorleri()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT *
						FROM pm_sektorler  
						WHERE sektor_durum=?";
		
		$params = array ("1");//aktif sektorler
		return $db->prep_exec($sql, $params);
	}
	
	function getMeslekStandartSeviyeleri()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM pm_seviye";
		$params = array ();//boş
		return $db->prep_exec($sql, $params);
	}
	function getYetkilendirmeTurleri()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM pm_yetkilendirme_turu";
		$params = array ();//boş
		return $db->prep_exec($sql, $params);
	}
		
	function pdfGoster ($yetkilendirmeID){
		$_db = &JFactory::getOracleDBO();

		$sql = "SELECT DOSYA
				    FROM M_YETKI 
				    WHERE YETKI_ID = ?";
	
	
		$r = $_db->prep_exec_array($sql, array ($yetkilendirmeID));
	
		$file = $r[0];
	
		FormFactory::readFileFromDB($file);
	}
	
	function getPmStandartDurumlari(){
		$db = &JFactory::getOracleDBO();
		$standart_durum = $db->prep_exec("SELECT * FROM PM_MESLEK_STANDART_DURUM ORDER BY MESLEK_STANDART_DURUM_ID", array());
		return $standart_durum;
	}
	
	function StandartGetirByStatus($status){
		$db = &JFactory::getOracleDBO();
		$condition = ($status == null || $status == "" ? "" : " AND MESLEK_STANDART_DURUM_ID=".$status);
		$standartlar  =  $db->prep_exec("SELECT M_MESLEK_STANDARTLARI.STANDART_ID,
			 								    M_MESLEK_STANDARTLARI.STANDART_ADI||' - '||PM_SEVIYE.SEVIYE_ADI||' - Revizyon '||M_MESLEK_STANDARTLARI.REVIZYON AS STANDART_ADI 
										   FROM M_MESLEK_STANDARTLARI 
					                 INNER JOIN PM_SEVIYE ON M_MESLEK_STANDARTLARI.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID 
									 WHERE 1 = 1 ".$condition." ORDER BY M_MESLEK_STANDARTLARI.STANDART_ADI,M_MESLEK_STANDARTLARI.SEVIYE_ID,M_MESLEK_STANDARTLARI.REVIZYON",array());
		return $standartlar;
	}
	
	function StandartGetirById($standartid){
		$db = &JFactory::getOracleDBO();
		if($standartid <> "" && $standartid <> null){
			$standart = $db->prep_exec("SELECT * FROM M_MESLEK_STANDARTLARI JOIN PM_MESLEK_STANDART_DURUM USING (MESLEK_STANDART_DURUM_ID) 
										WHERE M_MESLEK_STANDARTLARI.STANDART_ID='".$standartid."'", array());
			if(count($standart) > 0){
				$standart_bilgi = current($standart);
				$revizyon = ($standart_bilgi['REVIZYON'] == null ? "01" : ($standart_bilgi['REVIZYON']+1));
				if(strlen($revizyon) < 2){
					$revizyon = ($standart_bilgi['REVIZYON'] == null ? "01" : ($standart_bilgi['REVIZYON']+1));
					$revizyon = str_pad($revizyon, 2, '0', STR_PAD_LEFT);
				}
				$standart_bilgi['REVIZYON'] = $revizyon;
				$result['status'] = "1";
				$result['result'] = $standart_bilgi;
			}else {
				$result['status'] = "0";
			}
		}else{
			$result['status'] = "0";
		}
		return $result;
	}
	
	function revizyonOlustur($datas) {
		$db = &JFactory::getOracleDBO();

		$sql_ms = "SELECT * FROM M_MESLEK_STANDARTLARI WHERE STANDART_ID='".$datas['STANDART_ID']."'";
		$standart = $db->prep_exec($sql_ms, array());
	
		if(count($standart) == 1){
			$standart = current($standart);
			$sql = "INSERT INTO M_MESLEK_STANDARTLARI(STANDART_ID,
													  SEVIYE_ID,
													  MESLEK_STANDART_SUREC_DURUM_ID,
													  STANDART_ADI,
													  YASAL_DUZENLEME,
													  MEVCUT_CALISMA,
													  BASLANGIC_TARIHI,
													  BITIS_TARIHI,
													  ULUSLAR_ARASI_STANDART,
													  STANDART_KODU,
													  STANDART_TANIMI,
													  SEKTOR_ID,
													  YAYIN_TARIHI,
													  KARAR_TARIHI,
													  KARAR_SAYI,
													  RESMI_GAZETE_TARIH,
													  RESMI_GAZETE_SAYI,
													  MESLEK_STANDART_DURUM_ID,
													  REVIZYON,
												      REVIZYON_DURUMU,
													  REVIZYON_TARIHI)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			unset($standart['STANDART_ID']);
			
			$data = array( $db->getNextVal('MESLEK_STD_ID_seq'),
						   $standart['SEVIYE_ID'],
						   '-4',
						   $standart['STANDART_ADI'],
						   $standart['YASAL_DUZENLEME'],
						   $standart['MEVCUT_CALISMA'],
						   $standart['BASLANGIC_TARIHI'],
						   $standart['BITIS_TARIHI'],
						   $standart['ULUSLAR_ARASI_STANDART'],
						   $standart['STANDART_KODU'],
						   $standart['STANDART_TANIMI'],
						   $standart['SEKTOR_ID'],
						   $standart['YAYIN_TARIHI'],
						   $standart['KARAR_TARIHI'],
						   $standart['KARAR_SAYI'],
						   $standart['RESMI_GAZETE_TARIH'],
						   $standart['RESMI_GAZETE_SAYI'],
						   '-3',
						   $datas['REVIZYON'],
						   '1',
						   date('d/m/Y'));

			$db->prep_exec_insert($sql, $data);
			
			$sql = "SELECT STANDART_ID,REVIZYON FROM M_MESLEK_STANDARTLARI WHERE ROWNUM <= 1 ORDER BY STANDART_ID DESC";
			$data = $db->prep_exec($sql, array());
			$id = current($data);
				
			$sql_yetki = "INSERT INTO m_yetki_standart(YETKI_ID, STANDART_ID, REVIZYON_NO) VALUES ( ?,?, ?)";
			$db->prep_exec_insert($sql_yetki, array($datas['PROTOKOL_ID'],$id['STANDART_ID'],$id['REVIZYON']));
				
			$result['status'] = "1";
			$result['standart_id'] = $id['STANDART_ID'];
			$result['revizyon'] = ($id['REVIZYON'] == null ? "01" : $id['REVIZYON']);
		}else{
			$result['status'] = "0";
			$result['standart_id'] = "";
		}
		return $result;
	}
	
	function updateStandartStatus($post){
		$db = &JFactory::getOracleDBO();
		
		if($post['stadart_durum'] == "iptal"){
			$standart_durum_id = '-6';
			$standart_surec_durum_id = '-5';
		}
		
		if($standart_durum_id <> "" && $standart_surec_durum_id <> ""){
			$sql = "UPDATE M_MESLEK_STANDARTLARI 
					   SET MESLEK_STANDART_DURUM_ID = ?,
					       MESLEK_STANDART_SUREC_DURUM_ID = ? 
					 WHERE STANDART_ID = ?";
			
			$db->prep_exec_insert($sql, array($standart_durum_id,$standart_surec_durum_id,$post['standart_id']));
			$return['ERROR'] = true;
			$return['MESSAGE'] = "Meslek standardı durumu başarıyla değiştirildi";
		}else{
			$return['ERROR'] = false;
			$return['MESSAGE'] = "Meslek standardı durumu değiştirilirken hata oluştu";
		}
		
		return $return;
	}
	
}
?>