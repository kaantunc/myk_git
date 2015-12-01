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
		
        $userId = JFactory::getUser()->getOracleUserId();
		$model = &$this->getModel();
		
		$db = & JFactory::getOracleDBO();
		
		$session =&JFactory::getSession();
		$post = $session->get('takvimPdfPostData');
		
		//$kapsamlarCombo = $model->getTumKapsamlar($db);
//		$yetCombo = $model->getYeterlilikler($db);
//		$yilCombo = $model->getYillarCombo();
		$merkezler = $model->getMerkezAdlari($db, $post['inputsinavTakvimi-5']);
		$altBirimler = $model->getAltBirimAdlari($db, $post['inputsinavTakvimi-4-Hidden'], $post['inputsinavTakvimi-3']);
		$altBirimlerPDF = $model->getAltBirimAdlari_PdfIcin($db, $post['inputsinavTakvimi-4-Hidden'], $post['inputsinavTakvimi-3']);
		$sekiller = $model->getSekiller($db, $post['inputsinavTakvimi-4']);
		$yeterlilikler = $model->getYetAdlari($db, $post['inputsinavTakvimi-3']);
		$kurulus = $model->getKurulusAdi($db, $userId);
		
				
		
		$this->assignRef('merkezler'  , $merkezler);
		$this->assignRef('yeterlilikler'  , $yeterlilikler);
		$this->assignRef('altBirimler'  , $altBirimler);
		$this->assignRef('altBirimlerPDF'  , $altBirimlerPDF);
		$this->assignRef('sekiller', $sekiller);
		$this->assignRef('kurulus', $kurulus);
		$this->assignRef('postData', $post);
		parent::display($tpl);
		
	}	
}
?>
