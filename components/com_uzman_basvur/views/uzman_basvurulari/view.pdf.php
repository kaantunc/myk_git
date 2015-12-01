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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class Uzman_BasvurViewUzman_Basvur extends JView
{
	function display($tpl = null)
	{
		$user	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$model 	 = &$this->getModel();
		
		$title 		= $model->title;
		$kurulus 	= $model->getUzmanValues($user_id);	
		$tckimlik	= $kurulus[TC_KIMLIK];
		$evrak_id	= $tckimlik;
		$pageTree	= FormFactory::getPageTree ($user, $layout, substr($evrak_id,0,9), $pages, $pageNames); 
		$egitim		= $model->getUzmanEgitimValues($tckimlik);	
		$dil		= $model->getUzmanDilValues($tckimlik);	
		$sertifika	= $model->getUzmanSertifikaValues($tckimlik);
		$deneyim	= $model->getUzmanDeneyimValues($tckimlik);
		$mykdeneyim	= $model->getUzmanMykDeneyimValues($tckimlik);
		$deneyim_tipleri	= $model->getDeneyim_tipleri ();
		
//		$iller	 	= FormFactory::getKurulusIlValues ($user_id, $pdf);

		//Parametrik Data
		$pm_il		 	  = FormParametrik::getIl ();
		$pm_kurulus_statu = FormParametrik::getKurulusStatu ();
		$pm_faaliyet_sure = FormParametrik::getFaaliyetSuresi ();
		$pm_sektor		  = FormParametrik::getSektor ();
		$pm_seviye		  = FormParametrik::getSeviye ();
		$pm_yeterlilik_ad = FormParametrik::getYeterlilikAd ();

		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $evrak_id);
		$this->assignRef('pageTree'	, $pageTree);	
		$this->assignRef('basvuru'	, $basvuru);
		
		$this->assignRef('kurulus'	, $kurulus);
		$this->assignRef('pm_il'	, $pm_il);
		$this->assignRef('pm_sektor'	, $pm_sektor);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('dil'	    , $dil);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('deneyim'  , $deneyim);
		$this->assignRef('mykdeneyim'  , $mykdeneyim);
		$this->assignRef('deneyim_tipleri', $deneyim_tipleri);
		
				
		parent::display($tpl);
	}

}
?>