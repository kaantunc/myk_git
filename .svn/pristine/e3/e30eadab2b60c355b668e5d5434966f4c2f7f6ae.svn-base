<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Uzman_BasvurViewUzman_Basvurulari extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user = &JFactory::getUser ();
		$model = &$this->getModel();	
		$db = & JFactory::getOracleDBO();				
// 		$group_id   = UZMAN_ONIZLEYICI_GROUP_ID;
		$message   	= YETKI_MESAJ;
// 		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		
		$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
		$this->assignRef('sektorSorumlusu'  , $sektorSorumlusu);
		
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		$message = YETKI_MESAJ;
		if (!$sektorSorumlusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////
		
		$bekleyenbasvurular = $model->getBasvurular($db,1);// (oracledb,basvuru durumu, kaydeden(1->kullanıcı, 2->sektorSorumlusu) )
		$this->assignRef('bekleyenbasvurular'  		, $bekleyenbasvurular);

		$onaylanmisbasvurular = $model->getBasvurular($db,2);
		$this->assignRef('onaylanmisbasvurular'  		, $onaylanmisbasvurular);

		$redddedilmisbasvurular = $model->getBasvurular($db,-1);
		$this->assignRef('redddedilmisbasvurular'  		, $redddedilmisbasvurular);
		
		parent::display($tpl);
		
	}	
	}
?>
