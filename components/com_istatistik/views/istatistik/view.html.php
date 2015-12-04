<?php
ini_set("display_errors","1");
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class IstatistikViewIstatistik extends JView
{
    function display($tpl = null)
    {
        global $mainframe;

        $redirect	= "index.php?option=com_istatistik&view=istatistik";

        $model = &$this->getModel();
		$user  = &JFactory::getUser();
        
        $layout	= JRequest::getVar ("layout");
        $user_id =  $user->getOracleUserId ();

        
        if($layout == "istatistik_meslek_standart"){
        	
        	$group_id   = MS_SEKTOR_SORUMLUSU_GROUP_ID;
        	$message   	= YETKI_MESAJ;
        	$aut = FormFactory::checkAuthorization  ($user, $group_id);
        	
        	if(!$aut){
        		$mainframe->redirect('index.php?', $message);
        	}
        	
        	$this->assignRef ("istatistik_meslek", $model->istatistik_meslek());
        	$this->assignRef ("istatistik_meslek_detail", $model->istatistik_meslek_detail());
        	
        }else if($layout == "istatistik_meslek_standart_revizyon"){
        	
        	$group_id   = MS_SEKTOR_SORUMLUSU_GROUP_ID;
        	$message   	= YETKI_MESAJ;
        	$aut = FormFactory::checkAuthorization  ($user, $group_id);
        	
        	if(!$aut){
        		$mainframe->redirect('index.php?', $message);
        	}
        	
        	$this->assignRef ("istatistik_meslek_detail", $model->istatistik_meslek_detail(true));
        	
        }else if($layout == "istatistik_yeterlilik"){
        	
        	$this->assignRef ("istatistik_yeterlilik", $model->istatistik_yeterlilik());
        	$this->assignRef ("istatistik_yeterlilik_detail", $model->istatistik_yeterlilik_detail());
       
        }else if($layout == "istatistik_protokol_meslek_standart"){
        	
        	$this->assignRef ("istatistik_protokol_standart", $model->istatistik_protokol_standart());
        	
        }else if($layout == "istatistik_protokol_yeterlilik"){
        
        	$this->assignRef ("istatistik_protokol_yeterlilik", $model->istatistik_protokol_yeterlilik());
        	
        }else if($layout == "default" || empty($layout)){
        
        	$perm = false;
        	if($user_id == "40" || $user_id == "42"){
        		$perm = true;
        	}
        	$statictic 	= $model->getAllStatistic();
        	$this->assignRef('perm'  , $perm);
        	$this->assignRef('statistic'  , $statictic);
        	$this->assignRef ("istatistik_duzenleme_yetki", $perm);
        }
       
        parent::display($tpl);
    }
}

?>