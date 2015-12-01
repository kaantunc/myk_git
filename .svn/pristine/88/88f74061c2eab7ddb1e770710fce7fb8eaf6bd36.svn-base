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
class Akreditasyon_BasvurViewAkreditasyon_Basvur extends JView
{
	function display($tpl = null)
	{
		$user	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$model 	 = &$this->getModel();
		
		$title 		= $model->title;
		$evrak_id	= FormFactory::getCurrentEvrakId ($_POST,T4_BASVURU_TIP, $user);
		$basvuru	= FormFactory::getBasvuruValues ($evrak_id);
		$kurulus 	= FormFactory::getMKurulusValues($evrak_id);	
		$iller	 	= FormFactory::getMKurulusIlValues ($evrak_id, $pdf);
		$irtibat	= FormFactory::getIrtibatValues ($evrak_id);
		$sektor		= FormFactory::getSektorValues ($evrak_id);
		$faaliyet	= FormFactory::getFaaliyetValues ($evrak_id);					
		$birlikteKurulus = FormFactory::getBirlikteKurulusValues ($evrak_id);	
		$yetkiTalep	= $model->getYetkiTalepValues  ($evrak_id);			
		$personel 	= FormFactory::getPersonelValues ($evrak_id);			
		$egitim 	= FormFactory::getEgitimValues ($evrak_id);			
		$sertifika 	= FormFactory::getSertifikaValues ($evrak_id);			
		$isDeneyim 	= FormFactory::getIsDeneyimValues ($evrak_id);			
		$dil 		= FormFactory::getDilValues ($evrak_id);
		$basvuru_ekleri = $model->getBasvuruEkleri($user_id);
		$basvuru_ekleri_tur = $model->getBasvuruEkleriBelgeTuru($user_id);

		$this->assignRef('title'	, $title);
		$this->assignRef('evrak_id'	, $evrak_id);	
		$this->assignRef('basvuru'	, $basvuru);
		
		//1. Kurulus Bilgi
		$this->assignRef('kurulus'	, $kurulus);
		$this->assignRef('iller'	, $iller);
		
		//2. Irtibat
		$this->assignRef('irtibat'	, $irtibat);
		
		//3. Faaliyet
		$this->assignRef('sektor'	, $sektor);
		$this->assignRef('faaliyet'	, $faaliyet);
		$this->assignRef('birlikteKurulus'	, $birlikteKurulus);
		$this->assignRef('yetkiTalep'	, $yetkiTalep);
		
		//4. Ek
		$this->assignRef('personel'	, $personel);
		$this->assignRef('egitim'	, $egitim);
		$this->assignRef('sertifika', $sertifika);
		$this->assignRef('isDeneyim', $isDeneyim);
		$this->assignRef('dil'		, $dil);
		
		//5. Basvuru Ekleri
		$this->assignRef('basvuru_ekleri', $basvuru_ekleri);
		$this->assignRef('turler', $basvuru_ekleri_tur);
		
		parent::display($tpl);
	}

}
?>