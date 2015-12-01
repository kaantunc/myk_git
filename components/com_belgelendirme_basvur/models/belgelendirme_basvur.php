<?php
defined('_JEXEC') or die('Restricted access');

class Belgelendirme_BasvurModelBelgelendirme_Basvur extends JModel
{

    var $title = "Sınav ve Belgelendirme Başvuru Formu";
//	var $pages 	  = array ("kurulus_bilgi","irtibat","faaliyet","akreditasyon", "sinav", "ek2", "ek", "form");
//	var $pageNames = array ("Kuruluş Bilgileri", "İrtibat Bilgileri", "Faaliyet Bilgileri", "Akreditasyon Bilgileri", "Sınav Kapsamı", "Ekler", "Kişi Bilgi Eki", "Başvuru Dökümanları");

    var $pages = array("kurulus_bilgi", "irtibat", "faaliyet", "akreditasyon", "sinav", "ek2", "form");
    var $pageNames = array("Kuruluş Bilgileri", "İrtibat Bilgileri", "Faaliyet Bilgileri", "Akreditasyon Bilgileri", "Sınav Kapsamı", "Ekler", "Başvuru Dökümanları");

    function getYetkiTalepValues($evrak_id)
    {
        $_db = JFactory::getOracleDBO();

        $sql = " SELECT *
				 FROM m_belgelendirme_yet_talebi  
				 	JOIN m_yeterlilik USING (yeterlilik_id)
				 	JOIN pm_seviye USING (seviye_id) 
					WHERE evrak_id = ?
					ORDER BY YETERLILIK_ADI, YETERLILIK_KODU, REVIZYON";

        $params = array($evrak_id);

        return $_db->prep_exec($sql, $params);
    }

    function getSinavMerkezValues($evrak_id)
    {
        $_db = JFactory::getOracleDBO();

        $sql = " SELECT *
				 FROM m_sinav_merkezi 
				 	JOIN m_merkez_sinav ms USING (evrak_id, merkez_id)   
		 	        JOIN m_yeterlilik USING (yeterlilik_id)
		            JOIN pm_sinav_sekli USING (sinav_sekli_id)
		            JOIN pm_sinav_merkez_temin USING (merkez_temin_id)
				 WHERE evrak_id = ? 
				 ORDER BY merkez_id";

        $params = array($evrak_id);

        $result = $_db->prep_exec($sql, $params);
        $data = array();

        $tur3mu = array();
        foreach ($result as $row) {
            if (!in_array($row['MERKEZ_ID'], $tur3mu)) {
                $data[$row['MERKEZ_ID']] = $row;
                $tur3mu[] = $row['MERKEZ_ID'];
            } else {
                $data[$row['MERKEZ_ID']]['SINAV_SEKLI_ID'] = 3;
                $data[$row['MERKEZ_ID']]['SINAV_SEKLI_ADI'] = 'Teorik, Pratik';
            }
        }

        return $data;
    }

    function getAkreditasyonValues($evrak_id)
    {
        $_db = JFactory::getOracleDBO();

        $sql = " SELECT AKREDITASYON_ID,
						AKREDITASYON_ADI,
						AKREDITASYON_PATH,
						AKREDITASYON_ACIKLAMA,
						AKREDITASYON_SEVIYE,
						AKREDITASYON_STANDARDI,
						TO_CHAR (AKREDITASYON_BASLANGIC , 'dd.mm.yyyy') as AKREDITASYON_BASLANGIC,
						TO_CHAR (AKREDITASYON_BITIS , 'dd.mm.yyyy') as AKREDITASYON_BITIS,
						TO_CHAR (AKREDITASYON_DENETIM , 'dd.mm.yyyy') as AKREDITASYON_DENETIM,
						TO_CHAR (AKREDITASYON_KAPSAM , 'dd.mm.yyyy') as AKREDITASYON_KAPSAM
				 FROM m_akreditasyon 
				 WHERE evrak_id = ?";

        $params = array($evrak_id);

        return $_db->prep_exec($sql, $params);
    }

    //burda kaldın
    function getBelgelendirmeBasvurular($user_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT 	M_BASVURU.EVRAK_ID, M_BASVURU.USER_ID, TO_CHAR(BASVURU_TARIHI,'dd/mm/yyyy') as BASVURU_TARIHI, M_BELGELENDIRME_DURUM.DURUM_ID, DURUM, BASVURU_TURU
				FROM M_BASVURU
		        JOIN m_belgelendirme_durum ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
		        JOIN pm_belgelendirme_durum ON M_BELGELENDIRME_DURUM.DURUM_ID = PM_BELGELENDIRME_DURUM.DURUM_ID
		        WHERE M_BASVURU.BASVURU_TIP_ID = 3 
		        AND M_BASVURU.USER_ID = ?";

        $params = array($user_id);
        return $db->prep_exec($sql, $params);

    }

    function getBelgelendirmeBasvurularEvrak($evrak_id)
    {
        $db = &JFactory::getOracleDBO();
        $sqluseral = "SELECT user_id
									FROM m_basvuru
									WHERE evrak_id = ?";

        $params = array($evrak_id);
        $user = $db->prep_exec($sqluseral, $params);


        $sql = "SELECT 	M_BASVURU.EVRAK_ID, M_BASVURU.USER_ID, TO_CHAR(BASVURU_TARIHI,'dd/mm/yyyy') as BASVURU_TARIHI, M_BELGELENDIRME_DURUM.DURUM_ID, DURUM, BASVURU_TURU
					FROM M_BASVURU
			        JOIN m_belgelendirme_durum ON M_BASVURU.EVRAK_ID = M_BELGELENDIRME_DURUM.EVRAK_ID
			        JOIN pm_belgelendirme_durum ON M_BELGELENDIRME_DURUM.DURUM_ID = PM_BELGELENDIRME_DURUM.DURUM_ID
			        WHERE M_BASVURU.BASVURU_TIP_ID = 3 
			        AND M_BASVURU.USER_ID = ?";

        $params = array($user[0][USER_ID]);
        return $db->prep_exec($sql, $params);

    }

    function getBasvuruEkleri($evrak_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT *
						FROM M_BELGELENDIRME_BASVURU_EKLERI 
						WHERE EVRAK_ID = ? ORDER BY BELGE_ADI ASC";

        $params = array($evrak_id);
        $data = $db->prep_exec($sql, $params);

        if (!empty($data))
            return $data;
        else
            return null;
    }

    function getBasvuruEkleriPDF($evrak_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT DISTINCT BELGE_TURU
						FROM M_BELGELENDIRME_BASVURU_EKLERI
						WHERE EVRAK_ID = ?";

        $params = array($evrak_id);
        $data = $db->prep_exec($sql, $params);

        if (!empty($data))
            return $data;
        else
            return null;
    }

    function getBasvuruDocs($evrak_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT *
				FROM M_BELGELENDIRME_DOCS 
				WHERE EVRAK_ID = ?";

        $params = array($evrak_id);
        $data = $db->prep_exec($sql, $params);

        if (!empty($data))
            return $data;
        else
            return null;
    }

    function getBasvuruEkleriBelgeTuru($evrak_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT BELGE_TURU
						FROM M_BELGELENDIRME_BASVURU_EKLERI WHERE EVRAK_ID = ? 
						GROUP BY BELGE_TURU";

        $params = array($evrak_id);
        $data = $db->prep_exec($sql, $params);

        if (!empty($data))
            return $data;
        else
            return null;
    }

    function getKayitliYeterlilikler($evrak_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = " SELECT YETERLILIK_ID, YETERLILIK_ADI, SEVIYE_ADI, YETERLILIK_KODU FROM M_BELGELENDIRME_YET_TALEBI
   				JOIN M_YETERLILIK USING (YETERLILIK_ID)
   				JOIN PM_SEVIYE USING (SEVIYE_ID) 
   				WHERE YETERLILIK_SUREC_DURUM_ID = 1 AND EVRAK_ID = ? ORDER BY YETERLILIK_ADI ASC,YETERLILIK_KODU ASC";

        $params = array($evrak_id);
        $data = $db->prep_exec($sql, $params);

        if (!empty($data))
            return $data;
        else
            return null;
    }

    function getDegelendiriciler($evrak_id)
    {
        $db = &JFactory::getOracleDBO();

        $sql = " SELECT YETERLILIK_ID, YETERLILIK_ADI, DEGERLENDIRICI, SEVIYE_ADI
						FROM M_SINAV_DEGERLENDIRICI
		   				JOIN M_YETERLILIK USING (YETERLILIK_ID)
						JOIN PM_SEVIYE USING (SEVIYE_ID)
		   				WHERE EVRAK_ID = ?";

        $params = array($evrak_id);
        $data = $db->prep_exec($sql, $params);

        if (!empty($data))
            return $data;
        else
            return null;
    }

    function getYeterlilikAd()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT m_yeterlilik.yeterlilik_id, m_yeterlilik.yeterlilik_adi, m_yeterlilik.yeterlilik_kodu,m_yeterlilik.revizyon
				FROM m_yeterlilik
				WHERE YETERLILIK_SUREC_DURUM_ID = " . ONAYLANMIS_YETERLILIK . "
				ORDER BY yeterlilik_adi,YETERLILIK_KODU,REVIZYON";

        $data = $_db->loadList($sql);

        foreach ($data as $key => $row) {
            if (!empty($row['YETKOD']) && $row['REVIZYON_DURUMU'] == 1) {
                $data[$key]['YETERLILIK_KODU'] = $row['YETKOD'];
                $data[$key][2] = $row['YETKOD'];
            }
        }
        return $data;
    }

    function getYeterlilikAdYeniBasvurularIcin()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT m_yeterlilik.yeterlilik_id, m_yeterlilik.yeterlilik_adi,m_yeterlilik.revizyon_durumu, m_yeterlilik.yeterlilik_kodu,m_yeterlilik.revizyon
				FROM m_yeterlilik
				WHERE YETERLILIK_SUREC_DURUM_ID = " . ONAYLANMIS_YETERLILIK . "
				ORDER BY REVIZYON DESC";

        $data = $_db->loadList($sql);
        $yenidata = array();
        $yetkod = array();
        $yetAd = array();
        foreach ($data as $key => $val) {
            if (!in_array($val["YETERLILIK_KODU"], $yetkod)) {
                $val[2] = $val['YETERLILIK_KODU'];
                $val[3] = $val['REVIZYON'];
                $yenidata[$val['YETERLILIK_ID']] = $val;
                $yetkod[] = $val["YETERLILIK_KODU"];
                $yetAd[$val['YETERLILIK_ID']] = FormFactory2::formatFilename($val['YETERLILIK_ADI']);
            }
        }
        array_multisort($yetAd, SORT_ASC, $yenidata);
        return $yenidata;
    }

    function belgelendirmeEkSil($post)
    {
        $_db = &JFactory::getOracleDBO();
        $tarih = $post['tarih'];
        $belge = $post['belge'];
        $evrak_id = $post['evrak_id'];

        $sql = "SELECT BELGE_ADI FROM M_BELGELENDIRME_BASVURU_EKLERI WHERE EVRAK_ID=? AND TARIH=? AND BELGE_TURU=?";
        $belgeAdi = $_db->prep_exec($sql, array($evrak_id, $tarih, $belge));

        $sql = "DELETE FROM M_BELGELENDIRME_BASVURU_EKLERI WHERE EVRAK_ID=? AND TARIH=? AND BELGE_TURU=?";
        $_db->prep_exec($sql, array($evrak_id, $tarih, $belge));
        $sildir = EK_FOLDER . "belgelendirme_basvuru_ekleri/" . $evrak_id . "/" . $belge . "/" . $belgeAdi[0]['BELGE_ADI'];
        if (is_dir($sildir)) {
            rrmdir($sildir);
        } else {
            unlink($sildir);
        }
        rmdir($sildir);
        return true;
    }

    function getBasvuruDurum($evrak_id)
    {
        $_db = &JFactory::getOracleDBO();

        if ($evrak_id == -1) {
            return 0;
        } else {
            $sql = "SELECT DURUM_ID FROM M_BELGELENDIRME_DURUM WHERE EVRAK_ID = ?";
            $data = $_db->prep_exec($sql, array((int)$evrak_id));
            return $data[0]['DURUM_ID'];
        }
    }

    function DelBasvuruDoc($post)
    {
        $_db = &JFactory::getOracleDBO();
        $tur = $post['tur'];
        $evrak_id = $post['evrak_id'];

        $sql = "SELECT BELGE_ADI FROM M_BELGELENDIRME_DOCS WHERE EVRAK_ID=? AND BELGE_TURU=?";
        $belgeAdi = $_db->prep_exec($sql, array($evrak_id, $tur));

        $sql = "DELETE FROM M_BELGELENDIRME_DOCS WHERE EVRAK_ID=? AND BELGE_TURU=?";
        $_db->prep_exec($sql, array($evrak_id, $tur));
        $sildir = EK_FOLDER . "belgelendirme_basvuru_ekleri/" . $evrak_id . "/DOCS/" . $tur . "/" . $belgeAdi[0]['BELGE_ADI'];
        if (is_dir($sildir)) {
            rrmdir($sildir);
        } else {
            unlink($sildir);
        }
        rmdir($sildir);
        return true;
    }

    function sinavMerkeziKaydet($post)
    {
        $_db = &JFactory::getOracleDBO();

        $evrak_id = $post['evrak_id'];
        $merkez_temin_id = $post['merkezTas'];
        $merkez_adi = $post['merkezAd'];
        $merkez_adresi = $post['merkezAdres'];
//             $yeterlilik_id = $post['merkezYet'];
        $yeterlilik = $post['merkezYet'];
        $yets = explode(',', $yeterlilik);
        $sinav_sekli_id = $post['merkezSekil'];

        foreach ($yets as $row) {
            $merkez_id = $_db->getNextVal(SINAV_MERKEZI_SEQ);

            $sql = "INSERT INTO M_SINAV_MERKEZI (EVRAK_ID, MERKEZ_ID, MERKEZ_TEMIN_ID, MERKEZ_ADI, MERKEZ_ADRESI, MERKEZ_TELEFON, MERKEZ_FAKS, MERKEZ_EPOSTA, MERKEZ_WEB)
					VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $params = array($evrak_id,
                $merkez_id,
                $merkez_temin_id,
                $merkez_adi,
                $merkez_adresi,
                null,
                null,
                null,
                null);

            $result = $_db->prep_exec_insert($sql, $params);
            if ($result) {
                if ($sinav_sekli_id == 3) {
                    $sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
					VALUES( ?, ?, ?, ?, ?)";

                    $params = array($evrak_id,
                        $merkez_id,
                        $row,
                        null,
                        1);

                    $result = $_db->prep_exec_insert($sql, $params);

                    $sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
	                                    VALUES( ?, ?, ?, ?, ?)";

                    $params = array($evrak_id,
                        $merkez_id,
                        $row,
                        null,
                        2);

                    $result = $_db->prep_exec_insert($sql, $params);
                } else {
                    $sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
	                                    VALUES( ?, ?, ?, ?, ?)";

                    $params = array($evrak_id,
                        $merkez_id,
                        $row,
                        null,
                        $sinav_sekli_id);

                    $result = $_db->prep_exec_insert($sql, $params);
                }
            } else
                return false;
        }
        return true;
    }

    function sinavMerkeziSil($post)
    {
        $_db = &JFactory::getOracleDBO();
        $merkezId = $post['merkezId'];
        $sekil = $post['sekil'];

        if ($sekil == 3) {
            $sql = "DELETE FROM M_MERKEZ_SINAV WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
            $_db->prep_exec($sql, array($merkezId, 1));

            $sql = "DELETE FROM M_MERKEZ_SINAV WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
            $_db->prep_exec($sql, array($merkezId, 2));
        } else {
            $sql = "DELETE FROM M_MERKEZ_SINAV WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
            $_db->prep_exec($sql, array($merkezId, $sekil));
        }

        $sqlVarmi = "SELECT * FROM M_MERKEZ_SINAV WHERE MERKEZ_ID=?";
        $data = $_db->prep_exec($sqlVarmi, array($merkezId));
        if (count($data) == 0) {
            $sql = "DELETE FROM M_SINAV_MERKEZI WHERE MERKEZ_ID=?";
            $_db->prep_exec($sql, array($merkezId));
        }

        return true;
    }

    function ajaxGetSinavMerkezi($post)
    {
        $_db = &JFactory::getOracleDBO();

        if ($post['sekil'] == 3) {
            $sekil = 1;
        } else {
            $sekil = $post['sekil'];
        }

        $sql = " SELECT *
				 FROM m_sinav_merkezi
				 	JOIN m_merkez_sinav ms USING (evrak_id, merkez_id)
		 	        JOIN m_yeterlilik USING (yeterlilik_id)
		            JOIN pm_sinav_sekli USING (sinav_sekli_id)
		            JOIN pm_sinav_merkez_temin USING (merkez_temin_id)
				 WHERE merkez_id = ? AND SINAV_SEKLI_ID =?";

        $params = array($post['merkezId'], $sekil);

        $result = $_db->prep_exec($sql, $params);

        if ($post['sekil'] == 3) {
            $result[0]['SINAV_SEKLI_ID'] = 3;
        }

        return $result;
    }

    function sinavMerkeziUpdate($post)
    {
        $_db = &JFactory::getOracleDBO();

        $evrak_id = $post['evrak_id'];
        $merkez_temin_id = $post['merkezTas'];
        $merkez_adi = $post['merkezAd'];
        $merkez_adresi = $post['merkezAdres'];
        $yeterlilik_id = $post['merkezYet'];
        $sinav_sekli_id = $post['merkezSekil'];
        $merkezId = $post['merkezId'];

        $sql = "UPDATE M_SINAV_MERKEZI SET MERKEZ_TEMIN_ID=?, MERKEZ_ADI=?, MERKEZ_ADRESI=? WHERE MERKEZ_ID=? AND EVRAK_ID=?";

        $params = array(
            $merkez_temin_id,
            $merkez_adi,
            $merkez_adresi,
            $merkezId,
            $evrak_id);

        $result = $_db->prep_exec_insert($sql, $params);
        if ($result) {
            if ($sinav_sekli_id == 3) {

                $sqlVarmi = "SELECT * FROM M_MERKEZ_SINAV WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
                $data1 = $_db->prep_exec($sqlVarmi, array($merkezId, 1));

                if (count($data1) > 0) {
                    $sql = "UPDATE M_MERKEZ_SINAV SET YETERLILIK_ID=? WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
                    $_db->prep_exec_insert($sql, array($yeterlilik_id, $merkezId, 1));
                } else {
                    $sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
				 				VALUES( ?, ?, ?, ?, ?)";

                    $params = array($evrak_id,
                        $merkezId,
                        $yeterlilik_id,
                        null,
                        1);
                    $_db->prep_exec_insert($sql, $params);
                }

                $data2 = $_db->prep_exec($sqlVarmi, array($merkezId, 2));
                if (count($data2) > 0) {
                    $sql = "UPDATE M_MERKEZ_SINAV SET YETERLILIK_ID=? WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
                    $_db->prep_exec_insert($sql, array($yeterlilik_id, $merkezId, 2));
                } else {
                    $sql = "INSERT INTO M_MERKEZ_SINAV (EVRAK_ID, MERKEZ_ID, YETERLILIK_ID, YETERLILIK_ACIKLAMA, SINAV_SEKLI_ID)
				 				VALUES( ?, ?, ?, ?, ?)";

                    $params = array($evrak_id,
                        $merkezId,
                        $yeterlilik_id,
                        null,
                        2);
                    $_db->prep_exec_insert($sql, $params);
                }
            } else {
                $sql = "UPDATE M_MERKEZ_SINAV SET YETERLILIK_ID=? WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";

                $result = $_db->prep_exec_insert($sql, array($yeterlilik_id, $merkezId, $sinav_sekli_id));

                $sqlSil = "DELETE FROM M_MERKEZ_SINAV WHERE MERKEZ_ID=? AND SINAV_SEKLI_ID=?";
                if ($sinav_sekli_id == 1) {
                    $_db->prep_exec($sqlSil, array($merkezId, 2));
                } else {
                    $_db->prep_exec($sqlSil, array($merkezId, 1));
                }

            }
            if ($result)
                return true;
            else
                return false;
        }
    }

    function ajaxBelgeSil($post)
    {
        $_db = &JFactory::getOracleDBO();

        $evrakId = $post['evrakId'];

        $sqlSe = "DELETE from M_BASVURU_SEKTOR WHERE EVRAK_ID = ?";
        $_db->prep_exec($sqlSe, array($evrakId));

        $sqlFa = "DELETE FROM M_BASVURU_FALIYET_ALAN WHERE EVRAK_ID = ?";
        $_db->prep_exec($sqlFa, array($evrakId));

        $sql = "DELETE FROM M_BASVURU WHERE EVRAK_ID = ?";

        $result = $_db->prep_exec($sql, array($evrakId));

        return $result;
    }

    function getKurulus($evrak_id = null)
    {
        $db = &JFactory::getOracleDBO();
        $user = &JFactory::getUser();
        $user_id = $user->getOracleUserId();

        $x = $db->prep_exec("SELECT USER_ID FROM M_KURULUS WHERE USER_ID = ?", array($user_id));
        if (count($x) == 0) {
            $user_datas = current($db->prep_exec("SELECT user_id FROM m_basvuru WHERE evrak_id = ?", array($evrak_id)));
            $user_id = $user_datas['USER_ID'];
        }

        if ($evrak_id <> "-1" && $data['BASVURU_ILETISIM_ID'] <> "") {

            $sql_basvuru = "SELECT BASVURU_DURUM_ID,BASVURU_ILETISIM_ID FROM M_BASVURU WHERE EVRAK_ID = ?";
            $data = current($db->prep_exec($sql_basvuru, array($evrak_id)));
        } else if ($evrak_id <> "-1" && $data['BASVURU_ILETISIM_ID'] == "") {

            $sql_mkurulus_edit = "SELECT * FROM M_KURULUS_EDIT INNER JOIN PM_KURULUS_STATU ON M_KURULUS_EDIT.KURULUS_STATU_ID = PM_KURULUS_STATU.KURULUS_STATU_ID  WHERE USER_ID = ? AND ONAY_BEKLEYEN = 0 AND AKTIF = 1";
            $data = current($db->prep_exec($sql_mkurulus_edit, array($user_id)));

            if (count($data) <= 2) {
                $sql_mkurulus = "SELECT * FROM M_KURULUS INNER JOIN PM_KURULUS_STATU ON M_KURULUS.KURULUS_STATU_ID = PM_KURULUS_STATU.KURULUS_STATU_ID WHERE USER_ID = ?";
                $data = current($db->prep_exec($sql_mkurulus, array($user_id)));
            }
        } else {
            $sql_mkurulus = "SELECT * FROM M_KURULUS INNER JOIN PM_KURULUS_STATU ON M_KURULUS.KURULUS_STATU_ID = PM_KURULUS_STATU.KURULUS_STATU_ID  WHERE USER_ID = ?";
            $data = current($db->prep_exec($sql_mkurulus, array($user_id)));
        }
        return $data;
    }

    function AjaxYetTalepSil($post){
        $db = &JFactory::getOracleDBO();

        $sql = "DELETE FROM m_belgelendirme_yet_talebi WHERE EVRAK_ID = ? AND YETERLILIK_ID = ?";
        return $db->prep_exec_insert($sql,array($post['eId'],$post['yId']));
    }
}

?>