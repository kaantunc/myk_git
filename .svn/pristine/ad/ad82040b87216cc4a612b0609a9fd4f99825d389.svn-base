<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class ProfileViewAbuzman extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$session	 = &JFactory::getSession();
		$user 	 	= &JFactory::getUser();
		$model = JModel::getInstance('profile','profileModel');
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$redirect = "index.php?option=com_profile&view=abuzman";
		$aut = FormFactory::checkAuthorization ($user, 32);
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		$canEdit = true;
		if(!$aut){
			$canEdit = false;
			$mainframe->redirect($redirect,'Bu sayfayı görme yetkiniz yoktur.');
		}
		$this->assignRef('canEdit', $canEdit);
		
		if($layout == ''){
			$layout = 'default';
		}
		
		if($layout == "default"){
			$allSBKurulus = $model->getAllKurulusWithoutPro(SINAV_BELGELENDIRME_KURULUS_DURUM_IDS);
			$this->assign('AllSBKurulus',$allSBKurulus);
			$this->assignRef('ProKur', $model->ProtokoluOlanKuruluslar());
		}else if($layout == "abdonem"){
			$kId = 0;
			if(array_key_exists('kId', $post) && $post['kId'] != null && $post['kId'] != 0){
				$kId = $post['kId'];
			}else if(array_key_exists('kId', $get) && $get['kId'] != null && $get['kId'] != 0){
				$kId = $get['kId'];
			}else{
				$mainframe->redirect($redirect,'Bu sayfayı görme yetkiniz yoktur.');
			}
			
			$kurulus_bilgi 		= FormFactory::getKurulusBilgi($kId);
			$this->assignRef('kurulus_bilgi', $kurulus_bilgi);
			$abKur = $model->getABKurulusBilgi($kId);
			$this->assignRef('abKur', $abKur);
			$this->assignRef('ABKurKota', FormABHibeUcretHesabi::KuruluABHibeToplamKota($kId));
			$this->assignRef('ABKurKullanilanKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($kId));
			$this->assignRef('ABKurKullanilanDezKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($kId));
			$this->assignRef('ABKurBekKota', FormABHibeUcretHesabi::KuruluABHibeBekKota($kId));
			$this->assignRef('ABKurBekDezKota', FormABHibeUcretHesabi::KuruluABHibeBekDezKota($kId));
			$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($kId));
			$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
			$this->assignRef('doviz', $doviz);
		}
		
		parent::display($tpl);		
	}	
}
?>
