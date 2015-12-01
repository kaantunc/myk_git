<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Birim_YonetimiViewBirim_Yonetimi extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();
		/*$aut 		= FormFactory::checkAuthorization  ($user, T1_GROUP_ID);

		if (!$aut)
			$mainframe->redirect('index.php?', YETKI_MESAJ);
		*/

		if (!isset ($layout)){
			$layout = "default";
			$this->setLayout($layout);
		}



		$birimler = $model->getTumBirimler();
		$this->assignRef('birimler',$birimler);
		$onaylanacakBirimler = $model->getOnaylanacakBirimler();
		$this->assignRef('onaylanacakBirimler',$onaylanacakBirimler);

		
		$eklenmisBirim = $birimler;
		
		for($i=0; $i<count($eklenmisBirim); $i++)
		{
			$birimID = $eklenmisBirim[$i]["BIRIM_ID"];

			$birimiGelistirenKuruluslar[$i] = $model->getBirimiGelistirenKuruluslar($birimID);
			$this->assignRef('birimiGelistirenKuruluslar-'.$birimID, $birimiGelistirenKuruluslar[$i]);

			$biriminKaynaklari[$i] = $model->getBiriminKaynaklari($birimID);
			$this->assignRef('biriminKaynaklari-'.$birimID, $biriminKaynaklari[$i]);

			$biriminKaynaklariListesi[$i] = $model->getBiriminKaynaklariTextListesi($birimID);
			$this->assignRef('biriminKaynaklariListesi-'.$birimID, $biriminKaynaklariListesi[$i]);

			$birimiDogrulayanKomiteUyeleri[$i] = $model->getBirimiDogrulayanKomiteUyeleri($birimID);
			$this->assignRef('birimiDogrulayanKomiteUyeleri-'.$birimID, $birimiDogrulayanKomiteUyeleri[$i]);
				
			$biriminEk2si_KontrolListesiz[$i] = $model->getBiriminEk2si_KontrolListesiz($birimID);
			$this->assignRef('biriminEk2si_KontrolListesiz-'.$birimID, $biriminEk2si_KontrolListesiz[$i]);


			$biriminEk1Yazilari[$i] = $model->getBiriminEk1Yazilari($birimID);
			$this->assignRef('buBiriminEk1Yazilari-'.$birimID, $biriminEk1Yazilari[$i]);



			$biriminEk2si_KontrolListeliTablo1[$i] = $model->getBiriminEk2si_KontrolListeli($birimID, PM_BIRIM_EK2_TIPI__YETKINLIK);
			$this->assignRef('biriminEk2si_KontrolListeli-Tablo1-'.$birimID, $biriminEk2si_KontrolListeliTablo1[$i]);
			$biriminEk2si_KontrolListeliTablo2[$i] = $model->getBiriminEk2si_KontrolListeli($birimID, PM_BIRIM_EK2_TIPI__ANLAYIS);
			$this->assignRef('biriminEk2si_KontrolListeli-Tablo2-'.$birimID, $biriminEk2si_KontrolListeliTablo2[$i]);


			$biriminTeorikSinavlari[$i] = $model->getBiriminOlcmeDegerlendirmeleri($birimID, PM_OLCME_DEGERLENDIRME_TIPI__TEORIK_SINAV);
			if($biriminTeorikSinavlari[$i] != null )
				$this->assignRef('biriminTeorikSinavlari-'.$birimID, $biriminTeorikSinavlari[$i]);

			$biriminPerformansSinavlari[$i] = $model->getBiriminOlcmeDegerlendirmeleri($birimID, PM_OLCME_DEGERLENDIRME_TIPI__PERFORMANS_SINAVI);
			if($biriminPerformansSinavlari[$i] != null )
				$this->assignRef('biriminPerformansSinavlari-'.$birimID, $biriminPerformansSinavlari[$i]);

			$biriminDigerSinavlari[$i] = $model->getBiriminOlcmeDegerlendirmeleri($birimID, PM_OLCME_DEGERLENDIRME_TIPI__DIGER_KOSULLAR);
			if($biriminDigerSinavlari[$i] != null )
				$this->assignRef('biriminDigerSinavlari-'.$birimID, $biriminDigerSinavlari[$i]);


			$biriminOgrenmeCiktilari[$i] = $model->getOgrenmeCiktilariByBirim($birimID);
			if($biriminOgrenmeCiktilari[$i] != null )
				$this->assignRef('biriminOgrenmeCiktilari-'.$birimID, $biriminOgrenmeCiktilari[$i]);

			$biriminBaglamlari[$i] = $model->getBaglamByDisIDAndIliskiTipi(array($birimID), PM_BAGLAM_TIPI__BIRIM_BAGLAMI );
			if($biriminBaglamlari[$i] != null )
				$this->assignRef('biriminBaglamlari-'.$birimID, $biriminBaglamlari[$i]);


			for($j=0; $j<count($biriminOgrenmeCiktilari[$i]); $j++)
			{
				$ogrenmeCiktisiID = $biriminOgrenmeCiktilari[$i][$j]["OGRENME_CIKTISI_ID"];
				$ogrenmeCiktilariIDleriArray[] = $ogrenmeCiktisiID;

				$ogrenmeCiktisininBaglamlari[$i][$j] = $model->getBaglamByDisIDAndIliskiTipi(array($ogrenmeCiktisiID), PM_BAGLAM_TIPI__OGRENME_CIKTISI_BAGLAMI );
				if($ogrenmeCiktisininBaglamlari[$i][$j]  != null)
					$this->assignRef('ogrenmeCiktisininBaglamlari-'.$birimID."-".$ogrenmeCiktisiID, $ogrenmeCiktisininBaglamlari[$i][$j] );
					
				$ogrenmeCiktisininBasarimOlcutleri[$i][$j]  = $model->getBasarimOlcutleriByOgrenmeCiktisi($ogrenmeCiktisiID);
				if($ogrenmeCiktisininBasarimOlcutleri[$i][$j]  != null)
					$this->assignRef('ogrenmeCiktisininBasarimOlcutleri-'.$birimID.'-'.$ogrenmeCiktisiID, $ogrenmeCiktisininBasarimOlcutleri[$i][$j]);

				for($k=0; $k<count($ogrenmeCiktisininBasarimOlcutleri[$i][$j]); $k++)
				{
					$basarimOlcutuID = $ogrenmeCiktisininBasarimOlcutleri[$i][$j][$k]["BASARIM_OLCUTU_ID"];

					$basarimOlcutununBaglamlari[$i][$j][$k] = $model->getBaglamByDisIDAndIliskiTipi(array($basarimOlcutuID), PM_BAGLAM_TIPI__BASARIM_OLCUTU_BAGLAMI );
					if($basarimOlcutununBaglamlari[$i][$j][$k] != null)
						$this->assignRef('basarimOlcutununBaglamlari-'.$birimID."-".$ogrenmeCiktisiID."-".$basarimOlcutuID, $basarimOlcutununBaglamlari[$i][$j][$k]);


				}


			}

		}
		$PMEk2Turler = $model->getPMBirimEk2Turleri();
		$this->assignRef('birimEk2Turleri', $PMEk2Turler );
		$this->assignRef('genelKurul', $model->getGenelKurul());
		$this->assignRef('distinctGenelKurul', $model->getDistinctGenelKurul());
		$this->assignRef('yeterliligeKaynakTeskilEdenler', $model->getYeterlilikKaynagi($yeterlilik_id));
			
		
		
		
		parent::display($tpl);
	}
}

?>