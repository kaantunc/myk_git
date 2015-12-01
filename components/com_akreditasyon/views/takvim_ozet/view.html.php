<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class AkreditasyonViewTakvim_Ozet extends JView
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
		$post = $session->set('akreTakvimPdfPostData', $_POST);
		
		//$kapsamlarCombo = $model->getTumKapsamlar($db);
//		$yetCombo = $model->getYeterlilikler($db);
//		$yilCombo = $model->getYillarCombo();
		$kuruluslar = $model->getKurulusAdlari($db, $_POST['inputsinavTakvimi-3']);
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
		
		$this->assignRef('kuruluslar'  , $kuruluslar);
		//$this->assignRef('yeterlilikler'  , $yeterlilikler);
		//$this->assignRef('yetCombo'  , $yetCombo);
		//$this->assignRef('yerCombo'  , $yerCombo);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
