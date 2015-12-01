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

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

// Initialize the controller
$controller = new EgbcaptchaController();
$controller->execute( null );

// Redirect if set by the controller
$controller->redirect();
?>