<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries' . DS . 'form' . DS . 'form.php');
require_once('libraries' . DS . 'form' . DS . 'form_config.php');
require_once('libraries' . DS . 'form' . DS . 'formBelgelendirme.php');
require_once('libraries' . DS . 'phpseclib0.3.10' . DS . 'Net' . DS . 'SFTP.php');

ini_set("display_errors", "1");

class TesvikModelTesvik extends JModel
{
    function TesvikAdaylarWithTarih($basTarih, $bitTarih)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MBS.TESVIK = 2 
				AND MBS.BELGENO NOT IN (SELECT BELGE_NO FROM M_BELGE_TESVIK_ADAY WHERE ODENDI = 0 OR ODENDI = 1)
				AND MBS.BELGE_DUZENLEME_TARIHI <= TO_DATE(?)
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC, MBS.BELGE_MASRAF DESC
				";

        $tesvikAday = $db->prep_exec($sql, array($bitTarih));

        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
            // 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);

// 			if($row['BELGE_MASRAF']){
// 				$sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
// 				$masraf = $db->prep_exec($sqlMasraf, array($row['BELGE_DUZENLEME_TARIHI']));
// 				$BelgeMasraf[$row['BELGENO']] = $masraf[0]['BELGE_MASRAFI'];
// 			}else{
// 				$BelgeMasraf[$row['BELGENO']] = 0;
// 			}
            $BelgeMasraf[$row['BELGENO']] = FormUcretHesabi::BelgeMasrafi($row['BELGE_DUZENLEME_TARIHI']);
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf);
    }

    // Belge almış adayların başarılı oldukları birim ücretleri

    function AlteratifBirim($yeterlilik_id)
    {
        $_db = JFactory::getOracleDBO();

        $sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
        $yenimi = $_db->prep_exec($sql, array($yeterlilik_id));
        $yeni_mi = $yenimi[0]["YENI_MI"];

        if ($yeni_mi == "1") {
            $sql = "select birim_id, birim_kodu, zorunlu from m_birim join M_YETERLILIK_BIRIM using (birim_id)  where yeterlilik_id=" . $yeterlilik_id;
            $birimler = $_db->prep_exec($sql, array());

            foreach ($birimler as $row) {
                $sql = "select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=" . $row["BIRIM_ID"] . " AND OLC_DEG_HARF != 'D'";
                $sinav_kodlari = $_db->prep_exec($sql, array());
                foreach ($sinav_kodlari as $row2) {
                    if ($row2["OLC_DEG_HARF"] != "D") {
                        if ($row['ZORUNLU'] == 0) {
                            $yeterlilik[0][$row["BIRIM_ID"]][] = $row2["OLC_DEG_HARF"] . $row2["OLC_DEG_NUMARA"];
                        } else {
                            $yeterlilik[1][$row["BIRIM_ID"]][] = $row2["OLC_DEG_HARF"] . $row2["OLC_DEG_NUMARA"];
                        }
                    }
                }
            }

        } else {
            $sql = "select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu,
                		yeterlilik_zorunlu as zorunlu
                		from m_yeterlilik_alt_birim where yeterlilik_id=" . $yeterlilik_id;
            $birimler = $_db->prep_exec($sql, array());
            foreach ($birimler as $row) {
                $sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ?";
                $sinav_kodlari = $_db->prep_exec($sql, array($row["BIRIM_ID"]));

                foreach ($sinav_kodlari as $row2) {
                    if ($row['ZORUNLU'] == 0) {
                        $yeterlilik[0][$row["BIRIM_ID"]][] = $row2['TUR_KODU'];
                    } else {
                        $yeterlilik[1][$row["BIRIM_ID"]][] = $row2["TUR_KODU"];
                    }
                }
            }
        }

        return $yeterlilik;
    }

    function AlteratifBirimWithBirimId($birimId, $yeniMi)
    {
        $_db = JFactory::getOracleDBO();

        if ($yeniMi) {
            $sql = "select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=" . $birimId;
            $sinav_kodlari = $_db->prep_exec($sql, array());
            foreach ($sinav_kodlari as $row2) {
                if ($row2["OLC_DEG_HARF"] != "D") {
                    $yeterlilik[] = $row2["OLC_DEG_HARF"] . $row2["OLC_DEG_NUMARA"];
                }
            }

        } else {
            $sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ?";
            $sinav_kodlari = $_db->prep_exec($sql, array($birimId));

            foreach ($sinav_kodlari as $row2) {
                $yeterlilik[] = $row2['TUR_KODU'];
            }
        }

        return $yeterlilik;
    }

    // Belge almış adayların başarılı oldukları birim ücretleri SON

    function TesvikAdayYarat($data)
    {
        $db = JFactory::getOracleDBO();
        $user = &JFactory::getUser();
        $user_id = $user->getOracleUserId();

        $belgeNo = $data['tesvik'];

        $istekId = $db->getNextVal('SEQ_TESVIK_ISTEK');

        $sql = "INSERT INTO M_BELGE_TESVIK_ISTEK (ID,USER_ID,TARIH,BIT_TARIH) VALUES(?,?,SYSDATE,TO_DATE(?))";
        if ($db->prep_exec_insert($sql, array($istekId, $user_id, $data['bit_tarih']))) {
            $sqlBelge = "INSERT INTO M_BELGE_TESVIK_ADAY (TESVIK_ID,BELGE_NO) VALUES(?,?)";
            $hata = 0;
            foreach ($belgeNo as $val) {
                $sonuc = $db->prep_exec_insert($sqlBelge, array($istekId, $val));
                if (!$sonuc) {
                    $hata++;
                }
            }

            if ($hata > 0) {
                $sqlDelete = "DELETE FROM M_BELGE_TESVIK_ADAY WHERE TESVIK_ID = ?";
                $return = $db->prep_exec_insert($sqlDelete, array($istekId));
                return array('durum' => 2, 'message' => 'Teşvikten yararlanacak aday seçiminde bir hata meydana geldi. Lütfen tekrar deneyin.', 'tesvikId' => $istekId);
            } else {
                $this->TesvikAdayUcretYazdir($istekId);
                return array('durum' => 1, 'message' => 'Teşvikten yararlanacak adaylar başarıyla oluşturuldu.', 'tesvikId' => $istekId);
            }
        } else {
            return array('durum' => 0, 'message' => 'Bir hata meydana geldi. Lütfen tekrar deneyin.');
        }
    }

    function TesvikIstekleri()
    {
        $db = JFactory::getOracleDBO();

// 		$sql = "SELECT MA.TESVIK_ID, COUNT(MA.TESVIK_ID) AS ADAY, MT.ID, MT.TARIH, MT.USER_ID, MT.DURUM, TO_CHAR(MT.BIT_TARIH,'dd/mm/yyyy') AS ARAMA_TARIH FROM M_BELGE_TESVIK_ADAY MA
// 				INNER JOIN M_BELGE_TESVIK_ISTEK MT ON(MA.TESVIK_ID = MT.ID)
// 				GROUP BY MA.TESVIK_ID, MT.ID, MT.TARIH, MT.DURUM, MT.BIT_TARIH, MT.USER_ID
// 				ORDER BY TARIH DESC";
        $sql = "SELECT ID, TARIH, USER_ID, DURUM, TO_CHAR(BIT_TARIH,'dd/mm/yyyy') AS ARAMA_TARIH FROM M_BELGE_TESVIK_ISTEK
				ORDER BY TARIH ASC";
        return $db->prep_exec($sql, array());
    }

    function TesvikIstekleriUser($tesvik)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT COUNT(*) AS SAY FROM M_BELGE_TESVIK_ADAY
				WHERE TESVIK_ID = ? AND ODENDI != -3";

        $tesvikUser = array();
        foreach ($tesvik as $row) {
            $dat = $db->prep_exec($sql, array($row['ID']));
            if ($dat) {
                $tesvikUser[$row['ID']] = $dat[0]['SAY'];
            } else {
                $tesvikUser[$row['ID']] = 0;
            }
        }
        return $tesvikUser;
    }

    function GetTesvikWithTesvikId($tesvikId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT ID, DURUM, TARIH, TO_CHAR(BIT_TARIH,'dd/mm/yyyy') AS BIT_TARIH, USER_ID,LISTE_KODU FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";
        $data = $db->prep_exec($sql, array($tesvikId));

        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }

    function GetTesvikWithTesvikIdPDF($tesvikId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT BELGENO FROM M_BELGE_SORGU MBS
                    INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON MBS.TCKIMLIKNO = MBO.TC_KIMLIK
                    INNER JOIN M_BELGE_TESVIK_ADAY MBT ON MBS.BELGENO = MBT.BELGE_NO
                    WHERE LENGTH(MBO.IBAN) != 26 AND MBT.ODENDI = 0 AND MBT.TESVIK_ID = ?";
        $data = $db->prep_exec($sql,array($tesvikId));

        if($data){
            $sql = "UPDATE M_BELGE_TESVIK_ADAY SET ODENDI = -3, ACIKLAMA = 'IBAN 26 HANE OLMALI' WHERE ODENDI = 0 AND TESVIK_ID = ?
                AND BELGE_NO IN (
                  SELECT BELGENO FROM M_BELGE_SORGU MBS
                    INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON MBS.TCKIMLIKNO = MBO.TC_KIMLIK
                    INNER JOIN M_BELGE_TESVIK_ADAY MBT ON MBS.BELGENO = MBT.BELGE_NO
                    WHERE LENGTH(MBO.IBAN) != 26 AND MBT.ODENDI = 0 AND MBT.TESVIK_ID = ?
                )";
            $db->prep_exec_insert($sql,array($tesvikId,$tesvikId));

            $db = JFactory::getOracleDBO();
            $sql = "SELECT ID, DURUM, TARIH, TO_CHAR(BIT_TARIH,'dd/mm/yyyy') AS BIT_TARIH, USER_ID,LISTE_KODU FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";
            $data = $db->prep_exec($sql, array($tesvikId));

            if ($data) {
                return $data[0];
            } else {
                return false;
            }
        }else{
            $filepath = "tesvikpdf/" . $tesvikId . "_4447_Ek_3_Yaranlanici_Listesi.pdf";
            if (is_file(EK_FOLDER . $filepath) and $_GET['layout']=="tesvikpdf") {
                header("location: index.php?dl=" . $filepath);
                exit;
            } else {

                $db = JFactory::getOracleDBO();
                $sql = "SELECT ID, DURUM, TARIH, TO_CHAR(BIT_TARIH,'dd/mm/yyyy') AS BIT_TARIH, USER_ID,LISTE_KODU FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";
                $data = $db->prep_exec($sql, array($tesvikId));

                if ($data) {
                    return $data[0];
                } else {
                    return false;
                }
            }
        }
    }

    function GetTesvikAdaylarWithTesvikId($tesvikId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT BELGE_NO FROM M_BELGE_TESVIK_ADAY WHERE TESVIK_ID = ?";
        $data = $db->prep_exec_array($sql, array($tesvikId));
        return $data;
    }

    function TesvikAdaylarEditWithTarih($tesvikId, $bitTarih)
    {
        $db = JFactory::getOracleDBO();
        $tesvikAday = array();

        $sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MBS.TESVIK = 2
				AND MBS.BELGENO NOT IN (SELECT BELGE_NO FROM M_BELGE_TESVIK_ADAY WHERE ODENDI = 0 OR ODENDI = 1)
				AND MBS.BELGE_DUZENLEME_TARIHI <= TO_DATE(?)
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC
				";

        $tesvikAday = $db->prep_exec($sql, array($bitTarih));

        $sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN M_BELGE_TESVIK_ADAY MTA ON(MBS.BELGENO = MTA.BELGE_NO)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MTA.TESVIK_ID = ? AND MTA.ODENDI = 0
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC";

        $tAday = $db->prep_exec($sql, array($tesvikId));

        foreach ($tAday as $row) {
            $tesvikAday[] = $row;
        }
        $birimUcretiHesabi = array();
        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi);
    }

    function TesvikAdaylarWithBelgeNo($BelgeNo)
    {
        $db = JFactory::getOracleDBO();


        $sql = "SELECT * FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				WHERE MBS.BELGENO = ? AND MY.TEHLIKELI_IS_DURUM = 1
				ORDER BY MBS.AD ASC, MBS.SOYAD ASC
				";

        $tesvikAday = $db->prep_exec($sql, array($BelgeNo));

        $YetUcretiHesabi = array();
        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TC_KIMLIK'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            $BelgeMasraf[$row['BELGENO']] = FormUcretHesabi::BelgeMasrafi($row['BELGE_DUZENLEME_TARIHI']);
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf
        );
    }

    function TesvikAdaylarWithBelgeNoTest($BelgeNo)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MBS.BELGENO
FROM M_BELGE_SORGU MBS
INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
INNER JOIN M_BELGELENDIRME_HAK_KAZANANLAR MHK ON(MBS.BELGENO = MHK.BELGE_NO)
WHERE MHK.SINAV_TARIHI >= TO_DATE('25.05.2015') AND MHK.SINAV_TARIHI <= TO_DATE('20.07.2015')
AND MY.TEHLIKELI_IS_DURUM = 1
ORDER BY MHK.SINAV_TARIHI DESC";

        $belgenolar = $db->prep_exec_array($sql, array());

        $dat = array();
        foreach ($belgenolar as $cow) {
            $dat[] = "'" . $cow . "'";
        }

        $sql = "SELECT * FROM M_BELGE_SORGU MBS
				INNER JOIN M_BELGELENDIRME_HAK_KAZANANLAR MHK ON(MBS.BELGENO = MHK.BELGE_NO)
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				WHERE MBS.BELGENO IN (" . implode(',', $dat) . ")
				";
        // 		$sql = "SELECT * FROM M_BELGE_SORGU MBS
        // 				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
        // 				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
        // 				WHERE MBS.BELGE_DUZENLEME_TARIHI >= TO_DATE(?) AND MY.TEHLIKELI_IS_DURUM = 1
        // 				ORDER BY MBS.AD ASC, MBS.SOYAD ASC
        // 				";

        $tesvikAday = $db->prep_exec($sql, array());
        // 		$tesvikAday = $db->prep_exec($sql, array(TEBLIG_TARIH));

        $YetUcretiHesabi = array();
        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TC_KIMLIK'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            $BelgeMasraf[$row['BELGENO']] = FormUcretHesabi::BelgeMasrafi($row['BELGE_DUZENLEME_TARIHI']);
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf
        );
    }

    function TesvikAdaylarWithBelgeNoYeni($BelgeNo)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT * FROM M_BELGE_SORGU MBS
				INNER JOIN M_BELGELENDIRME_HAK_KAZANANLAR MHK ON(MBS.BELGENO = MHK.BELGE_NO)
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				WHERE MBS.BELGENO = ?
				";
        // 		$sql = "SELECT * FROM M_BELGE_SORGU MBS
        // 				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
        // 				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
        // 				WHERE MBS.BELGE_DUZENLEME_TARIHI >= TO_DATE(?) AND MY.TEHLIKELI_IS_DURUM = 1
        // 				ORDER BY MBS.AD ASC, MBS.SOYAD ASC
        // 				";

        $tesvikAday = $db->prep_exec($sql, array($BelgeNo));
        // 		$tesvikAday = $db->prep_exec($sql, array(TEBLIG_TARIH));

        $YetUcretiHesabi = array();
        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TC_KIMLIK'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            $BelgeMasraf[$row['BELGENO']] = FormUcretHesabi::BelgeMasrafi($row['BELGE_DUZENLEME_TARIHI']);
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf
        );
    }

    function TesvikAdayEditKaydet($data)
    {
        $db = JFactory::getOracleDBO();
        $user = &JFactory::getUser();
        $user_id = $user->getOracleUserId();

        $belgeNo = $data['tesvik'];
        $tesvikId = $data['tesvikId'];

        if (!empty($tesvikId) && is_numeric($tesvikId)) {

            $sqlDel = "DELETE FROM M_BELGE_TESVIK_ADAY WHERE TESVIK_ID = ?";
            $dat = $db->prep_exec_insert($sqlDel, array($tesvikId));

            $sqlBelge = "INSERT INTO M_BELGE_TESVIK_ADAY (TESVIK_ID,BELGE_NO) VALUES(?,?)";
            $hata = 0;
            foreach ($belgeNo as $val) {
                $sonuc = $db->prep_exec_insert($sqlBelge, array($tesvikId, $val));
                if (!$sonuc) {
                    $hata++;
                }
            }

            if ($hata > 0) {
                $sqlDelete = "DELETE FROM M_BELGE_TESVIK_ADAY WHERE TESVIK_ID = ?";
                $return = $db->prep_exec_insert($sqlDelete, array($tesvikId));
                return array('durum' => 2, 'message' => 'Teşvikten yararlanacak aday seçiminde bir hata meydana geldi. Lütfen tekrar deneyin.', 'tesvikId' => $tesvikId);
            } else {
                $this->TesvikAdayUcretYazdir($tId);
                return array('durum' => 1, 'message' => 'Teşvikten yararlanacak adaylar başarıyla oluşturuldu.', 'tesvikId' => $tesvikId);
            }
        } else {
            return array('durum' => 0, 'message' => 'Bir hata meydana geldi. Lütfen tekrar deneyin.');
        }
    }

    function TesvikSil($tId)
    {
        $db = JFactory::getOracleDBO();

        if (!empty($tId) && is_numeric($tId)) {
            $sqlDel = "DELETE FROM M_BELGE_TESVIK_ADAY WHERE TESVIK_ID = ?";
            if ($db->prep_exec_insert($sqlDel, array($tId))) {
                $sqlDelIs = "DELETE FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";
                if ($db->prep_exec_insert($sqlDelIs, array($tId))) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function TesvikOnayaSun($tId)
    {
        $db = JFactory::getOracleDBO();

        if (!empty($tId) && is_numeric($tId)) {
            $sqlUp = "UPDATE M_BELGE_TESVIK_ISTEK SET DURUM = 1 WHERE ID = ?";
            if ($db->prep_exec_insert($sqlUp, array($tId), true)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function TesvikOnayla($tId, $uId)
    {
        $db = JFactory::getOracleDBO();

        if (!empty($tId) && is_numeric($tId) && !empty($uId) && is_numeric($uId)) {
            $sqlIns = "INSERT INTO M_BELGE_TESVIK_ONAY (TESVIK_ID,USER_ID,ONAY_TARIH) VALUES(?,?,SYSDATE)";
            $dat = $db->prep_exec_insert($sqlIns, array($tId, $uId), true);
            if ($dat) {
                $sql = "SELECT USER_ID FROM M_TESVIK_ONAY_KOMITESI ORDER BY USER_ID ASC";
                $komiteArray = $db->prep_exec_array($sql, array());
                $sql = "SELECT USER_ID FROM M_BELGE_TESVIK_ONAY WHERE TESVIK_ID = ? ORDER BY USER_ID ASC";
                $OnayArray = $db->prep_exec_array($sql, array($tId));
                if ($komiteArray == $OnayArray) {
                    $tesviklistekodu = "SELECT LISTE_KODU FROM M_BELGE_TESVIK_ISTEK WHERE ROWNUM <2 ORDER BY LISTE_KODU DESC";
                    $lkodu = $db->prep_exec($tesviklistekodu, array());
                    $liste_kodu = str_pad(($lkodu[0]['LISTE_KODU'] + 1), 3, "0", STR_PAD_LEFT);
                    $sqlTesvikUp = "UPDATE M_BELGE_TESVIK_ISTEK SET DURUM = 2,LISTE_KODU=? WHERE ID = ?";
                    $dat = $db->prep_exec_insert($sqlTesvikUp, array($liste_kodu, $tId), true);
                    if ($dat) {
                        return true;
//                         $pat = $this->TesvikAdayUcretYazdir($tId);
//                         if ($pat) {
//                             return true;
//                         } else {
//                             $sqlDel = "DELETE FROM M_BELGE_TESVIK_ONAY WHERE TESVIK_ID = ? AND USER_ID = ?";
//                             $db->prep_exec_insert($sqlDel, array($tId, $uId));
//                             $sqlTesvikUp = "UPDATE M_BELGE_TESVIK_ISTEK SET DURUM = 1,LISTE_KODU='' WHERE ID = ?";
//                             $dat = $db->prep_exec_insert($sqlTesvikUp, array($tId), true);
//                             return false;
//                         }
                    } else {
                        $sqlDel = "DELETE FROM M_BELGE_TESVIK_ONAY WHERE TESVIK_ID = ? AND USER_ID = ?";
                        $db->prep_exec_insert($sqlDel, array($tId, $uId));
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                $sqlDel = "DELETE FROM M_BELGE_TESVIK_ONAY WHERE TESVIK_ID = ? AND USER_ID = ?";
                $db->prep_exec_insert($sqlDel, array($tId, $uId));
                return false;
            }
        } else {
            return false;
        }
    }

    function TesvikGeriGonder($tId, $uId)
    {
        $db = JFactory::getOracleDBO();

        if (!empty($tId) && is_numeric($tId) && !empty($uId) && is_numeric($uId)) {
            $sqlDel = "DELETE FROM M_BELGE_TESVIK_ONAY WHERE TESVIK_ID = ?";
            $dat = $db->prep_exec_insert($sqlDel, array($tId));
            if ($dat) {
                $sqlTesvikUp = "UPDATE M_BELGE_TESVIK_ISTEK SET DURUM = 0,LISTE_KODU='' WHERE ID = ?";
                $dat = $db->prep_exec_insert($sqlTesvikUp, array($tId), true);
                if ($dat) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function TesvikIstekUsers($data)
    {
        $mysqlDB = &JFactory::getDBO();

        $userNames = array();
        foreach ($data as $row) {
            $sqlMatbaa = "SELECT name FROM #__users as users
					WHERE tgUserId = " . $row['USER_ID'];
            $mysqlDB->setQuery($sqlMatbaa);
            $user = $mysqlDB->loadObjectList();
            $userNames[$row['ID']] = $user[0]->name;
        }
        return $userNames;
    }

    function TesvikImzaUsers($data)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT USER_ID FROM M_BELGE_TESVIK_ONAY WHERE TESVIK_ID = ?";
        $imzaUserArray = array();
        foreach ($data as $row) {
            $imzaUserArray[$row['ID']] = $db->prep_exec_array($sql, array($row['ID']));
        }

        return $imzaUserArray;
// 		$sql = "SELECT * FROM M_TESVIK_ONAY_KOMITESI";
// 		$dat = $db->prep_exec($sql, array());

// 		$mysqlDB = &JFactory::getDBO();
// 		$userNames = array();

// 		foreach($dat as $row){
// 			$sqlMatbaa= "SELECT name FROM #__users as users
// 					WHERE tgUserId = ".$row['USER_ID'];
// 			$mysqlDB->setQuery($sqlMatbaa);
// 			$user = $mysqlDB->loadObjectList();
// 			$userNames[$row['ID']] = $user[0]->name;
// 		}
// 		return $userNames;
    }

    function TesvikImzaUsersArray()
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT USER_ID FROM M_TESVIK_ONAY_KOMITESI";
        return $db->prep_exec_array($sql, array());
    }

    function TesvikImzaUserName($data)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT USER_ID FROM M_TESVIK_ONAY_KOMITESI";
        $dat = $db->prep_exec($sql, array());

        $mysqlDB = &JFactory::getDBO();
        $userNames = array();

        foreach ($dat as $row) {
            $sqlMatbaa = "SELECT name FROM #__users as users
					WHERE tgUserId = " . $row['USER_ID'];
            $mysqlDB->setQuery($sqlMatbaa);
            $user = $mysqlDB->loadObjectList();
            $userNames[$row['USER_ID']] = $user[0]->name;
        }
        return $userNames;
    }

    function TesvikAdaylarWithTesvikId($tId)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MBS.*, MBO.*, MAT.*, MTI.DURUM AS ITIRAZ_DURUMU, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN M_BELGE_TESVIK_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MBS.TESVIK = 2 AND MAT.TESVIK_ID = ? 
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY MBS.BELGE_DUZENLEME_TARIHI ASC, ADI ASC, SOYADI ASC, MBS.BELGE_MASRAF DESC
				";

        $tesvikAday = $db->prep_exec($sql, array($tId));

        $birimUcretiHesabi = array();
        $YetUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            $BelgeMasraf[$row['BELGENO']] = FormUcretHesabi::BelgeMasrafi($row['BELGE_DUZENLEME_TARIHI']);
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi, 'BelgeMasraf' => $BelgeMasraf);
    }

    function YeterlilikUcretHesabi($yId, $tarih)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MYU.UCRET, MYU.BAS_TARIH, MBK.KARAR_SAYI FROM M_YETERLILIK_UCRET MYU
				LEFT JOIN M_BAKANLAR_KURULU_KARAR_SAYI MBK ON(MYU.BAKANLAR_KURULU_KARAR_SAYI_ID = MBK.ID)  
				WHERE MYU.YETERLILIK_ID = ? AND MYU.BAS_TARIH <= TO_DATE(?) 
				ORDER BY BAS_TARIH DESC";
        $data = $db->prep_exec($sql, array($yId, $tarih));

        if ($data) {
            return $data[0];
        } else {
            return 0;
        }
    }

    function TesvikAdayUcretYazdir($tId)
    {
        $db = JFactory::getOracleDBO();
        $data = $this->TesvikAdaylarWithTesvikId($tId);

        $AdayBilgi = $data['AdayBilgi'];
        $UcretBilgi = $data['UcretBilgi'];
        $YetUcret = $data['YetUcret'];
        $BelgeMasraf = $data['BelgeMasraf'];

        $sql = "UPDATE M_BELGE_TESVIK_ADAY SET SINAV_UCRET = ?, BIRIMLER = ?, DAMGASIZ_UCRET = ?,
				DAMGALI_UCRET = ?, BELGE_MASRAF_UCRET = ?, BELGE_MASRAF = ?, BK_UCRET = ?, BK_KARAR_SAYI = ? 
				WHERE TESVIK_ID = ? AND BELGE_NO = ?";
        $hata = 0;
        foreach ($AdayBilgi as $row) {
            $SinavUcret = 0;
            $birimler = '';
            foreach ($UcretBilgi[$row['BELGENO']] as $key => $cow) {
                $SinavUcret += $cow['ucret'];
                $birimler .= $cow['kurId'] . '(' . $cow['tarih'] . ')-' . $key . '=' . $cow['ucret'] . ' # ';
            }

            $sqlItiraz = "SELECT * FROM M_BELGE_TESVIK_ITIRAZ WHERE BELGENO=? AND DURUM = 1";
            $datItiraz = $db->prep_exec($sqlItiraz, array($row['BELGENO']));

            if ($datItiraz) {
                $SinavUcret = $this->UcretDuzenle($datItiraz[0]['ITIRAZ_UCRET']);
            }

            if ($SinavUcret > $this->UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET'])) {
                $damgali = $this->UcretDuzenle($YetUcret[$row['BELGENO']]['UCRET']);
            } else {
                $damgali = $SinavUcret;
            }

            $damgasiz = $damgali - ($damgali * (0.00759));

            $parSinav = floor($SinavUcret * 100) / 100;
            $parDamgasiz = floor($damgasiz * 100) / 100;
            $parDamgali = floor($damgali * 100) / 100;

            $params = array(
                number_format($parSinav, 2, ',', ''),
                $birimler,
                number_format($parDamgasiz, 2, ',', ''),
                number_format($parDamgali, 2, ',', ''),
                number_format($BelgeMasraf[$row['BELGENO']], 2, ',', ''),
                $row['BELGE_MASRAF'],
                number_format($YetUcret[$row['BELGENO']]['UCRET'], 2, ',', ''),
                $YetUcret[$row['BELGENO']]['KARAR_SAYI'],
                (int)$tId,
                $row['BELGENO']
            );

            if (!$db->prep_exec_insert($sql, $params)) {
                $hata++;
            }
        }

        if ($hata > 0) {
            $sqlUp = "UPDATE M_BELGE_TESVIK_ADAY SET SINAV_UCRET = NULL, BIRIMLER = NULL, DAMGASIZ_UCRET = NULL, DAMGALI_UCRET = NULL WHERE TESVIK_ID = ?";
            $db->prep_exec_insert($sqlUp, array($tId));
            return false;
        } else {
            return true;
        }
    }

    function generateTxt($tesvikid, $temp = false)
    {

        $db = JFactory::getOracleDBO();

        $sql = "SELECT  M_BELGE_TESVIK_ADAY.BELGE_NO,
						M_BELGE_TESVIK_ADAY.DAMGALI_UCRET AS UCRET,
						M_BELGE_TESVIK_ADAY.BELGE_MASRAF_UCRET,
						M_BELGE_TESVIK_ISTEK.ID AS TESVIK_ID,
						M_BELGE_TESVIK_ISTEK.BANKA_ODEME_TARIHI AS BANKA_ODEME_TARIHI,
						M_BELGE_TESVIK_ISTEK.TARIH AS TESVIK_TARIHI,
						M_BELGELENDIRME_OGRENCI.IBAN,
						M_BELGELENDIRME_OGRENCI.ADI,
						M_BELGELENDIRME_OGRENCI.SOYADI,
						M_BELGELENDIRME_OGRENCI.BABA_ADI,
						M_BELGELENDIRME_OGRENCI.TC_KIMLIK,
						M_BELGELENDIRME_OGRENCI.TELEFON,
						M_BELGELENDIRME_OGRENCI.EMAIL,
						M_BELGE_SORGU.BELGE_MASRAF
				   FROM M_BELGE_TESVIK_ADAY
			 INNER JOIN M_BELGE_TESVIK_ISTEK ON M_BELGE_TESVIK_ISTEK.ID = M_BELGE_TESVIK_ADAY.TESVIK_ID
		LEFT OUTER JOIN M_BELGE_SORGU ON M_BELGE_SORGU.BELGENO = M_BELGE_TESVIK_ADAY.BELGE_NO
		LEFT OUTER JOIN M_BELGELENDIRME_OGRENCI ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGE_SORGU.TCKIMLIKNO
				  WHERE TESVIK_ID = ? AND M_BELGE_TESVIK_ADAY.ODENDI = 0
			   ORDER BY M_BELGE_SORGU.BELGE_DUZENLEME_TARIHI ASC, M_BELGE_SORGU.AD ASC, M_BELGE_SORGU.SOYAD ASC, M_BELGE_SORGU.BELGE_MASRAF DESC";
        $datas = $db->prep_exec($sql, array($tesvikid));
        if ($temp == true) {
            $directory = EK_FOLDER . "ziraat_eft/temp_kurumdan_bankaya/" . date('Ymd');
        } else {
            $directory = EK_FOLDER . "ziraat_eft/kurumdan_bankaya/" . date('Ymd');
        }
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = "eft_desen" . date('YmdHis') . ".txt";
        $fileLocation = $directory . '/' . $fileName;

        $file = fopen($fileLocation, "w");

        $headerDatas = current($datas);

        $content = "";
        $content .= str_pad('H', 1);
        $content .= str_pad(trim(ZIRAAT_MYK_KURUM_KODU), 5, "0", STR_PAD_LEFT);                //$kurum_kodu
        $content .= str_pad(trim(ZIRAAT_MYK_KURUM_ALT_KODU), 3, "0", STR_PAD_LEFT);            //$kurum_alt_kodu
        $content .= str_pad(trim($headerDatas['TESVIK_ID']), 10, "0", STR_PAD_LEFT);        //$bordro_no
        $tarihparts = explode(" ", $headerDatas['BANKA_ODEME_TARIHI']);
        $tarihparts = explode("/", $tarihparts[0]);
        $content .= str_pad($tarihparts[2] . $tarihparts[1] . $tarihparts[0], 8);            //TESVIK_TARIHI yerine BANKA_ODEME_TARIHI YAPILDI
        $content .= str_pad('Mesleki Yeterlilik Kurumu', 50) . "\n";                                            //$bordro_aciklama

        $toplam_adet = 0;
        $toplam_tutar = 0;
        foreach ($datas as $data) {

            $toplam_adet++;

            $detay = "D";

            if ($data['BELGE_MASRAF'] == 1) {
                $data['UCRET'] = number_format((float)str_replace(',', '.', ($data['UCRET'])), 2, '.', '') + number_format((float)str_replace(',', '.', ($data['BELGE_MASRAF_UCRET'])), 2, '.', '');
            } else {
                $data['UCRET'] = number_format((float)str_replace(',', '.', ($data['UCRET'])), 2, '.', '');
            }
            $data['UCRET'] = number_format(str_replace(',', '.', ($data['UCRET'])), 2, '.', '');
            $date = new DateTime('+1 day');

            $content .= str_pad(trim($detay), 1);
            $content .= str_pad(trim($toplam_adet), 7, "0", STR_PAD_LEFT);            //$toplam_adet
            if ($data['BANKA_ODEME_TARIHI'] <> "") {
                $content .= str_pad(trim(date('Ymd', strtotime(str_replace('/', '-', $data['BANKA_ODEME_TARIHI'])))), 8);
            } else {
                $content .= str_pad("", 8);
            }
            //str_pad($date->format('Ymd'),8);	//$ödeme_tarihi
            $content .= str_pad('0000', 4);                                            //$alacak_banka_kodu
            $content .= str_pad('00000', 5);                                            //$alacak_hesap_no
            $content .= str_pad(trim($data['IBAN']), 26);
            $content .= str_pad("", 16);                                            //$alacak_kredikart_no
            $content .= str_pad(trim($data['UCRET']), 16, "0", STR_PAD_LEFT);            //tutar

            $content .= FormFactory2::mb_str_pad(trim($data['ADI']), 30, ' ', STR_PAD_RIGHT);//str_pad($data['ADI'],30);
            $content .= FormFactory2::mb_str_pad(trim($data['SOYADI']), 30, ' ', STR_PAD_RIGHT);//str_pad($data['SOYADI'],30);
            $content .= FormFactory2::mb_str_pad(trim($data['BABA_ADI']), 30, ' ', STR_PAD_RIGHT);
            $content .= str_pad(trim($data['TC_KIMLIK']), 11);
            $content .= FormFactory2::mb_str_pad(trim(mb_substr("MYK MeslekiYeterlilikBelgesi sınav ücreti iadesi hesabınıza yatırılmıştır.Mesleki Yeterlilik Kurumu", 0, 100, "UTF-8")), 100, ' ', STR_PAD_RIGHT);//$aciklama
            $content .= str_pad(substr(ltrim($data['TELEFON'], 0), 0, 10), 10);
            $content .= str_pad(trim($data['EMAIL'], 100)) . "\n";

            $toplam_tutar += $data['UCRET'];
        }

        $trailer = "T";

        $content .= str_pad(trim($trailer), 1);
        $content .= str_pad(trim($toplam_adet), 7, "0", STR_PAD_LEFT);
        $content .= str_pad(number_format(trim($toplam_tutar), 2, '.', ''), 16, "0", STR_PAD_LEFT);


        fwrite($file, $content);
        fclose($file);

        return date('Ymd') . "/" . $fileName;
    }

    function explodeAndCommitTxt($path)
    {
        $db = JFactory::getOracleDBO();

        $real_path = EK_FOLDER . "ziraat_eft/bankadan_kuruma/" . $path;
        $file = fopen($real_path, 'r');
        $file_contents = fread($file, filesize($real_path));
        fclose($file);

        $contents = explode("\n", $file_contents);

        do {
            $head = current($contents);

            if ($head == null && empty($head)) {
                array_shift($contents);
            }
        } while ($head == null && empty($head));

        do {
            $trailer = end($contents);

            if ($trailer == null && empty($trailer)) {
                array_pop($contents);
            }
        } while ($trailer == null && empty($trailer));

        array_shift($contents);
        array_pop($contents);

        $odeme_array = array();
        for ($i = 0; $i < count($contents); $i++) {
            $odeme_array[$i]['TESVIKID'] = ltrim(substr($contents[$i], 1, 10), 0);
            $odeme_array[$i]['TCKN'] = substr($contents[$i], 191, 11);
            $odeme_array[$i]['STATUS'] = substr($contents[$i], 302, 1);
            $odeme_array[$i]['STATUS_MESSAGE'] = substr($contents[$i], 303, 20);
        }

        foreach ($odeme_array as $data) {
            $tesvikid = $data['TESVIKID'];
            $sql = "SELECT M_BELGE_TESVIK_ADAY.ID,M_BELGE_TESVIK_ADAY.BELGE_NO
					  FROM M_BELGE_TESVIK_ADAY 
                INNER JOIN M_BELGE_SORGU ON M_BELGE_SORGU.BELGENO = M_BELGE_TESVIK_ADAY.BELGE_NO 
                     WHERE M_BELGE_TESVIK_ADAY.TESVIK_ID = ? AND 
					       M_BELGE_SORGU.TCKIMLIKNO = ?";
            $tesvik_aday = $db->prep_exec($sql, array($data['TESVIKID'], $data['TCKN']));

            $odeme_durum = -1;
            if ($data['STATUS'] == "E") {
                $odeme_durum = 1;
            } else if ($data['STATUS'] == "H") {
                $odeme_durum = -1;
            } else if ($data['STATUS'] == "İ" || $data['STATUS'] == "I") {
                $odeme_durum = -2;
            }
            $sql_up = "UPDATE M_BELGE_TESVIK_ADAY SET ODENDI = ?,ACIKLAMA = ? WHERE TESVIK_ID = ? AND BELGE_NO = ?";

            $db->prep_exec_insert($sql_up, array($odeme_durum, $data['STATUS_MESSAGE'], $data['TESVIKID'], $tesvik_aday[0]['BELGE_NO']));
        }

        $sql_up_txt = "UPDATE M_BELGE_TESVIK_ISTEK SET AKIBET_TXT = ? WHERE ID = ?";
        $db->prep_exec_insert($sql_up_txt, array($path, $tesvikid));

        return true;
    }

    function previewTxtBeforeSendToBank($tesvikid)
    {
        $path = $this->generateTxt($tesvikid, true);
        return $path;
    }

    function afterTransferBankTxt($tesvikid)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT AKIBET_TXT FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";
        $data = $db->prep_exec($sql, array($tesvikid));

        $path = EK_FOLDER . "ziraat_eft/bankadan_kuruma/" . $data[0]['AKIBET_TXT'];
        $file = fopen($path, 'r');
        $file_contents = fread($file, filesize($path));
        $file_contents = iconv('', 'UTF-8', $file_contents);
        fclose($file);

        $contents = explode("\n", $file_contents);
        $head = current($contents);
        do {
            $trailer = end($contents);

            if ($trailer == null && empty($trailer)) {
                array_pop($contents);
            }
        } while ($trailer == null && empty($trailer));

        array_shift($contents);
        array_pop($contents);

        $tesvikid = "";
        $odenen_toplam_tutar = ltrim(substr($trailer, 8, 16), 0);
        $odenemeyen_toplam_tutar = ltrim(substr($trailer, 31, 16), 0);

        $txt_contents = array();
        $iadeedilenler = 0;
        for ($i = 0; $i < count($contents); $i++) {
            $tesvikid = ltrim(mb_substr($contents[$i], 1, 10, 'UTF-8'), 0);
            $txt_contents[$i]['TCKN'] = mb_substr($contents[$i], 191, 11, 'UTF-8');
            $txt_contents[$i]['ADSOYAD'] = trim(mb_substr($contents[$i], 101, 30, 'UTF-8')) . " " . trim(mb_substr($contents[$i], 131, 30, 'UTF-8'));
            $txt_contents[$i]['IBAN'] = mb_substr($contents[$i], 43, 26, 'UTF-8');
            $txt_contents[$i]['BANKA_ODEME_TARIHI'] = date('d/m/Y', strtotime(mb_substr($contents[$i], 11, 8, 'UTF-8')));
            $txt_contents[$i]['ODENEN_TUTAR'] = ltrim(mb_substr($contents[$i], 85, 16, 'UTF-8'), 0);
            $txt_contents[$i]['ODEME_DURUMU'] = mb_substr($contents[$i], 302, 1, 'UTF-8');
            $txt_contents[$i]['ODEME_ACIKLAMA'] = mb_substr($contents[$i], 303, 20, 'UTF-8');
            if ($txt_contents[$i]['ODEME_DURUMU'] == "I" || $txt_contents[$i]['ODEME_DURUMU'] == "İ") {
                $iadeedilenler = $iadeedilenler + $txt_contents[$i]['ODENEN_TUTAR'];
                $iadeedilenlerlistesi[] = $txt_contents[$i]['TCKN'];
            }
        }
        for ($i = 0; $i < count($txt_contents); $i++) {
            if ($txt_contents[$i]['ODEME_DURUMU'] == "E" && in_array($txt_contents[$i]['TCKN'], $iadeedilenlerlistesi)) {
                unset($txt_contents[$i]);
            }
        }

        $data = array('tesvikid' => $tesvikid,
            'status' => 'aftertransfer',
            'odenen_toplam_tutar' => ($odenen_toplam_tutar - $iadeedilenler),
            'odenemeyen_toplam_tutar' => $odenemeyen_toplam_tutar,
            'odeme_tarihi' => date('d/m/Y', strtotime(substr($head, 9, 8))),
            'content' => $txt_contents);
//        dd($data);
//        exit;
        return $data;
    }

    function readTxtForPdf($tesvikid, $path = false)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT BANKA_TXT FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";
        $path_info = $db->prep_exec($sql, array($tesvikid));

        if ($path <> false) {
            $path = EK_FOLDER . "ziraat_eft/temp_kurumdan_bankaya/" . $path;
            $status = 'temptransfer';
        } else {
            $path = EK_FOLDER . "ziraat_eft/kurumdan_bankaya/" . $path_info[0]['BANKA_TXT'];
            $status = 'beforetransfer';
        }
        $file = fopen($path, 'r');
        $file_contents = fread($file, filesize($path));
        fclose($file);

        $contents = explode("\n", $file_contents);

        $head = current($contents);
        $trailer = end($contents);

        $tesvikid = ltrim(substr($head, 10, 10), 0);
        $toplam_tutar = ltrim(substr($trailer, 9, 16), 0);
        $x = 0;
        $txt_contents = array();
        for ($i = 1; $i < (count($contents) - 1); $i++) {
            $txt_contents[$x]['TCKN'] = mb_substr($contents[$i], 173, 11, 'utf-8');
            $txt_contents[$x]['ADSOYAD'] = trim(substr($contents[$i], 83, 30)) . " " . trim(substr($contents[$i], 113, 30));
            $txt_contents[$x]['IBAN'] = substr($contents[$i], 25, 26);
            $txt_contents[$x]['ODENEN_TUTAR'] = ltrim(substr($contents[$i], 67, 16), 0);
            $txt_contents[$x]['BANKA_ODEME_TARIHI'] = date('d/m/Y', strtotime(substr($contents[$i], 8, 8)));
            $x++;
        }

        $data = array('tesvikid' => $tesvikid,
            'status' => $status,
            'toplam_tutar' => $toplam_tutar,
            'content' => $txt_contents);
        return $data;
    }

    function checkTxtFileForTesvik($tesvikid, $path)
    {

        $file = fopen($path, 'r');
        $file_contents = fread($file, filesize($path));
        fclose($file);

        $contents = explode("\n", $file_contents);

        do {
            $head = current($contents);

            if ($head == null && empty($head)) {
                array_shift($contents);
            }
        } while ($head == null && empty($head));

        do {
            $trailer = end($contents);

            if ($trailer == null && empty($trailer)) {
                array_pop($contents);
            }
        } while ($trailer == null && empty($trailer));

        array_shift($contents);
        array_pop($contents);

        $tesvikidlist = array();
        for ($i = 0; $i < count($contents); $i++) {
            $tesvikidlist[$i] = ltrim(substr($contents[$i], 1, 10), 0);
        }

        $cleanlist = array_unique($tesvikidlist);

        if (count($cleanlist) == 1) {
            if ($cleanlist[0] == $tesvikid) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function sendToZiraatTxt($path)
    {

        $sftp = new Net_SFTP(ZIRAAT_FTP_HOST);

        if ($sftp->login(ZIRAAT_FTP_USER, ZIRAAT_FTP_PASS)) {
            $file = explode('/', $path);
            $filename = end($file);
            $fileTo = "/kurumdan_bankaya/" . $filename;

            $real_path = EK_FOLDER . "ziraat_eft/kurumdan_bankaya/" . $path;

            if (file_exists($real_path)) {
                if ($sftp->put($fileTo, fopen($real_path, 'r'))) {
                    $return['FILE'] = $filename;
                    $return['STATUS'] = true;
                    $return['TEXT'] = "Dosya basariyla yüklendi";
                } else {

                    $return['STATUS'] = false;
                    $return['TEXT'] = "Dosya yükleme hatasi";
                }
            } else {
                $return['STATUS'] = false;
                $return['TEXT'] = "dosya bulunamadı";
            }
        } else {
            $return['STATUS'] = false;
            $return['TEXT'] = "ftp bağlanti hatasi";
        }

        $this->ziraatLog($return);
    }

    function readFromZiraatTxt($tesvikid)
    {

        $sftp = new Net_SFTP(ZIRAAT_FTP_HOST);

        if ($sftp->login(ZIRAAT_FTP_USER, ZIRAAT_FTP_PASS)) {

            //ilk önce doğru txt mi ??
            $directory_temp = EK_FOLDER . "ziraat_eft/temp_bankadan_kuruma/";

            if (!file_exists($directory_temp)) {
                mkdir($directory_temp, 0777, true);
            }

            //$fileTo
            $fileFrom = "/bankadan_kuruma/";

            $filelist = $sftp->nlist($fileFrom);

            $control = false;
            $fileth = count($filelist) - 1;
            do {
                $file = $filelist[$fileth];
                $fileTo = $directory_temp . $file;

                $sftp->get($fileFrom . $file, $fileTo);

                $control = $this->checkTxtFileForTesvik($tesvikid, $fileTo);
                if ($control == false) {
                    unlink($fileTo);
                    $fileth--;
                }

                if ($fileth == 0) {
                    break;
                }
            } while ($control == false);

            if ($control == true) {
                $directory = EK_FOLDER . "ziraat_eft/bankadan_kuruma/" . date('Ymd');

                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $files = explode('/', $fileTo);
                rename($fileTo, $directory . '/' . end($files));

                $return['FILE'] = date('Ymd') . '/' . end($files);
                $return['STATUS'] = true;
                $return['TEXT'] = "Dosya basariyla indirildi";
            } else {

                $return['STATUS'] = false;
                $return['TEXT'] = "Dosya indirme hatasi";
            }
        } else {
            $return['STATUS'] = false;
            $return['TEXT'] = "ftp bağlanti hatasi";
        }

        return $return;
    }

    function ziraatLog($text)
    {

        $conf =& JFactory::getConfig();

        if (is_array($text)) {

            foreach ($text as $key => $val) {
                $log_text = $key . "  :  " . $val . "\n";
            }

        } else {
            $log_text = $text;
        }
        $log_path = $conf->getValue('config.ziraat_eft_log');
        $log = "------------------------------------------\n" .
            "------------------------------------------\n" .
            date('Y-m-d H:i:s') . "\n" .
            $log_text . "\n" .
            "------------------------------------------\n" .
            "------------------------------------------\n\n";


        $content = file_get_contents($log_path);
        $content .= $log;
        file_put_contents($log_path, $content);

    }

    function TesvikItirazlar($durum = 0, $uId)
    {
        $db = JFactory::getOracleDBO();

        $sqlPlus = "";
        $uGrup = $this->UserKimGrup($uId);
        if (!$uGrup) {
            $sqlPlus = " AND MKG.TGUSERID = " . $uId;
        }

        $sql = "SELECT MTI.*, MBO.*, MBS.* FROM M_BELGE_TESVIK_ITIRAZ MTI
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MTI.TC_KIMLIK = MBO.TC_KIMLIK)
				INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MTI.SINAV_ID = MBS.SINAV_ID)
        		INNER JOIN M_KURULUS_GOREVLI MKG ON(MBS.KURULUS_ID = MKG.KURULUS_ID)
				WHERE MTI.DURUM = ? ";
        $sql .= $sqlPlus;
        $itirazlar = $db->prep_exec($sql, array($durum));

        $BelgeUcretBilgi = array();
        foreach ($itirazlar as $row) {
            $BelgeUcretBilgi[$row['BELGENO']] = $this->TesvikAdaylarWithBelgeNo($row['BELGENO']);
            $kurulus[$row['BELGENO']] = $this->getKurulusBilgi($row['KURULUS_ID']);
        }

        return array('itirazlar' => $itirazlar, 'BelgeUcretBilgi' => $BelgeUcretBilgi, 'kurulus' => $kurulus);
    }

    public function getKurulusBilgi($kurulusId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
				  ORDER BY KURULUS_ADI ASC";
        $data = $db->prep_exec($sql, array($kurulusId, $kurulusId));

        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }

    public function TesvikItirazWithBelgeNo($belgeno)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT * FROM M_BELGE_TESVIK_ITIRAZ MTI
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MTI.TC_KIMLIK = MBO.TC_KIMLIK)
				INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MTI.SINAV_ID = MBS.SINAV_ID)
				WHERE MTI.DURUM = 0 AND MTI.BELGENO = ?";

        $itirazlar = $db->prep_exec($sql, array($belgeno));

        $BelgeUcretBilgi = array();
        foreach ($itirazlar as $row) {
            $BelgeUcretBilgi[$row['BELGENO']] = $this->TesvikAdaylarWithBelgeNo($row['BELGENO']);
            $kurulus[$row['BELGENO']] = $this->getKurulusBilgi($row['KURULUS_ID']);
        }

        return array('itirazlar' => $itirazlar, 'BelgeUcretBilgi' => $BelgeUcretBilgi, 'kurulus' => $kurulus);
    }

    function AjaxItirazWithBelgeNo($belgeNo)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT * FROM M_BELGE_TESVIK_ITIRAZ
				WHERE BELGENO = ?";
        $data = $db->prep_exec($sql, array($belgeNo));

        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }

    function AjaxItirazUcretKaydetWithBelgeNo($belgeNo, $ucret)
    {
        $db = JFactory::getOracleDBO();
        $sql = "UPDATE M_BELGE_TESVIK_ITIRAZ SET ITIRAZ_UCRET = ?
				WHERE BELGENO = ?";
        $data = $db->prep_exec_insert($sql, array($ucret, $belgeNo));

        return $data;
    }

    function AjaxItirazDurumGuncelleWithBelgeNo($belgeNo, $durum)
    {
        $db = JFactory::getOracleDBO();
        $sql = "UPDATE M_BELGE_TESVIK_ITIRAZ SET DURUM = ?
				WHERE BELGENO = ?";
        $data = $db->prep_exec_insert($sql, array($durum, $belgeNo));

        return $data;
    }

    function getTarifeDonemleri($tarih)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT BELGE_MASRAFI, TARIFE_BASLANGICI FROM M_FINANS_TARIFE_DONEMI
				WHERE TARIFE_BASLANGICI <= TO_DATE(?)
				ORDER BY TARIFE_BASLANGICI DESC";

        $data = $db->prep_exec($sql, array($tarih));

        if ($data) {
            return $data[0]['BELGE_MASRAFI'];
        } else {
            return 0;
        }
    }

    function UserKimGrup($userId)
    {
        $db = JFactory::getOracleDBO();

        if ($userId == 40 || $userId == 7) {
            return 999;
        } else {
            $sql = "SELECT * FROM M_TESVIK_ONAY_KOMITESI
				WHERE USER_ID = ?";
            $dat = $db->prep_exec($sql, array($userId));

            if ($dat) {
                return $dat[0]['ROL_ID'];
            } else {
                return false;
            }
        }
    }

    function TesvikBankayaGonder($tId, $dId)
    {

        $db = JFactory::getOracleDBO();

        $sql = "SELECT BANKA_ODEME_TARIHI FROM M_BELGE_TESVIK_ISTEK WHERE ID = ?";

        $data = $db->prep_exec($sql, array($tId));

        if ($data[0]['BANKA_ODEME_TARIHI'] == "") {
            $return['STATUS'] = false;
            $return['STATUS_MESSAGE'] = "Banka ödeme tarihi girilmeden bankaya txt gönderimi sağlanamaz !";
        } else {
            $tesvik_txt_path = $this->generateTxt($tId);
            $sql = "UPDATE M_BELGE_TESVIK_ISTEK SET BANKA_TXT = ? WHERE ID = ?";

            $datas = $db->prep_exec_insert($sql, array($tesvik_txt_path, $tId));

            $this->sendToZiraatTxt($tesvik_txt_path);

            $sql = "UPDATE M_BELGE_TESVIK_ISTEK SET DURUM = ? WHERE ID = ?";
            if ($db->prep_exec_insert($sql, array($dId, $tId))) {
                $return['STATUS'] = true;
                $return['STATUS_MESSAGE'] = "Banka ödeme işlemi için bankaya txt gönderimi başarıyla sağlandı !";
            } else {
                $return['STATUS'] = false;
                $return['STATUS_MESSAGE'] = "Banka ödeme işlemi için bankaya txt gönderimi esnasında hata oluştu !";
            }
        }

        return $return;
    }

    function TesvikIskuraGonder($tId, $dId)
    {
        $db = JFactory::getOracleDBO();

        $sql = "UPDATE M_BELGE_TESVIK_ISTEK SET DURUM = ? WHERE ID = ?";
        return $db->prep_exec_insert($sql, array($dId, $tId));
    }

    function TesvikOdenenVeSonuc($data)
    {
        $db = JFactory::getOracleDBO();

        $TesvikOdemesi = array();
        $sql = "SELECT COUNT(*) as SAY FROM M_BELGE_TESVIK_ADAY WHERE TESVIK_ID = ? ";
        foreach ($data as $row) {
            if ($row['DURUM'] == 6) {
                $sqlOdendi = $sql . " AND ODENDI = 1";
                $datOdendi = $db->prep_exec($sqlOdendi, array($row['ID']));

                $sqlOdenmedi = $sql . " AND (ODENDI = -1 OR ODENDI = -2)";
                $datOdenmedi = $db->prep_exec($sqlOdenmedi, array($row['ID']));

                $TesvikOdemesi[$row['ID']] = array('odendi' => $datOdendi[0]['SAY'], 'odenmedi' => $datOdenmedi[0]['SAY']);
            }
        }
        return $TesvikOdemesi;
    }

    function TesvikOdenemeyen($tId)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT * FROM M_BELGE_TESVIK_ADAY MTA
				INNER JOIN M_BELGE_SORGU MBS ON(MTA.BELGE_NO = MBS.BELGENO) 
				WHERE MTA.TESVIK_ID = ? AND (MTA.ODENDI = -1 OR MTA.ODENDI = -2)";

        return $db->prep_exec($sql, array($tId));
    }

    function istekDetay($istekId)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT ID,USER_ID,TARIH,BIT_TARIH,BANKA_ODEME_TARIHI FROM M_BELGE_TESVIK_ISTEK WHERE ID=?";

        $datas = $db->prep_exec($sql, array($istekId));


        $mysqlDB = &JFactory::getDBO();

        $sqlUser = "SELECT name FROM #__users as users WHERE tgUserId = " . $datas[0]['USER_ID'];
        $mysqlDB->setQuery($sqlUser);
        $user = $mysqlDB->loadObjectList();
        $datas[0]['NAME'] = $user[0]->name;
        $datas[0]['BIT_TARIH'] = substr($datas[0]['BIT_TARIH'], 0, 10);
        $datas[0]['BANKA_ODEME_TARIHI'] = substr($datas[0]['BANKA_ODEME_TARIHI'], 0, 10);
        if (count($datas) > 0) {
            $retrun['STATUS'] = true;
            $retrun['DATA'] = current($datas);
        } else {
            $retrun['STATUS'] = false;
            $retrun['DATA'] = "";
        }

        return $retrun;
    }

    function saveIstekDetay($istekId, $bankaodemetarihi)
    {

        $db = JFactory::getOracleDBO();
        $sql = "UPDATE M_BELGE_TESVIK_ISTEK SET BANKA_ODEME_TARIHI = ? WHERE ID = ?";

        if ($db->prep_exec_insert($sql, array($bankaodemetarihi, $istekId))) {
            $retrun['STATUS'] = true;
            $retrun['STATUS_MESSAGE'] = "Banka ödeme tarihi başarıyla kaydedildi !";
        } else {
            $retrun['STATUS'] = false;
            $retrun['STATUS_MESSAGE'] = "Banka ödeme tarihi başarıyla kaydedilirken hata oluştu !";
        }

        return $retrun;
    }

    function TesvikAdaylarWithTesvikIdPDF($tId)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MBS.BELGENO, MBS.AD, MBS.SOYAD, MBS.TCKIMLIKNO, MBS.KURULUS_ADI, MBS.BELGE_DUZENLEME_TARIHI,
    			MBS.YETERLILIK_ADI, MBS.YETERLILIK_SEVIYESI, MBS.YETERLILIK_ID, 
    			MBO.ADI, MBO.SOYADI, MBO.TC_KIMLIK, MBO.TELEFON, MBO.IBAN, MAT.*,
case when (SELECT count(*) from m_belge_tesvik_aday where belge_no=MBS.BELGENO and odendi<>-3)>1 then 0 else MAT.BELGE_MASRAF_UCRET end as BELGE_UCRET
    			FROM M_BELGE_SORGU MBS
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN M_BELGE_TESVIK_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)
				WHERE MBS.TESVIK = 2 AND MAT.TESVIK_ID = ? AND MAT.ODENDI = 0
				ORDER BY BELGE_UCRET desc, ADI ASC, SOYADI ASC, MBS.BELGE_MASRAF DESC
				";

        $tesvikAday = $db->prep_exec($sql, array($tId));


        return array('AdayBilgi' => $tesvikAday);
    }


    function testDuzeltme()
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT MBS.BELGENO, MBS.TCKIMLIKNO, MBS.YETERLILIK_ID,
    			MAT.*	
    			FROM M_BELGE_SORGU MBS
				INNER JOIN M_BELGE_TESVIK_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)
				";
        $data = $db->prep_exec($sql, array());
        $sqlUp = "UPDATE M_BELGE_TESVIK_ADAY SET BK_UCRET = ?, BK_KARAR_SAYI = ?
				WHERE TESVIK_ID = ? AND BELGE_NO = ?";
        foreach ($data as $row) {
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
            $YetUcretiHesabi = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            $db->prep_exec_insert($sqlUp, array($this->UcretDuzenleTers($YetUcretiHesabi['UCRET']), $YetUcretiHesabi['KARAR_SAYI'], $row['TESVIK_ID'], $row['BELGENO']));
        }
    }

    public function UcretDuzenle($ucret)
    {
        return str_replace(',', '.', $ucret);
    }

    public function UcretDuzenleTers($ucret)
    {
        return str_replace('.', ',', $ucret);
    }

    public function Istatistik()
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT
                    to_char(to_date(MBS.SINAV_TARIHI),'yyyy') as yil,
                    count(*) as Kisi,
                    sum(MAT.SINAV_UCRET) + sum(MAT.BELGE_MASRAF_UCRET) as SinavUcreti,
                    sum(DAMGALI_UCRET)+ sum(MAT.BELGE_MASRAF_UCRET) as FonlananUcret
    		  FROM M_BELGE_SORGU MBS,M_BELGELENDIRME_OGRENCI MBO,M_BELGE_TESVIK_ADAY MAT
			  where MBS.TCKIMLIKNO = MBO.TC_KIMLIK
				AND MBS.BELGENO = MAT.BELGE_NO
				AND MBS.TESVIK = 2
				AND MAT.ODENDI=1
		      GROUP BY to_char(to_date(MBS.SINAV_TARIHI),'yyyy')";

        $istatistik = $db->prep_exec($sql, array());

        return $istatistik;
    }

    public function KurulusIstatistik($id)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT
                    to_char(to_date(MBS.SINAV_TARIHI),'yyyy') as yil,
                    count(*) as Kisi,
                    sum(MAT.SINAV_UCRET) + sum(MAT.BELGE_MASRAF_UCRET) as SinavUcreti,
                    sum(DAMGALI_UCRET)+ sum(MAT.BELGE_MASRAF_UCRET) as FonlananUcret
    		  FROM M_BELGE_SORGU MBS,M_BELGELENDIRME_OGRENCI MBO,M_BELGE_TESVIK_ADAY MAT
			  where MBS.TCKIMLIKNO = MBO.TC_KIMLIK
				AND MBS.BELGENO = MAT.BELGE_NO
				AND MBS.TESVIK = 2
				AND MAT.ODENDI=1
				AND MBS.KURULUS_ID= ?
		      GROUP BY to_char(to_date(MBS.SINAV_TARIHI),'yyyy')";

        $istatistik = $db->prep_exec($sql, array($id));

        return $istatistik;
    }

    function getAllKurulus($kurulus_durum)
    {
        $db = &JFactory::getOracleDBO();

        $sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(" . $kurulus_durum . ")
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND KURULUS_DURUM_ID IN(" . $kurulus_durum . ")
				  ORDER BY KURULUS_ADI ASC";
        return $db->prep_exec($sql, array());
    }

}