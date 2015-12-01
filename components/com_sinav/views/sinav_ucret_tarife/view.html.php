<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class SinavViewSinav_Ucret_Tarife extends JView
{
	function display($tpl = null)
	{

		$model = &$this->getModel();
		$user = & JFactory::getUser();
		$user_id = $user->getOracleUserId();
		
		$db = & JFactory::getOracleDBO();
		
		$getData = JRequest::get( 'get' );
		
		
		/*$kurulus = $model->KuruluslariGetir();
		$yeterlilik = $model->YeterlilikGetir();
		
		$this->assignRef('kurulus'  , $kurulus);
		$this->assignRef('yeterlilik'  , $yeterlilik);*/
		$kuradi = $model->kurulusBilgi($db, $user_id);
		$ucretTar = $model->kurulusIDdenUcretTarifesiGetir($db, $user_id);
		$ucretler = $model->getUcretTarifesiUcretleri($db, $ucretTar["UCRET_TARIFESI_ID"]);
		
		$this->assignRef('kuradi'  , $kuradi[0]["KURULUS_ADI"]);
		$this->assignRef('ucretTar'  , $ucretTar);
		$this->assignRef('ucretler'  , $ucretler);
		
		parent::display($tpl);
	}	
}
?>
