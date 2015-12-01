<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
ini_set("dispaly_erros","1");
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeViewBelgelendirme_Islemleri extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belgelendirme&view=belgelendirme_islemleri";
		$model = &$this->getModel();
		$user =& JFactory::getUser();
		$layout		= JRequest::getVar ("layout");
		
		$user_id =  $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id4 = OZEL_KULLANICI_GRUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		$aut4 = FormFactory::checkAuthorization ($user, $group_id4);
		$canEdit = false;
		
		if (!$aut and !$aut2 and !$aut3 and !$aut4)
			$mainframe->redirect('index.php?', $message);
		
		if($aut2 || $aut3 || $user_id == 40){
			$canEdit = true;
		}
		
		if ($layout==""){
			$mainframe->redirect($redirect.'&layout=belgelendirme_program');
		}
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
        $files = JRequest::get( 'files' );

		$sayfalar=array("belgelendirme_degerlendirici"=>"Sınav Değerlendiricileri Yönetimi","belgelendirme_sinav_yeri"=>"Sınav Merkezi İşlemleri","belgelendirme_program"=>"Sınav Programı Düzenleme");
		$sayfaLink='<div style="margin-bottom:20px; float:left; width:70%">';
		foreach ($sayfalar as $key=>$value){
			$stil='style="float:left;border:1px solid #1C617C;margin:2px;padding:5px;';
			if ($key==$layout) {
				$stil.='color:white;background-color:#3C91FF;font-weight:bold;';
			} else {
				$stil.='background-color:#ffffff;color:black;';
			}
			$stil.='"';
			$sayfaLink .='<a href="'.$redirect.'&layout='.$key.'" '.$stil.'>'.$value.'</a>';
		}
		$sayfaLink.='</div><div style="margin-bottom:20px;float:right;width:30%"><a href="libraries/sonm/index.html" target="_blank" style="float:right;border:1px solid #1C617C;margin:2px;padding:5px;color:white;background-color:#3C91FF;font-weight:bold;">Yardım Videosu</a></div>';
		
		if (!$aut and !$aut2 and !$aut3 and !$aut4)
			$mainframe->redirect('index.php?', $message);
		
		
		//SORGU SONUC
		if ($layout == 'belgelendirme_degerlendirici'){
			if(isset($_GET['kurulus']) && $_GET['kurulus'] <> ""){
				$user_id = $_GET['kurulus'];
			}
			
			$kurYets = $model->getYeterlilik($user_id);
			$this->assignRef('kurYets', $kurYets);
			
			$getDeg = $model->getDeger($user_id);
			$this->assignRef('getDegs', $getDeg);
			
			$this->assignRef('canEdit', $canEdit);
				
		}
		else if($layout == 'belgelendirme_program'){
			$kurYets = $model->getYeterlilik($user_id);
			$this->assignRef('kurYets', $kurYets);
			$program = array_key_exists('program',$get)?$get['program']:1;

            $Gelecekprogram = array();
            $Gecmisprogram = array();
            $Yapilmayanprogram = array();
            $IptalProgram = array();
            if($program == 1){
                $Gelecekprogram = $model->getGelecekProgram($user_id,$post);
                $this->assignRef('programsGelecek', $Gelecekprogram);
            }else if($program == 2 || $program == 4){
                $Gecmisprogram = $model->getGecmisProgram($user_id,$post);
                $this->assignRef('programsGecmis', $Gecmisprogram);
            }else if($program == 3){
                $Yapilmayanprogram = $model->getYapilmayanProgram($user_id,$post);
                $this->assignRef('programsYapilmayan', $Yapilmayanprogram);
            }else if($program == 5){
                $IptalProgram = $model->getIptalProgram($user_id,$post);
                $this->assignRef('IptalProgram', $IptalProgram);
            }

			$adayVarMi = $model->getAdayVarmi($user_id);
			$this->assignRef('adayVarmi', $adayVarMi);
		}
		else if($layout == 'belgelendirme_sinav_yeri'){
			if(isset($_GET['kurulus']) && $_GET['kurulus'] <> ""){
				$user_id = $_GET['kurulus'];
			}
			$kurYets = $model->getYeterlilik($user_id);
			$this->assignRef('kurYets', $kurYets);
				
			$belprogram = $model->getProgramSinavYeri($user_id);
			$this->assignRef('programs', $belprogram);
			$this->assignRef('canEdit', $canEdit);
		}
		
		else if($layout == 'aday_bildirim'){
			if(!$canEdit){
				if (!$model->sinavKurulusKontrol($get["sinav"], $user_id)){
					$message = "Bu işlem için yetkiniz yok.";
					$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
				}

                // Sinav Tarihi ve Saati Geçmiş mi Kontrolü Yapılıyor
                if($model->sinavTarihSaatGecmisMi($get['sinav'])){
                    $message = "Bu sınav için aday bildirim süreniz dolmuştur.";
                    $mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
                }
			}
            $this->assignRef('sinavBilgi', $model->getSinavBilgi($get['sinav']));
            $this->assignRef('canEdit', $canEdit);
		}
		else if($layout == 'adaylar'){
			if(!$canEdit){
				if (!$model->sinavKurulusKontrol($get["sinav"], $user_id)){
					$message = "Bu işlem için yetkiniz yok.";
					$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
				}
				
				/*if (!$model->sinavTarihKontrol($get["sinav"], $user_id)){
					$message = "Bildirme tarihi geçmiştir.";
					$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
				}*/

                // Sinav Tarihi ve Saati Geçmiş mi Kontrolü Yapılıyor
                if($model->sinavTarihSaatGecmisMi($get['sinav'])){
                    $message = "Bu sınav için aday bildirim süreniz dolmuştur.";
                    $mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
                }
			}

			$files = JRequest::get( 'files' );
			$adaylar = $model->getAdayExcel($post, $get, $files, $canEdit);
			
			if ($adaylar["hataMesaji"]==""){
				$message = "Bildirdiğiniz adaylar sisteme başarıyla kaydedilmiştir.";
				$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav='.$get["sinav"], $message);
			} else  {
				$this->assignRef('adays', $adaylar);
			}
			// 			$kurYets = $model->getYeterlilik($user_id);
			// 			$this->assignRef('kurYets', $kurYets);
		
			// 			$belprogram = $model->getProgramSinavYeri($user_id);
			// 			$this->assignRef('programs', $belprogram);
		}
		else if($layout == 'adayAra'){
			$post = JRequest::get( 'post' );
			
		}
		else if($layout == 'sonuc_bildir'){
			$get = JRequest::get( 'get' );
			if (!$model->sinavKurulusKontrol($get["sinav"], $user_id)){
				$message = "Bu işlem için yetkiniz yok.";
				$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
			}
                        $this->assignRef('adaySayisi' ,$model->getKayitSayisi($get["sinav"]));
                        $this->assignRef('sinavBilgi', $model->getSinavBilgi($get['sinav']));
		}
		else if($layout == 'sonuclar'){
                    $post = JRequest::get( 'post' );
                    if (!$model->sinavKurulusKontrol($get["sinav"], $user_id)){
                            $message = "Bu işlem için yetkiniz yok.";
                            $mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
                    }

                    $files = JRequest::get( 'files' );
                    $adaylar = $model->getSonucExcel($post, $get, $files);

                    if ($adaylar["hataMesaji"]==""){
                            $message = "Bildirdiğiniz sonuçlar sisteme başarıyla kaydedilmiştir.";
                            $mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=sonuc_bildir&sinav='.$get["sinav"], $message);
                    } else  {
                            $this->assignRef('adays', $adaylar);
                    }
		}
		
		else if($layout == "sonucgor"){
			$sonucs = $model->getSonuclar($post,$get);
			$this->assignRef('sonucs', $sonucs);
		}
		
		else if($layout == "tekbelgeisteme"){
			if(isset($post['yeterlilik_id']) && isset($post['tckn'])){
				$birims = $model->tekSonucGonder($post);
				$this->assignRef('birims', $birims);
			}
			$kurYets = $model->getYeterlilik($user_id);
			$this->assignRef('kurYets', $kurYets);
		}
		
		else if($layout == "aday_bilgileri"){
			
		}else{ 
			$layout = "giris";
			$allKurulus = $model->getAllKurulus(); 
			$this->assign('AllKurulus',$allKurulus);
			$this->assign('type',$_GET['type']); 
			
		}
		
		$excel = $model->geriAdayExcel($user_id,$get["sinav"]);
		$this->assignRef('excelAday', $excel);	
		$this->assignRef('sayfaLink', $sayfaLink);
		
		parent::display($tpl);
	}
}

?>