<?php
defined('_JEXEC') or die('Restricted access');

class Belgelendirme_TesvikModelBelgelendirme_Tesvik extends JModel
{

    function TesvikIstekleri($user_id)
    {
        $db = JFactory::getOracleDBO();

        $sqlIstek = "SELECT  CASE M_KURULUS_EDIT.KURULUS_KISA_ADI WHEN NULL THEN M_KURULUS.KURULUS_ADI
											ELSE M_KURULUS_EDIT.KURULUS_KISA_ADI END AS KURULUS_ADI,
				M_KURULUS_TESVIK_ISTEK.ID, 
				M_KURULUS_TESVIK_ISTEK.USER_ID, 
				M_KURULUS_TESVIK_ISTEK.DURUM, 
				M_KURULUS_TESVIK_ISTEK.DOSYA, 
				TO_CHAR(M_KURULUS_TESVIK_ISTEK.BIT_TARIH,'DD/MM/YYYY') AS BIT_TARIH, 
				M_KURULUS_TESVIK_ISTEK.IMZA_UNVAN, 
				M_KURULUS_TESVIK_ISTEK.IMZA_ISIM 
	 FROM M_KURULUS_TESVIK_ISTEK 
INNER JOIN M_KURULUS ON M_KURULUS.USER_ID = M_KURULUS_TESVIK_ISTEK.USER_ID
INNER JOIN M_KURULUS_EDIT ON M_KURULUS_EDIT.USER_ID = M_KURULUS_TESVIK_ISTEK.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
	WHERE M_KURULUS_TESVIK_ISTEK.USER_ID = ?
ORDER BY M_KURULUS_TESVIK_ISTEK.BIT_TARIH DESC";

        $istek = $db->prep_exec($sqlIstek, array($user_id));

        $adayCount = array();
        foreach ($istek as $row) {
            $adays = $this->TesvikIstekAdaylar($row['ID']);
            $adayCount[$row['ID']] = count($adays);
        }

        return array('isteks' => $istek, 'adayCount' => $adayCount);
    }

    function TesvikIstekleriWithDurum($durum)
    {
        $db = JFactory::getOracleDBO();

        $sqlIstek = "SELECT CASE M_KURULUS_EDIT.KURULUS_KISA_ADI WHEN NULL THEN M_KURULUS.KURULUS_ADI
							ELSE M_KURULUS_EDIT.KURULUS_KISA_ADI END AS KURULUS_ADI,
							M_KURULUS_TESVIK_ISTEK.ID, 
							M_KURULUS_TESVIK_ISTEK.USER_ID, 
							M_KURULUS_TESVIK_ISTEK.DURUM, 
							M_KURULUS_TESVIK_ISTEK.DOSYA, 
							TO_CHAR(M_KURULUS_TESVIK_ISTEK.BIT_TARIH,'DD/MM/YYYY') AS BIT_TARIH,
							M_KURULUS_TESVIK_ISTEK.IMZA_UNVAN, 
							M_KURULUS_TESVIK_ISTEK.IMZA_ISIM 
							FROM M_KURULUS_TESVIK_ISTEK 
							INNER JOIN M_KURULUS ON M_KURULUS.USER_ID = M_KURULUS_TESVIK_ISTEK.USER_ID
							INNER JOIN M_KURULUS_EDIT ON M_KURULUS_EDIT.USER_ID = M_KURULUS_TESVIK_ISTEK.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
							WHERE M_KURULUS_TESVIK_ISTEK.DURUM = ?
											ORDER BY M_KURULUS_TESVIK_ISTEK.BIT_TARIH DESC";

        $istek = $db->prep_exec($sqlIstek, array($durum));

        $adayCount = array();
        foreach ($istek as $row) {
            $adays = $this->TesvikIstekAdaylar($row['ID']);
            $adayCount[$row['ID']] = count($adays);
        }

        return array('isteks' => $istek, 'adayCount' => $adayCount);
    }

    function TesvikIstekAdaylar($IstekId)
    {
        $db = JFactory::getOracleDBO();

        $sqlAday = "SELECT * FROM M_KURULUS_TESVIK_ADAY MTA
				INNER JOIN M_BELGE_SORGU MBS ON(MTA.BELGE_NO = MBS.BELGENO) 
				WHERE MTA.ISTEK_ID = ?";

        return $db->prep_exec($sqlAday, array($IstekId));
    }

    function TesvikIstekAdaylarWithTarih($user_id, $bitTarih)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MBS.KURULUS_ID = ? AND MBS.TESVIK = 1 
				AND MBS.BELGE_DUZENLEME_TARIHI <= TO_DATE(?)
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY MBS.BELGE_DUZENLEME_TARIHI DESC, ADI ASC, SOYADI ASC
				";

        $tesvikAday = $db->prep_exec($sql, array($user_id, $bitTarih));

        $BelgeMasraf = array();
        $YetUcretiHesabi = array();
        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            if ($row['BELGE_MASRAF']) {
                $sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
                $masraf = $db->prep_exec($sqlMasraf, array($row['BELGE_DUZENLEME_TARIHI']));
                $BelgeMasraf[$row['BELGENO']] = $masraf[0]['BELGE_MASRAFI'];
            } else {
                $BelgeMasraf[$row['BELGENO']] = 0;
            }
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf
        );
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
                $sql = "select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=" . $row["BIRIM_ID"];
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

    function TesvikIstekKaydet($post, $user_id)
    {
        $db = JFactory::getOracleDBO();

        if (array_key_exists('IstekId', $post) && is_numeric($post['IstekId'])) {
            $IstekId = $post['IstekId'];
            $sqlUp = "UPDATE M_KURULUS_TESVIK_ISTEK SET IMZA_UNVAN = ?, IMZA_ISIM = ? WHERE ID = ?";
            $return = $db->prep_exec_insert($sqlUp, array($post['unvan'], $post['isim'], $IstekId));
        } else {
            $IstekId = $db->getNextVal('SEQ_KURULUS_TESVIK_ISTEK');
            $sql = "INSERT INTO M_KURULUS_TESVIK_ISTEK (ID,USER_ID,BIT_TARIH,IMZA_UNVAN,IMZA_ISIM) VALUES(?,?,TO_DATE(?,'DD/MM/YYYY'),?,?)";
            $return = $db->prep_exec_insert($sql, array($IstekId, $user_id, $post['bit_tarih'], $post['unvan'], $post['isim']));
        }

        if (!$return) {
            return false;
        }

        $adays = $post['adays'];

        $sqlDel = "DELETE FROM M_KURULUS_TESVIK_ADAY WHERE ISTEK_ID = ?";
        $db->prep_exec_insert($sqlDel, array($IstekId));

        $sqlInsAday = "INSERT INTO M_KURULUS_TESVIK_ADAY (ISTEK_ID, BELGE_NO, ILK_SINAV_TARIHI) VALUES(?,?,TO_DATE(?))";
        $hata = 0;
        foreach ($adays as $row) {
            // İlk Sınav Tarihi
            $sqlTC = "SELECT TCKIMLIKNO, YETERLILIK_ID FROM M_BELGE_SORGU WHERE BELGENO = ?";
            $dataTC = $db->prep_exec($sqlTC, array($row));
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($dataTC[0]['TCKIMLIKNO'], $dataTC[0]['YETERLILIK_ID']);
            // İlk Sınav Tarihi

            if (!$db->prep_exec_insert($sqlInsAday, array($IstekId, $row, $ilkSinav))) {
                $hata++;
            }
        }

        if ($hata > 0) {
            return array('durum' => 1, 'message' => 'Teşvik isteği oluşturuldu. Fakat bazı belgeler tesvik isteğine kaydedilemedi. Lütfen teşvik isteğini tekrar düzenleyin.', 'IstekId' => $IstekId);
        } else {
            return array('durum' => 2, 'message' => 'Başarılı bir şekilde teşvik isteği oluşturuldu. Teşvik isteğinin pdf formatında indirdikten sonra imzalayarak sisteme geri yükleyin.', 'IstekId' => $IstekId);
        }
    }

    function GetTesvikWithTesvikId($IstekId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT ID, USER_ID, DURUM, TO_CHAR(BIT_TARIH,'dd/mm/yyyy') AS BIT_TARIH, IMZA_UNVAN, IMZA_ISIM FROM M_KURULUS_TESVIK_ISTEK WHERE ID = ?";
        $data = $db->prep_exec($sql, array($IstekId));

        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }

    function GetTesvikAdaylarWithTesvikId($IstekId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT BELGE_NO FROM M_KURULUS_TESVIK_ADAY WHERE ISTEK_ID = ?";
        $data = $db->prep_exec_array($sql, array($IstekId));
        return $data;
    }

    function TesvikAdaylarWithTesvikId($tId)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT MBS.*, MBO.*, MAT.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN M_KURULUS_TESVIK_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MAT.ISTEK_ID = ?
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC
				";

        $tesvikAday = $db->prep_exec($sql, array($tId));

        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            if ($row['BELGE_MASRAF']) {
                $sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
                $masraf = $db->prep_exec($sqlMasraf, array($row['BELGE_DUZENLEME_TARIHI']));
                $BelgeMasraf[$row['BELGENO']] = $masraf[0]['BELGE_MASRAFI'];
            } else {
                $BelgeMasraf[$row['BELGENO']] = 0;
            }
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf
        );
    }

    function TesvikAdaylarEditWithTarih($user_id, $IstekId, $bitTarih)
    {
        $db = JFactory::getOracleDBO();
        $tesvikAday = array();

        $sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MBS.TESVIK = 1 AND MBS.KURULUS_ID = ?
				AND MBS.BELGENO NOT IN (SELECT BELGE_NO FROM M_KURULUS_TESVIK_ADAY)
				AND MBS.BELGE_DUZENLEME_TARIHI <= TO_DATE(?)
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC
				";

        $tesvikAday = $db->prep_exec($sql, array($user_id, $bitTarih));

        $sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN M_KURULUS_TESVIK_ADAY MTA ON(MBS.BELGENO = MTA.BELGE_NO)
				LEFT JOIN M_BELGE_TESVIK_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				WHERE MTA.ISTEK_ID = ? AND MBS.KURULUS_ID = ?
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC";

        $tAday = $db->prep_exec($sql, array($IstekId, $user_id));

        foreach ($tAday as $row) {
            $tesvikAday[] = $row;
        }

        $birimUcretiHesabi = array();
        foreach ($tesvikAday as $row) {
            $birimUcretiHesabi[$row['BELGENO']] = FormUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'], $row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            /* Tesvik tarihinden sonraki ilk sınav tarihi */
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
            // 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $row['SINAV_TARIHI']);
            $YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
            if ($row['BELGE_MASRAF']) {
                $sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
                $masraf = $db->prep_exec($sqlMasraf, array($row['BELGE_DUZENLEME_TARIHI']));
                $BelgeMasraf[$row['BELGENO']] = $masraf[0]['BELGE_MASRAFI'];
            } else {
                $BelgeMasraf[$row['BELGENO']] = 0;
            }
        }

        return array('AdayBilgi' => $tesvikAday, 'UcretBilgi' => $birimUcretiHesabi, 'YetUcret' => $YetUcretiHesabi,
            'BelgeMasraf' => $BelgeMasraf
        );
    }

    function TesvikPdfKaydet($post, $files, $user_id)
    {
        $db = JFactory::getOracleDBO();

        $IstekId = $post['IstekId'];
        $IstekPdf = $files['IstekPdf'];

        if (is_numeric($IstekId) && $IstekId > 0) {
            if ($IstekPdf['size'] > 0 && $IstekPdf['error'] == 0 && $IstekPdf['type'] == 'application/pdf') {
                $directory = EK_FOLDER . "KurulusTesvikIstek/" . $user_id . "/" . $IstekId;
                if (!file_exists($directory)) {
                    mkdir($directory, 0700, true);
                }

                $normalFile = date('Ymd_His') . '.pdf';
                $path = "KurulusTesvikIstek/" . $user_id . "/" . $IstekId . "/" . $normalFile;
                if (move_uploaded_file($IstekPdf['tmp_name'], $directory . '/' . $normalFile)) {
                    $sql = "UPDATE M_KURULUS_TESVIK_ISTEK SET DOSYA = ? WHERE ID = ?";

                    if ($db->prep_exec_insert($sql, array($path, $IstekId))) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    function TesvikPdfSil($IstekId)
    {
        $db = JFactory::getOracleDBO();

        if (is_numeric($IstekId)) {
            $sql = "UPDATE M_KURULUS_TESVIK_ISTEK SET DOSYA = NULL WHERE ID = ?";

            if ($db->prep_exec_insert($sql, array($IstekId))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function TesvikSil($IstekId)
    {
        $db = JFactory::getOracleDBO();

        if (is_numeric($IstekId)) {
            $sql = "DELETE FROM M_KURULUS_TESVIK_ISTEK WHERE ID = ?";
            $sqlAdayDel = "DELETE FROM M_KURULUS_TESVIK_ADAY WHERE ISTEK_ID = ?";

            if ($db->prep_exec_insert($sqlAdayDel, array($IstekId))) {
                if ($db->prep_exec_insert($sql, array($IstekId))) {
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

    function TesvikOnayaSun($IstekId, $user_id)
    {
        $db = JFactory::getOracleDBO();

        if (is_numeric($IstekId)) {

            $sql_istek_bilgi = "SELECT IMZA_ISIM,IMZA_UNVAN FROM M_KURULUS_TESVIK_ISTEK WHERE ID = ? AND ROWNUM <2";
            $data = $db->prep_exec($sql_istek_bilgi, array($IstekId));
            if ($data[0]['IMZA_ISIM'] == "" || $data[0]['IMZA_UNVAN'] == "") {
                $return['ERR'] = 1;
                $return['ERR_TEXT'] = "Ücret iadesi istek talebinde bulunurken İmza Yetkilisi Unvan veya İmza Yetkilisi Ad Soyad alanları boş bırakılamaz !";
            } else {
                $sql = "UPDATE M_KURULUS_TESVIK_ISTEK SET DURUM = 1 WHERE ID = ?";

                if ($db->prep_exec_insert($sql, array($IstekId))) {
                    $kurulus = FormFactory::getKurulusGuncelBilgi($user_id);
                    if (!$kurulus) {
                        $kurulus = FormFactory::getKurulusValues($user_id);
                    }

                    $body = '<div style="font-size:20px;">';
                    $body .= '<p>' . $kurulus['KURULUS_ADI'] . ' ücret iadesi talebinde bulundu. Ulaşmak için <a target="_blank" href="http://portal.myk.gov.tr/index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri">tıklayınız</a>.</p>';
                    $body .= '</div>';
                    FormFactory::sentEmail('Ücret İadesi Talebi', $body, array('htoplu@myk.gov.tr', 'ktunc@myk.gov.tr', 'epapur@myk.gov.tr', 'mozgen@myk.gov.tr', 'mordukaya@myk.gov.tr'), true);
                    $return['ERR'] = 0;
                    $return['ERR_TEXT'] = "Başarılı";
                } else {
                    $return['ERR'] = 1;
                    $return['ERR_TEXT'] = "Teknik bir hata oluştu !";
                }
            }
        } else {
            $return['ERR'] = 1;
            $return['ERR_TEXT'] = "Teknik bir hata oluştu !";
        }
        return $return;
    }

    function TesvikDurumGuncelle($IstekId, $durum, $user_id)
    {
        $db = JFactory::getOracleDBO();

        if (is_numeric($IstekId)) {
            $sql = "UPDATE M_KURULUS_TESVIK_ISTEK SET DURUM = ?, ONAY_USER = ? WHERE ID = ?";

            if ($db->prep_exec_insert($sql, array($durum, $user_id, $IstekId))) {
                if ($durum == 2) {
                    $sqlAday = "SELECT * FROM M_KURULUS_TESVIK_ADAY WHERE ISTEK_ID = ?";
                    $dataAday = $db->prep_exec($sqlAday, array($IstekId));
                    foreach ($dataAday as $row) {
                        $sqlUp = "UPDATE M_BELGE_SORGU SET TESVIK = 2 WHERE BELGENO = ?";
                        $db->prep_exec_insert($sqlUp, array($row['BELGE_NO']));
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function OnayUserMi($user_id)
    {
        $db = JFactory::getOracleDBO();

        $sql = "SELECT * FROM M_TESVIK_ONAY_KOMITESI WHERE USER_ID = ?";

        $data = $db->prep_exec($sql, array($user_id));
        if ($data || $user_id == 40) {
            return true;
        } else {
            return false;
        }
    }

    function TesvikYetkiliMi($user_id, $IstekId)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT * FROM M_KURULUS_TESVIK_ISTEK WHERE ID = ? AND USER_ID = ?";
        return $db->prep_exec($sql, array($IstekId, $user_id));
    }

    function adayBilgiKontrol($belgelist)
    {
        $db = JFactory::getOracleDBO();

        $datas = explode(",", $belgelist);
        $error = array();
        foreach ($datas as $belgeno) {
            $sql = "SELECT TCKIMLIKNO FROM M_BELGE_SORGU WHERE BELGENO = ?";

            $belge = $db->prep_exec($sql, array($belgeno));

            $tckimlik = current($belge);

            $sql2 = "SELECT TELEFON,IBAN FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK = ?";

            $ogrencidatas = $db->prep_exec($sql2, array($tckimlik['TCKIMLIKNO']));

            $ogrencidata = current($ogrencidatas);

            if ($ogrencidata['TELEFON'] == "") {
                $error[$belgeno]['ERR'] = "1";
                $error[$belgeno]['ERR_TEXT'] = "Aday TELEFON bilgileri bulunmamaktadır.";
            } else if ($ogrencidata['IBAN'] == "") {
                $error[$belgeno]['ERR'] = "2";
                $error[$belgeno]['ERR_TEXT'] = "Aday IBAN bilgileri bulunmamaktadır.";
            } else {
                $error[$belgeno]['ERR'] = "0";
                $error[$belgeno]['ERR_TEXT'] = "Aday bilgilerinde hata bulunamadı.";
            }
        }
        return $error;
    }

    function TesvikBilgi($istekid)
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT CASE M_KURULUS_EDIT.KURULUS_ADI WHEN NULL THEN M_KURULUS.KURULUS_ADI
					    ELSE M_KURULUS_EDIT.KURULUS_ADI END AS KURULUS_ADI,
						M_KURULUS_TESVIK_ISTEK.BIT_TARIH
				 FROM M_KURULUS_TESVIK_ISTEK 
		   INNER JOIN M_KURULUS ON M_KURULUS.USER_ID = M_KURULUS_TESVIK_ISTEK.USER_ID
		   INNER JOIN M_KURULUS_EDIT ON M_KURULUS_EDIT.USER_ID = M_KURULUS_TESVIK_ISTEK.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
				WHERE M_KURULUS_TESVIK_ISTEK.ID = ?";
        $data = $db->prep_exec($sql, array($istekid));

        return current($data);
    }

    function TestButunTarihlerUpdate()
    {
        $db = JFactory::getOracleDBO();
        $sql = "SELECT MBS.* FROM M_BELGE_SORGU MBS
				INNER JOIN M_KURULUS_TESVIK_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)";
        $data = $db->prep_exec($sql, array());

        $sqlUp = "UPDATE M_KURULUS_TESVIK_ADAY SET ILK_SINAV_TARIHI = TO_DATE(?) WHERE BELGE_NO = ?";
        foreach ($data as $row) {
            $ilkSinav = FormUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'], $row['YETERLILIK_ID']);
            $db->prep_exec_insert($sqlUp, array($ilkSinav, $row['BELGENO']));
        }

    }

    function OncekiTesvikOdenmeyenler($user_id)
    {
        $db = JFactory::getOracleDBO();
        $sql = "select s.TCKIMLIKNO,s.AD,s.SOYAD,s.BELGENO,o.IBAN,AD.ODENDI,AD.ACIKLAMA,o.IBAN from M_BELGE_TESVIK_ADAY ad, M_BELGE_SORGU s,M_BELGELENDIRME_OGRENCI o
			where s.BELGENO=ad.BELGE_NO and s.TCKIMLIKNO=o.TC_KIMLIK
			and (ad.ODENDI=-1 or ad.ODENDI=-2 or ad.ODENDI=-3)
			and ad.BELGE_NO NOT IN (select BELGE_NO from M_BELGE_TESVIK_ADAY where ODENDI=1 or ODENDI=0)
			and s.KURULUS_ID=?
			order by s.AD,s.SOYAD";
        $data = $db->prep_exec($sql, array($user_id));
        return $data;
    }

}

?>