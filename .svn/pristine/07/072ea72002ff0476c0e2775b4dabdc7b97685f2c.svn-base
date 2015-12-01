<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class BelgelendirmeModelEski_Sinav extends JModel {
	
	function getYeterlilik($yetId){
		$db = JFactory::getOracleDBO();
		
		$sql="SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$data = $db->prep_exec($sql, array($yetId));
		return $data[0];
	}
	
	function getAdayVarmi($kimlik){
		$db = JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK = ?";
		return $db->prep_exec($sql, array($kimlik));
	}
	
	/*
	 * Adayın başarılı oldugu birimleri alıyoruz. 
	 * birim id'si, birim türü, basarı durumu, sınav tarihi
	 * */
	function getAdayBasariliBirims($kimlik, $yeterlilik){
		$db = JFactory::getOracleDBO();
		
		$yets = $this->getYeterlilik($yeterlilik);
		
		if($yets['YENI_MI'] == 1){
			$sql="SELECT DISTINCT M_BIRIM.BIRIM_ID, M_BIRIM.BIRIM_KODU, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_HARF, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_NUMARA 
					FROM M_BIRIM 
					JOIN M_YETERLILIK_BIRIM ON(M_BIRIM.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					JOIN M_BIRIM_OLCME_DEGERLENDIRME ON(M_BIRIM.BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID)
					WHERE M_YETERLILIK_BIRIM.YETERLILIK_ID = ? AND M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_HARF != 'D'";
			$data = $db->prep_exec($sql, array($yeterlilik));
			$birims = array();
			foreach($data as $row){
				if ($row["OLC_DEG_HARF"]!="D"){
					$birims[]=array("BIRIM_ID"=>$row["BIRIM_ID"],"KODU"=>$row["BIRIM_KODU"],"TUR"=>$row["OLC_DEG_HARF"].$row["OLC_DEG_NUMARA"]);
				}
			}
			
			$basariliBirims = array();
			foreach($birims as $cow){
				
				$sql="select BILDIRIM_ID, KURULUS_ID, SINAV_TARIHI, BASARI_DURUMU, PUAN, ESKI_MI 
						from M_BELGELENDIRME_ADAY_BILDIRIM 
						where TC_KIMLIK = ? and BIRIM_ID = ? and SINAV_TURU_KODU = ? and BASARI_DURUMU = 1 
						and SINAV_TARIHI >= (SELECT SYSDATE-730 FROM DUAL) and rownum=1
	                    order by SINAV_TARIHI desc";
				$data = $db->prep_exec($sql, array($kimlik, $cow['BIRIM_ID'], $cow['TUR']));
				if($data){
					$basariliBirims[$cow['BIRIM_ID']][$cow['TUR']] = $data[0];
				}
			}
			return $basariliBirims;
		}else{
			$sql="select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu, yeterlilik_kodu from m_yeterlilik_alt_birim join m_yeterlilik using(yeterlilik_id) where yeterlilik_id=".$yeterlilik;
			$birimler = $db->prep_exec($sql, array());
				
			$birims = array();
			foreach ($birimler as $row){
				$sql="select TUR_KODU from M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID=".$row["BIRIM_ID"];
				$sinav_kodlari=$db->prep_exec($sql, array());
				foreach ($sinav_kodlari as $row2){
					$birims[]=array("BIRIM_ID"=>$row["BIRIM_ID"],"KODU"=>$row["YETERLILIK_KODU"].'/'.$row["BIRIM_KODU"],"TUR"=>$row2["TUR_KODU"]);
				}
			}
			
			$basariliBirims = array();
			foreach($birims as $cow){
			
				$sql="select BILDIRIM_ID, KURULUS_ID, SINAV_TARIHI, BASARI_DURUMU, PUAN, ESKI_MI 
						from M_BELGELENDIRME_ADAY_BILDIRIM
						where TC_KIMLIK = ? and BIRIM_ID = ? and SINAV_TURU_KODU = ? and BASARI_DURUMU = 1
						and SINAV_TARIHI >= (SELECT SYSDATE-730 FROM DUAL) and rownum=1
	                    order by SINAV_TARIHI desc";
				$data = $db->prep_exec($sql, array($kimlik, $cow['BIRIM_ID'], $cow['TUR']));
				if($data){
					$basariliBirims[$cow['BIRIM_ID']][$cow['TUR']] = $data[0];
				}
			}
			return $basariliBirims;
		}
	}
	
	/*
	 * Yeterliliğe ait birimler ve birim türleri
	 */
	function getYeterlilikBirims($yeterlilik){
		$db = JFactory::getOracleDBO();
		
		$yets = $this->getYeterlilik($yeterlilik);
		
		if($yets['YENI_MI'] == 1){
			$sql="SELECT M_BIRIM.BIRIM_ID, M_BIRIM.BIRIM_KODU, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_HARF, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_NUMARA 
					FROM M_BIRIM 
					JOIN M_YETERLILIK_BIRIM ON(M_BIRIM.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					JOIN M_BIRIM_OLCME_DEGERLENDIRME ON(M_BIRIM.BIRIM_ID = M_BIRIM_OLCME_DEGERLENDIRME.BIRIM_ID)
					WHERE M_YETERLILIK_BIRIM.YETERLILIK_ID = ? AND M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_HARF != 'D' 
					ORDER BY M_BIRIM.BIRIM_KODU ASC, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_HARF ASC, M_BIRIM_OLCME_DEGERLENDIRME.OLC_DEG_NUMARA ASC";
			$data = $db->prep_exec($sql, array($yeterlilik));
			$birims = array();
			$birimTurs = array();
			foreach($data as $row){
				if ($row["OLC_DEG_HARF"]!="D"){
					if(!array_key_exists($row["BIRIM_ID"], $birims)){
						$birims[$row["BIRIM_ID"]]["KODU"] = $row["BIRIM_KODU"];
					}
					
					$birimTurs[$row["BIRIM_ID"]][$row["OLC_DEG_HARF"].$row["OLC_DEG_NUMARA"]] = array("BIRIM_ID"=>$row["BIRIM_ID"],"KODU"=>$row["BIRIM_KODU"],"TUR"=>$row["OLC_DEG_HARF"].$row["OLC_DEG_NUMARA"]);
				}
			}
		}else{
			$sql="select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu, yeterlilik_kodu 
					from m_yeterlilik_alt_birim 
					join m_yeterlilik using(yeterlilik_id) 
					where yeterlilik_id=".$yeterlilik." 
					order by birim_kodu asc";
			$birimler = $db->prep_exec($sql, array());
			
			$birims = array();
			$birimTurs = array();
			
			foreach ($birimler as $row){
				$sql="select TUR_KODU from M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID=".$row["BIRIM_ID"]." ORDER BY TUR_KODU ASC";
				$sinav_kodlari=$db->prep_exec($sql, array());

				foreach ($sinav_kodlari as $row2){
					if(!array_key_exists($row["BIRIM_ID"], $birims)){
						$birims[$row["BIRIM_ID"]]["KODU"] = $row["BIRIM_KODU"];
					}
					$birimTurs[$row["BIRIM_ID"]][$row2["TUR_KODU"]]=array("BIRIM_ID"=>$row["BIRIM_ID"],"KODU"=>$row["YETERLILIK_KODU"].'/'.$row["BIRIM_KODU"],"TUR"=>$row2["TUR_KODU"]);
				}
			}
		}
		
		return array(0=>$birims,1=>$birimTurs);
	}
	
	/*
	 * Kurulus bilgilerini alma
	 */
	function getKurulus(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_KURULUS WHERE KURULUS_DURUM_ID != 1 ORDER BY KURULUS_ADI ASC";

		$data = $db->prep_exec($sql, array());
		$kurulus = array();
		foreach($data as $val){
			$kurulus[$val['USER_ID']] = $val;
		}
		return $kurulus;
	}
	
	/*
	 * Eski sinav birimleri kaydetme
	 */
	function EskiSinavBirimKaydet($post){
		$db = JFactory::getOracleDBO();
		
		$kimlik = $post['kimlik'];
		$yetId = $post['yeterlilik'];
		$eskiMi = 1;
		$tarih = $post['tarih'];
		$puan = $post['puan'];
		$kurulus = $post['kurulus'];
		
		$sql = "INSERT INTO M_BELGELENDIRME_ADAY_BILDIRIM (TC_KIMLIK, YETERLILIK_ID, KURULUS_ID, BIRIM_ID, 
				SINAV_TURU_KODU, SINAV_TARIHI, PUAN, BASARI_DURUMU, ESKI_MI) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		foreach($tarih as $key=>$val){
			foreach($val as $key2=>$val2){
				if(!empty($val2) && !empty($puan[$key][$key2]) && $kurulus[$key][$key2] != 0){
					$params = array(
							$kimlik,
							$yetId,
							$kurulus[$key][$key2],
							$key,
							$key2,
							$val2,
							$puan[$key][$key2],
							1,
							$eskiMi
					);
					
					$db->prep_exec_insert($sql, $params);
				}
			}
		}
		
		return true;
	}
	
	function eskiSinavBirimSil($bildirimId){
		$db = JFactory::getOracleDBO();
		
		$sql = "DELETE FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE BILDIRIM_ID = ?";
		
		return $db->prep_exec($sql, array($bildirimId));
	}
	
	function eskiSinavBirimTurGetir($bildirimId){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE BILDIRIM_ID = ?";
		
		$data = $db->prep_exec($sql, array($bildirimId));
		
		if($data){
			$yets = $this->getYeterlilik($data[0]['YETERLILIK_ID']);
			if($yets['YENI_MI'] == 1){
				$sql="SELECT BIRIM_KODU FROM M_BIRIM 
					WHERE BIRIM_ID = ? ";
				$birimKodu = $db->prep_exec($sql, array($data[0]['BIRIM_ID']));
			}else{
				$sql="select yeterlilik_alt_birim_no as birim_kodu from m_yeterlilik_alt_birim  where yeterlilik_alt_birim_id=? 
					order by birim_kodu asc";
				$birimKodu = $db->prep_exec($sql, array($data[0]['BIRIM_ID']));
			}
			return array($data[0],$birimKodu[0]);
		}else{
			return false;
		}
	}
	
	function eskiSinavBirimUpdate($post){
		$db = JFactory::getOracleDBO();
		
		$sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET SINAV_TARIHI = ?, PUAN = ?, KURULUS_ID = ? WHERE BILDIRIM_ID = ?";
		
		$return = $db->prep_exec_insert($sql, array($post['tarih'],$post['puan'],$post['kurulus'],$post['bildirimId']));
		
		if($return){
			$sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE BILDIRIM_ID = ?";
			$data = $db->prep_exec($sql, array($post['bildirimId']));
			 return array('kimlik'=>$data[0]['TC_KIMLIK'], 'yeterlilik'=>$data[0]['YETERLILIK_ID']);
		}else{
			return false;
		}
	}
}