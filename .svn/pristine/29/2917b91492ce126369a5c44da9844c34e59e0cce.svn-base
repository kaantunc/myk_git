<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 

class Yonetim_KuruluViewYonetim_Kurulu extends JView
{
    function display($tpl = null)
    {
    	
    	global $mainframe;
    	$user 	 	= &JFactory::getUser();
    	$model 	  	= &$this->getModel();
    	$layout		= JRequest::getVar ("layout");
    	$user_id	= $user->getOracleUserId ();
    	 
    	$yonetimKurulu=$model->getYonetimKurulu();
    	$this->assignRef('yonetimKurulu', $yonetimKurulu);
    	
    	$etkinlikDurumlari = $model->getYonetimKuruluEtkinlikDurumlari();
    	$this->assignRef('etkinlikDurumlari', $etkinlikDurumlari);
    	
    	$uyeID = JRequest::getVar("uyeID");
    	if(isset($uyeID)){
    		$seciliUye=$model->getUye($uyeID);
    		$this->assignRef('seciliUye', $seciliUye);
    	
    	}
        parent::display($tpl);
    }
}
?>