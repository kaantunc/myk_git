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
		
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$canEdit = false;
		if($aut2 || $aut3){
			$canEdit = true;
		}

		if (!isset ($layout)){
			//$layout = "denetim_listele";
			$layout = "kurulus_denetim";
			$this->setLayout($layout);
		}
		
		
		$this->assignRef('denetimListesi', $model->getDenetimListesi(isset($_GET['kid'])?$_GET['kid']:0));
		$this->assignRef('denetimlerim', $model->getDenetimlerim());
		$this->assignRef('bagliOldugumDenetimler', $model->getBagliOldugumDenetimler());
        $this->assignRef('AkIcDenetimListesi', $model->getAkIcDenetimEkleri(isset($_GET['kid'])?$_GET['kid']:0));
		
		$this->assignRef('kurulusDenetim', $model->getKurulusDenetim());
		
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
			
			$this->assignRef('denetimRapor', $model->getDenetimRapor($denetim_id));
			$this->assignRef('kurulus', $model->getKurulusFromDenetimID($denetim_id));
			$this->assignRef('denetimRaporOnay', $model->getDenetimRaporOnay($denetim_id));
			
			if($seciliDenetim['DENETIM_TURU'] == 1 || $seciliDenetim['DENETIM_TURU'] == 2){
			
				$this->assignRef('sinavYetkisiVerilecekBirimler', $model->getSinavYetkisiVerilecekBirimler($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiVerilecekBirimler_EskiFormattakiYeterlilik', $model->getSinavYetkisiVerilecekBirimler_EskiFormattakiYeterlilikler($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				
				$this->assignRef('sinavYetkisiVerilecekBirimIDleri', $model->getSinavYetkisiVerilecekBirimIDleri($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiVerilmisBirimler', $model->getSinavYetkisiVerilmisBirimler($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiVerilmisBirimler_Detaylariyla', $model->getSinavYetkisiVerilmisBirimler_Detaylariyla($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiVerilmisBirimler_Detaylariyla_EskiFormattakiYeterlilikler', $model->getSinavYetkisiVerilmisBirimler_Detaylariyla_EskiFormattakiYeterlilikler($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				
				$this->assignRef('sinavYetkisiVerilmisBirimlerVeYetkiTarihleri', $model->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiVerilmisBirimlerVeYetkiTarihleriFarkliDenetim', $model->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleriFarkliDenetim($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiAlinmisBirimlerVeYetkiTarihleri', $model->getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
					
				$this->assignRef('sinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten', $model->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterliliktenFarkliDenetim', $model->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterliliktenFarkliDenetim($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
				$this->assignRef('sinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten', $model->getSinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten($seciliDenetim['DENETIM_KURULUS_ID'],$denetim_id));
					
				$this->assignRef('buDenetimDisindaYetkilendirilmisBirimler', $model->getBuDenetimDisindaSinavYetkisiVerilmisBirimler($seciliDenetim['DENETIM_KURULUS_ID'], $denetim_id));
				
				// Denetim Sınav Yeri //M_SINAV_MERKEZI
				$SMerkez = $model->getDenetimBasvurudakiSinavYerleri($seciliDenetim['DENETIM_KURULUS_ID'], $denetim_id,1);
				$this->assignRef('SMerkez', $SMerkez);
				
				// Denetim Yeterlilik
				$Yet = $model->getDenetimBasvurudakiYeterlilik($seciliDenetim['DENETIM_KURULUS_ID'], $denetim_id,1);
				$this->assignRef('Yet', $Yet);
			}
			else{
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
					
				$this->assignRef('buDenetimDisindaYetkilendirilmisBirimler', $model->getBuDenetimDisindaSinavYetkisiVerilmisBirimler($seciliDenetim['DENETIM_KURULUS_ID']));
				
				// Denetim Sınav Yeri //M_SINAV_MERKEZI
				$SMerkez = $model->getDenetimBasvurudakiSinavYerleri($seciliDenetim['DENETIM_KURULUS_ID'], $denetim_id,0);
				$this->assignRef('SMerkez', $SMerkez);
				
				// Denetim Yeterlilik
				$Yet = $model->getDenetimBasvurudakiYeterlilik($seciliDenetim['DENETIM_KURULUS_ID'], $denetim_id,0);
				$this->assignRef('Yet', $Yet);
			}
			
			$urlPath = "index.php?option=com_denetim";
			$sayfalar=array("denetim_ekibi"=>"Denetim İçerik","denetim_yeterlilik"=>"Sınavı İzlenen Yeterlilikler",
					"denetim_sinavyeri"=>"Denetlenen Sinav Yerleri","rapor_aktar"=>"Denetim Raporu","uygunsuzluk_listele"=>"Uygunsuzluk",
					"yetkilendirme"=>"Yetki Ver","yetki_kapsami"=>"Yetki Kapsamı","kod_duzenle"=>"Yetkilendirme Kodu");
			
			$sayfaLink = "";
			if($canEdit && array_key_exists($layout, $sayfalar)){
				
				$sayfaLink='<div style="margin-bottom:20px;">';
				foreach ($sayfalar as $key=>$value){
					$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
					if ($key==$layout) {
						$stil.='color:white;background-color:#3C91FF;font-weight:bold;';
					} else {
						$stil.='background-color:#ffffff;color:black;';
					}
					$stil.='"';
					if($key == "yetkilendirme" || $key == "yetki_kapsami"){
						$sayfaLink .='<a target="_blank" href="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki&kurulusId='.$seciliDenetim['DENETIM_KURULUS_ID'].'" '.$stil.'>'.$value.'</a>';
					}else{
						$sayfaLink .='<a href="'.$urlPath.'&layout='.$key.'&denetim_id='.$denetim_id.'" '.$stil.'>'.$value.'</a>';
					}
				}
				$sayfaLink.='</div>';
					
			}
			
			if(!$canEdit && ($layout != 'denetim_planim' && $layout != 'yetki_kapsami' && $layout != 'uygunsuzluk_listele' )){
				$mainframe->redirect('index.php?option=com_denetim');
			}
			$this->assignRef('sayfaLink', $sayfaLink);
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