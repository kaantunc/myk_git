<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once('libraries/form/form_parametrik.php');
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Protokol Component
 */
class Protokol_YetViewProtokol_Yet extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$user_id	= $user->getOracleUserId ();
		
		if (!isset ($layout)){
			$layout = "protokol_listele";
			$this->setLayout($layout);
		}
		
		//PROTOKOL LISTE
		if($layout == "protokol_listele"){
			$protokoller = $model->getProtokoller();
			$etkinlikDurumlari = $model->getEtkinlikDurumlari();
			//ASSIGN REFERENCE
			$this->assignRef('protokoller', $protokoller);
			$this->assignRef('etkinlikDurumlari', $etkinlikDurumlari);
		}
		//YENI veya EDIT
		else{
			$protokolID = JRequest::getVar("protokolID");
			$yeterlilikSektorleri = FormParametrik::getSektor ();
			$yeterlilikSeviyeleri = FormParametrik::getSeviye ();
			$kuruluslar = $model->getYetkiliKuruluslar(); //Meslek Standardi Hazirlamaya Yetkilendirilmis Kuruluslar	
					
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
		}

		parent::display($tpl);
	}
}

?>