<?php
defined('_JEXEC') or die('Restricted access');

class Uzman_BasvurModelUzman_Basvurulari extends JModel {
	
	
	function getBasvurular ($db,$basvurudurum){
		$sql = "SELECT  *
		FROM M_UZMAN_HAVUZU
		WHERE basvuru_durum=$basvurudurum
		ORDER BY ID ASC, AD ASC, SOYAD ASC";
			
		return $db->prep_exec($sql, array());
		
	}
	function uzmanlardanAra()
	{
		$db = JFactory::getOracleDBO();
		
		$tckConstraint = ($_POST['tck_no']=='') ? '' : " AND TC_KIMLIK='".$_POST['tck_no']."'" ;
		$adConstraint = iconv("UTF-8", "ISO-8859-1//TRANSLIT", ($_POST['ad']=='') ? '' : " AND UPPER(AD) LIKE UPPER('%".$_POST['ad']."%')") ;
		$soyadConstraint = iconv("UTF-8", "ISO-8859-1//TRANSLIT", ($_POST['soyad']=='') ? '' : " AND UPPER(SOYAD) LIKE UPPER('%".$_POST['soyad']."%')") ;
		
		if($_POST['onay_durumu']=='3'){
			if($_POST['basvuru_tipi'] == 0){
				$basvuruTip = " AND (DENETCI = 3 OR UZMAN = 3)";
			}else if($_POST['basvuru_tipi'] == 1){
				$basvuruTip = " AND DENETCI = 3";
			}else if($_POST['basvuru_tipi'] == 2){
				$basvuruTip = " AND UZMAN = 3";
			}else if($_POST['basvuru_tipi'] == 3){
				$basvuruTip = " AND MODARATOR = 3";
			}
		}else if($_POST['onay_durumu']=='2'){
			if($_POST['basvuru_tipi'] == 0){
				$basvuruTip = " AND (DENETCI = 2 OR UZMAN = 2)";
			}else if($_POST['basvuru_tipi'] == 1){
				$basvuruTip = " AND DENETCI = 2";
			}else if($_POST['basvuru_tipi'] == 2){
				$basvuruTip = " AND UZMAN = 2";
			}else if($_POST['basvuru_tipi'] == 3){
				$basvuruTip = " AND MODARATOR = 2";
			}
		}else if($_POST['onay_durumu']=='1'){
			if($_POST['basvuru_tipi'] == 0){
				$basvuruTip = " AND (DENETCI = 1 OR UZMAN = 1)";
			}else if($_POST['basvuru_tipi'] == 1){
				$basvuruTip = " AND DENETCI = 1";
			}else if($_POST['basvuru_tipi'] == 2){
				$basvuruTip = " AND UZMAN = 1";
			}else if($_POST['basvuru_tipi'] == 3){
				$basvuruTip = " AND MODARATOR = 1";
			}
		}else if($_POST['onay_durumu'] == '0'){
			if($_POST['basvuru_tipi'] == 0){
				$basvuruTip = " AND (DENETCI = 0 OR UZMAN = 0)";
			}else if($_POST['basvuru_tipi'] == 1){
				$basvuruTip = " AND DENETCI = 0";
			}else if($_POST['basvuru_tipi'] == 2){
				$basvuruTip = " AND UZMAN = 0";
			}else if($_POST['basvuru_tipi'] == 3){
				$basvuruTip = " AND MODARATOR = 0";
			}
		}else{ 
			$basvuruTip = ' ';
		}
		
		$sql = "SELECT DISTINCT 
				USER_ID,
				TC_KIMLIK,
				ONEK,
				AD,
				SOYAD,
				EPOSTA,
				DENETCI,
				UZMAN
				
				FROM M_UZMAN_HAVUZU
				
				WHERE (USER_ID IS NOT NULL)
				"
				.$tckConstraint
				.$adConstraint
				.$soyadConstraint
				.$basvuruTip
				."
				
				ORDER BY AD
		";
		$uzmanlar =  $db->prep_exec($sql, array());
		
		$result['UZMANLAR'] = $uzmanlar;
		
		ajax_success_response_with_array('Sorgu başarılı', $result);
	}
        
        function getSertifikaGetir($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "SELECT * FROM M_UZMAN_HAVUZU_SERTIFIKA WHERE SERTIFIKA_ID = ?";
            return $db->prep_exec($sql,array($post['serId']));
        }
        
        function SertifikaSil($post){
            $db = JFactory::getOracleDBO();
            
            $sqlP = "SELECT PATH FROM M_UZMAN_HAVUZU_SERTIFIKA WHERE SERTIFIKA_ID = ?";
            $belge = $db->prep_exec($sqlP,array($post['serId']));
            $path = $belge[0]['PATH'];
            
            $sql = "DELETE FROM M_UZMAN_HAVUZU_SERTIFIKA WHERE SERTIFIKA_ID = ?";
            $db->prep_exec($sql,array($post['serId']));
            
            $sildir=EK_FOLDER.$path;
            if(is_dir($sildir)){
                rrmdir($sildir);
            }
            else{
                unlink($sildir);
            }
            rmdir($sildir);
            
            return true;
        }
        
        function getEgitimGetir($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "SELECT * FROM M_UZMAN_HAVUZU_EGITIM WHERE EGITIM_ID = ?";
            return $db->prep_exec($sql,array($post['egitId']));
        }
        
        function getMykEgitimGetir($post){
        	$db = JFactory::getOracleDBO();
        
        	$sql = "SELECT * FROM M_UZMAN_HAVUZU_MYK_EGITIM WHERE EGITIM_ID = ?";
        	return $db->prep_exec($sql,array($post['egitId']));
        }
        
        function EgitimSil($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "DELETE FROM M_UZMAN_HAVUZU_EGITIM WHERE EGITIM_ID = ?";
            return $db->prep_exec($sql,array($post['egitId']));
        }
        
        function MykEgitimSil($post){
        	$db = JFactory::getOracleDBO();
        
        	$sql = "DELETE FROM M_UZMAN_HAVUZU_MYK_EGITIM WHERE EGITIM_ID = ?";
        	return $db->prep_exec($sql,array($post['egitId']));
        }
        
        function getDilGetir($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "SELECT * FROM M_UZMAN_HAVUZU_YABANCI_DIL WHERE DIL_ID = ?";
            return $db->prep_exec($sql,array($post['dilId']));
        }
        
        function DilSil($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "DELETE FROM M_UZMAN_HAVUZU_YABANCI_DIL WHERE DIL_ID = ?";
            return $db->prep_exec($sql,array($post['dilId']));
        }
        
        function getIsGetir($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "SELECT * FROM M_UZMAN_HAVUZU_DENEYIM WHERE DENEYIM_ID = ?";
            return $db->prep_exec($sql,array($post['isId']));
        }
        
        function IsSil($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "DELETE FROM M_UZMAN_HAVUZU_DENEYIM WHERE DENEYIM_ID = ?";
            return $db->prep_exec($sql,array($post['isId']));
        }
        
        function getMYKDeneyimGetir($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "SELECT * FROM M_UZMAN_HAVUZU_MYK_DENEYIM WHERE MYKDENEYIM_ID = ?";
            return $db->prep_exec($sql,array($post['mykdeneyimId']));
        }
        
        function MYKDeneyimSil($post){
            $db = JFactory::getOracleDBO();
            
            $sql = "DELETE FROM M_UZMAN_HAVUZU_MYK_DENEYIM WHERE MYKDENEYIM_ID = ?";
            return $db->prep_exec($sql,array($post['mykdeneyimId']));
        }
        
        function DenetciDeneyimKaydet($post){
        	$db = JFactory::getOracleDBO();
        	
        	$tcId = $post['tckimlik'];
        	$dId = $post['deneyimId'];
        	$dtTarih = $post['dtTarih'];
        	$dtTur = trim($post['dtTur']);
        	$dtGorKur = trim($post['dtGorKur']);
        	$dtDenKur = trim($post['dtDenKur']);
        	$dtSure = trim($post['dtSure']);
        	$dtAcik = trim($post['dtAcik']);
        	
        	if($dId == 0){
        		$dId = $db->getNextVal('SEQ_U_DENETCI_DENEYIM');;
        		$params = array(
        				$dId,
        				$tcId,
        				$dtTarih,
        				$dtTur,
        				$dtGorKur,
        				$dtDenKur,
        				$dtSure,
        				$dtAcik
        		);
        		
        		$sql = "INSERT INTO M_UZMAN_DENETCI_DENEYIM 
        				(DENEYIM_ID, UZMAN_ID, TARIH, DENETIM_TUR, GOR_KUR, DEN_KUR, GOR_SURE, ACIKLAMA) 
        				VALUES(?,?,?,?,?,?,?,?)";
        		
        		$return = $db->prep_exec_insert($sql, $params);
        		if($return){
        			$sqlSel = "SELECT * FROM M_UZMAN_DENETCI_DENEYIM WHERE DENEYIM_ID = ?";
        			$data = $db->prep_exec($sqlSel,array($dId));
        			if($data){
        				return array('durum'=>true,'deger'=>$data[0]);
        			}else{
        				return array('durum'=>false);
        			}
        		}else{
        			return array('durum'=>false);
        		}
        	}else{
        		$params = array(
        				$dtTarih,
        				$dtTur,
        				$dtGorKur,
        				$dtDenKur,
        				$dtSure,
        				$dtAcik,
        				$dId
        		);
        		
        		$sql = "UPDATE M_UZMAN_DENETCI_DENEYIM
        				SET TARIH = ?, DENETIM_TUR = ?, GOR_KUR = ?, DEN_KUR = ?, GOR_SURE = ?, ACIKLAMA = ?
        				WHERE DENEYIM_ID = ?
        				";
        		
        		$return = $db->prep_exec_insert($sql, $params);
        		if($return){
        			$sqlSel = "SELECT * FROM M_UZMAN_DENETCI_DENEYIM WHERE DENEYIM_ID = ?";
        			$data = $db->prep_exec($sqlSel,array($dId));
        			if($data){
        				return array('durum'=>true,'deger'=>$data[0]);
        			}else{
        				return array('durum'=>false);
        			}
        		}else{
        			return array('durum'=>false);
        		}
        	}
        }
        
        function TUzmanDeneyimKaydet($post){
        	$db = JFactory::getOracleDBO();
        	 
        	$tcId = $post['tckimlik'];
        	$dId = $post['deneyimId'];
        	$dtTarih = trim($post['dtTarih']);
        	$dtTur = trim($post['dtTur']);
        	$dtGorKur = trim($post['dtGorKur']);
        	$dtDenKur = trim($post['dtDenKur']);
        	$dtSure = trim($post['dtSure']);
        	$dtAcik = trim($post['dtAcik']);
        	 
        	if($dId == 0){
        		$dId = $db->getNextVal('SEQ_U_TEKNIK_DENEYIM');;
        		$params = array(
        				$dId,
        				$tcId,
        				$dtTarih,
        				$dtTur,
        				$dtGorKur,
        				$dtDenKur,
        				$dtSure,
        				$dtAcik
        		);
        
        		$sql = "INSERT INTO M_UZMAN_TEKNIK_DENEYIM
        				(DENEYIM_ID, UZMAN_ID, TARIH, DENETIM_TUR, GOR_KUR, DEN_KUR, GOR_SURE, ACIKLAMA)
        				VALUES(?,?,?,?,?,?,?,?)";
        
        		$return = $db->prep_exec_insert($sql, $params);
        		if($return){
        			$sqlSel = "SELECT * FROM M_UZMAN_TEKNIK_DENEYIM WHERE DENEYIM_ID = ?";
        			$data = $db->prep_exec($sqlSel,array($dId));
        			if($data){
        				return array('durum'=>true,'deger'=>$data[0]);
        			}else{
        				return array('durum'=>false);
        			}
        		}else{
        			return array('durum'=>false);
        		}
        	}else{

        		$params = array(
        				$dtTarih,
        				$dtTur,
        				$dtGorKur,
        				$dtDenKur,
        				$dtSure,
        				$dtAcik,
        				$dId
        		);
        		
        		$sql = "UPDATE M_UZMAN_TEKNIK_DENEYIM
        				SET TARIH = ?, DENETIM_TUR = ?, GOR_KUR = ?, DEN_KUR = ?, GOR_SURE = ?, ACIKLAMA = ?
        				WHERE DENEYIM_ID = ?
        				";
        		
        		$return = $db->prep_exec_insert($sql, $params);
        		if($return){
        			$sqlSel = "SELECT * FROM M_UZMAN_TEKNIK_DENEYIM WHERE DENEYIM_ID = ?";
        			$data = $db->prep_exec($sqlSel,array($dId));
        			if($data){
        				return array('durum'=>true,'deger'=>$data[0]);
        			}else{
        				return array('durum'=>false);
        			}
        		}else{
        			return array('durum'=>false);
        		}
        	}
        }
	
	function getAjaxYeterlilikWithSekorIdAndTc($post){
		$db = JFactory::getOracleDBO();
		$sqlEkle = "";
		
		$sekId = $post['sekId'];
		$tc = $post['tc'];
		
		$sqlTcYet = "SELECT YETERLILIK_ID FROM M_UZMAN_TEKNIK_YETERLILIK WHERE UZMAN_ID = ?";
		$dataTc = $db->prep_exec_array($sqlTcYet, array($tc));
		
		if($dataTc){
			$sqlEkle .= " AND YETERLILIK_ID NOT IN (".implode(',', $dataTc).")";
		}
		
		$sqlYet = "SELECT * FROM M_YETERLILIK WHERE SEKTOR_ID = ? AND YETERLILIK_DURUM_ID = 2 AND YETERLILIK_SUREC_DURUM_ID = 1";
		$sqlYet .= $sqlEkle;
		$sqlYet .= " ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC";
		
		$dataYet = $db->prep_exec($sqlYet, array($sekId));
		
		if($dataYet){
			return $dataYet;
		}else{
			return false;
		}
	}
	
	function DenetciDeneyimSil($post){
		$db = JFactory::getOracleDBO();
		
		$dId = $post['deneyimId'];
		
		$sqlDelete = "DELETE FROM M_UZMAN_DENETCI_DENEYIM WHERE DENEYIM_ID = ?";
		return $db->prep_exec_insert($sqlDelete, array($dId));
	}
	
	function DenetciDeneyimGetir($post){
		$db = JFactory::getOracleDBO();
		
		$dId = $post['deneyimId'];
		
		$sql = "SELECT * FROM M_UZMAN_DENETCI_DENEYIM WHERE DENEYIM_ID = ?";
		$data = $db->prep_exec($sql, array($dId));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function TUDeneyimSil($post){
		$db = JFactory::getOracleDBO();
	
		$dId = $post['deneyimId'];
	
		$sqlDelete = "DELETE FROM M_UZMAN_TEKNIK_DENEYIM WHERE DENEYIM_ID = ?";
		return $db->prep_exec_insert($sqlDelete, array($dId));
	}
	
	function TUDeneyimGetir($post){
		$db = JFactory::getOracleDBO();
	
		$dId = $post['deneyimId'];
	
		$sql = "SELECT * FROM M_UZMAN_TEKNIK_DENEYIM WHERE DENEYIM_ID = ?";
		$data = $db->prep_exec($sql, array($dId));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	function DenetciBelgeGecSil($post){
		$db = JFactory::getOracleDBO();
		
		$bId = $post['bId'];
		
		$sqlDelete = "DELETE FROM M_UZMAN_DENETCI_BELGE WHERE BELGE_ID = ?";
		return $db->prep_exec_insert($sqlDelete, array($bId));
	}
	
	function DenetciBelgeKanitSil($post){
		$db = JFactory::getOracleDBO();
		
		$kId = $post['kId'];
		
		$sqlDelete = "DELETE FROM M_UZMAN_DENETCI_KANIT_BELGESI WHERE BELGE_ID = ?";
		return $db->prep_exec_insert($sqlDelete, array($kId));
	}
	
	function TUYetSil($post){
		$db = JFactory::getOracleDBO();
	
		$tuYetId = $post['tuYetId'];
	
		$sqlDelete = "DELETE FROM M_UZMAN_TEKNIK_YETERLILIK WHERE TUYET_ID = ?";
		return $db->prep_exec_insert($sqlDelete, array($tuYetId));
	}
	
	function TUBelgeKanitSil($post){
		$db = JFactory::getOracleDBO();
	
		$kId = $post['kId'];
	
		$sqlDelete = "DELETE FROM M_UZMAN_TEKNIK_KANIT_BELGESI WHERE BELGE_ID = ?";
		return $db->prep_exec_insert($sqlDelete, array($kId));
	}
	
	function DenetciBelgeDurumKaydet($post){
		$db = JFactory::getOracleDBO();
		$bId = $post['bId'];
		$durum = $post['durum'];
		
		$sqlUp = "UPDATE M_UZMAN_DENETCI_BELGE SET DURUM = ? WHERE BELGE_ID = ?";
		return $db->prep_exec_insert($sqlUp, array($durum,$bId));
	}
	
	function TUYetDurumKaydet($post){
		$db = JFactory::getOracleDBO();
		$tuYetId = $post['tuYetId'];
		$durum = $post['durum'];
		
		$sqlUp = "UPDATE M_UZMAN_TEKNIK_YETERLILIK SET DURUM = ? WHERE TUYET_ID = ?";
		return $db->prep_exec_insert($sqlUp, array($durum,$tuYetId));
	}
	
	function getTaslakYeterlilik ($yeterlilik_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *
			   FROM m_taslak_yeterlilik
			   WHERE yeterlilik_id = ?
			   ORDER BY yeterlilik_id";
		
		$lobCol = array (
				"DEGERLENDIRICI_OLCUT"
				);
		
		$params = array ($yeterlilik_id);
		
		for ($i = 0; $i < count($lobCol); $i++){
			$dataLob = $_db->prep_exec_clob($sql, $params, $lobCol[$i]);
			$data[$lobCol[$i]] = $dataLob;
		}
		
		$sql = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$dat = $_db->prep_exec($sql, array($yeterlilik_id));
		
		if (!empty($dat)){
			$dat[0]['DEGERLENDIRICI_OLCUT'] = $data['DEGERLENDIRICI_OLCUT'];
			return $dat[0];
		}
		else{
			return null;
		}
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
	
	function DenetciBasvurusuTamamla($post){
		$db = &JFactory::getOracleDBO();
		
		$tc = $post['tc'];
		$durum = $post['durum'];
		
		$sql = "UPDATE M_UZMAN_HAVUZU SET DENETCI = ? WHERE TC_KIMLIK = ?";
// 		$sql = "UPDATE M_UZMAN_HAVUZU SET UZMAN = ? WHERE TC_KIMLIK = ?";

		if($durum == 1){
			$sql = "UPDATE M_UZMAN_HAVUZU SET DENETCI = ?, BASVURU_DURUM = 1 WHERE TC_KIMLIK = ?";
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
			
			if($return){
				// DS'ye mail at, onay için
// 				FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['TGUSERID']);
				$uzman = $this->getUzmanValuesByTcKimlik($tc);
				$mailGorevli = array('ktunc@myk.gov.tr');
				$baslik = 'Denetçi Başvuru Onayı';
				$icerik = $uzman['AD'].' '.$uzman['SOYAD'].', Denetçi Başvurusunda bulundu. Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_uzman_basvur&view=uzman_basvur&layout=denetci&tc_kimlik='.$tc;
				$to = $mailGorevli;
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return array('durum'=>true,'message'=>'Denetçi Başvurusu Tamamlandı ve Dosya Sorumlusunun Onayına Sunuldu.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else if($durum == 2){
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
				
			if($return){
				// Yönetici'ye mail at, onay için
				$uzman = $this->getUzmanValuesByTcKimlik($tc);
				$mailGorevli = array('ktunc@myk.gov.tr');
				$baslik = 'Denetçi Başvurusu Yönetici Onayı';
				$icerik = $uzman['AD'].' '.$uzman['SOYAD'].', Denetçi Başvurusunda bulundu. Yönetici Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_uzman_basvur&view=uzman_basvur&layout=denetci&tc_kimlik='.$tc;
				$to = $mailGorevli;
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return array('durum'=>true,'message'=>'Denetçi Başvurusu Onaylandı ve Yönetici Onayına Sunuldu.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else if($durum == 3){
			$sql = "UPDATE M_UZMAN_HAVUZU SET DENETCI = ?, BASVURU_DURUM = 2 WHERE TC_KIMLIK = ?";
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
			
			if($return){
				// Uzmana, reddedildiği hakkında mail at
				return array('durum'=>true,'message'=>'Denetçi Başvurusu Onaylandı.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else if($durum == 0){
			$sql = "UPDATE M_UZMAN_HAVUZU SET DENETCI = ?, BASVURU_DURUM = 0 WHERE TC_KIMLIK = ?";
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
				
			if($return){
				// Uzmana, reddedildiği hakkında mail at
				$uzman = $this->getUzmanValuesByTcKimlik($tc);
				$mailGorevli = array($uzman['EPOSTA']);
				$baslik = 'MYK Denetçi Başvurusunuz Reddedildi';
				$icerik = $uzman['AD'].' '.$uzman['SOYAD'].', Denetçi Başvurunuz reddedildi. MYK ile iletişime geçebilirsiniz.';
				$to = $mailGorevli;
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return array('durum'=>true,'message'=>'Denetçi Başvurusu Reddedildi.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else{
			return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
		}
		
	}
	
	function TeknikBasvurusuTamamla($post){
		$db = &JFactory::getOracleDBO();
	
		$tc = $post['tc'];
		$durum = $post['durum'];
	
		$sql = "UPDATE M_UZMAN_HAVUZU SET UZMAN = ? WHERE TC_KIMLIK = ?";
		// 		$sql = "UPDATE M_UZMAN_HAVUZU SET UZMAN = ? WHERE TC_KIMLIK = ?";
	
		if($durum == 1){
			$sql = "UPDATE M_UZMAN_HAVUZU SET UZMAN = ?, BASVURU_DURUM = 1 WHERE TC_KIMLIK = ?";
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
				
			if($return){
				// DS'ye mail at, onay için
				$uzman = $this->getUzmanValuesByTcKimlik($tc);
				$mailGorevli = array('ktunc@myk.gov.tr');
				$baslik = 'Teknik Uzman Başvuru Onayı';
				$icerik = $uzman['AD'].' '.$uzman['SOYAD'].', Teknik Uzman Başvurusunda bulundu. Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_uzman_basvur&view=uzman_basvur&layout=teknik_uzman&tc_kimlik='.$tc;
				$to = $mailGorevli;
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return array('durum'=>true,'message'=>'Tekniz Uzman Başvurusu Tamamlandı ve Dosya Sorumlusunun Onayına Sunuldu.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else if($durum == 2){
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
	
			if($return){
				// Yönetici'ye mail at, onay için
				$uzman = $this->getUzmanValuesByTcKimlik($tc);
				$mailGorevli = array('ktunc@myk.gov.tr');
				$baslik = 'Teknik Uzman Başvrusu Yönetici Onayı';
				$icerik = $uzman['AD'].' '.$uzman['SOYAD'].', Teknik Uzman Başvurusunda bulundu. Yönetici Onayınız bekleniyor. http://portal.myk.gov.tr/index.php?option=com_uzman_basvur&view=uzman_basvur&layout=teknik_uzman&tc_kimlik='.$tc;
				$to = $mailGorevli;
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return array('durum'=>true,'message'=>'Teknik Uzman Başvurusu Onaylandı ve Yönetici Onayına Sunuldu.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else if($durum == 3){
			$sql = "UPDATE M_UZMAN_HAVUZU SET UZMAN = ?, BASVURU_DURUM = 2 WHERE TC_KIMLIK = ?";
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
				
			if($return){
				// Uzmana, reddedildiği hakkında mail at
				return array('durum'=>true,'message'=>'Teknik Uzman Başvurusu Onaylandı.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else if($durum == 0){
			$sql = "UPDATE M_UZMAN_HAVUZU SET UZMAN = ?, BASVURU_DURUM = 0 WHERE TC_KIMLIK = ?";
			$return = $db->prep_exec_insert($sql, array($durum,$tc));
	
			if($return){
				// Uzmana, reddedildiği hakkında mail at
				$uzman = $this->getUzmanValuesByTcKimlik($tc);
				$mailGorevli = array($uzman['EPOSTA']);
				$baslik = 'MYK Teknik Uzman Başvurusunuz Reddedildi';
				$icerik = $uzman['AD'].' '.$uzman['SOYAD'].', Teknik Uzman Başvurunuz reddedildi. MYK ile iletişime geçebilirsiniz.';
				$to = $mailGorevli;
				FormFactory::sentEmail($baslik,$icerik,$to);
				
				return array('durum'=>true,'message'=>'Teknik Uzman Başvurusu Reddedildi.');
			}else{
				return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
			}
		}else{
			return array('durum'=>false,'message'=>'Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
		}
	
	}
	
	function BilgilendirmeOnayla($post){
		$db = &JFactory::getOracleDBO();
		
		$sql = "INSERT INTO M_UZMAN_BILGI_ONAY (UZMAN_ID,BILGI_ID,TARIH) VALUES(?,?,TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS'))";
		
		$return = $db->prep_exec_insert($sql, array($post['uId'],$post['bilgi']));
		return $return;
		
	}
	
	function TaahutSil($post){
		$db = &JFactory::getOracleDBO();
		
		$sql = "DELETE FROM M_UZMAN_TAAHUTNAME WHERE UZMAN_ID = ?";
		
		$return = $db->prep_exec_insert($sql, array($post['uId']));
		return $return;
	}
}
?>
