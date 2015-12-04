<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class ProfileViewProfile extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$session	 = &JFactory::getSession();
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$redirect = "index.php?option=com_profile&view=profile";
		
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$pages			= $model->pages;
		$pageNames		= $model->pageNames;
		$title 			= $model->title;
		
		$bekleyen = true;
		$canEdit = true;
		
		if($aut2 || $aut3){
			$kurulusId = $_GET['kurulus'];
			$session->set('kurulusId', $_GET['kurulus']);
		}else{
			$kurulusId = $user_id;
			$session->set('kurulusId', $kurulusId);
			$canEdit = false;
		}
		
		$this->assignRef('canEdit', $canEdit);
		
		if($kurulusId>0){
			//$kurulusId = $_GET['kurulus'];
			
			$kurulusBilgi = $model->getKurulusBilgi($kurulusId);
			$kurulus_bilgi 		= FormFactory::getKurulusValues($kurulusId);
			$kurulus_edit = $model->KurulusEditBilgi($kurulusId);
			$kurulus_bekleyen = $model->KurulusBekleyenBilgi($kurulusId);
			$iller 	 	   		= FormFactory::getKurulusIlValues($kurulusId);
				
			if(in_array($kurulusBilgi['KURULUS_DURUM_ID'],MESLEK_STD_KURULUS_DURUM_IDS)){
				$kurulus_tur = "ms_kurulusu"; 
			}else if(in_array($kurulusBilgi['KURULUS_DURUM_ID'],YETERLILIK_KURULUS_DURUM_IDS)){
				$kurulus_tur = "yeterlilik_kurulusu"; 
			}else if(in_array($kurulusBilgi['KURULUS_DURUM_ID'],SINAV_BELGELENDIRME_KURULUS_DURUM_IDS)){
				$kurulus_tur = "belgelendirme_kurulusu"; 
			}

			$type = $model->getKurulusTypeWithIds();
			$kurulus_tur = array();
			if(in_array($kurulusBilgi[0]['KURULUS_DURUM_ID'],$type['MESLEK_STD_KURULUS_DURUM_IDS'])){
				array_push($kurulus_tur,"ms_kurulusu");
			}
			if(in_array($kurulusBilgi[0]['KURULUS_DURUM_ID'],$type['YETERLILIK_KURULUS_DURUM_IDS'])){
				array_push($kurulus_tur,"yeterlilik_kurulusu");
			}
			if(in_array($kurulusBilgi[0]['KURULUS_DURUM_ID'],$type['SINAV_BELGELENDIRME_KURULUS_DURUM_IDS'])){
				array_push($kurulus_tur,"belgelendirme_kurulusu");				
			}

			if($kurulus_edit){
				$kurulus_bilgi = $kurulus_edit;
			}
			
			if(!$kurulus_bekleyen){
				$kurulus_bekleyen = $kurulus_bilgi;
				$bekleyen = false;
			}
			$this->assignRef('bekleyen', $bekleyen);
			
			if(isset($kurulus_bekleyen['EDIT_ID'])){
				$editIller = $model->getKurulusIlEdit($kurulus_bekleyen['EDIT_ID']);
			}else{
				$editIller = FormFactory::getKurulusIlValues($kurulusId);
			}
			
			if($kurulus_edit){
				$iller = $model->getKurulusIlEdit($kurulus_bilgi['EDIT_ID']);
			}
			
// 			$meslek				= $model->getMeslekValues($kurulusId);
// 			$yeterlilik			= $model->getYeterlilikValues ($kurulusId);
			$ms_liste_durum 	= FormFactory::getListeDurum ($kurulusId, MS_SEKTOR_TIPI);
			$yet_liste_durum	= FormFactory::getListeDurum ($kurulusId, YET_SEKTOR_TIPI);
			$pm_il				= FormParametrik::getIl();
			$pm_kurulus_statu 	= FormParametrik::getKurulusStatu();
			$pm_seviye 			= FormParametrik::getSeviye ();
			$pm_sektor 			= FormParametrik::getSektor ();
			$pm_meslek_std		= FormParametrik::getMeslekStandart ();
			
			$this->assignRef('pageTree'		, $pageTree);
			$this->assignRef('kurulus_edit', $kurulus_edit);
			$this->assignRef('kurulus_bilgi', $kurulus_bilgi);
			$this->assignRef('kurulus_bekleyen', $kurulus_bekleyen);
			
			$this->assignRef('iller'  	    , $iller);
			$this->assignRef('editIller', $editIller);
// 			$this->assignRef('meslek'	    , $meslek);
// 			$this->assignRef('yeterlilik'   , $yeterlilik);
			$this->assignRef('ms_liste_durum' , $ms_liste_durum);
			$this->assignRef('yet_liste_durum', $yet_liste_durum);
			$this->assignRef('pm_il'		, $pm_il);
			$this->assignRef('pm_kurulus_statu'	, $pm_kurulus_statu);
			$this->assignRef('pm_seviye'	, $pm_seviye);
			$this->assignRef('pm_sektor'	, $pm_sektor);
			$this->assignRef('pm_meslek_standart', $pm_meslek_std);
		}
		else{
			$kurulusId = -1;
		}
		
		
		if ((!isset ($layout) || $layout == "giris") && $kurulusId == -1){
			$layout = "giris";
			$this->setLayout($layout);
		}else if(!$aut2 && !$aut3 && !isset($layout)){
			$layout = "ozet";
			$this->setLayout($layout);
		}
		
		if($aut2 && !$aut3){
			//MS sorumlusu için gösterilecek menüler
			$sayfalar=array("ozet"=>"Özet","kurulus_bilgi"=>"İletişim Bilgisi","basvurular"=>"Başvurular","irtibat" => "İrtibat Bilgileri");
		}
		else if($aut3){
		
			if(in_array('belgelendirme_kurulusu',$kurulus_tur)){
			//Sınav ve Belgelendirme  Sorumlusuna gösterilecek menüler
				$sayfalar=array("ozet"=>"Özet","kurulus_bilgi"=>"İletişim Bilgisi","basvurular"=>"Başvurular",
						"ekler"=>"Dökümanlar","yetki_yeterlilik"=>"Yeterlilikler","sinavlar"=>"Sınavlar",
						"degerlendirici"=>"Değerlendiriciler","sinav_merkez"=>"Sınav Merkezi",
						"denetim"=>"Denetimler","notlar"=>"Notlar","irtibat" => "İrtibat Bilgileri",
						"tarife"=>"Güncel Ücret Tarifeleri", "ucret_tarife_edit"=>"Ücret Tarifesi Dönemleri",
						"abdonem"=>"AB Protokol"
				);
			}else{
				$sayfalar=array("ozet"=>"Özet","kurulus_bilgi"=>"İletişim Bilgisi","basvurular"=>"Başvurular","irtibat" => "İrtibat Bilgileri");
			}
		}
		else{
			$datas = $model->getAllKurulus(MESLEK_STD_KURULUS_DURUM_IDS.','.YETERLILIK_KURULUS_DURUM_IDS);
			$control = true;
			foreach ($datas as $data){
				if($data['USER_ID'] == $user_id){
					$control = true;
					$datas2 =$model->getAllKurulus(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
					foreach ($datas2 as $data2){
						if($data2['USER_ID'] == $user_id){
							$control =false;
						}
					}
				}
			}
			
			$yetYetMi = false;
			$datas2 =$model->getAllKurulus(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
			foreach ($datas2 as $data2){
				if($data2['USER_ID'] == $user_id){
					$yetYetMi = true;
				}
			}
			
			if($control && !$yetYetMi){
				$sayfalar=array("ozet"=>"Özet","kurulus_bilgi"=>"İletişim Bilgisi","basvurular"=>"Başvurular","irtibat" => "İrtibat Bilgileri");
			}else{
				$sayfalar=array("ozet"=>"Özet","kurulus_bilgi"=>"İletişim Bilgisi","basvurular"=>"Başvurular",
						"ekler"=>"Dökümanlar","yetki_yeterlilik"=>"Yeterlilikler","sinavlar"=>"Sınavlar",
						"degerlendirici"=>"Değerlendiriciler","sinav_merkez"=>"Sınav Merkezi",
						"denetim"=>"Denetimler","irtibat" => "İrtibat Bilgileri","tarife"=>"Güncel Ücret Tarifeleri"
				);
			}
		}
		
		$sayfaLink='<div class="anaDiv">';
		foreach ($sayfalar as $key=>$value){
			$stil='class="btn';
			if($key == "denetim"){
				$stil.=' btn-xs btn-primary"';
				if($canEdit){
					$sayfaLink .='<div class="divYan"><a target="_blank" href="index.php?option=com_denetim&layout=denetim_listele&kid='.$kurulusId.'" '.$stil.'>'.$value.'</a></div>';
				}else{
					$sayfaLink .='<div class="divYan"><a target="_blank" href="index.php?option=com_denetim&layout=denetimlerim" '.$stil.'>'.$value.'</a></div>';
				}
			}else{
				if ($key==$layout) {
					$stil.=' btn-success';
				} else {
					$stil.=' btn-xs btn-primary';
				}
				$stil.='"';
				$sayfaLink .='<div class="divYan"><a href="'.$redirect.'&layout='.$key.'&kurulus='.$kurulusId.'" '.$stil.'>'.$value.'</a></div>';
			}
		}
		$sayfaLink.='</div>';
		$this->assignRef('sayfaLink', $sayfaLink);
		
		$glink = "window.location.href='index.php?option=com_profile'";
		$geriLink = '<input type="button" onclick="'.$glink.'" value="Geri" style="margin-top:10px;"/>';
		$this->assignRef('geriLink', $geriLink);
		
		if($layout == "basvurular"){
			
			$basvuruTip = FormFactory::BasvuruTipleri();
			$this->assignRef('basvuruTip', $basvuruTip);
			
			$basvurular = $model->BasvuruGetir($kurulusId);
			$this->assignRef('basvurular', $basvurular);
			
		}
		else if($layout == "ozet"){
			$DSorumlu = $model->dosyaSorumlusu($kurulusId);
			$this->assignRef('DSorumlu', $DSorumlu);
			
			if($aut3){
				$yetkiliYet = $model->getYetkiliYeterlilik($kurulusId);
				$this->assignRef('yetkiliYet', $yetkiliYet);
				
				$belprogram = $model->getSinavYerleri($kurulusId);
				$this->assignRef('programs', $belprogram);
	
// 				$sinavGirBas = $model->getKurulusSinavGirenAndBasarili($kurulusId);
// 				$this->assignRef('sinavGirBas', $sinavGirBas);
				
				$deger = $model->getDegerlendirici($kurulusId);
				$this->assignRef('deger', $deger);
				
				$belgeler = $model->getYetBelge($kurulusId);
				$this->assignRef('belgeler', $belgeler);
			}
		}
		else if($layout == "ekler"){
			$eks = $model->getEks($kurulusId);
			$this->assignRef('eks', $eks);
			
			$basvuruEk = $model->BasvuruEks($kurulusId);
			$this->assignRef('basvuruEk', $basvuruEk);
		}
		else if($layout == "yetki_yeterlilik"){
			$yetkiliYet = $model->getYetkiliYeterlilik($kurulusId);
			$this->assignRef('yetkiliYet', $yetkiliYet);
		}
		else if($layout == "degerlendirici"){
			$deger = $model->getDegerlendirici($kurulusId);
			$this->assignRef('deger', $deger);
		}
		else if($layout == 'sinav_merkez'){
			$belprogram = $model->getProgramSinavYeri($kurulusId);
			$this->assignRef('programs', $belprogram);
		}
		else if($layout == "sinavlar"){
			$sinavTipi = array_key_exists('sinavTipi',$_GET)?$_GET['sinavTipi']:1;
			
			$sinavTipleri=array(1=>"Yapılmış Sınavlar",2=>"Yapılacak Sınavlar", 3=>"Yapılmayan Sınavlar");
			
			$tipLink='<div class="anaDiv text-center">';
			foreach ($sinavTipleri as $key=>$value){
				$stil='class="btn ';
				if ($key==$sinavTipi) {
					$stil.='btn-success';
				} else {
					$stil.='btn-xs btn-default';
				}
				$stil.='"';
				$tipLink .='<div class="divYan"><a href="'.$redirect.'&layout=sinavlar&kurulus='.$kurulusId.'&sinavTipi='.$key.'" '.$stil.'>'.$value.'</a></div>';
			}
			$tipLink.='</div>';
			$this->assignRef('tipLink', $tipLink);
			
			if($sinavTipi == 1){//gelecek sinav
				$sinavlar = $model->SinavSearch($kurulusId,$sinavTipi);
				$this->assignRef('sinavlar', $sinavlar);
				$this->assignRef('sinavTipi', $sinavTipi);
			}
			else if($sinavTipi == 2){//yapılmış sınav
				$sinavlar = $model->SinavSearch($kurulusId,$sinavTipi);
				$this->assignRef('sinavlar', $sinavlar);
				$this->assignRef('sinavTipi', $sinavTipi);
			}
			else if($sinavTipi == 3){//yapılmayan sınavlar
				$sinavlar = $model->SinavSearch($kurulusId,$sinavTipi);
				$this->assignRef('sinavlar', $sinavlar);
				$this->assignRef('sinavTipi', $sinavTipi);
			}
			else{
				$mainframe->redirect($redirect,'Bu sayfayı görme yetkiniz yoktur.');
			}
		}
		else if($layout == "belgeler"){
			$belgeler = $model->getYetBelge($kurulusId);
			$this->assignRef('belgeler', $belgeler);
		}
		else if($layout == "notlar"){
// 			$notlar = $model->NotGetir($user_id);
			$notlar = $model->NotGetir($kurulusId);
			$this->assignRef('notlar', $notlar);
		}
		else if($layout == "giris"){
			// Tüm Kuruluşlar
			$allKurulus = $model->getAllKurulus(TUM_KURULUS_DURUM_IDS);
			$this->assign('AllKurulus',$allKurulus);
			// MS Kuruluşları
			$allMSKurulus = $model->getAllKurulus(MESLEK_STD_KURULUS_DURUM_IDS);
			$this->assign('AllMSKurulus',$allMSKurulus);
			// Yeterlilik Hazırlama Kuruluşları
			$allYETKurulus = $model->getAllKurulus(YETERLILIK_KURULUS_DURUM_IDS);
			$this->assign('AllYETKurulus',$allYETKurulus);
			// Sinav ve Belgelendirme Kurulusu
			$allSBKurulus = $model->getAllKurulus(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
			$this->assign('AllSBKurulus',$allSBKurulus);
			// Akreditasyon Kuruluşu
			$allAKKurulus = $model->getAllKurulus(AKREDITASYON_KURULUS_DURUM_IDS);
			$this->assign('AllAKKurulus',$allAKKurulus);
		}
		else if($layout == "tarife"){
			$OnayliTarifeler = $model->getOnayliUcretTarifeleri($kurulusId);
			$this->assignRef('OnayliUcretYets', $OnayliTarifeler);
			
			$OnayBekleyenTarifeler = $model->getOnayBekleyenUcretTarifeleri($kurulusId);
			$this->assignRef('OnayBekleyenTarifeler', $OnayBekleyenTarifeler);
			
			$yetkiYets = $model->getYetYetki($kurulusId);
			$this->assignRef('yetkiYets', $yetkiYets);
			 
			$yetkiBirims = $model->getYetkiBirim($kurulusId,$yetkiYets);
			$this->assignRef('yetkiBirims', $yetkiBirims);
			
			$detay = $model->UcretDetay($kurulusId);
			$this->assignRef('detay', $detay);
		}else if($layout == "irtibat"){
			$irtibat = $model->getProfileIrtibatValues($kurulusId);
			$this->assignRef('irtibat', $irtibat);
		}else if($layout == "ucret_tarife_edit"){
						
			if(isset($_GET['yetId']) && !empty($_GET['yetId'])){
				$yetId = $_GET['yetId'];
			}else if(isset($_POST['yetId']) && !empty($_POST['yetId'])){
				$yetId = $_POST['yetId'];
			}else{
				$yetId = 0;
			}
			
			if($yetId != 0){
				$yetkiliYet = $model->getYetkiliYeterlilik($kurulusId);
				$this->assignRef('yetkiliYet', $yetkiliYet);
					
				$yetkiYets = $model->getYetYetkiOnayli($kurulusId,$yetId);
				$this->assignRef('yetkiYets', $yetkiYets);
					
				$yetkiBirims = $model->getYetkiBirimOnayli($kurulusId,$yetkiYets);
				$this->assignRef('yetkiBirims', $yetkiBirims);
			}
			$this->assignRef('yId', $yetId);
			$UcretTarifeYet = $model->UcretTarifeYet($kurulusId);
			$this->assignRef('UcretTarifeYet', $UcretTarifeYet);
		}else if($layout=="abdonem"){
			$abKur = $model->getABKurulusBilgi($kurulusId);
			$this->assignRef('abKur', $abKur);
			$this->assignRef('ABKurKota', FormABHibeUcretHesabi::KuruluABHibeToplamKota($kurulusId));
			$this->assignRef('ABKurKullanilanKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($kurulusId));
			$this->assignRef('ABKurKullanilanDezKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($kurulusId));
			$this->assignRef('ABKurBekKota', FormABHibeUcretHesabi::KuruluABHibeBekKota($kurulusId));
			$this->assignRef('ABKurBekDezKota', FormABHibeUcretHesabi::KuruluABHibeBekDezKota($kurulusId));
			$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($kurulusId));
			$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
			$this->assignRef('doviz', $doviz);
		}

		
		
		
		
		parent::display($tpl);		
	}	
}
?>
