<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class KurulusAraViewKurulus_Ara extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		/* Bütün Viewlerde Olması Gereken ***************************************************************/
		$model = JModel::getInstance('Kurulus_Ara','kurulusaraModel');
		$layout		= JRequest::getVar ("layout");
		$redirect = "index.php?option=com_kurulus_ara&view=kurulus_ara";
// 		$user 	 	= &JFactory::getUser();
// 		$user_id	= $user->getOracleUserId ();
// 		$group_id   = T3_GROUP_ID;
// 		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
// 		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
// 		$message   	= YETKI_MESAJ;
// 		$aut = FormFactory::checkAuthorization  ($user, $group_id);
// 		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
// 		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
// 		if(!$aut3){
// 			$message = 'Bu sayfayı görüntüleme yetkiniz yoktur.';
// 			$mainframe->redirect('index.php', $message,'error');
// 		}
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get('get');
        $file = JRequest::get('files');
		
        if (!isset ($layout)){
        	$layout = "default";
        	$this->setLayout($layout);
        }
        /* Bütün Viewlerde Olması Gereken SON ***********************************************************/
        if(isset($get['kurId']) && !empty($get['kurId'])){
	        $sayfalar=array("kurulus"=>"Kuruluş Bilgileri","kurulus_kapsam"=>"Yetki Kapsamı","kurulus_tarife"=>"Ücret Tarifesi");
	        $sayfaLink='<div style="margin-bottom:20px; width:100%">';
	        foreach ($sayfalar as $key=>$value){
	        	$stil='style="border:1px solid #1C617C;margin:2px;padding:8px;font-size:14px;';
	        	if ($key==$layout) {
	        		$stil.='color:white;background-color:#3C91FF;font-weight:bold;';
	        	}else {
	        		$stil.='background-color:#ffffff;color:black;';
	        	}
	        	$stil.='"';
				$sayfaLink .='<a href="'.$redirect.'&layout='.$key.'&kurId='.$get['kurId'].'" '.$stil.'>'.$value.'</a>';
	        }
	        $sayfaLink.='</div>';
	        $this->assignRef('sayfaLink', $sayfaLink);
        }
        
        if($layout == "default"){
        	$sektors = FormFactory::getBelgeliSektors();
        	
        	$yets = $model->GetAllYeterlilik();
        	
        	if(isset($post['sektor']) && is_numeric($post['sektor']) && isset($post['yets']) && is_numeric($post['yets'])){
        		$kurs = $model->getKuruluslarWithSektorAndYets(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS,$post);
        		$this->assignRef('kurs', $kurs);
        		$this->assignRef('sek', $post['sektor']);
        		$this->assignRef('yet', $post['yets']);
        		$yets = $model->GetAllYeterlilik($post['sektor']);
        	}else{
        		$kurs = $model->getKuruluslar(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
        		$this->assignRef('kurs', $kurs);
        		$yet = 0;
        		$sek = 0;
        		$this->assignRef('sek', $sek);
        		$this->assignRef('yet', $yet);
        	}
        	
        	$this->assignRef('sektors', $sektors);
        	$this->assignRef('yets', $yets);
        	
        }else if($layout == "kurulus"){
        	if(isset($get['kurId']) || !empty($get['kurId']) && is_numeric($get['kurId'])){
	        	$kurs = $model->getKurulus($get['kurId']);
	        	$this->assignRef('kurs', $kurs);
	        	
	        	$yetTarih = $model->YetkiTarihi($get['kurId']);
	        	$this->assignRef('yetTarih', $yetTarih);
        	}
        	else{
        		$mainframe->redirect('index.php?option=com_kurulus_ara&view=kurulus_ara');
        	}
        }else if($layout == "kurulus_kapsam"){
        	if(isset($get['kurId']) && !empty($get['kurId']) && is_numeric($get['kurId'])){
        		$kurs = $model->getKurulus($get['kurId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yetId = "0";
        		if(isset($get['yetId']) && !empty($get['yetId']) && is_numeric($get['yetId'])){
        			$yetId = $get['yetId'];
        		}
        		$this->assignRef('yetId', $yetId);
        		
        		$yetkiYets = $model->getYetYetki($get['kurId'],$yetId);
        		$this->assignRef('yetkiYets', $yetkiYets);
        		
        		$SelectYets = $model->getYetYetki($get['kurId']);
        		$this->assignRef('SelectYets', $SelectYets);
        		 
        		$yetkiBirims = $model->getYetkiBirim($get['kurId'],$yetkiYets);
        		$this->assignRef('yetkiBirims', $yetkiBirims);
        	}
        	else{
        		$mainframe->redirect('index.php?option=com_kurulus_ara&view=kurulus_ara');
        	}
        }else if($layout == "kurulus_tarife"){
        if(isset($get['kurId']) && !empty($get['kurId']) && is_numeric($get['kurId'])){
        		$kurs = $model->getKurulus($get['kurId']);
        		$this->assignRef('kurs', $kurs);
        		
        		$yetId = "0";
        		if(isset($get['yetId']) && !empty($get['yetId']) && is_numeric($get['yetId'])){
        			$yetId = $get['yetId'];
        		}
        		$this->assignRef('yetId', $yetId);
        		
        		$yetkiYets = $model->getYetYetkiTarife($get['kurId'],$yetId);
        		$this->assignRef('yetkiYets', $yetkiYets);
        		
        		$SelectYets = $model->getYetYetkiTarife($get['kurId']);
        		$this->assignRef('SelectYets', $SelectYets);
        		 
        		$yetkiBirims = $model->getYetkiBirimTarif($get['kurId'],$yetkiYets);
        		$this->assignRef('yetkiBirims', $yetkiBirims);
        		
        		$detay = $model->UcretDetay($get['kurId']);
        		$this->assignRef('detay', $detay);
        	}
        	else{
        		$mainframe->redirect('index.php?option=com_kurulus_ara&view=kurulus_ara');
        	}
        }
		
		parent::display($tpl);
	}
}

?>