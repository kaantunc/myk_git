<?php
defined('_JEXEC') or die('Restricted access');

class Belgelendirme_AbhibeModelYonetici extends JModel {
	
	function TesvikIstekleri($user_id){
		$db = JFactory::getOracleDBO ();
		
		$sqlIstek = "SELECT 
				AB_HIBE_KURULUS_ISTEK.*, 
				TO_CHAR(AB_HIBE_KURULUS_ISTEK.BIT_TARIH,'DD/MM/YYYY') AS BIT_TARIH
	 FROM AB_HIBE_KURULUS_ISTEK
	WHERE AB_HIBE_KURULUS_ISTEK.USER_ID = ?
	ORDER BY AB_HIBE_KURULUS_ISTEK.BIT_TARIH DESC";
		
		$istek = $db->prep_exec($sqlIstek, array($user_id));
		
		$adayCount = array();
		$istekUcret = array();
		foreach($istek as $row){
			$adays = $this->TesvikIstekAdaylar($row['ID']);
			$adayCount[$row['ID']] = count($adays);
			$topUcret = $this->IstekUcretleriWithIstekId($row['ID']);
			$istekUcret[$row['ID']] = $topUcret['kdvli'];
		}
		
		return array('isteks'=>$istek, 'adayCount'=>$adayCount, 'istekUcret'=>$istekUcret);
	}
	
	function TesvikIstekleriWithDurum($durum=1){
		$db = JFactory::getOracleDBO ();
	
		$sqlIstek = "SELECT  AB_HIBE_KURULUS_ISTEK.*,
				TO_CHAR(AB_HIBE_KURULUS_ISTEK.BIT_TARIH,'DD/MM/YYYY') AS BIT_TARIH
							FROM AB_HIBE_KURULUS_ISTEK 
							WHERE AB_HIBE_KURULUS_ISTEK.DURUM = ?
							ORDER BY AB_HIBE_KURULUS_ISTEK.BIT_TARIH DESC";
	
		$istek = $db->prep_exec($sqlIstek, array($durum));
	
		$adayCount = array();
		$kurulus = array();
		$istekUcret = array();
		foreach($istek as $row){
			$adays = $this->TesvikIstekAdaylar($row['ID']);
			$kurulus[$row['ID']] = $this->getKurulusBilgi($row['USER_ID']);
			$adayCount[$row['ID']] = count($adays);
			$topUcret = $this->IstekUcretleriWithIstekId($row['ID']);
			$istekUcret[$row['ID']]['kdvli'] = $topUcret['kdvli'];
			$istekUcret[$row['ID']]['kdvsiz'] = $topUcret['kdvsiz'];
		}
		
		return array('isteks'=>$istek, 'adayCount'=>$adayCount, 'istekUcret'=>$istekUcret, 'kurulus'=>$kurulus);
	}
	
	function TesvikIstekAdaylar($IstekId){
		$db = JFactory::getOracleDBO ();
		
		$sqlAday = "SELECT * FROM AB_HIBE_KURULUS_ADAY MTA 
				INNER JOIN M_BELGE_SORGU MBS ON(MTA.BELGE_NO = MBS.BELGENO)
				WHERE MTA.ISTEK_ID = ?";
		
		return $db->prep_exec($sqlAday, array($IstekId));
	}
	
	function TesvikIstekAdaylarWithTarih($user_id, $bitTarih){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET, ABDEZ.DOKUMAN AS DEZAV 
				FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				LEFT JOIN AB_HIBE_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				LEFT JOIN AB_HIBE_DEZAVANTAJ_ADAY ABDEZ ON(MBS.BELGENO = ABDEZ.BELGE_NO)
				WHERE MBS.KURULUS_ID = ? AND MBS.ABHIBE = 1 
				AND MBS.BELGE_DUZENLEME_TARIHI <= TO_DATE(?)
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC
				";
		
		$tesvikAday = $db->prep_exec($sql, array($user_id, $bitTarih));
		
		$BelgeMasraf = array();
		$YetUcretiHesabi = array();
		$birimUcretiHesabi = array();
		foreach ($tesvikAday as $row){
			$birimUcretiHesabi[$row['BELGENO']] = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'],$row['YETERLILIK_ID'], $row['SINAV_TARIHI'],$row['KURULUS_ID']);
			/* Tesvik tarihinden sonraki ilk sınav tarihi */
// 			$ilkSinav = FormABHibeUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'],$row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
// 			if($row['BELGE_MASRAF']){
// 				$sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
// 				$masraf = $db->prep_exec($sqlMasraf, array($row['BELGE_DUZENLEME_TARIHI']));
// 				$BelgeMasraf[$row['BELGENO']] = $masraf[0]['BELGE_MASRAFI'];
// 			}else{
// 				$BelgeMasraf[$row['BELGENO']] = 0;
// 			}
		}
		
// 		return array('AdayBilgi'=>$tesvikAday, 'UcretBilgi'=>$birimUcretiHesabi, 'YetUcret'=>$YetUcretiHesabi,
// 				'BelgeMasraf'=>$BelgeMasraf
// 		);
		return array('AdayBilgi'=>$tesvikAday, 'UcretBilgi'=>$birimUcretiHesabi);
	}
	
	function YeterlilikUcretHesabi($yId, $tarih){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT MYU.UCRET, MYU.BAS_TARIH, MBK.KARAR_SAYI FROM M_YETERLILIK_UCRET MYU
				LEFT JOIN M_BAKANLAR_KURULU_KARAR_SAYI MBK ON(MYU.BAKANLAR_KURULU_KARAR_SAYI_ID = MBK.ID)
				WHERE MYU.YETERLILIK_ID = ? AND MYU.BAS_TARIH <= TO_DATE(?)
				ORDER BY BAS_TARIH DESC";
		$data = $db->prep_exec($sql, array($yId,$tarih));
	
		if($data){
			return $data[0];
		}else{
			return 0;
		}
	}
	
	// Belge almış adayların başarılı oldukları birim ücretleri
	
	function AlteratifBirim($yeterlilik_id) {
		$_db = JFactory::getOracleDBO ();
	
		$sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$yenimi = $_db->prep_exec($sql,array($yeterlilik_id));
		$yeni_mi=$yenimi[0]["YENI_MI"];
	
		if ($yeni_mi=="1"){
			$sql= "select birim_id, birim_kodu, zorunlu from m_birim join M_YETERLILIK_BIRIM using (birim_id)  where yeterlilik_id=".$yeterlilik_id;
			$birimler=$_db->prep_exec($sql, array());
	
			foreach ($birimler as $row){
				$sql="select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=".$row["BIRIM_ID"];
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
	
	function TesvikIstekKaydet($post,$user_id){
		$db = JFactory::getOracleDBO ();
		$adays = $post['adays'];
		
		if(array_key_exists('IstekId', $post) && is_numeric($post['IstekId'])){
			$IstekId = $post['IstekId'];
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET IMZA_UNVAN = ?, IMZA_ISIM = ? WHERE ID = ?";
			$return = $db->prep_exec_insert($sqlUp, array($post['unvan'],$post['isim'],$IstekId));
			
			$sql = "SELECT BELGE_NO FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ?";
			$kayitliAdaylar = $db->prep_exec_array($sql, array($IstekId));
			
			$diff = array_diff($kayitliAdaylar, $adays);
			$sqlDel = "DELETE FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ? AND BELGE_NO = ?";
			
			if($diff){
				$hata = 0;
				foreach($diff as $row){
					if(!$db->prep_exec_insert($sqlDel, array($IstekId,$row))){
						$hata++;
					}
				}
				if($hata > 0){
					return array('durum'=>1, 'message'=>'Hibe isteği düzenlendi. Fakat bazı belgeler hibe isteğine kaydedilemedi. Lütfen hibe isteğini tekrar düzenleyin.', 'IstekId'=>$IstekId);
				}
				
				$sqlUcret = "SELECT AVG(KDVLI) AS KDVLI, AVG(KDVSIZ) AS KDVSIZ FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ?";
				$dataUcret = $db->prep_exec($sqlUcret, array($IstekId));
				
				$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET KDVLI = ?, KDVSIZ = ? WHERE ISTEK_ID = ?";
				if(!$db->prep_exec_insert($sqlUp, array($dataUcret[0]['KDVLI'], $dataUcret[0]['KDVSIZ'], $IstekId))){
					return array('durum'=>1, 'message'=>'Hibe isteği oluşturuldu. Fakat bazı belgeler hibe isteğine kaydedilemedi. Lütfen hibe isteğini tekrar düzenleyin.', 'IstekId'=>$IstekId);
				}
			}
			
			return array('durum'=>2, 'message'=>'Başarılı bir şekilde hibe isteği düzenlendi.', 'IstekId'=>$IstekId);
		}else{
			return false;
		}
	}
	
	function GetTesvikWithTesvikId($IstekId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT ABHKI.*, TO_CHAR(ABHKI.BIT_TARIH,'dd/mm/yyyy') AS BIT_TARIH,
				TO_CHAR(ABHKI.ODEME_TARIHI,'dd/mm/yyyy') AS ODEME_TARIHI 
				FROM AB_HIBE_KURULUS_ISTEK ABHKI WHERE ABHKI.ID = ?";
		$data = $db->prep_exec($sql, array($IstekId));
	
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function GetTesvikAdaylarWithTesvikId($IstekId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT BELGE_NO FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ?";
		$data = $db->prep_exec_array($sql, array($IstekId));
		return $data;
	}
	
	function TesvikAdaylarWithTesvikId($tId){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT MBS.*, MY.*, MBO.*, MAT.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET, 
				ABDEZ.DOKUMAN AS DEZAV, ABDEZ.SINAV_ID AS DEZSINAV, 
				ABBAS.SINAV_ID AS BASSINAV, ABBAS.DOKUMAN AS BASDOK, ABIBAN.IBAN AS BASIBAN
				FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN AB_HIBE_KURULUS_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)
				INNER JOIN AB_HIBE_ADAY_BASVURU MHAB ON(MBS.BELGENO = MHAB.BELGE_NO)
				LEFT JOIN AB_HIBE_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				LEFT JOIN AB_HIBE_DEZAVANTAJ_ADAY ABDEZ ON(MBS.BELGENO = ABDEZ.BELGE_NO)
				LEFT JOIN AB_HIBE_ADAY_BASVURU ABBAS ON(MBS.BELGENO = ABBAS.BELGE_NO)
				LEFT JOIN AB_HIBE_ADAY_IBAN ABIBAN ON(MBS.BELGENO = ABIBAN.BELGE_NO)
				WHERE MAT.ISTEK_ID = ? 
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC
				";
	
		$tesvikAday = $db->prep_exec($sql, array($tId));
		
		$birimUcretiHesabi = array();
		foreach ($tesvikAday as $row){
			$birimUcretiHesabi[$row['BELGENO']] = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'],$row['YETERLILIK_ID'], $row['SINAV_TARIHI'],$row['KURULUS_ID']);
		}
		
		return array('AdayBilgi'=>$tesvikAday, 'UcretBilgi'=>$birimUcretiHesabi);
	}
	
	function TesvikAdaylarEditWithTarih($user_id, $IstekId,$bitTarih){
		$db = JFactory::getOracleDBO ();
		$tesvikAday = array();
	
		$sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET, ABDEZ.DOKUMAN AS DEZAV  
				FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				LEFT JOIN AB_HIBE_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				LEFT JOIN AB_HIBE_DEZAVANTAJ_ADAY ABDEZ ON(MBS.BELGENO = ABDEZ.BELGE_NO)
				WHERE MBS.ABHIBE = 1 AND MBS.KURULUS_ID = ?
				AND MBS.BELGENO NOT IN (SELECT BELGE_NO FROM AB_HIBE_KURULUS_ADAY)
				AND MBS.BELGE_DUZENLEME_TARIHI <= TO_DATE(?)
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC
				";
	
		$tesvikAday = $db->prep_exec($sql, array($user_id,$bitTarih));
	
		$sql = "SELECT MBS.*, MY.*, MBO.*, MTI.DURUM AS ITIRAZ_DURUM, MTI.ITIRAZ_UCRET, ABDEZ.DOKUMAN AS DEZAV 
				FROM M_BELGE_SORGU MBS
				INNER JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
				INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON(MBS.TCKIMLIKNO = MBO.TC_KIMLIK)
				INNER JOIN AB_HIBE_KURULUS_ADAY MTA ON(MBS.BELGENO = MTA.BELGE_NO)
				LEFT JOIN AB_HIBE_ITIRAZ MTI ON(MBS.BELGENO = MTI.BELGENO)
				LEFT JOIN AB_HIBE_DEZAVANTAJ_ADAY ABDEZ ON(MBS.BELGENO = ABDEZ.BELGE_NO)
				WHERE MTA.ISTEK_ID = ? AND MBS.KURULUS_ID = ?
				AND (MTI.DURUM IS NULL OR MTI.DURUM = 1 OR MTI.DURUM = -1)
				ORDER BY ADI ASC, SOYADI ASC";
	
		$tAday = $db->prep_exec($sql, array($IstekId,$user_id));
	
		foreach ($tAday as $row){
			$tesvikAday[] = $row;
		}

		$birimUcretiHesabi = array();
		foreach ($tesvikAday as $row){
			$birimUcretiHesabi[$row['BELGENO']] = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($row['TCKIMLIKNO'],$row['YETERLILIK_ID'], $row['SINAV_TARIHI'], $row['KURULUS_ID']);
			/* Tesvik tarihinden sonraki ilk sınav tarihi */
// 			$ilkSinav = FormABHibeUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'],$row['YETERLILIK_ID']);
// 			$YetUcretiHesabi[$row['BELGENO']] = $this->YeterlilikUcretHesabi($row['YETERLILIK_ID'], $ilkSinav);
// 			if($row['BELGE_MASRAF']){
// 				$sqlMasraf = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_BASLANGICI <= TO_DATE(?) ORDER BY TARIFE_BASLANGICI DESC";
// 				$masraf = $db->prep_exec($sqlMasraf, array($row['BELGE_DUZENLEME_TARIHI']));
// 				$BelgeMasraf[$row['BELGENO']] = $masraf[0]['BELGE_MASRAFI'];
// 			}else{
// 				$BelgeMasraf[$row['BELGENO']] = 0;
// 			}
		}
		
// 		return array('AdayBilgi'=>$tesvikAday, 'UcretBilgi'=>$birimUcretiHesabi, 'YetUcret'=>$YetUcretiHesabi,
// 				'BelgeMasraf'=>$BelgeMasraf
// 		);
		return array('AdayBilgi'=>$tesvikAday, 'UcretBilgi'=>$birimUcretiHesabi);
	}
	
	function TesvikPdfKaydet($post, $files, $user_id){
		$db = JFactory::getOracleDBO ();
		
		$IstekId = $post['IstekId'];
		$IstekPdf = $files['IstekPdf'];
		
		if(is_numeric($IstekId) && $IstekId > 0){
			if($IstekPdf['size'] > 0 && $IstekPdf['error']==0 && $IstekPdf['type'] == 'application/pdf'){
				$directory = EK_FOLDER."abhibe/adaypdfimzali/".$IstekId;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
					
				$normalFile = date('YmdHis').'.pdf';
				$path = $directory."/".$normalFile;
				if(move_uploaded_file($IstekPdf['tmp_name'], $path)){
					$sql = "UPDATE AB_HIBE_KURULUS_ISTEK SET AB_ADAY_DOSYA = ? WHERE ID = ?";
						
					if($db->prep_exec_insert($sql, array($normalFile,$IstekId))){
						return true;
					}else{
						return false;
					}
				}
				else{
					return false;
				}
			}
		}else{
			return false;
		}
	}
	
	function TesvikPdfSil($IstekId){
		$db = JFactory::getOracleDBO ();
		
		if(is_numeric($IstekId)){
			$sql = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
			$data = $db->prep_exec($sql, array($IstekId));
			
			if($data[0]['AB_ADAY_DOSYA'] != null){
				$sql = "UPDATE AB_HIBE_KURULUS_ISTEK SET AB_ADAY_DOSYA = NULL WHERE ID = ?";
				if($db->prep_exec_insert($sql, array($IstekId))){
					$directory = EK_FOLDER."abhibe/adaypdfimzali/".$IstekId."/".$data[0]['AB_ADAY_DOSYA'];
					unlink($directory);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function TesvikSil($IstekId){
		$db = JFactory::getOracleDBO ();
		
		if(is_numeric($IstekId)){
			$sql = "DELETE FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
			$sqlAdayDel = "DELETE FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ?";
				
			if($db->prep_exec_insert($sqlAdayDel, array($IstekId))){
				if($db->prep_exec_insert($sql, array($IstekId))){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function TesvikOnayaSun($IstekId,$user_id){
		$db = JFactory::getOracleDBO ();
		$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
		
		if(is_numeric($IstekId)){
			$IstekUcretleri = $this->IstekUcretleriWithIstekId($IstekId);
			
			$sql_istek_bilgi = "SELECT IMZA_ISIM,IMZA_UNVAN FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ? AND ROWNUM <2";
			$data = $db->prep_exec($sql_istek_bilgi, array($IstekId));
			if($data[0]['IMZA_ISIM'] == "" || $data[0]['IMZA_UNVAN'] == ""){
				$return['ERR'] = 1;
				$return['ERR_TEXT'] = "Ücret iadesi istek talebinde bulunurken İmza Yetkilisi Unvan veya İmza Yetkilisi Ad Soyad alanları boş bırakılamaz !";
			}else{
				$sql = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = 1, DOVIZ_KURU = ?, DOVIZ_TARIHI = ?, KDVLI = ?, KDVSIZ = ? WHERE ID = ?";
				
				if($db->prep_exec_insert($sql, array($this->UcretDuzenleTers($doviz['alis']),$doviz['tarih'],$this->UcretDuzenleTers($IstekUcretleri['kdvli']),$this->UcretDuzenleTers($IstekUcretleri['kdvsiz']),$IstekId))){
					// Ödemesi Yapılacak Adayların Ücretlerini Sisteme İşle
					$kayitDurum = $this->AdaylarinUcretiniSistemeIsle($IstekId);
					if(!$kayitDurum){
						$sql = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = 0, DOVIZ_KURU = NULL, DOVIZ_TARIHI = NULL, KDVLI = NULL, KDVSIZ = NULL WHERE ID = ?";
						$db->prep_exec_insert($sql, array($IstekId));
						$return['ERR'] = 1;
						$return['ERR_TEXT'] = "Teknik bir hata oluştu! Lütfen tekrar deneyin";
						return $return;
					}
					// Ödemesi Yapılacak Adayların Ücretlerini Sisteme İşle SON
					
					$kurulus = FormFactory::getKurulusGuncelBilgi($user_id);
					if(!$kurulus){
						$kurulus = FormFactory::getKurulusValues($user_id);
					}
				
					$body = '<div style="font-size:20px;">';
					$body .='<p>'.$kurulus['KURULUS_ADI'].' ücret iadesi talebinde bulundu. Ulaşmak için <a target="_blank" href="http://portal.myk.gov.tr/index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhine&layout=tesvik_istekleri">tıklayınız</a>.</p>';
					$body .= '</div>';
					FormFactory::sentEmail('Ücret İadesi Talebi', $body, array('htoplu@myk.gov.tr','ktunc@myk.gov.tr','hkorpe@myk.gov.tr'), true);
					$return['ERR'] = 0;
					$return['ERR_TEXT'] = "Başarılı";
				}else{
					$return['ERR'] = 1;
					$return['ERR_TEXT'] = "Teknik bir hata oluştu !";
				}
			}
		}else{
			$return['ERR'] = 1;
			$return['ERR_TEXT'] = "Teknik bir hata oluştu !";
		}
		return $return;
	}
	
	function TesvikDurumGuncelle($IstekId, $durum, $user_id){
		$db = JFactory::getOracleDBO ();
		
		if(is_numeric($IstekId)){
			$sql = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = ?, ONAY_USER = ? WHERE ID = ?";
		
			if($db->prep_exec_insert($sql, array($durum, $user_id, $IstekId))){
				if($durum == 2){
					$sqlAday = "SELECT * FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ?";
					$dataAday = $db->prep_exec($sqlAday, array($IstekId));
					foreach($dataAday as $row){
						$sqlUp = "UPDATE M_BELGE_SORGU SET ABHIBE = 2 WHERE BELGENO = ?";
						$db->prep_exec_insert($sqlUp, array($row['BELGE_NO']));
					}
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function OnayUserMi($user_id){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM AB_ONAY_KOMITESI WHERE USER_ID = ?";
		
		$data = $db->prep_exec($sql, array($user_id));
		if($data || $user_id == 40){
			return true;
		}else{
			return false;
		}
	}
	
	function TesvikYetkiliMi($user_id, $IstekId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ? AND USER_ID = ?";
		return $db->prep_exec($sql, array($IstekId, $user_id));
	}
	
	function adayBilgiKontrol($belgelist){
		$db = JFactory::getOracleDBO ();
		
		$datas = explode(",", $belgelist);
		$error = array();
		foreach($datas as $belgeno){
			$sql = "SELECT TCKIMLIKNO FROM M_BELGE_SORGU WHERE BELGENO = ?";
			
			$belge = $db->prep_exec($sql, array($belgeno));
			
			$tckimlik = current($belge);
			
			$sql2 = "SELECT TELEFON,IBAN FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK = ?";
			
			$ogrencidatas = $db->prep_exec($sql2, array($tckimlik['TCKIMLIKNO']));
			
			$ogrencidata = current($ogrencidatas);
	
			if($ogrencidata['TELEFON'] == ""){
				$error[$belgeno]['ERR'] = "1"; 
				$error[$belgeno]['ERR_TEXT'] = "Aday TELEFON bilgileri bulunmamaktadır.";
			}else if($ogrencidata['IBAN'] == ""){
				$error[$belgeno]['ERR'] = "2";
				$error[$belgeno]['ERR_TEXT'] = "Aday IBAN bilgileri bulunmamaktadır.";
			}else{
				$error[$belgeno]['ERR'] = "0";
				$error[$belgeno]['ERR_TEXT'] = "Aday bilgilerinde hata bulunamadı.";
			}
		}
		return $error;
	}
	function TesvikBilgi($istekid){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT CASE M_KURULUS_EDIT.KURULUS_ADI WHEN NULL THEN M_KURULUS.KURULUS_ADI 
					    ELSE M_KURULUS_EDIT.KURULUS_ADI END AS KURULUS_ADI,
						AB_HIBE_KURULUS_ISTEK.BIT_TARIH
				 FROM AB_HIBE_KURULUS_ISTEK 
		   INNER JOIN M_KURULUS ON M_KURULUS.USER_ID = AB_HIBE_KURULUS_ISTEK.USER_ID
		   INNER JOIN M_KURULUS_EDIT ON M_KURULUS_EDIT.USER_ID = AB_HIBE_KURULUS_ISTEK.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
				WHERE AB_HIBE_KURULUS_ISTEK.ID = ?";
		$data = $db->prep_exec($sql, array($istekid));
		
		return current($data);
	}
	
	function TestButunTarihlerUpdate(){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT MBS.* FROM M_BELGE_SORGU MBS 
				INNER JOIN AB_HIBE_KURULUS_ADAY MAT ON(MBS.BELGENO = MAT.BELGE_NO)";
		$data = $db->prep_exec($sql, array());
		
		$sqlUp = "UPDATE AB_HIBE_KURULUS_ADAY SET ILK_SINAV_TARIHI = TO_DATE(?) WHERE BELGE_NO = ?";
		foreach($data as $row){
			$ilkSinav = FormABHibeUcretHesabi::TesviktenSonrakiIlkSinavTarihi($row['TCKIMLIKNO'],$row['YETERLILIK_ID']);
			$db->prep_exec_insert($sqlUp, array($ilkSinav,$row['BELGENO']));
		}
		
	}
	
	public function UcretDuzenle($ucret){
		return str_replace(',', '.',$ucret);
	}
	public function UcretDuzenleTers($ucret){
		return str_replace('.',',',$ucret);
	}
	
	public function IstekUcretleriWithIstekId($istekId){
		$db = JFactory::getOracleDBO ();
		
		$sqlIstek = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
		$data = $db->prep_exec($sqlIstek, array($istekId));
		
		if($data){
			$dataIstek = $data[0];
		}else{
			return false;
		}
		
		$kurPro = FormABHibeUcretHesabi::KuruluABHibeProtokol($dataIstek['USER_ID']);
		$KurKdv = $this->UcretDuzenle(1+($kurPro['KDV']/100));
		$adays = $this->TesvikIstekAdaylar($istekId);
		$TopUcret = 0;
		$TopUcretKdvsiz = 0;
		foreach($adays as $cow){
			$Hesap = 0;
			$sqlItiraz = "SELECT * FROM AB_HIBE_ITIRAZ WHERE BELGENO = ?";
			$dataItiraz = $db->prep_exec($sqlItiraz, array($cow['BELGE_NO']));
		
			$birimUcreti = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($cow['TCKIMLIKNO'],$cow['YETERLILIK_ID'], $cow['SINAV_TARIHI'],$cow['KURULUS_ID']);
			if($dataItiraz && $dataItiraz[0]['DURUM'] == 1){
				$Hesap = $this->UcretDuzenle($dataItiraz[0]['ITIRAZ_UCRET']);
			}else{
				foreach ($birimUcreti as $tow){
					$Hesap += $tow['ucret'];
				}
			}
		
			if($dataIstek && $dataIstek['DOVIZ_KURU'] != null){
				$maxUcret = $this->UcretDuzenle(FormABHibeUcretHesabi::ABHibeMaxUcret())*$this->UcretDuzenle($dataIstek['DOVIZ_KURU']);
				$maxKDV = $this->UcretDuzenle(FormABHibeUcretHesabi::ABHibeMaxUcret())*$this->UcretDuzenle($dataIstek['DOVIZ_KURU'])*$this->UcretDuzenle($kurPro['KDV']/100);
			}else{
				$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
				$maxUcret = $this->UcretDuzenle(FormABHibeUcretHesabi::ABHibeMaxUcret())*$this->UcretDuzenle($doviz['alis']);
				$maxKDV = $this->UcretDuzenle(FormABHibeUcretHesabi::ABHibeMaxUcret())*$this->UcretDuzenle($doviz['alis'])*$this->UcretDuzenle($kurPro['KDV']/100);
			}
			$anaPara = $this->UcretDuzenle($Hesap/$KurKdv);
// 			$ParaKdv = $Hesap-$anaPara;
			if($anaPara > $this->UcretDuzenle($maxUcret)){
// 				$kdvli = $this->UcretDuzenle($maxUcret) + $ParaKdv;
				$kdvli = $this->UcretDuzenle($maxUcret) + $maxKDV;
				$kdvsiz = $this->UcretDuzenle($maxUcret);
			}else{
				$kdvli = $Hesap;
				$kdvsiz = $anaPara;
			}
		
			$TopUcret += $kdvli;
			$TopUcretKdvsiz += $kdvsiz;
		}
		return array('kdvli'=>$TopUcret, 'kdvsiz'=>$TopUcretKdvsiz);
	}
	
	function AdaylarinUcretiniSistemeIsle($istekId){
		$db = JFactory::getOracleDBO ();
		
		$sqlIstek = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
		$data = $db->prep_exec($sqlIstek, array($istekId));
		
		if($data){
			$dataIstek = $data[0];
		}else{
			return false;
		}
		
		$kurPro = FormABHibeUcretHesabi::KuruluABHibeProtokol($dataIstek['USER_ID']);
		$KurKdv = $this->UcretDuzenle(1+($kurPro['KDV']/100));
		$adays = $this->TesvikIstekAdaylar($istekId);
		$TopKDVli = 0;
		$TopKDVsiz = 0;
		$hata = 0;
		foreach($adays as $cow){
			$Hesap = 0;
			$sqlItiraz = "SELECT * FROM AB_HIBE_ITIRAZ WHERE BELGENO = ?";
			$dataItiraz = $db->prep_exec($sqlItiraz, array($cow['BELGE_NO']));
		
			$birimUcreti = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($cow['TCKIMLIKNO'],$cow['YETERLILIK_ID'], $cow['SINAV_TARIHI'],$cow['KURULUS_ID']);
			if($dataItiraz && $dataItiraz[0]['DURUM'] == 1){
				$Hesap = $this->UcretDuzenle($dataItiraz[0]['ITIRAZ_UCRET']);
			}else{
				foreach ($birimUcreti as $tow){
					$Hesap += $tow['ucret'];
				}
			}
		
			$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*$dataIstek['DOVIZ_KURU'];
			$maxKDV = $this->UcretDuzenle(FormABHibeUcretHesabi::ABHibeMaxUcret())*$this->UcretDuzenle($dataIstek['DOVIZ_KURU'])*$this->UcretDuzenle($kurPro['KDV']/100);
			$anaPara = $this->UcretDuzenle($Hesap/$KurKdv);
// 			$ParaKdv = $Hesap-$anaPara;
			
			if($anaPara > $this->UcretDuzenle($maxUcret)){
// 				$kdvli = $this->UcretDuzenle($maxUcret) + $ParaKdv;
				$kdvli = $this->UcretDuzenle($maxUcret) + $maxKDV;
				$kdvsiz = $this->UcretDuzenle($maxUcret);
			}else{
				$kdvli = $Hesap;
				$kdvsiz = $anaPara;
			}
			
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ADAY SET KDVLI = ?, KDVSIZ = ? WHERE BELGE_NO = ? AND ISTEK_ID = ?";
			$return = $db->prep_exec_insert($sqlUp, array($this->UcretDuzenleTers($kdvli),$this->UcretDuzenleTers($kdvsiz),$cow['BELGE_NO'],$istekId));
			if(!$return){
				$hata++;
			}
			
			$TopKDVli += $kdvli;
			$TopKDVsiz += $kdvsiz;
		}
		
		if($hata>0){
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ADAY SET KDVLI = NULL, KDVSIZ = NULL WHERE ISTEK_ID = ?";
			$db->prep_exec_insert($sqlUp, array($istekId));
			return false;
		}else{
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET KDVLI = ?, KDVSIZ = ? WHERE ID = ?";
			if($db->prep_exec_insert($sqlUp, array($this->UcretDuzenleTers($TopKDVli),$this->UcretDuzenleTers($TopKDVsiz),$istekId))){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function UcretFloor($dat){
		return floor($dat*100)/100;
	}
	
	public function getKurulusBilgi($kurulusId){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI, 
				M_KURULUS_EDIT.KURULUS_KISA_ADI AS KURULUS_KISA_ADI, M_KURULUS_EDIT.KURULUS_EPOSTA AS KURULUS_EPOSTA  
				FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI, KURULUS_KISA_ADI, KURULUS_EPOSTA FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
				  ORDER BY KURULUS_ADI ASC";
		$data = $db->prep_exec($sql, array($kurulusId,$kurulusId));
	
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function YoneticiHibeOnayla($post,$uId){
		$db = JFactory::getOracleDBO ();
		
		if($post['dId'] == 2){
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = ?, ONAY_USER = ? WHERE ID = ?";
			$data = $db->prep_exec_insert($sqlUp, array($post['dId'], $uId, $post['IstekId']), true);
			if($data){
				// Ödemesi Yapılacak Adayların Ücretlerini Sisteme İşle
				$kayitDurum = $this->AdaylarinUcretiniSistemeIsle($post['IstekId']);
				if(!$kayitDurum){
					$sql = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = 1, KDVLI = NULL, KDVSIZ = NULL WHERE ID = ?";
					$db->prep_exec_insert($sql, array($post['IstekId']));
					$return['ERR'] = 1;
					$return['ERR_TEXT'] = "Teknik bir hata oluştu! Lütfen tekrar deneyin";
					return $return;
				}else{
					return true;
				}
				// Ödemesi Yapılacak Adayların Ücretlerini Sisteme İşle SON
			}else{
				return false;
			}
		}else{
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = ?, ONAY_USER = ? WHERE ID = ?";
			return $db->prep_exec_insert($sqlUp, array($post['dId'], $uId, $post['IstekId']), true);
		}
	}
	
	public function SGBUcretKaydet($post,$files,$uId){
		$db = JFactory::getOracleDBO ();
		$file = $files['fileOdeme'];
		if($file['size'] > 0 && $file['error']==0 && $file['type'] == 'application/pdf'){
			$directory = EK_FOLDER."abhibe/odenen/".$post['IstekId'];
			if (!file_exists($directory)){
				mkdir($directory, 0700,true);
			}
				
			$normalFile = date('YmdHis').'.pdf';
			$path = $directory.'/'.$normalFile;
			if(!move_uploaded_file($file['tmp_name'], $path)){
				return false;
			}
			
			$sql = "SELECT BELGE_NO FROM AB_HIBE_KURULUS_ADAY WHERE ISTEK_ID = ?";
			$data = $db->prep_exec($sql, array($post['IstekId']));
			
			$sqlUp = "UPDATE M_BELGE_SORGU SET ABHIBE = 2 WHERE BELGENO = ?";
			foreach($data as $row){
				$db->prep_exec_insert($sqlUp, array($row['BELGE_NO']));
			}
			
			$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = 5, ODENEN = ?, BANKA_KURU = ?, ONAY_USER = ?, ODEME_DOSYASI = ?, ODEME_TARIHI = TO_DATE(?) WHERE ID = ?";
			$odenen = $this->UcretDuzenleTers($post['ucret']);
			$bankaKur = $this->UcretDuzenleTers($post['kur']);
			$onayUser = $uId;
			$IstekId = $post['IstekId'];
			$tarih = $post['Otarih'];
			$params = array($odenen,$bankaKur,$onayUser,$normalFile,$tarih,$IstekId);
			return $db->prep_exec_insert($sqlUp, $params, true);
		}else{
			return false;
		}		
	}
	
	public function GeriOdemeBilgi($IstekId){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
		$data = $db->prep_exec($sql, array($IstekId));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
public function AdayBasvuruFile($IstekId){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT ABHAB.* FROM AB_HIBE_KURULUS_ADAY ABHKA
				INNER JOIN AB_HIBE_ADAY_BASVURU ABHAB ON(ABHKA.BELGE_NO = ABHAB.BELGE_NO)
				INNER JOIN M_BELGE_SORGU MBS ON(ABHKA.BELGE_NO = MBS.BELGENO)
				WHERE ABHKA.ISTEK_ID = ? 
				ORDER BY MBS.AD ASC, MBS.SOYAD ASC";
		$data = $db->prep_exec($sql, array($IstekId));
	
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	public function AdayOdemeFile($IstekId){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT ABHKA.* FROM AB_HIBE_KURULUS_ADAY ABHKA
				INNER JOIN M_BELGE_SORGU MBS ON(ABHKA.BELGE_NO = MBS.BELGENO)
				WHERE ABHKA.ISTEK_ID = ? 
				ORDER BY MBS.AD ASC, MBS.SOYAD ASC";
		$data = $db->prep_exec($sql, array($IstekId));
	
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	public function ABHibeGeriGonder($post){
		$db = JFactory::getOracleDBO ();
		$IstekId = $post['IstekId'];
		$aciklama = $post['aciklama'];
		
		$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET DURUM = 0, ACIKLAMA = ? WHERE ID = ?";
		if($db->prep_exec_insert($sqlUp, array($aciklama,$IstekId))){
			$sql = "SELECT * FROM AB_HIBE_KURULUS_ISTEK WHERE ID = ?";
			$data = $db->prep_exec($sql, array($IstekId));
			$kurBilgi = $this->getKurulusBilgi($data[0]['USER_ID']);
			
			$baslik = $IstekId.' ID li AB Hibe Kapsamında Ücret İade Talebi Tarafınıza Geri Gönderildi';
			$aciklamaText = '<div style="text-align:center; width:100%; font-size:18px; font-weight:bold;">';
			$aciklamaText .= $baslik;
			$aciklamaText .= '</div><br><div style="width:100%; font-size:16px;">'.$aciklama.'</div>';
			$link = "index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe&layout=default";
			
			FormFactory::sektorSorumlusunaNotificationGonder($baslik, $link, $data[0]['USER_ID']);
			if($kurBilgi['KURULUS_EPOSTA'] != null){
				FormFactory::sentEmail($baslik,$aciklamaText,$kurBilgi['KURULUS_EPOSTA'],true);
			}
			
			return true;
		}else{
			return false;
		}
	}
	
	public function DurumToplamlari(){
		$db = JFactory::getOracleDBO ();
		$sql = "SELECT DURUM, COUNT(DURUM) AS SAY FROM AB_HIBE_KURULUS_ISTEK
				WHERE DURUM = 1 OR DURUM = 2 OR DURUM = 3 OR DURUM = 4 OR DURUM = 5 OR (DURUM = 0 AND ACIKLAMA IS NULL)
				GROUP BY DURUM
				ORDER BY DURUM";
		$data = $db->prep_exec($sql, array());
		$return = array();
		foreach($data as $row){
			$return[$row['DURUM']] = $row['SAY'];
		}
		return $return;
	}
	
	public function DovizKuruBelirle($IstekId){
		$db = JFactory::getOracleDBO ();
		$doviz = FormABHibeUcretHesabi::TariheGoreDovizKuru(date('d-m-Y',strtotime('-1 day')));
		
		$sqlUp = "UPDATE AB_HIBE_KURULUS_ISTEK SET DOVIZ_KURU = ?, DOVIZ_TARIHI = TO_DATE(?) WHERE ID = ?";
		return $db->prep_exec_insert($sqlUp, array($this->UcretDuzenleTers($doviz['alis']),$doviz['tarih'],$IstekId));
	}

    public function ATSorgu($post){
        $db = JFactory::getOracleDBO ();
        $sBas = $post['sBas'];
        $sBit = $post['sBit'];

        $sql = "SELECT AHKI.*, ABKP.VERGI_KIMLIK_NO FROM AB_HIBE_KURULUS_ISTEK AHKI
                INNER JOIN AB_KURULUS_PROTOKOL ABKP ON(AHKI.USER_ID = ABKP.KURULUS_ID)
                WHERE AHKI.FATURA_TARIH <= TO_DATE(?) AND AHKI.FATURA_TARIH >= TO_DATE(?) AND AHKI.DURUM = 5";
        $data = $db->prep_exec($sql, array($sBit,$sBas));

        if($data){
            foreach($data as $key=>$val){
                $kur = FormFactory::getKurulusBilgi($val['USER_ID']);
                $data[$key]['KURULUS_ADI'] = $kur['KURULUS_ADI'];
            }
            return $data;
        }else{
            return false;
        }
    }

    function AjaxGetFaturaBilgi($IstekId){
        $db = JFactory::getOracleDBO ();
        $sql = "SELECT * FROM AB_HIBE_KURULUS_ISTEK
                WHERE ID = ?";
        $data = $db->prep_exec($sql, array($IstekId));
        if($data){
            return $data[0];
        }else{
            return false;
        }
    }

    function AjaxGetAbHibeBelgeNo($bNo){
        $db = JFactory::getOracleDBO ();

        $return = array();
        $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR MBH
        		INNER JOIN M_BELGE_SORGU MBS ON MBH.BELGE_NO = MBS.BELGENO
                  WHERE MBH.BELGE_NO != ? AND MBH.TESVIK = 2
                   AND MBH.TC_KIMLIK = (SELECT TC_KIMLIK FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?)";
        $data = $db->prep_exec($sql,array($bNo,$bNo));
        if($data){
            $return['hata'] = true;
            $return['message'] = $bNo." Belge Numaralı aday daha önce AB Hibesinden yararlanmak için ".$data[0]['BELGE_NO']." belge numarası ile başvuru yaptığı için yeni başvuru yapamazsınız.";
            return $return;
        }

        $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR MBH
        		INNER JOIN M_BELGE_SORGU MBS ON MBH.BELGE_NO = MBS.BELGENO
                  WHERE MBH.BELGE_NO = ? AND MBH.TESVIK = 1";
        $data = $db->prep_exec($sql,array($bNo));
        if($data){
            $return['hata'] = true;
            $return['message'] = $bNo." Belge Numarası için daha önce Devlet Teşviğinden yararlanma başvurusu yapıldığı için yeni başvuru yapamazsınız.";
            return $return;
        }

        $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR MBH
        		INNER JOIN M_BELGE_SORGU MBS ON MBH.BELGE_NO = MBS.BELGENO
                  WHERE MBH.BELGE_NO = ? AND MBH.TESVIK = 2";
        $data = $db->prep_exec($sql,array($bNo));
        if($data){
            $return['hata'] = true;
            $return['message'] = $bNo." Belge Numarası için daha önce AB Hibesinden yararlanma başvurusu yapıldığı için yeni başvuru yapamazsınız.";
            return $return;
        }

        $sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM MBA
					INNER JOIN M_BELGELENDIRME_SINAV MBS ON(MBA.SINAV_ID = MBS.SINAV_ID)
					WHERE MBS.BASLANGIC_TARIHI > TO_DATE((SELECT PRO_TARIH FROM M_BELGELENDIRME_HAK_KAZANANLAR INNER JOIN AB_KURULUS_PROTOKOL USING(KURULUS_ID) WHERE BELGE_NO = ?))
					AND MBS.KURULUS_ID = (SELECT KURULUS_ID FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?)
					AND MBA.TC_KIMLIK = (SELECT TC_KIMLIK FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?)";
        $dat = $db->prep_exec($sql, array($bNo,$bNo,$bNo));

        if(!$dat){
            $return['hata'] = true;
            $return['message'] = $bNo." Belge Numarası için başarılı olduğu sınavlar Kuruluş Protokol Tarihinden önce olduğu için AB Hibesinden yararlanamaz.";
            return $return;
        }

        $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR MBHK
        		INNER JOIN M_BELGE_SORGU MBS ON MBHK.BELGE_NO = MBS.BELGENO
                  INNER JOIN M_BELGELENDIRME_OGRENCI MBO ON MBHK.TC_KIMLIK = MBO.TC_KIMLIK
                  WHERE MBHK.BELGE_NO = ?";
        $data = $db->prep_exec($sql,array($bNo));

        if($data){
            $birimUcretiHesabi = FormABHibeUcretHesabi::BasariliBirimUcretiHesabi($data[0]['TC_KIMLIK'],$data[0]['YETERLILIK_ID'], $data[0]['SINAV_TARIHI'],$data[0]['KURULUS_ID']);
            return array('hata' => false, 'AdayBilgi'=>$data[0], 'UcretBilgi'=>$birimUcretiHesabi);
        }else{
            return array('hata'=>true, 'message'=>'Böyle bir Belge Numarası henüz sistemde kayıtlı değildir.');
        }
    }

    public function ABHibeYoneticiAdayKaydet($post,$files){
        $db = JFactory::getOracleDBO ();
        $bNo = $post['bNo'];
        $tc = $post['tc'];
        $basIban = $post['basIban'];
        $basFile = $files['basForm'];
        $dezFile = $files['adayDez'];
        $itDurum = $post['itirazdurum'];
        $pathItiraz = '';
        $pathDez = '';
        $pathBas = '';
        $return = array();

        $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?";
        $data = $db->prep_exec($sql,array($bNo));

        // Ücret İtiraz Varsa Kadyet
        if($itDurum == 1){
            $itUcret = $this->UcretDuzenleTers($post['itiraz_ucret']);
            $itAc = $post['itiraz_aciklama'];
            $itFile = $files['itiraz_dosya'];

            $directoryHibe = EK_FOLDER.'sinavABHibeItiraz/'.$data[0]['SINAV_ID'];
            if (!file_exists($directoryHibe)){
                mkdir($directoryHibe, 0700,true);
            }

            $fileName = explode('.',$itFile['name']);
            $name = $tc.'.'.$fileName[count($fileName)-1];
            $pathHibe = $directoryHibe.'/'.$name;
            if(move_uploaded_file($itFile['tmp_name'], $pathHibe)) {
                $nextId = $db->getNextVal('SEQ_AB_HIBE_ITIRAZ');
                $sql_itiraz = "INSERT INTO AB_HIBE_ITIRAZ (ID,TC_KIMLIK,SINAV_ID,ITIRAZ_UCRET,ITIRAZ_ACIKLAMA,ITIRAZ_DOSYA,BELGENO,ITIRAZ_TARIHI)
								VALUES(?,?,?,?,?,?,?,TO_DATE(SYSDATE))";

                if(!$db->prep_exec_insert($sql_itiraz, array($nextId, $tc, $data[0]['SINAV_ID'], $itUcret, $itAc, $name, $bNo))){
                    $this->AbHibeAdayBilgiSil($bNo);
                    $return['hata'] = true;
                    $return['message'] = "Ücret Düzeltme Talebinde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.";
                    return $return;
                }
            }else{
                $this->AbHibeAdayBilgiSil($bNo);
                $return['hata'] = true;
                $return['message'] = "Ücret Düzeltme Talebinde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.";
                return $return;
            }
        }

        //Dezavantaj Bilgisi Varsa Ekle
        if($dezFile['size'] > 0){

            if($dezFile['error'] == 0 && $dezFile['type'] == "application/pdf")
            {
                $directory = EK_FOLDER."abhibe/dezavantaj/".$data[0]['SINAV_ID'];
                if (!file_exists($directory)){
                    mkdir($directory, 0700,true);
                }

                $fileName = explode('.',$dezFile['name']);
                $name = $tc.date('YmdHis').'.'.$fileName[count($fileName)-1];
                $path = $directory.'/'.$name;
                if(!move_uploaded_file($dezFile['tmp_name'], $path)){
                    $this->AbHibeAdayBilgiSil($bNo);
                    $return['hata'] = true;
                    $return['message'] = 'Aday Dezavantaj dosyası yükleme işleminde hata meydana geldi. Lütfen dosya formatını kontrol ederek tekrar deneyiniz. (.png, .jpeg, .rar, .zip, .pdf)';
                    return $return;
                }
            }else{
                $this->AbHibeAdayBilgiSil($bNo);
                $return['hata'] = true;
                $return['message'] = 'Aday Dezavantaj dosyası yükleme işleminde hata meydana geldi. Lütfen dosya formatını kontrol ederek tekrar deneyiniz. (.png, .jpeg, .rar, .zip, .pdf)';
                return $return;
            }

            $nextId = $db->getNextVal('SEQ_AB_HIBE_DEZ');
            $sql = "INSERT INTO AB_HIBE_DEZAVANTAJ_ADAY (ID,TC_KIMLIK,SINAV_ID,DOKUMAN,BELGE_NO,TARIH)
				VALUES(?,?,?,?,?,SYSDATE)";

            $param = array($nextId, $tc, $data[0]['SINAV_ID'], $name, $bNo);

            if(!$db->prep_exec_insert($sql, $param)){
                $this->AbHibeAdayBilgiSil($bNo);
                $return['hata'] = true;
                $return['message'] = 'Aday Dezavantaj dosyası yükleme işleminde hata meydana geldi. Lütfen tekrar deneyin.';
                return $return;
            }
        }

        // Aday Basvuru Formu Kaydet
        if($basFile['error'] == 0 && $basFile['type'] == "application/pdf")
        {
            $directory = EK_FOLDER."abhibe/basvuru/".$data[0]['SINAV_ID'];
            if (!file_exists($directory)){
                mkdir($directory, 0700,true);
            }

            $fileName = explode('.',$basFile['name']);
            $name = $tc.date('YmdHis').'.'.$fileName[count($fileName)-1];
            $nameIlk = "ilk".$tc.date('YmdHis').'.'.$fileName[count($fileName)-1];
            $path = $directory.'/'.$nameIlk;
            $pathSon = $directory.'/'.$name;
            if(!move_uploaded_file($basFile['tmp_name'], $path)){
                $this->AbHibeAdayBilgiSil($bNo);
                $return['hata'] = true;
                $return['message'] = 'Aday Başvuru dosyası yükleme işleminde hata meydana geldi. Lütfen dosya formatını kontrol ederek tekrar deneyiniz. (.pdf)';
                return $return;
            }else{
                $cmd = '"C:\\Program Files (x86)\\PDFtk Server\\bin\\pdftk.exe" '.$path.' output '.$pathSon;
                shell_exec($cmd);
            }
        }else{
            $this->AbHibeAdayBilgiSil($bNo);
            $return['hata'] = true;
            $return['message'] = 'Aday Başvuru dosyası yükleme işleminde hata meydana geldi. Lütfen dosya formatını kontrol ederek tekrar deneyiniz. (.pdf)';
            return $return;
        }

        $nextId = $db->getNextVal('SEQ_AB_HIBE_ADAY_BASVURU');
        $sql = "INSERT INTO AB_HIBE_ADAY_BASVURU (ID,TC_KIMLIK,SINAV_ID,DOKUMAN,BELGE_NO,TARIH)
				VALUES(?,?,?,?,?,SYSDATE)";

        $param = array($nextId, $tc, $data[0]['SINAV_ID'], $name, $bNo);

        if(!$db->prep_exec_insert($sql, $param)){
            $this->AbHibeAdayBilgiSil($bNo);
            $return['hata'] = true;
            $return['message'] = 'Aday Başvuru dosyası yükleme işleminde hata meydana geldi. Lütfen tekrar deneyin.';
            return $return;
        }

        // Basvuru Iban Kayıt
        $sqlIban = "INSERT INTO AB_HIBE_ADAY_IBAN (TC_KIMLIK,BELGE_NO,IBAN,TARIH) VALUES(?,?,?,SYSDATE)";
        if(!$db->prep_exec_insert($sqlIban, array($tc,$bNo,trim(str_replace(' ', '',$basIban))))){
            $this->AbHibeAdayBilgiSil($bNo);
            $return['hata'] = true;
            $return['message'] = 'Aday Başvuru IBAN Bilgileri yükleme işleminde hata meydana geldi. Lütfen tekrar deneyin.';
            return $return;
        }

        // Durumunu Hibeden yararlanacak yap
        $sqlUp = "UPDATE M_BELGELENDIRME_HAK_KAZANANLAR SET TESVIK = 2 WHERE BELGE_NO = ? AND TC_KIMLIK = ?";
        if(!$db->prep_exec_insert($sqlUp,array($bNo,$tc))){
            $this->AbHibeAdayBilgiSil($bNo);
            $return['hata'] = true;
            $return['message'] = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
            return $return;
        }
        // Durumunu Hibeden yararlanacak yap
        $sqlUp = "UPDATE M_BELGE_SORGU SET ABHIBE = 1 WHERE BELGENO = ? AND TCKIMLIKNO = ?";
        if(!$db->prep_exec_insert($sqlUp,array($bNo,$tc))){
            $this->AbHibeAdayBilgiSil($bNo);
            $return['hata'] = true;
            $return['message'] = 'Bir hata meydana geldi. Lütfen tekrar deneyin.';
            return $return;
        }

        $return['hata'] = false;
        $return['message'] = "Aday AB Hibesinden yararlanmak için başarıyla sisteme kaydedildi. Artık kuruluş istek yapabilir.";
        return $return;
    }

    private function AbHibeAdayBilgiSil($bNo){
        $db = JFactory::getOracleDBO ();

        $sql = "DELETE FROM AB_HIBE_ITIRAZ WHERE BELGENO = ?";
        $db->prep_exec($sql, array($bNo));

        $sql = "DELETE FROM AB_HIBE_DEZAVANTAJ_ADAY WHERE BELGE_NO = ?";
        $db->prep_exec($sql, array($bNo));

        $sql = "DELETE FROM AB_HIBE_ADAY_BASVURU WHERE BELGE_NO = ?";
        $db->prep_exec($sql, array($bNo));

        $sql = "DELETE FROM AB_HIBE_ADAY_IBAN WHERE BELGE_NO = ?";
        $db->prep_exec($sql, array($bNo));

        $sqlUp = "UPDATE M_BELGELENDIRME_HAK_KAZANANLAR SET TESVIK = 0 WHERE BELGE_NO = ?";
        $db->prep_exec_insert($sqlUp,array($bNo));

        $sqlUp = "UPDATE M_BELGE_SORGU SET ABHIBE = 0 WHERE BELGENO = ?";
        $db->prep_exec_insert($sqlUp,array($bNo));

        return true;
    }
}
?>