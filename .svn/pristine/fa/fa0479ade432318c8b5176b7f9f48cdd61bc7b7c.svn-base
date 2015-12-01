<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Meslek_Std_TaslakViewGorus_Bildir extends JView
{
	function display($tpl = null)
	{
//		require_once( JPATH_COMPONENT.DS.'models'.DS.'yt_url.php' );
//		$ytModel = new RateModelYt_Url();
		
//		$user =& JFactory::getUser();
//		if($user->get('guest')){
//        	global $mainframe;
//        	$mainframe->redirect('index.php?option=com_user&view=login',"You must login first");
//        }
		
		$model = &$this->getModel();
		
		$db = & JFactory::getOracleDBO();
		
		$standartId = JRequest::getVar('standartId');
		
		$standartAdi = $model->getStandartAdi($db, $standartId);
		$seviye = $model->getSeviye($db, $standartId);
		$sonGorusTarihi = $model->getSonGorusTarihi ($db, $standartId);
		
		$seviyeId = $seviye['SEVIYE_ID'];
		$seviyeAdi = $seviye['SEVIYE_ADI'];
		
		//$yetCombo = $model->getYeterlilikler($db);
		//$yilCombo = $model->getYillarCombo();
		//$ogrenciler  = $model->getOgrList($db);
		//$sinavTurleri = $model->sinavTurleriAl($db);
		//$sinavSekilleri = $model->sinavSekilleriAl($db);
		
//		foreach ($rows as $row) {
//			if(strpos($row->file_path, 'youtube')!==FALSE){
//				$pageContent = file_get_contents($row->file_path);
//				$row->file_path = $ytModel->getFullUrl($row->file_path, $pageContent);
//			}
//		}
		
		$this->assignRef('standartAdi'  , $standartAdi);
		$this->assignRef('seviyeAdi'  , $seviyeAdi);
		$this->assignRef('seviyeId'  , $seviyeId);
		$this->assignRef('standartId'  , $standartId);
		$this->assignRef('sonGorusTarihi'  , $sonGorusTarihi);
		//$this->assignRef('sinavTurleri'  , $sinavTurleri);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
