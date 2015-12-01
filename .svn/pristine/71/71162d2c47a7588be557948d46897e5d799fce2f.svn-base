<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once('libraries/form/form_config.php');

class FormUcretHesabi
{
	public function BasariliBirimUcretiHesabi($tckn, $yeterlilik_id, $sinavTarihi){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$yeniMi = $db->prep_exec($sql, array($yeterlilik_id));
	
		$dataYet = FormUcretHesabi::AlteratifBirim($yeterlilik_id);
		$zorunluBirims =$dataYet[1];
		$secmeliBirims = $dataYet[0];
		$basariliZorunluBirimler = FormUcretHesabi::BasBirimUcret($zorunluBirims, $tckn,$yeniMi[0]['YENI_MI'],$yeterlilik_id,$sinavTarihi);
		$basariliSecmeliBirimler = FormUcretHesabi::BasBirimUcret($secmeliBirims, $tckn,$yeniMi[0]['YENI_MI'],$yeterlilik_id,$sinavTarihi);
	
		if(is_array($basariliSecmeliBirimler)){
			return $basariliZorunluBirimler+$basariliSecmeliBirimler;
		}else{
			return $basariliZorunluBirimler;
		}
	
	}
	
	public function TebligOncesiSinav($tckn,$birim_id,$kurId,$sinavTarih,$yeniMi,$yetId){
		$db = JFactory::getOracleDBO();
		if($yeniMi == 1){
			$sqlBirTur = "SELECT DISTINCT OLC_DEG_GECERLILIK_SURESI AS TUR_TARIH
					FROM M_BIRIM_OLCME_DEGERLENDIRME
					WHERE BIRIM_ID = ?";
			$dataTur = $db->prep_exec($sqlBirTur, array($birim_id));
	
			$sql = "select MBAB.KURULUS_ID, MBAB.SINAV_TARIHI, MBAB.SINAV_TURU_KODU
					FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
				WHERE MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ?
					and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-(".$dataTur[0]['TUR_TARIH']."*12))+1 FROM DUAL)
					and MBAB.SINAV_TARIHI <= TO_DATE(?)
           			and MY.YENI_MI = 1
					order by SINAV_TARIHI asc";
			$data = $db->prep_exec($sql, array($tckn,$birim_id,$sinavTarih,$sinavTarih));
	
			$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".TEBLIG_TARIH."')<=TO_DATE('".$data[0]['SINAV_TARIHI']."')
						UNION
						select TO_CHAR('false') as durum from dual where TO_DATE('".TEBLIG_TARIH."')>TO_DATE('".$data[0]['SINAV_TARIHI']."')";
			$durum = $db->prep_exec($sql, array());
	
			if($durum[0]['DURUM'] == 'true'){
				$sqlUcret = "SELECT MUT.UCRET FROM M_UCRET_TARIFESI MUT
						INNER JOIN M_UCRET_TARIFESI_DONEM MUTD
						ON(
						MUT.DONEM_ID = MUTD.DONEM_ID
						AND MUT.YETERLILIK_ID = MUTD.YET_ID
						AND MUT.USER_ID = MUTD.USER_ID
						)
						WHERE MUT.BIRIM_ID = ?
						AND MUTD.USER_ID = ?
						AND MUT.YETERLILIK_ID = ?
						AND MUTD.TARIH<=TO_DATE(?)
						AND (MUTD.DURUM = -2 OR MUTD.DURUM = 3)
						ORDER BY TARIH DESC";
				$DateUcret = $db->prep_exec($sqlUcret, array($birim_id,$kurId,$yetId,$data[0]['SINAV_TARIHI']));
	
				$ucret = 0;
				if($DateUcret){
					$ucret = str_replace(',', '.', $DateUcret[0]['UCRET']);
				}
	
				return array('tarih'=>$data[0]['SINAV_TARIHI'],'kurId'=>$data[0]['KURULUS_ID'],'ucret'=>$ucret);
			}else{
				return array('tarih'=>$data[0]['SINAV_TARIHI'],'kurId'=>$data[0]['KURULUS_ID'],'ucret'=>0);
			}
	
		}else{
			$sqlBirTur = "SELECT DISTINCT OLC_DEG_GECERLILIK_SURESI AS TUR_TARIH
					FROM M_BIRIM_OLCME_DEGERLENDIRME
					WHERE BIRIM_ID = ?";
			$dataTur = $db->prep_exec($sqlBirTur, array($birim_id));
	
			$sql = "select MBAB.KURULUS_ID, MBAB.SINAV_TARIHI, MBAB.SINAV_TURU_KODU
					FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
				WHERE MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ?
					and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-12)+1 FROM DUAL)
					and MBAB.SINAV_TARIHI <= TO_DATE(?)
           			and MY.YENI_MI = 0
					order by SINAV_TARIHI asc";
			$data = $db->prep_exec($sql, array($tckn,$birim_id,$sinavTarih,$sinavTarih));
	
			$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".TEBLIG_TARIH."')<=TO_DATE('".$data[0]['SINAV_TARIHI']."')
						UNION
						select TO_CHAR('false') as durum from dual where TO_DATE('".TEBLIG_TARIH."')>TO_DATE('".$data[0]['SINAV_TARIHI']."')";
			$durum = $db->prep_exec($sql, array());
	
			if($durum[0]['DURUM'] == 'true'){
				$sqlUcret = "SELECT MUT.UCRET FROM M_UCRET_TARIFESI MUT
						INNER JOIN M_UCRET_TARIFESI_DONEM MUTD
						ON(MUT.DONEM_ID = MUTD.DONEM_ID
						AND MUT.YETERLILIK_ID = MUTD.YET_ID
						AND MUT.USER_ID = MUTD.USER_ID
						)
						WHERE MUT.BIRIM_ID = ?
						AND MUTD.USER_ID = ?
						AND MUT.YETERLILIK_ID = ?
						AND MUTD.TARIH<=TO_DATE(?)
						AND (MUTD.DURUM = -2 OR MUTD.DURUM = 3) 
						ORDER BY TARIH DESC";
				$DateUcret = $db->prep_exec($sqlUcret, array($birim_id,$kurId,$yetId,$data[0]['SINAV_TARIHI']));
					
				$ucret = 0;
				if($DateUcret){
					$ucret = str_replace(',', '.', $DateUcret[0]['UCRET']);
				}
					
				return array('tarih'=>$data[0]['SINAV_TARIHI'],'kurId'=>$data[0]['KURULUS_ID'],'ucret'=>$ucret);
			}else{
				return array('tarih'=>$data[0]['SINAV_TARIHI'],'kurId'=>$data[0]['KURULUS_ID'],'ucret'=>0);
			}
		}
	}
	
	public function BirimdenBasarisiVeUcret($tckn,$birim_id,$sinavTurleri,$sinavTarihi,$yeniMi,$user_id){
		$db = JFactory::getOracleDBO ();
		if($yeniMi == 1){
			// YENi SORGU
			/*
			 * Basarili birimleri bulmak icin once Birim Gecerlilik tarihine gore basarili birim türlerini bul
				*/
			$sql = "select MBAB.KURULUS_ID, MBAB.SINAV_TARIHI, MBAB.SINAV_TURU_KODU FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
            				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
        					INNER JOIN M_BIRIM ON(MBAB.BIRIM_ID = M_BIRIM.BIRIM_ID)
            				INNER JOIN
	            				(SELECT BIRIM_ID, OLC_DEG_HARF||OLC_DEG_NUMARA as TUR, OLC_DEG_GECERLILIK_SURESI AS TUR_TARIH FROM M_BIRIM_OLCME_DEGERLENDIRME) MBO
								ON(MBAB.SINAV_TURU_KODU = MBO.TUR AND MBAB.BIRIM_ID = MBO.BIRIM_ID)
							where MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ? and MBAB.BASARI_DURUMU = 1
							and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-(M_BIRIM.BIRIM_GECERLILIK_SURESI*12))+1 FROM DUAL)
							and MBAB.SINAV_TARIHI <= TO_DATE(?)+30
            				and MY.YENI_MI = 1
							order by SINAV_TARIHI asc";
			$dataBasariliTurler = $db->prep_exec($sql, array($tckn,$birim_id,$sinavTarihi,$sinavTarihi));
	
			$basariliTurler = array();
			$basariliTurlerTarih = array();
			$say = 0;
			foreach($dataBasariliTurler as $basTur){
				/*
				 * Buldugun basarili birim türlerine gore Tur Gecerlilik tarihini kapsayan ve
					* o birim türü dısında basarılı olmus turleri bul.
					* Buldugun türleri ve islem yaptıgın türü bir array'de tut.
					* Daha sonra bunları sorguda kullanılacak.
					*/
				$sqlTurBas = "select DISTINCT MBAB.SINAV_TURU_KODU, MBAB.SINAV_TARIHI, MBAB.YETERLILIK_ID FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
            				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
            				INNER JOIN
	            				(SELECT BIRIM_ID, OLC_DEG_HARF||OLC_DEG_NUMARA as TUR, OLC_DEG_GECERLILIK_SURESI AS TUR_TARIH FROM M_BIRIM_OLCME_DEGERLENDIRME) MBO
								ON(MBAB.SINAV_TURU_KODU = MBO.TUR AND MBAB.BIRIM_ID = MBO.BIRIM_ID)
							where MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ? and MBAB.BASARI_DURUMU = 1
							and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-(MBO.TUR_TARIH*12))+1 FROM DUAL)
							and MBAB.SINAV_TARIHI <= (SELECT ADD_MONTHS(TO_DATE(?),+(MBO.TUR_TARIH*12))+1 FROM DUAL)
            				and MY.YENI_MI = 1
        					and MBAB.KURULUS_ID = ?
							ORDER BY SINAV_TARIHI ASC";
				$dat = $db->prep_exec($sqlTurBas, array($tckn,$birim_id,$basTur['SINAV_TARIHI'],$basTur['SINAV_TARIHI'],$basTur['KURULUS_ID']));
					
				// 				$basariliTurler[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $basTur['SINAV_TURU_KODU'];
				// 				$basariliTurlerTarih[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $basTur['SINAV_TARIHI'];
				foreach($dat as $row){
					$basariliTurler[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $row['SINAV_TURU_KODU'];
					$basariliTurlerTarih[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $row['SINAV_TARIHI'];
					$basariliTurlerYet[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $row['YETERLILIK_ID'];
				}
				$say++;
			}
	
			$sqlBirimTur = "SELECT * FROM M_BIRIM_ALTERNATIF_TUR WHERE BIRIM_ID = ? ORDER BY ALTERNATIF_TUR_ID ASC";
			$biriTur = $db->prep_exec($sqlBirimTur, array($birim_id));
			$turler = array();
			if($biriTur){
				foreach ($biriTur as $till){
					$turler[$till['ALTERNATIF_TUR_ID']][] = $till['BIRIM_TUR'].$till['BIRIM_NUMARA'];
				}
	
				foreach($basariliTurler as $key=>$val){
					foreach($val as $key2=>$val2){
						$birimBasArray = array();
						foreach($val2 as $key3=>$val3){
							foreach($val3 as $key4=>$val4){
								$birimBasArray[] = $val4;
								foreach ($turler as $ky2=>$fill){
									if(count(array_diff(array_values($fill),array_values($birimBasArray))) == 0){
										return array('tarih'=>$basariliTurlerTarih[$key][$key2][$key3][$key4], 'kurId'=>$key, 'yetId'=>$basariliTurlerYet[$key][$key2][$key3][$key4]);
										break;
									}
								}
							}
						}
					}
				}
				return false;
			}
			else{
	
				foreach($basariliTurler as $key=>$val){
					foreach($val as $key2=>$val2){
						$birimBasArray = array();
						foreach($val2 as $key3=>$val3){
							foreach($val3 as $key4=>$val4){
								$birimBasArray[] = $val4;
								if(count(array_diff(array_values($sinavTurleri),array_values($birimBasArray))) == 0){
									return array('tarih'=>$basariliTurlerTarih[$key][$key2][$key3][$key4], 'kurId'=>$key, 'yetId'=>$basariliTurlerYet[$key][$key2][$key3][$key4]);
									break;
								}
							}
						}
					}
				}
	
				return false;
			}
		}else{
			/*
			 * Basarili birimleri bulmak icin once Birim Gecerlilik tarihine gore basarili birim türlerini bul
				*/
			$sql = "select MBAB.KURULUS_ID, MBAB.SINAV_TARIHI, MBAB.SINAV_TURU_KODU FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
            				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
							INNER JOIN M_YETERLILIK_ALT_BIRIM MAB ON(MBAB.YETERLILIK_ID = MAB.YETERLILIK_ID AND MBAB.BIRIM_ID = MAB.YETERLILIK_ALT_BIRIM_ID)
            				INNER JOIN M_YETERLILIK_ALT_BIRIM_TUR MAT ON(MBAB.SINAV_TURU_KODU = MAT.TUR_KODU AND MBAB.BIRIM_ID = MAT.BIRIM_ID)
							where MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ? and MBAB.BASARI_DURUMU = 1
            				and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-(MAB.BIRIM_GECERLILIK_SURESI*12))+1 FROM DUAL)
							and MBAB.SINAV_TARIHI <= TO_DATE(?)+30
            				and MY.YENI_MI = 0
							order by SINAV_TARIHI asc";
			$dataBasariliTurler = $db->prep_exec($sql, array($tckn,$birim_id,$sinavTarihi,$sinavTarihi));
	
			$basariliTurler = array();
			$basariliTurlerTarih = array();
			$say = 0;
			foreach($dataBasariliTurler as $basTur){
				/*
				 * Buldugun basarili birim türlerine gore Tur Gecerlilik tarihini kapsayan ve
					* o birim türü dısında basarılı olmus turleri bul.
					* Buldugun türleri ve islem yaptıgın türü bir array'de tut.
					* Daha sonra bunları sorguda kullanılacak.
					*/
				$sqlTurBas = "select DISTINCT MBAB.SINAV_TURU_KODU, MBAB.SINAV_TARIHI, MBAB.YETERLILIK_ID
						FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
            				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
            				INNER JOIN M_YETERLILIK_ALT_BIRIM_TUR MAT ON(MBAB.SINAV_TURU_KODU = MAT.TUR_KODU AND MBAB.BIRIM_ID = MAT.BIRIM_ID)
							where MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ? and MBAB.BASARI_DURUMU = 1
							and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-12)+1 FROM DUAL)
							and MBAB.SINAV_TARIHI <= (SELECT ADD_MONTHS(TO_DATE(?),+12)+1 FROM DUAL)
            				and MY.YENI_MI = 0
        					and MBAB.KURULUS_ID = ?
							ORDER BY SINAV_TARIHI ASC";
				$dat = $db->prep_exec($sqlTurBas, array($tckn,$birim_id,$basTur['SINAV_TARIHI'],$basTur['SINAV_TARIHI'],$basTur['KURULUS_ID']));
					
				// 				$basariliTurler[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $basTur['SINAV_TURU_KODU'];
				// 				$basariliTurlerTarih[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $basTur['SINAV_TARIHI'];
				foreach($dat as $row){
					$basariliTurler[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $row['SINAV_TURU_KODU'];
					$basariliTurlerTarih[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $row['SINAV_TARIHI'];
					$basariliTurlerYet[$basTur['KURULUS_ID']][$say][$basTur['SINAV_TURU_KODU']][] = $row['YETERLILIK_ID'];
				}
				$say++;
			}
	
	
			foreach($basariliTurler as $key=>$val){
				foreach($val as $key2=>$val2){
					$birimBasArray = array();
					foreach($val2 as $key3=>$val3){
						foreach($val3 as $key4=>$val4){
							$birimBasArray[] = $val4;
							if(count(array_diff(array_values($sinavTurleri),array_values($birimBasArray))) == 0){
								return array('tarih'=>$basariliTurlerTarih[$key][$key2][$key3][$key4], 'kurId'=>$key, 'yetId'=>$basariliTurlerYet[$key][$key2][$key3][$key4]);
								break;
							}
						}
					}
				}
			}
	
			return false;
		}
	}
	
	public function BasBirimUcret($data, $tckn, $yeniMi, $yeterlilik_id, $sinavTarihi){
		$db = JFactory::getOracleDBO ();
	
		foreach ($data as $birim_id=>$sinavTurleri){
			// YENi SORGU
			$birTarih = FormUcretHesabi::BirimdenBasarisiVeUcret($tckn,$birim_id,$sinavTurleri,$sinavTarihi,$yeniMi);
			if($birTarih){
				$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".TEBLIG_TARIH."')<=TO_DATE('".$birTarih['tarih']."')
						UNION
						select TO_CHAR('false') as durum from dual where TO_DATE('".TEBLIG_TARIH."')>TO_DATE('".$birTarih['tarih']."')";
				$durum = $db->prep_exec($sql, array());
	
				if($durum[0]['DURUM'] == 'true'){
					$dataTeblig = FormUcretHesabi::TebligOncesiSinav($tckn,$birim_id,$birTarih['kurId'],$birTarih['tarih'],$yeniMi,$birTarih['yetId']);
					$basariliBirim[$birim_id]=array('tarih'=>$dataTeblig['tarih'],'kurId'=>$dataTeblig['kurId'],'ucret'=>$dataTeblig['ucret'],'yetId'=>$birTarih['yetId']);
				}else{
					$basariliBirim[$birim_id]=array('tarih'=>$birTarih['tarih'],'kurId'=>$birTarih['kurId'],'ucret'=>0, 'yetId'=>$birTarih['yetId']);
				}
	
			}else{
				$sql = "SELECT YERINE_GECERLI_BIRIM_ID, YENI_MI FROM M_BIRIM_YERINE_GECERLI
            				WHERE BIRIM_ID = ?";
				$birimGerliler = $db->prep_exec($sql, array($birim_id));
	
				foreach($birimGerliler as $val){
					$sinavTurleri = FormUcretHesabi::AlteratifBirimWithBirimId($val['YERINE_GECERLI_BIRIM_ID'],$val['YENI_MI']);
					$birTarih = FormUcretHesabi::BirimdenBasarisiVeUcret($tckn,$val['YERINE_GECERLI_BIRIM_ID'],$sinavTurleri,$sinavTarihi,$val['YENI_MI']);
					if($birTarih){
						$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".TEBLIG_TARIH."')<=TO_DATE('".$birTarih['tarih']."')
							UNION
							select TO_CHAR('false') as durum from dual where TO_DATE('".TEBLIG_TARIH."')>TO_DATE('".$birTarih['tarih']."')";
						$durum = $db->prep_exec($sql, array());
							
						if($durum[0]['DURUM']){
							$dataTeblig = FormUcretHesabi::TebligOncesiSinav($tckn,$val['YERINE_GECERLI_BIRIM_ID'],$birTarih['kurId'],$birTarih['tarih'],$yeniMi,$birTarih['yetId']);
							$basariliBirim[$birim_id]=array('tarih'=>$dataTeblig['tarih'],'kurId'=>$dataTeblig['kurId'],'ucret'=>$dataTeblig['ucret'],'yetId'=>$birTarih['yetId']);
						}else{
							$basariliBirim[$birim_id]=array('tarih'=>$birTarih['tarih'],'kurId'=>$birTarih['kurId'],'ucret'=>0);
						}
					}
				}
			}
		}
	
		return $basariliBirim;
		// YENi SORGU SON
	}
	
	public function AlteratifBirimWithBirimId($birimId, $yeniMi) {
		$db = JFactory::getOracleDBO ();
	
		if ($yeniMi){
			$sql="select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=".$birimId;
			$sinav_kodlari=$db->prep_exec($sql, array());
			foreach ($sinav_kodlari as $row2){
				if ($row2["OLC_DEG_HARF"]!="D"){
					$yeterlilik[]=$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"];
				}
			}
	
		} else {
			$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ?";
			$sinav_kodlari = $db->prep_exec($sql, array($birimId));
	
			foreach ($sinav_kodlari as $row2){
				$yeterlilik[] = $row2['TUR_KODU'];
			}
		}
	
		return $yeterlilik;
	}
	
	function AlteratifBirim($yeterlilik_id) {
		$_db = JFactory::getOracleDBO ();
	
		$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$yenimi = $_db->prep_exec($sql,array($yeterlilik_id));
		$yeni_mi=$yenimi[0]["YENI_MI"];
	
		if ($yeni_mi=="1"){
			$sql= "select birim_id, birim_kodu, zorunlu from m_birim join M_YETERLILIK_BIRIM using (birim_id)  where yeterlilik_id=".$yeterlilik_id;
			$birimler=$_db->prep_exec($sql, array());
	
			foreach ($birimler as $row){
				$sql="select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=".$row["BIRIM_ID"]." AND OLC_DEG_HARF != 'D'";
				$sinav_kodlari=$_db->prep_exec($sql, array());
				foreach ($sinav_kodlari as $row2){
					if ($row2["OLC_DEG_HARF"]!="D"){
						if($row['ZORUNLU'] == 0){
							$yeterlilik[0][$row["BIRIM_ID"]][]=$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"];
						}
						else{
							$yeterlilik[1][$row["BIRIM_ID"]][]=$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"];
						}
					}
				}
			}
	
		} else {
			$sql="select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu,
                		yeterlilik_zorunlu as zorunlu
                		from m_yeterlilik_alt_birim where yeterlilik_id=".$yeterlilik_id;
			$birimler=$_db->prep_exec($sql, array());
			foreach ($birimler as $row){
				$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ?";
				$sinav_kodlari = $_db->prep_exec($sql, array($row["BIRIM_ID"]));
					
				foreach ($sinav_kodlari as $row2){
					if($row['ZORUNLU'] == 0){
						$yeterlilik[0][$row["BIRIM_ID"]][] = $row2['TUR_KODU'];
					}
					else{
						$yeterlilik[1][$row["BIRIM_ID"]][] = $row2["TUR_KODU"];
					}
				}
			}
		}
	
		return $yeterlilik;
	}
	
	public function BelgeMasrafi($date){
		$db = JFactory::getOracleDBO ();
		$sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
		$masraf = $db->prep_exec($sqlMasraf, array($date));
		return str_replace(',', '.', $masraf[0]['BELGE_MASRAFI']);
	}
	
	public function TesviktenSonrakiIlkSinavTarihi($tc,$yId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM 
				WHERE TC_KIMLIK = ? AND YETERLILIK_ID = ? AND TO_DATE(?) <= SINAV_TARIHI  
				ORDER BY SINAV_TARIHI ASC";
		$data = $db->prep_exec($sql, array($tc,$yId,TEBLIG_TARIH));
		if($data){
			return $data[0]['SINAV_TARIHI'];
		}else{
			return TEBLIG_TARIH;
		}
	}
}