<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Birim Component
 */
class Yeterlilik_BirimViewOgrenme_Cikti extends JView
{
	function display($tpl = null)
	{
		$model  = &$this->getModel();
		$layout = $this->getLayout();
			
		$birimID   = JRequest::getVar ("birimID");
		$ogrenmeCiktilari = $model->getOgrenmeCiktilar ($birimID);
		//$basarimOlcutleri = $model->getBasarimOlcutler ($birimID);
		//$baglamlar  	  = $model->getBaglamlar ($birimID);

		//ASSIGN REF
		$this->assignRef('birimID', $birimID);
		$this->assignRef('ogrenmeCiktilari', $ogrenmeCiktilari);
		//$this->assignRef('basarimOlcutleri', $basarimOlcutleri);
		//$this->assignRef('baglamlar', $baglamlar);

		parent::display($tpl);
	}	
}
?>
