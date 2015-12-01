<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Tesvik_AbhibeViewTesvik extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		/* Bütün Viewlerde Olması Gereken ***************************************************************/
		$model = JModel::getInstance('Tesvik_Abhibe','Tesvik_AbhibeModel');
		$layout		= JRequest::getVar ("layout");
		$redirect = "index.php?option=com_tesvik_abhibe&view=tesvik";
		$user 	 	= &JFactory::getUser();
		$user_id	= $user->getOracleUserId();
		
		$userGroup = $model->UserKimGrup($user_id);

		if(!$userGroup){
			$mainframe->redirect("index.php",'Bu alanı görme yetkiniz yoktur.','error');
		}
		$this->assignRef('UserGroup', $userGroup);
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		if (!isset ($layout)){
			$layout = "default";
			$this->setLayout($layout);
		}
		
		if($layout == "default"){
			//$tehlikeliYeterlilik = FormFactory::tehlikeliYeterlilik();
			$tesvikIstek = $model->TesvikIstekleri();
			$this->assignRef('tesvikIstek', $tesvikIstek);
			$tesvikIstekAday = $model->TesvikIstekleriUser($tesvikIstek);
			$this->assignRef('tesvikIstekAday', $tesvikIstekAday);
			$TesvikIstekUser = $model->TesvikIstekUsers($tesvikIstek);
			$this->assignRef('IstekUser', $TesvikIstekUser);
			$TesvikImzaUser = $model->TesvikImzaUsers($tesvikIstek);
			$this->assignRef('ImzaUser', $TesvikImzaUser);
			$TesvikImzaUserArray = $model->TesvikImzaUsersArray();
			$this->assignRef('ImzaUserArray', $TesvikImzaUserArray);
			$TesvikImzaUserName = $model->TesvikImzaUserName();
			$this->assignRef('TesvikImzaUserName', $TesvikImzaUserName);
			$TesvikTamamlanan = $model->TesvikOdenenVeSonuc($tesvikIstek);
			$this->assignRef('TesvikTamamlanan', $TesvikTamamlanan);
			$this->assignRef('user_id', $user_id);
		}else if($layout == "tesvik_adaylar"){
			if(array_key_exists('bitTarih', $post)){
				if(!empty($post['bitTarih'])){
					$TesvikAdaylar = $model->TesvikAdaylarWithTarih(null,$post['bitTarih']);
					$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
// 					$this->assignRef('basTarih', $post['basTarih']);
					$this->assignRef('bitTarih', $post['bitTarih']);
				}else{
					$mainframe->redirect($redirect,'Lütfen Tarih Alanını Boş Bırakmayınız.','error');
				}
			}else{
				$mainframe->redirect($redirect,'Lütfen Tarih Alanını Boş Bırakmayınız.','error');
			}
		}else if($layout == 'tesvik_edit'){
			// İsteği yapan user_id'mi onu bul. Ona göre işlemi devam ettir.
			if(array_key_exists('tesvikId', $get) && !empty($get['tesvikId'])){
				$tesvik = $model->GetTesvikWithTesvikId($get['tesvikId']);
				$this->assignRef('tesvik', $tesvik);
				$tesvikAday = $model->GetTesvikAdaylarWithTesvikId($get['tesvikId']);
				$this->assignRef('tesvikAday', $tesvikAday);
				$TesvikAdaylar = $model->TesvikAdaylarEditWithTarih($get['tesvikId'],$tesvik['BIT_TARIH']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
				
				$this->assignRef('tesvikId', $get['tesvikId']);
			}
		}else if($layout == "tesvikpdf"){
			if(array_key_exists('tesvikId', $get) && !empty($get['tesvikId'])){
				$this->assignRef('tesvikId', $get['tesvikId']);
				$tesvik = $model->GetTesvikWithTesvikId($get['tesvikId']);
				$this->assignRef('tesvik', $tesvik);
				$TesvikAdaylar = $model->TesvikAdaylarWithTesvikId($get['tesvikId']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "itirazlar"){
			
			$itirazSayfa = array(-1 => 'Rededilen İtirazlar', 0=>'Onay Bekleyen İtirazlar', 1=>'Onaylanan İtirazlar');
			
			if(array_key_exists('dId', $get) && !empty($get['dId']) && is_numeric($get['dId'])){
				$dId = $get['dId'];
			}else{
				$dId = 0;
			}
			
			$iLink = '<div class="anaDiv">';
			foreach($itirazSayfa as $key=>$val){
				$iLink .= '<div class="divYan">';
				if($key == $dId){
					$iLink .= '<a class="btn btn-success" href="index.php?option=com_tesvik_abhibe&view=tesvik&layout=itirazlar&dId='.$key.'">'.$val.'</a>';
				}else{
					$iLink .= '<a class="btn btn-xs btn-primary" href="index.php?option=com_tesvik_abhibe&view=tesvik&layout=itirazlar&dId='.$key.'">'.$val.'</a>';
				}
				$iLink .='</div>';
			}
			$iLink .='</div>';
			
			$itirazlar = $model->TesvikItirazlar($dId);
			$this->assignRef('itirazlar', $itirazlar);
			$this->assignRef('dId', $dId);
			$this->assignRef('iLink', $iLink);
			
		}else if($layout == "itiraz_belgeno"){
			if(array_key_exists('belgeno', $get) && !empty($get['belgeno'])){
				$itiraz = $model->TesvikItirazWithBelgeNo(urldecode($get['belgeno']));
				$this->assignRef('itiraz', $itiraz);
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "dezavantajlilar"){
			
			$itirazSayfa = array(-1 => 'Rededilen Dezavantajlı Belgeler', 0=>'Onay Bekleyen Dezavantajlı Belgeler', 1=>'Onaylanan Dezavantajlı Belgeler');
			
			if(array_key_exists('dId', $get) && !empty($get['dId']) && is_numeric($get['dId'])){
				$dId = $get['dId'];
			}else{
				$dId = 0;
			}
			
			$iLink = '<div class="anaDiv">';
			foreach($itirazSayfa as $key=>$val){
				$iLink .= '<div class="divYan">';
				if($key == $dId){
					$iLink .= '<a class="btn btn-success" href="index.php?option=com_tesvik_abhibe&view=tesvik&layout=dezavantajlilar&dId='.$key.'">'.$val.'</a>';
				}else{
					$iLink .= '<a class="btn btn-xs btn-primary" href="index.php?option=com_tesvik_abhibe&view=tesvik&layout=dezavantajlilar&dId='.$key.'">'.$val.'</a>';
				}
				$iLink .='</div>';
			}
			$iLink .='</div>';
			
			$itirazlar = $model->Dezavantajlilar($dId);
			$this->assignRef('itirazlar', $itirazlar);
			$this->assignRef('dId', $dId);
			$this->assignRef('iLink', $iLink);
			
		}else if($layout == "odenemeyen"){
			if(array_key_exists('tesvikId', $get) && !empty($get['tesvikId']) && is_numeric($get['tesvikId'])){
				$odenemeyen = $model->TesvikOdenemeyen($get['tesvikId']);
				$this->assignRef('odenemeyen', $odenemeyen);
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "odenenen"){
			if(array_key_exists('tesvikId', $get) && !empty($get['tesvikId']) && is_numeric($get['tesvikId'])){
				$odenemeyen = $model->TesvikOdenen($get['tesvikId']);
				$this->assignRef('odenemeyen', $odenemeyen);
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "tesvikpdfbanka"){
			$tesvik = $model->GetTesvikWithTesvikId($get['tesvikId']);
			$this->assignRef('tesvik', $tesvik);
			if($get['previewtxt'] == 1){
				$temp_path = $model->previewTxtBeforeSendToBank($get['tesvikId']);
				$txtDatas  = $model->readTxtForPdf($get['tesvikId'],$temp_path);
			}elseif($get['aftertransfer'] == 1){
				$txtDatas = $model->afterTransferBankTxt($get['tesvikId']);
			}else{
				$txtDatas = $model->readTxtForPdf($get['tesvikId']);
			}
			$this->assignRef('txtDatas', $txtDatas);
		}else if($layout == "test"){
			$TesvikAdaylar = $model->TesvikAdaylarWithBelgeNoTest();
			$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
		}else if($layout == "test2"){
			$TesvikAdaylar = $model->TesvikAdaylarWithBelgeNoYeni('YB0002/11UY0031-3/00/405');
			$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
		}
		
		parent::display($tpl);
	}
}

?>