<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class Meslek_Std_TaslakModelTaslak_Kaydet extends JModel
{

    function taslakKaydet($data, $layout, $standart_id, $evrak_id)
    {
        $user = &JFactory::getUser();

        if ($evrak_id == -1) {
            $evrak_id = $this->basvuruOlustur();
            $taslak_meslek_id = $this->taslakMeslekOlustur($evrak_id, $standart_id);
        } else {
            $taslak_meslek_id = $this->getTaslakMeslekId($evrak_id);
        }

        $this->dokunulmamissaOntaslagiKaydet($standart_id);

        if ($evrak_id != -1) {
            switch ($layout) {
                case "hazirlayan":
                    $sayfaNum = 1;
                    $colCount = 3;//2ydi yüklenicileri ekledik 3 oldu
                    $tableName = "hazirlayan";
                    $dbTableName = "m_taslak_meslek_hazirlayan";
                    $dbTableId = "hazirlayan_id";
//	    			$data = $this->arrangeDataForRadioButtons($data, $tableName); 
                    $message = $this->hazirlayanKurulusKaydet($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);
                    break;
                case "terim":
                    $sayfaNum = 2;
                    $user = &JFactory::getUser();
                    $_db = &JFactory::getOracleDBO();

                    $terimId = $data["terimId"];
                    $sql = "DELETE FROM M_STANDART_TASLAK_TERIM
                                WHERE taslak_id = " . $taslak_meslek_id;
                    $_db->prep_exec_insert($sql, "");
                    for ($i = 0; $i < count($terimId); $i++) {
                        $sql = "INSERT INTO M_STANDART_TASLAK_TERIM
                				values (" . $terimId[$i] . ", " . $taslak_meslek_id . ")";
                        $_db->prep_exec_insert($sql, "");
                    }

                    for ($i = 0; $i < count($data["terimAdi"]); $i++) {
                        $terim_id = $_db->getNextVal(TERIM_SEQ);

                        $terim_adi = FormFactory::toUpperCase($data["terimAdi"][$i]);
                        $terim_aciklama = $data["terimAciklama"][$i];

                        //Prepare sql statement
                        $sql = "INSERT INTO M_TERIM
                				values (?, ?, ?)";
                        $params = array($terim_id,
                            $terim_adi,
                            $terim_aciklama
                        );
                        $_db->prep_exec_insert($sql, $params);

                        $sql = "INSERT INTO M_STANDART_TASLAK_TERIM
                				values (?, ?)";
                        $params = array($terim_id,
                            $taslak_meslek_id
                        );

                        $_db->prep_exec_insert($sql, $params);
                    }

                    for ($i = 0; $i < count($data["terimAdiUp"]); $i++) {
                        $terim_id = $data["terimIdUp"][$i];

                        $terim_adi = FormFactory::toUpperCase($data["terimAdiUp"][$i]);
                        $terim_aciklama = $data["terimAciklamaUp"][$i];

                        //Prepare sql statement
                        $sql = "UPDATE M_TERIM SET TERIM_ADI=?, TERIM_ACIKLAMA=?
                				WHERE TERIM_ID=?";
                        $params = array(
                            $terim_adi,
                            $terim_aciklama,
                            $terim_id
                        );
                        $_db->prep_exec_insert($sql, $params);
                    }

                    $message = JText::_("VERI_KAYDI_BASARILI");
//	    			$message = $this->tabloKaydet ($data, $layout,$colCount,$tableName,$taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);
                    break;
                case "meslek_tanitimi":
                    $sayfaNum = 3;
                    $colCount = 3;
                    $tableName = "meslekStandart";
                    $dbTableName = "m_taslak_meslek_standart";
                    $dbTableId = "standart_id";

                    $result = $this->tanitimKaydet($data, $taslak_meslek_id, $standart_id, $evrak_id);
                    $message = $this->tabloKaydet($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);
                    break;
                case "meslek_profil":
                    $sayfaNum = 4;

                    $result = $this->profilKaydet($data, $taslak_meslek_id, $standart_id);

                    if ($result)
                        $message = JText::_("VERI_KAYDI_BASARILI");
                    else
                        $message = JText::_("VERI_KAYDI_BASARISIZ");

                    break;
                case "ekipman":
                    $sayfaNum = 5;
                    $colCount = 2;
                    $tableName = "ekipman";
                    $dbTableName = "m_taslak_meslek_ekipman";
                    $dbTableId = "ekipman_id";

                    $message = $this->tabloKaydet2($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);
                    break;
                case "bilgi_beceri":
                    $sayfaNum = 6;
                    $colCount = 2;
                    $tableName = "bilgiBeceri";
                    $dbTableName = "m_taslak_meslek_bilgi_beceri";
                    $dbTableId = "bilgi_beceri_id";

                    $message = $this->tabloKaydet2($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);
                    break;
                case "tutum_davranis":
                    $sayfaNum = 7;
                    $colCount = 2;
                    $tableName = "tutumDavranis";
                    $dbTableName = "m_taslak_meslek_tutum";
                    $dbTableId = "tutum_davranis_id";

                    $message = $this->tabloKaydet2($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);
                    break;
                case "gorev_alanlar":
                    $sayfaNum = 8;
                    $colCount = 4;
                    $tableCount = 5;

                    $result = $this->gorevAlanKaydet($data, $taslak_meslek_id, $colCount, $tableCount);
                    if ($result)
                        $message = JText::_("VERI_KAYDI_BASARILI");
                    else
                        $message = JText::_("VERI_KAYDI_BASARISIZ");

                    break;
            }

            if ($message == JText::_("VERI_KAYDI_BASARILI"))
                $this->insertSavedPage($sayfaNum, $evrak_id, $user->id, YT1_BASVURU_TIP, $standart_id);
        } else {
            $message = JText::_("VERI_KAYDI_BASARILI");
        }

        return $message;
    }

    function yorumlariGonder($evrak_id)
    {
        $this->clearPreviousYorum_SS($evrak_id);
        $this->updateYorumDurum_SS($evrak_id, 0);
    }

    function updateStandartDurum($standart_id, $durumID)
    {
        $_db = &JFactory::getOracleDBO();
        FormParametrik::uyariKaydet(Array(MESLEK_STANDARTI, "00"), $standart_id, "");

        //Prepare sql statement
        $sql = "UPDATE m_meslek_standartlari
					SET MESLEK_STANDART_DURUM_ID = ?
				WHERE standart_id = ?";

        $params = array($durumID, $standart_id);
        return $_db->prep_exec_insert($sql, $params);
    }

    function yorumKaydet_SS($post, $evrak_id, $layout)
    {
        $db = &JFactory::getOracleDBO();

        $sql = 'DELETE FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ?
		AND TASLAK_TIPI = ' . PM_TASLAK_YORUM_TIPI__STANDART_YORUMU . '
		AND SS_YORUMU_MU = 1 AND LAYOUT = ?';
        $params = array($_GET['standart_id'], $layout);
        $data = $db->prep_exec($sql, $params);


        $sql = 'INSERT INTO m_taslak_yorum
				(STD_VEYA_YET_ID,TASLAK_TIPI, SS_YORUMU_MU, LAYOUT, YORUM) 
		VALUES  (?, ' . PM_TASLAK_YORUM_TIPI__STANDART_YORUMU . ', 1, ?, ?)';
        $params = array($_GET['standart_id'], $layout, $post['yorum']);
        $sonuc = $db->prep_exec_insert($sql, $params);

        return $sonuc;
    }

    function yorumKaydet_Kurulus($post, $evrak_id, $layout)
    {
        $db = &JFactory::getOracleDBO();

        $sql = 'DELETE FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ?
		AND TASLAK_TIPI = ' . PM_TASLAK_YORUM_TIPI__STANDART_YORUMU . '
		AND SS_YORUMU_MU = 0 AND LAYOUT = ?';
        $params = array($_GET['standart_id'], $layout);
        $data = $db->prep_exec($sql, $params);


        $sql = 'INSERT INTO m_taslak_yorum
				(STD_VEYA_YET_ID,TASLAK_TIPI, SS_YORUMU_MU, LAYOUT, YORUM) 
		VALUES  (?, ' . PM_TASLAK_YORUM_TIPI__STANDART_YORUMU . ', 0, ?, ?)';
        $params = array($_GET['standart_id'], $layout, $post['yorum_Kurulus']);
        $sonuc = $db->prep_exec_insert($sql, $params);

        return $sonuc;
    }

    function sektorSorumlusunaGonder($standart_id)
    {
        $this->updateStandartDurum($standart_id, PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK);
        $this->updateStandartSurecDurum($standart_id, 6);
// 		$this->updateEditable($standart_id, 0);
    }

    function onBasvuruOnayla($evrak_id, $standart_id)
    {
        $this->updateStandartDurum($standart_id, PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK);
    }


    function basvuruOnayla($evrak_id, $standart_id)
    {
        $this->updateStandartDurum($standart_id, PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART);
        $this->updateStandartSurecDurum($standart_id, PM_MESLEK_STANDART_SUREC_DURUMU__RESMI_GAZETEDE_YAYINLANDI);
    }

    function onBasvuruBitir($evrak_id, $standart_id)
    {
        $this->updateBasvuruDurum($evrak_id, IMZA_BEKLENEN_BASVURU);
        $this->updateStandartDurum($standart_id, PM_MESLEK_STANDART_DURUMU__TASLAK);
        //$this->updateStandartSurecDurum($standart_id, IMZA_BEKLENEN_STANDART);
        $this->updateEditable($standart_id, 0);
        $this->clearSavedPages($evrak_id);
        //$this->clearSavedYorum_SS ($evrak_id);
    }

    function tabloKaydet2($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId)
    {
        $_db = &JFactory::getOracleDBO();

        echo "<pre>";
        print_r($_REQUEST);
        echo "</pre>$dbTableName-$tableName";
//        exit;
        switch ($layout) {
            case "ekipman":
                $dataAl = $data["ekipman"];
                break;
            case "bilgi_beceri":
                $dataAl = $data["bilgiBeceri"];
                break;
            case "tutum_davranis":
                $dataAl = $data["tutumDavranis"];
                break;
        }
        $sql = "DELETE FROM " . $dbTableName . "
				WHERE taslak_meslek_id = ?";

        $params = array($taslak_meslek_id
        );
        $_db->prep_exec_insert($sql, $params);
        for ($i = 0; $i < count($dataAl); $i++) {
            if ($dataAl[$i] != "") {
                switch ($layout) {
                    case "ekipman":
                        $yeni_id = $_db->getNextVal(EKIPMAN_SEQ);
                        break;
                    case "bilgi_beceri":
                        $yeni_id = $_db->getNextVal(BILGI_BECERI_SEQ);
                        break;
                    case "tutum_davranis":
                        $yeni_id = $_db->getNextVal(TUTUM_DAVRANIS_SEQ);
                        break;
                }
                $sql = "INSERT INTO " . $dbTableName . "
        				values (?,?,?)";
                $params = array($yeni_id, $taslak_meslek_id, $dataAl[$i]);
                $_db->prep_exec($sql, $params);
            }
        }
        return JText::_("VERI_KAYDI_BASARILI");
    }

    function tabloKaydet($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId)
    {

        echo "<pre>";
//    	print_r($data);
        echo "</pre>";
//    	exit;


        $user = &JFactory::getUser();
        $_db = &JFactory::getOracleDBO();

        $tableValues = FormFactory::getTableValues($data, array($tableName, $colCount));
        $count = count($tableValues);
        $rowCount = $count / $colCount;

        $inpTablo = "tablo_" . $tableName . "_";
        $tabloId = $tableName . "_";

        $updated = 0;
        for ($i = 1; isset ($data[$tabloId . $i]); $i++) {
            $inpName = $inpTablo . $i;
            $tablo_id = $data[$tabloId . $i];

            if ($tablo_id != -2) { // Hazirlayan Kurulusta ilk kurulus degilse
                if (isset ($data[$inpName])) { // GUNCELLE
                    $id = $updated * $colCount;

                    if (!$this->updateTableElement($layout, $taslak_meslek_id, $tablo_id, $tableValues, $id))
                        return JText::_("VERI_GUNCELLE_HATA");

                    $updated++;
                } else {                   // SIL
                    if (!$this->deleteTableElement($layout, $taslak_meslek_id, $tablo_id))
                        return JText::_("VERI_SIL_HATA");
                }
            } else {
                $updated++;
            }
        }

        // GERISINI EKLE
        for ($j = 0; isset ($data["input" . $tableName . "-1"][($updated + $j)]); $j++) {
            $id = ($updated + $j) * $colCount;
            if (!$this->insertTableElement($layout, $taslak_meslek_id, $tableValues, $id))
                return JText::_("VERI_EKLE_HATA");
        }

        return JText::_("VERI_KAYDI_BASARILI");

    }

    function insertTableElement($layout, $taslak_meslek_id, $tableValues, $id)
    {
        switch ($layout) {
            case "hazirlayan":
                $hazirlayan_adi = $tableValues [$id + 1];
                $kurulus_turu = $tableValues [$id + 2];
                return $this->hazirlayanEkle($taslak_meslek_id, $hazirlayan_adi, $kurulus_turu);
                break;
            case "terim":
                $terim_adi = $tableValues [$id + 1];
                $terim_aciklama = $tableValues [$id + 2];
                return $this->terimEkle($taslak_meslek_id, $terim_adi, $terim_aciklama, $terimId);
                break;
            case "meslek_tanitimi":
                $standart_adi = $tableValues [$id + 1];
                $standart_aciklama = $tableValues [$id + 2];
                return $this->standartEkle($taslak_meslek_id, $standart_adi, $standart_aciklama);
                break;
            case "ekipman":
                $ekipman_adi = $tableValues [$id + 1];
                return $this->ekipmanEkle($taslak_meslek_id, $ekipman_adi);
                break;
            case "bilgi_beceri":
                $bilgi_adi = $tableValues [$id + 1];
                return $this->bilgiBeceriEkle($taslak_meslek_id, $bilgi_adi);
                break;
            case "tutum_davranis":
                $tutum_adi = $tableValues [$id + 1];
                return $this->tutumDavranisEkle($taslak_meslek_id, $tutum_adi);
                break;
        }
    }

    function updateTableElement($layout, $taslak_meslek_id, $tablo_id, $tableValues, $id)
    {
        switch ($layout) {
            case "hazirlayan":


                $hazirlayan_adi = $tableValues [$id + 1];
                $hazirlayan_turu = $tableValues [$id + 2];
                return $this->hazirlayanUpdate($taslak_meslek_id, $tablo_id, $hazirlayan_adi, $hazirlayan_turu);
                break;
//    		case "terim":
//    			$terim_adi		= $tableValues [$id + 1];
//    			$terim_aciklama	= $tableValues [$id + 2];
//   				return $this->terimUpdate ($taslak_meslek_id, $tablo_id, $terim_adi, $terim_aciklama);
//    			break;
            case "meslek_tanitimi":
                $standart_adi = $tableValues [$id + 1];
                $standart_aciklama = $tableValues [$id + 2];
                return $this->standartUpdate($taslak_meslek_id, $tablo_id, $standart_adi, $standart_aciklama);
                break;
            case "ekipman":
                $ekipman_adi = $tableValues [$id + 1];
                return $this->ekipmanUpdate($taslak_meslek_id, $tablo_id, $ekipman_adi);
                break;
            case "bilgi_beceri":
                $bilgi_adi = $tableValues [$id + 1];
                return $this->bilgiBeceriUpdate($taslak_meslek_id, $tablo_id, $bilgi_adi);
                break;
            case "tutum_davranis":
                $tutum_adi = $tableValues [$id + 1];
                return $this->tutumDavranisUpdate($taslak_meslek_id, $tablo_id, $tutum_adi);
                break;
        }
    }

    function deleteTableElement($layout, $taslak_meslek_id, $tablo_id)
    {
        switch ($layout) {
            case "hazirlayan":
                return $this->hazirlayanSil($taslak_meslek_id, $tablo_id);
                break;
            case "terim":
                return $this->terimSil($taslak_meslek_id, $tablo_id);
                break;
            case "meslek_tanitimi":
                return $this->standartSil($taslak_meslek_id, $tablo_id);
                break;
            case "ekipman":
                return $this->ekipmanSil($taslak_meslek_id, $tablo_id);
                break;
            case "bilgi_beceri":
                return $this->bilgiBeceriSil($taslak_meslek_id, $tablo_id);
                break;
            case "tutum_davranis":
                return $this->tutumDavranisSil($taslak_meslek_id, $tablo_id);
                break;
        }
    }

    function hazirlayanEkle($taslak_meslek_id, $hazirlayan_adi, $kurulus_turu)
    {
        $_db = &JFactory::getOracleDBO();

        $hazirlayan_id = $_db->getNextVal(STANDART_HAZIRLAYAN_SEQ);
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_hazirlayan
				(taslak_meslek_id,hazirlayan_id,hazirlayan_kurulus_adi,kurulus_turu) values (?, ?, ?,?)";

        $params = array($taslak_meslek_id,
            $hazirlayan_id,
            $hazirlayan_adi,
            $kurulus_turu
        );
        return $_db->prep_exec_insert($sql, $params);
    }

    function hazirlayanUpdate($taslak_meslek_id, $hazirlayan_id, $hazirlayan_adi, $hazirlayan_turu)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_taslak_meslek_hazirlayan
				SET hazirlayan_kurulus_adi = ? , kurulus_turu = ?
				WHERE taslak_meslek_id = ? AND hazirlayan_id = ? ";

        $params = array($hazirlayan_adi,
            $hazirlayan_turu,
            $taslak_meslek_id,
            $hazirlayan_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function hazirlayanSil($taslak_meslek_id, $hazirlayan_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_hazirlayan
				WHERE taslak_meslek_id = ? AND hazirlayan_id = ?";

        $params = array($taslak_meslek_id,
            $hazirlayan_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function terimEkle($taslak_meslek_id, $terim_adi, $terim_aciklama, $terimIDs)
    {
        $_db = &JFactory::getOracleDBO();
        for ($i = 0; $i < count($terimIDs); $i++) {
            $sql = "DELETE FROM M_STANDART_TASLAK_TERIM 
                    WHERE taslak_meslek_id = ? AND terim_id = ?";

            $params = array($taslak_meslek_id,
                $terimIDs[$i]
            );
            $sql = "INSERT INTO M_STANDART_TASLAK_TERIM
    				values (?, ?)";
            $params = array($terimIDs[$i],
                $taslak_meslek_id
            );

        }

        $terim_id = $_db->getNextVal(TERIM_SEQ);
        $terim_adi = FormFactory::toUpperCase($terim_adi);
        //Prepare sql statement
        $sql = "INSERT INTO M_TERIM
				values (?, ?, ?)";

        $params = array($terim_id,
            $terim_adi,
            $terim_aciklama
        );
        $_db->prep_exec_insert($sql, $params);

        $sql = "INSERT INTO M_STANDART_TASLAK_TERIM
				values (?, ?)";
        $params = array($terim_id,
            $taslak_meslek_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function terimUpdate($taslak_meslek_id, $terim_id, $terim_adi, $terim_aciklama)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE M_TERIM
				SET terim_adi = ?,
					terim_aciklama = ?
				WHERE taslak_meslek_id = ? AND terim_id = ?";

        $params = array($terim_adi,
            $terim_aciklama,
            $taslak_meslek_id,
            $terim_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function terimSil($taslak_meslek_id, $terim_id)
    {

        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM M_STANDART_TASLAK_TERIM
				WHERE taslak_meslek_id = ? AND terim_id = ?";

        $params = array($taslak_meslek_id,
            $terim_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function tanitimKaydet($data, $taslak_meslek_id, $standart_id, $evrak_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_taslak_meslek
				SET meslek_tanim = ?,
					meslek_saglik_duzenleme = ?,
					meslek_mevzuat = ?,
					meslek_calisma_kosul = ?,
					meslek_gereklilik = ?
				WHERE taslak_meslek_id = ?";

        $params = array($data["meslek_tanimi"],
            $data["duzenleme"],
            $data["mevzuat"],
            $data["kosul"],
            $data["gereklilik"],
            $taslak_meslek_id
        );

        $result = $_db->prep_exec_insert($sql, $params);

        return $result;
    }

    function standartEkle($taslak_meslek_id, $standart_adi, $standart_aciklama, $standart_id = null)
    {
        $_db = &JFactory::getOracleDBO();

        if ($standart_id == null) {
            $standart_id = $_db->getNextVal(STANDART_SEQ);
        }
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_standart
				values (?, ?, ?, ?)";

        $params = array($standart_id,
            $taslak_meslek_id,
            $standart_adi,
            $standart_aciklama
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function standartUpdate($taslak_meslek_id, $standart_id, $standart_adi, $standart_aciklama)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_taslak_meslek_standart
				SET standart_adi = ?,
					standart_aciklama = ?
				WHERE taslak_meslek_id = ? AND standart_id = ?";

        $params = array($standart_adi,
            $standart_aciklama,
            $taslak_meslek_id,
            $standart_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function dokunulmamissaOntaslagiKaydet($standart_id)
    {
        $_db = &JFactory::getOracleDBO();

        $sql = "Select meslek_standart_durum_id FROM m_meslek_standartlari WHERE standart_id = ?";
        $params = array($standart_id);
        $result = $_db->prep_exec($sql, $params);

        if ($result[0]["MESLEK_STANDART_DURUM_ID"] == PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK) {
            $sql = "UPDATE m_meslek_standartlari SET meslek_standart_durum_id = ? WHERE standart_id = ?";
            $params = array(PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK, $standart_id);
            return $_db->prep_exec_insert($sql, $params);
        } else
            return FALSE;
    }

    function standartSil($taslak_meslek_id, $standart_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_standart
				WHERE taslak_meslek_id = ? AND standart_id = ?";

        $params = array($taslak_meslek_id,
            $standart_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function profilKaydet($data, $taslak_meslek_id, $standart_id)
    {

        $user = &JFactory::getUser();
        $_db = &JFactory::getOracleDBO();

        $gorev = $data["gorev"];
        $islem = $data["islem"];
        $BO = $data["BO"];
        $dipnotGorev = $data["dipnotGorev"];
        $dipnotIslem = $data["dipnotIslem"];
        $dipnotBO = $data["dipnotBO"];
        $sira = $data["sira"];

// echo "<pre>";
//    	print_r($data);
//    	echo "</pre>";
//        
        $sql = "DELETE FROM m_taslak_meslek_profil
        WHERE taslak_meslek_id=?";
        $params = array($taslak_meslek_id);
        $_db->prep_exec_insert($sql, $params);

        for ($i = 0; $i < count($gorev); $i++) {
            $parent[$i] = $this->profilVerisiEkle($taslak_meslek_id, "-1", $gorev[$i], $dipnotGorev[$i], "", "", "", "", $sira[$i]);

            for ($j = 0; $j < count($islem[$i]); $j++) {
                if ($islem[$i][$j] != "") {
                    $parentislem[$i][$j] = $this->profilVerisiEkle($taslak_meslek_id, $parent[$i], "", "", $islem[$i][$j], $dipnotIslem[$i][$j], "", "", $sira[$i]);
                }
                for ($k = 0; $k < count($BO[$i][$j]); $k++) {

                    if ($BO[$i][$j][$k] != "") {
                        $this->profilVerisiEkle($taslak_meslek_id, $parentislem[$i][$j], "", "", "", "", $BO[$i][$j][$k], $dipnotBO[$i][$j][$k], $sira[$i]);
                    }

                }
            }
        }
        return JText::_("VERI_KAYDI_BASARILI");
//		if ($_db->prep_exec_insert($sql, $params))
//			return $profil_id;
//		else
//			return -1;
//	  

//    	$resultS = $this->profilVerileriSil  ($taslak_meslek_id);
//   	$resultE = $this->profilVerileriEkle ($taslak_meslek_id, $data);
//    	
//    	return ($resultS&&$resultE);
    }

    function profilVerisiEkle($taslak_meslek_id, $parent_id, $gorev, $dipnotGorev, $islem, $dipnotIslem, $BO, $dipnotBO, $sira)
    {
        $_db = &JFactory::getOracleDBO();
//
//		$profil_gorev_adi = $tableValues[0];
//		$profil_islem_adi = $tableValues[1];
//		$profil_basarim	  = $tableValues[2];
//		$profil_dipnot	  = $tableValues[3];
//		
//    	$profil_id = $_db->getNextVal (PROFIL_SEQ);
//		//Prepare sql statement
//		$sql = "INSERT INTO m_taslak_meslek_profil 
//				values (?, ?, ?, ?, ?, ?, ?)";
//
//	
//		$params = array($profil_id,
//						$taslak_meslek_id,
//						$parent_id,
//						$profil_gorev_adi,
//						$profil_islem_adi,
//						$profil_basarim,
//						$profil_dipnot
//						);
//
        $profil_id = $_db->getNextVal(PROFIL_SEQ);
//                    echo $profil_id."-".$parent_id."<br>"; 
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_profil
    				(profil_id,
                    taslak_meslek_id,
                    parent_id,
                    profil_gorev_adi,
                    profil_gorev_dipnot,
                    profil_islem_adi,
                    profil_islem_dipnot,
                    profil_basarim_olcut,
                    profil_basarim_dipnot,
                    sira)
                    values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = array($profil_id,
            $taslak_meslek_id,
            $parent_id,
            $gorev,
            $dipnotGorev,
            $islem,
            $dipnotIslem,
            $BO,
            $dipnotBO,
            $sira
        );
        $_db->prep_exec_insert($sql, $params);
        return $profil_id;
    }

    function profilVerileriEkle($taslak_meslek_id, $data)
    {
        $tableLetters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'Y', 'Z');
        $result = true;

        for ($i = 0; $i < count($tableLetters); $i++) {
            $inp1 = "input_" . $tableLetters[$i];
            if (isset ($data[$inp1])) {
                $gorev_profil_id = $this->profilVerisiEkle($taslak_meslek_id, -1, array($data[$inp1], "", "", ""));
                if ($gorev_profil_id == -1)
                    return false;

                $inp2 = "input_" . $tableLetters[$i] . "_1";
                for ($j = 0; isset ($data[$inp2]); $j++) {
                    $islem_profil_id = $this->profilVerisiEkle($taslak_meslek_id, $gorev_profil_id, array("", $data[$inp2], "", ""));
                    if ($islem_profil_id == -1)
                        return false;

                    $inp3 = "input_" . $tableLetters[$i] . "_" . ($j + 1) . "_1";
                    $inp4 = "input_dipnot_" . $tableLetters[$i] . "_" . ($j + 1) . "_1";
                    for ($k = 0; isset ($data[$inp3]); $k++) {
                        $basarim_profil_id = $this->profilVerisiEkle($taslak_meslek_id, $islem_profil_id, array("", "", $data[$inp3], $data[$inp4]));
                        if ($basarim_profil_id == -1)
                            return false;
                        $inp3 = "input_" . $tableLetters[$i] . "_" . ($j + 1) . "_" . ($k + 2);
                        $inp4 = "input_dipnot_" . $tableLetters[$i] . "_" . ($j + 1) . "_" . ($k + 2);
                    }

                    $inp2 = "input_" . $tableLetters[$i] . "_" . ($j + 2);
                }
            }
        }

        return $result;
    }


    function profilVerileriSil($taslak_meslek_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_profil
				WHERE taslak_meslek_id = ?";

        $params = array($taslak_meslek_id);

        return $_db->prep_exec_insert($sql, $params);
    }

    function hazirlayanKurulusKaydet($data, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId)
    {
        $_db = &JFactory::getOracleDBO();

        $sql = "DELETE FROM m_taslak_meslek_hazirlayan
    	WHERE taslak_meslek_id = ?";

        $params = array($taslak_meslek_id);
        $sonuc = $_db->prep_exec_insert($sql, $params);

        for ($i = 0; $i < count($data["inputhazirlayan-2"]); $i++) {
            $hazirlayan_adi = $data["inputhazirlayan-2"][$i];
            $j = $i + 1;
            $kurulus_turu = $data["inputhazirlayan-3-$j"][0];
            $sonuc = $this->hazirlayanEkle($taslak_meslek_id, $hazirlayan_adi, $kurulus_turu);
        }

        return JText::_("VERI_KAYDI_BASARILI");
    }

    function ekipmanEkle($taslak_meslek_id, $ekipman_adi)
    {
        $_db = &JFactory::getOracleDBO();

        $ekipman_id = $_db->getNextVal(EKIPMAN_SEQ);
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_ekipman
				values (?, ?, ?)";

        $params = array($ekipman_id,
            $taslak_meslek_id,
            $ekipman_adi
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function ekipmanUpdate($taslak_meslek_id, $ekipman_id, $ekipman_adi)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_taslak_meslek_ekipman
				SET ekipman_adi = ? 
				WHERE taslak_meslek_id = ? AND ekipman_id = ?";

        $params = array($ekipman_adi,
            $taslak_meslek_id,
            $ekipman_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function ekipmanSil($taslak_meslek_id, $ekipman_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_ekipman
				WHERE taslak_meslek_id = ? AND ekipman_id = ?";

        $params = array($taslak_meslek_id,
            $ekipman_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function bilgiBeceriEkle($taslak_meslek_id, $bilgi_beceri_adi)
    {
        $_db = &JFactory::getOracleDBO();

        $bilgi_beceri_id = $_db->getNextVal(BILGI_BECERI_SEQ);
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_bilgi_beceri
				values (?, ?, ?)";

        $params = array($bilgi_beceri_id,
            $taslak_meslek_id,
            $bilgi_beceri_adi
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function bilgiBeceriUpdate($taslak_meslek_id, $bilgi_beceri_id, $bilgi_beceri_adi)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_taslak_meslek_bilgi_beceri
				SET bilgi_beceri_adi = ? 
				WHERE taslak_meslek_id = ? AND bilgi_beceri_id = ?";

        $params = array($bilgi_beceri_adi,
            $taslak_meslek_id,
            $bilgi_beceri_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function bilgiBeceriSil($taslak_meslek_id, $bilgi_beceri_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_bilgi_beceri
				WHERE taslak_meslek_id = ? AND bilgi_beceri_id = ?";

        $params = array($taslak_meslek_id,
            $bilgi_beceri_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function tutumDavranisEkle($taslak_meslek_id, $tutum_davranis_adi)
    {
        $_db = &JFactory::getOracleDBO();

        $tutum_davranis_id = $_db->getNextVal(TUTUM_DAVRANIS_SEQ);
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_tutum
				values (?, ?, ?)";

        $params = array($tutum_davranis_id,
            $taslak_meslek_id,
            $tutum_davranis_adi
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function tutumDavranisUpdate($taslak_meslek_id, $tutum_davranis_id, $tutum_davranis_adi)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_taslak_meslek_tutum
				SET tutum_davranis_adi = ? 
				WHERE taslak_meslek_id = ? AND tutum_davranis_id = ?";

        $params = array($tutum_davranis_adi,
            $taslak_meslek_id,
            $tutum_davranis_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function tutumDavranisSil($taslak_meslek_id, $tutum_davranis_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_tutum
				WHERE taslak_meslek_id = ? AND tutum_davranis_id = ?";

        $params = array($taslak_meslek_id,
            $tutum_davranis_id
        );

        return $_db->prep_exec_insert($sql, $params);
    }

    function gorevAlanKaydet($data, $taslak_meslek_id, $colCount, $tableCount)
    {

        $result = $this->gorevAlanlarSil($taslak_meslek_id);

        for ($i = 1; $i < 6; $i++) {
//    	echo count($data["adSoyad"][$i])."<pre>";
            for ($j = 0; $j < count($data["adSoyad"][$i]); $j++) {
                if ($data["adSoyad"][$i][$j] != "" or $data["kurum"][$i][$j] != "") {
                    $result = $this->gorevAlanEkle($taslak_meslek_id, $data["adSoyad"][$i][$j], $data["kurum"][$i][$j], $data["unvan"][$i][$j], $i);
//                     echo $data["adSoyad"][$i][$j]."-";
                }
            }
        }
//    	print_r($_REQUEST);
//    	echo "</pre>";
//        exit;

        return $result;
    }

    function gorevAlanEkle($taslak_meslek_id, $gorevAlan_adi, $gorevAlan_kurulus, $gorev_alan_unvan, $gorev_tur_id)
    {
        $_db = &JFactory::getOracleDBO();

        $gorevAlan_id = $_db->getNextVal(GOREV_ALAN_SEQ);
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek_gorev_alan
				values (?, ?, ?, ?, ?, ?)";

        $params = array($gorevAlan_id,
            $taslak_meslek_id,
            $gorevAlan_adi,
            $gorevAlan_kurulus,
            $gorev_alan_unvan,
            $gorev_tur_id);

        return $_db->prep_exec_insert($sql, $params);
    }

    function gorevAlanlarSil($taslak_meslek_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "DELETE FROM m_taslak_meslek_gorev_alan
				WHERE taslak_meslek_id = ? ";

        $params = array($taslak_meslek_id);

        return $_db->prep_exec_insert($sql, $params);
    }

    function updateEvrakTur($evrak_id, $tur_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE " . DB_PREFIX . ".evrak
				SET basvuru_sekli_id = ? 
				WHERE evrak_id = ?";

        $params = array($tur_id, $evrak_id);
        return $_db->prep_exec_insert($sql, $params);
    }


    function updateBasvuruDurum($evrak_id, $durum_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_basvuru
				SET basvuru_durum_id = ? 
				WHERE evrak_id = ?";

        $params = array($durum_id, $evrak_id);
        return $_db->prep_exec_insert($sql, $params);
    }

    function updateStandartSurecDurum($standart_id, $durum_id)
    {
        $_db = &JFactory::getOracleDBO();

        //Prepare sql statement
        $sql = "UPDATE m_meslek_standartlari
				SET MESLEK_STANDART_SUREC_DURUM_ID = ? 
				WHERE standart_id = ?";

        $params = array($durum_id, $standart_id);
        return $_db->prep_exec_insert($sql, $params);
    }

    function updateYorumDurum_SS($evrak_id, $yorum_durum)
    {
        $db = &JFactory::getDBO();
        $sql = "UPDATE #__taslak_yorum
				SET yorum_durum = " . $yorum_durum . "
				WHERE 	evrak_id = " . $evrak_id . "
						AND  ss_yorumu_mu = 1";

        return $db->Execute($sql);
    }

    function updateEditable($standart_id, $editable)
    {
        $_db =& JFactory::getOracleDBO();

        $sql = "UPDATE m_taslak_meslek
				SET editable = ? 
				WHERE standart_id = ?";

        $params = array($editable, $standart_id);

        return $_db->prep_exec_insert($sql, $params);
    }

    function basvuruOlustur()
    {
        $_db =& JFactory::getOracleDBO();

        $user = &JFactory::getUser();
        $user_id = $user->getOracleUserId();
        $sayi_id = YT1_SAYI_ID;
        $basvuru_tip = YT1_BASVURU_TIP;
        $basvuru_durum = KAYDEDILMEMIS_BASVURU;

        $evrak_id = $_db->getNextVal(EVRAK_SEQ);//FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_TASLAK_ADAYI_SEKLI_ID);
        if ($evrak_id != -1)
            FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);

        return $evrak_id;
    }

    function taslakMeslekOlustur($evrak_id, $standart_id)
    {
        $_db =& JFactory::getOracleDBO();

        $taslak_meslek_id = $_db->getNextVal(TASLAK_MESLEK_SEQ);
        //Prepare sql statement
        $sql = "INSERT INTO m_taslak_meslek
				(taslak_meslek_id, evrak_id, standart_id, editable) 
				 values( ?, ?, ? , 1)";

        $params = array($taslak_meslek_id,
            $evrak_id,
            $standart_id
        );

        if ($_db->prep_exec_insert($sql, $params))
            return $taslak_meslek_id;
        else
            return -1;
    }

    function getTaslakMeslekId($evrak_id)
    {
        $_db = &JFactory::getOracleDBO();

        $sql = "SELECT taslak_meslek_id
			   FROM m_taslak_meslek 
			   WHERE evrak_id = ?";

        $params = array($evrak_id);

        $data = $_db->prep_exec_array($sql, $params);


        if (!empty($data))
            return $data[0];
        else
            return null;
    }

    function insertSavedPage($pageNum, $evrak_id, $juser_id, $basvuru_tur, $form_id)
    {
        $db = &JFactory::getDBO();

        $sql = "	REPLACE INTO #__user_evrak (user_id, evrak_id,basvuru_tur, saved_page, form_id)
				VALUES (" . $juser_id . ", " . $evrak_id . "," . $basvuru_tur . ", " . $pageNum . ", " . $form_id . ")";

        return $db->Execute($sql);
    }

    function clearSavedPages($evrak_id)
    {
        $db = &JFactory::getDBO();

        $sql = "	DELETE FROM #__user_evrak
				WHERE evrak_id = " . $evrak_id;

        return $db->Execute($sql);
    }

    function clearSavedYorum_SS($evrak_id)
    {
        $db = &JFactory::getDBO();

        $sql = "	DELETE FROM #__taslak_yorum
				WHERE evrak_id = " . $evrak_id . " AND  ss_yorumu_mu = 1 ";

        return $db->Execute($sql);
    }

    function clearPreviousYorum_SS($evrak_id)
    {
        $db = &JFactory::getDBO();
        $sayfalar = $this->getGonderilmemisYorumSayfa_SS($evrak_id);

        if (count($sayfalar) > 0) {
            $sql = "	DELETE FROM #__taslak_yorum
					WHERE evrak_id = " . $evrak_id . " AND
						  yorum_durum = 0 AND  ss_yorumu_mu = 1 ";

            for ($i = 0; $i < count($sayfalar); $i++) {
                $sql .= " AND sayfa = " . $sayfalar[$i];
            }
        }

        return $db->Execute($sql);
    }

    function getGonderilmemisYorumSayfa_SS($evrak_id)
    {
        $db = &JFactory::getDBO();

        $sql = "	SELECT sayfa
				FROM #__taslak_yorum 
				WHERE yorum_durum = -1 AND  ss_yorumu_mu = 1 AND evrak_id = " . $evrak_id;

        $db->setQuery($sql);
        $data = $db->loadRow();

        return $data;
    }

    function getSayfa($layout)
    {
        $pages = array("hazirlayan", "terim", "meslek_tanitimi", "meslek_profil", "ekipman", "bilgi_beceri", "tutum_davranis", "gorev_alanlar");
        for ($i = 0; $i < count($pages); $i++) {
            if ($pages[$i] == $layout)
                break;
        }

        return $i + 1;
    }

    function arrangeDataForRadioButtons($data, $tableName)
    {

        $inputCount = 1;//1 tanesini zaten kaydetmiş sayılıyoruz
        $numberCounter = 2;//Baştakini kaydetmeye gerek yok o zaten 1 olmalı
        while ($inputCount != count($data["input" . $tableName . "-1"])) {
            if (isset($data["input" . $tableName . "-3-" . $numberCounter])) {
                $data["input" . $tableName . "-3"][$inputCount] = $data["input" . $tableName . "-3-" . $numberCounter][0];

                $inputCount++;
            }
            $numberCounter++;
        }

// 		echo "*****************<br>*****************<br><pre>";
// 		print_r($data["input".$tableName."-1"]);
// 		echo "</pre>+++++++++++++++++++++<br>";


        return $data;
    }

    function taslakKaydetYeni($post, $evrak_id)
    {
    	$error['ERROR_STATUS'] = false;
    	$error['ERROR_MESSAGE'] = "";
        $_db = &JFactory::getOracleDBO();
        $section = $_GET['section'];
        $standart_id = $post['standart_id'];
        $user = &JFactory::getUser();
        $isSektorSorumlusu = FormFactory::sektorSorumlusuMu($user);

        if ($evrak_id == -1) {
            $evrak_id = $this->basvuruOlustur();
            $taslakResult = $this->taslakMeslekOlustur($evrak_id, $standart_id);

            if (!$taslakResult)
                $evrak_id = -2;
        }

        if ($evrak_id != -1 && $evrak_id != null) {
            if (!$isSektorSorumlusu) {
                $sql = "UPDATE M_MESLEK_STANDARTLARI SET CALISMA_BASLAMA_DURUM = ? WHERE STANDART_ID = ?";
                $_db->prep_exec_insert($sql, array('1', $standart_id));
                if ($post['revizyon_durum'] == '-4') {
                    $this->updateStandartSurecDurum($standart_id, -6);
                }

            }
            switch ($section) {
                case 'section1':
                    if ($isSektorSorumlusu) {
                        $addedline = "";
                        $params = array($post['yayinTarihi'],
                            $post['onayTarihi'],
                            $post['onaySayisi'],
                            $post['referans_kodu'],
                            $post['tehlikeli_is_durum'],
                            $post['revizyon_durum'],
                            $standart_id);
                        if ($post['revizyon_durum'] == '14') {
                            $sql = 'SELECT SON_TASLAK_PDF FROM M_TASLAK_MESLEK WHERE STANDART_ID = ?';
                            $data = $_db->prep_exec($sql, array($standart_id));
                            if ($data[0]['SON_TASLAK_PDF'] == "") {
                                $error['ERROR_STATUS'] = true;
                                $error['ERROR_MESSAGE'] = "Döküman versiyonu girmeden ulusal meslek standardı haline getiremezsiniz.";
                                return $error;
                            } else {
                                $error['ERROR_STATUS'] = false;
                                $error['ERROR_MESSAGE'] = "";
                                $addedline = "MESLEK_STANDART_DURUM_ID = ?,";
                                $post['standart_durum'] = 2;
                                $params = array($post['yayinTarihi'],
                                    $post['onayTarihi'],
                                    $post['onaySayisi'],
                                    $post['referans_kodu'],
                                    $post['tehlikeli_is_durum'],
                                    $post['standart_durum'],
                                    $post['revizyon_durum'],
                                    $standart_id);
                            }

                        }
                        $sql = "UPDATE m_meslek_standartlari
								SET YAYIN_TARIHI = to_date (?, 'dd/mm/yyyy'),
									KARAR_TARIHI = to_date (?, 'dd/mm/yyyy'),
									KARAR_SAYI = ?,
									STANDART_KODU = ?,
								    TEHLIKELI_IS_DURUM=?," .
                            $addedline .
                            "MESLEK_STANDART_SUREC_DURUM_ID = ?
						   WHERE standart_id = ?";


                        $_db->prep_exec_insert($sql, $params);
                    }
                    if (isset($post['revizyon_durum']) && $post['revizyon_durum'] <> "") {
                        if ($post['revizyon_durum'] == "1") {
                            $standartDurumId = "2";
                        } else if ($post['revizyon_durum'] == "-4") {
                            $standartDurumId = "-2";
                        } else if ($post['revizyon_durum'] == "-6") {
                            $standartDurumId = "-2";
                        } else if ($post['revizyon_durum'] == "6") {
                            $standartDurumId = "-2";
                        } else if ($post['revizyon_durum'] == "14") {
                            $standartDurumId = "2";
                        } else {
                            $standartDurumId = "1";
                        }
                        if ($post['revizyon_durum'] != "3") {
                            $sql = "UPDATE m_meslek_standartlari SET MESLEK_STANDART_DURUM_ID = ? WHERE STANDART_ID = ?";
                            $parameter = array($standartDurumId,
                                $standart_id);
                            $_db->prep_exec_insert($sql, $parameter);
                        }

                    }

                    $sql = "UPDATE m_taslak_meslek
								SET GORUSE_CIKMA_TARIHI = to_date (?, 'dd/mm/yyyy')
								WHERE standart_id = ?";

                    $params = array($post ["goruse_cikma_tarihi"],
                        $standart_id);

                    $_db->prep_exec_insert($sql, $params);

                    $taslak = $_db->prep_exec("SELECT TASLAK_MESLEK_ID FROM M_TASLAK_MESLEK WHERE STANDART_ID = ?", array($standart_id));
                    $taslak_meslek_id = $taslak[0]['TASLAK_MESLEK_ID'];

                    $standart['inputstandart-2'] = $post['inputstandart-2'];
                    $standart['inputstandart-3'] = $post['inputstandart-3'];
                    for ($i = 0; $i < count($standart['inputstandart-2']); $i++) {
                        $this->standartEkle($taslak_meslek_id, $standart['inputstandart-2'][$i], $standart['inputstandart-3'][$i], $standart_id);
                    }

                    $sayfaNum = 1;
                    $colCount = 3;
                    $tableName = "hazirlayan";
                    $dbTableName = "m_taslak_meslek_hazirlayan";
                    $dbTableId = "hazirlayan_id";

                    $result = $this->hazirlayanKurulusKaydet($post, $layout, $colCount, $tableName, $taslak_meslek_id, $standart_id, $evrak_id, $dbTableName, $dbTableId);

                    return $error;
                    break;

                case 'section5':
                    $sql = "UPDATE m_taslak_meslek
						      SET RESMI_GORUS_ONCESI_PDF = ?,
							      SEKTOR_KOMITESI_ONCESI_PDF = ?,
							      YONETIM_KURULU_ONCESI_PDF = ?,
							      SON_TASLAK_PDF = ?
				            WHERE standart_id = ?";

                    $params = array(
                        $post ["path_taslakPdf_0_1"],
                        $post ["path_taslakPdf_0_2"],
                        $post ["path_taslakPdf_0_3"],
                        $post ["path_taslakPdf_0_4"],
                        $standart_id);
                    $_db->prep_exec_insert($sql, $params);
                    // 				   $this->readDocument($path);
                    break;
                default:
                    ;
                    break;
            }
        }
        return $error;
    }

    function basvuruKurulusaGonder($evrak_id, $standart_id)
    {
        $this->updateEvrakTur($evrak_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
        $this->updateStandartDurum($standart_id, PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMEMIS_ONTASLAK);
        $this->updateStandartSurecDurum($standart_id, PM_MESLEK_STANDART_SUREC_DURUMU__KURULUSTAN_DUZELTME_ISTENDI);
    }
}

?>
