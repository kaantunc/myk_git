<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once('libraries/form/form_config.php');

class FormParametrik
{
    function getIl()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT IL_ID, IL_ADI
				FROM M_IL";

        $data = $_db->loadList($sql);
        return $data;
    }

    function getKurulusStatu()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT KURULUS_STATU_ID, KURULUS_STATU_ADI
				FROM PM_KURULUS_STATU";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getFaaliyetSuresi()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM PM_FALIYET_SURESI";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getSektor()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM pm_sektorler 
				WHERE sektor_durum = 1 ORDER BY NLSSORT(SEKTOR_ADI,'nls_sort=xturkish') ASC";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getTumSektor()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM pm_sektorler 
				ORDER BY sektor_durum desc, NLSSORT(SEKTOR_ADI,'nls_sort=xturkish') ASC";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getSeviye()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM pm_seviye 
				ORDER BY seviye_id";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getMeslekStandart($standart_turu = null)
    {
        $_db = &JFactory::getOracleDBO();

        $join = "";
        if ($standart_turu == "ulusal") {
            $durum = "IN (" . RESMI_GAZETEDE_YAYINLANMIS_STANDART . ")";
        } else if ($standart_turu == "taslak") {
            $join = "LEFT JOIN m_taslak_meslek USING (standart_id) ";
            $durum = "NOT IN (" . REDDEDILMIS_STANDART . "," . RESMI_GAZETEDE_YAYINLANMIS_STANDART . ")";
        } else {
            $durum = "IN (" . RESMI_GAZETEDE_YAYINLANMIS_STANDART . ")";
        }

        $sql = "SELECT DISTINCT standart_id, standart_adi, seviye_adi
				FROM m_meslek_standartlari 
					JOIN pm_seviye USING (seviye_id)  
					$join 
				WHERE MESLEK_STANDART_SUREC_DURUM_ID $durum 
					ORDER BY standart_adi, seviye_adi";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getMeslekStandart2($standart_turu = null)
    {
        $_db = &JFactory::getOracleDBO();

        $join = "";
        if ($standart_turu == "ulusal") {
            $durum = "IN (" . PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART . ")";
        } else if ($standart_turu == "taslak") {
            $join = "LEFT JOIN m_taslak_meslek USING (standart_id) ";
            $durum = "IN (" . PM_MESLEK_STANDART_DURUMU__TASLAK . ")";
        } else {
            $durum = "IN (" . RESMI_GAZETEDE_YAYINLANMIS_STANDART . ")";
        }

        $sql = "SELECT DISTINCT standart_id, standart_adi, seviye_adi
				FROM m_meslek_standartlari 
					JOIN pm_seviye USING (seviye_id)  
					$join 
				WHERE MESLEK_STANDART_DURUM_ID $durum 
					ORDER BY standart_adi, seviye_adi";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getYeterlilikAd()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT yeterlilik_id, yeterlilik_adi
				FROM m_yeterlilik 
				WHERE YETERLILIK_SUREC_DURUM_id = " . ONAYLANMIS_YETERLILIK . "
				ORDER BY yeterlilik_adi";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getYeterlilik()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT yeterlilik_id, yeterlilik_adi, seviye_adi
				FROM m_yeterlilik 
					JOIN pm_seviye USING (seviye_id) 
				WHERE YETERLILIK_SUREC_DURUM_id = " . ONAYLANMIS_YETERLILIK . "";

        $data = $_db->loadList($sql);

        return $data;
    }


    function getSinavSekli()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM pm_sinav_sekli 
				ORDER BY sinav_sekli_id";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getBasvuruTip()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM pm_basvuru_tip 
				WHERE basvuru_tip_id NOT IN (" . KULLANILMAYAN_BASVURU_TIP_ID . ")
				ORDER BY basvuru_tip_id";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getBasvuruDurum()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
				FROM pm_basvuru_durum   
				ORDER BY basvuru_durum_id";

        $data = $_db->loadList($sql);

        return $data;
    }

    function getBelgelendirmeBasvuruDurum()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT *
					FROM PM_BELGELENDIRME_DURUM   
					ORDER BY DURUM_ID";

        $data = $_db->loadList($sql);

        return $data;
    }

    function uyariKaydet($uyari_tip, $tip_id, $durum)
    {
        $_db = &JFactory::getOracleDBO();

        $userOracleId = JFactory::getUser()->getOracleUserId();
        $userTip = JFactory::getUser()->getActive();

        $taslakbilgi = FormParametrik::getTaslakById($uyari_tip, $tip_id);

        $durumbilgi = FormParametrik::getDurumAdiById($uyari_tip, $durum);
        $durumAdi = $durumbilgi[0];

        if ($uyari_tip[0] == MESLEK_STANDARTI or $uyari_tip[0] == YETERLILIK) {
            $ek = "taslağının";
        } else if ($uyari_tip[0] == MESLEK_STANDARTI_REVIZYONU or $uyari_tip[0] == YETERLILIK_REVIZYONU) {
            $ek = $uyari_tip[1] . " Numaralı Revizyonunun";
        }

        if ($taslakbilgi[0]["YENI_MI"] == 1) {
            $yeniMi = "_yeni";
        }

        if ($uyari_tip[0] == MESLEK_STANDARTI or $uyari_tip[0] == MESLEK_STANDARTI_REVIZYONU) {
            $link = "index.php?option=com_meslek_std_taslak&layout=meslek_std_taslak_yeni&standart_id=" . $tip_id;
        } else if ($uyari_tip[0] == YETERLILIK or $uyari_tip[0] == YETERLILIK_REVIZYONU) {
            $link = "index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_taslak_yeni&yeterlilik_id=" . $tip_id;
        }


        if ($userTip == 1) {
            $sql = "select user_id from m_yetki_sektor_sorumlusu where sektor_id=" . $taslakbilgi[0]["SEKTOR_ID"] . " and yetki_alani=" . $uyari_tip[0];
            $hedef = $_db->prep_exec($sql, array());
            foreach ($hedef as $row) {
                $hedef_user_id[] = $row["USER_ID"];
            }

            $aciklama = $taslakbilgi[0]["YETERLILIK_ADI"] . $taslakbilgi[0]["STANDART_ADI"] . " (Seviye " . $taslakbilgi[0]["SEVIYE_ID"] . ") incelemenize sunuldu.";
        }

        if ($userTip == 2) {
            foreach ($taslakbilgi as $row) {
                $hedef_user_id[] = $row["USER_ID"];
            }
            if ($durumAdi != "") {
                $aciklama = $taslakbilgi[0]["SEKTOR_ADI"] . " Sektör Sorumlusu tarafından " . $taslakbilgi[0]["YETERLILIK_ADI"] . $taslakbilgi[0]["STANDART_ADI"] . " (Seviye " . $taslakbilgi[0]["SEVIYE_ID"] . ") " . $ek . " durumu \"" . $durumAdi . "\" olarak değiştirildi.";
            } else {
                $aciklama = $taslakbilgi[0]["SEKTOR_ADI"] . " Sektör Sorumlusu tarafından " . $taslakbilgi[0]["YETERLILIK_ADI"] . $taslakbilgi[0]["STANDART_ADI"] . " (Seviye " . $taslakbilgi[0]["SEVIYE_ID"] . ") taslağını onayladı.";
            }
        }

        for ($i = 0; $i < count($hedef_user_id); $i++) {
            $uyari_id = $_db->getNextVal(UYARI_ID_SEQ);
            $sql = "INSERT INTO m_uyarilar
						(UYARI_ID,
						FROM_USER_ID,
						ACIKLAMA,
						LINK,
						TO_USER_ID,
						tarih)
						VALUES
						(?,?,?,?,?,?)
			";
            $params = array($uyari_id,
                $userOracleId,
                $aciklama,
                $link,
                $hedef_user_id[$i],
                time()
            );

            $_db->prep_exec_insert($sql, $params);
        }
    }

    function getTaslakById($uyari_tip, $id)
    {
        $_db = &JFactory::getOracleDBO();
        if ($uyari_tip[0] == MESLEK_STANDARTI or $uyari_tip[0] == MESLEK_STANDARTI_REVIZYONU) {
            $tablo = "m_meslek_standartlari";
            $alan = "standart_id";
            $yetkitablosu = "m_yetki_standart";
        } else if ($uyari_tip[0] == YETERLILIK or $uyari_tip[0] == YETERLILIK_REVIZYONU) {
            $tablo = "m_yeterlilik";
            $alan = "yeterlilik_id";
            $yetkitablosu = "m_yetki_yeterlilik";
        }
        $sql = "SELECT *
		FROM " . $tablo . "
		JOIN pm_sektorler USING (sektor_id)
		JOIN " . $yetkitablosu . " USING (" . $alan . ")
		JOIN M_KURULUS_YETKI USING(YETKI_ID)
		WHERE
		REVIZYON_NO=" . $uyari_tip[1] . " AND
		" . $alan . " = ?
		";

        $params = array($id);

        $data = $_db->prep_exec($sql, $params);

        return $data;

    }

    function getDurumAdiById($uyari_tip, $durum)
    {
        $_db = &JFactory::getOracleDBO();
        if ($uyari_tip[0] == MESLEK_STANDARTI) {
            $tablo = "PM_MESLEK_STANDART_SUREC_DURUM";
            $selectalan = "STANDART_SUREC_DURUM_ADI";
            $alan = "MESLEK_STANDART_SUREC_DURUM_ID";
        } else if ($uyari_tip[0] == YETERLILIK) {
            $tablo = "PM_YETERLILIK_SUREC_DURUM";
            $selectalan = "YETERLILIK_SUREC_DURUM_ADI";
            $alan = "YETERLILIK_SUREC_DURUM_ID";
        } else if ($uyari_tip[0] == MESLEK_STANDARTI_REVIZYONU) {
            $tablo = "PM_STANDART_REVIZYON_SUREC";
            $selectalan = "STANDART_SUREC_DURUM_ADI";
            $alan = "MESLEK_STANDART_SUREC_DURUM_ID";
        } else if ($uyari_tip[0] == YETERLILIK_REVIZYONU) {
            $tablo = "PM_YETERLILIK_REVIZYON_SUREC";
            $selectalan = "YETERLILIK_SUREC_DURUM_ADI";
            $alan = "YETERLILIK_SUREC_DURUM_ID";
        }
        $sql = "SELECT " . $selectalan . "
		FROM " . $tablo . "
		WHERE " . $alan . "=?
		";

        $params = array($durum);

        $data = $_db->prep_exec_array($sql, $params);

        return $data;

    }


    function harfleriTexttenCikar($string_to_be_stripped)
    {
        return ereg_replace("[^0-9]", "", $string_to_be_stripped);

    }

    function getKuruluslar()
    {
        $_db = &JFactory::getOracleDBO();
        $sql = "SELECT * FROM M_KURULUS INNER JOIN PM_KURULUS_DURUM ON M_KURULUS.KURULUS_DURUM_ID = PM_KURULUS_DURUM.KURULUS_DURUM_ID
				WHERE M_KURULUS.KURULUS_DURUM_ID != 1
				ORDER BY KURULUS_ADI";

        $data = $_db->loadList($sql);

        return $data;
    }

    function checkIBAN($iban)
    {
        $iban = strtolower(str_replace(' ', '', $iban));
        $Countries = array('al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24);
        $Chars = array('a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35);

        if (strlen($iban) == $Countries[substr($iban, 0, 2)]) {

            $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";

            foreach ($MovedCharArray AS $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }

            if (bcmod($NewString, '97') == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}