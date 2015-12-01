<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Uzman_KayitViewUzman_Kayit extends JView
{
	function display($tpl = null)
	{	
		global $mainframe;
		$model = &$this->getModel();
		$user  = &JFactory::getUser();
        $layout		 = JRequest::getVar("layout");
        $message   	= YETKI_MESAJ;
        if ($user->id==0)
        	$mainframe->redirect('index.php?', $message);
        
        

        $data = $model->getUzmanValues($user->getOracleUserId());
         
        if (!empty($data)){
        	$mainframe->redirect("index.php?option=com_uzman_basvur", "Daha önce başvuru yapılmış", 'error');
        }
        
        
        //Iller
		$il	= FormParametrik::getIl ();
		$this->assignRef('il', $il);
		
		parent::display($tpl);		
	}	
}
?>
