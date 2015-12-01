<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewTakvim_Gor extends JView
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
        
        $userId = JRequest::getVar( 'userId' );
		$takvimYili = JRequest::getVar( 'takvimYili' );
		$aramaSozcugu = JRequest::getVar( 'aramaSozcugu' );
		
		
        if(!$userId && !$takvimYili){
        	global $mainframe;
        	$mainframe->redirect('index.php?option=com_kurulus_ara');
        }
		else if(!$takvimYili){
			$db = & JFactory::getOracleDBO();
			$model = &$this->getModel();
			$takvimListe = $model->getTakvimListe($db, $userId);
			$this->assignRef('takvimListe'  , $takvimListe);
			
			$this->assignRef('aramaSozcugu'  , $aramaSozcugu);
		}
        else{
			$db = & JFactory::getOracleDBO();
			$model = &$this->getModel();
        	$takvimIcerik = $model->getTakvim($db, $userId, $takvimYili);
        	$this->assignRef('takvimIcerik'  , $takvimIcerik);
        }
		$this->assignRef('userId'  , $userId);
		
		//$this->assignRef('yerCombo'  , $yerCombo);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
