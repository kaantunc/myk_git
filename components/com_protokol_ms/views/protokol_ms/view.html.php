<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Protokol Component
 */
class Protokol_MsViewProtokol_Ms extends JView
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
					
			//EDIT
			if (isset ($protokolID)){
				$seciliProtokol = $model->getProtokol($protokolID);
				$seciliKuruluslar = $model->getProtokolKuruluslari($protokolID);
				$msProtokoluMu = $model->msProtokoluMu($protokolID);
				$uzatmalar = $model->getUzatmalar($protokolID); //Uzatma Sureleri
				$protokolunSektorleri = $model->getProtokolunSektorleri($protokolID);
				//ASSIGN REFERENCE
				$this->assignRef('protokolunSektorleri',$protokolunSektorleri);
				$this->assignRef('seciliProtokol', $seciliProtokol);
				$this->assignRef('seciliKuruluslar', $seciliKuruluslar);
				$this->assignRef('msProtokoluMu', $msProtokoluMu);
				$this->assignRef('uzatmalar', $uzatmalar);
			}
			
			$meslekStandartSektorleri = FormParametrik::getSektor ();
			$meslekStandartSeviyeleri = FormParametrik::getSeviye ();
			$kuruluslar = $model->getYetkiliKuruluslar(); //Meslek Standardi Hazirlamaya Yetkilendirilmis Kuruluslar
			
			//ASSIGN REFERENCE
			$this->assignRef('protokolID', $protokolID);
			$this->assignRef('meslekStandartSektorleri',$meslekStandartSektorleri);
			$this->assignRef('meslekStandartSeviyeleri',$meslekStandartSeviyeleri);
			$this->assignRef('kuruluslar', $kuruluslar);
		}

		parent::display($tpl);
	}
}

?>