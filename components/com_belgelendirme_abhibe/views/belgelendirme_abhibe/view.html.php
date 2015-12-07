<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Belgelendirme_AbhibeViewBelgelendirme_Abhibe extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");
		$redirect = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe";
		$user_id	= $user->getOracleUserId ();
		$group_id   = T3_GROUP_ID;
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		$aut = FormFactory::checkAuthorization  ($user, $group_id);
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		$OnayUserMi = $model->OnayUserMi($user_id);
		$this->assignRef('OnayUserMi', $OnayUserMi);
		
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		if (!$aut and !$aut2 and !$aut3)
			$mainframe->redirect('index.php?', $message);
		
		$canEdit = false;
		if($aut || $aut2 || $aut3){
			$canEdit = true;
		}
		$this->assignRef('canEdit', $canEdit);

	    if (!isset ($layout)){
    		$layout = "default";
			$this->setLayout($layout);
		}
		
		$this->assignRef('user_id', $user_id);
		
		if($layout == "default" && !$OnayUserMi){
			$TesvikIstekleri = $model->TesvikIstekleri($user_id);
			$this->assignRef('TesvikIstekleri', $TesvikIstekleri);
			$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
			// 					$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru('04-10-2015');
			$this->assignRef('doviz', $doviz);
			$this->assignRef('ABKurKota', FormABHibeUcretHesabi::KuruluABHibeToplamKota($user_id));
			$this->assignRef('ABKurKullanilanKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($user_id));
			$this->assignRef('ABKurKullanilanDezKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($user_id));
			$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($user_id));
			$this->assignRef('ABKurBekKota', FormABHibeUcretHesabi::KuruluABHibeBekKota($user_id));
			$this->assignRef('ABKurBekDezKota', FormABHibeUcretHesabi::KuruluABHibeBekDezKota($user_id));
		}else if($layout == "tesvik_adaylar"){
			if(array_key_exists('bitTarih', $post)){
				if(!empty($post['bitTarih'])){
					$TesvikAdaylar = $model->TesvikIstekAdaylarWithTarih($user_id,$post['bitTarih']);
					$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
					$this->assignRef('bitTarih', $post['bitTarih']);
					$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
// 					$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru('04-10-2015');
					$this->assignRef('doviz', $doviz);
					$this->assignRef('ABKurKota', FormABHibeUcretHesabi::KuruluABHibeToplamKota($user_id));
					$this->assignRef('ABKurKullanilanKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($user_id));
					$this->assignRef('ABKurKullanilanDezKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($user_id));
					$this->assignRef('ABKurBekKota', FormABHibeUcretHesabi::KuruluABHibeBekKota($user_id));
					$this->assignRef('ABKurBekDezKota', FormABHibeUcretHesabi::KuruluABHibeBekDezKota($user_id));
					$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($user_id));
				}else{
					$mainframe->redirect($redirect,'Lütfen Tarih Alanını Boş Bırakmayınız.','error');
				}
			}else{
				$mainframe->redirect($redirect,'Lütfen Tarih Alanını Boş Bırakmayınız.','error');
			}
		}else if($layout == "tesvik_edit" && !$OnayUserMi){
			if(array_key_exists('IstekId', $get) && is_numeric($get['IstekId']) && $model->TesvikYetkiliMi($user_id,$get['IstekId'])){
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				if($tesvik['DURUM'] != 0 || !$tesvik){
					$mainframe->redirect($redirect,'Bu sayfayı görüntüleme yetkiniz yoktur.','error');
				}
				$this->assignRef('tesvik', $tesvik);
				$tesvikAday = $model->GetTesvikAdaylarWithTesvikId($get['IstekId']);
				$this->assignRef('tesvikAday', $tesvikAday);
				$TesvikAdaylar = $model->TesvikAdaylarEditWithTarih($user_id,$get['IstekId'],$tesvik['BIT_TARIH']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
				$this->assignRef('IstekId', $get['IstekId']);
				$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
				// 					$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru('04-10-2015');
				$this->assignRef('doviz', $doviz);
				$this->assignRef('ABKurKota', FormABHibeUcretHesabi::KuruluABHibeToplamKota($user_id));
				// Kalan Kotaya tekrardan bak
				$this->assignRef('ABKurKullanilanKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($user_id));
				$this->assignRef('ABKurKullanilanDezKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($user_id));
				$this->assignRef('ABKurBekKota', FormABHibeUcretHesabi::KuruluABHibeBekKota($user_id));
				$this->assignRef('ABKurBekDezKota', FormABHibeUcretHesabi::KuruluABHibeBekDezKota($user_id));
				$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($user_id));
			}else{
				$mainframe->redirect($redirect,'Bir hata meydana geldi.','error');
			}
		}else if($layout == "tesvik_adaylar_odeme"){
			if(array_key_exists('IstekId', $get) && !empty($get['IstekId'])){
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				$this->assignRef('tesvik', $tesvik);
				if($tesvik['DURUM'] != 2 || !$tesvik){
					$mainframe->redirect($redirect,'Bu sayfayı görüntüleme yetkiniz yoktur.','error');
				}
				$TesvikAdaylar = $model->TesvikAdaylarWithTesvikId($get['IstekId']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
				$this->assignRef('IstekId', $get['IstekId']);
				$this->assignRef('ABKurKota', FormABHibeUcretHesabi::KuruluABHibeToplamKota($tesvik['USER_ID']));
				// Kalan Kotaya tekrardan bak
				$this->assignRef('ABKurKullanilanKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($tesvik['USER_ID']));
				$this->assignRef('ABKurKullanilanDezKota', FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($tesvik['USER_ID']));
				$this->assignRef('ABKurBekKota', FormABHibeUcretHesabi::KuruluABHibeBekKota($tesvik['USER_ID']));
				$this->assignRef('ABKurBekDezKota', FormABHibeUcretHesabi::KuruluABHibeBekDezKota($tesvik['USER_ID']));
				$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($tesvik['USER_ID']));
				$this->assignRef('kurBilgi', $model->getKurulusBilgi($tesvik['USER_ID']));
			}else{
				$mainframe->redirect($redirect,'Bir hata meydana geldi.','error');
			}
		}else if($layout == "aday_basvuru"){
			if(array_key_exists('IstekId', $get) && !empty($get['IstekId'])){
				$AdayBasvuru = $model->AdayBasvuruFile($get['IstekId']);
				$this->assignRef('AdayBasvuru', $AdayBasvuru);
				$this->assign('IstekId',$get['IstekId']);
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "aday_odeme"){
			if(array_key_exists('IstekId', $get) && !empty($get['IstekId'])){
				$AdayBasvuru = $model->AdayOdemeFile($get['IstekId']);
				$this->assignRef('AdayBasvuru', $AdayBasvuru);
				$this->assign('IstekId',$get['IstekId']);
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "tesvikpdf"){
			if(array_key_exists('IstekId', $get) && !empty($get['IstekId'])){
				$this->assignRef('IstekId', $get['IstekId']);
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				$this->assignRef('tesvik', $tesvik);
				$TesvikAdaylar = $model->TesvikAdaylarWithTesvikId($get['IstekId']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
				$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($user_id));
				$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
				$this->assignRef('doviz', $doviz);
				$this->assignRef('kurBilgi', $model->getKurulusBilgi($tesvik['USER_ID']));
			}else{
				$mainframe->redirect($redirect);
			}
		}else if($layout == "tesvik_istekleri" && $OnayUserMi){
			if(array_key_exists('IstekDurum', $get) && !empty($get['IstekDurum'])){
				if($get['IstekDurum'] == '2'){
					$IstekDurum = "2";
					$TesvikIstekleri = $model->TesvikIstekleriWithDurum($IstekDurum);
					$sayfa = '<div class="anaDiv">';
					$sayfa .= '<div class="divYan"><a class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri&IstekDurum=1">Onay Bekleyen İstekler</a></div>';
					$sayfa .= '<div class="divYan"><a class="btn btn-success" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri&IstekDurum=2">Onaylanan İstekler</a></div>';
					$sayfa .= '</div>';
				}else{
					$IstekDurum = "1";
					$TesvikIstekleri = $model->TesvikIstekleriWithDurum($IstekDurum);
					$sayfa = '<div class="anaDiv">';
					$sayfa .= '<div class="divYan"><a class="btn btn-success" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri&IstekDurum=1">Onay Bekleyen İstekler</a></div>';
					$sayfa .= '<div class="divYan"><a class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri&IstekDurum=2">Onaylanan İstekler</a></div>';
					$sayfa .= '</div>';
				}
			}else{
				$IstekDurum = "1";
				$TesvikIstekleri = $model->TesvikIstekleriWithDurum($IstekDurum);
				$sayfa = '<div class="anaDiv">';
				$sayfa .= '<div class="divYan"><a class="btn btn-success" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri&IstekDurum=1">Onay Bekleyen İstekler</a></div>';
				$sayfa .= '<div class="divYan"><a class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_istekleri&IstekDurum=2">Onaylanan İstekler</a></div>';
				$sayfa .= '</div>';
			}
			
			$this->assignRef('sayfa', $sayfa);
			$this->assignRef('durum', $IstekDurum);
			$this->assignRef('TesvikIstekleri', $TesvikIstekleri);
		}else if($layout == 'test' && $OnayUserMi){
			$model->TestButunTarihlerUpdate();
		}else if($layout == "testtesvikpdf"){

        }else if($layout == 'basvuru_listesi'){
            $basvuruExcel = $model->BasvuruExcel($user_id);
            $this->assignRef('basvuruExcel',$basvuruExcel);
        }else if($layout == "abaday"){
            $bNo = '';
            if(array_key_exists('bNo',$get)){
                $bNo = $get['bNo'];
            }
            $this->assignRef('bNo',$bNo);
        }

		parent::display($tpl);
	}	
}
?>
