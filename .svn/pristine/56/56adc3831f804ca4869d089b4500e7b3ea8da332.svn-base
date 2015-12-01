<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once('libraries/form/form_config.php');

class FormABHibeUcretHesabi
{
	public function BasariliBirimUcretiHesabi($tckn, $yeterlilik_id, $sinavTarihi, $kId){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$yeniMi = $db->prep_exec($sql, array($yeterlilik_id));
	
		$dataYet = FormABHibeUcretHesabi::AlteratifBirim($yeterlilik_id);
		$zorunluBirims =$dataYet[1];
		$secmeliBirims = $dataYet[0];
		$basariliZorunluBirimler = FormABHibeUcretHesabi::BasBirimUcret($zorunluBirims, $tckn,$yeniMi[0]['YENI_MI'],$yeterlilik_id,$sinavTarihi, $kId);
		$basariliSecmeliBirimler = FormABHibeUcretHesabi::BasBirimUcret($secmeliBirims, $tckn,$yeniMi[0]['YENI_MI'],$yeterlilik_id,$sinavTarihi, $kId);
	
		if(is_array($basariliSecmeliBirimler)){
			return $basariliZorunluBirimler+$basariliSecmeliBirimler;
		}else{
			return $basariliZorunluBirimler;
		}
	
	}
	
	public function TebligOncesiSinav($tckn,$birim_id,$kurId,$sinavTarih,$yeniMi,$yetId,$kId){
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
	
			$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')<=TO_DATE('".$data[0]['SINAV_TARIHI']."')
						UNION
						select TO_CHAR('false') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')>TO_DATE('".$data[0]['SINAV_TARIHI']."')";
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
	
			$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')<=TO_DATE('".$data[0]['SINAV_TARIHI']."')
						UNION
						select TO_CHAR('false') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')>TO_DATE('".$data[0]['SINAV_TARIHI']."')";
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
	
	public function BirimdenBasarisiVeUcret($tckn,$birim_id,$sinavTurleri,$sinavTarihi,$yeniMi,$kId){
		$db = JFactory::getOracleDBO ();
		if($yeniMi == 1){
			// YENi SORGU
			/*
			 * Basarili birimleri bulmak icin once Birim Gecerlilik tarihine gore basarili birim türlerini bul
				*/
			$sql = "select MBAB.KURULUS_ID, MBAB.SINAV_TARIHI, MBAB.SINAV_TURU_KODU 
					FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
            				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
        					INNER JOIN M_BIRIM ON(MBAB.BIRIM_ID = M_BIRIM.BIRIM_ID)
            				INNER JOIN
	            				(SELECT BIRIM_ID, OLC_DEG_HARF||OLC_DEG_NUMARA as TUR, OLC_DEG_GECERLILIK_SURESI AS TUR_TARIH FROM M_BIRIM_OLCME_DEGERLENDIRME) MBO
								ON(MBAB.SINAV_TURU_KODU = MBO.TUR AND MBAB.BIRIM_ID = MBO.BIRIM_ID)
							where MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ? and MBAB.BASARI_DURUMU = 1
							and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-(M_BIRIM.BIRIM_GECERLILIK_SURESI*12))+1 FROM DUAL)
							and MBAB.SINAV_TARIHI <= TO_DATE(?)+30
            				and MY.YENI_MI = 1
							and MBAB.KURULUS_ID = ?
							order by SINAV_TARIHI asc";
			$dataBasariliTurler = $db->prep_exec($sql, array($tckn,$birim_id,$sinavTarihi,$sinavTarihi,$kId));
	
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
			$sql = "select MBAB.KURULUS_ID, MBAB.SINAV_TARIHI, MBAB.SINAV_TURU_KODU 
					FROM M_BELGELENDIRME_ADAY_BILDIRIM MBAB
            				INNER JOIN M_YETERLILIK MY ON(MBAB.YETERLILIK_ID = MY.YETERLILIK_ID)
							INNER JOIN M_YETERLILIK_ALT_BIRIM MAB ON(MBAB.YETERLILIK_ID = MAB.YETERLILIK_ID AND MBAB.BIRIM_ID = MAB.YETERLILIK_ALT_BIRIM_ID)
            				INNER JOIN M_YETERLILIK_ALT_BIRIM_TUR MAT ON(MBAB.SINAV_TURU_KODU = MAT.TUR_KODU AND MBAB.BIRIM_ID = MAT.BIRIM_ID)
							where MBAB.TC_KIMLIK = ? and MBAB.BIRIM_ID = ? and MBAB.BASARI_DURUMU = 1
            				and MBAB.SINAV_TARIHI >= (SELECT ADD_MONTHS(TO_DATE(?),-(MAB.BIRIM_GECERLILIK_SURESI*12))+1 FROM DUAL)
							and MBAB.SINAV_TARIHI <= TO_DATE(?)+30
            				and MY.YENI_MI = 0
							and MBAB.KURULUS_ID = ?
							order by SINAV_TARIHI asc";
			$dataBasariliTurler = $db->prep_exec($sql, array($tckn,$birim_id,$sinavTarihi,$sinavTarihi,$kId));
	
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
	
	public function BasBirimUcret($data, $tckn, $yeniMi, $yeterlilik_id, $sinavTarihi, $kId){
		$db = JFactory::getOracleDBO ();
	
		foreach ($data as $birim_id=>$sinavTurleri){
			// YENi SORGU
			$birTarih = FormABHibeUcretHesabi::BirimdenBasarisiVeUcret($tckn,$birim_id,$sinavTurleri,$sinavTarihi,$yeniMi,$kId);
			if($birTarih){
				$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')<=TO_DATE('".$birTarih['tarih']."')
						UNION
						select TO_CHAR('false') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')>TO_DATE('".$birTarih['tarih']."')";
				$durum = $db->prep_exec($sql, array());
	
				if($durum[0]['DURUM'] == 'true'){
					$dataTeblig = FormABHibeUcretHesabi::TebligOncesiSinav($tckn,$birim_id,$birTarih['kurId'],$birTarih['tarih'],$yeniMi,$birTarih['yetId'],$kId);
					$basariliBirim[$birim_id]=array('tarih'=>$dataTeblig['tarih'],'kurId'=>$dataTeblig['kurId'],'ucret'=>$dataTeblig['ucret'],'yetId'=>$birTarih['yetId']);
				}else{
					$basariliBirim[$birim_id]=array('tarih'=>$birTarih['tarih'],'kurId'=>$birTarih['kurId'],'ucret'=>0, 'yetId'=>$birTarih['yetId']);
				}
	
			}else{
				$sql = "SELECT YERINE_GECERLI_BIRIM_ID, YENI_MI FROM M_BIRIM_YERINE_GECERLI
            				WHERE BIRIM_ID = ?";
				$birimGerliler = $db->prep_exec($sql, array($birim_id));
	
				foreach($birimGerliler as $val){
					$sinavTurleri = FormABHibeUcretHesabi::AlteratifBirimWithBirimId($val['YERINE_GECERLI_BIRIM_ID'],$val['YENI_MI']);
					$birTarih = FormABHibeUcretHesabi::BirimdenBasarisiVeUcret($tckn,$val['YERINE_GECERLI_BIRIM_ID'],$sinavTurleri,$sinavTarihi,$val['YENI_MI'],$kId);
					if($birTarih){
						$sql = "select TO_CHAR('true') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')<=TO_DATE('".$birTarih['tarih']."')
							UNION
							select TO_CHAR('false') as durum from dual where TO_DATE('".FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)."')>TO_DATE('".$birTarih['tarih']."')";
						$durum = $db->prep_exec($sql, array());
							
						if($durum[0]['DURUM']){
							$dataTeblig = FormABHibeUcretHesabi::TebligOncesiSinav($tckn,$val['YERINE_GECERLI_BIRIM_ID'],$birTarih['kurId'],$birTarih['tarih'],$yeniMi,$birTarih['yetId'],$kId);
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
	
	public function TesviktenSonrakiIlkSinavTarihi($tc,$yId,$kId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM 
				WHERE TC_KIMLIK = ? AND YETERLILIK_ID = ? AND TO_DATE(?) <= SINAV_TARIHI  
				ORDER BY SINAV_TARIHI ASC";
		$data = $db->prep_exec($sql, array($tc,$yId,FormABHibeUcretHesabi::KurulusProtokolTarihi($kId)));
		if($data){
			return $data[0]['SINAV_TARIHI'];
		}else{
			return FormABHibeUcretHesabi::KurulusProtokolTarihi($kId);
		}
	}
	
	public function KurulusProtokolTarihi($kId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM AB_KURULUS_PROTOKOL WHERE KURULUS_ID = ?";
		$data = $db->prep_exec($sql, array($kId));
		if($data){
			return $data[0]['PRO_TARIH'];
		}else{
			return false;
		}
	}
	
	public function KurulusProtokolVarMi($kId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM AB_KURULUS_PROTOKOL WHERE KURULUS_ID = ?";
		$data = $db->prep_exec($sql, array($kId));
		if($data){
			return true;
		}else{
			return false;
		}
	}
	
	public function KuruluABHibeToplamKota($kId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT AVG(UCRET) AS UCRET FROM AB_KURULUS_DONEM WHERE KURULUS_ID = ?";
		$data = $db->prep_exec($sql, array($kId));
		if($data){
			return FormABHibeUcretHesabi::UcretDuzenle($data[0]['UCRET']);
		}else{
			return 0;
		}
	}
	
	public function KuruluABHibeProtokol($kId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM AB_KURULUS_PROTOKOL WHERE KURULUS_ID = ?";
		$data = $db->prep_exec($sql, array($kId));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function KuruluABHibeKullanilanKota($kId, $IstekId = 0){
		$db = JFactory::getOracleDBO ();
		$sqlPlus = "";
		if($IstekId){
			$sqlPlus = " ID != ".$IstekId;  
		}
		
		// Geri Ödenen Ücretler
		$sql = "SELECT AVG(ODENEN) AS ODENEN FROM AB_HIBE_KURULUS_ISTEK WHERE DURUM = 5 AND USER_ID = ?".$sqlPlus;
		$dataOdenen = $db->prep_exec($sql, array($kId));
		$odenenTop = FormABHibeUcretHesabi::UcretDuzenle($dataOdenen[0]['ODENEN']);
		
		return $odenenTop;
	}
	
	public function KuruluABHibeKullanilanDezKota($kId, $IstekId = 0){
		$db = JFactory::getOracleDBO ();
	
		$sqlPlus = "";
		if($IstekId){
			$sqlPlus = " ABHKI.ID != ".$IstekId;
		}
		
		// Geri Ödenen Ücretler
		$sql = "SELECT DISTINCT ABHKI.ID, ABHKI.BANKA_KURU FROM AB_HIBE_KURULUS_ISTEK ABHKI 
				INNER JOIN  AB_HIBE_KURULUS_ADAY ABHKA ON(ABHKI.ID = ABHKA.ISTEK_ID)
				WHERE ABHKI.DURUM = 5 AND ABHKI.USER_ID = ?";
		$dataKur = $db->prep_exec($sql, array($kId));
		$odenenTop = 0;
		foreach($dataKur as $row){
			$sqlAday = "SELECT AVG(ABHKA.KDVSIZ) AS TOPLAM FROM AB_HIBE_KURULUS_ADAY ABHKA
						INNER JOIN AB_HIBE_DEZAVANTAJ_ADAY ABHDA ON(ABHKA.BELGE_NO = ABHDA.BELGE_NO) 
						WHERE ISTEK_ID = ?
					";
			$dataAday = $db->prep_exec($sqlAday, array($row['ID']));
			$odenenTop += (FormABHibeUcretHesabi::UcretDuzenle($dataAday[0]['TOPLAM'])/FormABHibeUcretHesabi::UcretDuzenle($row['BANKA_KURU']));
		}	
	
		return $odenenTop;
	}
	
	public function KuruluABHibeBekKota($kId, $IstekId = 0){
		$db = JFactory::getOracleDBO ();
		$sqlPlus = "";
		if($IstekId){
			$sqlPlus = " ID != ".$IstekId;
		}
	
		// Oluşturulmuş AMA Daha Ödemesi Yapılmamış
		$sql = "SELECT DOVIZ_KURU, KDVSIZ FROM AB_HIBE_KURULUS_ISTEK WHERE DURUM != 5 AND DURUM != 0 AND USER_ID = ?".$sqlPlus;
		$data = $db->prep_exec($sql, array($kId));
		$odenmeyenTop = 0;
		foreach ($data as $row){
			$odenmeyenTop += FormABHibeUcretHesabi::UcretDuzenle($row['KDVSIZ'])/FormABHibeUcretHesabi::UcretDuzenle($row['DOVIZ_KURU']);
		}
	
		return $odenmeyenTop;
	}
	
	public function KuruluABHibeBekDezKota($kId, $IstekId = 0){
		$db = JFactory::getOracleDBO ();
	
		$sqlPlus = "";
		if($IstekId){
			$sqlPlus = " ABHKI.ID != ".$IstekId;
		}
	
		// Oluşturulmuş AMA Daha Ödemesi Yapılmamış
		$sql = "SELECT DISTINCT ABHKI.ID, ABHKI.DOVIZ_KURU FROM AB_HIBE_KURULUS_ISTEK ABHKI
				INNER JOIN  AB_HIBE_KURULUS_ADAY ABHKA ON(ABHKI.ID = ABHKA.ISTEK_ID)
				WHERE ABHKI.DURUM != 5 AND ABHKI.DURUM != 0 AND ABHKI.USER_ID = ?".$sqlPlus;
		$dataKur = $db->prep_exec($sql, array($kId));
		$odenmeyenTop = 0;
		foreach($dataKur as $row){
			$sqlAday = "SELECT AVG(ABHKA.KDVSIZ) AS TOPLAM FROM AB_HIBE_KURULUS_ADAY ABHKA
						INNER JOIN AB_HIBE_DEZAVANTAJ_ADAY ABHDA ON(ABHKA.BELGE_NO = ABHDA.BELGE_NO)
						WHERE ISTEK_ID = ?
					";
			$dataAday = $db->prep_exec($sqlAday, array($row['ID']));
			$odenmeyenTop += (FormABHibeUcretHesabi::UcretDuzenle($dataAday[0]['TOPLAM'])/FormABHibeUcretHesabi::UcretDuzenle($row['DOVIZ_KURU']));
		}
	
		return $odenmeyenTop;
	}
	
	public function TariheGoreDovizKuru($tar){
		$tarexp = explode('-', $tar);
		$yilay = $tarexp[2].$tarexp[1];
		$gunayyil = $tarexp[0].$tarexp[1].$tarexp[2];
		$url		=	"http://www.tcmb.gov.tr/kurlar/".$yilay."/".$gunayyil.".xml";
// 		$url = "http://www.tcmb.gov.tr/kurlar/201501/01012015.xml";
		$xml 		=	simplexml_load_file($url);
		$doviz 		=	array("alis"=>"","satis"=>"", "tarih"=>"");
		
		if($xml){
			foreach ($xml as $kur)
			{
				if ($kur["Kod"]=="EUR")
				{
					$doviz["alis"]=json_decode($kur->ForexBuying);
					$doviz["satis"]=json_decode($kur->ForexSelling);
					$doviz["tarih"] = $tar;
				}
			}
			return $doviz;
		}else{
			$date = new DateTime($tar);
			date_sub($date, new DateInterval("P1D"));
			return FormABHibeUcretHesabi::TariheGoreDovizKuru($date->format("d-m-Y"));
		}
	}
	
	public function ABHibeMaxUcret(){
		// Euro bazında ücret
		return 300;
	}
	
	function UcretDuzenle($ucret){
		return str_replace(',', '.',$ucret);
	}
	
	function KotaOdemeKontrol($TopUcret, $TopDez, $doviz, $kId, $IstekId = 0){
		$db = JFactory::getOracleDBO ();
		$KurPro = FormABHibeUcretHesabi::KuruluABHibeProtokol($kId);
		$ToplamKota = FormABHibeUcretHesabi::KuruluABHibeToplamKota($kId);
		$KulTop = FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($kId, $IstekId);
		$KulDez = FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($kId, $IstekId);
		$KulNorKota = $KulTop - $KulDez;
		
		$doviz = FormABHibeUcretHesabi::UcretDuzenle($doviz);
		$TopUcret = FormABHibeUcretHesabi::UcretDuzenle($TopUcret)/$doviz;
		$TopDez = FormABHibeUcretHesabi::UcretDuzenle($TopDez)/$doviz;
		
		$TopNorUcret = FormABHibeUcretHesabi::UcretDuzenle($TopUcret) - FormABHibeUcretHesabi::UcretDuzenle($TopDez);
		
		$tt = FormABHibeUcretHesabi::UcretDuzenle($TopUcret) + $KulTop;
		if($tt > $ToplamKota){
			return array('hata'=>1, 'mesaj'=>'Talep etmek istediğiniz ücret iadesi Kalan Toplam Kotanızı aşmaktadır.');
		}
		
		if($KurPro['DEZAVANTAJ'] == 1){
			$ToplamDezKota = $ToplamKota/10;
			$ToplamNorKota = $ToplamKota - $ToplamDezKota;
			
			$tt = FormABHibeUcretHesabi::UcretDuzenle($TopDez) + $KulDez;
			if($tt > $ToplamDezKota){
				return array('hata'=>1, 'mesaj'=>'Talep etmek istediğiniz ücret iadesindeki Dezavantajlı adayların ücret toplamı Kalan Dezavantajlı Toplam Kotanızı aşmaktadır.');
			}

			$tt = FormABHibeUcretHesabi::UcretDuzenle($TopNorUcret) + $KulNorKota;
			if($tt > $ToplamNorKota){
				return array('hata'=>1, 'mesaj'=>'Talep etmek istediğiniz ücret iadesindeki Dezavantajlı olmayan adayların ücret toplamı Kalan Dezavantajlı Olmayan Toplam Kotanızı aşmaktadır.');
			}
			
		}
		
		return array('hata'=>0);
	}
	
	public function KotaOdemeKontrolWithId($IstekId,$doviz){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
		$data = $db->prep_exec($sql, array($IstekId));
		
		$kId = $data[0]['USER_ID'];
		
		$KurPro = FormABHibeUcretHesabi::KuruluABHibeProtokol($kId);
		$ToplamKota = FormABHibeUcretHesabi::KuruluABHibeToplamKota($kId);
		$KulTop = FormABHibeUcretHesabi::KuruluABHibeKullanilanKota($kId, $IstekId);
		$KulDez = FormABHibeUcretHesabi::KuruluABHibeKullanilanDezKota($kId, $IstekId);
		$KulNorKota = $KulTop - $KulDez;
		$KurKdv = FormABHibeUcretHesabi::UcretDuzenle(1+($KurPro['KDV']/100));
		$doviz = FormABHibeUcretHesabi::UcretDuzenle($doviz);
		$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret();
		$TopUcret = 0;
		$TopDez = 0;
		$TopNorUcret = 0;
		//******** ADAYLARIN UCRETLERI *****************************************************//
		$sqlAday = "SELECT MTA.*,MBS.*, ABHDA.DOKUMAN AS DEZDOK FROM AB_HIBE_KURULUS_ADAY MTA
				INNER JOIN M_BELGE_SORGU MBS ON(MTA.BELGE_NO = MBS.BELGENO)
				LEFT JOIN AB_HIBE_DEZAVANTAJ_ADAY ABHDA ON(MTA.BELGE_NO = ABHDA.BELGE_NO)
				WHERE MTA.ISTEK_ID = ?";
		
		$adays = $db->prep_exec($sqlAday, array($IstekId));
		$hata = 0;
		foreach($adays as $cow){
			$Hesap = 0;
			$sqlItiraz = "SELECT * FROM AB_HIBE_ITIRAZ WHERE BELGE_NO = ?";
			$dataItiraz = $db->prep_exec($sqlItiraz, array($cow['BELGE_NO']));
		
			$birimUcreti = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($cow['TCKIMLIKNO'],$cow['YETERLILIK_ID'], $cow['SINAV_TARIHI'],$cow['KURULUS_ID']);
			if($dataItiraz && $dataItiraz['DURUM'] == 1){
				$Hesap = FormABHibeUcretHesabi::UcretDuzenle($dataItiraz[0]['ITIRAZ_UCRET']);
			}else{
				foreach ($birimUcreti as $tow){
					$Hesap += $tow['ucret'];
				}
			}
			
			$Hesap = FormABHibeUcretHesabi::UcretDuzenle($Hesap/$KurKdv);
			$Hesap = $Hesap/$doviz;
		
			if($Hesap > FormABHibeUcretHesabi::UcretDuzenle($maxUcret)){
				$TopUcret += FormABHibeUcretHesabi::UcretDuzenle($maxUcret);
				if($cow['DEZDOK'] != null){
					$TopDez += FormABHibeUcretHesabi::UcretDuzenle($maxUcret);
				}else{
					$TopNorUcret += FormABHibeUcretHesabi::UcretDuzenle($maxUcret);
				}
			}else{
				$TopUcret += FormABHibeUcretHesabi::UcretDuzenle($Hesap);
				if($cow['DEZDOK'] != null){
					$TopDez += FormABHibeUcretHesabi::UcretDuzenle($Hesap);
				}else{
					$TopNorUcret += FormABHibeUcretHesabi::UcretDuzenle($Hesap);
				}
			}
			
		}
		//******** ADAYLARIN UCRETLERI SON *****************************************************//
		
		$tt = FormABHibeUcretHesabi::UcretDuzenle($TopUcret) + $KulTop;
		if($tt > $ToplamKota){
			return array('hata'=>1, 'mesaj'=>'Talep etmek istediğiniz ücret iadesi Kalan Toplam Kotanızı aşmaktadır.');
		}
		
		if($KurPro['DEZAVANTAJ'] == 1){
			$ToplamDezKota = $ToplamKota/10;
			$ToplamNorKota = $ToplamKota - $ToplamDezKota;
				
// 			$tt = FormABHibeUcretHesabi::UcretDuzenle($TopDez) + $KulDez;
// 			if($tt > $ToplamDezKota){
// 				return array('hata'=>1, 'mesaj'=>'Talep etmek istediğiniz ücret iadesindeki Dezavantajlı adayların ücret toplamı Kalan Dezavantajlı Toplam Kotanızı aşmaktadır.');
// 			}
		
			$tt = FormABHibeUcretHesabi::UcretDuzenle($TopNorUcret) + $KulNorKota;
			if($tt > $ToplamNorKota){
				return array('hata'=>1, 'mesaj'=>'Talep etmek istediğiniz ücret iadesindeki Dezavantajlı olmayan adayların ücret toplamı Kalan Dezavantajlı Olmayan Toplam Kotanızı aşmaktadır.');
			}
				
		}
		
		return array('hata'=>0);
	}
}