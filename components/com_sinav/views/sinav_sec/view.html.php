<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewSinav_Sec extends JView
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
		
		$userId = JRequest::getVar('userId');
		$aramaSozcugu = JRequest::getVar( 'aramaSozcugu' );
						
		$sinavlar  = $model->getSinavlar($db, $userId);
		
//		foreach ($rows as $row) {
//			if(strpos($row->file_path, 'youtube')!==FALSE){
//				$pageContent = file_get_contents($row->file_path);
//				$row->file_path = $ytModel->getFullUrl($row->file_path, $pageContent);
//			}
//		}

		if($userId)
			$isKomite = 1;
		else
			$isKomite = 0;
			
		$this->assignRef('komite'  , $isKomite);
		
		$this->assignRef('aramaSozcugu'  , $aramaSozcugu);
		$this->assignRef('sinavlar'  , $sinavlar);
		parent::display($tpl);
		
	}	
}
?>
