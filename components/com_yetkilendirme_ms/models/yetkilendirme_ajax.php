<?php
defined('_JEXEC') or die('Restricted access');


require_once('libraries/form/functions.php');

class Yetkilendirme_MsModelYetkilendirme_Ajax extends JModel
{

    function ajaxSaveRow()
    {

        $_db = JFactory::getOracleDBO();
        $columns = array();
        //DB Columns
        $dbParams = array('meslekSeviyesi', 'meslekAdi', 'hazirlamaBaslangic', 'hazirlamaBitis', 'meslekSektoru', 'revizyon');

        $id = $_db->getNextVal('MESLEK_STD_ID_seq');
        $columns[] = $id;

        foreach ($dbParams as $key) {
            if (isset($_REQUEST[$key]))
                $columns[] = $_REQUEST[$key];
        }

        $sql = " INSERT INTO m_meslek_standartlari (standart_id, seviye_id, MESLEK_STANDART_SUREC_DURUM_ID, standart_adi, bitis_Tarihi, sektor_id, meslek_standart_durum_id,revizyon)
					 VALUES (?, ?, -4, ?, TO_DATE(?, 'dd.mm.yyyy'), ?, " . PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK . ",?)";

        //@ for disable error display
        if (@$_db->prep_exec_insert($sql, $columns)) {
            $sql2 = "INSERT INTO m_yetki_standart (yetki_id, standart_id) VALUES (?, ?)";
            $yetkilendirmeID = $_REQUEST['yetkilendirmeID'];

            if (@$_db->prep_exec_insert($sql2, array($yetkilendirmeID, $id)))
                ajax_success_response('Satır başarıyla kaydedilmiştir.', $id);
            else
                ajax_error_response('Standardı Yetkilendirmeye Eklemede Hata Oluştu.');
        } else {
            ajax_error_response('Standart Yaratırken Sistemde Bir Hata Oluştu');
        }


    }

    function ajaxEditRow()
    {
        $yetkilendirmeID = $_REQUEST['yetkilendirmeID'];

        $_db = JFactory::getOracleDBO();
        $id = $_POST['id'];

        $columns = array();

        //DB Columns
        $dbParams = array('meslekSeviyesi', 'meslekAdi', 'hazirlamaBaslangic', 'meslekSektoru', 'revizyon', 'id');

        foreach ($dbParams as $key) {
            if (isset($_POST[$key]))
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
            ajax_success_response('İlgili satır başarıyla kaydedildi.', $id);
        else
            ajax_error_response('Hata Oluştu');
    }

    function ajaxDeleteRow()
    {
        $_db = JFactory::getOracleDBO();
        $id = $_POST['id'];
        $standart_id = $id;

        $sql = "DELETE FROM m_yetki_standart WHERE standart_id = ? AND YETKI_ID = ?";

        $yetkilendirmeID = $_REQUEST['yetkilendirmeID'];

        if (@$_db->prep_exec_insert($sql, array($id, $yetkilendirmeID))) {
            $sonuc = true;
            $_db = &JFactory::getOracleDBO();

            $sql = "Select meslek_standart_durum_id FROM m_meslek_standartlari WHERE standart_id = ?";
            $params = array($standart_id);
            $result = $_db->prep_exec($sql, $params);

            if ($result[0]["MESLEK_STANDART_DURUM_ID"] == PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK) {
                $sql = "DELETE FROM m_meslek_standartlari WHERE standart_id =? ";
                $params = array($standart_id);
                $sonuc = $_db->prep_exec_insert($sql, $params);
            }
            //// BU KISIM MODELDE GETYETKILENDIRMESTANDARTLARI METODUNDAN
            $db = &JFactory::getOracleDBO();
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

            $params = array($yetkilendirmeID, -3);
            $yeniStandartlar = $db->prep_exec($sql, $params);
            /////////////
            if ($sonuc == true) {
                ajax_success_response_with_array('SatÄ±r baÅŸarÄ±yla silindi.', $yeniStandartlar);
            } else
                ajax_error_response('Standart deÄŸiÅŸtirilmiÅŸ.');
        } else
            ajax_error_response('Standardı Yetkilendirmeden Çıkarırken Hata Oluştu.');


    }

    function ajaxFetchExistingStandart()
    {

        if (isset($_REQUEST['seviyeID']) && $_REQUEST['seviyeID'] != 0)
            $seviyeText = " m_meslek_standartlari.seviye_id = " . $_REQUEST['seviyeID'];
        if (isset($_REQUEST['sektorID']) && $_REQUEST['sektorID'] != 0)
            $sektorText = " m_meslek_standartlari.sektor_id = " . $_REQUEST['sektorID'];
        if (isset($seviyeText) && isset($sektorText))
            $andText = " AND ";

        $yetkilendirmeID = $_REQUEST['yetkilendirmeID'];
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
					
				WHERE " . $seviyeText . $andText . $sektorText . "
					AND m_meslek_standartlari.meslek_standart_surec_durum_id NOT IN (" . REDDEDILMIS_STANDART . ")";
// m_meslek_standartlari.standart_id in (SELECT standart_id FROM m_yetki_standart)
        // AND
        $result = @$_db->prep_exec($sql, array());

        if (count($result) > 0)
            ajax_success_response_with_array('Sorgu başarılı', $result);
        else
            ajax_error_response('Kayıt bulunamadı');
    }


    function ajaxAddFromVarolanStandartlar()
    {
        $eklenecekStandartlar = $_REQUEST['varolanStandartlarCheckbox'];
        $yetkilendirmeID = $_REQUEST['yetkilendirmeID'];

        $_db = JFactory::getOracleDBO();
        $result = true;
        for ($i = 0; $i < count($eklenecekStandartlar); $i++) {
            $revizyonCount = 0;
            $revizyonSql = "SELECT REVIZYON FROM M_MESLEK_STANDARTLARI WHERE STANDART_ID=?";
            $revizyonSqlResult = $_db->prep_exec($revizyonSql, array($eklenecekStandartlar[$i]));
            $revizyon = $revizyonSqlResult[0]["REVIZYON"];

            $sql = "INSERT INTO m_yetki_standart(YETKI_ID, STANDART_ID, REVIZYON_NO ) VALUES (?,?,?)";
            $result = $result && $_db->prep_exec_insert($sql, array($yetkilendirmeID, $eklenecekStandartlar[$i], $revizyon));
        }


        if ($result == true) {
            // RESULT TRUE, BASARILI, YENI STANDARTLARI ARRAYA KOY YOLLA
            $db = &JFactory::getOracleDBO();
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

            $params = array($yetkilendirmeID, -3);
            $yetkilendirmeStandartlari = $db->prep_exec($sql, $params);

            ajax_success_response_with_array('Başarılı', $yetkilendirmeStandartlari);
        } else
            ajax_error_response('Başarısız');
    }

    function ajaxFilterYetkilendirmeler($kurulusAdi, $standartAdi, $standartSektorIDleri)
    {
        $db = &JFactory::getOracleDBO();

        $condition = " 1=1 ";
        if (isset($kurulusAdi) && $kurulusAdi <> "") {
            $condition .= " AND M_KURULUS.KURULUS_ADI LIKE TURKCE_UPPER('" . FormFactory::toLowerCase($kurulusAdi) . "%') ";
        }

        if (isset($standartAdi) && $standartAdi <> "") {
            $condition .= " AND M_MESLEK_STANDARTLARI.STANDART_ADI LIKE TURKCE_UPPER('" . FormFactory::toLowerCase($standartAdi) . "%') ";
        }

        if (count($standartSektorIDleri) > 0) {
            $condition .= " AND M_MESLEK_STANDARTLARI.SEKTOR_ID IN (" . implode(",", $standartSektorIDleri) . ") ";
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
					      WHERE " . $condition . "
					   ORDER BY M_YETKI.ADI";

        // PM_YETKILENDIRMETURU_MESLEKSTANDARDIYETKILENDIRME
        $yetkilendirmeStandartlari = $db->prep_exec($sql, array());

        if (count($yetkilendirmeStandartlari) != 0)
            ajax_success_response_with_array('Başarılı', $yetkilendirmeStandartlari);
        else
            ajax_error_response('Başrısız');

    }

    function ajaxUzatmaKaydet()
    {
        $_db = JFactory::getOracleDBO();
        $columns = array();
        //DB Columns
        $dbParams = array('protokolID', 'uzatmaAciklama');

        $id = $_db->getNextVal(UZATMA_SEQ);

        foreach ($dbParams as $key) {
            if (isset($_REQUEST[$key]))
                $columns[] = $_REQUEST[$key];
        }

        $columns[] = FormParametrik::harfleriTexttenCikar($_REQUEST['uzatmaSuresi']);
        $columns[] = $id;

        $sql = " INSERT INTO m_yetki_sure_uzatma (yetki_id, aciklama, uzatma_suresi, uzatma_id)
		VALUES (?, ?, ?, ?)";

        //@ for disable error display
        if (@$_db->prep_exec_insert($sql, $columns)) {
            ajax_success_response('Satır Başarıyla Kaydedilmiştir.', $id);
        } else {
            ajax_error_response('Hata Oluştu');
        }
    }

    function ajaxUzatmaGuncelle()
    {
        $_db = JFactory::getOracleDBO();
        $id = $_POST['id'];

        $columns = array();

        //DB Columns
        $dbParams = array('uzatmaSuresi', 'uzatmaAciklama', 'protokolID');

        foreach ($dbParams as $key) {
            if (isset($_REQUEST[$key]))
                $columns[] = $_REQUEST[$key];
        }

        $columns[] = $id;

        $sql = " UPDATE m_yetki_sure_uzatma
		SET uzatma_suresi = ?,
		aciklama = ?
		WHERE yetki_id = ? AND uzatma_id = ?";

        //@ for disable error display
        if (@$_db->prep_exec_insert($sql, $columns)) {
            ajax_success_response('Satır Başarıyla Kaydedilmiştir.');
        } else {
            ajax_error_response('Hata Oluştu');
        }
    }

    function ajaxUzatmaSil()
    {
        $protokolID = $_REQUEST['protokolID'];

        $_db = JFactory::getOracleDBO();
        $id = $_POST['id'];

        $sql = "DELETE FROM m_yetki_sure_uzatma WHERE yetki_id = ? AND uzatma_id = ?";

        if (@$_db->prep_exec_insert($sql, array($protokolID, $id))) {
            ajax_success_response('Satır Başarıyla Kaydedilmiştir.');
        } else {
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