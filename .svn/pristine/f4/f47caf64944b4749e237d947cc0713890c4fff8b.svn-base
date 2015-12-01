<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Uzman_BasvurViewUzman_Profile extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar("layout");
		$canEdit = false;
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		if ($isSektorSorumlusu){
			$tc_kimlik = JRequest::getVar("tc_kimlik");	
			$durum=2;
			$canEdit=true;
		}
		$user_id	= $user->getOracleUserId ();
		$group_id   = UZMAN_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		
		// Yönetici mi Kotrolü
		$group_idYon   = 27;
		$autYon = FormFactory::checkAuthorization  ($user, $group_idYon);
		$yonetici = false;
		if($autYon){
			$yonetici = true;
		}
		$this->assignRef('Yonetici', $yonetici);
		// Yönetici mi Kotrolü SON
		
		if (!$aut and (!$isSektorSorumlusu or !$tc_kimlik))
			$mainframe->redirect('index.php?', $message);
				
		if ($tc_kimlik){
			$kurulus 	= $model->getUzmanValuesByTcKimlik($tc_kimlik);
		} else {
			$kurulus 	= $model->getUzmanValues($user_id);
		}
		
	    if (!isset ($layout)){
    		$layout = "uzman_bilgi";
			$this->setLayout($layout);
		}

		$title 	  = "Uzman Başvuru Formu";
		$pages 	  = array ("uzman_bilgi","myk_egitim","basvuru_bilgi","denetim");
		$pageNames= array ("Kişisel Bilgiler","MYK’dan Alınmış Eğitimler","Başvuru Bilgileri","Denetimler");

//		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
		if(!$isSektorSorumlusu){
			$tckimlik	= $kurulus[TC_KIMLIK];
		} else {
			$tckimlik=$tc_kimlik;
		}
		if ($layout == ""){
			$mainframe->redirect('index.php?option=com_uzman_basvur', "Kişisel Bilgileriniz kaydedilmeden diğer sayfalara geçemezsiniz.");
		}
		
		$basvuru_durum	= $kurulus[BASVURU_DURUM];
		$pageTree	= $model->getPageTree ($user, $layout, substr($tckimlik,0,9), $pages, $pageNames,$basvuru_durum,$tckimlik); 
// 		$yorum	= $model->getYorumValues($tckimlik);
// 		$basvuru_sektor	= $model->getUzmanBasvuruSektorValues($tckimlik);
// 		$basvuru_yeterlilik	= $model->getUzmanBasvuruYeterlilikValues($tckimlik);
// 		$deneyim_tipleri	= $model->getDeneyim_tipleri ();
// 		$basvuru_alanlari	= $model->getBasvuru_alanlari ($tckimlik);
		

		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		$pm_yeterlilik_ad = FormParametrik::getYeterlilikAd ();
// 		$deneyim_tipleri	= $model->getDeneyim_tipleri();
		
		$this->assignRef('pm_il'	, $pm_il);
		$this->assignRef('pm_sektor'	, $pm_sektor);
		
		$this->assignRef('basvuru_alanlari', $basvuru_alanlari);
// 		$this->assignRef('deneyim_tipleri', $deneyim_tipleri);
		
		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $tckimlik);
		$this->assignRef('pageTree'	, $pageTree);	
		$this->assignRef('basvuru'	, $basvuru);
		$this->assignRef('canEdit'	, $canEdit);
		
		$this->assignRef('isSektorSorumlusu'	, $isSektorSorumlusu);
		$this->assignRef('kurulus'	, $kurulus);
		
		
		$this->assignRef('yorum'  	, $yorum);
		$this->assignRef('ssmi', $isSektorSorumlusu);
		
		$BilgiOnay = $model->getBilgilendirmeOnayla($tckimlik);
		$this->assignRef('BilgiOnay', $BilgiOnay);
		
		if($layout == "default"){
			
		}else if($layout == "uzman_bilgi"){
			$this->assignRef('kurulus', $kurulus);
		}else if($layout == "myk_egitim"){
			$myk_egitim		= $model->getMykUzmanEgitimValues($tckimlik);
			$this->assignRef('myk_egitim'	, $myk_egitim);
		}else if($layout == "basvuru_bilgi"){
			
		}else if($layout == "denetci"){
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
			$tuYet = $model->getTUYeterlilik($tckimlik);
			$this->assignRef('tuYet', $tuYet);
			$tuKanit = $model->getTUBelgeKanit($tckimlik);
			$this->assignRef('tuKanit', $tuKanit);
			$tuDeneyim = $model->getTUDeneyim($tckimlik);
			$this->assignRef('tuDeneyim', $tuDeneyim);
			$dtTaahut = $model->getUzmanTaahut($tckimlik);
			$this->assignRef('taahut', $dtTaahut);
			$tuMusait = $model->getTUMusait($tckimlik);
			$this->assignRef('tuMusait', $tuMusait);
		}else if($layout == "denetim"){
			$denetim = $model->getDenetim($tckimlik);
			$this->assignRef('denetim', $denetim);
		}else if($layout == 'testtc'){
			$this->assignRef('hataTC', $model->SonraSilTCKontrol());
		}
		
		parent::display($tpl);		
	}	
}
?>
