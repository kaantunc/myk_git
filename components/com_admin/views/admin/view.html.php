<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AdminViewAdmin extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
		$aut 		= FormFactory::checkAuthorization  ($user, YONETICI_GROUP_ID);
        $layout		 = JRequest::getVar("layout");

		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		if (!$aut)
			$mainframe->redirect('index.php?', YETKI_MESAJ);

		/////////////////////////////////////////////////////////////////////////////////
		
		$pageTree 	= $model->getPageTree ($user, $layout, $standart_id, $evrak_id);
		$this->assignRef('pageTree'	  	, $pageTree);
        
 		$yonetimKuruluTarihleri1 = $model->getYonetimKuruluTarihleri (1);
		$this->assignRef ("yonetimKuruluTarihleri1"		, $yonetimKuruluTarihleri1);
        
 		$yonetimKuruluTarihleri2 = $model->getYonetimKuruluTarihleri (2);
		$this->assignRef ("yonetimKuruluTarihleri2"		, $yonetimKuruluTarihleri2);

 		$yonetimKurulu = $model->getYonetimKurulu ();
		$this->assignRef ("yonetimKurulu"		, $yonetimKurulu);
        
 		$genelKurulTarihleri = $model->getGenelKurulTarihleri();
		$this->assignRef ("genelKurulTarihleri"		, $genelKurulTarihleri);

 		$genelKurul = $model->getGenelKurul ();
		$this->assignRef ("genelKurul"		, $genelKurul);
        
 		$sektorler = $model->getSektorler ();
		$this->assignRef ("sektorler"		, $sektorler);

 		$komiteTarihleri = $model->getKomiteTarihleri ();
		$this->assignRef ("komiteTarihleri"		, $komiteTarihleri);

 		$sektorKomitesi = $model->getSektorKomitesi ();
		$this->assignRef ("sektorKomitesi"		, $sektorKomitesi);

 		$SSYetkileri = $model->getSSYetkileri ();
		$this->assignRef ("SSYetkileri"		, $SSYetkileri);
		
		$sektorler		  = FormParametrik::getSektor ();
		$this->assignRef ("sektorler"		, $sektorler);
		
		$tumsektorler		  = FormParametrik::getTumSektor ();
		$this->assignRef ("tumsektorler"		, $tumsektorler);
		
 		$sektorSorumlulari = $model->getSektorSorumlulari ();
		$this->assignRef ("sektorSorumlulari"		, $sektorSorumlulari);

 		$itemBankUsers = $model->getItemBankUsers ();
		$this->assignRef ("itemBankUsers"		, $itemBankUsers);

 		$kuruluslar = $model->getKurulus ();
		$this->assignRef ("kuruluslar"		, $kuruluslar);
		
		if($layout == 'sektorSorumlusuGorev'){
			$post = JRequest::get( 'post' );
			$get = JRequest::get( 'get' );
			$kurId = array_key_exists('kurulus', $get)?$get['kurulus']:0;
			$this->assignRef('kurId', $kurId);
			
			$sektorSor2 = $model->getSektorSorumlulari2();
			$this->assignRef('sektorSor', $sektorSor2);
			
			$gorevlendirme = $model->getGorevlendirme($kurId);
			$this->assignRef('gorevli', $gorevlendirme);
			
			$kurulusGorevliler = $model->KurulusGorevliler($kurId);
			$this->assignRef('kurulusGorevliler', $kurulusGorevliler);
		}

		if($layout == 'tesvikonaykomitesi'){
			$tesvikonaykomitesi = $model->getTesvikKomitesi();
			$this->assignRef('tesvikonaykomitesi', $tesvikonaykomitesi);
			
			$grouplists = $model->getUserGroups();
			$this->assignRef('usergroups', $grouplists);
		}
		parent::display($tpl);
    }    

}
?>
