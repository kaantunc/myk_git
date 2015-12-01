<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeViewSonuc_Bildirim extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belgelendirme&view=belgelendirme_islemleri";
		$redirectBelge	= "index.php?option=com_belgelendirme&view=sonuc_bildirim";
		$model = JModel::getInstance('belgelendirme_islemleri','belgelendirmeModel');
		
		$user =& JFactory::getUser();
		$layout		= JRequest::getVar ("layout");
		
		$user_id =  $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		if (!$aut and !$aut2 and !$aut3)
			$mainframe->redirect('index.php?', $message);
		
		if ($layout==""){
			$mainframe->redirect($redirect.'&layout=belgelendirme_program');
		}
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		$sayfalar=array("aday_bildirim"=>"Belgelendirilecek Adaylar","belgeno_bildirim"=>"Aday Belge Numarası");
		$sayfaLink='<div style="margin-bottom:20px;">';
		
		foreach ($sayfalar as $key=>$value){
			$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
			if ($key==$layout) {
				$stil.='color:white;background-color:#3C91FF;';
			} else {
				$stil.='background-color:#ffffff;color:black;';
			}
			$stil.='"';
			$sayfaLink .='<span '.$stil.'>'.$value.'</span>';
		}
		$sayfaLink.='</div>';
		
		//SORGU SONUC
		if ($layout == 'aday_bildirim' && isset($_GET['sinavId'])){
			if (!$model->sinavKurulusKontrol($_GET['sinavId'], $user_id)){
				$message = "Bu işlem için yetkiniz yok.";
				$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program', $message,'error');
			}else{
				$sonucs = $model->sonucGonderilecekAdaylar($_GET);
				if(count($sonucs[0]) == 0){
					// Belgelendirilecek aday yoksa SonucBos'a gönder sınav sonuc durumu bildirildi yap.
					$model->SonucBos($_GET['sinavId']);
					$msg = 'Sınav Sonuç Bildirimi Tamamlanmıştır. Bu sınav sonucunda belge almaya hak kazanan aday bulunmamaktadır.';
					$mainframe->redirect('index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=2',$msg);
				}else{
					$this->assignRef('sonucs', $sonucs);
					$this->assignRef('sinavId', $_GET['sinavId']);
					$kurs = FormFactory::getKurulusValues($user_id);
					$this->assignRef('kurs', $kurs);
					$yets = $model->getSinavBilgi($_GET['sinavId']);
					$this->assignRef('yets', $yets);
				}
			}
		}
		else if($layout == 'belgeno_bildirim'){
			$basarili = $model->AdayBilgi($_POST['basarili']);
			$basariliUcretData = $model->AdayUcretBilgileri($_POST['basarili'],$_POST['sinav']);
			$basarisiz = $model->AdayBilgi($_POST['basarisiz']);
			
			$tesvikArray = $model->AdayArrayTesvikFarmi($_POST['basarili']);
			$this->assignRef('tesvikArray', $tesvikArray);
			
			$aciklama =  $_POST['aciklama'];
			$this->assignRef('aciklama', $aciklama);
			$this->assignRef('basarili', $basarili);
			$this->assignRef('basariliUcretData', $basariliUcretData);
			$this->assignRef('basarisiz', $basarisiz);
			$yets = $model->getSinavBilgi($_POST['sinav']);
			$this->assignRef('yets', $yets);
			$sonbelgeNo = $model->SonBelgeNo($yets[0]['YETERLILIK_ID']);
			$this->assignRef('sonBelgeNo', $sonbelgeNo);
			$this->assignRef('sinav_id', $_POST['sinav']);
			$kurs = FormFactory::getKurulusValues($user_id);
			$this->assignRef('kurs', $kurs);
			$yeterlilikBkUcret = $model->getYeterLilikBkUcret($yets[0]['YETERLILIK_ID']);
			$this->assignRef('yeterlilikBkUcret', $yeterlilikBkUcret);
			
			// AB Hibe Bilgileri
			$ABProVarMi = FormABHibeUcretHesabi::KurulusProtokolVarMi($user_id);
			$this->assignRef('ABProVarMi', $ABProVarMi);
			$ABHibeArray = $model->AdayArrayABHibeFarmi($_POST['basarili'],$yets[0]['YETERLILIK_ID']);
			$this->assignRef('ABHibeArray', $ABHibeArray);
			$basariliABHibeUcretData = $model->AdayABHibeUcretBilgileri($_POST['basarili'],$_POST['sinav']);
			$this->assignRef('basariliABHibeUcretData', $basariliABHibeUcretData);
		}
		else if($layout == 'tarih_bildirim'){
			
		}
		else if($layout == "belgewithkimlik"){
			$this->assignRef('kurulusId', $user_id);
		}
		else if($layout == "belgewithbelgeno"){
			$this->assignRef('kurulusId', $user_id);
		}
		else if($layout == "belgewithsinav"){
			$this->assignRef('kurulusId', $user_id);
			
			$yets = $model->SinavYapilanYetsWithKur($user_id);
			$this->assignRef('yets', $yets);
		}
		else if($layout == "belgelilerwithsinav"){
			if(!array_key_exists('sinavId', $get)){
				$mainframe->redirect('index.php', 'Eksik veya Geçersiz işlem.');
			}else{
				$kurKontrol = $model->sinavKurulusKontrol($get['sinavId'],$user_id);
				if($kurKontrol){
					$belgeliler = $model->belgeliAdaylarWithSinavId($get['sinavId']);
					$this->assignRef('belgeliler', $belgeliler);
					
					$yets = $model->YeterlilikSinavBilgileri($get['sinavId']);
					$this->assignRef('yets', $yets);
					
					$kurs = FormFactory::getKurulusValues($user_id);
					$this->assignRef('kurs', $kurs);
				}else{
					$mainframe->redirect('index.php', 'Bu işlem için yetkinin bulunmamaktadır.','error');
				}
			}
		}
		
		$sayfalarBelge=array("belgewithkimlik"=>"Kimlik Numarası","belgewithbelgeno"=>"Belge Numarası",
				"belgewithsinav"=>"Sınav"
		);
		$sayfaLinkBelge='<div style="margin-bottom:20px;">';
			
		foreach ($sayfalarBelge as $key=>$value){
			$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
			if ($key==$layout) {
				$stil.='color:white;background-color:#3C91FF;';
			} else {
				$stil.='background-color:#ffffff;color:black;';
			}
			$stil.='"';
			$sayfaLinkBelge .='<a href="'.$redirectBelge.'&layout='.$key.'" '.$stil.'>'.$value.'</a>';
		}
		$sayfaLinkBelge.='</div>';
		
		$this->assignRef('sayfaLinkBelge', $sayfaLinkBelge);
		$this->assignRef('sayfaLink', $sayfaLink);
		
		parent::display($tpl);
	}
}

?>