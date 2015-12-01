<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewSertifika_Ozet extends JView
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
		
		$session =&JFactory::getSession();
		
		$sinavIds = $session->get('sinavIds');
		
		$ogrenciler = $session->get('sertifikaPdfOgrenci');
		
		$tumSonuclar = $model->getTumSinavSonuclari($db, $sinavIds);
		
		$postData = $session->get('sertifikaPdfPostData');
		$kapsamlar = $session->get('sertifikaPdfKapsamlar');
		$sinavlar = $session->get('sertifikaPdfSinavlar');
		$yetkiNo = $session->get('sertifikaPdfYetkiNo');
		$yeterlilik = $session->get('sertifikaPdfYeterlilik');

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
		
		$this->assignRef('ogrenciler'  , $ogrenciler);
		$this->assignRef('tumSonuclar'  , $tumSonuclar);
		$this->assignRef('postData'  , $postData);
		$this->assignRef('kapsamlar'  , $kapsamlar);
		$this->assignRef('sinavlar'  , $sinavlar);
		$this->assignRef('yetkiNo'  , $yetkiNo);
		$this->assignRef('yeterlilik'  , $yeterlilik);
		//$this->assignRef('yeterlilikler'  , $yeterlilikler);
		//$this->assignRef('yetCombo'  , $yetCombo);
		//$this->assignRef('yerCombo'  , $yerCombo);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
