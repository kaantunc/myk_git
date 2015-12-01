<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AkreditasyonViewTakvim extends JView
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
		$kurCombo = $model->getKuruluslar($db);
		$yilCombo = $model->getYillarCombo();
		//$yerCombo = $model->getMerkezler($db);
		//$ogrenciler  = $model->getOgrList($db);
		
		$this->assignRef('kurCombo'  , $kurCombo);
		$this->assignRef('yilCombo'  , $yilCombo);
		//$this->assignRef('yerCombo'  , $yerCombo);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
