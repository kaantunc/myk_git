<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class SinavViewSinav_Sonucu_Gor extends JView
{
	function display($tpl = null)
	{
//		require_once( JPATH_COMPONENT.DS.'models'.DS.'yt_url.php' );
//		$ytModel = new RateModelYt_Url();

		$user =& JFactory::getUser();
		if($user->get('guest')){
        	global $mainframe;
        	$mainframe->redirect('index.php?option=com_user&view=login',JText::_('LOGIN_DESCRIPTION'));
        }
		
		$model = &$this->getModel();
		
		$db = & JFactory::getOracleDBO();
		//$postData = JRequest::get( 'post' );
		$getData = JRequest::get( 'get' );
		
		$sinavSekli = $model->getSinavSekli($db, $getData);
		$sinavSonuclari = $model->getSinavSonuclari($db, $getData);
		
//		if($sinavSekli == TEORIK_SINAV_ID){
//			JRequest::setVar('layout', 'teorik');
//		}
//		else if($sinavSekli == PRATIK_SINAV_ID){
//			JRequest::setVar('layout', 'pratik');
//		}
		
		$this->assignRef('sinavSonuclari'  , $sinavSonuclari);
		$this->assignRef('sinavSekli'  , $sinavSekli);
		
		parent::display($tpl);
	}	
}
?>
