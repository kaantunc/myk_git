<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeViewBelge_Sorgula extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belgelendirme&view=belgelendirme_islemleri";
		$redirectBelge	= "index.php?option=com_belgelendirme&view=sonuc_bildirim";
		$model = JModel::getInstance('belgelendirme_islemleri','belgelendirmeModel');
		
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
		
// 		if (!$aut and !$aut2 and !$aut3)
// 			$mainframe->redirect('index.php?', $message);
		
// 		if ($layout==""){
// 			$mainframe->redirect($redirect.'&layout=belgelendirme_program');
// 		}
		
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
		
		
		//SORGU SONUC
		if ($layout == 'belgeno_sorgu' && isset($get['belgeno'])){
			$bilgi = $model->BelgeKontrol(trim(str_replace(' ','',$get['belgeno'])));
			$this->assignRef('bilgi', $bilgi);
			$this->assignRef('belgeNo', $get['belgeno']);
		}
		else if($layout == 'alternatifs'){
			$yets = $model->getYeterlilikAd();
			$this->assignRef('yets', $yets);
		}
		else if($layout == 'birimtxt'){
			$model->sinavBirimTxt($get);
		}
		else if($layout == 'belge_tarih'){
			$yets = $model->SinavYapilanYeterlilikler();
			$kurs = $model->SinavYapanKuruluslar();
			
			$this->assignRef('kurs', $kurs);
			$this->assignRef('yets', $yets);
		}
		
		$this->assignRef('sayfaLink', $sayfaLink);
		
		parent::display($tpl);
	}
}

?>