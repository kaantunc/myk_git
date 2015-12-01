<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeYetkiViewBelgelendirme_Yetki_Onay extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		/* Bütün Viewlerde Olması Gereken ***************************************************************/
		$user 	 	= &JFactory::getUser();
		$model = JModel::getInstance('Belgelendirme_Yetki','belgelendirmeyetkiModel');
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$group_id   = 27;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		
		
		if(!$aut){
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
        
        $head = array('default'=>'Yetki Onayı','aski'=>'Askıya Alma İşlemleri');
        $pageHeader = '<div class="anaDiv">';
        foreach ($head as $key=>$row){
        	if($layout == $key){
        		$pageHeader .= '<div class="divYan"><a class="btn btn-success" href="#">'.$row.'</a></div>';
        	}else{
        		$pageHeader .= '<div class="divYan"><a class="btn btn-sm btn-primary" href="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki_onay&layout='.$key.'">'.$row.'</a></div>';
        	}
        }
        $pageHeader .= '</div>';
        $this->assignRef('pageHeader', $pageHeader);
        
        
        if($layout == "default"){
        	$kurs = $model->OnayBekleyenKurs();
        	$this->assignRef('kurulus', $kurs);
        }else if($layout == "kurulus_yetki"){
        	if(isset($post['kurulusId']) && !empty($post['kurulusId'])){
        		$kurs = $model->getKurulusBilgi($post['kurulusId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yetkiYets = $model->OnayBekleyenYetsWithKurs($post['kurulusId']);
        		$this->assignRef('yetkiYets', $yetkiYets);
        			
        		$yetkiBirims = $model->getYetkiBirim($post['kurulusId'],$yetkiYets);
        		$this->assignRef('yetkiBirims', $yetkiBirims);
        		
        	}else if(isset($get['kurulusId']) && !empty($get['kurulusId'])){
        		$kurs = $model->getKurulusBilgi($get['kurulusId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yetkiYets = $model->OnayBekleyenYetsWithKurs($get['kurulusId']);
        		$this->assignRef('yetkiYets', $yetkiYets);
        		 
        		$yetkiBirims = $model->getYetkiBirim($get['kurulusId'],$yetkiYets);
        		$this->assignRef('yetkiBirims', $yetkiBirims);
        		
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
        		
        		$yetBirims = $model->getKurulusYetkiliBirimsOnaysiz($get['kurulusId'],$get['yetkiYet']);
        		$this->assignRef('yetBirims', $yetBirims);
        		
        		$denetims = $model->getKurulusDenetim($get['kurulusId']);
        		$this->assignRef('denetims', $denetims);
        	}else{
        		$message = 'Bu sayfayı görüntüleme yetkiniz yoktur.';
        		$mainframe->redirect('index.php', $message,'error');
        	}
        }else if($layout == "aski"){
        	$AskiKur = $model->getAskidakiKuruluslar();
        	$this->assignRef('AskiKur', $AskiKur);
        	
        	$BelKur = $model->getAskiDisiKuruluslar();
        	$this->assignRef('BelKur', $BelKur);
        }
		
		parent::display($tpl);
	}
}

?>