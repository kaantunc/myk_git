<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class BelgelendirmeModelDekont extends JModel {
	
	public function getKursWithHak(){
		$db = JFactory::getOracleDBO();
		
		$sql="SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI 
				FROM M_BELGELENDIRME_HAK_KAZANANLAR
				JOIN M_KURULUS ON M_BELGELENDIRME_HAK_KAZANANLAR.KURULUS_ID = M_KURULUS.USER_ID
				JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0
			UNION
				SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI 
				FROM M_BELGELENDIRME_HAK_KAZANANLAR
				JOIN M_KURULUS ON M_BELGELENDIRME_HAK_KAZANANLAR.KURULUS_ID = M_KURULUS.USER_ID
				WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1)
				ORDER BY KURULUS_ADI ASC";
		
		return $db->prep_exec($sql, array());
	}
	
	public function sinavDekontGetir($sinavId){
		$db = JFactory::getOracleDBO();
		
		$sql="SELECT DISTINCT MBB.DEKONT, MBB.DEKONT_TARIH, MBB.DEKONTNO, MBB.TUTAR, TO_CHAR(MBM.BASIM_TARIHI,'dd/mm/yyyy') as BASIM_TARIHI FROM M_BELGELENDIRME_BASVURU MBB
				INNER JOIN M_BELGELENDIRME_HAK_KAZANANLAR MBHK ON (MBB.BASVURU_ID = MBHK.BASVURU_ID)
				INNER JOIN M_BELGELENDIRME_MATBAA MBM ON (MBHK.MATBAA_ID = MBM.MATBAA_ID)
				WHERE MBHK.SINAV_ID = ?";
		$data = $db->prep_exec($sql, array($sinavId));
		
		if($data){
			return array('durum'=>1,'dekont'=>$data);
		}else{
			$sql="SELECT DEKONT, DEKONTNO, TUTAR FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?";
			$data = $db->prep_exec($sql, array($sinavId));
			if(!empty($data[0]['DEKONT']) || $data[0]['DEKONT'] != null){
				return array('durum'=>2,'dekont'=>$data);
			}else{
				return array('durum'=>0);
			}
		}
	}
}