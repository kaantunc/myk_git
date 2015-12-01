<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewTakvim_Ozet extends JView
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
		
		//$kapsamlarCombo = $model->getTumKapsamlar($db);
//		$yetCombo = $model->getYeterlilikler($db);
//		$yilCombo = $model->getYillarCombo();
		$merkezler = $model->getMerkezAdlari($db, $_POST['inputsinavTakvimi-5']);
		$altBirimler = $model->getAltBirimAdlari($db, $_POST['inputsinavTakvimi-4-Hidden'], $_POST['inputsinavTakvimi-3']);
		$altBirimlerPDF = $model->getAltBirimAdlari_PdfIcin($db, $_POST['inputsinavTakvimi-4-Hidden'], $_POST['inputsinavTakvimi-3']);
		$sekiller = $model->getSekiller($db, $_POST['inputsinavTakvimi-4-Hidden']);
		$yeterlilikler = $model->getYetAdlari($db, $_POST['inputsinavTakvimi-3']);
		
		$session =&JFactory::getSession();
		$post = $session->set('takvimPdfPostData', $_POST);
		
		
		$this->assignRef('merkezler'  , $merkezler);
		$this->assignRef('yeterlilikler'  , $yeterlilikler);
		$this->assignRef('altBirimler'  , $altBirimler);
		$this->assignRef('altBirimlerPDF'  , $altBirimlerPDF);
		$this->assignRef('sekiller', $sekiller);
		
		parent::display($tpl);
		
	}	
}
?>
