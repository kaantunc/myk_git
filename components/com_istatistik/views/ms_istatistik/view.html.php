<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class IstatistikViewMs_Istatistik extends JView
{
    function display($tpl = null)
    {
        global $mainframe;

        $redirect	= "index.php?option=com_istatistik&view=istatistik";
     	$model = JModel::getInstance('istatistik','IstatistikModel');
		//$model=$this->getModel( 'istatistik' );
        //$model = &$this->getModel();
		$user  = &JFactory::getUser();
        
        $layout	= JRequest::getVar ("layout");
        $user_id =  $user->getOracleUserId ();

        $post = JRequest::get( 'post' );
        $get = JRequest::get('get');
        $file = JRequest::get('files');


//    $mainframe->redirect('index.php?option=com_belgelendirme&view=belge_olusturma', $sonuc['hata'],'error');
        
        if(empty($layout)){
            $layout = 'default';
        }
        
        $SSgonderilmisMSonTas 	= $model->SSgonderilmisMSonTas();
        $this->assignRef('SSgonderilmisMSonTas'  , $SSgonderilmisMSonTas);
        
        $SSgonderilmemisMSonTas 	= $model->SSgonderilmemisMSonTas();
        $this->assignRef('SSgonderilmemisMSonTas'  , $SSgonderilmemisMSonTas);
        
        parent::display($tpl);
    }
}

?>