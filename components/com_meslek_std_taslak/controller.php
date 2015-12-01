<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

require_once('libraries/form/captcha.php');
require_once('libraries/form/functions.php');

$document = &JFactory::getDocument();

//patchSatirEkle ve rowAdded icin
$document->addScript( SITE_URL.'/components/com_sinav/js/sinav.js' );

$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/addrow.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/pagination.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/dosya_gonder.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/panel.js' );
$document->addScript( SITE_URL.'/administrator/components/com_chronocontact/js/myjsvalidator.js' );
$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/meslek_std_taslak.js' );
$document->addScript( SITE_URL.'/components/com_meslek_std_taslak/js/jquery.lightbox_me.js' );

$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );

$document->addStyleSheet( SITE_URL.'/components/com_meslek_std_taslak/css/meslek_std_taslak.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/css/tablo_panel.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/border-radius.css' );
$document->addStyleSheet( SITE_URL.'/components/com_chronocontact/themes/default/css/style1.css' );

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
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery.ui.datepicker-tr.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

$document->addScript (SITE_URL.'/templates/elegance/js/jquery.collapsible.js');
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');
/**
 * Meslek_Std_Taslak Component Controller
 */
class Meslek_Std_TaslakController extends JController {
    
    function ajaxTaslakTerimGetir(){
  		$model = $this->getModel('Ajax');
		$model->ajaxTaslakTerimGetir();
    }
	
    function ajaxYonetimKuruluGetir(){
  		$model = $this->getModel('Ajax');
		$model->ajaxYonetimKuruluGetir();
    }
	
    function ajaxKomiteGetir(){
  		$model = $this->getModel('Ajax');
		$model->ajaxKomiteGetir();
    }
	
    function ajaxGenelKurulGetir(){
  		$model = $this->getModel('Ajax');
		$model->ajaxGenelKurulGetir();
    }
    
    function ajaxRevizyonlariGetir(){
  		$model = $this->getModel();
		$model->ajaxRevizyonlariGetir();
    }
    
	
	function revizyonKaydet(){
		$model 		 	= $this->getModel('taslak_revizyon');
		$post 		 	= JRequest::get( 'post' );
		$standart_id 	= JRequest::getVar('standart_id');
		$redirectLink	= 'index.php?option=com_meslek_std_taslak&view=taslak_revizyon&standart_id='.$standart_id.'&revize_no='.$post[revizyonNo];

		$message	 	= $model->revizyonKaydet ($post, $standart_id);
		
		$this->setRedirect($redirectLink, $message);
	}
	
	function gorusCevapla(){
						
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('gorus_kaydet');
        $post = JRequest::get( 'post' );
        $standartId = JRequest::getVar( 'standartId' );
        $message = $model->gorusCevapla($db, $post);
        
//        echo '**<pre>';
//		print_r($standartId);        
//        echo '</pre>**';
        //die();
		$this->setRedirect('index.php?option=com_meslek_std_taslak&view=gorus_listele&standartId='. $standartId , $message);
		
	}
	
	function gorusKaydet(){
				
		captcha::check("index.php?option=com_meslek_std_taslak&view=gorus_bildir&standartId=".JRequest::getVar("standartId"));
		
		$db = & JFactory::getOracleDBO();
		$model = $this->getModel('gorus_kaydet');
        $post = JRequest::get( 'post' );
        $message = $model->gorusKaydet($db, $post);
        
		$this->setRedirect('index.php' , $message);
		
	}
	
	function taslakKaydet(){
		$session	 = &JFactory::getSession();
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$standart_id = JRequest::getVar("standart_id");
		$layout		 = JRequest::getVar("layout");
		$redirectLink= 'index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&layout='.$layout.'&standart_id='.$standart_id;

		$evrak_id	 = $this->getModel('meslek_std_taslak')->getOracleEvrakId ($standart_id);
		$message	 = $model->taslakKaydet ($post, $layout, $standart_id, $evrak_id);
		
		$this->setRedirect($redirectLink, $message);
	}
 	
 	function sektorSorumlusunaGonder (){
 		$session	 = &JFactory::getSession();
    	$basvuru_tip = YT1_BASVURU_TIP;
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$standart_id = JRequest::getVar('standart_id');

		$model->sektorSorumlusunaGonder ($standart_id);
		
		$message 	 = "Meslek Standartı Formatı Sektör Sorumlusu Onayına Gönderildi"; 
		$this->setRedirect('index.php?option=com_meslek_std_taslak&layout=meslek_std_taslak_yeni&standart_id='.$standart_id, $message);
 	}
 	
 	function onBasvuruBitir (){
 		$session	 = &JFactory::getSession();
    	$basvuru_tip = YT1_BASVURU_TIP;
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$standart_id = JRequest::getVar('standart_id');
		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getCurrentEvrakId ($post, $basvuru_tip, $standart_id);
		
		$model->onBasvuruBitir ($evrak_id, $standart_id);
		
		$session->set("evrak_id", $evrak_id);
		$message 	 = "Meslek Standardı Taslağı Sektör Sorumlusuna Gönderildi"; 
		$this->setRedirect('index.php?option=com_meslek_std_taslak&layout=pdf_link&standart_id='.$standart_id, $message);
 	}
 	
 	function yorumKaydet (){
 		$session	 = &JFactory::getSession();
    	$basvuru_tip = YT1_BASVURU_TIP;
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$layout 	 = JRequest::getVar('layout');
		$standart_id = JRequest::getVar('standart_id');
		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getCurrentEvrakId ($post, $basvuru_tip, $standart_id);
		
		$model->yorumKaydet_SS ($post, $evrak_id, $layout);
		
		$message 	 = "Yorum Kaydedildi"; 
		$this->setRedirect('index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&layout='.$layout.'&standart_id='.$standart_id, $message);
 	}
 	function yorumKaydet_Kurulus (){
 		$session	 = &JFactory::getSession();
 		$basvuru_tip = YT1_BASVURU_TIP;
 		$model 		 = $this->getModel('taslak_kaydet');
 		$post 		 = JRequest::get( 'post' );
 		$layout 	 = JRequest::getVar('layout');
 		$standart_id = JRequest::getVar('standart_id');
 		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getCurrentEvrakId ($post, $basvuru_tip, $standart_id);
 	
 		$model->yorumKaydet_Kurulus ($post, $evrak_id, $layout);
 	
 		$message 	 = "Yorum Kaydedildi";
 		$this->setRedirect('index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&layout='.$layout.'&standart_id='.$standart_id, $message);
 	}
 	
 	function yorumlariGonder (){
 		$session	 = &JFactory::getSession();
    	$basvuru_tip = YT1_BASVURU_TIP;
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$standart_id = JRequest::getVar('standart_id');
		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getCurrentEvrakId ($post, $basvuru_tip, $standart_id);
		
		$model->yorumlariGonder ($evrak_id);
		
		$message 	 = "Yorumlar Gönderildi"; 
		$this->setRedirect('index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&layout=terim&standart_id='.$standart_id, $message);
 	}
 	
	function onBasvuruOnayla (){
 		$session	 = &JFactory::getSession();
    	$basvuru_tip = YT1_BASVURU_TIP;
		$model 		 = $this->getModel('taslak_kaydet');
		$post 		 = JRequest::get( 'post' );
		$standart_id = JRequest::getVar('standart_id');
		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getOracleEvrakId ($standart_id);
		
		$model->onBasvuruOnayla ($evrak_id, $standart_id);
		
		$message 	 = "Meslek Standardı Formatı Onaylandı. <br>Kuruluş tarafından başvurunun son onayının verilip, ıslak imzalı olarak MYK'ya gönderilmesini temin ediniz."; 
		$this->setRedirect('index.php?option=com_meslek_std_taslak&layout=hazirlayan&standart_id='.$standart_id, $message);
 	}
 	function ulusalMeslekStandardiOlarakAta()
 	{
 		$model 		 = $this->getModel('taslak_kaydet');
 		$post 		 = JRequest::get( 'post' );
 		$standart_id = JRequest::getVar('standart_id');
 		$model->ulusalMeslekStandardiOlarakAta ($standart_id);
 		$message 	 = "Meslek Standardı Ulusal Standart Olarak Kaydedildi.";
 		$this->setRedirect('index.php?', $message);
 	}
 	
 	function indir (){
 		$standart_id = JRequest::getVar('standart_id');
 		$id = JRequest::getVar('id');
 		
 		$revize_no = JRequest::getVar('revize_no');
 		$model = $this->getModel('taslak_revizyon');
 		$model->pdfGoster ($standart_id, $id, $revize_no);
 	}

	function sil (){
 		$standart_id = JRequest::getVar('standart_id');
 		$id = JRequest::getVar('id');
 		$revize_no = JRequest::getVar('revize_no');
 		$redirectLink = 'index.php?option=com_meslek_std_taslak&view=taslak_revizyon&standart_id='.$standart_id.'&revize_no='.$revize_no;
 		
 		$model = $this->getModel('taslak_revizyon');
 		$message = $model->pdfSil ($standart_id, $id, $revize_no);
 		
 		$this->setRedirect($redirectLink, $message);
 	}

	function basvuruOnayla (){ 
		$model 		 = $this->getModel('taslak_kaydet');
		$standart_id = JRequest::getVar('standart_id');
		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getOracleEvrakId ($standart_id);
		
		$model->basvuruOnayla ($evrak_id, $standart_id);		
		$message 	 = "Meslek Standardı Taslak Başvurusu Onaylandı"; 
		$this->setRedirect('index.php?', $message);
	}

// 	function basvuruBitir (){
// 		$session	 = &JFactory::getSession();
//    	$basvuru_tip = YT1_BASVURU_TIP;
//		$model 		 = $this->getModel('taslak_kaydet');
//		$post 		 = JRequest::get( 'post' );
//		$standart_id = JRequest::getVar('standart_id');
//		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getOracleEvrakId ($standart_id);
//		
//		$model->basvuruBitir ($evrak_id);
//
//		$this->setRedirect('index.php?option=com_meslek_std_taslak&layout=pdf_link&standart_id='.$standart_id);
// 	}

 	function getTerims(){
 		$model 		 	= $this->getModel('meslek_std_taslak');
 		$post 		 	= JRequest::get( 'post' );
 		
 		echo json_encode($model->getTerims ($post));
 	}
 	
 	function taslakKaydetYeni(){
 		$post 		 = JRequest::get( 'post' );
 		$model = &$this->getModel('taslak_kaydet');
 		$standart_id = JRequest::getVar('standart_id');
 		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getOracleEvrakId ($standart_id);
 		$return = $model->taslakKaydetYeni($post,$evrak_id);
 		echo json_encode($return);
 	}
 	
 	function basvuruKurulusaGonder (){
 		$model 		 = $this->getModel('taslak_kaydet');
 		$post 		 = JRequest::get( 'post' );
 		$standart_id = JRequest::getVar('standart_id');
 		$evrak_id 	 = $this->getModel('meslek_std_taslak')->getOracleEvrakId ($standart_id);
 	
 		$model->basvuruKurulusaGonder ($evrak_id, $standart_id);
 	
 		$message 	 = "Meslek Standardı Taslağı Kuruluşa Geri Gönderildi";
 		$this->setRedirect('index.php?option=com_meslek_std_taslak&layout=meslek_std_taslak_yeni&standart_id='.$standart_id, $message);
 	}
 	
 	function getVersionDatas(){
 		$post 		 = JRequest::get( 'post' );
 		$model = &$this->getModel('taslak_listele');
 		$datas = $model->getVersionDatas($post);
 		echo json_encode($datas);
 	}
 	
    function display() {

        parent::display();
    }

}
?>