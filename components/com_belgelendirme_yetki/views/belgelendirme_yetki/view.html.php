<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeYetkiViewBelgelendirme_Yetki extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		/* Bütün Viewlerde Olması Gereken ***************************************************************/
		$user 	 	= &JFactory::getUser();
		$model = JModel::getInstance('Belgelendirme_Yetki','belgelendirmeyetkiModel');
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		if(!$aut3){
			$message = 'Bu sayfayı görüntüleme yetkiniz yoktur.';
			$mainframe->redirect('index.php', $message,'error');
		}
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get('get');
        $file = JRequest::get('files');
		
        if (!isset ($layout)){
        	$layout = "default";
        	$this->setLayout($layout);
        }
        /* Bütün Viewlerde Olması Gereken SON ***********************************************************/
        
        if($layout == "default"){
        	$kurs = $model->getKurulus(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
        	$this->assignRef('kurulus', $kurs);
        }else if($layout == "kurulus_yetki"){
        	if(isset($post['kurulusId']) && !empty($post['kurulusId'])){
        		$kurs = $model->getKurulusBilgi($post['kurulusId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yetkiYets = $model->getYetYetki($post['kurulusId']);
        		$this->assignRef('yetkiYets', $yetkiYets);
        			
        		$yetkiBirims = $model->getYetkiBirim($post['kurulusId'],$yetkiYets);
        		$this->assignRef('yetkiBirims', $yetkiBirims);
        			
        		$yets = $model->yetkiDisiYets($post['kurulusId']);
        		$this->assignRef('yets', $yets);
        		
        	}else if(isset($get['kurulusId']) && !empty($get['kurulusId'])){
        		$kurs = $model->getKurulusBilgi($get['kurulusId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yetkiYets = $model->getYetYetki($get['kurulusId']);
        		$this->assignRef('yetkiYets', $yetkiYets);
        		 
        		$yetkiBirims = $model->getYetkiBirim($get['kurulusId'],$yetkiYets);
        		$this->assignRef('yetkiBirims', $yetkiBirims);
        		 
        		$yets = $model->yetkiDisiYets($get['kurulusId']);
        		$this->assignRef('yets', $yets);
        		
        	}else{
        		$message = 'Bu sayfayı görüntüleme yetkiniz yoktur.';
        		$mainframe->redirect('index.php', $message,'error');
        	}
        	
        }else if($layout == "kurulus_yeni_yetki"){
        	if((isset($post['kurulusId']) && !empty($post['kurulusId'])) && (isset($post['yetkiYet']) && !empty($post['yetkiYet']))){
        		$kurs = $model->getKurulusBilgi($post['kurulusId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yets = $model->getYeterlilik($post['yetkiYet']);
        		$this->assignRef('yeterlilik', $yets);
        		
        		$yetBirims = $model->getYeterlilikBirims($post['yetkiYet']);
        		$this->assignRef('yetBirims', $yetBirims);
        		
        		$denetims = $model->getKurulusDenetim($post['kurulusId']);
        		$this->assignRef('denetims', $denetims);
        	}else{
        		$message = 'Bu sayfayı görüntüleme yetkiniz yoktur.';
        		$mainframe->redirect('index.php', $message,'error');
        	}
        }else if($layout == "kurulus_yetki_duzenle"){
        	if((isset($get['kurulusId']) && !empty($get['kurulusId'])) && (isset($get['yetkiYet']) && !empty($get['yetkiYet']))){
        		$kurs = $model->getKurulusBilgi($get['kurulusId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yets = $model->getYeterlilik($get['yetkiYet']);
        		$this->assignRef('yeterlilik', $yets);
        		
        		$Birims = $model->getYeterlilikBirims($get['yetkiYet']);
        		$this->assignRef('birims', $Birims);
        		
        		$yetBirims = $model->getKurulusYetkiliBirims($get['kurulusId'],$get['yetkiYet']);
        		$this->assignRef('yetBirims', $yetBirims);
        		
        		$denetims = $model->getKurulusDenetim($get['kurulusId']);
        		$this->assignRef('denetims', $denetims);
        		
        		$OnayBekleyen = $model->getOnayBekleyen($get['kurulusId'],$get['yetkiYet']);
        		$this->assignRef('OnayBekleyen', $OnayBekleyen);
        	}else{
        		$message = 'Bu sayfayı görüntüleme yetkiniz yoktur.';
        		$mainframe->redirect('index.php', $message,'error');
        	}
        }
		
		parent::display($tpl);
	}
}

?>