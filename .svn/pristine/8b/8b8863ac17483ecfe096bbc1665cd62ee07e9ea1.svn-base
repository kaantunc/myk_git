<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class Scheduled_Tasks_FunctionsModelScheduled_Tasks_Functions extends JModel {
	
	function sendToZiraatTxt(){ echo "ede"; exit;
		$db  = JFactory::getOracleDBO ();
		
		$componentA_modelpath = JPATH_ROOT.DS.'components'.DS.'com_tesvik'.DS.'models';
		JModel::addIncludePath( $componentA_modelpath);
		$tesvik_model =& JModel::getInstance('tesvik','TesvikModel');
		
		$sql = "SELECT DISTINCT TESVIK_ID FROM M_BELGE_TESVIK_ADAY WHERE ODENDI = 1 OR ODENDI = -1";
		
		$datas = $db->prep_exec($sql, array());
		foreach ($datas as $data){
			$tesvik_txt_path = $tesvik_model->generateTxt($data['TESVIK_ID']);
// 			$tesvik_model->sendToZiraatTxt($tesvik_txt_path);
		} 
	}
	
	function readFromZiraatTxt(){
		$db  = JFactory::getOracleDBO ();
		
		$sql = "SELECT ID FROM M_BELGE_TESVIK_ISTEK WHERE DURUM = ?";
		$tesviks = $db->prep_exec($sql, array('4'));
		
		$componentA_modelpath = JPATH_ROOT.DS.'components'.DS.'com_tesvik'.DS.'models';
		JModel::addIncludePath( $componentA_modelpath);
		$tesvik_model =& JModel::getInstance('tesvik','TesvikModel');
		
		$file = $tesvik_model->readFromZiraatTxt($tesviks[0]['ID']);
		
		if($file['STATUS'] == true && $file['FILE'] <> ""){
			$tesvik_model->explodeAndCommitTxt($file['FILE']);
		}
	}
	
}