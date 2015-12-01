<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Uzman_BasvurViewUzman_Basvur extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");	
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		if ($isSektorSorumlusu){
			$tc_kimlik		= JRequest::getVar ("tc_kimlik");	
			$durum=2;
			$canEdit=true;
		}
		$user_id	= $user->getOracleUserId ();
		$group_id   = UZMAN_GROUP_ID;
// 		$group_id2   = UZMAN_ONIZLEYICI_GROUP_ID;
		$group_idYon   = 27;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$autYon = FormFactory::checkAuthorization  ($user, $group_idYon);
// 		$aut2 = FormFactory::checkAuthorization  ($user, $group_id2);
		
		$yonetici = false;
		if($autYon){
			$yonetici = true;
		}
		
		$this->assignRef('Yonetici', $yonetici);
		
		if (!$aut and (!$isSektorSorumlusu or !$tc_kimlik))
			$mainframe->redirect('index.php?', $message);
				
		if ($tc_kimlik){
			$kurulus 	= $model->getUzmanValuesByTcKimlik($tc_kimlik);	
// 			$onaylanmiskurulus 	= $model->getUzmanValuesByTcKimlik($tc_kimlik);	
		} else {
			$kurulus 	= $model->getUzmanValues($user_id);
		}
	    if (!isset ($layout)){
    		$layout = "uzman_bilgi";
			$this->setLayout($layout);
		}
		
		$pdf = 0;
		if ($layout == "tum_basvuru")
			$pdf = 1;
		$title 	  = "Uzman Başvuru Formu";
// 		$pages 	  = array ("uzman_bilgi","myk_egitim","basvuru_bilgi","egitim","yabanci_dil","sertifika","is_deneyimi","myk_deneyimi");
		$pages 	  = array ("uzman_bilgi","myk_egitim","basvuru_bilgi");
// 		$pageNames= array ("Kişisel Bilgiler","MYK’dan Alınmış Eğitimler","Başvuru Bilgileri","Eğitim Bilgileri", "Yabancı Dil", "Sertifika ve Belgeler","İş Deneyimleri","MYK ile İlgili Deneyimler");
		$pageNames= array ("Kişisel Bilgiler","MYK’dan Alınmış Eğitimler","Başvuru Bilgileri");

//		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
		if(!$isSektorSorumlusu){
			$tckimlik	= $kurulus[TC_KIMLIK];
		} else {
			$tckimlik=$tc_kimlik;
// 			$pages[] 	  = "ss_islemleri";
// 			$pageNames[]  = "SS İşlem";
		}
		if ($layout == ""){
			$mainframe->redirect('index.php?option=com_uzman_basvur', "Kişisel Bilgileriniz kaydedilmeden diğer sayfalara geçemezsiniz.");
		}
		if ($kurulus[TC_KIMLIK]==""){
			$pages 	  = array ("uzman_bilgi","","");
// 			$pageNames= array ("Kişisel Bilgiler","MYK’dan Alınmış Eğitimler","Başvuru Bilgileri","Eğitim Bilgileri", "Yabancı Dil", "Sertifika ve Belgeler","İş Deneyimleri","MYK ile İlgili Deneyimler");
			$pageNames= array ("Kişisel Bilgiler","MYK’dan Alınmış Eğitimler","Başvuru Bilgileri");
		}
		$basvuru_durum	= $kurulus[BASVURU_DURUM];
		$pageTree	= $model->getPageTree ($user, $layout, substr($tckimlik,0,9), $pages, $pageNames,$basvuru_durum,$tckimlik); 
		$egitim		= $model->getUzmanEgitimValues($tckimlik);
		$myk_egitim		= $model->getMykUzmanEgitimValues($tckimlik);
		$dil		= $model->getUzmanDilValues($tckimlik);	
		$sertifika	= $model->getUzmanSertifikaValues($tckimlik);
		$deneyim	= $model->getUzmanDeneyimValues($tckimlik);
		$mykdeneyim	= $model->getUzmanMykDeneyimValues($tckimlik);
		$yorum	= $model->getYorumValues($tckimlik);
		$basvuru_sektor	= $model->getUzmanBasvuruSektorValues($tckimlik);
		$basvuru_yeterlilik	= $model->getUzmanBasvuruYeterlilikValues($tckimlik);
		$deneyim_tipleri	= $model->getDeneyim_tipleri ();
		$basvuru_alanlari	= $model->getBasvuru_alanlari ($tckimlik);
		
// 		if ($basvuru_durum=="0" or ($isSektorSorumlusu and $tc_kimlik) or ($kurulus==NULL and $layout == "uzman_bilgi")){
// 			$canEdit=true;
// 		}
		
// 			if ($basvuru_durum=="1" and !$isSektorSorumlusu and $layout!="pdf_link" and $layout!="tum_basvuru"){
// 				$msgtext="Değişiklik yapmanız halinde yaptığınız başvuru iptal edilecek. Değişiklikten sonra tekrar başvuru tamamlamanız gerekmektedir.";
// 				JError::raiseNotice( 100,  $msgtext);
// 				$onclick="return confirm('".$msgtext."');";
// 				$this->assignRef('onclick'	, $onclick);
// 			}
// 			if ($basvuru_durum=="2" and !$isSektorSorumlusu and $layout!="pdf_link" and $layout!="tum_basvuru"){
// 				$msgtext="Değişiklik yapmanız halinde onaylanmış olan bilgileriniz iptal edilecek. Değişiklikten sonra tekrar başvuru tamamlamanız gerekmektedir.";
// 				JError::raiseNotice( 100, $msgtext);
// 				$onclick="return confirm('".$msgtext."');";
// 				$this->assignRef('onclick'	, $onclick);
// 			}
				
//		$iller	 	= FormFactory::getKurulusIlValues ($user_id, $pdf);

		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_kurulus_statu = FormParametrik::getKurulusStatu ();
		$pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		$pm_yeterlilik_ad = FormParametrik::getYeterlilikAd ();
		$deneyim_tipleri	= $model->getDeneyim_tipleri ();
		$BilgiOnay = $model->getBilgilendirmeOnayla($tckimlik);
		$this->assignRef('BilgiOnay', $BilgiOnay);
		
		$this->assignRef('basvuru_alanlari', $basvuru_alanlari);
		$this->assignRef('deneyim_tipleri', $deneyim_tipleri);
		
		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $tckimlik);
		$this->assignRef('pageTree'	, $pageTree);	
		$this->assignRef('basvuru'	, $basvuru);
		$this->assignRef('canEdit'	, $canEdit);
		
		$this->assignRef('isSektorSorumlusu'	, $isSektorSorumlusu);
		$this->assignRef('kurulus'	, $kurulus);
// 		$this->assignRef('onaylanmiskurulus'	, $onaylanmiskurulus);
		$this->assignRef('pm_il'	, $pm_il);
		$this->assignRef('pm_sektor'	, $pm_sektor);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('myk_egitim'	, $myk_egitim);
		$this->assignRef('dil'	    , $dil);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('deneyim'  , $deneyim);
		$this->assignRef('yorum'  	, $yorum);
		$this->assignRef('mykdeneyim'  , $mykdeneyim);
		$this->assignRef('basvuru_sektor'  , $basvuru_sektor);
		$this->assignRef('basvuru_yeterlilik'  , $basvuru_yeterlilik);
		$this->assignRef('deneyim_tipleri', $deneyim_tipleri);
		$this->assignRef('ssmi', $isSektorSorumlusu);
		
		$this->assignRef('user_id', $user_id);
		
		if($layout == "denetci"){
			$dtBelge = $model->getDenetciBelgeGecerlilik($tckimlik);
			$this->assignRef('dtBelge', $dtBelge);
			$dtKanit = $model->getDenetciBelgeKanit($tckimlik);
			$this->assignRef('dtKanit', $dtKanit);
			$dtDeneyim = $model->getDenetciDeneyim($tckimlik);
			$this->assignRef('dtDeneyim', $dtDeneyim);
			$dtTaahut = $model->getUzmanTaahut($tckimlik);
			$this->assignRef('taahut', $dtTaahut);
			$dtMusait = $model->getDenetciMusait($tckimlik);
			$this->assignRef('dtMusait', $dtMusait); 
		}else if($layout == "teknik_uzman"){
			$dtYet = $model->getTUYeterlilik($tckimlik);
			$this->assignRef('dtYet', $dtYet);
			$dtKanit = $model->getTUBelgeKanit($tckimlik);
			$this->assignRef('dtKanit', $dtKanit);
			$dtDeneyim = $model->getTUDeneyim($tckimlik);
			$this->assignRef('dtDeneyim', $dtDeneyim);
			$dtTaahut = $model->getUzmanTaahut($tckimlik);
			$this->assignRef('taahut', $dtTaahut);
			$dtMusait = $model->getTUMusait($tckimlik);
			$this->assignRef('dtMusait', $dtMusait);
		}
		
		parent::display($tpl);		
	}	
}
?>
