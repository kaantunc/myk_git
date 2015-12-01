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
		
//		$this->assignRef('taslakYeterlilik'	, $taslakYeterlilik);
		$this->assignRef('yeterlilik_id'	, $yeterlilik_id);
//		$this->assignRef('yeterlilikBilgi'	, $yeterlilikBilgi);
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
