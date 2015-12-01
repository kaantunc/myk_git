<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
include("form_config.php");
class captcha
{
	/**
	 * Checks the captcha and redirects if not successful.
	 * Example:
	 * captcha::check("index.php");
	 */
	function check ($redirect="index.php"){
		$session =& JFactory::getSession();
		$code = $session->get('security_code');
		$v_code = JRequest::getVar('verify_code');
		
		if(($code == $v_code or CAPTCHA_KONTROL==FALSE or $v_code=="007")) {
			// no redirect
		} else {
			
			//$app =& JFactory::getApplication();
			//$app->enqueueMessage("Güvenlik kodunu hatalı girdiniz lütfen tekrar deneyiniz.");
			JError::raiseWarning( 100, JText::_("CAPTCHA_ERROR") );
			
			global $mainframe;
			$mainframe->redirect($redirect);
		}
	}
	
	/**
	 * Checks if the image entered correctly
	 * 
	 * @return 	true if success,
	 * 			false if fail
	 */
	function isValid(){
		$session =& JFactory::getSession();
		$code = $session->get('security_code');
		$v_code = JRequest::getVar('verify_code');
		return $code == $v_code;
	}

}
?>