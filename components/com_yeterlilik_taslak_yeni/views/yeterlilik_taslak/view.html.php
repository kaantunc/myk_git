<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


//$document = &JFactory::getDocument();
//$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/gibTable.js' );
ini_set("display_errors", "1");
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Yeterlilik_TaslakViewYeterlilik_Taslak extends JView
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
			$aktifYetkilendirmesiVarMi = $model->aktifYetkilendirmesiVarMi($yeterlilik_id, $user_id);
			if (!$isSektorSorumlusu && !($isYetkiliKurulus && $aktifYetkilendirmesiVarMi))
			{
				if (!($isYetkiliKurulus && $aktifYetkilendirmesiVarMi))
					$message = "Yetkilendirmeniz Aktif Değil";	
				
				$mainframe->redirect('index.php?', $message, 'error');
			}
			/////////////////////////////////////////////////////////////////////////////////	
		
			$evrak_id	= $model->getOracleEvrakId ($yeterlilik_id);
			$taslak		= $model->isTaslak ($evrak_id);
			$tur_id		= JRequest::getVar("id");
			$yorumDiv_SS= "";
			
			$canEdit	= $model->canEdit ($user, $yeterlilik_id);
			
			$GenelKurulTarihleri = $model->getGenelKurulTarihleri (1);
			$this->assignRef ("genelKurulTarihleri"		, $GenelKurulTarihleri);
				
			$yeterlilik_bilgi	 = $model->getTaslakBilgi ($yeterlilik_id);
			$revizyon_bilgi	 	 = $model->getRevizyonBilgi ($yeterlilik_id,$revizyon_no);
			
			$yeterlilikBilgi  = $model->getYeterlilikBilgi ($yeterlilik_id);
			$taslakYeterlilik = $model->getTaslakYeterlilik ($yeterlilik_id);
			$zorunluBirim	  =	$model->getAltBirim ($yeterlilik_id, ZORUNLU_ALT_BIRIM);
			$zorunluBirimTur  = $model->getAltBirimTur ($zorunluBirim);
			$secmeliBirim	  =	$model->getAltBirim ($yeterlilik_id, SECMELI_ALT_BIRIM);
			$secmeliBirimTur  = $model->getAltBirimTur ($secmeliBirim);
			$sinavsizBirim	  =	$model->getAltBirimSinavsiz ($yeterlilik_id);
			$sinavsizBirimTur = $model->getAltBirimTur ($secmeliBirim);
			$teorikOlcme	  = $model->getDegerlendirmeArac ($yeterlilik_id, TEORIK_OLCME_ARAC_TUR);
			$performansOlcme  = $model->getDegerlendirmeArac ($yeterlilik_id, PERFORMANS_OLCME_ARAC_TUR);
			$bilgi 			  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BILGI);
			$beceri 		  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_BECERI);
			$yetkinlik 		  = $model->getBeceriYetkinlikValues ($yeterlilik_id, YETERLILIK_YETKINLIK);
			$onayliStandart	  = FormParametrik::getMeslekStandart ();
			$onayliAltBirim	  = $model->getOnaylanmisAltBirim ();
			$kaynakMeslek	  = $model->getKaynakValues ($yeterlilik_id, KAYNAK_STANDART_TUR);
			$kaynakBirim	  = $model->getKaynakValues ($yeterlilik_id, KAYNAK_YETERLILIK_TUR);
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
			$yeterlilikInfo  = $model->getYeterlilikInfo($yeterlilik_id);
			$eklenmisBirim = $model->getEklenmisBirim($yeterlilik_id);
			$alternatif = $model->GetAlternatif($yeterlilik_id);
			$yeterlilikDurum = $model->getPmYeterlilikDurumlar();
			$this->assignRef('yeterlilikDurumlari', $yeterlilikDurum);
			$birimTurs = $model->birimsTur($yeterlilik_id);
			$this->assignRef('birimTur', $birimTurs);
			
			
			$pm_YETERLILIK_SUREC_DURUM = $model->getYeterlilikDurum (0);
			$this->assignRef ("pm_YETERLILIK_SUREC_DURUM"	, $pm_YETERLILIK_SUREC_DURUM);
			$pm_YETERLILIK_REVIZYON_SUREC_DURUM = $model->getYeterlilikDurum (1);
			$this->assignRef ("pm_YETERLILIK_REVIZYON_SUREC_DURUM"	, $pm_YETERLILIK_REVIZYON_SUREC_DURUM);
			
// 			$yeterlilikTeorik = $model->yeterlilikTeorik($yeterlilik_id);
// 			$yeterlilikPratik = $model->yeterlilikPratik($yeterlilik_id);
			
			$this->assignRef('alternatif',$alternatif);
			
			if($layout == "yeterlilik_taslak_yeni"){
				
				$this->assignRef ("yeterlilikList"	, $model->yeterlilikList());
				if($yeterlilikBilgi['YENI_MI'] == 0){
					$componentA_modelpath = JPATH_ROOT.DS.'components'.DS.'com_yeterlilik_taslak'.DS.'models';
					JModel::addIncludePath( $componentA_modelpath);
					$yeterlilik_taslak_old =& JModel::getInstance('yeterlilik_taslak_old','Yeterlilik_TaslakModel');
					$zorunluBirim	  =	$yeterlilik_taslak_old->getAltBirim ($yeterlilik_id, ZORUNLU_ALT_BIRIM);
					$zorunluBirimTur  = $yeterlilik_taslak_old->getZorunluBirimTur ($zorunluBirim);
					$secmeliBirim	  =	$yeterlilik_taslak_old->getAltBirim ($yeterlilik_id, SECMELI_ALT_BIRIM);
					$secmeliBirimTur  = $yeterlilik_taslak_old->getZorunluBirimTur ($secmeliBirim);
					
					$eklenmisBirim = $yeterlilik_taslak_old->getEklenmisBirim($yeterlilik_id);
// 					$sinavsizBirim	  =	$yeterlilik_taslak_old->getAltBirimSinavsiz ($yeterlilik_id);
// 					$sinavsizBirimTur = $yeterlilik_taslak_old->getAltBirimTur ($secmeliBirim);
				}
				
				$pageTree 	= $model->getPageTreeYeni ($user, $layout, $evrak_id, $yeterlilik_id);
				$perm = false;
				if($isSektorSorumlusu){
					$perm= true;
				}else{
					if($yeterlilikInfo[0]['YETERLILIK_DURUM_ID'] <> PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK && 
					   $yeterlilikInfo[0]['YETERLILIK_DURUM_ID'] <> PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK && 
					   $yeterlilikInfo[0]['YETERLILIK_DURUM_ID'] <> PM_YETERLILIK_DURUMU__TASLAK &&
					   $yeterlilikInfo[0]['YETERLILIK_DURUM_ID'] <> PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK){
						
						$perm = true;
					}else{
						$perm = false;
					}
				}
				$this->assignRef ("yeterlilik_duzenleme_yetki"	, $perm);
			}else{
				if (!$taslak){ // TASLAK TASLAGI
					$pageTree 	= $model->getPageTree ($user, $layout, $evrak_id, $yeterlilik_id);
					$evrak_tur_id = $model->getEvrakDurumId ($evrak_id);
					$yorum_durum  = $model->getYorumDurumId_SS ($evrak_id);
						
				}else{ // TASLAK
					$pageTree  = $model->getPageTree ($user, $layout, $evrak_id, $yeterlilik_id, 1);
					$yeterlilikDurum = $model->getYeterlilikDurumId ($yeterlilik_id);
						
					$this->assignRef('yeterlilikDurum' , $yeterlilikDurum);
				}	
			}
			
			if (	  $yeterlilikDurum == PM_YETERLILIK_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK
					||$yeterlilikDurum == PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK
					||$yeterlilikDurum == PM_YETERLILIK_DURUMU__TASLAK)
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
			
			if($yeterlilikBilgi['YENI_MI'] == 0){
				for($i=0; $i<count($eklenmisBirim); $i++)
				{
						$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
					
						$biriminEk2si_KontrolListesiz[$i] = $model->getBiriminEk2si_KontrolListesiz($birimID);
							$this->assignRef('biriminEk2si_KontrolListesiz-'.$birimID, $biriminEk2si_KontrolListesiz[$i]);
			
						$biriminEk2si_KontrolListeliTablo1[$i] = $model->getBiriminEk2si_KontrolListeli($birimID, PM_BIRIM_EK2_TIPI__YETKINLIK);
							$this->assignRef('biriminEk2si_KontrolListeli-Tablo1-'.$birimID, $biriminEk2si_KontrolListeliTablo1[$i]);
						
							$biriminEk2si_KontrolListeliTablo2[$i] = $model->getBiriminEk2si_KontrolListeli($birimID, PM_BIRIM_EK2_TIPI__ANLAYIS);
							$this->assignRef('biriminEk2si_KontrolListeli-Tablo2-'.$birimID, $biriminEk2si_KontrolListeliTablo2[$i]);
							
						$biriminTeorikSinavlari[$i] = $yeterlilik_taslak_old->getBiriminOlcmeDegerlendirmeleri($birimID, PM_OLCME_DEGERLENDIRME_TIPI__TEORIK_SINAV);
						if($biriminTeorikSinavlari[$i] != null )
							$this->assignRef('biriminTeorikSinavlari-'.$birimID, $biriminTeorikSinavlari[$i]);
								
						$biriminPerformansSinavlari[$i] = $yeterlilik_taslak_old->getBiriminOlcmeDegerlendirmeleri($birimID, PM_OLCME_DEGERLENDIRME_TIPI__PERFORMANS_SINAVI);
						if($biriminPerformansSinavlari[$i] != null )
							$this->assignRef('biriminPerformansSinavlari-'.$birimID, $biriminPerformansSinavlari[$i]);
							
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
			}else{
				
				$gelistiren_kurulus = $model->getKurulusValues ($yeterlilik_id, YET_GELISTIREN_KURULUS);
				
				$kayitliBirimTur = $model->kayitliBirimTur($yeterlilik_id);
				$this->assignRef('kayitliBirimTur', $kayitliBirimTur);
				
				for($i=0; $i<count($eklenmisBirim); $i++)
				{
					$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
			
					$this->assignRef('yerineGecerliBirimList-'.$birimID	, $model->yerineGecerliBirimList($birimID));
					
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
			}
			
			$this->assignRef('birimEk2Turleri', $model->getPMBirimEk2Turleri());
			$this->assignRef('genelKurul', $model->getGenelKurul());
			$this->assignRef('distinctGenelKurul', $model->getDistinctGenelKurul());
			$this->assignRef('yeterliligeKaynakTeskilEdenler', $model->getYeterlilikKaynagi($yeterlilik_id));
			
			
			$birimlerleDetaylari = $model->getBirimlerleDetaylari($yeterlilik_id);
			$this->assignRef('birimlerleDetaylari', $birimlerleDetaylari);
			$this->assignRef('YeterlilikKaynagindanKurulus', $model->getYeterlilikKaynagindanKurulusValues($yeterlilik_id));
			$this->assignRef('seviyeler', $model->getSeviyeValues());
			$this->assignRef('sektorler', $model->getSektorValues());
			$this->assignRef('bagimliBirimlerOlanSektorler', $model->getBagimliBirimlerOlanSektorValues());
			
			$this->assignRef('ek2Terimleri', $model->getEk2Tablosu($yeterlilik_id));
			$this->assignRef('ek5Tablosu', $model->getEk5Tablosu($yeterlilik_id));
			$this->assignRef('ek6Tablosu', $model->getEk6Tablosu($yeterlilik_id));
			$this->assignRef('yeterlilik' , $yeterlilikInfo);
			$this->assignRef('evrak_id'	  		, $evrak_id);
			$this->assignRef('yeterlilik_id'	, $yeterlilik_id);
			$this->assignRef('pageTree'	  		, $pageTree);
			$this->assignRef('tur_id'	  		, $tur_id);
			$this->assignRef('yorumDiv'	  		, $yorumDiv_SS);
			$this->assignRef('canEdit'	  		, $canEdit);
			$this->assignRef('sektorSorumlusu' 	, $isSektorSorumlusu);
			$this->assignRef('taslak' 			, $taslak);

			$this->assignRef('yeterlilikBilgi'	, $yeterlilikBilgi);
			$this->assignRef('taslakYeterlilik'	, $taslakYeterlilik);
			$this->assignRef('zorunluBirim'	  	, $zorunluBirim);
			$this->assignRef('zorunluBirimTur'	  	, $zorunluBirimTur);
			$this->assignRef('secmeliBirim'	  	, $secmeliBirim);
			$this->assignRef('secmeliBirimTur'	  	, $secmeliBirimTur);
			$this->assignRef('sinavsizBirim'	  	, $sinavsizBirim);
			$this->assignRef('sinavsizBirimTur'	  	, $sinavsizBirimTur);
			$this->assignRef('eklenmisBirim'	, $eklenmisBirim);
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
			$this->assignRef ("yeterlilik_bilgi"	, $yeterlilik_bilgi);
			$this->assignRef ("revizyon_bilgi"		, $revizyon_bilgi);
			$this->assignRef('yeterliliginSektoru', $model->getYeterliliginSektoru($yeterlilik_id));
			
			
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
