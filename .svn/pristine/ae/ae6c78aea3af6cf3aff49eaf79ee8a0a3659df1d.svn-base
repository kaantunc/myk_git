<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class SinavViewSinav_Oncesi_Incele extends JView
{
	function display($tpl = null)
	{

		$user =& JFactory::getUser();
		if($user->get('guest')){
        	global $mainframe;
        	$mainframe->redirect('index.php?option=com_user&view=login',
        			JText::_('LOGIN_DESCRIPTION'));
        }
        $user_id =  $user->getOracleUserId ();
		$model = &$this->getModel();
		$db = & JFactory::getOracleDBO();

		$sinav_id = $_GET["sinavId"];
		
		
		$session =&JFactory::getSession();
		
		$isSaved = $session->get('sinavOncesiKaydedildi');
		
		if($isSaved == 1){
			$session->set('sinavOncesiKaydedildi', 0);
			// @todo sinav oncesinde eklenenlerin hepsini temizle
			$session->clear('sinavOncesiSekil');
			$session->clear('sinavOncesiPostData');
			$session->clear('sinavOncesiAdlar');
			$sinavOncesiPostData = "";
			$sinavOncesiAdlar = "";
		}
		else{

			$sinavOncesiPostData = $session->get('sinavOncesiPostData');
			$sinavOncesiAdlar = $session->get('sinavOncesiAdlar');
		
			
			
		
		}
		$this->assignRef('postData'  , $sinavOncesiPostData);
			$this->assignRef('sinavOncesiAdlar'  , $sinavOncesiAdlar);

		$sinavBilgi = $model->getSinavBilgi($db, $sinav_id);	
		$sinavlar = $model->getSinavlar($db, $user_id);
		$turCombo = $model->getSinavTurleri($db);
		$yerCombo = $model->getMerkezler($db);
		$yetCombo = $model->getBASYeterlilikler($db);
		
		$this->assignRef('sinavBilgi'  , $sinavBilgi);
		$this->assignRef('yerCombo'  , $yerCombo);
		$this->assignRef('turCombo'  , $turCombo);
		$this->assignRef('yetCombo'  , $yetCombo);
		$this->assignRef('user_id'  , $user_id);
		$this->assignRef('sinavlar'  , $sinavlar);

		parent::display($tpl);
		
	}	
}
?>
