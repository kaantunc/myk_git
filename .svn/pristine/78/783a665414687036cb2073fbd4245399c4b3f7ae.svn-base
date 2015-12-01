<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewSinav_Oncesi extends JView
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
		
		$merkezId = JRequest::getVar('merkezId');
		
		
		
		if($merkezId != null){
			$yetCombo = $model->getYeterlilikler($db, $merkezId);
			$this->assignRef('yetCombo'  , $yetCombo);
			
			$yetId = JRequest::getVar('yeterlilik_konusu');
				
//			if($yetId != null){
//				$sekilCombo = $model->getSinavSekilleri($db,$merkezId,$yetId);
//				
////				echo '*<pre>';
////				print_r($sekilCombo);				
////				echo '</pre>*';
//				$this->assignRef('sekilCombo'  , $sekilCombo);
//			}
			
		}
		
		$turCombo = $model->getSinavTurleri($db);
		$yerCombo = $model->getMerkezler($db, $merkezId);
		
		$this->assignRef('yerCombo'  , $yerCombo);
		$this->assignRef('turCombo'  , $turCombo);

		parent::display($tpl);
		
	}	
}
?>
