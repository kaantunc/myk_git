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
class Yeterlilik_BasvurViewYeterlilik_Basvur extends JView
{
	function display($tpl = null)
	{
		$user	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$model 	 = &$this->getModel();
		
		$evrak_id	= JRequest::getVar("id");
		
		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
		$kurulus 	= FormFactory::getMKurulusValues($evrak_id);
		$iller	 	= FormFactory::getMKurulusIlValues ($evrak_id, 1);
		$irtibat	= FormFactory::getIrtibatValues ($evrak_id);
		$sektor		= FormFactory::getSektorValues ($evrak_id);
		$faaliyet	= FormFactory::getFaaliyetValues ($evrak_id);	
		$akreditasyon = $model->getAkreditasyonValues ($evrak_id);				
		$birlikteKurulus = FormFactory::getBirlikteKurulusValues ($evrak_id);			
		$yeterlilik	= $model->getYeterlilikPdfValues ($evrak_id);			
		$personel 	= FormFactory::getPersonelValues ($evrak_id);			
		$egitim 	= FormFactory::getEgitimValues ($evrak_id);			
		$sertifika 	= FormFactory::getSertifikaValues ($evrak_id);			
		$isDeneyim 	= FormFactory::getIsDeneyimValues ($evrak_id);			
		$dil 		= FormFactory::getDilValues ($evrak_id);			
		
		$this->assignRef('basvuru'	, $basvuru);
		$this->assignRef('akreditasyon'	, $akreditasyon);
		//1. Kurulus Bilgi
		$this->assignRef('kurulus'	, $kurulus);
		$this->assignRef('iller'	, $iller);
		//2. Irtibat
		$this->assignRef('irtibat'	, $irtibat);
		//3. Faaliyet
		$this->assignRef('sektor'	, $sektor);
		$this->assignRef('faaliyet'	, $faaliyet);
		$this->assignRef('birlikteKurulus'	, $birlikteKurulus);
		//4. Kapsam
		$this->assignRef('yeterlilik', $yeterlilik);
		//5. Ek
		$this->assignRef('personel'	, $personel);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('isDeneyim', $isDeneyim);
		$this->assignRef('dil'		, $dil);
		
		parent::display($tpl);
	}

}
?>