<?php
/**
 * Joomla! 1.5 component egbcaptcha
 *
 * @version $Id: view.html.php 2010-05-15 15:59:50 svn $
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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the egbcaptcha component
 */
class EgbcaptchaViewEgbcaptcha extends JView {var $_data;
	var $font = 'components/com_egbcaptcha/views/egbcaptcha/CAYTANBI.ttf';
	private $code;
	
	function display($tpl = null)
	{
		// session
		$session =& JFactory::getSession();
		
		// Generate code
		$code = $this->generateCode(isset($_GET['characters'])?$_GET['characters']:5);
		// Generate image
		$this->getCaptchaSecurityImages($code, $_GET['width'],$_GET['height']);
		
		// Set session
		$session->set('security_code', $code);
		
		parent::display($tpl);
		exit;
	}
	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		//$possible = '23456789bcdfhQkmnrstvwxzJi';
		$possible = '346789bcdfhokmnrtvi';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}

	function getCaptchaSecurityImages($code, $width='120',$height='40') {
		//$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 20, 40, 100);
		$noise_color = imagecolorallocate($image, 100, 120, 180);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	function getCode(){
		return $this->code;
	}

}
?>