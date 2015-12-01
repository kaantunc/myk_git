<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the rate Component
 */
class Belgelendirme_BasvurViewBelgelendirme_Basvur extends JView
{
    function display($tpl = null)
    {
        global $mainframe;
        $user = &JFactory::getUser();
        $model = &$this->getModel();
        $layout = JRequest::getVar("layout");
        $user_id = $user->getOracleUserId();
        $group_id = T3_GROUP_ID;
        $group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
        $group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
        $message = YETKI_MESAJ;
        $aut = FormFactory2::checkAuthorization($user, $group_id);
        $aut2 = FormFactory2::checkAuthorization($user, $group_id2);
        $aut3 = FormFactory2::checkAuthorization($user, $group_id3);

        if (!$aut and !$aut2 and !$aut3)
            $mainframe->redirect('index.php?', $message);

        $canEdit = false;
        if ($aut2 || $aut3) {
            $canEdit = true;
        }
        $this->assignRef('canEdit', $canEdit);

        if (!isset ($layout)) {
            $layout = "giris";
            $this->setLayout($layout);
        }

        $pdf = 0;
        if ($layout == "tum_basvuru")
            $pdf = 1;

        $pages = $model->pages;
        $pageNames = $model->pageNames;
        $title = $model->title;
        $evrak_id = $_GET['evrak_id'];
        if (!isset($evrak_id)) {
            $evrak_id = -1;
            //$layout = "kurulus_bilgi";
            //$this->setLayout($layout);
        }


        //$evrak_id	= FormFactory2::getCurrentEvrakId ($_POST, T3_BASVURU_TIP, $user);

        $basvuru = FormFactory2::getBasvuruValues($evrak_id);

        if ($aut == false)//yani sektör sorumlusu girdiği için ulaşılamamış
            $user_id = $basvuru['USER_ID'];


// 		$kurulus 	= FormFactory2::getKurulusValues($user_id);
// 		if(!isset($kurulus))
// 			$kurulus = 	FormFactory2::getKurulusValuesEvrak($evrak_id);

        $kurulus = $model->getKurulus($evrak_id);

        $iller = FormFactory2::getKurulusIlValues($user_id, $pdf);
        if (!isset($iller[0]))
            $iller = FormFactory2::getKurulusIlValuesEvrak($evrak_id, $pdf);
        $irtibat = FormFactory2::getIrtibatValues($evrak_id);
        $sektor = FormFactory2::getSektorValues($evrak_id);
        $faaliyet = FormFactory2::getFaaliyetValues($evrak_id);
        $bagliKurulus = FormFactory2::getBagliKurulusValues($evrak_id);
        $birlikteKurulus = FormFactory2::getBirlikteKurulusValues($evrak_id);
        $yetkiTalep = $model->getYetkiTalepValues($evrak_id);
        $sinavMerkez = $model->getSinavMerkezValues($evrak_id);
        $akreditasyon = $model->getAkreditasyonValues($evrak_id);
        $personel = FormFactory2::getPersonelValues($evrak_id);
        $egitim = FormFactory2::getEgitimValues($evrak_id);
        $sertifika = FormFactory2::getSertifikaValues($evrak_id);
        $isDeneyim = FormFactory2::getIsDeneyimValues($evrak_id);
        $dil = FormFactory2::getDilValues($evrak_id);
        //$ekler		= FormFactory2::getBasvuruEkValues ($evrak_id);
        $belgebasvurular = $model->getBelgelendirmeBasvurular($user_id);
        if (!isset($belgebasvurular[0]) and $evrak_id != -1)
            $belgebasvurular = $model->getBelgelendirmeBasvurularEvrak($evrak_id);
        $basvuru_ekleri = $model->getBasvuruEkleri($evrak_id);
        $basvuru_docs = $model->getBasvuruDocs($evrak_id);
        $basvuru_ekleri_tur = $model->getBasvuruEkleriBelgeTuru($evrak_id);
        $kayitli_yeterlilikler = $model->getKayitliYeterlilikler($evrak_id);
        $degerlendiriciler = $model->getDegelendiriciler($evrak_id);
        $basvuruDurum = $model->getBasvuruDurum($evrak_id);
        $this->assignRef('durum', $basvuruDurum);


        $pageTree = FormFactory2::getPageTree($user, $layout, $evrak_id, $pages, $pageNames, $user_id, $basvuruDurum);
        //Parametrik Data
        $pm_il = FormParametrik::getIl();
        $pm_kurulus_statu = FormParametrik::getKurulusStatu();
        $pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi();
        $pm_sektor = FormParametrik::getSektor();
        $pm_seviye = FormParametrik::getSeviye();
        /*if ($aut && ($basvuruDurum==2 or $basvuruDurum==6 or $basvuruDurum==14)) {
            $pm_yeterlilik_ad = $model->getYeterlilikAdYeniBasvurularIcin();
        } else {
            $pm_yeterlilik_ad = $model->getYeterlilikAd();
        }*/
        $pm_yeterlilik_ad = $model->getYeterlilikAdYeniBasvurularIcin();
        $pm_yeterlilik = FormParametrik::getYeterlilik();
        $pm_sinav_sekli = FormParametrik::getSinavSekli();

        $basvuru_ekleriPDF = $model->getBasvuruEkleriPDF($evrak_id);

        $this->assignRef('basvuru_ekleriPDF', $basvuru_ekleriPDF);

        $this->assignRef('title', $title);
        $this->assignRef('evrak_id', $evrak_id);
        $this->assignRef('pageTree', $pageTree);
        $this->assignRef('basvuru', $basvuru);
        $this->assignRef('user_id', $user_id);

        //giris
        $this->assignRef('belgebasvurular', $belgebasvurular);

        //1. Kurulus Bilgi
        $this->assignRef('kurulus', $kurulus);
        $this->assignRef('iller', $iller);

        //2. Irtibat
        $this->assignRef('irtibat', $irtibat);

        //3. Faaliyet
        $this->assignRef('sektor', $sektor);
        $this->assignRef('faaliyet', $faaliyet);
        $this->assignRef('bagliKurulus', $bagliKurulus);
        $this->assignRef('birlikteKurulus', $birlikteKurulus);
        $this->assignRef('yetkiTalep', $yetkiTalep);

        //4. Akreditasyon
        $this->assignRef('akreditasyon', $akreditasyon);

        //5. Kapsam
        $this->assignRef('sinavMerkez', $sinavMerkez);

        //6. Kişi Bilgi Eki
        $this->assignRef('personel', $personel);
        $this->assignRef('egitim', $egitim);
        $this->assignRef('sertifika', $sertifika);
        $this->assignRef('isDeneyim', $isDeneyim);
        $this->assignRef('dil', $dil);

        //7. Ekler
        $this->assignRef('ekler', $ekler);
        $this->assignRef('basvuru_ekleri', $basvuru_ekleri);
        $this->assignRef('basvuru_docs', $basvuru_docs);
        $this->assignRef('turler', $basvuru_ekleri_tur);
        $this->assignRef('degerlen', $degerlendiriciler);

        //Parametrik Data
        $this->assignRef('pm_il', $pm_il);
        $this->assignRef('pm_kurulus_statu', $pm_kurulus_statu);
        $this->assignRef('pm_faaliyet_sure', $pm_faaliyet_sure);
        $this->assignRef('pm_sektor', $pm_sektor);
        $this->assignRef('pm_seviye', $pm_seviye);
        $this->assignRef('pm_yeterlilik_ad', $pm_yeterlilik_ad);
        $this->assignRef('pm_yeterlilik', $pm_yeterlilik);
        $this->assignRef('pm_sinav_sekli', $pm_sinav_sekli);
        $this->assignRef('pm_kayitli_yet', $kayitli_yeterlilikler);

        parent::display($tpl);
    }
}

?>
