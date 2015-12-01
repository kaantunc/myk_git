<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class FinansViewFinans extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();

		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////

		/////////////////////////////////////////////////////////////////////////////////
		
		$finans_bilgi = $model->getFinansBilgi ();
			
		$this->assignRef ("finans_bilgi"		, $finans_bilgi);
		$this->assignRef ("kuruluslar", $model->getKuruluslar());
		$this->assignRef('seciliKurulusunAdi', $model->getSessiondakiKurulusunAdi());
			
		if($_GET['donem_id']!='')
		{
			$donem_id = $_GET['donem_id'];
			$this->assignRef ("seciliDonem", $model->getTarifeDonemiByID($donem_id));
			$this->assignRef ("seciliDonemAralikliTablo_1", $model->getTarifeDonemiAralikliTablosuByDonemID($donem_id, 1));
			$this->assignRef ("seciliDonemAralikliTablo_2", $model->getTarifeDonemiAralikliTablosuByDonemID($donem_id, 2));
		}
		

		parent::display($tpl);
	}	
}
?>
