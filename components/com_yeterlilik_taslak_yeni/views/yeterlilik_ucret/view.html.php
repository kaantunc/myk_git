<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewYeterlilik_Ucret extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$message= YETKI_MESAJ;
		$user 	= &JFactory::getUser();
		$user_id= $user->getOracleUserId ();
		$model 	= &$this->getModel();
		$layout	= JRequest::getVar("layout");
		$redirect = 'index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret';
		
		
// 		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
// 		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$canEdit = false;
		if ($aut2 || $aut3){
			$canEdit = true;
// 			$mainframe->redirect('index.php?', $message);
		}
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get('get');
		
		$this->assignRef ("canEdit"	, $canEdit);
		
		if($layout == ""){
			$layout = "default";
		}
		
		$sayfalar=array("kurul_kararno"=>"Bakanlar Kurulu Karar Sayısı","default"=>"Ücret Tarifesi","toplu_zam"=>"Toplu Zam Uygula");
		$sayfaLink='<div style="margin-bottom:20px;">';
			
		foreach ($sayfalar as $key=>$value){
			$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
			if ($key==$layout) {
				$stil.='color:white;background-color:#3C91FF;';
			} else {
				$stil.='background-color:#ffffff;color:black;';
			}
			$stil.='"';
			$sayfaLink .='<a href="index.php?option=com_yeterlilik_taslak_yeni&view=yeterlilik_ucret&layout='.$key.'"'.$stil.'>'.$value.'</a>';
		}
		$sayfaLink.='</div>';
		
		if($layout == "default"){
			if(array_key_exists('sekId', $post) && is_numeric($post['sekId'])){
				$sekId = $post['sekId'];
			}
			
			$yets = $model->getYeterlilik($sekId);
			$this->assignRef('yets', $yets);
			
			$yetUcret = $model->getYetUcret($yets);
			$this->assignRef('yetUcret', $yetUcret);
			
			$sektorler = $model->getYayindakiSektorler();
			$this->assignRef('sektorler', $sektorler);
			$this->assignRef('sekId', $sekId);
			
		}else if($layout == 'yeterlilik_ucret'){
			if(array_key_exists('yetId', $get) && is_numeric($get['yetId'])){
				$yetId = $get['yetId'];
				$this->assignRef('yetId', $yetId);
				$yetUcrets = $model->GetYetUcrets($yetId);
				$this->assignRef('yetUcrets', $yetUcrets);
			}else{
				$mainframe->redirect($redirect, $message);
			}
		}else if($layout == "toplu_zam"){
			$yets = $model->getYeterlilik($sekId);
			$this->assignRef('yets', $yets);
			$yetUcret = $model->getYetUcret($yets);
			$this->assignRef('yetUcret', $yetUcret);
			$sektorler = $model->getYayindakiSektorler();
			$this->assignRef('sektorler', $sektorler);
			$this->assignRef('sekId', $sekId);
		}
			
		$karar_sayi = $model->getBakanlarKuruluSayi();
		$this->assignRef('kararSayilari', $karar_sayi);

		$this->assignRef('sayfaLink', $sayfaLink);
		
		parent::display($tpl);
	}	
}
?>
