<?php
/**
 * Joomla! 1.5 component egbcaptcha
 *
 * @version $Id: egbcaptcha.php 2010-05-15 15:59:50 svn $
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

jimport('joomla.application.component.model');

/**
 * egbcaptcha Component egbcaptcha Model
 *
 * @author      notwebdesign
 * @package		Joomla
 * @subpackage	egbcaptcha
 * @since 1.5
 */
class EgbcaptchaModelEgbcaptcha extends JModel {
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
    }
}
?>