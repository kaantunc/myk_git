<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );

class SinavViewSinav_Sonucu_Gir extends JView
{
	function display($tpl = null)
	{
//		require_once( JPATH_COMPONENT.DS.'models'.DS.'yt_url.php' );
//		$ytModel = new RateModelYt_Url();

		$user =& JFactory::getUser();
		if($user->get('guest')){
        	global $mainframe;
        	$mainframe->redirect('index.php?option=com_user&view=login',JText::_('LOGIN_DESCRIPTION'));
        }
		
		$model = &$this->getModel();
		
		$db = & JFactory::getOracleDBO();
		$postData = JRequest::get( 'post' );
		$getData = JRequest::get( 'get' );
		
		$ogrenciler  = $model->getOgrListe($db, $getData);
		
		if($ogrenciler == -1){
        	global $mainframe;
        	$mainframe->redirect('index.php',JText::_('EVRAK_YETKI_HATASI'), "error");
        }
		
		$sinavDurumlari = $model->getSinavDurumlariCombo($db);
//		
//		echo '$ogrenciler:<pre>';
//		print_r($ogrenciler);
//		echo '</pre>';
//		foreach ($rows as $row) {
//			if(strpos($row->file_path, 'youtube')!==FALSE){
//				$pageContent = file_get_contents($row->file_path);
//				$row->file_path = $ytModel->getFullUrl($row->file_path, $pageContent);
//			}
//		}
		
		$this->assignRef('postData'  , $postData);
		$this->assignRef('ogrenciler'  , $ogrenciler);
		$this->assignRef('sinavDurumlari'  , $sinavDurumlari);
		parent::display($tpl);
	}	
}
?>
