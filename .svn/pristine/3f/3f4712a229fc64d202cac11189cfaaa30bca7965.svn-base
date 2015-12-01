<?php
defined('_JEXEC') or die('Restricted access');

class Birim_YonetimiModelBirim_Yonetimi extends JModel {

	
	/*OK*/function getOnaylanacakBirimler()
	{
		$onaylanacakBirimParametrikDurumu = 2;
		
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	*
		FROM m_birim, pm_birim_onay_durumu
		WHERE m_birim.birim_onay_durum = pm_birim_onay_durumu.durum_id 
		AND pm_birim_onay_durumu.durum_id = ?
		";
	
		$params = array ($onaylanacakBirimParametrikDurumu);
		return $db->prep_exec($sql, $params);
	
	}
	/*OK*/function getTumBirimler()
	{
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT 	*
		FROM m_birim, pm_birim_onay_durumu
		WHERE m_birim.birim_onay_durum = pm_birim_onay_durumu.durum_id
		";
	
		$params = array ();
		return $db->prep_exec($sql, $params);
	
	}
	
	function birimleriSil($birimArr, $messageType)
	{
		$message = "";
		for($i=0; $i<count($birimArr); $i++)
		{
			$birimID = $birimArr[$i];
			$params = array($birimID);
			
			$db  = &JFactory::getOracleDBO();
			
			$sql = "SELECT * FROM m_birim WHERE birim_onay_durum=".PM_BIRIM_ONAY_DURUMU__SS_ONAYLAMIS;
			
			$kayitliBirimler = $db->prep_exec($sql, $params);
			
			
			if(count($kayitliBirimler)==0)
			{
								
				$sql = "DELETE FROM m_birim WHERE BIRIM_ID=?";
				$db->prep_exec($sql, $params);
				
				
			}
			else
			{
				$message .= "<li> - ".$kayitliBirimler[0]["BIRIM_ADI"]."</li>";
			}
			
		}
		
		
		if(strlen($message)>0)
		{
			$message = JText::_("DELETE_ERROR_MESSAGE")."<br>".$message;
			$messageType = "error";
		}
		else
		$message = JText::_("DELETE_SUCCESS_MESSAGE");
		
		return $message;
	}
	function getYeterlilikInfo($yeterlilik_Id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_yeterlilik join pm_yeterlilik_durum using(yeterlilik_durum_id) join pm_yeterlilik_surec_durum using(yeterlilik_surec_durum_id)
		WHERE YETERLILIK_ID = ?";
	
		$params = array ($yeterlilik_Id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminEk2si_KontrolListesiz($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_ek2_kntrl_listesiz
		WHERE birim_id = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminEk2si_KontrolListeli($birimID, $tabloTuru)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_ek2_kntrl_listeli
		WHERE birim_id = ? AND ek_tipi=".$tabloTuru."
		ORDER BY EK2_KONTROL_LISTELI_ID ";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminKaynaklari($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT kaynak_id FROM m_birim_kaynak
		WHERE birim_id = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec_array($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminKaynaklariTextListesi($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT standart_adi
		FROM m_birim_kaynak JOIN m_meslek_standartlari ON (m_birim_kaynak.kaynak_id = m_meslek_standartlari.standart_id)
		WHERE birim_id = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec_array($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getYeterliliginSektoru($yeterlilik_Id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_yeterlilik, pm_sektorler
		WHERE  m_yeterlilik.sektor_id = pm_sektorler.sektor_id AND m_yeterlilik.yeterlilik_id = ?";
	
		$params = array ($yeterlilik_Id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBirimiGelistirenKuruluslar($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_gelistiren_kurulus
		WHERE BIRIM_ID = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getSektorValues()
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM pm_sektorler";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getOgrenmeCiktilariByBirim($birim_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim__ogrenme_ciktisi, m_ogrenme_ciktisi
		WHERE m_birim__ogrenme_ciktisi.birim_id = ?
		AND m_birim__ogrenme_ciktisi.ogrenme_ciktisi_id = m_ogrenme_ciktisi.ogrenme_ciktisi_id
		ORDER BY m_ogrenme_ciktisi.ogrenme_ciktisi_id";
	
		$params = array ($birim_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBirimiDogrulayanKomiteUyeleri($birimID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_dogrulayan_komite
		WHERE BIRIM_ID = ?";
	
		$params = array ($birimID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminOlcmeDegerlendirmeleri($birimID, $olcmeDegerlendirmeTipi )
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_birim_olcme_degerlendirme WHERE birim_id=? AND olc_deg_harf=?";
	
		$params = array ($birimID, $olcmeDegerlendirmeTipi );
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBiriminEk1Yazilari($birimID)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT birim_id, ek1_yazisi FROM m_birim_ek1 
			   WHERE birim_id = ? ORDER BY sira_no";
		
		$params = array ($birimID);
		
		$data = $_db->prep_exec($sql, $params);
		
		
		return $data;
		
	}
	function getBaglamByDisIDAndIliskiTipi($idlerArrayi, $iliski_tipi)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_baglam_iliski, m_baglam
		WHERE m_baglam_iliski.baglam_id = m_baglam.baglam_id
		AND m_baglam_iliski.dis_id IN (".implode(" , ", $idlerArrayi).")
		AND m_baglam_iliski.iliski_tipi = ".$iliski_tipi."
		ORDER BY m_baglam_iliski.dis_id";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getEk2Tablosu($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT *
		FROM m_yeterlilik_terim, m_terim
		WHERE m_yeterlilik_terim.yeterlilik_id = ?
		AND m_yeterlilik_terim.terim_id = m_terim.terim_id order by m_terim.terim_adi";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getPMBirimEk2Turleri()
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM pm_birim_ek2_ek_tipi";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getGenelKurulTarihleri ($etkin){
		$db = JFactory::getOracleDBO();
		$sql = "SELECT distinct tarih
		FROM M_GENEL_KURUL
		WHERE aktif_mi='".$etkin."'
		ORDER BY tarih desc";
			
		return $db->prep_exec($sql, array());
	}
	function getGenelKurul()
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_genel_kurul
		where aktif_mi=1 order by sira";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
	
		return $data;
	
	}
	function getYeterlilikKaynagi($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT * FROM M_YETERLILIK_KAYNAK JOIN M_MESLEK_STANDARTLARI ON (M_YETERLILIK_KAYNAK.KAYNAK_ID = M_MESLEK_STANDARTLARI.STANDART_ID)
		WHERE YETERLILIK_ID = ?";
	
		$params = array ($yeterlilik_id);
	
		return $_db->prep_exec($sql, $params);
	}
	
	function getDistinctGenelKurul()
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT KURUM FROM m_genel_kurul where aktif_mi=1 order by sira";
	
		$params = array ();
	
		$data = $_db->prep_exec($sql, $params);
	
	
		return $data;
	
	}
	function getBasarimOlcutleriByOgrenmeCiktisi($ogrenmeCiktisiID)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT * FROM m_ogrenme_ciktisi__basarim_olc, m_basarim_olcutu
		WHERE m_ogrenme_ciktisi__basarim_olc.basarim_olcutu_id = m_basarim_olcutu.basarim_olcutu_id
		AND m_ogrenme_ciktisi__basarim_olc.ogrenme_ciktisi_id = ?";
	
		$params = array ($ogrenmeCiktisiID);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getBirimlerleDetaylari($yeterlilik_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$queryFields = "m_yeterlilik_birim.yeterlilik_id, m_yeterlilik_birim.birim_id, m_birim.birim_adi,
		m_birim.birim_seviye,m_birim.birim_kredi,m_birim.birim_yayin_tar,m_birim.birim_rev_no,
		m_birim.birim_rev_tar, m_yeterlilik_birim.zorunlu, m_ogrenme_ciktisi.ogrenme_ciktisi_id,
		m_ogrenme_ciktisi.ogrenme_ciktisi_yazisi";
	
		$queryTables = "m_yeterlilik_birim, m_yeterlilik, m_birim, m_birim__ogrenme_ciktisi, m_ogrenme_ciktisi";
	
		$sql= "SELECT ".$queryFields." FROM ".$queryTables. "
		WHERE m_yeterlilik_birim.yeterlilik_id = ?
		AND m_yeterlilik_birim.yeterlilik_id = m_yeterlilik.yeterlilik_id
		AND m_yeterlilik_birim.birim_id = m_birim.birim_id
		AND m_birim.birim_id = m_birim__ogrenme_ciktisi.birim_id
		AND m_birim__ogrenme_ciktisi.ogrenme_ciktisi_id = m_ogrenme_ciktisi.ogrenme_ciktisi_id
		ORDER BY m_yeterlilik_birim.yeterlilik_id, m_yeterlilik_birim.birim_id, m_yeterlilik_birim.zorunlu
		";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getDegerlendirmeOgrenmeCiktiValues ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT *
		FROM m_yet_degerlendirme_ogrenme
		JOIN m_yet_degerlendirme_arac USING (degerlendirme_arac_id)
		WHERE yeterlilik_id = ?";
	
		$params = array ($yeterlilik_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
}
?>