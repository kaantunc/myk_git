<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeViewTekrar_Basim extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belgelendirme&view=belge_olusturma";
		
		$model = JModel::getInstance('belge_edit','belgelendirmeModel');
// 		$model=$this->getModel( 'belgelendirme_islemleri' );

		$user =& JFactory::getUser();
		$layout	= JRequest::getVar ("layout");
		
		$user_id =  $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$canEdit = true;
		
		if (!$aut2 and !$aut3 and !$aut){
			$mainframe->redirect('index.php?', $message);
		}
		
		if (!$aut2 and !$aut3){
// 			$mainframe->redirect('index.php?', $message);
			$canEdit = false;
		}
		$this->assignRef('canEdit', $canEdit);
		
		if ($layout=="" || empty($layout)){
			$layout = "default";
		}
		$post = JRequest::get( 'post' );
		$get = JRequest::get('get');
        $file = JRequest::get('files');
		
        if($layout == "default"){
        	$BasimTalep = $model->getBasimTalep();
        	$this->assignRef('BasimTalep', $BasimTalep);
        }
        else if($layout == 'belgeExcel'){
         	$belgeAdayExcel = $model->getAdayBelgeExcel($get['belgeNo']);
         	$this->assignRef('belgeAdayExcel', $belgeAdayExcel);
        }
        else if($layout == "belge_duzenleme"){
        	$belgeNo = urldecode($get['belgeNo']);
        	
//         	if($model->BelgeBasimdaMi($belgeNo)){
//         		$message = 'Açmak istediğiz belge basım aşamasında olduğu için görüntüleyezmisiniz.';
//         		$mainframe->redirect('index.php?', $message, 'error');
//         	}
        	
        	if($canEdit){
        		$belgeNoBilgi = $model->belgeNoBilgi($belgeNo);
        	}else{
        		$belgeNoBilgi = $model->belgeNoBilgi($belgeNo,$user_id);
        	}
        	if(!$belgeNoBilgi){
        		$message = 'Kendinize ait olmayan belgeleri düzenlemeyez veya tekrar basıma gönderemezsiniz.';
        		$mainframe->redirect('index.php?', $message, 'error');
        	}
        	
        	$this->assignRef('belgeNoBilgi', $belgeNoBilgi);
        	
        	$BelgeBirimOnayBekleyen = $model->BelgeBirimleriOnayBekliyorMu($belgeNo);
        	$this->assignRef('BelgeBirimOnayBekleyen', $BelgeBirimOnayBekleyen);
        	$BelgeNoOnayBekleyen = $model->BelgeNoEditMiByBelgeNo($belgeNo);
        	$this->assignRef('BelgeNoOnayBekleyen', $BelgeNoOnayBekleyen);
        	$BelgeTarihOnayBekleyen = $model->BelgeTarihEditMiByBelgeNo($belgeNo);
        	$this->assignRef('BelgeTarihOnayBekleyen', $BelgeTarihOnayBekleyen);
        	
//         	$app = &JFactory::getApplication();
//         	$app->enqueueMessage("File was submitted successfully!");
//         	JError::raiseNotice( 100, 'Notice' );
//         	JError::raiseWarning( 100, 'Warning' );
        }
        else if($layout == 'belgewithbelgeno'){
        	
        }
        else if($layout == 'belgewithkimlik'){
        	 
        }

// 		if(isset($get['kurulusId']) && isset($get['sinavId'])){
// 			$kurulus = $get['kurulusId'];
// 			$this->assignRef('kurulusId', $kurulus);
// 			$sinavId = $get['sinavId'];
// 			$this->assignRef('sinavId', $sinavId);
			
// 			if(!FormFactory::KurulusIcinGorevliMi($user_id,$kurulus) && $user_id != 40){
// 				$mainframe->redirect('index.php?option=com_belgelendirme&view=belge_olusturma', 'Bu kuruluş için görevli değilsiniz.','error');
// 			}
			
// 			$sinavlar = $model->KurulusSinavlar(array('sınavId'=>$sinavId,'kurulus_id'=>$kurulus,'durum_id'=>1));
// 			$this->assignRef('sinavlar', $sinavlar);
// 			$belgeAdaylar = $model->BelgeAdayGetir(array('sınavId'=>$sinavId,'kurulusId'=>$kurulus,'durum_id'=>1));
// 			$this->assignRef('belgeAdaylar', $belgeAdaylar);
// 			$belgeSablon = $model->BelgeSablonGetir(array('sınavId'=>$sinavId,'kurulusId'=>$kurulus));
// 			$this->assignRef('belgeSablon', $belgeSablon);
// 		}
// 		$kuruluslar = $model->getBelgelendirmeBekleyenKuruluslar($user_id);
// 		$this->assignRef('kuruluslar', $kuruluslar);
		
		parent::display($tpl);
	}
}

?>