<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewSinav_Oncesi_Incele_Ozet extends JView
{
	function display($tpl = null)
	{
//		require_once( JPATH_COMPONENT.DS.'models'.DS.'yt_url.php' );
//		$ytModel = new RateModelYt_Url();
		
		$user =& JFactory::getUser();
		if($user->get('guest')){
        	global $mainframe;
        	$mainframe->redirect('index.php?option=com_user&view=login',
        			JText::_('LOGIN_DESCRIPTION'));
        }
		
		$model = &$this->getModel();
		
		$db = & JFactory::getOracleDBO();
				
		$merkezAdi = $model->getMerkezAdi($db, $_POST);
		$yetAdi = $model->getYetAdi($db, $_POST);
		$turAdi = $model->getTurAdi($db, $_POST);
		$sekilAdi = $model->getSekilAdi($db, $_POST);
		
		$session =&JFactory::getSession();
		$session->set('sinavOncesiPostData', $_POST);
		$session->set('sinavOncesiAdlar', array($merkezAdi, $yetAdi, $turAdi,
				$sekilAdi));
				
		$post = $session->set('sinavOncesiPdfPostData', $_POST);
		
//		$kapsamlar = $model->getKapsamlar($db, $_POST);
//		$sinavlar = $model->getSinavlar($db, $_POST);
//		$yetkiNo = $model->getYetkiNo($db);
//		$yeterlilik = $model->getYeterlilik($db, $_POST);
//		$yetCombo = $model->getYeterlilikler($db);
//		$yilCombo = $model->getYillarCombo();
		//$merkezler = $model->getMerkezAdlari($db, $_POST['inputsinavTakvimi-3']);
		//$yeterlilikler = $model->getYetAdlari($db, $_POST['inputsinavTakvimi-4']);
		//$ogrenciler  = $model->getOgrList($db);
		//$sinavTurleri = $model->sinavTurleriAl($db);
		//$sinavSekilleri = $model->sinavSekilleriAl($db);
		
//		foreach ($rows as $row) {
//			if(strpos($row->file_path, 'youtube')!==FALSE){
//				$pageContent = file_get_contents($row->file_path);
//				$row->file_path = $ytModel->getFullUrl($row->file_path, $pageContent);
//			}
//		}
		
		$this->assignRef('merkezAdi'  , $merkezAdi);
		$this->assignRef('yetAdi'  , $yetAdi);
		$this->assignRef('turAdi'  , $turAdi);
		$this->assignRef('sekilAdi'  , $sekilAdi);
//		$this->assignRef('sinavlar'  , $sinavlar);
//		$this->assignRef('yetkiNo'  , $yetkiNo);
//		$this->assignRef('yeterlilik'  , $yeterlilik);
		//$this->assignRef('yeterlilikler'  , $yeterlilikler);
		//$this->assignRef('yetCombo'  , $yetCombo);
		//$this->assignRef('yerCombo'  , $yerCombo);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
