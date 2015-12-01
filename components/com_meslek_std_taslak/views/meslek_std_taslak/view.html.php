<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/gibTable.js' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Meslek_Std_TaslakViewMeslek_Std_Taslak extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message   	 = YETKI_MESAJ;
		$user 		 = &JFactory::getUser();
		$model 		 = &$this->getModel();
		$layout		 = JRequest::getVar("layout");
		
		if (isset ($layout)){
			$standart_id = JRequest::getVar("standart_id");
			$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
			$isYetkiliKurulus  = FormFactory::standartHazirlamayaProtokoluVarMi ($user->getOracleUserId(), $standart_id);	
			$aktifYetkilendirmesiVarMi = $model->aktifYetkilendirmesiVarMi($standart_id, $user->getOracleUserId());
			//YETKI KONTROL
			/////////////////////////////////////////////////////////////////////////////////
			if (!$isSektorSorumlusu && !($isYetkiliKurulus && $aktifYetkilendirmesiVarMi))
			{
				if (!($isYetkiliKurulus && $aktifYetkilendirmesiVarMi))
					$message = "Yetkilendirmeniz Aktif Değil";	
				$mainframe->redirect('index.php?', $message, 'error');
			}
			/////////////////////////////////////////////////////////////////////////////////	
			
			$tur_id	= JRequest::getVar("id");
			$evrak_id	= $model->getOracleEvrakId ($standart_id);
			//$taslak		= $model->isTaslak ($evrak_id);
			$taslak = $model->isTaslak($standart_id);
			
			$yorumDiv_SS 	= "";
			$yorum_Div_Kurulus = '';
			
			$canEdit	= $model->canEdit($user, $standart_id);
			
			if(!$taslak)
				$taslakMiNumber = 0;
			else 
				$taslakMiNumber = 1;
			
			if (!$taslak){ // On Taslak
				$pageTree 	= $model->getPageTree ($user, $layout, $standart_id, $evrak_id, $taslakMiNumber);
				$taslak_meslek_id = $model->getTaslakMeslekId ($evrak_id);
				$standart_bilgileri = $model->getStandartBilgi ($standart_id);
				$meslekStandartDurum = $model->getMeslekStandartDurumId ($standart_id);			
				$yorum_durum  = $model->getYorumDurumId_SS ($evrak_id);
								
				
			}else{ // TASLAK
				$pageTree 			 = $model->getPageTree ($user, $layout, $standart_id, $evrak_id, 1);
				$taslak_meslek_id 	 = $model->getTaslakMeslekId ($evrak_id);
				$standart_bilgileri = $model->getStandartBilgi ($standart_id);
				$meslekStandartDurum = $model->getMeslekStandartDurumId ($standart_id);
				
				$this->assignRef('meslekStandartDurum' , $meslekStandartDurum);
			}
			
			
			if ($meslekStandartDurum == PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK
					||$meslekStandartDurum == PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK
					||$meslekStandartDurum == PM_MESLEK_STANDART_DURUMU__TASLAK)
			{ //Form Sektor Sorumlusuna Gonderilmisse
				if ($isSektorSorumlusu){ // Sektor Sorumlusuysa
					$yorumDiv_SS  	= $model->getYorumDiv_SS ($evrak_id, $layout, false); //Yorum - readOnly = false
					$yorum_Div_Kurulus = $model->getYorumDiv_Kurulus ($evrak_id, $layout, true);  //Yorum - readOnly = true
				}
				else
				{
					$yorumDiv_SS  	= $model->getYorumDiv_SS ($evrak_id, $layout, true);  //Yorum - readOnly = true
					$yorum_Div_Kurulus = $model->getYorumDiv_Kurulus ($evrak_id, $layout, false); //Yorum - readOnly = false
				}
			}
			$hazirlayan		= $model->getHazirlayanValues ($taslak_meslek_id);
			if(empty($hazirlayan)){
				// Taslak henuz olusturulmaya baslanmadiysa kurulus bilgilerine buradan ulasilacak.
				$hazirlayan		= $model->getHazirlayanValues2 ($standart_id);
			}
			$terim			= $model->getTerimValues ($taslak_meslek_id);
			$meslekStandart = $model->getMeslekStandartValues ($taslak_meslek_id);
			$meslekTanitim 	= $model->getMeslekTanitimValues ($taslak_meslek_id);
			$ekipman		= $model->getEkipmanValues ($taslak_meslek_id);
			$bilgiBeceri	= $model->getBilgiBeceriValues ($taslak_meslek_id);
			$tutumDavranis  = $model->getTutumDavranisValues ($taslak_meslek_id);
			for ($i = 0; $i < 5; $i++){
				$gorevAlan[$i] = $model->getGorevAlanValues ($taslak_meslek_id, $i+1);
			}
			$yonetimKurulu = $model->getYonetimKuruluValues($taslak_meslek_id);
			$profil			= $model->getProfilValues ($taslak_meslek_id);

			if($layout == "meslek_std_taslak_yeni"){
				$pageTree 	= $model->getPageTreeYeni ($user, $layout, $standart_id, $evrak_id);
			}
			
			$meslekStandardi = $model->getMeslekStandardiByStandartID($standart_id);
			$this->assignRef('meslekStandardi' , $meslekStandardi);
			
			$perm = false;
			if($isSektorSorumlusu){
				$perm= true;
			}else{
				if($meslekStandardi['MESLEK_STANDART_DURUM_ID'] <> PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK &&
				$meslekStandardi['MESLEK_STANDART_DURUM_ID'] <> PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK && 
				$meslekStandardi['MESLEK_STANDART_DURUM_ID'] <> PM_MESLEK_STANDART_DURUMU__TASLAK &&
				$meslekStandardi['MESLEK_STANDART_DURUM_ID'] <> PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART){
						
					$perm = true;
				}else{
					$perm = false;
				}
			}
			
			$this->assignRef ("standart_duzenleme_yetki"	, $perm);
			
			$pm_MESLEK_STANDART_SUREC_DURUM = $model->getStandartDurum (0);
			$this->assignRef ("pm_MESLEK_STANDART_SUREC_DURUM"	, $pm_MESLEK_STANDART_SUREC_DURUM);
			$pm_MESLEK_STANDART_REVIZYON_SUREC_DURUM = $model->getStandartDurum (1);
			$this->assignRef ("pm_MESLEK_STANDART_REVIZYON_SUREC_DURUM"	, $pm_MESLEK_STANDART_REVIZYON_SUREC_DURUM);
			
			$this->assignRef('pageTree'	  	, $pageTree);
			$this->assignRef('title'	  	, $model->title);
			$this->assignRef('evrak_id'	  	, $evrak_id);
			$this->assignRef('standart_id'	, $standart_id);
			$this->assignRef('yorumDiv'	  	, $yorumDiv_SS);
			$this->assignRef('yorumDiv_Kurulus' , $yorum_Div_Kurulus);
			$this->assignRef('canEdit'	  	, $canEdit);
			$this->assignRef('taslak'	  	, $taslak);
			$this->assignRef('tur_id'	  	, $tur_id);
			$this->assignRef('sektorSorumlusu', $isSektorSorumlusu);
			
			$this->assignRef('hazirlayan'  	 , $hazirlayan);
			$this->assignRef('terim'	  	 , $terim);
			$this->assignRef('terimFromModule', $terimFromModule);
			$this->assignRef('meslekStandart', $meslekStandart);
			$this->assignRef('meslekTanitim' , $meslekTanitim);
			$this->assignRef('ekipman' 		 , $ekipman);
			$this->assignRef('bilgiBeceri'	 , $bilgiBeceri);
			$this->assignRef('tutumDavranis' , $tutumDavranis);
			$this->assignRef('gorevAlan'	 , $gorevAlan);
			$this->assignRef('yonetimKurulu' , $yonetimKurulu);
			$this->assignRef('profil'		 , $profil);
            
     		$yonetimKuruluTarihleri = $model->getYonetimKuruluTarihleri (1);
    		$this->assignRef ("yonetimKuruluTarihleri"		, $yonetimKuruluTarihleri);

     		$komiteTarihleri = $model->getKomiteTarihleri ($standart_id);
    		$this->assignRef ("komiteTarihleri"		, $komiteTarihleri);
            
     		$genelKurulTarihleri = $model->getGenelKurulTarihleri ();
    		$this->assignRef ("genelKurulTarihleri"		, $genelKurulTarihleri);
    		
    		$this->assignRef('taslakStandart'		 , $model->getTaslakBilgi($standart_id));
            
		}else{
							
			$user_id = $user->getOracleUserId ();
			if(isset($user_id))
			{	
				$meslekStandart	= $model->getMeslekStandart ($user_id);				
				$this->assignRef('meslekStandart', $meslekStandart);
			}
			else
			{
				$mainframe->redirect('index.php?', $message);
			}
		}
	
		if($layout == 'word' && !empty($standart_id)){
			$bilgi = $model->getStandartRevizyonBilgi($standart_id);
			$standart_bilgileri = $model->getStandartBilgiWord ($standart_id);
			$data = $model->getStandartSeviye($standart_id);
			$kurulusAd = $model->getKurulusAdFromStandartID($standart_id);
			
			$this->assignRef('bilgi', $bilgi);
			$this->assignRef('standart_bilgileri', $standart_bilgileri);
			$this->assignRef('data', $data);
			$this->assignRef('kurulusAd', $kurulusAd);
		}

		
		parent::display($tpl);
	}	
}


?>

