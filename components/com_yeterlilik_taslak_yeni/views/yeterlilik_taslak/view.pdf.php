<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Yeterlilik_TaslakViewYeterlilik_Taslak extends JView
{
	function display($tpl = null)
	{
		$model 	= &$this->getModel();
		$yeterlilik_id = JRequest::getVar("yeterlilik_id");
		
//		$taslakYeterlilik = $model->getTaslakYeterlilik ($yeterlilik_id);
//		$yeterlilikBilgi  = $model->getYeterlilikBilgi ($yeterlilik_id);
				$zorunluBirim	  =	$model->getAltBirim ($yeterlilik_id, ZORUNLU_ALT_BIRIM);
		$secmeliBirim	  =	$model->getAltBirim ($yeterlilik_id, SECMELI_ALT_BIRIM);
		$teorikOlcme	  = $model->getDegerlendirmeArac ($yeterlilik_id, TEORIK_OLCME_ARAC_TUR);
		$performansOlcme  = $model->getDegerlendirmeArac ($yeterlilik_id, PERFORMANS_OLCME_ARAC_TUR);
		$bilgi 			  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BILGI);
		$beceri 		  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BECERI);
		$yetkinlik 		  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_YETKINLIK);
		//$onayliStandart	  = $model->getOnaylanmisMeslekStandart ();
		$onayliAltBirim	  = $model->getOnaylanmisAltBirim ();
		$kaynakMeslek	  = $model->getKaynakValues ($yeterlilik_id, KAYNAK_STANDART_TUR);
		$kaynakBirim	  = $model->getKaynakValues ($yeterlilik_id, KAYNAK_YETERLILIK_TUR);
		$gelistiren_kurulus = $model->getKurulusValues ($yeterlilik_id, YET_GELISTIREN_KURULUS);
		$terim			  = $model->getTerimValues ($yeterlilik_id);
		$standart		  = $model->getStandartValues ($yeterlilik_id);
		$birim_bilgi 	  = $model->getAltBirimBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BILGI);
		$birim_beceri 	  = $model->getAltBirimBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BECERI);
		$birim_yetkinlik  = $model->getAltBirimBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_YETKINLIK);
		$katki_kurulus	  = $model->getKurulusValues ($yeterlilik_id, YET_KATKI_SAGLAYAN_KURULUS);
		$gorus_kurulus	  = $model->getKurulusValues ($yeterlilik_id, YET_GORUSE_GONDERILEN_KURULUS);
		$degerlendirme_ogrenme = $model->getDegerlendirmeOgrenmeCikti ($yeterlilik_id);
		$canOpenEkler	  = $model->canOpenEkler ($yeterlilik_id, $user);
		
		$eklenmisBirim = $model->getEklenmisBirim($yeterlilik_id);
			
		for($i=0; $i<count($eklenmisBirim); $i++)
		{
			$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
			
			$birimiGelistirenKuruluslar[$i] = $model->getBirimiGelistirenKuruluslar($birimID);
			$this->assignRef('birimiGelistirenKuruluslar-'.$birimID, $birimiGelistirenKuruluslar[$i]);
			
			$biriminKaynaklari[$i] = $model->getBiriminKaynaklari($birimID);
			$this->assignRef('biriminKaynaklari-'.$birimID, $biriminKaynaklari[$i]);
			
			$biriminKaynaklariListesi[$i] = $model->getBiriminKaynaklariTextListesi($birimID);
			$this->assignRef('biriminKaynaklariListesi-'.$birimID, $biriminKaynaklariListesi[$i]);
			
			$biriminKaynaklariListesi_Detayli[$i] = $model->getBiriminKaynaklariListesi($birimID);
			$this->assignRef('biriminKaynaklariListesiDetayli-'.$birimID, $biriminKaynaklariListesi_Detayli[$i]);
				
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
			
		$this->assignRef('eklenmisBirim', $eklenmisBirim);
		$this->assignRef('yeterlilikBirimleri', $model->getYeterlilikBirimleri ($yeterlilik_id));
		
//		$this->assignRef('yeterlilikBilgi'	, $yeterlilikBilgi);
//		$this->assignRef('taslakYeterlilik'	, $taslakYeterlilik);
		$this->assignRef('zorunluBirim'	  	, $zorunluBirim);
		$this->assignRef('secmeliBirim'	  	, $secmeliBirim);
		$this->assignRef('teorikOlcme'	  	, $teorikOlcme);
		$this->assignRef('performansOlcme'	, $performansOlcme);
		$this->assignRef('bilgi'			, $bilgi);
		$this->assignRef('beceri'			, $beceri);
		$this->assignRef('yetkinlik'		, $yetkinlik);
		//$this->assignRef('onayliStandart'	, $onayliStandart);
		$this->assignRef('onayliAltBirim'	, $onayliAltBirim);
		$this->assignRef('kaynakMeslek'		, $kaynakMeslek);
		$this->assignRef('kaynakBirim'		, $kaynakBirim);
		$this->assignRef('gelistiren_kurulus', $gelistiren_kurulus);
		$this->assignRef('terim'			, $terim);
		$this->assignRef('standart'			, $standart);
		$this->assignRef('birim_bilgi'		, $birim_bilgi);
		$this->assignRef('birim_beceri'		, $birim_beceri);
		$this->assignRef('birim_yetkinlik'	, $birim_yetkinlik);
		$this->assignRef('katki_kurulus'	, $katki_kurulus);
		$this->assignRef('gorus_kurulus'	, $gorus_kurulus);
		$this->assignRef('degerlendirme_ogrenme', $degerlendirme_ogrenme);
		$this->assignRef('canOpenEkler'		, $canOpenEkler);

		parent::display($tpl);
	}	
}
?>
