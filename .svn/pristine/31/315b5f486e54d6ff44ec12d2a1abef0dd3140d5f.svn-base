<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Sertifika_SorgulaViewSertifika_Sorgula extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$user 	 	= &JFactory::getUser();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id4 = YT3_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory2::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory2::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory2::checkAuthorization ($user, $group_id3);
		$aut4 = FormFactory2::checkAuthorization ($user, $group_id4);
		$user_id	= $user->getOracleUserId ();
		
		$redirect	= "index.php?option=com_sertifika_sorgula&view=sertifika_sorgula";
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$kimlik_no 	= $_POST["kimlik_no"];
		if($_GET['tarih']){
			$tarih = $_GET['tarih'];
		}
		else{
			$tarih = $_POST["tarih"];
		}
		if($_GET['userId']){
			$kurulus = $_GET['userId'];
		}
		else if(!empty($_POST["kurulus_id"]) || $aut2 || $aut3){
			$kurulus = $_POST["kurulus_id"];
		}
		else if($aut || $aut4){
			$kurulus = $user_id;
		}
		
		$yeterlilik = $_POST["yet_id"];
		
		//SORGU SONUC
		if (isset($layout) && $layout == "sorgu_sonuc"){
			//Captcha
			if($user_id == null || empty($user_id)){
				captcha::check($redirect);
			}
			//Kimlik No
			if(empty($kimlik_no) && empty($kurulus) && empty($tarih) && empty($yeterlilik)){
				JError::raiseWarning( 100, "Lütfen Gerekli Alanlardan En Az Birini Doldurunuz." );
				$mainframe->redirect($redirect);
			}
			//hepsi varsa
			else if(!empty($kimlik_no) && !empty($kurulus) && !empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByHepsi($kimlik_no, $kurulus, $tarih, $yeterlilik);
				$this->assignRef('data'	, $data);
			}
			//tc_kimlik+kurulus+tarih
			else if(!empty($kimlik_no) && !empty($kurulus) && !empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByTCKURTAR($kimlik_no, $kurulus, $tarih);
				$this->assignRef('data'	, $data);
			}
			//tc_kimlik+kurulus+yet_id
			else if(!empty($kimlik_no) && !empty($kurulus) && empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByTCKURYET($kimlik_no, $kurulus, $yeterlilik);
				$this->assignRef('data'	, $data);
			}
			//tc_kimlik+tarih+yet_id
			else if(!empty($kimlik_no) && empty($kurulus) && !empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByTCTARYET($kimlik_no, $tarih, $yeterlilik);
				$this->assignRef('data'	, $data);
			}
			//kurulus+tarih+yet_id
			else if(empty($kimlik_no) && !empty($kurulus) && !empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByKURTARYET($kurulus, $tarih, $yeterlilik);
				$this->assignRef('data'	, $data);
			}
			//kurulus+yet_id
			else if(empty($kimlik_no) && !empty($kurulus) && empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByKURYET($kurulus, $yeterlilik);
				$this->assignRef('data'	, $data);
			}
			//kurulus+tarih
			else if(empty($kimlik_no) && !empty($kurulus) && !empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByKURTAR($kurulus, $tarih);
				$this->assignRef('data'	, $data);
			}
			//kurulus+tc_kimlik
			else if(!empty($kimlik_no) && !empty($kurulus) && empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByKURTC($kurulus, $kimlik_no);
				$this->assignRef('data'	, $data);
			}
			//yet_id+tarih
			else if(empty($kimlik_no) && empty($kurulus) && !empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByYETTAR($yeterlilik, $tarih);
				$this->assignRef('data'	, $data);
			}
			//yet_id+tc_kimlik
			else if(!empty($kimlik_no) && empty($kurulus) && empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByYETTC($yeterlilik, $kimlik_no);
				$this->assignRef('data'	, $data);
			}
			//tarih+tc_kimlik
			else if(!empty($kimlik_no) && empty($kurulus) && !empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByTARTC($tarih, $kimlik_no);
				$this->assignRef('data'	, $data);
			}
			//sadece yeterlilik
			else if(empty($kimlik_no) && empty($kurulus) && empty($tarih) && !empty($yeterlilik)){
				$data = $model->getBelgeDataByYeterlilik($yeterlilik);
				$this->assignRef('data'	, $data);
			}
			//sadece tarih
			else if(empty($kimlik_no) && empty($kurulus) && !empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByTarih($tarih);
				$this->assignRef('data'	, $data);
			}
			//sadece kurulus
			else if(empty($kimlik_no) && !empty($kurulus) && empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByKurulus($kurulus);
				$this->assignRef('data'	, $data);
			}
			//sadece tc_kimlik
			else if(!empty($kimlik_no) && empty($kurulus) && empty($tarih) && empty($yeterlilik)){
				$data = $model->getBelgeDataByTcKimlikNo($kimlik_no);
				$this->assignRef('data'	, $data);
			}
		}
		$session =&JFactory::getSession();
		$session->set('data', $data);
		
		$kuruluslar = $model->getKurulus();
		$yeterlilikler = $model->getYeterlilik();
		
		$this->assignRef('kuruluslar'  , $kuruluslar);
		$this->assignRef('yeterlilik'  , $yeterlilikler);
		$kullanici1 = 1;
		$kullanici2 = 2;
		$kullanici3 = 3;
		
		if($aut || $aut4){
			$this->assignRef('user' , $kullanici1);
		}
		else if($aut2 || $aut3){
			$this->assignRef('user'  , $kullanici2);
		}
		else{
			$this->assignRef('user'  , $kullanici3);
		}
		
		parent::display($tpl);
	}
}

?>