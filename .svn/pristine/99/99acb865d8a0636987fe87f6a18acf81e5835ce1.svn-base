<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeViewEski_Sinav extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belgelendirme&view=eski_sinav";
		$model = JModel::getInstance('eski_sinav','belgelendirmeModel');
		
		$user =& JFactory::getUser();
		$layout		= JRequest::getVar ("layout");
		
		$user_id =  $user->getOracleUserId ();
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		if (!$aut2 and !$aut3){
			$mainframe->redirect('index.php', $message, 'error');
		}
		
		if ($layout==""){
			$layout = 'default';
		}
		
		$this->assignRef('yeterlilikler', FormFactory::getYayindakiYetlilikler());
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
// 		$sayfalar=array("aday_bildirim"=>"Belgelendirilecek Adaylar","belgeno_bildirim"=>"Aday Belge Numarası");
// 		$sayfaLink='<div style="margin-bottom:20px;">';
		
// 		foreach ($sayfalar as $key=>$value){
// 			$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
// 			if ($key==$layout) {
// 				$stil.='color:white;background-color:#3C91FF;';
// 			} else {
// 				$stil.='background-color:#ffffff;color:black;';
// 			}
// 			$stil.='"';
// 			$sayfaLink .='<span '.$stil.'>'.$value.'</span>';
// 		}
// 		$sayfaLink.='</div>';
		
		if($layout == 'aday_yeter'){
			if(isset($post['yetSelect']) && isset($post['Kimlik'])){
				$kimlik = $post['Kimlik'];
				$yetId = $post['yetSelect'];
			}else if(isset($get['yetSelect']) && isset($get['Kimlik'])){
				$kimlik = $get['Kimlik'];
				$yetId = $get['yetSelect'];
			}
			
			if((!isset($kimlik) && !isset($yetId)) || $yetId == 0){
				$message = 'Gerekli alanları doldurmadan bu alana geçiş yapamazsınız.';
				$mainframe->redirect($redirect, $message, 'error');
			}else{
				$aday = $model->getAdayVarmi($kimlik);
				if($aday){
					$basBirims = $model->getAdayBasariliBirims($kimlik,$yetId);
					$yetBirims = $model->getYeterlilikBirims($yetId);
					$kurulus = $model->getKurulus();
					$yeterlilik = $model->getYeterlilik($yetId);
					$this->assignRef('basBirims', $basBirims);
					$this->assignRef('yetBirims', $yetBirims);
					$this->assignRef('kurulus', $kurulus);
					$this->assignRef('yeterlilik', $yeterlilik);
					$this->assignRef('aday', $aday);
					
				}else{
					$message = $kimlik.' kimlik numaralı kişi sistemde yer almamaktadır.';
					$mainframe->redirect($redirect, $message, 'error');
				}
			}
		}
		
		$this->assignRef('sayfaLink', $sayfaLink);
		
		parent::display($tpl);
	}
}

?>