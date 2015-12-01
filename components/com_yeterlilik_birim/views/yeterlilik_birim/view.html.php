<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Birim Component
 */
class Yeterlilik_BirimViewYeterlilik_Birim extends JView
{
	function display($tpl = null)
	{
		$model  = &$this->getModel();
		$layout = $this->getLayout();
			
		$birimID   = JRequest::getVar ("birimID");
		$seviyeler = FormParametrik::getSeviye ();
		$sektorler = FormParametrik::getSektor (); 
		
		$birimInfo = $model->getBirimInfo ($birimID);
		$birimKaynak = $model->getBirimKaynak ($birimID);
		
		//ASSIGN REF
		$this->assignRef('birimID', $birimID);
		$this->assignRef('birimInfo', $birimInfo);
		$this->assignRef('birimKaynak', $birimKaynak);
		$this->assignRef('seviyeler', $seviyeler);
		$this->assignRef('sektorler', $sektorler);
		
		parent::display($tpl);
	}	
}
?>
