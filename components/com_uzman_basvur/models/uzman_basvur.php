<?php
defined('_JEXEC') or die('Restricted access');

class Uzman_BasvurModelUzman_Basvur extends JModel {
	
	
	function getPageTree ($user, $activeLayout, $evrak_id, $pages, $pageNames,$basvuru_durum,$tc_kimlik){
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;" ';
		$sayfa = count($pages);
		$saved = FormFactory::getSavedPages ($evrak_id);
//		$saved[count($saved)] = 1;
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu($user);
		$tree = '<div class="form_element" style="padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;" class="anaDiv">';
		
		if ($basvuru_durum=="0" and !$isSektorSorumlusu){
// 		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
// 		$onClick = ' onclick = "basvuruGonder()" ';
// 		$value = ' value="Tüm Basvuruyu Görüntüle / Bitir" ';
// 		$class = ' class="btn" ';
		
// 		$disabled = 'disabled="disabled"';
		
// 		if (count($saved)>= $sayfa){
// 			$disabled = '';
// 			$class = ' class="btn btn-success" ';
// 		}
			
// 		$name  = 'name="gonder" ';
		
// 		$tree .= $inp.$name.$value.$onClick.$disabled.$class." />";
		}
		$tree .= '<div style="clear:both;"></div></div>';
		$tree .= '<div class="anaDiv">';
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			for ($j = 0; $j < count($saved); $j++){
				if ($saved[$j] == ($i+1)){
					$style	 = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255); margin: 1px;" ';
					break;
				}
			}
			$input = '<div class="divYan"><input type="button" onclick="goToPage(\'uzman_basvur\',\''.$pages[$i].'\',\''.$tc_kimlik.'\')" class="btn btn-xs" id="page'.$i.'" value="'.$pageNames[$i].'" ';
			
			$disabled = '';
			if ($pages[$i]== "ek" && !in_array(3, $saved)){ // sayfa 3 kaydedilmis mi (faaliyet)
				$disabled = 'disabled="disabled"';
			}
		
			if ($activeLayout == $pages[$i])
				$tree .= $input.$activeStyle.$disabled.' />';
			else
				$tree .= $input.$style.$disabled.' />';

			$tree .= '</div>';
		}
		$tree .= '</div>';
		$tree .= '<br /></div>';
		
		return $tree;
	}
	
	function getUzmanValues($user_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU 
				WHERE user_id = ?";
		
		$params = array ($user_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	
	function getUzmanValuesByTcKimlik($user_id){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU 
				WHERE tc_kimlik = ?";
		
		$params = array ($user_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getUzmanEgitimValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 		if ($durum!="2"){
// 			$sqlek=" and durum=1";
// 		} else {
// 			$sqlek=" order by durum";
// 		}
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU_EGITIM 
				WHERE TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getMykUzmanEgitimValues($tckimlik){
		$db = & JFactory::getOracleDBO();

		$sql = "SELECT *
				FROM M_UZMAN_HAVUZU_MYK_EGITIM
				WHERE TC_KIMLIK = ? ORDER BY EGITIM_ID DESC";
	
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}

	function getUzmanDilValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 		if ($durum!="2"){
// 			$sqlek=" and durum=1";
// 		} else {
// 			$sqlek=" order by durum";
// 		}
				
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU_YABANCI_DIL 
				WHERE TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getUzmanSertifikaValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 			if ($durum!="2"){
// 			$sqlek=" and durum=1";
// 		} else {
// 			$sqlek=" order by durum";
// 		}
				
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU_SERTIFIKA 
				WHERE TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getUzmanDeneyimValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 			if ($durum!="2"){
// 			$sqlek=" and durum=1";
// 		} else {
// 			$sqlek=" order by durum";
// 		}
				
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU_DENEYIM 
				WHERE TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	function getYorumValues($tckimlik){
		$db = & JFactory::getOracleDBO();
		// 			if ($durum!="2"){
		// 			$sqlek=" and durum=1";
		// 		} else {
		// 			$sqlek=" order by durum";
		// 		}
	
		$sql = "SELECT *
				FROM M_UZMAN_HAVUZU_YORUM
				WHERE TC_KIMLIK = ?";
	
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getUzmanMykDeneyimValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 		if ($durum!="2"){
// 			$sqlek=" and durum=1";
// 		} else {
// 			$sqlek=" order by durum";
// 		}
				
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU_MYK_DENEYIM 
				WHERE TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getUzmanBasvuruSektorValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 		if ($durum!="2"){
// 			$sqlek=" and a.durum=1";
// 		} else {
// 			$sqlek=" order by a.durum";
// 		}
		
		$sql = "SELECT a.sektor_id,b.sektor_adi,a.durum 
				FROM M_UZMAN_HAVUZU_SEKTOR a, PM_SEKTORLER b
				WHERE a.sektor_id=b.sektor_id and TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getUzmanBasvuruYeterlilikValues($tckimlik){
		$db = & JFactory::getOracleDBO();
// 			if ($durum!="2"){
// 			$sqlek=" and b.durum=1";
// 		} else {
// 			$sqlek=" order by b.durum";
// 		}
				
		$sql = "select 
					a.yeterlilik_id, 
					a.yeterlilik_adi,
					b.durum,
					c.sektor_adi,
					d.seviye_adi 
				from 
					m_yeterlilik a, 
					m_uzman_havuzu_yeterlilik b,
					pm_sektorler c,
					pm_seviye d 
				where 
					a.yeterlilik_id=b.yeterlilik_id and 
					a.sektor_id=c.sektor_id and
					a.seviye_id=d.seviye_id and
					b.tc_kimlik= ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getDeneyim_tipleri(){
		$db = JFactory::getOracleDBO();
		$sql = "SELECT  *
		FROM PM_UZMAN_HAVUZU_DENEYIM_TIP
		ORDER BY DENEYIM_NO";
			
		return $db->prep_exec($sql, array());
	
	}
	
// 	function getMYKDeneyim(){
// 		$db = JFactory::getOracleDBO();
// 		$sql = "SELECT  id
// 		FROM M_UZMAN_HAVUZU_MYK_DENEYIM
// 		where TC_KIMLIK=".$_GET["tc_kimlik"]." and durum=2";
			
// 		$mykDeneyim= $db->prep_exec($sql, array());
	
// 	}
	
	function getBasvuru_alanlari($tckimlik){
		$db = & JFactory::getOracleDBO();
// 			if ($durum!="2"){
// 			$sqlek=" and durum=1";
// 		} else {
// 			$sqlek=" order by durum";
// 		}
				
		$sql = "SELECT * 
				FROM M_UZMAN_HAVUZU_ALANLAR 
				WHERE TC_KIMLIK = ?";
		
		$params = array ($tckimlik);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data;
		else
			return null;
			
	}

	function getDenetciBelgeGecerlilik($tc){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT BELGE_ID, UZMAN_ID, BELGE_ADI, BELGE_PATH, TO_CHAR(GECERLILIK_TARIHI,'DD/MM/YYYY') as TARIH, DURUM 
				FROM M_UZMAN_DENETCI_BELGE WHERE UZMAN_ID = ? 
				ORDER BY BELGE_ID ASC";
		return $db->prep_exec($sql, array($tc));
	}
	
	function getDenetciBelgeKanit($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UZMAN_DENETCI_KANIT_BELGESI WHERE UZMAN_ID = ? ORDER BY BELGE_ID ASC";
		return $db->prep_exec($sql, array($tc));
	}
	
	function getDenetciDeneyim($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UZMAN_DENETCI_DENEYIM WHERE UZMAN_ID = ? ORDER BY DENEYIM_ID ASC";
		return $db->prep_exec($sql, array($tc));
	}
	
	function getTUBelgeKanit($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UZMAN_TEKNIK_KANIT_BELGESI WHERE UZMAN_ID = ? ORDER BY BELGE_ID ASC";
		return $db->prep_exec($sql, array($tc));
	}
	
	function getTUDeneyim($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UZMAN_TEKNIK_DENEYIM WHERE UZMAN_ID = ? ORDER BY DENEYIM_ID ASC";
		return $db->prep_exec($sql, array($tc));
	}
	
	function getTUYeterlilik($tc){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_UZMAN_TEKNIK_YETERLILIK MUTY 
				INNER JOIN M_YETERLILIK ON(MUTY.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID) 
				WHERE MUTY.UZMAN_ID = ?";
		
		return $db->prep_exec($sql, array($tc));
	}
	
	function getUzmanTaahut($tc){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_UZMAN_TAAHUTNAME WHERE UZMAN_ID = ?";
		
		$data = $db->prep_exec($sql, array($tc));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function getDenetciMusait($tc){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_UZMAN_DENETCI_MUSAIT WHERE UZMAN_ID = ?";
		$data = $db->prep_exec($sql, array($tc));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function getTUMusait($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UZMAN_TEKNIK_MUSAIT WHERE UZMAN_ID = ?";
		$data = $db->prep_exec($sql, array($tc));
	
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function getBilgilendirmeOnayla($tc){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT BILGI_ID FROM M_UZMAN_BILGI_ONAY WHERE UZMAN_ID=?";
		
		return $db->prep_exec_array($sql, array($tc));
	}
}
?>
