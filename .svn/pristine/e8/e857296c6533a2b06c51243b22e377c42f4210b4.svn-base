<?php
defined('_JEXEC') or die('Restricted access');

class Yetkilendirme_YetModelYetkilendirme_Yet extends JModel {

	/*OK*/function getKuruluslar_MeslekiYeterlilikYetkili (){
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
					ORDER BY KURULUS_ADI";
	
		$params = array ("3", "6", "9", "10", "12", "13", "15", "16" );
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
	
	/*OK*/function getProtokoller()
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
		
		$params = array (PM_PROTOKOLTURU_YETERLILIKPROTOKOLU);// mesleki yeterlilik
		return $db->prep_exec($sql, $params);
		
	}
	/*OK*/function getProtokol($protokolID)
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
		
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	
	/*OK*/function getProtokolKuruluslari($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * 
				FROM m_Kurulus_yetki, m_kurulus 
				WHERE m_Kurulus.USER_id = M_kurulus_yetki.USER_ID AND m_kurulus_yetki.YETKI_ID = ?
				ORDER BY m_kurulus.user_id";
		
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	
	function getProtokolStandartlari($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	STANDART_ID,
						STANDART_ADI,
						SEVIYE_ID,
						SEVIYE_ADI, 
						SEKTOR_ADI, 
						TO_CHAR(m_meslek_standartlari.BASLANGIC_TARIHI, 'dd.mm.yyyy') AS BASLANGIC_TARIHI, 
						TO_CHAR(m_meslek_standartlari.BITIS_TARIHI, 'dd.mm.yyyy') AS BITIS_TARIHI 
				FROM m_yetki, m_yetki_standart 
					 JOIN m_meslek_standartlari USING (standart_id) 
					 JOIN pm_sektorler USING (SEKTOR_ID)  
					 JOIN pm_seviye USING (SEVIYE_ID)  
				WHERE m_yetki.YETKI_ID = m_yetki_standart.YETKI_ID 
      			AND m_yetki_standart.YETKI_ID = ?";
		
		$params = array ($protokolID);
		return $db->prep_exec($sql, $params);
	}
	
	/*OK*/function getProtokolYeterlilikleri($protokolID)
	{
		$db  = &JFactory::getOracleDBO();
		
	/*$sql = "SELECT m_yetki.YETKI_ID, m_yeterlilik.YETERLILIK_ID, m_yeterlilik.YETERLILIK_ADI, 
				        m_yeterlilik.SEVIYE_ID, pm_seviye.SEVIYE_ADI, m_standart_yeterlilik.STANDART_ID,  m_meslek_standartlari.standart_adi, 
				        pm_sektorler.SEKTOR_ADI,
				        TO_CHAR(m_yeterlilik.YETERLILIK_TESLIM_TARIHI, 'dd.mm.yyyy') AS YETERLILIK_TESLIM_TARIHI  
				FROM m_yetki, m_yetki_yeterlilik, m_yeterlilik, m_standart_yeterlilik, m_meslek_standartlari, pm_sektorler, pm_seviye  
				WHERE m_yetki.YETKI_ID = m_yetki_yeterlilik.YETKI_ID 
				   AND m_yeterlilik.yeterlilik_id = m_yetki_yeterlilik.yeterlilik_id 
				   AND m_standart_yeterlilik.yeterlilik_id = m_yeterlilik.yeterlilik_id
				   AND m_meslek_standartlari.standart_id = m_standart_yeterlilik.standart_id
				   AND pm_sektorler.sektor_id = m_yeterlilik.sektor_id
				   AND pm_seviye.seviye_id = m_yeterlilik.seviye_id
				   AND m_yetki_yeterlilik.YETKI_ID = ?
				   AND NOT m_yeterlilik.YETERLILIK_SUREC_DURUM_ID = ?";  */
		
		$sql = " SELECT  DISTINCT	YETKI_ID, 
							YETERLILIK_ID, 
							YETERLILIK_ADI, 
							SEVIYE_ID, 
							SEVIYE_ADI, 
							SEKTOR_ADI,
							REVIZYON, 
							TO_CHAR(YETERLILIK_TESLIM_TARIHI, 'dd.mm.yyyy') AS YETERLILIK_TESLIM_TARIHI 
		
				FROM 	m_yetki JOIN m_yetki_yeterlilik USING (YETKI_ID)
								LEFT JOIN m_taslak_yeterlilik USING (YETERLILIK_ID)
								JOIN m_yeterlilik USING (YETERLILIK_ID) 
								JOIN pm_sektorler USING (SEKTOR_ID) 
								JOIN pm_seviye USING (SEVIYE_ID)
				
				WHERE YETKI_ID = ? AND NOT YETERLILIK_SUREC_DURUM_ID = ? AND NOT YETERLILIK_DURUM_ID IS NULL";
	
		$params = array ($protokolID, -3 ); //-3 ->deleted
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
	/*OK*/function getProtokolEtkinlikDurumlari()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DURUM_ID, ACIKLAMA
					FROM pm_yetki_durumu";
	
		$params = array ();
		return $db->prep_exec($sql, $params);
	
	}

	/*OK*/function getMeslekStandartSektorleri()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT *
						FROM pm_sektorler  
						WHERE sektor_durum=?";
		
		$params = array ("1");//aktif sektorler
		return $db->prep_exec($sql, $params);
	}
	
	/*OK*/function getMeslekStandartSeviyeleri()
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
	
	/*OK*/function getUlusalStandartlar()
	{
		$db  = &JFactory::getOracleDBO();
		
		$sql = "SELECT STANDART_ID, STANDART_ADI FROM M_MESLEK_STANDARTLARI WHERE MESLEK_STANDART_SUREC_DURUM_ID = ?";
		
		$params = array (RESMI_GAZETEDE_YAYINLANMIS_STANDART);
		return $db->prep_exec($sql, $params);
	}
	
	function meslekiYeterlilikProtokoluMu($protokolID)
	{
		$result = false;
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT * FROM m_yetki WHERE yetki_turu = ? AND YETKI_ID = ?";
	
		$params = array ( PM_PROTOKOLTURU_YETERLILIKPROTOKOLU ,$protokolID);
		if(count($db->prep_exec($sql, $params)) > 0)
		$result = true;
	
		return $result;
	}
	/*OK*/function pdfGoster ($protokolID){
		$_db = &JFactory::getOracleDBO();

		$sql = "SELECT DOSYA
				    FROM M_YETKI 
				    WHERE YETKI_ID = ?";
	
	
		$r = $_db->prep_exec_array($sql, array ($protokolID));
	
		$file = $r[0];
	
		FormFactory::readFileFromDB($file);
	}
	
	function revizyonOlustur($datas) {
		$db = &JFactory::getOracleDBO();
		$sql_yeterlilik = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID='".$datas['YETERLILIK_ID']."'";
		$yeterlilik = $db->prep_exec($sql_yeterlilik, array());
	
// 		$db->prep_exec($sql_yeterlilik, array());
// 		$sql_birim = "SELECT * FROM M_YETERLILIK_BIRIM WHERE YETERLILIK_ID='".$datas['YETERLILIK_ID']."'";
// 		$birimler = $db->prep_exec($sql_birim, array());
		if(count($yeterlilik) == 1){
			$sql = "INSERT INTO M_YETERLILIK(YETERLILIK_ID,SEVIYE_ID,SEKTOR_ID,YETERLILIK_SUREC_DURUM_ID,YETERLILIK_ADI,YETERLILIK_KODU,YETERLILIK_YASAL,YAYIN_TARIHI,KARAR_TARIHI,KARAR_SAYI,YENI_MI,YETERLILIK_TESLIM_TARIHI,KAYNAK_TESKIL_EDENLER,YETERLILIK_DURUM_ID,YETERLILIK_BASLANGIC,YETERLILIK_BITIS,BASLANGIC_KRITERI,GECERLILIK_SURESI,ALTERNATIF_TIPI,MIN_SECMELI_BIRIM_SAYISI,REVIZYON,REVIZYON_TARIHI)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			unset($yeterlilik[0]['YETERLILIK_ID']);
			$db->prep_exec_insert($sql, array(
										$db->getNextVal('YETERLILIK_ID_seq'),
										$datas['SEVIYE_ID'],
										$datas['SEKTOR_ID'],
										"-4",
										$yeterlilik[0]['YETERLILIK_ADI'],
										$yeterlilik[0]['YETERLILIK_KODU'],
										$yeterlilik[0]['YETERLILIK_YASAL'],
										$yeterlilik[0]['YAYIN_TARIHI'],
										$yeterlilik[0]['KARAR_TARIHI'],
										$yeterlilik[0]['KARAR_SAYI'],
										'1',
										$datas['YETERLILIK_TESLIM_TARIHI'],
										$yeterlilik[0]['KAYNAK_TESKIL_EDENLER'],
										"-2",
										$yeterlilik[0]['YETERLILIK_BASLANGIC'],
										$yeterlilik[0]['YETERLILIK_BITIS'],
										$yeterlilik[0]['BASLANGIC_KRITERI'],
										$yeterlilik[0]['GECERLILIK_SURESI'],
										$yeterlilik[0]['ALTERNATIF_TIPI'],
										$yeterlilik[0]['MIN_SECMELI_BIRIM_SAYISI'],
										$datas['REVIZYON'],
										date('d/m/Y')));
			
// 			foreach ($birimler as $birim){
// 				$sql = "INSERT INTO M_YETERLILIK_BIRIM(BIRIM_ID,ZORUNLU,SIRA_NO) VALUES(?,?,?)";
// 				unset($birim['YETERLILIK_ID']);
// 				$db->prep_exec_insert($sql, $birim);
// 			}

			$sql = "SELECT YETERLILIK_ID,REVIZYON FROM M_YETERLILIK WHERE ROWNUM <= 1 ORDER BY YETERLILIK_ID DESC";
			$id = current($db->prep_exec($sql, array()));
			
			$sql_yetki = "INSERT INTO m_yetki_yeterlilik(YETKI_ID, YETERLILIK_ID, REVIZYON_NO) VALUES ( ?,?, ?)";
			$db->prep_exec_insert($sql_yetki, array($datas['PROTOKOL_ID'],$id['YETERLILIK_ID'],$id['REVIZYON']));
			
			$result['status'] = "1";
			$result['yeterlilik_id'] = $id['YETERLILIK_ID']; 
			$result['revizyon'] = ($id['REVIZYON'] == null ? "01" : $id['REVIZYON']);
		}else{
			$result['status'] = "0";
			$result['yeterlilik_id'] = "";
		}
		return $result;
	}
	function getPmYeterlilikDurumlar(){
		$db = &JFactory::getOracleDBO();
		$yeterlilik_durum = $db->prep_exec("SELECT * FROM PM_YETERLILIK_DURUM ORDER BY YETERLILIK_DURUM_ID", array());
		return $yeterlilik_durum;
	}
	function YeterlilikGetirByStatus($status){
		$db = &JFactory::getOracleDBO();
		$condition = ($status == null || $status == "" ? "" : " AND YETERLILIK_DURUM_ID=".$status);
		$yeterlilikler = $db->prep_exec("SELECT M_YETERLILIK.YETERLILIK_ID,M_YETERLILIK.YETERLILIK_ADI||' - '||PM_SEVIYE.SEVIYE_ADI||' - Revizyon '||M_YETERLILIK.REVIZYON AS YETERLILIK_ADI FROM M_YETERLILIK INNER JOIN PM_SEVIYE ON M_YETERLILIK.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID WHERE 1 = 1 ".$condition." ORDER BY M_YETERLILIK.YETERLILIK_ADI,M_YETERLILIK.SEVIYE_ID,M_YETERLILIK.REVIZYON", array());
		return $yeterlilikler;
	}
	function YeterlilikGetirById($yetid){
		$db = &JFactory::getOracleDBO();
		if($yetid <> "" && $yetid <> null){
			$yeterlilik = $db->prep_exec("SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID='".$yetid."'", array());
			if(count($yeterlilik) > 0){
				$yeterlili_bilgi = current($yeterlilik);
				$revizyon = ($yeterlili_bilgi['REVIZYON'] == null ? "01" : ($yeterlili_bilgi['REVIZYON']+1));
				if(strlen($revizyon) < 2){
					$revizyon = ($yeterlili_bilgi['REVIZYON'] == null ? "01" : ($yeterlili_bilgi['REVIZYON']+1));
					$revizyon = str_pad($revizyon, 2, '0', STR_PAD_LEFT);
				}
				$yeterlili_bilgi['REVIZYON'] = $revizyon;
				$result['status'] = "1";
				$result['result'] = $yeterlili_bilgi;
			}else {
				$result['status'] = "0";
			}
		}else{
			$result['status'] = "0";
		}
		return $result;
	}
	
	function updateYeterlilikStatus($post){
		$db = &JFactory::getOracleDBO();
	
		if($post['yeterlilik_durum'] == "iptal"){
			$yeterlilik_durum_id = '-6';
			$yeterlilik_surec_durum_id = '-2';
		}
	
		if($yeterlilik_durum_id <> "" && $yeterlilik_surec_durum_id <> ""){
			$sql = "UPDATE M_YETERLILIK 
					   SET YETERLILIK_DURUM_ID = ?,
					       YETERLILIK_SUREC_DURUM_ID = ? 
					 WHERE YETERLILIK_ID = ?";
				
			$db->prep_exec_insert($sql, array($yeterlilik_durum_id,$yeterlilik_surec_durum_id,$post['yeterlilik_id']));
			$return['ERROR'] = true;
			$return['MESSAGE'] = "Yeterlilik durumu başarıyla değiştirildi";
		}else{
			$return['ERROR'] = false;
			$return['MESSAGE'] = "Yeterlilik durumu değiştirilirken hata oluştu";
		}
	
		return $return;
	}
	
}
?>