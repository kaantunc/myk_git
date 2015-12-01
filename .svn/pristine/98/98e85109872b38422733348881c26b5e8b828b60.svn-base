<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Belge_SorgulaViewBelge_Sorgula extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belge_sorgula&view=belge_sorgula";
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$kimlik_no 	= $_POST["kimlik_no"];
		
		//SORGU SONUC
		if (isset($layout) && $layout == "sorgu_sonuc"){
			//Captcha
			captcha::check($redirect);
			//Kimlik No
			if (!isset($_POST['kimlik_no']) || empty($_POST['kimlik_no'])){
				JError::raiseWarning( 100, "Lütfen T.C. Kimlik No Giriniz" );
				$mainframe->redirect($redirect);
			}else{
				$data = $model->getBelgeDataByTcKimlikNo($kimlik_no);
				$this->assignRef('data'	, $data);
			}
		}
				
		parent::display($tpl);
	}
}

?>