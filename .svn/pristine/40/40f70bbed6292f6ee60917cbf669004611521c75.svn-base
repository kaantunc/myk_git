<?php
/**
 * Joomla! 1.5 component egbcaptcha
 *
 * @version $Id: controller.php 2010-05-15 15:59:50 svn $
 * @author egbsystems
 * @package Joomla
 * @subpackage egbcaptcha
 * @license GNU/GPL
 *
 * Custom captcha For All Forms Developed by EGBSYSTEMS 
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * egbcaptcha Component Controller
 */
class EgbcaptchaController extends JController {
	function display() {
        // Make sure we have a default view
        if( !JRequest::getVar( 'view' )) {
		    JRequest::setVar('view', 'egbcaptcha' );
        }
		parent::display();
	}
}
?>