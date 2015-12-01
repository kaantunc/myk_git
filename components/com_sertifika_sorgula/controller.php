<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

require_once('libraries/form/captcha.php');


$document = &JFactory::getDocument();
$document->addStyleSheet( SITE_URL.'/components/com_sertifika_sorgula/assets/style.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');
$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js');


class Sertifika_SorgulaController extends JController {
	
	function display() {	 
		parent::display();
	}
	
	function sertifikaVer(){
		global $mainframe;
		
		$model = $this->getModel('sertifika_sorgula');
		$message = $model->sertifikaOnayla();
		//JRequest::setVar('view', 'sinav_ucret_tarife_ara');
		$mainframe->redirect("index.php?option=com_sertifika_sorgula&view=sertifika_sorgula", $message);
	}
	
	function sertifikacontrol() {
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT ID,TO_CHAR(GECERLILIK_TARIHI, 'yyyymmdd') AS GECERLILIK_TARIHI,BELGEDURUMU 
				FROM M_BELGE_SORGU WHERE BELGEDURUMU = 1 order by ID DESC";
		$datas = $db->prep_exec($sql, array());
		foreach ($datas as $data){
			if($data['GECERLILIK_TARIHI'] < date('Ymd') && $data['BELGEDURUMU'] <> "4"){
				$db->prep_exec_insert("UPDATE M_BELGE_SORGU SET BELGEDURUMU=4 WHERE ID=".$data['ID'], array());
				}	
			}
		}
	
}

?>