<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class MatbaaViewTekrar_Basim extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_matbaa&view=tekrar_basim";
		//$model = JModel::getInstance('belgelendirme_islemleri','belgelendirmeModel');
		$model 	  	= &$this->getModel();
		
		$user =& JFactory::getUser();
		$layout		= JRequest::getVar ("layout");
		
		$user_id =  $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		$matbaaGrup = FormFactory::checkAuthorization ($user, 26);
		$kurulusMu = false;
		
		if (!$aut2 and !$aut3 and !$matbaaGrup){
			$kurulusMu = true;
			$this->assignRef('kurulusMu', $kurulusMu);
		}
		
// 		if ($layout==""){
// 			$mainframe->redirect($redirect.'&layout=belgelendirme_program');
// 		}
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		$sayfalar=array("basilacak"=>"Basılacak Belgeler","basilan"=>"Basılmış Belgeler","gonderilen"=>"Gönderilmiş Belgeler");
		$sayfaLink='<div style="margin-bottom:20px;">';
		
		foreach ($sayfalar as $key=>$value){
			$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
			if ($key==$layout) {
				$stil.='color:white;background-color:#3C91FF;';
			} else {
				$stil.='background-color:#ffffff;color:black;';
			}
			$stil.='"';
			$sayfaLink .='<a href="'.$redirect.'&layout='.$key.'" '.$stil.'>'.$value.'</a>';
		}
		$sayfaLink.='</div>';
		
		$canEdit=true;
		
		if($matbaaGrup || $user_id == 40){
			$this->assignRef('canEdit', $canEdit);
		}
		
		
		//SORGU SONUC
		if ($layout == 'basilacak'){
			if($kurulusMu){
				$basilacak = $model->BasilacakBelgeler(1,$user_id);
			}else{
				$basilacak = $model->BasilacakBelgeler(1);
				
				$kuruluslar = $model->getKuruluslar(1);
				$yeterlilikler = $model->getYeterlilikler(1);
				$this->assignRef('getKur', $kuruluslar);
				$this->assignRef('getYet', $yeterlilikler);
			}
			$this->assignRef('basilacak', $basilacak);
		}
		else if ($layout == 'basilan'){
			if($kurulusMu){
				$basilacak = $model->BasilacakBelgeler(2,$user_id);
			}else{
				$basilacak = $model->BasilacakBelgeler(2);
				$kuruluslar = $model->getKuruluslar(2);
				$yeterlilikler = $model->getYeterlilikler(2);
				$this->assignRef('getKur', $kuruluslar);
				$this->assignRef('getYet', $yeterlilikler);
			}
			$this->assignRef('basilacak', $basilacak);
		}
		else if ($layout == 'gonderilen'){
			if($kurulusMu){
				$basilacak = $model->BasilacakBelgeler(3,$user_id);
			}else{
				$basilacak = $model->BasilacakBelgeler(3);
				$kuruluslar = $model->getKuruluslar(3);
				$yeterlilikler = $model->getYeterlilikler(3);
				$this->assignRef('getKur', $kuruluslar);
				$this->assignRef('getYet', $yeterlilikler);
			}
			$this->assignRef('basilacak', $basilacak);
		}
		else if($layout == 'matbaaBelge'){
			$basimId = $get['basimId'];
			$belgeExcel = $model->getAdayBelgeExcel($basimId);
			$this->assignRef('belgeAdayExcel', $belgeExcel);
		}
		else if($layout == 'zip'){
			$this->assignRef('basimId', $get['basimId']);
		}
		else if($layout == 'kurulus_bilgi'){
			$model->getKurulus();
		}
		
		$this->assignRef('sayfaLink', $sayfaLink);
		
		parent::display($tpl);
	}
}

?>