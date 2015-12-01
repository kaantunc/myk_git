<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class DenetimViewDenetim extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();
		

		if (!isset ($layout)){
			$layout = "denetim_listele";
			$this->setLayout($layout);
		}
		
		
		$this->assignRef('denetimListesi', $model->getDenetimListesi());
		$this->assignRef('denetimlerim', $model->getDenetimlerim());
		$this->assignRef('bagliOldugumDenetimler', $model->getBagliOldugumDenetimler());
		
		$denetim_id = JRequest::getVar("denetim_id");
		if (isset ($denetim_id)){
			$seciliDenetim = $model->getDenetimByID($denetim_id);
			$this->assignRef('seciliDenetim', $seciliDenetim);
			
			$uzmanDis = $model->getuzmanDisByID($denetim_id);
			$this->assignRef('uzmanDis', $uzmanDis);
			
			$this->assignRef('onayliUzmanlar_BuDenetimdekiCalismalariHaric', $model->getOnayliDenetimUzmanlari_BuDenetimdekiCalismalariHaric($denetim_id));
			
			$seciliDenetiminDenetimEkibi = $model->getDenetimEkibiByDenetimID($denetim_id);
			$this->assignRef('seciliDenetiminDenetimEkibi', $seciliDenetiminDenetimEkibi);
						
			$seciliDenetiminBasDenetcisi = $model->getDenetimEkibiByDenetimIDAndRolu($denetim_id, PM_DENETIM_EKIBI_ROLU__BAS_DENETCI);
			$this->assignRef('seciliDenetiminBasDenetcisi', $seciliDenetiminBasDenetcisi);
				
			
			$seciliDenetiminUygunsuzluklari = $model->getDenetimUygunsuzluklariByDenetimID($denetim_id);
			$this->assignRef('seciliDenetiminUygunsuzluklari', $seciliDenetiminUygunsuzluklari);
			
			$this->assignRef('uygunsuzlugunKurulusu', $model->getKurulusAdiFromDenetimID($denetim_id));
			
			
			$this->assignRef('sinavYetkisiVerilecekBirimler', $model->getSinavYetkisiVerilecekBirimler($seciliDenetim['DENETIM_KURULUS_ID']));
			$this->assignRef('sinavYetkisiVerilecekBirimler_EskiFormattakiYeterlilik', $model->getSinavYetkisiVerilecekBirimler_EskiFormattakiYeterlilikler($seciliDenetim['DENETIM_KURULUS_ID']));
			
			$this->assignRef('sinavYetkisiVerilecekBirimIDleri', $model->getSinavYetkisiVerilecekBirimIDleri($seciliDenetim['DENETIM_KURULUS_ID']));
			$this->assignRef('sinavYetkisiVerilmisBirimler', $model->getSinavYetkisiVerilmisBirimler($seciliDenetim['DENETIM_KURULUS_ID']));
			$this->assignRef('sinavYetkisiVerilmisBirimler_Detaylariyla', $model->getSinavYetkisiVerilmisBirimler_Detaylariyla($seciliDenetim['DENETIM_KURULUS_ID']));
			$this->assignRef('sinavYetkisiVerilmisBirimler_Detaylariyla_EskiFormattakiYeterlilikler', $model->getSinavYetkisiVerilmisBirimler_Detaylariyla_EskiFormattakiYeterlilikler($seciliDenetim['DENETIM_KURULUS_ID']));
			
			$this->assignRef('sinavYetkisiVerilmisBirimlerVeYetkiTarihleri', $model->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri($seciliDenetim['DENETIM_KURULUS_ID']));
			$this->assignRef('sinavYetkisiAlinmisBirimlerVeYetkiTarihleri', $model->getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri($seciliDenetim['DENETIM_KURULUS_ID']));
				
			$this->assignRef('sinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten', $model->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten($seciliDenetim['DENETIM_KURULUS_ID']));
			$this->assignRef('sinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten', $model->getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten($seciliDenetim['DENETIM_KURULUS_ID']));
				
			$this->assignRef('buDenetimDisindaYetkilendirilmisBirimler', $model->getBuDenetimDisindaSinavYetkisiVerilmisBirimler($seciliDenetim['DENETIM_KURULUS_ID'], $denetim_id));
				
			
			$this->assignRef('denetimRapor', $model->getDenetimRapor($denetim_id));
			$this->assignRef('kurulus', $model->getKurulusFromDenetimID($denetim_id));
			$this->assignRef('denetimRaporOnay', $model->getDenetimRaporOnay($denetim_id));
		}

		$uygunsuzluk_id = JRequest::getVar("uygunsuzluk_id");
		if (isset ($uygunsuzluk_id))
		{
			$seciliUygunsuzluk = $model->getDenetimUygunsuzluklariByUygunsuzlukID($uygunsuzluk_id);
			$this->assignRef('seciliUygunsuzluk', $seciliUygunsuzluk);
			$this->assignRef('uygunsuzlugunKurulusu', $model->getKurulusAdiFromUygunsuzlukID($uygunsuzluk_id));
			$seciliUygunsuzlugunDenetimi = $model->getSeciliUygunsuzlugunDenetimi($uygunsuzluk_id);
			$this->assignRef('seciliUygunsuzlugunDenetimi', $seciliUygunsuzlugunDenetimi );
			
			$denetim_id = $seciliUygunsuzlugunDenetimi['DENETIM_ID'];
			
			$seciliDenetiminDenetimEkibi = $model->getDenetimEkibiByDenetimID($denetim_id);
			$this->assignRef('seciliDenetiminDenetimEkibi', $seciliDenetiminDenetimEkibi);
			
			$seciliDenetiminBasDenetcisi = $model->getDenetimEkibiByDenetimIDAndRolu($denetim_id, PM_DENETIM_EKIBI_ROLU__BAS_DENETCI);
			$this->assignRef('seciliDenetiminBasDenetcisi', $seciliDenetiminBasDenetcisi);
				
				
		}
		
			
		
		$this->assignRef('kuruluslarSelectOptions', $model->getKuruluslarAsASelect($seciliDenetim['DENETIM_KURULUS_ID']));
		$this->assignRef('rollerSelectOptions', $model->getPMDenetimEkipRolleriAsSelectOptions());
		
		$this->assignRef('uzmanlar', $model->getDenetimUzmanlari());
		$this->assignRef('onayliUzmanlar', $model->getOnayliDenetimUzmanlari());
		
		
		$this->assignRef('ekipRolleri', $model->getEkipRolleri());
		
		
		
		parent::display($tpl);
	}
}

?>