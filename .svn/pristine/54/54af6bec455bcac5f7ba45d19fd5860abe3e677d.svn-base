<?php
defined('_JEXEC') or die('Restricted access');

class Uzman_BasvurModelUzman_Profile extends JModel {
	
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
			$input = '<div class="divYan"><input type="button" onclick="goToPage(\'uzman_profile\',\''.$pages[$i].'\',\''.$tc_kimlik.'\')" class="btn btn-xs" id="page'.$i.'" value="'.$pageNames[$i].'" ';
				
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
	
	function getBasvurular ($db,$basvurudurum){
		$db = JFactory::getOracleDBO();
		$sql = "SELECT  *
		FROM M_UZMAN_HAVUZU
		WHERE basvuru_durum=$basvurudurum
		ORDER BY ID ASC, AD ASC, SOYAD ASC";
			
		return $db->prep_exec($sql, array());
		
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
	
	function getBilgilendirmeOnayla($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT BILGI_ID FROM M_UZMAN_BILGI_ONAY WHERE UZMAN_ID=?";
	
		return $db->prep_exec_array($sql, array($tc));
	}
	
	function getDenetciBelgeGecerlilik($tc){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_UZMAN_DENETCI_BELGE WHERE UZMAN_ID = ? ORDER BY BELGE_ID ASC";
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
	
	function getDenetim($tc){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT MD.DENETIM_ID, PDT.DENETIM_TURU_ACIKLAMA, MKE.KURULUS_ADI, PDER.ROL_ID, PDER.ROL_ADI, 
				MUCS.GOREVLENDIRILDIGI_GUN_SAYISI, MUCS.BASLANGIC_TARIHI, MDR.DURUM, MDRO.ONAY 
				FROM M_UZMAN_HAVUZU MUZ
				INNER JOIN M_DENETIM_EKIP MDE ON(MUZ.USER_ID = MDE.PERSONEL_ID)
				INNER JOIN PM_DENETIM_EKIP_ROLU PDER ON(MDE.PERSONEL_ROLU = PDER.ROL_ID)
				INNER JOIN M_UZMAN_CALISMA_SURESI MUCS ON(MDE.CALISMA_SURESI_ID = MUCS.CALISMA_SURESI_ID)
				INNER JOIN M_DENETIM MD ON(MDE.DENETIM_ID = MD.DENETIM_ID)
				LEFT JOIN M_DENETIM_RAPOR MDR ON(MD.DENETIM_ID = MDR.DENETIM_ID)
				LEFT JOIN M_DENETIM_RAPOR_ONAY MDRO ON(MD.DENETIM_ID = MDRO.DENETIM_ID AND MUZ.USER_ID = MDRO.UZMAN_ID)
				INNER JOIN PM_DENETIM_TURU PDT ON(MD.DENETIM_TURU = PDT.DENETIM_TURU)
				INNER JOIN M_BASVURU MB ON(MD.DENETIM_EVRAK_ID = MB.EVRAK_ID)
				INNER JOIN M_KURULUS MK ON(MB.USER_ID = MK.USER_ID)
				INNER JOIN M_KURULUS_EDIT MKE ON(MK.USER_ID = MKE.USER_ID)
				WHERE MKE.AKTIF = 1 AND MKE.ONAY_BEKLEYEN = 0 AND MUZ.TC_KIMLIK = ".$tc."
			UNION
				 SELECT DISTINCT MD.DENETIM_ID, PDT.DENETIM_TURU_ACIKLAMA, MK.KURULUS_ADI, PDER.ROL_ID, PDER.ROL_ADI, 
				MUCS.GOREVLENDIRILDIGI_GUN_SAYISI, MUCS.BASLANGIC_TARIHI, MDR.DURUM, MDRO.ONAY 
				FROM M_UZMAN_HAVUZU MUZ
				INNER JOIN M_DENETIM_EKIP MDE ON(MUZ.USER_ID = MDE.PERSONEL_ID)
				INNER JOIN PM_DENETIM_EKIP_ROLU PDER ON(MDE.PERSONEL_ROLU = PDER.ROL_ID)
				INNER JOIN M_UZMAN_CALISMA_SURESI MUCS ON(MDE.CALISMA_SURESI_ID = MUCS.CALISMA_SURESI_ID)
				INNER JOIN M_DENETIM MD ON(MDE.DENETIM_ID = MD.DENETIM_ID)
				LEFT JOIN M_DENETIM_RAPOR MDR ON(MD.DENETIM_ID = MDR.DENETIM_ID)
				LEFT JOIN M_DENETIM_RAPOR_ONAY MDRO ON(MD.DENETIM_ID = MDRO.DENETIM_ID AND MUZ.USER_ID = MDRO.UZMAN_ID)
				INNER JOIN PM_DENETIM_TURU PDT ON(MD.DENETIM_TURU = PDT.DENETIM_TURU)
				INNER JOIN M_BASVURU MB ON(MD.DENETIM_EVRAK_ID = MB.EVRAK_ID)
				INNER JOIN M_KURULUS MK ON(MB.USER_ID = MK.USER_ID)
				WHERE MK.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND MUZ.TC_KIMLIK = ".$tc."
				ORDER BY DENETIM_ID DESC";
		
		$data = $db->prep_exec($sql, array());
		
		if($data){
			return $data;
		}else{
			return false;
		}
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
	
	function ajaxDenetimRaporOnayla($post){
		$db = & JFactory::getOracleDBO();
		
		$dId = $post['dId'];
		$uTC = $post['uId'];
		
		$sqlUp = "UPDATE M_DENETIM_RAPOR_ONAY SET ONAY = 1, TARIH = TO_DATE('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS') 
				WHERE DENETIM_ID = ? AND UZMAN_ID = (SELECT USER_ID FROM M_UZMAN_HAVUZU WHERE TC_KIMLIK = ?)";
		
		return $db->prep_exec_insert($sqlUp, array($dId,$uTC));
	}
	
	function SonraSilTCKontrol(){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI";
		$data = $db->prep_exec($sql, array());
		
// 		$data[] = array('TC_KIMLIK'=>'10669335856','ADI'=>'Hülya','SOYADI'=>'ÖZFİLİZ','DOGUM_TARIHI'=>'1979-05-22 00:00:00');
		
		$hataArray = array();
		foreach ($data as $row){
			$date = explode('/', $row['DOGUM_TARIHI']);
// 			$date = new DateTime($row['DOGUM_TARIHI']);
// 			$date = strtotime($row['DOGUM_TARIHI']);
			$deger = array(
				'tcno'=>$row['TC_KIMLIK'],
				'isim'=>$row['ADI'],
				'soyisim'=>$row['SOYADI'],
				'dogumyili'=>$date[2]
			);
			
			$return = FormFactory::TCKimlikDogrulama($deger);
			
			if($return !== true && $return !== 'true'){
				$hataArray[] = $row['TC_KIMLIK'];
			}
		}
		
		return $hataArray;
	}
}
?>
