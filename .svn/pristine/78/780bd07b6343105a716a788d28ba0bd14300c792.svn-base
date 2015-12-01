<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();

require_once('libraries/form/captcha.php');


//patchSatirEkle ve rowAdded icin
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_yeterlilik_taslak/js/yeterlilik_taslak.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

$document->addStyleSheet( SITE_URL.'components/com_yeterlilik_taslak/assets/yeterlilik_taslak_yeni.css' );

$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

//DataTable
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'components/com_datatable/assets/datatable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.upper.min.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');


/**
 * Yeterlilik_Taslak Component Controller
 */
class Yeterlilik_TaslakController extends JController {
	
	function revizyonKaydet(){
		$model 		 	= $this->getModel('taslak_revizyon');
		$post 		 	= JRequest::get( 'post' );
		$yeterlilik_id 	= JRequest::getVar('yeterlilik_id');
		$redirectLink	= 'index.php?option=com_yeterlilik_taslak&view=taslak_revizyon&yeterlilik_id='.$yeterlilik_id;

		$message	 	= $model->revizyonKaydet ($post, $yeterlilik_id);
				
		$this->setRedirect($redirectLink, $message);
	}
	
	function gorusCevapla(){
						
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('gorus_kaydet');
		$post = JRequest::get( 'post' );
		$yeterlilikId = JRequest::getVar( 'yeterlilikId' );
		$message = $model->gorusCevapla($db, $post);
		        
		$this->setRedirect('index.php?option=com_yeterlilik_taslak&view=gorus_listele&yeterlilikId='. $yeterlilikId , $message);
		
	}
	
	function gorusKaydet(){
		
		captcha::check("index.php?option=com_yeterlilik_taslak&view=gorus_bildir&standartId=".JRequest::getVar("standartId"));
				
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('gorus_kaydet');
		$post = JRequest::get( 'post' );
		$message = $model->gorusKaydet($db, $post);
		        
		$this->setRedirect('index.php' , $message);
		
	}
	
	function taslakKaydet(){
		$layout		 = JRequest::getVar("layout");
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		$redirectLink= 'index.php?option=com_yeterlilik_taslak&layout='.$layout.'&yeterlilik_id='.$yeterlilik_id;

		$message	 = $model->taslakKaydet ($post, $layout, $evrak_id, $yeterlilik_id);
				
		$this->setRedirect($redirectLink, $message);
	}
	
 	function sektorSorumlusunaGonder (){
		$model 		 = $this->getModel('taslak_kaydet');
		$yeterlilik_id= JRequest::getVar('yeterlilik_id');	
		
		$model->sektorSorumlusunaGonder ($yeterlilik_id);
		
		$message 	 = "Yeterlilik Ön Taslağı Sektör Sorumlusu Onayına Gönderildi"; 
		$this->setRedirect('index.php', $message);
 	}
 	
 	function yorumKaydet (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout 	 = JRequest::getVar('layout');
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->yorumKaydet_SS ($post, $evrak_id, $layout);
		
		$message 	 = "Yorum Kaydedildi"; 
		$this->setRedirect('index.php?option=com_yeterlilik_taslak&layout='.$layout.'&yeterlilik_id='.$yeterlilik_id, $message);
 	}
 	
 	function yorumKaydet_Kurulus (){
 		$model 		 = $this->getModel('taslak_kaydet');
 		$post 		 = JRequest::get( 'post' );
 		$layout 	 = JRequest::getVar('layout');
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
 	
 		$model->yorumKaydet_Kurulus ($post, $evrak_id, $layout);
 	
 		$message 	 = "Yorum Kaydedildi";
 		$this->setRedirect('index.php?option=com_yeterlilik_taslak&layout='.$layout.'&yeterlilik_id='.$yeterlilik_id, $message);
 	}
 	
 	function yorumlariGonder (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->yorumlariGonder ($evrak_id);
		
		$message 	 = "Yorumlar Gönderildi"; 
		$this->setRedirect('index.php?option=com_yeterlilik_taslak&layout=tanitim&yeterlilik_id='.$yeterlilik_id, $message);
 	}
 	
	function onBasvuruOnayla (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->onBasvuruOnayla ($yeterlilik_id);
		
		$message 	 = "Yeterlilik Ön Taslağı Onaylandı. <br>Kuruluş tarafından başvurunun son onayının verilip, ıslak imzalı olarak MYK'ya gönderilmesini temin ediniz."; 
		$this->setRedirect('index.php?', $message);
 	}
 	
	function ulusalYeterlilikOlarakAta (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$success = $model->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK);
		
		if($success)
			$message = "Yeterlilik Ulusal Standart Olarak Kaydedildi."; 
		else
			$message = "Hata oluştu."; 
		
		$this->setRedirect('index.php?', $message);
 	}
	function SSnaGonderilmisOnTaslagiOnayla (){
		$model 		 = $this->getModel('taslak_kaydet');
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$success = $model->updateYeterlilikDurum($yeterlilik_id, PM_YETERLILIK_DURUMU__ONAYLANMIS_ONTASLAK);
		
		if($success)
			$message = "Yeterlilik Ön Taslağı Onaylandı."; 
		else
			$message = "Hata oluştu."; 
		
		$this->setRedirect('index.php?', $message);
 	}
 	
 	function onBasvuruBitir (){
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
		$evrak_id 	 = $this->getModel('yeterlilik_taslak')->getOracleEvrakId ($yeterlilik_id);
		
		$model->onBasvuruBitir ($evrak_id, $yeterlilik_id);

		$message 	 = "Yeterlilik Taslağı Sektör Sorumlusuna Gönderildi"; 
		$this->setRedirect('index.php?option=com_yeterlilik_taslak&layout=pdf_link&yeterlilik_id='.$yeterlilik_id, $message);
 	}
 	
 	function indir (){
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$id = JRequest::getVar('id');
 		
 		$model = $this->getModel('taslak_revizyon');
 		$model->pdfGoster ($yeterlilik_id, $id);
 	}
 	
 	/**
 	 * 
 	 * Secilen pdf belgesini veritabanindan siler.
 	 */
 	
 	function sil (){
 		$yeterlilik_id = JRequest::getVar('yeterlilik_id');
 		$id = JRequest::getVar('id');
 		$redirectLink = 'index.php?option=com_yeterlilik_taslak&view=taslak_revizyon&yeterlilik_id='.$yeterlilik_id;
 		
 		$model = $this->getModel('taslak_revizyon');
 		$message = $model->pdfSil ($yeterlilik_id, $id);
 		
 		$this->setRedirect($redirectLink, $message);
 	}
	
 	function getStandart (){
		$standartTur = JRequest::getVar('standartTur');
		
		if ($standartTur != "uluslararasi")
			echo json_encode( array("result"=>"success", "data"=>FormParametrik::getMeslekStandart ($standartTur)));
		else 
			echo json_encode( array("result"=>"error"));
 	}
 	
 	function getAjaxBagliBilgi(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 		
 		echo json_encode($model->getAjaxBagliBilgi($post));
 	}
 	
 	function ajaxDelBilgi(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 			
 		echo json_encode($model->ajaxDelBilgi($post));
 	}
 	
 	function ajaxGuncelleBilgi(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 		
 		echo json_encode($model->ajaxGuncelleBilgi($post));
 	}
 	
 	function ajaxAddBilgi(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 			
 		echo json_encode($model->ajaxAddBilgi($post));
 	}
 	
 	function ajaxEkBirimSil(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 		
 		echo json_encode($model->ajaxEkBirimSil($post));
 	}
 	
 	function ajaxZorunluBaglimi(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 			
 		echo json_encode($model->ajaxZorunluBaglimi($post));
 	}
 	
 	function ajaxZorunluSil(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 	
 		echo json_encode($model->ajaxZorunluSil($post));
 	}
 	
 	function ajaxZorunluGuncelle(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 		
 		echo json_encode($model->ajaxZorunluGuncelle($post));
 	}
 	
 	function ajaxAciklamaKaydet(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 			
 		echo json_encode($model->ajaxAciklamaKaydet($post));
 	}
 	
 	function ajaxAlternatifKaydet(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 		
 		echo json_encode($model->ajaxAlternatifKaydet($post));
 	}
 	
 	function turKaydet(){
 		$model 		 = $this->getModel('yeterlilik_taslak');
 		$post 		 = JRequest::get( 'post' );
 			
 		$model->turKaydet($post);
 		
 		$layout = $_GET['layout'];
 		$yetId = $_GET['yeterlilik_id'];
 		$this->setRedirect('index.php?option=com_yeterlilik_taslak&layout='.$layout.'&yeterlilik_id='.$yetId);
 	}
 	
    function display() {

        parent::display();
    }

}
?>