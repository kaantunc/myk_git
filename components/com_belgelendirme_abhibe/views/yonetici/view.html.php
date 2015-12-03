<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Belgelendirme_AbhibeViewYonetici extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		$user 	 	= &JFactory::getUser();
		$model 	  	= &$this->getModel();
		$layout		= JRequest::getVar ("layout");	
		$user_id	= $user->getOracleUserId ();
		$this->assignRef('user_id', $user_id);
		$message   	= YETKI_MESAJ;
		$abYon   = 1;
		$SBG = 1;
		$aut = FormFactory::checkAuthorization  ($user, 32);
        $redirect = "index.php?option=com_belgelendirme_abhibe&view=yonetici";
		$post = JRequest::get( 'post' );
		$get = JRequest::get( 'get' );
		
		if(!$aut){
			$mainframe->redirect('index.php?', $message);
		}
		
// 		if (!$abYon && $SBG)
// 			$mainframe->redirect('index.php?', $message);

	    if (!isset ($layout)){
    		$layout = "default";
			$this->setLayout($layout);
		}
		
		$TopDurum = $model->DurumToplamlari();
		
		$itirazSayfa = array(0 => 'Geri Gönderilen', 1 => 'Onay Bekleyen', 2=>'Ödeme Dosyası Beklenen', 3=>'Ödeme Dosyası Yüklenen',
				4=>'Ödeme Bekleyen', 5=>'Geri Ödenen');
			
		if(array_key_exists('dId', $get) && !empty($get['dId']) && is_numeric($get['dId'])){
			$dId = $get['dId'];
		}else{
			$dId = 1;
		}
		
		$iLink = '<div class="anaDiv">';
		foreach($itirazSayfa as $key=>$val){
			$durTop = 0;
			if(array_key_exists($key, $TopDurum)){
				$durTop = $TopDurum[$key];
			}
			$iLink .= '<div class="divYan">';
			if($key == $dId){
				$iLink .= '<a class="btn btn-success" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=default&dId='.$key.'">'.$val.' ('.$durTop.')</a>';
			}else{
				$iLink .= '<a class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme_abhibe&view=yonetici&layout=default&dId='.$key.'">'.$val.' ('.$durTop.')</a>';
			}
			$iLink .='</div>';
		}
		$iLink .='</div>';
		
		if($layout == "default"){
			$TesvikIstekleri = $model->TesvikIstekleriWithDurum($dId);
			$this->assignRef('TesvikIstekleri', $TesvikIstekleri);
			$this->assignRef('dId', $dId);
			$this->assignRef('iLink', $iLink);
		}else if($layout == "tesvik_adaylar"){
		if(array_key_exists('IstekId', $get) && is_numeric($get['IstekId']) /*&& $model->TesvikYetkiliMi($user_id,$get['IstekId'])*/){
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				$this->assignRef('tesvik', $tesvik);
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
		}else if($layout == "tesvik_edit"){
			if(array_key_exists('IstekId', $get) && is_numeric($get['IstekId']) /*&& $model->TesvikYetkiliMi($user_id,$get['IstekId'])*/){
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				$this->assignRef('tesvik', $tesvik);
				$TesvikAdaylar = $model->TesvikAdaylarWithTesvikId($get['IstekId']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
// 				$TesvikAdaylar = $model->TesvikAdaylarEditWithTarih($user_id,$get['IstekId'],$tesvik['BIT_TARIH']);
// 				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
				$this->assignRef('IstekId', $get['IstekId']);
				$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
// 				$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru('04-10-2015');
				$this->assignRef('doviz', $doviz);
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
		}else if($layout == "tesvikpdf"){
		if(array_key_exists('IstekId', $get) && !empty($get['IstekId'])){
				$this->assignRef('IstekId', $get['IstekId']);
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				if($tesvik['DOVIZ_KURU'] == null){
					$model->DovizKuruBelirle($get['IstekId']);
				}
				$tesvik = $model->GetTesvikWithTesvikId($get['IstekId']);
				$this->assignRef('tesvik', $tesvik);
				$TesvikAdaylar = $model->TesvikAdaylarWithTesvikId($get['IstekId']);
				$this->assignRef('TesvikAdaylar', $TesvikAdaylar);
				$this->assignRef('ABKurPro', FormABHibeUcretHesabi::KuruluABHibeProtokol($tesvik['USER_ID']));
				$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
				$this->assignRef('doviz', $doviz);
				$this->assignRef('kurBilgi', $model->getKurulusBilgi($tesvik['USER_ID']));
			}else{
				$mainframe->redirect($redirect);
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
		}else if($layout == "tesvik_istekleri"){
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
		}else if($layout == 'test'){
			$model->TestButunTarihlerUpdate();
		}else if($layout == "atsorgu"){

        }else if($layout == "atword"){
            $data = $model->ATSorgu($post);
            if(!$data){
                $mainframe->redirect($redirect.'&layout=atsorgu','Aradığınız kriterlere ait AB Hibesi bulunmamaktadır.','error');
            }else{
                $this->assignRef('atData',$data);
                $this->assignRef('atTar',$post);
            }
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
