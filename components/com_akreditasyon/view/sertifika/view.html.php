<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

// farklı layoutlarda yap
// session la fln halletcez son eklenen kapsam bilgilerini

// Kurulus bilgileri
// Sınava Giren Öğrenciler
// Sinav Sonuclari
// Sertifika sonuçları

class SinavViewSertifika extends JView
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
		$userId = JFactory::getUser()->getOracleUserId();
		
		$session =&JFactory::getSession();
		
		$mode = JRequest::getVar('mode');
		
		if($mode != null){
			$postData = $session->get('sertifikaPostData');
		}
		else{
			$postData = JRequest::get( 'post' );
			$session->set('sertifikaPostData', $postData);
		
		}
				
//		echo '<pre>';
//		print_r($postData);
//		echo '</pre>';
		//$kapsamlarCombo = $model->getTumKapsamlar($db);
		$kapsamlar = $model->getKapsamlar($db, $postData);
		$ogrenciler = $model->getOgrenciler($db, $postData);
		$sinavIds = $model->getSelectedSinavIds($db, $userId, $postData);
		$sinavlar = $model->getSelectedSinavlar($db, $sinavIds);
		
		$tumSonuclar = $model->getTumSinavSonuclari($db, $sinavIds);
		
		$session =&JFactory::getSession();
		$session->set('tumSonuclar', $tumSonuclar);
		$session->set('ogrenciler', $ogrenciler);

//		echo '$sinavIds <pre>';
//		print_r($sinavlar);
//		echo '</pre>';
//		die();
		
		//$ogrenciler  = $model->getOgrList($db);
		//$sinavTurleri = $model->sinavTurleriAl($db);
		//$sinavSekilleri = $model->sinavSekilleriAl($db);
		
//		foreach ($rows as $row) {
//			if(strpos($row->file_path, 'youtube')!==FALSE){
//				$pageContent = file_get_contents($row->file_path);
//				$row->file_path = $ytModel->getFullUrl($row->file_path, $pageContent);
//			}
//		}
		$sinavIds = serialize($sinavIds);
		$sinavIds=str_replace(array('&','"','\'','<','>',"\t",),
				array('&amp;','&quot;','&#039;','&lt;','&gt;','&nbsp;&nbsp;'),
				$sinavIds);
//				echo '$sinavIds <pre>';
//		print_r($sinavIds);
//		echo '</pre>';
		
		$this->assignRef('sinavlar'  , $sinavlar);
		$this->assignRef('kapsamlar'  , $kapsamlar);
		$this->assignRef('ogrenciler'  , $ogrenciler);
		$this->assignRef('sinavIds'  , $sinavIds);
		$this->assignRef('tumSonuclar'  , $tumSonuclar);
		//$this->assignRef('sinavSekilleri'  , $sinavSekilleri);
		parent::display($tpl);
		
	}	
}
?>
