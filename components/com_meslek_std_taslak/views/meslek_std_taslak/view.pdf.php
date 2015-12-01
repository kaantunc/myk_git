<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Meslek_Std_TaslakViewMeslek_Std_Taslak extends JView
{
	function display($tpl = null)
	{
		$id = -1;
		$user 	= &JFactory::getUser();
		$model 	= &$this->getModel();
		
		$evrak_id		= JRequest::getVar("id");
		$standart_id	= JRequest::getVar("standart_id");
		$evrak_id	= $model->getOracleEvrakId ($standart_id);
		$taslak_meslek_id = $model->getTaslakMeslekId ($evrak_id);
			$hazirlayan		= $model->getHazirlayanValues ($taslak_meslek_id);
			if(empty($hazirlayan)){
				// Taslak henuz olusturulmaya baslanmadiysa kurulus bilgilerine buradan ulasilacak.
				$hazirlayan		= $model->getHazirlayanValues2 ($standart_id);
			}
		$terim			= $model->getTerimValues ($taslak_meslek_id);
        	
		$meslekStandart = $model->getMeslekStandartValues ($taslak_meslek_id);
		$meslekTanitim 	= $model->getMeslekTanitimValues ($taslak_meslek_id);
		$ekipman		= $model->getEkipmanValues ($taslak_meslek_id);
		$bilgiBeceri	= $model->getBilgiBeceriValues ($taslak_meslek_id);
		$tutumDavranis  = $model->getTutumDavranisValues ($taslak_meslek_id);
		for ($i = 0; $i < 6; $i++){
			$gorevAlan[$i] = $model->getGorevAlanValues ($taslak_meslek_id, $i+1);
		}
		$yonetimKurulu = $model->getYonetimKuruluValues($taslak_meslek_id);
		$profil			= $model->getProfilValues ($taslak_meslek_id);
		
		$this->assignRef('evrak_id'	  	 , $evrak_id);
		$this->assignRef('standart_id'	 , $standart_id);
		$this->assignRef('hazirlayan'  	 , $hazirlayan);
		$this->assignRef('terim'	  	 , $terim);
		$this->assignRef('meslekStandart', $meslekStandart);
		$this->assignRef('meslekTanitim' , $meslekTanitim);
		$this->assignRef('ekipman' 		 , $ekipman);
		$this->assignRef('bilgiBeceri'	 , $bilgiBeceri);
		$this->assignRef('tutumDavranis' , $tutumDavranis);
		$this->assignRef('gorevAlan'	 , $gorevAlan);
		$this->assignRef('yonetimKurulu' , $yonetimKurulu);
		$this->assignRef('profil'		 , $profil);
		$this->assignRef('tur_id'		 , $id);
		
		parent::display($tpl);
	}	
}
?>
