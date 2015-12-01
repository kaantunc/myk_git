<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class SinavViewSinav_Ucret_Tarife_Ara extends JView
{
	function display($tpl = null)
	{

		$model = &$this->getModel();
		
		
		$db = & JFactory::getOracleDBO();
		
		$getData = JRequest::get( 'get' );
		
		
		$kurulus = $model->KuruluslariGetir();
		$yeterlilik = $model->YeterlilikGetir();
		
		$this->assignRef('kurulus'  , $kurulus);
		$this->assignRef('yeterlilik'  , $yeterlilik);
		
		parent::display($tpl);
	}	
}
?>
