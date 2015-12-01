<?php
/**
* @version		$Id: view.pdf.php 11371 2008-12-30 01:31:50Z ian $
* @package		Joomla
* @subpackage	Content
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free or open
* source software licenses. See COPYRIGHT.php for copyright notices and
* details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
/**
 * HTML View class for the rate Component
 */
class Sertifika_SorgulaViewSertifika_Sorgula extends JView
{
	function display($tpl = null)
	{
		$session =&JFactory::getSession();
		$model 	  	= &$this->getModel();
		$data = $session->get('data');
		
		$serid = $_GET["ser_id"];
		
		$logo = $model->getLogo($serid);
		
		$this->assignRef('logo'  , $logo);
		$this->assignRef('data'  , $data[0]);
		parent::display($tpl);
	}
}

?>