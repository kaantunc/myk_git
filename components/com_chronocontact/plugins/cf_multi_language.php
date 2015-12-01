<?php
/**
* CHRONOFORMS version 3.0
* Copyright (c) 2008 Chrono_Man, ChronoEngine.com. All rights reserved.
* Author: Chrono_Man
* License : GPL
* Visit http://www.ChronoEngine.com for regular update and information.
**/
defined('_JEXEC') or die('Restricted access');
global $mainframe;
require_once( $mainframe->getPath( 'class', 'com_chronocontact' ) );

// the class name must be the same as the file name without the .php at the end
class cf_multi_language
{
	//the next 3 fields must be defined for every plugin
	var $result_TITLE = "Multi Language";
	var $result_TOOLTIP = "Define translations for any string at your form";
	var $plugin_name = "cf_multi_language"; // must be the same as the class name
	var $event = "ONLOAD"; // must be defined and in Uppercase, should be ONSUBMIT or ONLOAD
	var $plugin_keys ='';

	// the next function must exist and will have the backend config code
	function show_conf($row, $id, $form_id, $option)
	{
    	global $mainframe;

    	require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'plugin.php');
        $helper = new ChronoContactHelperPlugin();
        // identify and initialise the parameters used in this plugin
        
        $params_array = array(
            'debugging' => '0',
        	'languages' => '',
        	'default_language' => '');
        $params = $helper->loadParams($row, $params_array);

        $messages[] = '$params: '.print_r($params, true);
        if ( $params->get('debugging') ) {
    	    $helper->showPluginDebugMessages($messages);
    	}
    	$tags = explode(',', $params->get('languages'));
?>
<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">
<?php
    	echo $pane->startPane("multilanguage");
    	/* echo $pane->startPanel( 'Multi Language settings', "settings" );
?>
<table border='0' cellpadding='3' cellspacing='0' class='cf_table' >
<?php
        $input = $helper->createHeaderTD('Configure the plugin', '',
            true, array('colspan' => '4', 'class' => 'cf_header'));
        echo $helper->wrapTR($input);

        $tooltip = "Your list of supported languages, in 2-2 letters form e.g. en-GB,fr-FR,es-ES";
        $input = $helper->createInputTD("Languages supported",
            "params[languages]", $params->get('languages'), '', $attribs['input'], $tooltip);
        echo $helper->wrapTR($input, array('class' => 'cf_config'));

        $tooltip = "Default language which will run when the current site language is not supported e.g. en-GB";
        $input = $helper->createInputTD("Default language",
            "params[default_language]", $params->get('default_language'), '', $attribs['input'], $tooltip);
        echo $helper->wrapTR($input, array('class' => 'cf_config'));
?>
	</table>
<?php
		echo $pane->endPanel(); */
		echo $pane->startPanel( "Languages 1-5", 'Languages2' );
?>
<table border="0" cellpadding="3" cellspacing="0" class='cf_table' >
<?php
        $tooltip = "Add your language translations here!";
        for ( $i = 1; $i <= 2; $i++ ) {
            $extra = 'extra'.$i;
            $tag_name = '';
            if ( !empty($tags[$i-1]) ){
                $tag_name =  $tags[$i-1];
            }
            $input = $helper->createTextareaTD('Language Strings: '.$tag_name, $extra,
                $row->$extra,
                $attribs['textarea'], $tooltip );
            echo $helper->wrapTR($input, array('class' => 'cf_config'));
        }
?>
</table>
<?php
		echo $pane->endPanel();
		/* echo $pane->startPanel( "Languages 6-10", 'Languages3' );
?>
<table border="0" cellpadding="3" cellspacing="0" class='cf_table' >
<?php
        for ( $i = 6; $i <= 10; $i++ ) {
            $extra = 'extra'.$i;
            $input = $helper->createTextareaTD('Language Strings', 'params['.$extra.']',
                $params->get($extra),
                $attribs['textarea'], $tooltip );
            echo $helper->wrapTR($input, array('class' => 'cf_config'));
        }
?>
</table>
<?php
		echo $pane->endPanel(); */
       /* echo $pane->startPanel( "Help", 'Legend3' );
?>
<table border="0" cellpadding="3" cellspacing="0" class='cf_table' >
<?php
        $input = $helper->createHeaderTD('How to use the Multi Language plugin', '',
            true, array('colspan' => '4', 'class' => 'cf_header'));
        echo $helper->wrapTR($input);
?>
    <tr>
        <td colspan='4' style='border:1px solid silver; padding:6px;'>
        <div>The plugin allows you to create multi-language forms in ChronoForms.</div>
        <div>The plugin works by checking the current language from the Joomla settings
        and then replacing 'key phrases' in the form html with the equivalent you have
        defined for that language.</div>
        <ul><li>In the Settings tab enter a list of the languages that you want to support
        using the 'country code'-'region code' format: en-GB, fr-FR </li>
        <li>Enter one of these language codes as the default value to be used if there isn't
        a definition for a language in use.</li>
        <li>On the second and third tabs are a series of text areas in which you can enter your
        language translations. Note that after the plugin is saved language tags will show up
        by the corresponding box names.</li>
        <li>In each box enter each of the 'key phrases' and the language equivalents
        e.g. in en-GB: 'Required field=This field is required';
        in fr-FR: 'Requred field=Ce champ est obligatoire'; and in nl-NL: Requred field=Dit veld is verplicht'.</li>
        <li>Notice that each entry takes the form Key phrase=Translated expression.
        Don't leave spaces around the '=' and don't add quotes around either part of the entry.</li>
        <li>Start each new 'key phrase' on a new line.</li>
        <li>In your form html make sure that the 'key phrase' is entered in exactly the same way as
        in the plugin e.g. &lt;input . . . title='Required field' . . . /&gt;</li>
        </ul>
        <div>Note that you can use Key phrases for any text in your for html.</div>
        <ul><li>For label text.</li>
        <li>For title entries to show validation error messages.</li>
        <li>For image names to show language specific images e.g 'Submit_image=submit_img_fr.jpg'</li>
        <li>For short body text - remember that the entry has to go onto a single line in the text area.</li></ul>
        <div>This version of the multi-language plugin will also translate ChronoForms errors
        so it can be used, for example, with the AntiSpam error message.</div>
        </td>
    </tr>
</table>
<?php
        echo $pane->endPanel(); */
		echo $pane->endPane();

        $hidden_array = array (
            'id' => $id,
            'form_id' => $form_id,
            'name' => $this->plugin_name,
            'event' => $this->event,
            'option' => $option,
            'task' => 'save_conf');
        //$hidden_array['params[onsubmit]'] = 'before_email';
        echo $helper->createHiddenArray( $hidden_array );
?>
</form>
<?php
	}
	// this function must exist and may not be changed unless you need to customize something
	function save_conf( $option ) {
		global $mainframe;
		$database =& JFactory::getDBO();
		$post = JRequest::get( 'post' , JREQUEST_ALLOWRAW );

		$row =& JTable::getInstance('chronocontactplugins', 'Table');
		if (!$row->bind( $post )) {
			JError::raiseWarning(100, $row->getError());
			$mainframe->redirect( "index2.php?option=$option" );
		}

		$params 	= JRequest::getVar( 'params', '', 'post', 'array', array(0) );
		if (is_array( $params )) {
			$txt = array();
			foreach ( $params as $k => $v) {
				$txt[] = "$k=$v";
			}
			$row->params = implode( "\n", $txt );
		}
		if (!$row->store()) {
			JError::raiseWarning(100, $row->getError());
			$mainframe->redirect( "index2.php?option=$option" );
		}
		$mainframe->redirect( "index2.php?option=".$option, "Config Saved" );
	}

	function onload( $option, $row, $params, $html_string )
	{
		global $mainframe;
		
		//echo "---- ON LOAD ----<br>";
				
		//$params   = JComponentHelper::getParams('com_languages');

		$frontend_lang = JComponentHelper::getParams('com_languages')->get('site', 'tr-TR');
		$LangTag = $frontend_lang;
		
		$formname = JRequest::getVar('chronoformname');
		if ( !$formname ) {
			$formname = $params->get('formname');
		}
		$MyForm =& CFChronoForm::getInstance($formname);

		$LangCount = 1;
		$LangArray = array();
		$Lang_Temp_Array = array();
		$cfLangDone = false;
		$default_lang = trim($params->get('default_language'));
		$supportedLanguages = explode(',', trim($params->get('languages')));

		// Look for the language ID, set to the defautl if not found (or 1 if no default)
		if(array_search($LangTag, $supportedLanguages) === FALSE){
			$lang_id = array_search($default_lang, $supportedLanguages);
		}
		else{
			$lang_id = array_search($LangTag, $supportedLanguages);
		}
		// increment lang_id to start with 1
		$lang_id++;
		$LangData = $row->{"extra".$lang_id};
		$Lang_Temp_Array = explode("\n", $LangData);
		foreach( $Lang_Temp_Array as $Lang_Temp_Element ) {
			$This_Lang_Element = explode('=', $Lang_Temp_Element, 2);
			if(!($This_Lang_Element[0] && $This_Lang_Element[1]))
				break;
			$html_string = str_replace($This_Lang_Element[0], $This_Lang_Element[1], $html_string);
			if ( $MyForm->formerrors ) {
			    $MyForm->formerrors = str_replace($This_Lang_Element[0], $This_Lang_Element[1], $MyForm->formerrors);
			}
		}
		
//		if($LangTag == "tr-TR"){
//			$val_eng = explode(",", "This field is required,Please enter a valid number in this field,Please use numbers only in this field,Please use letters only (a-z) in this field,Please use letters only (a-z) or numbers (0-9) in this field,Please enter a valid date in this format yyyy/mm/dd,Please enter a valid email address,Please enter a valid URL,Please use this date format: dd/mm/yyyy,Please enter a valid $ amount,Please make sure that the two fields match,Please select one of the options,Please make a selection");
//			$val_tr = explode(",", "Bu alan gerekli,Geçerli bir sayı giriniz,Sadece sayıları kullanınız,Sadece harf(a-z) giriniz,Sadece harf veya sayı giriniz,Geçerli bir tarih giriniz(yyyy/aa/gg),Geçerli bir e-posta adresi giriniz,Geçerli bir bağlantı giriniz,Lütfen tarih için şu biçimi kullanınız: gg/aa/yyyy,Geçerli bir miktar giriniz,İki alanın aynı olduğundan emin olunuz,Bir seçeneği işaretleyiniz,Bir seçim yapınız");
//			
//			$index=0;
//			for(;isset($val_eng[$index]) && isset($val_tr[$index]);$index++){
//				$html_string = str_replace($val_eng[$index], $val_tr[$index], $html_string);
//			}
//		}
		return $html_string ;
	}
}
?>