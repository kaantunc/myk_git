<?php
/**
 * @version		$Id: user.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	User
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * User Component User Model
 *
 * @package		Joomla
 * @subpackage	User
 * @since 1.5
 */
class UserModelChangepass extends JModel
{
    function ajaxSaveRow (){
		$user		= JFactory::getUser();
		$id	= $user->get('id');
    	jimport('joomla.mail.helper');
		jimport('joomla.user.helper');
		global $mainframe;
        $db = &JFactory::getDBO();

        $varolan=JRequest::getVar('varolan');     
        $yeni=JRequest::getVar('yeni');    
        
        $sql="select password from jos_users where id=$id";
        $liste=mysql_fetch_array(mysql_query($sql));
        
        $parts=explode(":", $liste[password]);
        $crypt   = $parts[0];
        $salt   = @$parts[1];
        $testcrypt = JUserHelper::getCryptedPassword($varolan, $salt);
        if ( $crypt==$testcrypt){
        
		$salt		= JUserHelper::genRandomPassword(32);
		$crypt		= JUserHelper::getCryptedPassword($yeni, $salt);
		$password	= $crypt.':'.$salt;
     		$query	= 'UPDATE #__users'
    				. ' SET `password` = "'.$password.'"'
    				. ' WHERE id = '.(int) $id
    				. ' AND block = 0';
    
    		$db->setQuery($query);
            $db->query();
            echo "<p align=center>Şifreniz başarıyla değiştirildi.</p>";
        } else {
        	echo "<p align=center>Geçerli şifreniz yanlış.</p><p align=center><a href='index.php?option=com_user&view=changepass'>Yeniden deneyiniz</a></p>";
        }
	}
 }

?>
