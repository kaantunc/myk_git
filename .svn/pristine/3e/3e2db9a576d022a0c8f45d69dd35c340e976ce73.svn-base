<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Protokol Component
 */
class Terim_SozluguViewTerim_Sozlugu extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();
		
		if (!isset ($layout)){
			$layout = "terim_sozlugu";
			$this->setLayout($layout);
		}
		
		$terimListesi = $model->getTerimListesi();
		$this->assignRef('terimListesi', $terimListesi);
			
		
		/*/PROTOKOL LISTE
		if($layout == "protokol_listele"){
			$protokoller = $model->getProtokoller();
			;
		}
		//YENI veya EDIT
		else{
			$protokolID = JRequest::getVar("protokolID");
			$yeterlilikSektorleri = FormParametrik::getSektor ();
			$yeterlilikSeviyeleri = FormParametrik::getSeviye ();
					
			//EDIT
			if (isset ($protokolID)){
				$seciliProtokol = $model->getProtokol($protokolID);
				$seciliKuruluslar = $model->getProtokolKuruluslari($protokolID);
				$yetProtokoluMu = $model->yetProtokoluMu($protokolID);
				$uzatmalar = $model->getUzatmalar($protokolID); //Uzatma Sureleri
				$protokolunSektorleri = $model->getProtokolunSektorleri($protokolID);
				//ASSIGN REFERENCE
				$this->assignRef('protokolunSektorleri',$protokolunSektorleri);
				$this->assignRef('seciliProtokol', $seciliProtokol);
				$this->assignRef('seciliKuruluslar', $seciliKuruluslar);
				$this->assignRef('yetProtokoluMu', $yetProtokoluMu);
				$this->assignRef('uzatmalar', $uzatmalar);
			}
			
			//ASSIGN REFERENCE
			$this->assignRef('protokolID', $protokolID);
			$this->assignRef('yeterlilikSektorleri',$yeterlilikSektorleri);
			$this->assignRef('yeterlilikSeviyeleri',$yeterlilikSeviyeleri);
			$this->assignRef('kuruluslar', $kuruluslar);
		}*/

		parent::display($tpl);
	}
}

?>