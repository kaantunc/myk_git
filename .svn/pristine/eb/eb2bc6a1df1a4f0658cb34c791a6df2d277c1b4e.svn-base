<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewSertifika_Ozet extends JView
{
	function display($tpl = null)
	{
//		require_once( JPATH_COMPONENT.DS.'models'.DS.'yt_url.php' );
//		$ytModel = new RateModelYt_Url();
		$posted = $_POST;
		$user =& JFactory::getUser();
		if($user->get('guest')){
        	global $mainframe;
        	$mainframe->redirect('index.php?option=com_user&view=login',
        			JText::_('LOGIN_DESCRIPTION'));
        }
        $user_id =  $user->getOracleUserId ();
		$model = &$this->getModel();
		
		$db = & JFactory::getOracleDBO();
		
		$session =&JFactory::getSession();
		$session->set('sertifikaPdfPostData', $posted);
		
		
		$kapsamlar = $model->getKapsamlar($db, $posted);
		$sinavlar = $model->getSinavlar($db, $posted);
		$yetkiNo = $model->getYetkiNo($db);
		$yeterlilik = $model->getYeterlilik($db, $posted);
		
		$sinavIds = $session->get('sinavIds');
		
		$ogrenciler = $model->getOgrencilerBak($db, $posted);
		
		$tumSonuclar = $model->getTumSinavSonuclari($db, $sinavIds);
		
		$session->set('sertifikaPdfKapsamlar', $kapsamlar);
		$session->set('sertifikaPdfSinavlar', $sinavlar);
		$session->set('sertifikaPdfYetkiNo', $yetkiNo);
		$session->set('sertifikaPdfYeterlilik', $yeterlilik);
		$session->set('sertifikaPdfOgrenci', $ogrenciler);
		
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
		$this->assignRef('kapsamlar'  , $kapsamlar);
		$this->assignRef('sinavlar'  , $sinavlar);
		$this->assignRef('yetkiNo'  , $yetkiNo);
		$this->assignRef('yeterlilik'  , $yeterlilik);
		$this->assignRef('user_id'  , $user_id);
		//$this->assignRef('yeterlilikler'  , $yeterlilikler);
		//$this->assignRef('yetCombo'  , $yetCombo);
		//$this->assignRef('yerCombo'  , $yerCombo);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
