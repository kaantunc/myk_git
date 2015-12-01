<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class BelgelendirmeViewBelge_Olusturma extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$redirect	= "index.php?option=com_belgelendirme&view=belge_olusturma";
		
		$model = JModel::getInstance('belgelendirme_islemleri','belgelendirmeModel');
// 		$model=$this->getModel( 'belgelendirme_islemleri' );

		$user =& JFactory::getUser();
		$layout	= JRequest::getVar ("layout");
		
		$user_id =  $user->getOracleUserId ();
		
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$message   	= YETKI_MESAJ;
		
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		if (!$aut2 and !$aut3)
			$mainframe->redirect('index.php?', $message);
		
// 		if ($layout==""){
// 			$mainframe->redirect($redirect.'&layout=belgelendirme_program');
// 		}
		$post = JRequest::get( 'post' );
		$get = JRequest::get('get');
        $file = JRequest::get('files');
		
			$sayfalar=array("yapilan_sinavlar"=>"Tamamlanmış Sınavlar","gelecek_sinavlar"=>"Açık Sınavlar",
                "yapilmayan_sinavlar"=>"Tamamlanmayan Sınavlar","iptal_sinavlar"=>"İptal Edilen Sınavlar");
         	$sayfaLink='<div class="anaDiv"><table style="width:100%; text-align:center;"  border="0" cellpadding="0" cellspacing="10"><tr>';
         	foreach ($sayfalar as $key=>$value){
         		$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
         		if ($key==$layout) {
         			$stil.='color:white;background-color:#3C91FF;font-weight:bold;';
         		} else {
         			$stil.='background-color:#ffffff;color:black;';
         		}
         		$stil.='"';
         		if($key == 'gelecek_sinavlar'){
         			if($layout == 'gelecek_sinavlar'){
         				$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
         				$stil.='color:white;background-color:#3C91FF;font-weight:bold;';
         				$stil.='"';
         			}else if($layout == 'sonuc_sinavlar'){
         				$stil='style="border:1px solid #1C617C;margin:2px;padding:5px;';
         				$stil.='color:white;background-color:#3C91FF;font-weight:bold;';
         				$stil.='"';
         			}
         			$sayfaLink .='<td colspan="2"><a href="'.$redirect.'&layout='.$key.'" '.$stil.'>'.$value.'</a></td>';
         		}else{
         			$sayfaLink .='<td><a href="'.$redirect.'&layout='.$key.'" '.$stil.'>'.$value.'</a></td>';
         		}
         	}
         	$sayfaLink.='</tr><tr><td></td>';
         	
         	if($layout == 'gelecek_sinavlar'){
         		$sayfaLink.='<td><a href="'.$redirect.'&layout='.$layout.'" style="border:1px solid #1C617C;padding:5px;color:white;background-color:#3C91FF;font-weight:bold;">Yapılacak Sınavlar</a></td>';
         		$sayfaLink.='<td><a href="'.$redirect.'&layout=sonuc_sinavlar" style="border:1px solid #1C617C;padding:5px;background-color:#ffffff;color:black;">Yapılmış Sınavlar</a></td>';
         	}else if($layout == 'sonuc_sinavlar'){
         		$sayfaLink.='<td><a href="'.$redirect.'&layout=gelecek_sinavlar" style="border:1px solid #1C617C;padding:5px;background-color:#ffffff;color:black;">Yapılacak Sınavlar</a></td>';
         		$sayfaLink.='<td><a href="'.$redirect.'&layout='.$layout.'" style="border:1px solid #1C617C;padding:5px;color:white;background-color:#3C91FF;font-weight:bold;">Yapılmış Sınavlar</a></td>';
         	}else{
         		$sayfaLink.='<td><a href="'.$redirect.'&layout=gelecek_sinavlar" style="border:1px solid #1C617C;padding:5px;background-color:#ffffff;color:black;">Yapılacak Sınavlar</a></td>';
         		$sayfaLink.='<td><a href="'.$redirect.'&layout=sonuc_sinavlar" style="border:1px solid #1C617C;padding:5px;background-color:#ffffff;color:black;">Yapılmış Sınavlar</a></td>';
         	}
         	
         	
         	
         	$sayfaLink.='</table></div>';
		
         if($layout == 'belge_adaylar'){
            $sonuc = $model->BelgeAdaylariKaydet($post,$file);
            if(is_array($sonuc) && isset($sonuc['hata'])){
                $mainframe->redirect('index.php?option=com_belgelendirme&view=belge_olusturma', $sonuc['hata'],'error');
            }
            else if($sonuc == -1){
            	$mainframe->redirect('index.php?option=com_belgelendirme&view=belge_olusturma&layout=sinav_belgeleri', 'Kuruluşun yapmadığı sınavlardan belge verdiğiniz için belge verdiğiniz adayları bu sayfada arayarak excelini oluşturabilirsiniz.');
            }
            $sinavId = $model->getSinavIdWithBasvuruId($post);
            $model->sinavBirimTxt(array('sinavId'=>$sinavId));
            $this->assignRef('belgeAdayExcel', $sonuc);
            $this->assignRef('sinavId', $sinavId);
            $yeterlilik = $model->YeterlilikSinavBilgileri($sinavId);
            $this->assignRef('yeterlilik', $yeterlilik[0]);
         }
         else if($layout == 'sinav_belgeleri'){
         	$BelgelendirilenKuruluslar = $model->getBelgelendirmeYapilanKuruluslar();
         	$this->assignRef('Belgekuruluslar', $BelgelendirilenKuruluslar);
         }
         else if($layout == 'belgeExcel'){
         	$belgeAdayExcel = $model->getAdayBelgeExcel($get);
         	$this->assignRef('belgeAdayExcel', $belgeAdayExcel);
         }
         else if($layout == 'belgenoal'){
         	$yeterlilik = $model->YeterlilikMYKWeb();
         	$this->assignRef('yeterlilik', $yeterlilik);
         }
         else if($layout == 'yapilan_sinavlar'){
         	$yets = $model->SinavYapilanYeterlilikler(2);
         	$kurs = $model->SinavYapanKuruluslar(2);
             $post['durum'] = 2;
             $sinavlar = array();
             if(array_key_exists('basTarih',$post) && !empty($post['basTarih'])){
                 $sinavlar = $model->GetSinavlariAra($post);
             }

         	$this->assignRef('kurs', $kurs);
         	$this->assignRef('yets', $yets);
         	$this->assignRef('sayfaLink', $sayfaLink);
             $this->assignRef('sinavlar',$sinavlar);
         }
         else if($layout == 'gelecek_sinavlar'){
         	$yets = $model->SinavYapilanYeterlilikler(4);
         	$kurs = $model->SinavYapanKuruluslar(4);
             $post['durum'] = 4;
             $sinavlar = array();
             if(array_key_exists('basTarih',$post) && !empty($post['basTarih'])){
                 $sinavlar = $model->GetSinavlariAra($post);
             }

         	$this->assignRef('kurs', $kurs);
         	$this->assignRef('yets', $yets);
         	$this->assignRef('sayfaLink', $sayfaLink);
             $this->assignRef('sinavlar',$sinavlar);
         }
         else if($layout == 'yapilmayan_sinavlar'){
         	$yets = $model->SinavYapilanYeterlilikler(0);
         	$kurs = $model->SinavYapanKuruluslar(0);
             $post['durum'] = 0;
             $sinavlar = array();
             if(array_key_exists('basTarih',$post) && !empty($post['basTarih'])){
                 $sinavlar = $model->GetSinavlariAra($post);
             }

         	$this->assignRef('kurs', $kurs);
         	$this->assignRef('yets', $yets);
         	$this->assignRef('sayfaLink', $sayfaLink);
             $this->assignRef('sinavlar',$sinavlar);
         }
         else if($layout == 'iptal_sinavlar'){
             $yets = $model->SinavYapilanYeterlilikler(3);
             $kurs = $model->SinavYapanKuruluslar(3);
             $post['durum'] = 3;
             $sinavlar = array();
             if(array_key_exists('basTarih',$post) && !empty($post['basTarih'])){
                 $sinavlar = $model->GetSinavlariAra($post);
             }

             $this->assignRef('kurs', $kurs);
             $this->assignRef('yets', $yets);
             $this->assignRef('sayfaLink', $sayfaLink);
             $this->assignRef('sinavlar',$sinavlar);
         }
         else if($layout == 'sonuc_sinavlar'){
             $yets = $model->SinavYapilanYeterlilikler(1);
             $kurs = $model->SinavYapanKuruluslar(1);
             $post['durum'] = 1;
             $sinavlar = array();
             if(array_key_exists('basTarih',$post) && !empty($post['basTarih'])){
                 $sinavlar = $model->GetSinavlariAra($post);
             }

             $this->assignRef('kurs', $kurs);
             $this->assignRef('yets', $yets);
             $this->assignRef('sayfaLink', $sayfaLink);
             $this->assignRef('sinavlar',$sinavlar);
         }
         else if($layout == 'sinavbirimtxt'){
         	$model->sinavBirimTxt($get);
         }
         else if($layout == 'belge_durum'){
         	$belgeNo = urldecode($get['belgeNo']);
         	$belgeNoBilgi = $model->belgeNoBilgi($belgeNo);
         	$this->assignRef('belgeNoBilgi', $belgeNoBilgi);
         }else if($layout == 'belge_duzenleme'){
         	$belgeNo = urldecode($get['belgeNo']);
         	$belgeNoBilgi = $model->belgeNoBilgi($belgeNo);
         	$this->assignRef('belgeNoBilgi', $belgeNoBilgi);
         }

		if(isset($get['kurulusId']) && isset($get['sinavId'])){
			$kurulus = $get['kurulusId'];
			$this->assignRef('kurulusId', $kurulus);
			$sinavId = $get['sinavId'];
			$this->assignRef('sinavId', $sinavId);
			
			if(!FormFactory::KurulusIcinGorevliMi($user_id,$kurulus) && $user_id != 40){
				$mainframe->redirect('index.php?option=com_belgelendirme&view=belge_olusturma', 'Bu kuruluş için görevli değilsiniz.','error');
			}
			
			$sinavlar = $model->KurulusSinavlar(array('sınavId'=>$sinavId,'kurulus_id'=>$kurulus,'durum_id'=>1));
			$this->assignRef('sinavlar', $sinavlar);
			$belgeAdaylar = $model->BelgeAdayGetir(array('sınavId'=>$sinavId,'kurulusId'=>$kurulus,'durum_id'=>1));
			$this->assignRef('belgeAdaylar', $belgeAdaylar);
			$belgeSablon = $model->BelgeSablonGetir(array('sınavId'=>$sinavId,'kurulusId'=>$kurulus));
			$this->assignRef('belgeSablon', $belgeSablon);
		}
		$kuruluslar = $model->getBelgelendirmeBekleyenKuruluslar($user_id);
		$this->assignRef('kuruluslar', $kuruluslar);
		
		parent::display($tpl);
	}
}

?>