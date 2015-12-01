<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Yeterlilik_TaslakViewGorus_Bildir extends JView
{
	function display($tpl = null)
	{
		$model = &$this->getModel();	
		$db = & JFactory::getOracleDBO();
		
		$yeterlilikId = JRequest::getVar('yeterlilikId');
		
		$yeterlilikAdi 	= $model->getYeterlilikAdi($db, $yeterlilikId);
		$seviye 		= $model->getSeviye($db, $yeterlilikId);
		$seviyeId 		= $seviye['SEVIYE_ID'];
		$seviyeAdi 		= $seviye['SEVIYE_ADI'];
		$sonGorusTarihi = $model->getSonGorusTarihi ($db, $yeterlilikId);
		
		$this->assignRef('yeterlilikAdi' , $yeterlilikAdi);
		$this->assignRef('seviyeAdi'  	 , $seviyeAdi);
		$this->assignRef('seviyeId'  	 , $seviyeId);
		$this->assignRef('yeterlilikId'  , $yeterlilikId);
		$this->assignRef('sonGorusTarihi', $sonGorusTarihi);

		parent::display($tpl);
		
	}	
}
?>
