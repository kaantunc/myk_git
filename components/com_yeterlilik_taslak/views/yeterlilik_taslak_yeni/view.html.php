<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


//$document = &JFactory::getDocument();
//$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/gibTable.js' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Yeterlilik_TaslakViewYeterlilik_Taslak_Yeni extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message= YETKI_MESAJ;
		$user 	= &JFactory::getUser();
		$user_id= $user->getOracleUserId ();
		$model 	= &$this->getModel();
		$layout	= JRequest::getVar("layout");

		
		if (isset($layout)){
			$yeterlilik_id = JRequest::getVar("yeterlilik_id");
			$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
			$isYetkiliKurulus  = FormFactory::yeterlilikHazirlamayaYetkiliMi ($user_id, $yeterlilik_id);	
			
			//YETKI KONTROL
			/////////////////////////////////////////////////////////////////////////////////
			//if (!$isSektorSorumlusu && !$isYetkiliKurulus){
			//	$mainframe->redirect('index.php?', $message);
			//}
			/////////////////////////////////////////////////////////////////////////////////	
		
			$evrak_id	= $model->getOracleEvrakId ($yeterlilik_id);
			$taslak		= $model->isTaslak ($evrak_id);
			$tur_id		= JRequest::getVar("id");
			$yorumDiv 	= "";
			
			$canEdit	= $model->canEdit ($user, $evrak_id);
			
			if (!$taslak){ // TASLAK TASLAGI
				$pageTree 	= $model->getPageTree ($user, $layout, $evrak_id, $yeterlilik_id);
				$evrak_tur_id = $model->getEvrakDurumId ($evrak_id);			
				$yorum_durum  = $model->getYorumDurumId_SS ($evrak_id);
				
				if ($evrak_tur_id == ONAYLANMAMIS_TASLAK_ADAYI_SEKLI_ID){ //Form Gonderilmisse
					if ($isSektorSorumlusu){ // Sektor Sorumlusuysa
						$yorumDiv  	= $model->getYorumDiv_SS ($evrak_id, $layout, false); //Yorum - readOnly = false
					}else{
						if ($yorum_durum == 0)
							$yorumDiv  	= $model->getYorumDiv_SS ($evrak_id, $layout, true);  //Yorum - readOnly = true
					}
				}
			}else{ // TASLAK
				$pageTree  = $model->getPageTree ($user, $layout, $evrak_id, $yeterlilik_id, 1);
				$yeterlilikDurum = $model->getYeterlilikDurumId ($yeterlilik_id);
				
				$this->assignRef('yeterlilikDurum' , $yeterlilikDurum);
			}

			$yeterlilikBilgi  = $model->getYeterlilikBilgi ($yeterlilik_id);
			$taslakYeterlilik = $model->getTaslakYeterlilik ($yeterlilik_id);
			$zorunluBirim	  =	$model->getAltBirim ($yeterlilik_id, ZORUNLU_ALT_BIRIM);
			$secmeliBirim	  =	$model->getAltBirim ($yeterlilik_id, SECMELI_ALT_BIRIM);
			$teorikOlcme	  = $model->getDegerlendirmeArac ($yeterlilik_id, TEORIK_OLCME_ARAC_TUR);
			$performansOlcme  = $model->getDegerlendirmeArac ($yeterlilik_id, PERFORMANS_OLCME_ARAC_TUR);
			$bilgi 			  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BILGI);
			$beceri 		  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BECERI);
			$yetkinlik 		  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_YETKINLIK);
			$onayliStandart	  = FormParametrik::getMeslekStandart ();
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
			$degerlendirme_ogrenme = $model->getDegerlendirmeOgrenmeCiktiValues ($yeterlilik_id);
			$degerlendirme_ogrenme2 = $model->getDegerlendirmeOgrenmeCikti ($yeterlilik_id);
			$ek_7			  = FormFactory::getBasvuruEkValues ($evrak_id, 1);
			$ek_8			  = FormFactory::getBasvuruEkValues ($evrak_id, 2);
			$canOpenEkler	  = $model->canOpenEkler ($yeterlilik_id, $user);
			$onayliYeterlilik =	$model->getOnayliYeterlilik (); //Azat
			$yeterlilikZBirim = $model->getZorunluHariciBirim ($yeterlilik_id); //Azat
			$yeterlilikSBirim = $model->getSecmeliHariciBirim ($yeterlilik_id); //Azat
			$yeterlilikTumBirim = $model->getYeterlilikTumBirim (); //Azat
			
			
			$this->assignRef('evrak_id'	  		, $evrak_id);
			$this->assignRef('yeterlilik_id'	, $yeterlilik_id);
			$this->assignRef('pageTree'	  		, $pageTree);
			$this->assignRef('tur_id'	  		, $tur_id);
			$this->assignRef('yorumDiv'	  		, $yorumDiv);
			$this->assignRef('canEdit'	  		, $canEdit);
			$this->assignRef('sektorSorumlusu' 	, $isSektorSorumlusu);
			$this->assignRef('taslak' 			, $taslak);

			$this->assignRef('yeterlilikBilgi'	, $yeterlilikBilgi);
			$this->assignRef('taslakYeterlilik'	, $taslakYeterlilik);
			$this->assignRef('zorunluBirim'	  	, $zorunluBirim);
			$this->assignRef('secmeliBirim'	  	, $secmeliBirim);
			$this->assignRef('teorikOlcme'	  	, $teorikOlcme);
			$this->assignRef('performansOlcme'	, $performansOlcme);
			$this->assignRef('bilgi'			, $bilgi);
			$this->assignRef('beceri'			, $beceri);
			$this->assignRef('yetkinlik'		, $yetkinlik);
			$this->assignRef('onayliStandart'	, $onayliStandart);
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
			$this->assignRef('degerlendirme_ogrenme2', $degerlendirme_ogrenme2);
			$this->assignRef('ek_7', $ek_7);
			$this->assignRef('ek_8', $ek_8);
			$this->assignRef('canOpenEkler', $canOpenEkler);
			$this->assignRef('onayliYeterlilik'	, $onayliYeterlilik);
			$this->assignRef('yeterlilikTumBirim'	, $yeterlilikTumBirim);
			$this->assignRef('yeterlilikZBirim'	, $yeterlilikZBirim);
			$this->assignRef('yeterlilikSBirim'	, $yeterlilikSBirim);
			
		}else{
			$yeterlilik = $model->getYeterlilik ($user_id);
			//$listeDurum	= FormFactory::getListeDurum ($user_id, YET_SEKTOR_TIPI);
			
			$this->assignRef('yeterlilik' , $yeterlilik);
			//$this->assignRef('listeDurum'  , $listeDurum);
		}

		parent::display($tpl);
	}	
}
?>
