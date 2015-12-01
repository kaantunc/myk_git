<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Kurulus_EditViewKurulus_Logo extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	= &JFactory::getUser();
		$model 	= &$this->getModel();
		$layout	= JRequest::getVar ("layout");
		$tur	= JRequest::getVar ("tur");
		$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
		//YETKI KONTROL
		/////////////////////////////////////////////////////////////////////////////////
		$message = YETKI_MESAJ;
		if (!$sektorSorumlusu)
			$mainframe->redirect('index.php?', $message);
		/////////////////////////////////////////////////////////////////////////////////
		if (isset($layout)){
			$user_id = JRequest::getVar ("id");
			$kuruluslar = $model->Kuruluslar();
			$this->assignRef('kuruluslar', $kuruluslar);
		}else{
			$layout = 'default';
			$kuruluslar = $model->Kuruluslar();
			$this->assignRef('kuruluslar', $kuruluslar);
			if($_GET['kurulusId']){
				$kurulusBilgi = $model->KurulusGetir($_GET);
				$this->assignRef('kurulusBilgi', $kurulusBilgi);
			}
		}
		
		$this->assignRef('user_id'	  , $user_id);
		$this->assignRef('kurulus_tur', $tur);
		
		parent::display($tpl);
	}	
}
?>
